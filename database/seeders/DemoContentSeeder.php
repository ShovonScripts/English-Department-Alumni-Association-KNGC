<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\AlumniStory;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\GalleryAlbum;
use App\Models\GalleryPhoto;
use App\Models\News;
use App\Models\NewsCategory;
use App\Models\PressRelease;
use App\Models\Publication;
use App\Models\PublicationCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Seeds two items of each public content type so the site
 * immediately has realistic demo content to browse:
 *   - Events (2, one upcoming + one featured)
 *   - News (2)
 *   - Alumni memories / stories (2)
 *   - Gallery albums (2, with photos)
 *   - Publications (2)
 *   - Press releases (2)
 */
class DemoContentSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('Seeding demo content (events, news, stories, gallery, publications, press releases)...');

        // ── Categories ─────────────────────────────────────────────
        $eventReunion = EventCategory::updateOrCreate(
            ['slug' => Str::slug('Reunion')],
            ['name' => 'Reunion', 'description' => 'Alumni reunions, get-togethers and anniversary celebrations.']
        );
        $eventSeminar = EventCategory::updateOrCreate(
            ['slug' => Str::slug('Seminar & Workshop')],
            ['name' => 'Seminar & Workshop', 'description' => 'Academic seminars, workshops and skill-building sessions.']
        );

        $newsDept = NewsCategory::updateOrCreate(
            ['slug' => Str::slug('Department News')],
            ['name' => 'Department News', 'description' => 'Latest news from the English Department, KNGC.', 'sort_order' => 1, 'is_active' => true]
        );
        $newsAchievements = NewsCategory::updateOrCreate(
            ['slug' => Str::slug('Achievements')],
            ['name' => 'Achievements', 'description' => 'Honours, awards and achievements of our alumni.', 'sort_order' => 2, 'is_active' => true]
        );

        $pubJournal = PublicationCategory::updateOrCreate(
            ['slug' => Str::slug('Journal')],
            ['name' => 'Journal', 'description' => 'Peer-reviewed academic journals.', 'sort_order' => 1, 'is_active' => true]
        );
        $pubMagazine = PublicationCategory::updateOrCreate(
            ['slug' => Str::slug('Magazine')],
            ['name' => 'Magazine', 'description' => 'Departmental magazines and yearbooks.', 'sort_order' => 2, 'is_active' => true]
        );

        // ── Events (2) ────────────────────────────────────────────
        Event::updateOrCreate(
            ['slug' => Str::slug('Grand Alumni Reunion 2026')],
            [
                'category_id' => $eventReunion->id,
                'title' => 'Grand Alumni Reunion 2026',
                'cover_image' => 'gallery/demo-1.jpg',
                'short_description' => 'An evening of nostalgia, reconnections and celebration for every EDAA-KNGC family.',
                'description' => "The English Department Alumni Association (EDAA-KNGC) is delighted to announce the Grand Alumni Reunion 2026.\n\nThe evening promises a nostalgic trip down memory lane \u2013 with drama performances by current students, musical sessions, felicitation of meritorious alumni, and dinner together. Old friends, batchmates and beloved teachers will all be reunited under one roof.\n\nAll members and former students of the Department of English, Government Kabi Nazrul College, are cordially invited.",
                'event_date' => now()->addMonths(2)->toDateString(),
                'start_time' => '17:00:00',
                'end_time' => '21:30:00',
                'venue' => 'College Auditorium',
                'address' => 'Govt. Kabi Nazrul College, Laxmibazar',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'organizer' => 'EDAA-KNGC Executive Committee',
                'capacity' => 300,
                'registration_deadline' => now()->addMonths(1)->toDateString(),
                'status' => Event::STATUS_PUBLISHED,
                'is_featured' => true,
                'sort_order' => 1,
            ]
        );

        Event::updateOrCreate(
            ['slug' => Str::slug('Creative Writing Workshop')],
            [
                'category_id' => $eventSeminar->id,
                'title' => 'Creative Writing Workshop',
                'cover_image' => 'gallery/demo-2.jpg',
                'short_description' => 'A hands-on workshop on fiction, poetry and creative non-fiction with our alumni writers.',
                'description' => "The Department of English, in collaboration with EDAA-KNGC, hosted a day-long Creative Writing Workshop.\n\nLed by our distinguished alumni authors and faculty, the workshop covered techniques in short fiction, poetry and creative non-fiction, with open feedback sessions and a showcase of participant writing.\n\nThis event is remembered as the seed of the department's very popular alumni literary circle.",
                'event_date' => now()->subMonths(1)->toDateString(),
                'start_time' => '09:30:00',
                'end_time' => '16:00:00',
                'venue' => 'Seminar Hall (3rd Floor)',
                'address' => 'Govt. Kabi Nazrul College, Laxmibazar',
                'city' => 'Dhaka',
                'country' => 'Bangladesh',
                'organizer' => 'EDAA-KNGC',
                'capacity' => 80,
                'registration_deadline' => now()->subMonths(2)->toDateString(),
                'status' => Event::STATUS_PUBLISHED,
                'is_featured' => false,
                'sort_order' => 2,
            ]
        );

        // ── News (2) ──────────────────────────────────────────────
        News::updateOrCreate(
            ['slug' => Str::slug('department-new-literary-common-room')],
            [
                'news_category_id' => $newsDept->id,
                'title' => 'Department Inaugurates New Literary Common Room',
                'excerpt' => 'A dedicated common room for reading, discussion and cultural practice opens its doors for all students of the department.',
                'content' => "The Department of English formally inaugurated its brand-new Literary Common Room in the presence of alumni, faculty and students.\n\nThe space is equipped with a mini library, discussion corners and a small stage for literary activities. The initiative was made possible by generous contributions from EDAA-KNGC alumni.\n\nThe ceremony ended with a heartfelt vote of thanks and the promise of many more collaborative initiatives.",
                'featured_image' => 'gallery/demo-3.jpg',
                'status' => News::STATUS_PUBLISHED,
                'is_featured' => true,
                'published_at' => now()->subDays(6),
                'author_name' => 'EDAA-KNGC Editorial',
                'sort_order' => 1,
            ]
        );

        News::updateOrCreate(
            ['slug' => Str::slug('alumnus-wins-national-essay-award')],
            [
                'news_category_id' => $newsAchievements->id,
                'title' => 'Alumnus Wins National Essay Competition',
                'excerpt' => 'A former student of the department wins a coveted national essay award on migration and identity.',
                'content' => "We are proud to announce that an alumnus of the department has won the National Essay Competition organised by the Ministry of Education.\n\nThe winning essay, written in English, explored themes of migration, memory and identity from a deeply personal perspective that judges described as 'poignant and beautifully researched'.\n\nThe association extends its heartfelt congratulations to the alumni author and to the teachers who mentored them.",
                'featured_image' => 'gallery/demo-4.jpg',
                'status' => News::STATUS_PUBLISHED,
                'is_featured' => false,
                'published_at' => now()->subDays(2),
                'author_name' => 'EDAA-KNGC Editorial',
                'sort_order' => 2,
            ]
        );

        // ── Alumni for memory stories ─────────────────────────────
        $alumniOne = Alumni::orderBy('id')->first();
        $alumniTwo = Alumni::orderBy('id')->skip(1)->first();
// ── Memories / Alumni Stories (2) ─────────────────────────
        if ($alumniOne) {
            AlumniStory::updateOrCreate(
                ['slug' => 'from-the-bench-corridor-to-teaching-english'],
                [
                    'alumni_id' => $alumniOne->id,
                    'title' => 'From the Bench Corridor to Teaching English',
                    'excerpt' => 'My journey from the famous department corridor to a classroom of my own.',
                    'content' => "Everyone remembers the bench corridor. We spent legendary hours there \u2013 practising speaking roles, rehearsing dramas, debating current affairs, and yes, sharing treats.\n\nThe teachers we had were extraordinary. They turned grammar drills into storytelling and literary theory into conversations about our own lives.\n\nToday, as I stand in my own classroom, I carry that corridor with me.",
                    'cover_image' => 'gallery/demo-5.jpg',
                    'status' => AlumniStory::STATUS_PUBLISHED,
                    'is_featured' => true,
                    'published_at' => now()->subDays(10),
                    'author_name' => $alumniOne->full_name,
                    'sort_order' => 1,
                ]
            );
        }

        if ($alumniTwo) {
            AlumniStory::updateOrCreate(
                ['slug' => 'a-phone-call-that-changed-my-life'],
                [
                    'alumni_id' => $alumniTwo->id,
                    'title' => 'A Phone Call That Changed My Life',
                    'excerpt' => 'How a single phone call from my professor led me to my dream job.',
                    'content' => "In my final year, I was convinced my degree would not get me anywhere. Then my professor called me out of the blue about an internship at a renowned media house.\n\nThat one call opened a door I never knew existed. It taught me the power of the alumni network and how much this department looks after its own.\n\nMy advice: keep in touch with your teachers and batchmates \u2013 the road opens in surprising ways.",
                    'cover_image' => 'gallery/demo-6.jpg',
                    'status' => AlumniStory::STATUS_PUBLISHED,
                    'is_featured' => false,
                    'published_at' => now()->subDays(4),
                    'author_name' => $alumniTwo->full_name,
                    'sort_order' => 2,
                ]
            );
        }

        // ── Gallery albums (2, each with 3 photos) ────────────────
        $albumOne = GalleryAlbum::updateOrCreate(
            ['slug' => 'reunion-glimpses-2026'],
            [
                'title' => 'Reunion Glimpses 2026',
                'description' => 'Selected photos from the recent alumni reunion \u2013 laughter, hugs and memories.',
                'cover_image' => 'gallery/demo-1.jpg',
                'event_id' => Event::where('slug', 'grand-alumni-reunion-2026')->value('id'),
                'status' => GalleryAlbum::STATUS_PUBLISHED,
                'sort_order' => 1,
            ]
        );
        $albumTwo = GalleryAlbum::updateOrCreate(
            ['slug' => 'campus-day-album'],
            [
                'title' => 'Campus Day Album',
                'description' => 'Everyday moments of the Department of English across a bright academic year.',
                'cover_image' => 'gallery/demo-4.jpg',
                'event_id' => null,
                'status' => GalleryAlbum::STATUS_PUBLISHED,
                'sort_order' => 2,
            ]
        );
$photos = [
            [$albumOne->id, 'gallery/demo-1.jpg', 'Welcome arch', 'Alumni arriving under the welcome arch.'],
            [$albumOne->id, 'gallery/demo-2.jpg', 'Batch selfie', 'A batch of 2018 celebrates a long-awaited reunion.'],
            [$albumOne->id, 'gallery/demo-3.jpg', 'Group photograph', 'All guests alongside the teachers.'],
            [$albumTwo->id, 'gallery/demo-4.jpg', 'Library corner', 'Quiet corners of the departmental library.'],
            [$albumTwo->id, 'gallery/demo-5.jpg', 'Field day', 'An annual sports event in the campus courtyard.'],
            [$albumTwo->id, 'gallery/demo-6.jpg', 'Farewell evening', 'The iconic farewell of the graduating batch.'],
        ];

        foreach ($photos as $index => $photo) {
            GalleryPhoto::updateOrCreate(
                ['gallery_album_id' => $photo[0], 'image' => $photo[1]],
                [
                    'title' => $photo[2],
                    'caption' => $photo[3],
                    'alt_text' => $photo[2],
                    'sort_order' => $index + 1,
                    'status' => GalleryPhoto::STATUS_PUBLISHED,
                ]
            );
        }

        // ── Publications (2) ──────────────────────────────────────
        Publication::updateOrCreate(
            ['slug' => 'the-edaa-journal-vol-01'],
            [
                'publication_category_id' => $pubJournal->id,
                'title' => 'The EDAA Journal Vol. 01',
                'subtitle' => 'A collection of essays, research and reflections by faculty and alumni.',
                'description' => "The flagship academic journal of the English Department Alumni Association.\n\nVolume 01 features scholarly essays on postcolonial literature, the teaching of English in Bangladesh, and reflective pieces from our alumni in academia and media.",
                'cover_image' => 'gallery/demo-2.jpg',
                'author' => 'EDAA-KNGC Editorial Board',
                'publisher' => 'English Department Alumni Association, KNGC',
                'publication_date' => now()->subMonths(3)->toDateString(),
                'status' => Publication::STATUS_PUBLISHED,
                'is_featured' => true,
                'sort_order' => 1,
            ]
        );

        Publication::updateOrCreate(
            ['slug' => 'echo-annual-magazine-2025'],
            [
                'publication_category_id' => $pubMagazine->id,
                'title' => 'Echo: Annual Magazine 2025',
                'subtitle' => 'The voice of the Department of English \u2013 stories, art and news.',
                'description' => 'The beloved annual magazine of the department, weaving together poems, short stories, travelogues, art and student journalism.\n\nThis edition includes the special section \u201cTwenty Years of the Corridor\u201d celebrating our alumni.',
                'cover_image' => 'gallery/demo-3.jpg',
                'author' => 'Department of English, KNGC',
                'publisher' => 'Department of English, Govt. Kabi Nazrul College',
                'publication_date' => now()->subMonths(12)->toDateString(),
                'status' => Publication::STATUS_PUBLISHED,
                'is_featured' => false,
                'sort_order' => 2,
            ]
        );
// ── Press releases (2) ────────────────────────────────────
        PressRelease::updateOrCreate(
            ['slug' => 'edaa-kngc-launches-online-alumni-directory'],
            [
                'title' => 'EDAA-KNGC Launches Online Alumni Directory',
                'excerpt' => 'An official, searchable directory of verified members of the English Department Alumni Association is now available online.',
                'content' => "The English Department Alumni Association (EDAA-KNGC) has formally launched its online Alumni Directory.\n\nThe platform helps members find one another, discover verified profiles, and keep the alumni community connected.\n\nThe directory includes verified profiles, digital membership cards and digitised records of the department's history.",
                'cover_image' => 'gallery/demo-5.jpg',
                'status' => PressRelease::STATUS_PUBLISHED,
                'is_featured' => true,
                'published_at' => now()->subDays(3),
                'sort_order' => 1,
            ]
        );

        PressRelease::updateOrCreate(
            ['slug' => 'alumni-led-literacy-drive-surpasses-target'],
            [
                'title' => 'Alumni-Led Literacy Drive Surpasses Participation Target',
                'excerpt' => 'The voluntary literacy campaign organised by EDAA-KNGC has now reached far more learners than planned.',
                'content' => "The English department's alumni-led literacy drive has surpassed its original participation target, teaching English fundamentals to community learners.\n\nVolunteers \u2013 many of them teaching and graduate students from the department \u2013 organised weekend classes, book donations and storytelling sessions.\n\nThe association thanks every volunteer and looks forward to expanding the drive next year.",
                'status' => PressRelease::STATUS_PUBLISHED,
                'is_featured' => false,
                'published_at' => now()->subDays(1),
                'sort_order' => 2,
            ]
        );

        $this->command->info('Demo content seeded successfully.');
    }
}