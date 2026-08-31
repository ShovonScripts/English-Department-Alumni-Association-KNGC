<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\EventCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Lecture', 'slug' => 'lecture', 'description' => 'Academic lectures and keynote presentations.'],
            ['name' => 'Reunion', 'slug' => 'reunion', 'description' => 'Homecoming events and class reunions.'],
            ['name' => 'Workshop', 'slug' => 'workshop', 'description' => 'Writing workshops and skill-building sessions.'],
            ['name' => 'Networking', 'slug' => 'networking', 'description' => 'Career conversations and professional networking.'],
            ['name' => 'Social', 'slug' => 'social', 'description' => 'Social gatherings, dinners, and cultural nights.'],
            ['name' => 'Meeting', 'slug' => 'meeting', 'description' => 'AGMs, committee meetings, and town halls.'],
            ['name' => 'Awards', 'slug' => 'awards', 'description' => 'Awards ceremonies and recognition events.'],
            ['name' => 'Other', 'slug' => 'other', 'description' => 'Miscellaneous events.'],
        ];

        foreach ($categories as $category) {
            EventCategory::firstOrCreate(
                ['slug' => $category['slug']],
                $category,
            );
        }

        $categoryIds = EventCategory::pluck('id', 'slug');

        // Upcoming published events
        $upcomingEvents = [
            [
                'title' => 'Annual Alumni Lecture: "Reading the City"',
                'short_description' => 'A distinguished graduate returns to the podium for the Association\'s flagship lecture — an exploration of how literature maps our urban lives.',
                'description' => '<p>The English Department Alumni Association is proud to present its Annual Alumni Lecture, one of the most anticipated events on our calendar.</p><p>This year\'s speaker, Dr. Adaeze Okafor (Class of 2004), returns to the Faculty to deliver a compelling lecture on the intersections of urban geography and literary imagination. Drawing from her recent book <em>Mapping Lagos: Literary Cartographies of a Megacity</em>, she will explore how novelists, poets, and playwrights have charted the rhythms of city life across Africa and beyond.</p><p>The lecture will be followed by a reception and book signing. All alumni, students, and friends of the Department are welcome to attend.</p>',
                'event_date' => now()->addDays(30)->format('Y-m-d'),
                'start_time' => '16:00',
                'end_time' => '18:00',
                'venue' => 'Faculty of Arts, Great Hall',
                'address' => 'University Main Campus',
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'organizer' => 'EDAA Events Committee',
                'capacity' => 200,
                'registration_deadline' => now()->addDays(25)->format('Y-m-d'),
                'status' => 'published',
                'is_featured' => true,
                'sort_order' => 1,
                'category_id' => $categoryIds['lecture'] ?? null,
            ],
            [
                'title' => 'Alumni Homecoming Weekend',
                'short_description' => 'A weekend of reconnection, nostalgia, and celebration as alumni return to campus for the annual homecoming.',
                'description' => '<p>Join fellow graduates for a weekend of reconnection and celebration. The Annual Homecoming features campus tours, departmental receptions, a gala dinner, and the traditional校友 parade.</p><p>Whether you graduated last year or decades ago, this is your chance to walk the halls once more and reconnect with the friends and mentors who shaped your journey.</p>',
                'event_date' => now()->addDays(60)->format('Y-m-d'),
                'start_time' => '10:00',
                'end_time' => '18:00',
                'venue' => 'English Department Campus',
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'organizer' => 'Alumni Relations Office',
                'capacity' => 300,
                'registration_deadline' => now()->addDays(50)->format('Y-m-d'),
                'status' => 'published',
                'is_featured' => false,
                'sort_order' => 2,
                'category_id' => $categoryIds['reunion'] ?? null,
            ],
            [
                'title' => 'Poetry Evening: New Voices',
                'short_description' => 'An evening of poetry readings featuring emerging writers from the Department and beyond.',
                'description' => '<p>The EDAA Poetry Series continues with an evening dedicated to new and emerging voices. Join us for an intimate readings event featuring six promising poets, each bringing a unique perspective to contemporary verse.</p><p>Light refreshments will be served. Open to all alumni, students, and poetry lovers.</p>',
                'event_date' => now()->addDays(90)->format('Y-m-d'),
                'start_time' => '18:30',
                'end_time' => '20:30',
                'venue' => 'Library Reading Room',
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'organizer' => 'EDAA Events Committee',
                'capacity' => 80,
                'registration_deadline' => now()->addDays(85)->format('Y-m-d'),
                'status' => 'published',
                'is_featured' => false,
                'sort_order' => 3,
                'category_id' => $categoryIds['social'] ?? null,
            ],
            [
                'title' => "Writers' Workshop: The Short Story",
                'short_description' => 'A hands-on workshop exploring the craft of short fiction with published authors.',
                'description' => '<p>This intensive half-day workshop is designed for aspiring and practicing fiction writers who want to sharpen their short story skills. Led by award-winning author Kofi Adjei, the session covers structure, voice, revision, and the art of the closing line.</p><p>Limited to 25 participants. Bring a manuscript page for peer review.</p>',
                'event_date' => now()->addDays(120)->format('Y-m-d'),
                'start_time' => '11:00',
                'end_time' => '15:00',
                'venue' => 'Department Seminar Room',
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'organizer' => 'EDAA Events Committee',
                'capacity' => 25,
                'registration_deadline' => now()->addDays(110)->format('Y-m-d'),
                'status' => 'published',
                'is_featured' => false,
                'sort_order' => 4,
                'category_id' => $categoryIds['workshop'] ?? null,
            ],
            [
                'title' => 'Career Conversation: Publishing & Media',
                'short_description' => 'Online panel discussion with alumni working in publishing, journalism, and digital media.',
                'description' => '<p>Curious about careers in publishing and media? Join a panel of five alumni who have built successful careers across book publishing, journalism, broadcasting, and digital content creation.</p><p>This online event is perfect for final-year students and recent graduates seeking guidance on entering the industry.</p>',
                'event_date' => now()->addDays(45)->format('Y-m-d'),
                'start_time' => '17:00',
                'end_time' => '19:00',
                'venue' => 'Online (Zoom)',
                'organizer' => 'EDAA Executive Council',
                'capacity' => 150,
                'status' => 'published',
                'is_featured' => false,
                'sort_order' => 5,
                'category_id' => $categoryIds['networking'] ?? null,
            ],
            [
                'title' => 'Annual General Meeting',
                'short_description' => 'The Association\'s annual general meeting for members to review activities and elect new officers.',
                'description' => '<p>All paid members are invited to attend the Annual General Meeting. The agenda includes the annual report, financial statements, constitutional amendments, and elections for the next executive council.</p><p>Proxy voting forms are available from the Secretary. Quorum: 30 members.</p>',
                'event_date' => now()->addDays(150)->format('Y-m-d'),
                'start_time' => '14:00',
                'end_time' => '16:00',
                'venue' => 'Faculty of Arts, Room 204',
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'organizer' => 'EDAA Executive Council',
                'capacity' => 100,
                'status' => 'published',
                'is_featured' => false,
                'sort_order' => 6,
                'category_id' => $categoryIds['meeting'] ?? null,
            ],
        ];

        foreach ($upcomingEvents as $eventData) {
            $eventData['slug'] = Str::slug($eventData['title']).'-'.rand(1000, 9999);
            $eventData['description'] = self::plainText($eventData['description']);
            Event::create($eventData);
        }

        // Past published events
        $pastEvents = [
            [
                'title' => 'Literary Awards Night 2025',
                'short_description' => 'Celebrating excellence in creative writing and literary scholarship among alumni.',
                'description' => '<p>The 2025 Literary Awards Night was a memorable evening celebrating the achievements of alumni in creative writing, literary criticism, and cultural journalism. Twelve nominees were recognised across four categories.</p>',
                'event_date' => now()->subDays(60)->format('Y-m-d'),
                'start_time' => '18:00',
                'end_time' => '21:00',
                'venue' => 'University Banquet Hall',
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'organizer' => 'EDAA Events Committee',
                'capacity' => 250,
                'status' => 'published',
                'is_featured' => false,
                'sort_order' => 10,
                'category_id' => $categoryIds['awards'] ?? null,
            ],
            [
                'title' => 'Homecoming 2024',
                'short_description' => 'A joyful reunion as alumni from over 20 graduating classes gathered on campus.',
                'description' => '<p>Over 400 alumni returned to campus for Homecoming 2024, celebrating class milestones, reuniting with former lecturers, and enjoying a weekend of events including a gala dinner, departmental tours, and the traditional parade.</p>',
                'event_date' => now()->subDays(200)->format('Y-m-d'),
                'start_time' => '10:00',
                'end_time' => '18:00',
                'venue' => 'English Department Campus',
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'organizer' => 'Alumni Relations Office',
                'capacity' => 500,
                'status' => 'published',
                'is_featured' => false,
                'sort_order' => 11,
                'category_id' => $categoryIds['reunion'] ?? null,
            ],
            [
                'title' => 'Annual Lecture 2024: "The Postcolonial Library"',
                'short_description' => 'Prof. Amina Diallo explored how postcolonial nations are reshaping their literary institutions.',
                'description' => '<p>The 2024 Annual Lecture brought together scholars, students, and cultural leaders for an afternoon of rigorous intellectual engagement. Prof. Amina Diallo of the University of Ghana delivered a landmark lecture on the evolving role of libraries in postcolonial Africa.</p>',
                'event_date' => now()->subDays(350)->format('Y-m-d'),
                'start_time' => '15:00',
                'end_time' => '17:00',
                'venue' => 'Faculty of Arts, Great Hall',
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'organizer' => 'EDAA Events Committee',
                'capacity' => 200,
                'status' => 'published',
                'is_featured' => false,
                'sort_order' => 12,
                'category_id' => $categoryIds['lecture'] ?? null,
            ],
        ];

        foreach ($pastEvents as $eventData) {
            $eventData['slug'] = Str::slug($eventData['title']).'-'.rand(1000, 9999);
            $eventData['description'] = self::plainText($eventData['description']);
            Event::create($eventData);
        }

        // Draft events (for admin testing)
        $draftEvents = [
            [
                'title' => 'Cultural Night & Drama Festival',
                'short_description' => 'An evening of drama performances, cultural displays, and live music.',
                'description' => '<p>Draft event — details to be confirmed.</p>',
                'event_date' => now()->addDays(200)->format('Y-m-d'),
                'start_time' => '18:00',
                'end_time' => '22:00',
                'venue' => 'University Auditorium',
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'organizer' => 'EDAA Events Committee',
                'capacity' => 400,
                'status' => 'draft',
                'is_featured' => false,
                'sort_order' => 20,
                'category_id' => $categoryIds['social'] ?? null,
            ],
            [
                'title' => 'Scholarship Fund Gala',
                'short_description' => 'A fundraising gala to support the EDAA Scholarship Fund.',
                'description' => '<p>Draft event — details to be confirmed.</p>',
                'event_date' => now()->addDays(240)->format('Y-m-d'),
                'start_time' => '19:00',
                'end_time' => '22:00',
                'venue' => 'University Banquet Hall',
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'organizer' => 'EDAA Executive Council',
                'capacity' => 150,
                'status' => 'draft',
                'is_featured' => false,
                'sort_order' => 21,
                'category_id' => $categoryIds['other'] ?? null,
            ],
        ];

        foreach ($draftEvents as $eventData) {
            $eventData['slug'] = Str::slug($eventData['title']).'-'.rand(1000, 9999);
            $eventData['description'] = self::plainText($eventData['description']);
            Event::create($eventData);
        }
    }

    /**
     * Convert legacy HTML seed content to plain text with paragraph breaks,
     * matching the plain-text description convention used by the admin form
     * and the escaped nl2br rendering on the public event page.
     */
    private static function plainText(string $html): string
    {
        $text = preg_replace('/<br\s*\/?>/i', "\n", $html);
        $text = preg_replace('/<\/p>\s*/i', "\n\n", (string) $text);
        $text = strip_tags((string) $text);

        return trim(html_entity_decode((string) $text, ENT_QUOTES | ENT_HTML5));
    }
}
