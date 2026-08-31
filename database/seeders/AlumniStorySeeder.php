<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\AlumniStory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AlumniStorySeeder extends Seeder
{
    public function run(): void
    {
        if (AlumniStory::exists()) {
            return;
        }

        $alumniSlugs = Alumni::pluck('id', 'slug');

        $stories = [
            // Published, past, featured
            [
                'title' => 'From Classroom to Global Career',
                'alumni' => 'adaeze-okafor',
                'excerpt' => 'How the English Department prepared me for a career in international publishing, and why the connections I made still matter today.',
                'content' => "When I first walked into the Department as a nervous eighteen-year-old, I had no idea that the next four years would shape the rest of my career. The English Department didn't just teach me literature — it taught me how to think critically about the world.\n\nAfter graduating, I joined a small publishing house in Lagos. Within five years, I was managing editor of a Pan-African imprint. The skills I learned in seminars — close reading, persuasive writing, and constructive criticism — became my most valuable professional tools.\n\nToday I work with authors from across the continent, and I still draw on the analytical framework my lecturers instilled in me. Every editorial decision I make echoes the discipline of a Shakespeare seminar or the rigour of a Victorian literature exam.",
                'author_name' => 'Mercy Uche',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDays(30),
            ],
            [
                'title' => 'How the Department Shaped My Writing',
                'alumni' => 'kwame-mensah',
                'excerpt' => 'From confused first-year to published academic — the journey that started in a lecture hall in Lagos.',
                'content' => "I came to the Department intending to become a journalist. Instead, I discovered a passion for academic research that has defined my career.\n\nThe small seminar groups gave me confidence to speak about ideas. The feedback from lecturers was honest and encouraging. By my third year, I was writing my first research paper on postcolonial narrative.\n\nNow, as a lecturer myself, I try to recreate that same environment for my students. The Department taught me that education is not just about content — it's about creating a space where curiosity is celebrated.\n\nI return to campus whenever I can, and each visit reminds me why this community matters so much.",
                'author_name' => 'Kofi Adjei',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDays(45),
            ],
            [
                'title' => 'Lessons Beyond Literature',
                'alumni' => 'halima-balogun',
                'excerpt' => 'How studying English prepared me for a career in broadcast media and documentary filmmaking.',
                'content' => "People often ask me what you can do with an English degree. I tell them everything.\n\nThe Department taught me how to construct a narrative, how to understand an audience, and how to communicate complex ideas in simple language. These are the exact skills I use every day as a documentary producer.\n\nMy first major production was a series on language preservation in East Africa. The research skills I learned during my degree were essential. But more than that, the Department taught me to listen — to stories, to voices, to the spaces between words.\n\nI owe my career to the foundation I received here.",
                'author_name' => 'Ngozi Eze',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(60),
            ],
            [
                'title' => 'Finding My Voice Through Shakespeare',
                'alumni' => 'chidi-eze',
                'excerpt' => 'A poet reflects on how the Department gave him the tools and confidence to pursue literary arts.',
                'content' => "I wrote my first poem in a second-year creative writing workshop. The lecturer told me it was raw but honest. That single comment gave me the courage to keep writing.\n\nThe Department was a place where creative ambition was taken seriously. We had reading groups, open mic nights, and a literary magazine that welcomed student contributions. I published my first piece in that magazine.\n\nYears later, when my debut collection was shortlisted for a prize, I thought of those early workshops. The Department didn't just teach me about literature — it showed me that I could be part of the literary conversation.\n\nI am proud to represent the Department in the international literary community.",
                'author_name' => 'Tom Bello',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(90),
            ],
            [
                'title' => 'A Journey from Campus to Publishing',
                'alumni' => 'fatima-haddad',
                'excerpt' => 'From a student passionate about preservation to a national archivist safeguarding written heritage.',
                'content' => "My interest in archives began with a course on textual bibliography. The idea that a physical book carries history — not just in its words but in its paper, binding, and marginalia — fascinated me.\n\nAfter graduation, I pursued a career in archival science. The analytical skills I learned in the Department were directly applicable. Reading a historical manuscript requires the same close attention as reading a poem.\n\nNow I lead a team that digitises and preserves national documents. Every time we save a manuscript from deterioration, I think of the lecturers who taught me to value the written word.\n\nThe Department gave me a purpose, and I am grateful every day.",
                'author_name' => 'Dr. Grace Adeyemi',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(120),
            ],
            [
                'title' => 'The Mentors Who Changed Everything',
                'alumni' => 'adaeze-okafor',
                'excerpt' => 'Why the relationships I built with lecturers and alumni remain the most valuable part of my education.',
                'content' => "In my final year, I was unsure about my career direction. A lecturer introduced me to an alumni who worked in publishing. That single connection changed my life.\n\nThe mentor took me under her wing, introduced me to colleagues, and helped me understand the industry. When I eventually applied for jobs, she recommended me for a position.\n\nThis is what makes the Department special. It's not just the curriculum — it's the people who invest in you. The relationships I built during my studies have lasted longer than any textbook.\n\nI now mentor young alumni myself, trying to give back what was given to me.",
                'author_name' => 'Mercy Uche',
                'status' => 'published',
                'is_featured' => true,
                'published_at' => now()->subDays(150),
            ],
            // Published, past
            [
                'title' => 'Building a Career in Media and Communications',
                'alumni' => 'kwame-mensah',
                'excerpt' => 'How the Department opened doors to a career I never expected.',
                'content' => "I never planned to work in media. I wanted to teach. But the writing skills I developed in the Department caught the attention of a media company during an alumni event.\n\nThey offered me a role in communications. Within a year, I was leading the content team. The ability to write clearly and persuasively is rare, and the Department gave me that ability.\n\nToday I manage communications for a multinational organisation. Every piece of content I review benefits from the editorial discipline I learned in those seminar rooms.\n\nThe Department prepared me for a career I didn't know I wanted.",
                'author_name' => 'Kofi Adjei',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(20),
            ],
            [
                'title' => 'How Alumni Networks Open Doors',
                'alumni' => 'halima-balogun',
                'excerpt' => 'The unexpected power of reconnecting with fellow graduates at Association events.',
                'content' => "I attended my first alumni dinner on a whim. I had been graduated for three years and felt disconnected from the Department.\n\nAt the dinner, I met an alumna who ran a media production company. We talked for an hour about documentary storytelling. Two weeks later, she offered me a freelance contract.\n\nThat contract turned into a full-time role and eventually my own production company. The alumni network is not just a social circle — it's a professional ecosystem.\n\nI make it a point to attend every reunion now. You never know which conversation will change your career.",
                'author_name' => 'Ngozi Eze',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->subDays(200),
            ],
            // Published, future (should not appear publicly)
            [
                'title' => 'Why I Keep Coming Back to Reunions',
                'alumni' => 'chidi-eze',
                'excerpt' => 'Homecoming is more than nostalgia — it is a reminder of who I am and where I come from.',
                'content' => "Every November, I book my flight back to campus. Some people think it's sentimental. For me, it's essential.\n\nThe reunion is where I reconnect with friends who knew me when I was still figuring out who I was. It's where I hear new ideas from current students. It's where I remember why literature matters.\n\nThe Department gave me a sense of belonging. The reunion is how I keep that feeling alive.\n\nI encourage every alumnus to attend at least one reunion. You'll understand when you're there.",
                'author_name' => 'Tom Bello',
                'status' => 'published',
                'is_featured' => false,
                'published_at' => now()->addMonth(),
            ],
            // Draft
            [
                'title' => 'Language as a Bridge Across Cultures',
                'alumni' => 'fatima-haddad',
                'excerpt' => 'How studying English literature helped me understand my own cultural identity more deeply.',
                'content' => "Studying English literature as an Egyptian student was a journey of cultural translation. I learned to see my own heritage through the lens of comparative literature.\n\nThe Department encouraged this kind of cross-cultural thinking. My lecturers challenged me to find connections between African and European literary traditions.\n\nThis perspective has been invaluable in my career as an archivist. I now lead projects that document and preserve Egypt's multicultural literary heritage.\n\nThe Department taught me that literature belongs to everyone.",
                'author_name' => 'Dr. Grace Adeyemi',
                'status' => 'draft',
                'is_featured' => false,
                'published_at' => null,
            ],
            [
                'title' => 'My Experience Studying Abroad',
                'alumni' => 'adaeze-okafor',
                'excerpt' => 'The exchange programme that broadened my horizons and changed my perspective on literature.',
                'content' => "In my third year, I spent a semester at the University of Edinburgh through the Department's exchange programme. It was the most transformative experience of my education.\n\nStudying literature in a different academic context taught me that literary interpretation is not universal — it is shaped by culture, history, and geography.\n\nI returned to my home university with a broader perspective and a network of international contacts. That experience directly influenced my career in international publishing.\n\nI recommend the exchange programme to every student who has the opportunity.",
                'author_name' => 'Mercy Uche',
                'status' => 'draft',
                'is_featured' => false,
                'published_at' => null,
            ],
            [
                'title' => 'What the Department Taught Me About Resilience',
                'alumni' => 'kwame-mensah',
                'excerpt' => 'The challenges of postgraduate study and how the Department prepared me for them.',
                'content' => "My master's thesis nearly broke me. The research was demanding, the writing was difficult, and I questioned my abilities daily.\n\nBut the Department had taught me something more valuable than content — it had taught me resilience. The ability to sit with difficulty, to revise and revise again, to trust the process.\n\nWhen I finally submitted my thesis, I understood that the struggle was the education. The Department had prepared me not just for academic work, but for any challenge that required patience and perseverance.\n\nThat lesson has served me in every aspect of my life.",
                'author_name' => 'Kofi Adjei',
                'status' => 'draft',
                'is_featured' => false,
                'published_at' => null,
            ],
        ];

        foreach ($stories as $data) {
            $alumniId = $alumniSlugs[$data['alumni']] ?? null;

            AlumniStory::firstOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'alumni_id' => $alumniId,
                    'title' => $data['title'],
                    'excerpt' => $data['excerpt'],
                    'content' => $data['content'],
                    'cover_image' => null,
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
