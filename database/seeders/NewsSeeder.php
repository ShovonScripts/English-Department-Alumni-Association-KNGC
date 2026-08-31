<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\NewsCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $categories = NewsCategory::pluck('id', 'slug');

        $articles = [
            // Published, past, featured
            [
                'title' => 'Department Launches New Creative Writing Fellowship',
                'category' => 'association-news',
                'excerpt' => 'A new fellowship for emerging writers opens its first call for applications this September, supported by EDAA members.',
                'content' => "The English Department has announced a prestigious fellowship programme for emerging creative writers. The fellowship, which is supported by contributions from EDAA members, will provide selected writers with mentorship, workspace, and a stipend to complete their debut manuscripts.\n\nApplications open on September 1st and close on October 31st. The programme is open to graduates of the English Department within the last ten years.\n\nThe fellowship includes monthly workshops with established authors, access to the University library, and a closing showcase where fellows present their work to publishers and editors.",
                'author_name' => 'Department Office',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'title' => 'EDAA Awards Merit Scholarships to Four Students',
                'category' => 'association-news',
                'excerpt' => 'This year\'s recipients were recognised for excellence in literary criticism and creative writing at the annual awards ceremony.',
                'content' => "The English Department Alumni Association has awarded merit scholarships to four outstanding final-year students. The awards were presented at the annual graduation reception.\n\nRecipients were selected based on academic excellence, creative output, and contribution to departmental life. Each scholarship covers tuition fees for the final semester.\n\nThis year's recipients are Adaeze Okonkwo, Yusuf Bello, Priya Nair, and Samuel Mensah. Their work spans literary criticism, poetry, and drama.",
                'author_name' => 'Mercy Uche',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDays(45),
            ],
            [
                'title' => 'Alumni Mentorship Programme Opens for Applications',
                'category' => 'association-news',
                'excerpt' => 'Seasoned graduates will guide final-year students through careers in publishing, education, media, and the arts.',
                'content' => "The EDAA Mentorship Programme is now accepting applications for the 2026-2027 cycle. The programme pairs final-year students with experienced alumni working in diverse fields.\n\nMentors include editors, professors, journalists, and creative directors. Each pair meets monthly for one academic year.\n\nPast participants have praised the programme for its practical guidance and lasting professional connections.",
                'author_name' => 'Kofi Adjei',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(60),
            ],
            // Published, past
            [
                'title' => 'Annual Reunion Date Announced for 2026',
                'category' => 'events',
                'excerpt' => 'Mark your calendars: this year\'s homecoming takes place on November 15th with a full programme of events.',
                'content' => "The EDAA has confirmed November 15th as the date for this year's annual homecoming reunion. The event will feature campus tours, a lecture by a distinguished alumna, and an evening reception.\n\nRegistration will open in September. Early-bird tickets will be available at a reduced rate.\n\nAll alumni, faculty, and friends of the department are warmly invited to attend.",
                'author_name' => 'EDAA Secretariat',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => 'Professor Adeyemi Delivers Keynote at International Conference',
                'category' => 'academic',
                'excerpt' => 'Our esteemed faculty member represented the department at the World Literature Forum in London.',
                'content' => "Professor Grace Adeyemi delivered the opening keynote at the 2026 World Literature Forum in London. Her lecture, titled Language and Belonging in Postcolonial Fiction, drew from her latest research.\n\nThe conference brought together scholars from over 40 countries. Professor Adeyemi's address was praised for its depth and accessibility.\n\nA recording of the lecture is available on the department's YouTube channel.",
                'author_name' => 'Department Office',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(90),
            ],
            [
                'title' => 'New Library Wing Inaugurated',
                'category' => 'department-news',
                'excerpt' => 'The expanded English Literature wing of the university library now houses rare manuscripts and a reading room.',
                'content' => "The new English Literature wing of the university library was inaugurated last month. The expansion adds 5,000 square feet of reading and archival space.\n\nThe wing includes a rare manuscripts collection, a quiet reading room, and dedicated workspaces for postgraduate researchers. The EDAA contributed to the funding of the project.\n\nA plaque commemorating the contribution of alumni donors was unveiled at the ceremony.",
                'author_name' => 'Department Office',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(120),
            ],
            [
                'title' => 'Student Exchange Programme Expands to Three New Universities',
                'category' => 'academic',
                'excerpt' => 'Partnerships with universities in Ghana, Kenya, and the UK create new opportunities for students.',
                'content' => "The English Department has signed exchange agreements with the University of Ghana, the University of Nairobi, and the University of Edinburgh. Students in their second or third year may apply for semester-long exchanges.\n\nThe programme covers tuition waivers and provides a small living stipend. Applications for the 2027 spring semester open in January.\n\nThese partnerships bring the department's total exchange network to eight institutions across four continents.",
                'author_name' => 'Dr. Grace Adeyemi',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(150),
            ],
            // Published, future (should not appear publicly)
            [
                'title' => 'Literary Magazine Launch Event',
                'category' => 'events',
                'excerpt' => 'Join us for the unveiling of the latest edition of the department\'s literary magazine.',
                'content' => "The department's annual literary magazine will be launched at a special event next month. The edition features poetry, short fiction, and essays by students and alumni.\n\nThe launch will include readings by selected contributors and a reception with refreshments.\n\nAll are welcome to attend. Details and RSVP information will follow.",
                'author_name' => 'Department Office',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->addMonth(),
            ],
            [
                'title' => 'Career Workshop for Final Year Students',
                'category' => 'announcements',
                'excerpt' => 'A practical half-day workshop on CV writing, interview skills, and career planning for graduating students.',
                'content' => "The EDAA is organising a career workshop for final-year English Department students. The half-day session covers CV writing, interview preparation, and career pathways for humanities graduates.\n\nAlumni volunteers from various industries will share their experiences and offer one-on-one advice.\n\nThe workshop takes place on October 5th in the Faculty Board Room. Registration is required.",
                'author_name' => 'Kofi Adjei',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->addWeeks(3),
            ],
            // Draft
            [
                'title' => 'Alumni Networking Dinner Planned',
                'category' => 'events',
                'excerpt' => 'An evening of conversation and connection for alumni in the Lagos metropolitan area.',
                'content' => "Plans are underway for an alumni networking dinner in Lagos. The event will provide an informal setting for alumni to reconnect and explore professional opportunities.\n\nDetails including venue and ticket pricing will be announced soon.",
                'author_name' => 'EDAA Secretariat',
                'status' => 'draft',
                'is_featured' => false,
                'published_at' => null,
            ],
            [
                'title' => 'Poetry Competition Results Announced',
                'category' => 'alumni-news',
                'excerpt' => 'Winners of the annual inter-departmental poetry competition have been selected.',
                'content' => "The judges have completed their review of submissions to the annual poetry competition. Winners will be announced at the homecoming ceremony.\n\nThis year saw a record number of entries from both students and alumni. The judging panel included three published poets.",
                'author_name' => 'Ngozi Eze',
                'status' => 'draft',
                'is_featured' => false,
                'published_at' => null,
            ],
        ];

        foreach ($articles as $data) {
            $categoryId = $categories[$data['category']] ?? null;

            News::firstOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'news_category_id' => $categoryId,
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'content' => $data['content'],
                    'featured_image' => null,
                    'status' => $data['status'],
                    'is_featured' => $data['is_featured'],
                    'published_at' => $data['published_at'],
                    'author_name' => $data['author_name'],
                    'sort_order' => 0,
                ]
            );
        }
    }
}
