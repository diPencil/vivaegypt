"""Compare lang/en/translate.php keys with lang/ar/translate.php"""
import re
from pathlib import Path

def extract_keys(content: str) -> set[str]:
    # Match 'key' => at line start (simplified)
    return set(re.findall(r"^\s*'((?:\\'|[^'])*)'\s*=>", content, re.MULTILINE))

def main():
    root = Path(__file__).resolve().parents[1]
    en = (root / "lang/en/translate.php").read_text(encoding="utf-8")
    ar = (root / "lang/ar/translate.php").read_text(encoding="utf-8")
    ke, ka = extract_keys(en), extract_keys(ar)
    missing_ar = sorted(ke - ka)
    only_ar = sorted(ka - ke)
    print(f"EN: {len(ke)} AR: {len(ka)}")
    print(f"Keys in EN missing from AR: {len(missing_ar)}")
    for k in missing_ar[:120]:
        print(k)
    if len(missing_ar) > 120:
        print(f"... and {len(missing_ar) - 120} more")
    print(f"Keys only in AR: {len(only_ar)}")

if __name__ == "__main__":
    main()
