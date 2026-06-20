<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NewTripsItinerarySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Pricing text fixes for ID 38 and ID 40 (idempotent)
        $desc38 = DB::table('service_translations')->where('service_id', 38)->where('locale', 'en')->value('description');
        if ($desc38 && !str_contains($desc38, 'Single: $17')) {
            $newDesc38 = $desc38 . "<h3>Pricing Options</h3><ul><li>Single: $17</li><li>Double: $23</li><li>Triple: $29</li></ul>";
            DB::table('service_translations')
                ->where('service_id', 38)
                ->where('locale', 'en')
                ->update(['description' => $newDesc38]);
        }

        $desc40 = DB::table('service_translations')->where('service_id', 40)->where('locale', 'en')->value('description');
        if ($desc40) {
            $newDesc40 = str_replace([
                '2 Hours (Adult: $26, Child: $13)',
                'The 3 Hours variant is (Adult: $37, Child: $19)'
            ], [
                '2 Hours: Adult $23 / Child $12',
                '3 Hours: Adult $29 / Child $14'
            ], $desc40);
            if ($newDesc40 !== $desc40) {
                DB::table('service_translations')
                    ->where('service_id', 40)
                    ->where('locale', 'en')
                    ->update(['description' => $newDesc40]);
            }
        }

        // 2. Load day-by-day itineraries (with AR and EN translations)
        $itineraries = [
            43 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Hotel Pickup',
                        'description' => 'Comfortable round-trip transfer from anywhere in Sharm El Sheikh.',
                        'location' => 'Sharm El Sheikh',
                    ],
                    'ar' => [
                        'title' => 'الانتقال من الفندق',
                        'description' => 'انتقال مريح ذهابًا وإيابًا من أي مكان في شرم الشيخ.',
                        'location' => 'شرم الشيخ',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Dolphin Center Arrival',
                        'description' => 'Receive safety instructions and life jackets from professional trainers.',
                        'location' => 'Dolphinarium',
                    ],
                    'ar' => [
                        'title' => 'الوصول إلى مركز الدلافين',
                        'description' => 'تلقي تعليمات السلامة وسترات النجاة من مدربين محترفين.',
                        'location' => 'دولفيناريوم',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Dolphin Interaction',
                        'description' => 'Swim, hug, and play with dolphins in a controlled environment (15 or 30-minute session).',
                        'location' => 'Dolphin Pool',
                    ],
                    'ar' => [
                        'title' => 'التفاعل مع الدلافين',
                        'description' => 'السباحة والاحتضان واللعب مع الدلافين في بيئة خاضعة للإشراف (جلسة 15 أو 30 دقيقة).',
                        'location' => 'حوض الدلافين',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Photo Session',
                        'description' => 'Capture memorable photos with these intelligent marine mammals.',
                        'location' => 'Dolphinarium',
                    ],
                    'ar' => [
                        'title' => 'جلسة تصوير',
                        'description' => 'التقاط صور تذكارية مع هذه الثدييات البحرية الذكية.',
                        'location' => 'دولفيناريوم',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Hotel Drop-off',
                        'description' => 'Return to your hotel after this heartwarming experience.',
                        'location' => 'Sharm El Sheikh',
                    ],
                    'ar' => [
                        'title' => 'العودة إلى الفندق',
                        'description' => 'العودة إلى فندقك بعد هذه التجربة الممتعة.',
                        'location' => 'شرم الشيخ',
                    ],
                ],
            ],
            44 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Hotel Pickup',
                        'description' => 'Morning pick-up from Sharm El Sheikh hotel around 08:00 AM.',
                        'location' => 'Sharm El Sheikh',
                    ],
                    'ar' => [
                        'title' => 'الانتقال من الفندق',
                        'description' => 'الانتقال صباحًا من فندقك بشرم الشيخ حوالي الساعة 08:00 صباحًا.',
                        'location' => 'شرم الشيخ',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Port and Boarding',
                        'description' => 'Welcome aboard our spacious tour boat and meet the crew.',
                        'location' => 'Marina',
                    ],
                    'ar' => [
                        'title' => 'الوصول للميناء والصعود لليخت',
                        'description' => 'مرحبًا بك على متن قاربنا السياحي الواسع والتعرف على طاقم العمل.',
                        'location' => 'المارينا',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Snorkeling Stop 1',
                        'description' => 'Explore the first coral reef spot in Ras Mohamed National Park with an expert guide.',
                        'location' => 'Ras Mohamed',
                    ],
                    'ar' => [
                        'title' => 'وقفة السباحة الأولى',
                        'description' => 'استكشاف موقع الشعاب المرجانية الأول في محمية رأس محمد مع مرشد متخصص.',
                        'location' => 'رأس محمد',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Introductory Scuba Dive',
                        'description' => 'Experience a 10-minute introductory dive with full instructor guidance.',
                        'location' => 'Ras Mohamed Reef',
                    ],
                    'ar' => [
                        'title' => 'تجربة الغوص التقديمية',
                        'description' => 'خوض تجربة غوص تقديمي لمدة 10 دقائق بتوجيه كامل من المدرب.',
                        'location' => 'شعاب رأس محمد',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Buffet Lunch',
                        'description' => 'Enjoy a delicious open buffet lunch and soft drinks served on board.',
                        'location' => 'Tour Boat',
                    ],
                    'ar' => [
                        'title' => 'بوفيه الغداء',
                        'description' => 'الاستمتاع بغداء بوفيه مفتوح لذيذ ومشروبات غازية تقدم على متن اليخت.',
                        'location' => 'قارب الرحلة',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Snorkeling Stop 2',
                        'description' => 'Discover another vibrant coral reef filled with Red Sea marine life.',
                        'location' => 'Ras Mohamed',
                    ],
                    'ar' => [
                        'title' => 'وقفة السباحة الثانية',
                        'description' => 'اكتشاف موقع شعاب مرجانية نابض بالحياة ومليء بالكائنات البحرية للبحر الأحمر.',
                        'location' => 'رأس محمد',
                    ],
                ],
                [
                    'day_number' => 7,
                    'en' => [
                        'title' => 'White Island Stop',
                        'description' => 'Walk on the famous powdery white sand bar and swim in the lagoon.',
                        'location' => 'White Island',
                    ],
                    'ar' => [
                        'title' => 'وقفة الجزيرة البيضاء',
                        'description' => 'السير على الرمال البيضاء الناعمة للجزيرة الشهيرة والسباحة في البحيرة.',
                        'location' => 'الجزيرة البيضاء',
                    ],
                ],
                [
                    'day_number' => 8,
                    'en' => [
                        'title' => 'Return to Port',
                        'description' => 'Sail back to the marina and transfer back to your hotel by 17:00 PM.',
                        'location' => 'Sharm El Sheikh',
                    ],
                    'ar' => [
                        'title' => 'العودة إلى الميناء',
                        'description' => 'الإبحار عائدًا إلى المارينا والانتقال إلى فندقك بحلول الساعة 05:00 مساءً.',
                        'location' => 'شرم الشيخ',
                    ],
                ],
            ],
            45 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Hotel Pickup',
                        'description' => 'Afternoon pickup from Sharm El Sheikh hotel and transfer to safari station.',
                        'location' => 'Sharm El Sheikh',
                    ],
                    'ar' => [
                        'title' => 'الانتقال من الفندق',
                        'description' => 'الانتقال عصرًا من فندقك بشرم الشيخ والتوجة إلى محطة السفاري.',
                        'location' => 'شرم الشيخ',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'ATV Briefing & Safari',
                        'description' => 'Learn quad operations and embark on a thrilling 1-hour ATV safari.',
                        'location' => 'Sinai Desert',
                    ],
                    'ar' => [
                        'title' => 'تعليمات البيتش باجي وبدء الرحلة',
                        'description' => 'تعلم قيادة الدراجات الرباعية وبدء رحلة سفاري مثيرة لمدة ساعة.',
                        'location' => 'صحراء سيناء',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Echo Sound Point',
                        'description' => 'Stop for photos at the unique desert Echo Sound location.',
                        'location' => 'Echo Valley',
                    ],
                    'ar' => [
                        'title' => 'صدى الصوت في الصحراء',
                        'description' => 'التوقف لالتقاط الصور في منطقة صدى الصوت الفريدة بالصحراء.',
                        'location' => 'وادي صدى الصوت',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Bedouin Tent',
                        'description' => 'Relax and enjoy traditional Bedouin tea in an authentic tent.',
                        'location' => 'Bedouin Camp',
                    ],
                    'ar' => [
                        'title' => 'الخيمة البدوية',
                        'description' => 'الاسترخاء وتناول الشاي البدوي التقليدي في خيمة بدوية أصيلة.',
                        'location' => 'المخيم البدوي',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Camel Ride',
                        'description' => 'Experience a short 5-minute camel ride around the camp.',
                        'location' => 'Bedouin Camp',
                    ],
                    'ar' => [
                        'title' => 'ركوب الجمال',
                        'description' => 'تجربة ركوب الجمال لمدة 5 دقائق حول المخيم البدوي.',
                        'location' => 'المخيم البدوي',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Bedouin Dinner',
                        'description' => 'Enjoy a tasty dinner under the stars at the Bedouin camp.',
                        'location' => 'Bedouin Camp',
                    ],
                    'ar' => [
                        'title' => 'العشاء البدوي',
                        'description' => 'الاستمتاع بتناول عشاء بدوي لذيذ تحت النجوم في المخيم البدوي.',
                        'location' => 'المخيم البدوي',
                    ],
                ],
                [
                    'day_number' => 7,
                    'en' => [
                        'title' => 'Evening Show',
                        'description' => 'Watch exciting traditional dance and fire shows.',
                        'location' => 'Bedouin Camp',
                    ],
                    'ar' => [
                        'title' => 'الحفل البدوي والعروض',
                        'description' => 'مشاهدة العروض الاستعراضية البدوية والرقص وعروض النار المثيرة.',
                        'location' => 'المخيم البدوي',
                    ],
                ],
                [
                    'day_number' => 8,
                    'en' => [
                        'title' => 'Hotel Drop-off',
                        'description' => 'Return back to your hotel.',
                        'location' => 'Sharm El Sheikh',
                    ],
                    'ar' => [
                        'title' => 'العودة إلى الفندق',
                        'description' => 'العودة مرة أخرى إلى فندقك.',
                        'location' => 'شرم الشيخ',
                    ],
                ],
            ],
            46 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Midnight Pickup',
                        'description' => 'Midnight pick-up from Sharm El Sheikh hotel for an 8-hour bus journey to Cairo.',
                        'location' => 'Sharm El Sheikh',
                    ],
                    'ar' => [
                        'title' => 'الانتقال ليلًا',
                        'description' => 'التحرك في منتصف الليل من فندقك بشرم الشيخ لبدء الرحلة بالأتوبيس إلى القاهرة (حوالي 8 ساعات).',
                        'location' => 'شرم الشيخ',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Cairo Museum Visit',
                        'description' => 'Explore the treasures of King Tutankhamun and ancient Egypt at the Cairo National Museum in Tahrir Square.',
                        'location' => 'Cairo',
                    ],
                    'ar' => [
                        'title' => 'زيارة المتحف المصري',
                        'description' => 'استكشاف كنوز الملك توت عنخ آمون والآثار المصرية القديمة بالمتحف المصري بميدان التحرير.',
                        'location' => 'القاهرة',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Traditional Lunch',
                        'description' => 'Sit down for a delicious lunch featuring national Egyptian dishes.',
                        'location' => 'Cairo Restaurant',
                    ],
                    'ar' => [
                        'title' => 'تناول الغداء',
                        'description' => 'تناول غداء لذيذ يضم أطباقًا مصرية تقليدية.',
                        'location' => 'مطعم بالقاهرة',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Giza Plateau & Pyramids',
                        'description' => 'Guided overview of the majestic Great Pyramids of Giza.',
                        'location' => 'Giza Plateau',
                    ],
                    'ar' => [
                        'title' => 'أهرامات الجيزة',
                        'description' => 'جولة إرشادية حول أهرامات الجيزة العظيمة والتاريخ الفرعوني.',
                        'location' => 'هضبة الجيزة',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Great Sphinx',
                        'description' => 'Discover the mysteries of the Sphinx.',
                        'location' => 'Giza Plateau',
                    ],
                    'ar' => [
                        'title' => 'أبو الهول',
                        'description' => 'استكشاف تمثال أبو الهول الغامض ومعبد الوادي.',
                        'location' => 'هضبة الجيزة',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Papyrus and Oils Museum',
                        'description' => 'Learn about ancient papyrus paper making and essential oils.',
                        'location' => 'Cairo Bazaars',
                    ],
                    'ar' => [
                        'title' => 'معرض البردي والعطور',
                        'description' => 'التعرف على صناعة ورق البردي القديم واستخلاص الزيوت العطرية.',
                        'location' => 'بازارات القاهرة',
                    ],
                ],
                [
                    'day_number' => 7,
                    'en' => [
                        'title' => 'Return Bus Journey',
                        'description' => 'Travel back from Cairo to Sharm El Sheikh, arriving around 23:30 PM.',
                        'location' => 'Sharm El Sheikh',
                    ],
                    'ar' => [
                        'title' => 'العودة بالأتوبيس',
                        'description' => 'رحلة العودة بالأتوبيس من القاهرة إلى شرم الشيخ والوصول حوالي الساعة 11:30 مساءً.',
                        'location' => 'شرم الشيخ',
                    ],
                ],
            ],
            47 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Hotel Pickup',
                        'description' => 'Pick-up from Sharm El Sheikh hotel in a comfortable 4x4 vehicle.',
                        'location' => 'Sharm El Sheikh',
                    ],
                    'ar' => [
                        'title' => 'الانتقال من الفندق',
                        'description' => 'الانتقال من فندقك بشرم الشيخ في سيارة 4x4 مريحة.',
                        'location' => 'شرم الشيخ',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Scenic Desert Drive',
                        'description' => 'Travel through dramatic desert canyons and Sinai mountain landscapes.',
                        'location' => 'Sinai Desert',
                    ],
                    'ar' => [
                        'title' => 'طريق الصحراء الجبلي',
                        'description' => 'القيادة عبر الأخاديد الصحراوية والمناظر الجبلية الطبيعية لسيناء.',
                        'location' => 'صحراء سيناء',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Valley Hike',
                        'description' => 'Hike along the scenic trails of Wadi El Weshwash with an English-speaking guide.',
                        'location' => 'Wadi El Weshwash',
                    ],
                    'ar' => [
                        'title' => 'المشي في الوادي',
                        'description' => 'السير والمشي في مسارات وادي الوشواش الجميلة مع مرشد محلي.',
                        'location' => 'وادي الوشواش',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Wildlife Spotting',
                        'description' => 'Look for desert wildlife including gazelles, ibex, and foxes.',
                        'location' => 'Protected Area',
                    ],
                    'ar' => [
                        'title' => 'رصد الكائنات البرية',
                        'description' => 'البحث عن الحيوانات البرية الصحراوية بما في ذلك الغزلان والوعل والثعالب.',
                        'location' => 'المحمية الطبيعية',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Panoramic Viewpoint',
                        'description' => 'Admire the towering sandstone cliffs and Sinai mountains.',
                        'location' => 'Viewpoint',
                    ],
                    'ar' => [
                        'title' => 'موقع المشاهدة البانورامي',
                        'description' => 'تأمل المنحدرات الصخرية الشاهقة وجبال سيناء المحيطة.',
                        'location' => 'موقع المشاهدة',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Optional Activities',
                        'description' => 'Opportunity for short jeep/quad rides or camel encounters.',
                        'location' => 'Wadi Area',
                    ],
                    'ar' => [
                        'title' => 'أنشطة اختيارية',
                        'description' => 'فرصة لركوب الجمال أو دراجات البيتش باجي في منطقة الوادي.',
                        'location' => 'منطقة الوادي',
                    ],
                ],
                [
                    'day_number' => 7,
                    'en' => [
                        'title' => 'Return Transfer',
                        'description' => 'Drive back and drop-off at your hotel.',
                        'location' => 'Sharm El Sheikh',
                    ],
                    'ar' => [
                        'title' => 'العودة إلى الفندق',
                        'description' => 'التوجه عائدًا في السيارة والنزول في فندقك بشرم الشيخ.',
                        'location' => 'شرم الشيخ',
                    ],
                ],
            ],
            48 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Hotel Pickup',
                        'description' => 'Morning pickup from Sharm El Sheikh hotel around 08:00 AM.',
                        'location' => 'Sharm El Sheikh',
                    ],
                    'ar' => [
                        'title' => 'الانتقال من الفندق',
                        'description' => 'الانتقال صباحًا من فندقك بشرم الشيخ حوالي الساعة 08:00 صباحًا.',
                        'location' => 'شرم الشيخ',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Colored Canyon Hike',
                        'description' => 'Hike through the towering sandstone rock formations of the Colored Canyon.',
                        'location' => 'Colored Canyon',
                    ],
                    'ar' => [
                        'title' => 'المشي في الوادي الملون',
                        'description' => 'المشي واستكشاف التكوينات الصخرية الملونة الفريدة للوادي الملون.',
                        'location' => 'الوادي الملون',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Desert Quad Biking',
                        'description' => 'Exhilarating quad biking adventure through Sinai desert trails.',
                        'location' => 'Sinai Desert',
                    ],
                    'ar' => [
                        'title' => 'ركوب البيتش باجي بالصحراء',
                        'description' => 'مغامرة قيادة البيتش باجي الممتعة في دروب صحراء سيناء.',
                        'location' => 'صحراء سيناء',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Snorkeling near Blue Hole',
                        'description' => 'Snorkel in the crystal-clear waters near the world-famous Blue Hole.',
                        'location' => 'Blue Hole',
                    ],
                    'ar' => [
                        'title' => 'السباحة بجوار البلو هول',
                        'description' => 'السباحة واستكشاف الشعاب المرجانية في المياه الكريستالية قرب البلو هول الشهير.',
                        'location' => 'البلو هول',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Beach Camel Ride',
                        'description' => 'Enjoy a relaxing camel ride along the coastline.',
                        'location' => 'Dahab Beach',
                    ],
                    'ar' => [
                        'title' => 'ركوب الجمال على الشاطئ',
                        'description' => 'الاستمتاع بتجربة ركوب الجمال الهادئة على شاطئ البحر الأحمر.',
                        'location' => 'شاطئ دهب',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Seaside Lunch',
                        'description' => 'Delicious lunch served near the beach.',
                        'location' => 'Seaside Tent',
                    ],
                    'ar' => [
                        'title' => 'تناول الغداء على البحر',
                        'description' => 'تناول غداء شهي يقدم في خيمة بدوية على الشاطئ مباشرة.',
                        'location' => 'خيمة شاطئية',
                    ],
                ],
                [
                    'day_number' => 7,
                    'en' => [
                        'title' => 'Dahab Souks',
                        'description' => 'Free time to explore local souvenir shops, bazaars, and handicrafts in Dahab.',
                        'location' => 'Dahab',
                    ],
                    'ar' => [
                        'title' => 'بازارات دهب وقضاء وقت حر',
                        'description' => 'وقت حر للتسوق وشراء المشغولات اليدوية المحلية والتوابل والتحف في دهب.',
                        'location' => 'دهب',
                    ],
                ],
                [
                    'day_number' => 8,
                    'en' => [
                        'title' => 'Return Transfer',
                        'description' => 'Drive back to Sharm El Sheikh.',
                        'location' => 'Sharm El Sheikh',
                    ],
                    'ar' => [
                        'title' => 'العودة إلى الفندق',
                        'description' => 'رحلة العودة بالسيارة والنزول في فندقك بشرم الشيخ.',
                        'location' => 'شرم الشيخ',
                    ],
                ],
            ],
            49 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Hotel Pickup',
                        'description' => 'Convenient transfer from your hotel to the marina.',
                        'location' => 'Sharm El Sheikh',
                    ],
                    'ar' => [
                        'title' => 'الانتقال من الفندق',
                        'description' => 'التحرك من الفندق والانتقال بالسيارة إلى مارينا اليخوت.',
                        'location' => 'شرم الشيخ',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Glass-Bottom Boat Boarding',
                        'description' => 'Welcome aboard the comfortable observation cruise ship.',
                        'location' => 'Marina',
                    ],
                    'ar' => [
                        'title' => 'الصعود لليخت الزجاجي',
                        'description' => 'الترحيب بك على متن اليخت الزجاجي وبدء الاستعداد للإبحار.',
                        'location' => 'المارينا',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Coral Reef Cruise',
                        'description' => 'Sail to vibrant coral reef sites with depth panels up to 3 meters.',
                        'location' => 'Red Sea Reefs',
                    ],
                    'ar' => [
                        'title' => 'الإبحار نحو الشعاب المرجانية',
                        'description' => 'الإبحار نحو مواقع الشعاب المرجانية لمشاهدة الأعماق حتى 3 أمتار.',
                        'location' => 'شعاب البحر الأحمر',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Underwater Viewing',
                        'description' => 'Look through large panoramic glass panels to see exotic fish and coral gardens.',
                        'location' => 'Glass Bottom Boat',
                    ],
                    'ar' => [
                        'title' => 'رؤية الأعماق والأسماك',
                        'description' => 'مشاهدة الأسماك الملونة والشعاب المرجانية الرائعة من خلال النوافذ الزجاجية البانورامية الكبيرة.',
                        'location' => 'الغواصة الزجاجية',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Scenic Return',
                        'description' => 'Stroll the sundeck as the boat cruises back to the marina.',
                        'location' => 'Marina',
                    ],
                    'ar' => [
                        'title' => 'طريق العودة',
                        'description' => 'الاسترخاء على سطح القارب والاستمتاع بنسيم البحر في طريق العودة للميناء.',
                        'location' => 'المارينا',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Hotel Drop-off',
                        'description' => 'Return to your hotel.',
                        'location' => 'Sharm El Sheikh',
                    ],
                    'ar' => [
                        'title' => 'العودة إلى الفندق',
                        'description' => 'التوجه بالسيارة عائدًا والنزول في فندقك بشرم الشيخ.',
                        'location' => 'شرم الشيخ',
                    ],
                ],
            ],
            50 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Hotel Pickup',
                        'description' => 'Shared pick-up from Hurghada hotel and comfortable road travel to Luxor.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'الانتقال من الفندق',
                        'description' => 'الانتقال من فندقك بالغردقة والتحرك لبدء الرحلة إلى الأقصر.',
                        'location' => 'الغردقة',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Karnak Temple',
                        'description' => 'Explore the monumental columns and sanctuaries of the Karnak Temple Complex.',
                        'location' => 'Luxor',
                    ],
                    'ar' => [
                        'title' => 'معبد الكرنك',
                        'description' => 'استكشاف الأعمدة الضخمة وقدس الأقداس في مجمع معبد الكرنك التاريخي.',
                        'location' => 'الأقصر',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Local Lunch',
                        'description' => 'Rest and enjoy lunch at a local restaurant.',
                        'location' => 'Luxor',
                    ],
                    'ar' => [
                        'title' => 'تناول الغداء',
                        'description' => 'الاستراحة وتناول وجبة غداء لذيذة في مطعم محلي بالأقصر.',
                        'location' => 'الأقصر',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Valley of the Queens',
                        'description' => 'Discover the final resting place of royal queens and princesses.',
                        'location' => 'West Bank',
                    ],
                    'ar' => [
                        'title' => 'وادي الملكات',
                        'description' => 'اكتشاف المقابر التاريخية والمدفن الأخير لملكات وأميرات الفراعنة.',
                        'location' => 'البر الغربي',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Hatshepsut Temple',
                        'description' => 'Visit the stunning temple of Queen Hatshepsut built into the cliffs.',
                        'location' => 'West Bank',
                    ],
                    'ar' => [
                        'title' => 'معبد حتشبسوت',
                        'description' => 'زيارة المعبد الجنائزي الرائع للملكة حتشبسوت المنحوت في المنحدرات الصخرية.',
                        'location' => 'البر الغربي',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Colossi of Memnon',
                        'description' => 'Stop for photos at the towering ancient statues of Amenhotep III.',
                        'location' => 'West Bank',
                    ],
                    'ar' => [
                        'title' => 'تمثالا ممنون',
                        'description' => 'التوقف لالتقاط الصور أمام التمثالين العملاقين للملك أمنحتب الثالث.',
                        'location' => 'البر الغربي',
                    ],
                ],
                [
                    'day_number' => 7,
                    'en' => [
                        'title' => 'Return to Hurghada',
                        'description' => 'Comfortable bus transfer back to your hotel.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'العودة إلى الغردقة',
                        'description' => 'الانتقال بالأتوبيس والعودة مجددًا إلى فندقك بالغردقة.',
                        'location' => 'الغردقة',
                    ],
                ],
            ],
            51 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Private Pickup',
                        'description' => 'Morning pick-up from Hurghada hotel in a private Toyota HIACE minibus.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'انتقال خاص من الفندق',
                        'description' => 'الانتقال صباحًا من فندقك بالغردقة في سيارة تويوتا هايس خاصة ومريحة.',
                        'location' => 'الغردقة',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Karnak Temple',
                        'description' => 'Explore the monumental columns and sanctuaries of the Karnak Temple Complex.',
                        'location' => 'Luxor',
                    ],
                    'ar' => [
                        'title' => 'معبد الكرنك',
                        'description' => 'استكشاف الأعمدة الضخمة وقدس الأقداس في مجمع معبد الكرنك التاريخي.',
                        'location' => 'الأقصر',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Local Lunch',
                        'description' => 'Rest and enjoy lunch at a local restaurant.',
                        'location' => 'Luxor',
                    ],
                    'ar' => [
                        'title' => 'تناول الغداء',
                        'description' => 'الاستراحة وتناول وجبة غداء لذيذة في مطعم محلي بالأقصر.',
                        'location' => 'الأقصر',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Valley of the Queens',
                        'description' => 'Discover the final resting place of royal queens and princesses.',
                        'location' => 'West Bank',
                    ],
                    'ar' => [
                        'title' => 'وادي الملكات',
                        'description' => 'اكتشاف المقابر التاريخية والمدفن الأخير لملكات وأميرات الفراعنة.',
                        'location' => 'البر الغربي',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Hatshepsut Temple',
                        'description' => 'Visit the stunning temple of Queen Hatshepsut built into the cliffs.',
                        'location' => 'West Bank',
                    ],
                    'ar' => [
                        'title' => 'معبد حتشبسوت',
                        'description' => 'زيارة المعبد الجنائزي الرائع للملكة حتشبسوت المنحوت في المنحدرات الصخرية.',
                        'location' => 'البر الغربي',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Colossi of Memnon',
                        'description' => 'Stop for photos at the towering ancient statues of Amenhotep III.',
                        'location' => 'West Bank',
                    ],
                    'ar' => [
                        'title' => 'تمثالا ممنون',
                        'description' => 'التوقف لالتقاط الصور أمام التمثالين العملاقين للملك أمنحتب الثالث.',
                        'location' => 'البر الغربي',
                    ],
                ],
                [
                    'day_number' => 7,
                    'en' => [
                        'title' => 'Return to Hurghada',
                        'description' => 'Comfortable private transfer back to your hotel.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'العودة الخاصة للغردقة',
                        'description' => 'انتقال خاص مريح ومباشر والنزول في فندقك بالغردقة.',
                        'location' => 'الغردقة',
                    ],
                ],
            ],
            52 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Hotel Pickup',
                        'description' => 'Shared pick-up from Hurghada hotel and comfortable road travel to Luxor.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'الانتقال من الفندق',
                        'description' => 'الانتقال من فندقك بالغردقة والتحرك لبدء الرحلة إلى الأقصر.',
                        'location' => 'الغردقة',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Karnak Temple',
                        'description' => 'Explore the monumental columns and sanctuaries of the Karnak Temple Complex.',
                        'location' => 'Luxor',
                    ],
                    'ar' => [
                        'title' => 'معبد الكرنك',
                        'description' => 'استكشاف الأعمدة الضخمة وقدس الأقداس في مجمع معبد الكرنك التاريخي.',
                        'location' => 'الأقصر',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Local Lunch',
                        'description' => 'Rest and enjoy lunch at a local restaurant.',
                        'location' => 'Luxor',
                    ],
                    'ar' => [
                        'title' => 'تناول الغداء',
                        'description' => 'الاستراحة وتناول وجبة غداء لذيذة في مطعم محلي بالأقصر.',
                        'location' => 'الأقصر',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Valley of the Kings',
                        'description' => 'Discover the tombs of ancient pharaohs including Tutankhamun.',
                        'location' => 'West Bank',
                    ],
                    'ar' => [
                        'title' => 'وادي الملوك',
                        'description' => 'استكشاف مقابر ملوك الفراعنة الأثرياء ومنها مقبرة توت عنخ آمون.',
                        'location' => 'البر الغربي',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Hatshepsut Temple',
                        'description' => 'Visit the stunning temple of Queen Hatshepsut built into the cliffs.',
                        'location' => 'West Bank',
                    ],
                    'ar' => [
                        'title' => 'معبد حتشبسوت',
                        'description' => 'زيارة المعبد الجنائزي الرائع للملكة حتشبسوت المنحوت في المنحدرات الصخرية.',
                        'location' => 'البر الغربي',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Colossi of Memnon',
                        'description' => 'Stop for photos at the towering ancient statues of Amenhotep III.',
                        'location' => 'West Bank',
                    ],
                    'ar' => [
                        'title' => 'تمثالا ممنون',
                        'description' => 'التوقف لالتقاط الصور أمام التمثالين العملاقين للملك أمنحتب الثالث.',
                        'location' => 'البر الغربي',
                    ],
                ],
                [
                    'day_number' => 7,
                    'en' => [
                        'title' => 'Return to Hurghada',
                        'description' => 'Comfortable bus transfer back to your hotel.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'العودة إلى الغردقة',
                        'description' => 'الانتقال بالأتوبيس والعودة مجددًا إلى فندقك بالغردقة.',
                        'location' => 'الغردقة',
                    ],
                ],
            ],
            53 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Private Pickup',
                        'description' => 'Morning pick-up from Hurghada hotel in a private Toyota HIACE minibus.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'انتقال خاص من الفندق',
                        'description' => 'الانتقال صباحًا من فندقك بالغردقة في سيارة تويوتا هايس خاصة ومريحة.',
                        'location' => 'الغردقة',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Karnak Temple',
                        'description' => 'Explore the monumental columns and sanctuaries of the Karnak Temple Complex.',
                        'location' => 'Luxor',
                    ],
                    'ar' => [
                        'title' => 'معبد الكرنك',
                        'description' => 'استكشاف الأعمدة الضخمة وقدس الأقداس في مجمع معبد الكرنك التاريخي.',
                        'location' => 'الأقصر',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Local Lunch',
                        'description' => 'Rest and enjoy lunch at a local restaurant.',
                        'location' => 'Luxor',
                    ],
                    'ar' => [
                        'title' => 'تناول الغداء',
                        'description' => 'الاستراحة وتناول وجبة غداء لذيذة في مطعم محلي بالأقصر.',
                        'location' => 'الأقصر',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Valley of the Kings',
                        'description' => 'Discover the tombs of ancient pharaohs including Tutankhamun.',
                        'location' => 'West Bank',
                    ],
                    'ar' => [
                        'title' => 'وادي الملوك',
                        'description' => 'استكشاف مقابر ملوك الفراعنة الأثرياء ومنها مقبرة توت عنخ آمون.',
                        'location' => 'البر الغربي',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Hatshepsut Temple',
                        'description' => 'Visit the stunning temple of Queen Hatshepsut built into the cliffs.',
                        'location' => 'West Bank',
                    ],
                    'ar' => [
                        'title' => 'معبد حتشبسوت',
                        'description' => 'زيارة المعبد الجنائزي الرائع للملكة حتشبسوت المنحوت في المنحدرات الصخرية.',
                        'location' => 'البر الغربي',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Colossi of Memnon',
                        'description' => 'Stop for photos at the towering ancient statues of Amenhotep III.',
                        'location' => 'West Bank',
                    ],
                    'ar' => [
                        'title' => 'تمثالا ممنون',
                        'description' => 'التوقف لالتقاط الصور أمام التمثالين العملاقين للملك أمنحتب الثالث.',
                        'location' => 'البر الغربي',
                    ],
                ],
                [
                    'day_number' => 7,
                    'en' => [
                        'title' => 'Return to Hurghada',
                        'description' => 'Comfortable private transfer back to your hotel.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'العودة الخاصة للغردقة',
                        'description' => 'انتقال خاص مريح ومباشر والنزول في فندقك بالغردقة.',
                        'location' => 'الغردقة',
                    ],
                ],
            ],
            54 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Hotel Pickup',
                        'description' => 'Shared morning pickup from Hurghada hotel and bus travel to Cairo.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'الانتقال من الفندق',
                        'description' => 'الانتقال صباحًا من فندقك بالغردقة والتحرك لبدء الرحلة بالأتوبيس إلى القاهرة.',
                        'location' => 'الغردقة',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Egyptian Museum',
                        'description' => 'Tour the historical halls and see King Tutankhamun\'s gold mask.',
                        'location' => 'Cairo',
                    ],
                    'ar' => [
                        'title' => 'زيارة المتحف المصري',
                        'description' => 'زيارة قاعات المتحف المصري بالتحرير ومشاهدة قناع الملك توت عنخ آمون الذهبي الكنوز.',
                        'location' => 'القاهرة',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Local Lunch',
                        'description' => 'Relaxing lunch at a restaurant.',
                        'location' => 'Cairo',
                    ],
                    'ar' => [
                        'title' => 'تناول الغداء',
                        'description' => 'تناول وجبة غداء لذيذة في مطعم محلي بالقاهرة.',
                        'location' => 'القاهرة',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Pyramids of Giza',
                        'description' => 'Admire the Great Pyramids of Giza.',
                        'location' => 'Giza Plateau',
                    ],
                    'ar' => [
                        'title' => 'زيارة أهرامات الجيزة',
                        'description' => 'الوقوف أمام أهرامات الجيزة العظيمة (خوفو وخفرع ومنقرع) والتقاط صور مذهلة.',
                        'location' => 'هضبة الجيزة',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Great Sphinx',
                        'description' => 'Get up close with the mysterious Sphinx.',
                        'location' => 'Giza Plateau',
                    ],
                    'ar' => [
                        'title' => 'تمثال أبو الهول',
                        'description' => 'رؤية تمثال أبو الهول العظيم ومعبد الوادي عن قرب والتعرف على أسرار بناء الأهرامات.',
                        'location' => 'هضبة الجيزة',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Papyrus and Oils',
                        'description' => 'Visit local perfume and papyrus workshops.',
                        'location' => 'Cairo Bazaars',
                    ],
                    'ar' => [
                        'title' => 'صناعة البردي والعطور',
                        'description' => 'زيارة المعارض البازارية للتعرف على صناعة ورق البردي القديم والعطور العطرية.',
                        'location' => 'بازارات القاهرة',
                    ],
                ],
                [
                    'day_number' => 7,
                    'en' => [
                        'title' => 'Return to Hurghada',
                        'description' => 'Travel back by bus to Hurghada.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'العودة إلى الغردقة',
                        'description' => 'العودة بالأتوبيس مجددًا إلى الغردقة والنزول في فندقك.',
                        'location' => 'الغردقة',
                    ],
                ],
            ],
            55 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Private Pickup',
                        'description' => 'Private pickup from Hurghada hotel in a Toyota HIACE minibus.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'انتقال خاص من الفندق',
                        'description' => 'الانتقال صباحًا من فندقك بالغردقة في سيارة تويوتا هايس خاصة ومباشرة.',
                        'location' => 'الغردقة',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Egyptian Museum',
                        'description' => 'Tour the historical halls and see King Tutankhamun\'s gold mask.',
                        'location' => 'Cairo',
                    ],
                    'ar' => [
                        'title' => 'زيارة المتحف المصري',
                        'description' => 'زيارة قاعات المتحف المصري بالتحرير ومشاهدة قناع الملك توت عنخ آمون الذهبي الكنوز.',
                        'location' => 'القاهرة',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Local Lunch',
                        'description' => 'Relaxing lunch at a restaurant.',
                        'location' => 'Cairo',
                    ],
                    'ar' => [
                        'title' => 'تناول الغداء',
                        'description' => 'تناول وجبة غداء لذيذة في مطعم محلي بالقاهرة.',
                        'location' => 'القاهرة',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Pyramids of Giza',
                        'description' => 'Admire the Great Pyramids of Giza.',
                        'location' => 'Giza Plateau',
                    ],
                    'ar' => [
                        'title' => 'زيارة أهرامات الجيزة',
                        'description' => 'الوقوف أمام أهرامات الجيزة العظيمة (خوفو وخفرع ومنقرع) والتقاط صور مذهلة.',
                        'location' => 'هضبة الجيزة',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Great Sphinx',
                        'description' => 'Get up close with the mysterious Sphinx.',
                        'location' => 'Giza Plateau',
                    ],
                    'ar' => [
                        'title' => 'تمثال أبو الهول',
                        'description' => 'رؤية تمثال أبو الهول العظيم ومعبد الوادي عن قرب والتعرف على أسرار بناء الأهرامات.',
                        'location' => 'هضبة الجيزة',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Papyrus and Oils',
                        'description' => 'Visit local perfume and papyrus workshops.',
                        'location' => 'Cairo Bazaars',
                    ],
                    'ar' => [
                        'title' => 'صناعة البردي والعطور',
                        'description' => 'زيارة المعارض البازارية للتعرف على صناعة ورق البردي القديم والعطور العطرية.',
                        'location' => 'بازارات القاهرة',
                    ],
                ],
                [
                    'day_number' => 7,
                    'en' => [
                        'title' => 'Return to Hurghada',
                        'description' => 'Travel back by private minibus to Hurghada.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'العودة الخاصة للغردقة',
                        'description' => 'رحلة العودة الخاصة بالسيارة المباشرة والوصول لفندقك بالغردقة.',
                        'location' => 'الغردقة',
                    ],
                ],
            ],
            56 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Hotel Pickup',
                        'description' => 'Shared morning pickup from Hurghada hotel and bus travel to Cairo.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'الانتقال من الفندق',
                        'description' => 'الانتقال صباحًا من فندقك بالغردقة والتحرك لبدء الرحلة بالأتوبيس إلى القاهرة.',
                        'location' => 'الغردقة',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Grand Egyptian Museum',
                        'description' => 'Visit the state-of-the-art GEM and view Tutankhamun\'s treasures.',
                        'location' => 'Cairo',
                    ],
                    'ar' => [
                        'title' => 'زيارة المتحف الكبير (GEM)',
                        'description' => 'استكشاف صالات المتحف المصري الكبير الحديث للغاية ومشاهدة كنوز الملك الشاب توت عنخ آمون.',
                        'location' => 'القاهرة',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Local Lunch',
                        'description' => 'Relaxing lunch at a restaurant.',
                        'location' => 'Cairo',
                    ],
                    'ar' => [
                        'title' => 'تناول الغداء',
                        'description' => 'تناول وجبة غداء متميزة في مطعم بالقاهرة.',
                        'location' => 'القاهرة',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Giza Plateau',
                        'description' => 'Admire the Giza Pyramids from a panoramic viewpoint.',
                        'location' => 'Giza Plateau',
                    ],
                    'ar' => [
                        'title' => 'بانوراما الأهرامات',
                        'description' => 'الاستمتاع بمشاهدة أهرامات الجيزة العظيمة مجتمعة من موقع المشاهدة البانورامي الممتاز.',
                        'location' => 'هضبة الجيزة',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Great Sphinx',
                        'description' => 'Explore the Sphinx and Valley Temple.',
                        'location' => 'Giza Plateau',
                    ],
                    'ar' => [
                        'title' => 'تمثال أبو الهول',
                        'description' => 'استكشاف تمثال أبو الهول العظيم ومعبد الوادي والتعرف على الآثار المحيطة.',
                        'location' => 'هضبة الجيزة',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Return to Hurghada',
                        'description' => 'Travel back by bus to Hurghada.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'العودة إلى الغردقة',
                        'description' => 'رحلة العودة بالأتوبيس مجددًا إلى الغردقة والنزول في فندقك.',
                        'location' => 'الغردقة',
                    ],
                ],
            ],
            57 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Private Pickup',
                        'description' => 'Private pickup from Hurghada hotel in a Toyota HIACE minibus.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'انتقال خاص من الفندق',
                        'description' => 'الانتقال صباحًا من فندقك بالغردقة في سيارة تويوتا هايس خاصة ومريحة.',
                        'location' => 'الغردقة',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Grand Egyptian Museum',
                        'description' => 'Visit the state-of-the-art GEM and view Tutankhamun\'s treasures.',
                        'location' => 'Cairo',
                    ],
                    'ar' => [
                        'title' => 'زيارة المتحف الكبير (GEM)',
                        'description' => 'استكشاف صالات المتحف المصري الكبير الحديث للغاية ومشاهدة كنوز الملك الشاب توت عنخ آمون.',
                        'location' => 'القاهرة',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Local Lunch',
                        'description' => 'Relaxing lunch at a restaurant.',
                        'location' => 'Cairo',
                    ],
                    'ar' => [
                        'title' => 'تناول الغداء',
                        'description' => 'تناول وجبة غداء متميزة في مطعم بالقاهرة.',
                        'location' => 'القاهرة',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Giza Plateau',
                        'description' => 'Admire the Giza Pyramids from a panoramic viewpoint.',
                        'location' => 'Giza Plateau',
                    ],
                    'ar' => [
                        'title' => 'بانوراما الأهرامات',
                        'description' => 'الاستمتاع بمشاهدة أهرامات الجيزة العظيمة مجتمعة من موقع المشاهدة البانورامي الممتاز.',
                        'location' => 'هضبة الجيزة',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Great Sphinx',
                        'description' => 'Explore the Sphinx and Valley Temple.',
                        'location' => 'Giza Plateau',
                    ],
                    'ar' => [
                        'title' => 'تمثال أبو الهول',
                        'description' => 'استكشاف تمثال أبو الهول العظيم ومعبد الوادي والتعرف على الآثار المحيطة.',
                        'location' => 'هضبة الجيزة',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Return to Hurghada',
                        'description' => 'Travel back by private minibus to Hurghada.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'العودة الخاصة للغردقة',
                        'description' => 'رحلة العودة الخاصة بالسيارة المباشرة والوصول لفندقك بالغردقة.',
                        'location' => 'الغردقة',
                    ],
                ],
            ],
            58 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Hotel Pickup',
                        'description' => 'Pickup from your hotel in Hurghada and transfer to city center.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'الانتقال من الفندق',
                        'description' => 'الانتقال من فندقك بالغردقة والتحرك لبدء الجولة في معالم المدينة.',
                        'location' => 'الغردقة',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'El Mina Mosque',
                        'description' => 'Guided visit to Hurghada\'s largest and most famous mosque.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'مسجد الميناء',
                        'description' => 'زيارة مع مرشد لمسجد الميناء الكبير، وهو الأكبر والأجمل في الغردقة.',
                        'location' => 'الغردقة',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Coptic Cathedral',
                        'description' => 'Visit the beautiful Coptic Cathedral of Saint Shenouda.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'كاتدرائية الأقباط',
                        'description' => 'زيارة كاتدرائية القديس شنودة للأقباط الأرثوذكس والتعرف على تصميمها الفريد.',
                        'location' => 'الغردقة',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'El Dahar Old Town',
                        'description' => 'Explore traditional streets, markets, and bazaars.',
                        'location' => 'El Dahar',
                    ],
                    'ar' => [
                        'title' => 'البلد القديم (الدهار)',
                        'description' => 'استكشاف شوارع وأسواق الدهار القديمة والبازارات الشعبية وتجربة الحياة المحلية.',
                        'location' => 'الدهار',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Hurghada Fish Market',
                        'description' => 'Experience the lively local fish market.',
                        'location' => 'Fish Market',
                    ],
                    'ar' => [
                        'title' => 'سوق السمك',
                        'description' => 'زيارة سوق السمك النابض بالحياة ورؤية أنواع الأسماك الطازجة من البحر الأحمر.',
                        'location' => 'سوق السمك',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Hurghada Marina',
                        'description' => 'Stroll along the yacht marina overlooking the Red Sea.',
                        'location' => 'Hurghada Marina',
                    ],
                    'ar' => [
                        'title' => 'مارينا الغردقة',
                        'description' => 'التنزه على شاطئ مارينا اليخوت الحديثة والاستمتاع بالمقاهي والمناظر الجميلة للبحر.',
                        'location' => 'مارينا الغردقة',
                    ],
                ],
                [
                    'day_number' => 7,
                    'en' => [
                        'title' => 'Hotel Drop-off',
                        'description' => 'Return to your hotel.',
                        'location' => 'Hurghada',
                    ],
                    'ar' => [
                        'title' => 'العودة إلى الفندق',
                        'description' => 'التوصيل والعودة مجددًا إلى فندقك بالمدينة.',
                        'location' => 'الغردقة',
                    ],
                ],
            ],
            59 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Hotel Pickup',
                        'description' => 'Pickup from Marsa Alam hotel in a 4WD Toyota Land Cruiser around 14:00 PM.',
                        'location' => 'Marsa Alam',
                    ],
                    'ar' => [
                        'title' => 'الانتقال من الفندق',
                        'description' => 'التحرك بالسيارة الـ 4x4 من فندقك بمرسى علم للتوجه للصحراء حوالي الساعة 02:00 ظهرًا.',
                        'location' => 'مرسى علم',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Akkasia Tree Stop',
                        'description' => 'Learn about desert flora and Eastern Desert life from your guide.',
                        'location' => 'Marsa Alam Desert',
                    ],
                    'ar' => [
                        'title' => 'شجرة الأكاسيا الصحراوية',
                        'description' => 'التوقف بجانب شجرة الأكاسيا الشهيرة وسماع شرح المرشد لطبائع الصحراء الشرقية.',
                        'location' => 'صحراء مرسى علم',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Bedouin Village Arrival',
                        'description' => 'Welcome tea and tour of the traditional village.',
                        'location' => 'Bedouin Village',
                    ],
                    'ar' => [
                        'title' => 'الوصول للمخيم البدوي',
                        'description' => 'الترحيب بك في الخيمة البدوية وتناول شاي الضيافة البدوي اللذيذ.',
                        'location' => 'القرية البدوية',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Desert Quad Biking',
                        'description' => 'Thrilling quad bike ride through scenic desert valleys.',
                        'location' => 'Bedouin Village',
                    ],
                    'ar' => [
                        'title' => 'قيادة البيتش باجي بالصحراء',
                        'description' => 'خوض جولة ممتعة بالبيتش باجي وسط الوديان والمنحدرات الرملية.',
                        'location' => 'القرية البدوية',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Camel Ride',
                        'description' => 'Enjoy a peaceful camel ride across the sands.',
                        'location' => 'Bedouin Village',
                    ],
                    'ar' => [
                        'title' => 'ركوب الجمال البدوية',
                        'description' => 'تجربة ركوب الجمال التقليدية حول القرية واستشعار حياة البداوة.',
                        'location' => 'القرية البدوية',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Desert Sunset',
                        'description' => 'Hike to a viewpoint to watch the sunset over the mountains.',
                        'location' => 'Viewpoint',
                    ],
                    'ar' => [
                        'title' => 'غروب الشمس في الصحراء',
                        'description' => 'الصعود لأعلى التل لمشاهدة المنظر الرائع لغروب الشمس وسط جبال البحر الأحمر.',
                        'location' => 'موقع المشاهدة',
                    ],
                ],
                [
                    'day_number' => 7,
                    'en' => [
                        'title' => 'BBQ Dinner & Show',
                        'description' => 'Open buffet BBQ dinner followed by traditional music and dancing.',
                        'location' => 'Bedouin Camp',
                    ],
                    'ar' => [
                        'title' => 'عشاء باربكيو وحفل بدوي',
                        'description' => 'تناول عشاء بوفيه مفتوح لذيذ مع اللحم المشوي، ثم الاستمتاع بفقرات الرقص الشرقي والتنورة.',
                        'location' => 'المخيم البدوي',
                    ],
                ],
                [
                    'day_number' => 8,
                    'en' => [
                        'title' => 'Stargazing',
                        'description' => 'View the clear desert night sky before return transfer.',
                        'location' => 'Marsa Alam',
                    ],
                    'ar' => [
                        'title' => 'مشاهدة النجوم والعودة',
                        'description' => 'تأمل السماء الصافية والنجوم من التلسكوب قبل التحرك بالسيارة للعودة إلى فندقك.',
                        'location' => 'مرسى علم',
                    ],
                ],
            ],
            60 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Hotel Pickup',
                        'description' => 'Early morning pickup from Marsa Alam hotel in a 4WD Toyota Land Cruiser.',
                        'location' => 'Marsa Alam',
                    ],
                    'ar' => [
                        'title' => 'الانتقال من الفندق',
                        'description' => 'التحرك مبكرًا بالسيارة الـ 4x4 من فندقك بمرسى علم لبدء مغامرة الصباح.',
                        'location' => 'مرسى علم',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Camel Yard Arrival',
                        'description' => 'Welcome tea and introductory briefing.',
                        'location' => 'Camel Yard',
                    ],
                    'ar' => [
                        'title' => 'الوصول لساحة الجمال',
                        'description' => 'الوصول للـ Camel Yard وتناول مشروب الضيافة وتلقي تعليمات السلامة.',
                        'location' => 'ساحة الجمال',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Desert Quad Biking',
                        'description' => 'Enjoy 30 minutes of guided quad biking.',
                        'location' => 'Camel Yard Trails',
                    ],
                    'ar' => [
                        'title' => 'جولة البيتش باجي',
                        'description' => 'قيادة البيتش باجي لمدة 30 دقيقة عبر الدروب والوديان الصحراوية.',
                        'location' => 'دروب ساحة الجمال',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Jeep Safari',
                        'description' => 'Ride through desert valleys to an abandoned mining village.',
                        'location' => 'Marsa Alam Desert',
                    ],
                    'ar' => [
                        'title' => 'رحلة الجيب لقرية المناجم',
                        'description' => 'القيادة بالسيارة الجيب وسط الصحراء الشرقية للتوجه نحو قرية التعدين القديمة المهجورة.',
                        'location' => 'صحراء مرسى علم',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Gold Mines Exploration',
                        'description' => 'Tour the old mines and learn about their history.',
                        'location' => 'Abandoned Mines',
                    ],
                    'ar' => [
                        'title' => 'استكشاف مناجم الذهب القديمة',
                        'description' => 'استكشاف مواقع مناجم الذهب القديمة والتعرف على تاريخ استخراج الكنوز بالصحراء.',
                        'location' => 'المناجم المهجورة',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Bedouin Breakfast',
                        'description' => 'Traditional Egyptian breakfast and tea in the village.',
                        'location' => 'Bedouin Village',
                    ],
                    'ar' => [
                        'title' => 'الفطور البدوي التقليدي',
                        'description' => 'تناول فطور مصري بدوي شهي ومخبوزات طازجة وشاي بدوي دافئ في القرية.',
                        'location' => 'القرية البدوية',
                    ],
                ],
                [
                    'day_number' => 7,
                    'en' => [
                        'title' => 'Camel Ride & Bread Making',
                        'description' => 'Short camel ride and watch Bedouin ladies bake fresh bread.',
                        'location' => 'Camel Yard',
                    ],
                    'ar' => [
                        'title' => 'ركوب الجمل وخبز العيش',
                        'description' => 'خوض جولة قصيرة بالجمال، ومشاهدة طريقة خبز العيش البلدي بالطريقة البدوية التقليدية.',
                        'location' => 'ساحة الجمال',
                    ],
                ],
                [
                    'day_number' => 8,
                    'en' => [
                        'title' => 'Return Transfer',
                        'description' => 'Drive back to your hotel.',
                        'location' => 'Marsa Alam',
                    ],
                    'ar' => [
                        'title' => 'العودة إلى الفندق',
                        'description' => 'التحرك في السيارة والعودة إلى فندقك بمرسى علم بعد قضاء يوم ممتع.',
                        'location' => 'مرسى علم',
                    ],
                ],
            ],
            61 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Hotel Pickup',
                        'description' => 'Early morning pickup from Marsa Alam hotel.',
                        'location' => 'Marsa Alam',
                    ],
                    'ar' => [
                        'title' => 'الانتقال من الفندق',
                        'description' => 'التحرك صباحًا بالسيارة والتوجه نحو ساحة الجمال بمرسى علم.',
                        'location' => 'مرسى علم',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Camel Yard Arrival',
                        'description' => 'Welcome briefing and quad preparation.',
                        'location' => 'Camel Yard',
                    ],
                    'ar' => [
                        'title' => 'الوصول لساحة الجمال',
                        'description' => 'الوصول للـ Camel Yard والاستماع لتعليمات قيادة دراجات البيتش باجي.',
                        'location' => 'ساحة الجمال',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Desert Quad Ride',
                        'description' => 'Thrilling quad ride through scenic desert valleys.',
                        'location' => 'Camel Yard Trails',
                    ],
                    'ar' => [
                        'title' => 'قيادة البيتش باجي بالوديان',
                        'description' => 'القيادة الحماسية للبيتش باجي وسط التلال والوديان الصخرية الجميلة.',
                        'location' => 'دروب ساحة الجمال',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Bedouin Tea',
                        'description' => 'Relax with hot tea at the Camel Yard.',
                        'location' => 'Camel Yard',
                    ],
                    'ar' => [
                        'title' => 'استراحة وشاي بدوي',
                        'description' => 'الاستراحة لبعض الوقت وتناول الشاي البدوي الساخن تحت الخيمة البدوية.',
                        'location' => 'ساحة الجمال',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Private Lagoon',
                        'description' => 'Quad to a quiet private lagoon.',
                        'location' => 'Private Lagoon',
                    ],
                    'ar' => [
                        'title' => 'التوجه للبحيرة الخاصة',
                        'description' => 'الانطلاق بالدراجات الرباعية والتوجه مباشرة نحو بحيرة الشاطئ الخاصة والجميلة.',
                        'location' => 'البحيرة الخاصة',
                    ],
                ],
                [
                    'day_number' => 6,
                    'en' => [
                        'title' => 'Snorkeling & Swimming',
                        'description' => 'Snorkel in crystal-clear waters (spotting sea turtles).',
                        'location' => 'Private Lagoon',
                    ],
                    'ar' => [
                        'title' => 'السباحة والسنوركل بالبحيرة',
                        'description' => 'السباحة في مياه البحيرة الهادئة والقيام بالسنوركل لاستكشاف السلاحف البحرية والأسماك.',
                        'location' => 'البحيرة الخاصة',
                    ],
                ],
                [
                    'day_number' => 7,
                    'en' => [
                        'title' => 'Fresh Fish Lunch',
                        'description' => 'Enjoy fresh fish, rice, and salad at the Camel Yard.',
                        'location' => 'Camel Yard',
                    ],
                    'ar' => [
                        'title' => 'غداء السمك الطازج',
                        'description' => 'العودة للمخيم وتناول وجبة غداء شهية من السمك المشوي الطازج مع الأرز والسلطات.',
                        'location' => 'ساحة الجمال',
                    ],
                ],
                [
                    'day_number' => 8,
                    'en' => [
                        'title' => 'Return Transfer',
                        'description' => 'Drop-off back to your hotel.',
                        'location' => 'Marsa Alam',
                    ],
                    'ar' => [
                        'title' => 'العودة إلى الفندق',
                        'description' => 'ركوب السيارة مجددًا والعودة التامة لفندقك بمرسى علم.',
                        'location' => 'مرسى علم',
                    ],
                ],
            ],
            62 => [
                [
                    'day_number' => 1,
                    'en' => [
                        'title' => 'Hotel Pickup',
                        'description' => 'Pickup from Marsa Alam hotel in the morning or afternoon.',
                        'location' => 'Marsa Alam',
                    ],
                    'ar' => [
                        'title' => 'الانتقال من الفندق',
                        'description' => 'التحرك من الفندق صباحًا أو بعد الظهر لبدء مغامرة البيتش باجي.',
                        'location' => 'مرسى علم',
                    ],
                ],
                [
                    'day_number' => 2,
                    'en' => [
                        'title' => 'Quad Bike Safari',
                        'description' => '2-hour guided quad ride through desert and coastal trails.',
                        'location' => 'Marsa Alam Trails',
                    ],
                    'ar' => [
                        'title' => 'جولة البيتش باجي (ساعتين)',
                        'description' => 'قيادة دراجات البيتش باجي لمدة ساعتين كاملتين على الشاطئ وبين دروب الجبال.',
                        'location' => 'دروب مرسى علم',
                    ],
                ],
                [
                    'day_number' => 3,
                    'en' => [
                        'title' => 'Camel Yard Stop',
                        'description' => 'Enjoy a relaxing camel ride in the Bedouin Yard.',
                        'location' => 'Camel Yard',
                    ],
                    'ar' => [
                        'title' => 'ركوب الجمل بساحة الجمال',
                        'description' => 'الوصول للـ Camel Yard وتجربة ركوب الجمل والتقاط صور جميلة بملابس بدوية.',
                        'location' => 'ساحة الجمال',
                    ],
                ],
                [
                    'day_number' => 4,
                    'en' => [
                        'title' => 'Photos & Papyrus',
                        'description' => 'Optional photo/video print on real papyrus paper.',
                        'location' => 'Camel Yard',
                    ],
                    'ar' => [
                        'title' => 'طباعة الصور على البردي',
                        'description' => 'فرصة التقاط وطباعة صورك التذكارية المميزة على ورق البردي الحقيقي وشراء تذكارات.',
                        'location' => 'ساحة الجمال',
                    ],
                ],
                [
                    'day_number' => 5,
                    'en' => [
                        'title' => 'Hotel Drop-off',
                        'description' => 'Return to your hotel.',
                        'location' => 'Marsa Alam',
                    ],
                    'ar' => [
                        'title' => 'العودة إلى الفندق',
                        'description' => 'التوجه مجددًا لفندقك بمرسى علم بالسيارة الخاصة.',
                        'location' => 'مرسى علم',
                    ],
                ],
            ],
        ];

        $fallbackLocales = ['de', 'fr', 'ru', 'tr', 'hi'];

        foreach ($itineraries as $serviceId => $steps) {
            foreach ($steps as $step) {
                // Check if already exists to ensure idempotency
                $existing = DB::table('tour_itineraries')
                    ->where('service_id', $serviceId)
                    ->where('day_number', $step['day_number'])
                    ->first();

                if ($existing) {
                    $itineraryId = $existing->id;
                    DB::table('tour_itineraries')
                        ->where('id', $itineraryId)
                        ->update([
                            'title' => $step['en']['title'],
                            'description' => $step['en']['description'],
                            'location' => $step['en']['location'],
                            'updated_at' => now(),
                        ]);
                } else {
                    $itineraryId = DB::table('tour_itineraries')->insertGetId([
                        'service_id' => $serviceId,
                        'title' => $step['en']['title'],
                        'day_number' => $step['day_number'],
                        'description' => $step['en']['description'],
                        'location' => $step['en']['location'],
                        'display_order' => $step['day_number'],
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }

                // 1. Insert English translation
                $this->updateOrInsertTranslation($itineraryId, 'en', $step['en']);

                // 2. Insert Arabic translation (non-fallback!)
                $this->updateOrInsertTranslation($itineraryId, 'ar', $step['ar']);

                // 3. Insert other fallback translations using English
                foreach ($fallbackLocales as $locale) {
                    $this->updateOrInsertTranslation($itineraryId, $locale, $step['en']);
                }
            }
        }
    }

    private function updateOrInsertTranslation(int $itineraryId, string $locale, array $data): void
    {
        $existingTrans = DB::table('tour_itinerary_translations')
            ->where('tour_itinerary_id', $itineraryId)
            ->where('locale', $locale)
            ->first();

        if ($existingTrans) {
            DB::table('tour_itinerary_translations')
                ->where('id', $existingTrans->id)
                ->update([
                    'title' => $data['title'],
                    'description' => $data['description'],
                    'location' => $data['location'],
                    'updated_at' => now(),
                ]);
        } else {
            DB::table('tour_itinerary_translations')->insert([
                'tour_itinerary_id' => $itineraryId,
                'locale' => $locale,
                'title' => $data['title'],
                'description' => $data['description'],
                'location' => $data['location'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}