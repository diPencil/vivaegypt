Param(
    [switch]$AutoComposer
)

# تأكد من تشغيل السكربت بصلاحيات المسؤول
$IsAdmin = ([Security.Principal.WindowsPrincipal] [Security.Principal.WindowsIdentity]::GetCurrent()).IsInRole([Security.Principal.WindowsBuiltinRole]::Administrator)
if (-not $IsAdmin) {
    Write-Host "السكربت يحتاج صلاحيات مسؤول. افتح PowerShell كمسؤول ثم أعد تشغيل السكربت." -ForegroundColor Yellow
    exit 1
}

# تكوين المسارات (غيّرها إن لزم)
$xamppPath = "C:\xampp"
$projectPath = "d:\Development\Viva\websource\vivaegypttravel"
$dataPath = Join-Path $xamppPath "mysql\data"

Write-Host "XAMPP: $xamppPath"
Write-Host "Project: $projectPath"
Write-Host ""

# ابحث عن أي عملية تستمع على المنفذ 3306
try {
    $conn = Get-NetTCPConnection -LocalPort 3306 -ErrorAction Stop
} catch {
    $conn = $null
}
if ($conn) {
    $pid = $conn.OwningProcess
    try { $proc = Get-Process -Id $pid -ErrorAction Stop } catch { $proc = $null }
    if ($proc) {
        Write-Host "وجدت عملية على المنفذ 3306: PID $pid - $($proc.ProcessName)" -ForegroundColor Yellow
    } else {
        Write-Host "وجدت PID $pid على المنفذ 3306" -ForegroundColor Yellow
    }
    $answer = Read-Host "هل تريد محاولة إيقاف الخدمة المرتبطة بأمان (Stop-Service) قبل القتل؟ اكتب Y للموافقة"
    if ($answer -match '^[yY]') {
        $svc = Get-Service | Where-Object { $_.Name -match 'mysql|mariadb' -or $_.DisplayName -match 'mysql|mariadb' }
        if ($svc) {
            Write-Host "محاولة إيقاف الخدمة: $($svc.Name)"
            try {
                Stop-Service -Name $svc.Name -Force -ErrorAction Stop
                Write-Host "تم إيقاف الخدمة بنجاح." -ForegroundColor Green
            } catch {
                Write-Warning "فشل إيقاف الخدمة: $_"
                $kill = Read-Host "هل تريد قتل العملية بالقوة؟ اكتب Y للقتل"
                if ($kill -match '^[yY]') { Stop-Process -Id $pid -Force; Write-Host "أرسلت إشارة قتل للـ PID $pid" -ForegroundColor Yellow }
            }
        } else {
            $kill = Read-Host "لم أجد خدمة باسم MySQL/MariaDB، هل تريد قتل العملية PID $pid بالقوة؟ اكتب Y للقتل"
            if ($kill -match '^[yY]') { Stop-Process -Id $pid -Force; Write-Host "أرسلت إشارة قتل للـ PID $pid" -ForegroundColor Yellow }
        }
    } else {
        $kill = Read-Host "لم توافق على إيقاف الخدمة. هل تريد قتل PID $pid بالقوة الآن؟ اكتب Y للقتل"
        if ($kill -match '^[yY]') { Stop-Process -Id $pid -Force; Write-Host "أرسلت إشارة قتل للـ PID $pid" -ForegroundColor Yellow }
    }
} else {
    Write-Host "لا توجد عملية تستمع على المنفذ 3306 (باستخدام Get-NetTCPConnection)." -ForegroundColor Green
}

# عمل نسخة احتياطية لمجلد البيانات
if (-Not (Test-Path $dataPath)) {
    Write-Warning "لم أجد مجلد البيانات: $dataPath"
} else {
    $backupDir = Join-Path $xamppPath "mysql\backup_$(Get-Date -Format yyyyMMdd_HHmmss)"
    New-Item -Path $backupDir -ItemType Directory -Force | Out-Null
    Write-Host "عملت نسخة احتياطية لمجلد البيانات إلى: $backupDir"
    try {
        Copy-Item -Path (Join-Path $dataPath '*') -Destination $backupDir -Recurse -Force -ErrorAction Stop
        Write-Host "نسخ الملفات اكتمل." -ForegroundColor Green
    } catch { Write-Warning "خطأ أثناء النسخ: $_" }
    # نقل ملفات ib_logfile* إذا وجدت
    $ibFiles = Get-ChildItem -Path $dataPath -Filter 'ib_logfile*' -ErrorAction SilentlyContinue
    if ($ibFiles) {
        $moveAns = Read-Host "هل تريد نقل ملفات ib_logfile* للاصلاح (آمن عادةً)؟ اكتب Y للموافقة"
        if ($moveAns -match '^[yY]') {
            foreach ($f in $ibFiles) {
                Move-Item -Path $f.FullName -Destination $backupDir -Force
                Write-Host "نقلت: $($f.Name)"
            }
        } else { Write-Host "تخطيت نقل ib_logfile*" }
    } else {
        Write-Host "لا توجد ملفات ib_logfile* في $dataPath"
    }
}

# تشغيل Apache و MySQL عبر ملفات الدُفعة في XAMPP
$apacheBat = Join-Path $xamppPath 'apache_start.bat'
$mysqlBat = Join-Path $xamppPath 'mysql_start.bat'
if (Test-Path $apacheBat) {
    Write-Host "تشغيل Apache..."
    Start-Process -FilePath $apacheBat -WorkingDirectory $xamppPath
} else { Write-Warning "لم أجد apache_start.bat في $xamppPath" }
Start-Sleep -Seconds 2
if (Test-Path $mysqlBat) {
    Write-Host "تشغيل MySQL..."
    Start-Process -FilePath $mysqlBat -WorkingDirectory $xamppPath
} else { Write-Warning "لم أجد mysql_start.bat في $xamppPath" }

Start-Sleep -Seconds 6

# التحقق من المنافذ
Write-Host "`nالتحقق من المنافذ..."
$mysqlOk = Test-NetConnection -ComputerName '127.0.0.1' -Port 3306 -InformationLevel Quiet
$apacheOk = (Test-NetConnection -ComputerName '127.0.0.1' -Port 80 -InformationLevel Quiet) -or (Test-NetConnection -ComputerName '127.0.0.1' -Port 8080 -InformationLevel Quiet)
if ($mysqlOk) { Write-Host "MySQL يستمع على 3306 ✅" -ForegroundColor Green } else { Write-Warning "MySQL ليس على 3306 بعد" }
if ($apacheOk) { Write-Host "Apache يعمل على المنفذ 80/8080 ✅" -ForegroundColor Green } else { Write-Warning "Apache غير متصل على 80/8080" }

Write-Host "`nإذا نجح الخادمان، افتح XAMPP Control Panel لتأكيد الحالة."

# إعداد المشروع بشكل اختياري
$runSetup = Read-Host "هل تريد أن أحاول تشغيل `composer install` و`php artisan key:generate` في المشروع؟ اكتب Y للموافقة"
if ($runSetup -match '^[yY]') {
    # تحديد php من XAMPP
    $phpExe = Join-Path $xamppPath 'php\php.exe'
    if (-not (Test-Path $phpExe)) {
        Write-Warning "لم أجد PHP في $phpExe — تأكد من XAMPP أو أن PHP في PATH"
    } else {
        Write-Host "تشغيل composer install باستخدام PHP من XAMPP..."
        Push-Location $projectPath
        # تشغَّل composer إن وُجد
        $composer = Get-Command composer -ErrorAction SilentlyContinue
        if ($composer) {
            & composer install
        } elseif (Test-Path (Join-Path $projectPath 'composer.phar')) {
            & $phpExe (Join-Path $projectPath 'composer.phar') install
        } else {
            Write-Warning "لم أجد composer في PATH أو composer.phar في المشروع — يمكنك تثبيته يدوياً"
        }
        # تشغيل artisan
        if (Test-Path (Join-Path $projectPath 'artisan')) {
            & $phpExe artisan key:generate
            Write-Host "تم تشغيل `php artisan key:generate`"
        } else { Write-Warning "لم أجد ملف `artisan` في المشروع" }
        Pop-Location
    }
}

Write-Host "`nانتهى السكربت. افحص XAMPP Control Panel والسجل لو فشل شيء." -ForegroundColor Cyan
