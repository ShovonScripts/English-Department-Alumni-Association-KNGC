<?php

namespace Database\Seeders;

use App\Models\Publication;
use App\Models\PublicationCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PublicationSeeder extends Seeder
{
    public function run(): void
    {
        if (PublicationCategory::exists()) {
            return;
        }

        $categoryNames = [
            'Alumni Magazine',
            'Department Magazine',
            'Annual Report',
            'Newsletter',
            'Research',
            'Books',
            'Conference Proceedings',
            'Reports',
        ];

        foreach ($categoryNames as $name) {
            PublicationCategory::create([
                'name' => $name,
                'slug' => Str::slug($name),
            ]);
        }

        $publications = [
            [
                'title' => 'Alumni Magazine 2026',
                'category' => 'Alumni Magazine',
                'subtitle' => 'Voices from the Class of 2026',
                'description' => 'The latest edition of the EDAA Alumni Magazine featuring interviews with recent graduates, career reflections, and highlights from the annual reunion.',
                'author' => 'EDAA Editorial Board',
                'publisher' => 'English Department Alumni Association',
                'publication_date' => '2026-03-15',
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'title' => 'Annual Report 2025',
                'category' => 'Annual Report',
                'subtitle' => 'A Year in Review',
                'description' => 'Comprehensive report on the department\'s achievements, financials, alumni activities, and strategic initiatives for the 2025 academic year.',
                'author' => 'Department Office',
                'publisher' => 'University Press',
                'publication_date' => '2026-01-10',
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'title' => 'Research Journal: Modern Literature',
                'category' => 'Research',
                'subtitle' => 'Vol. 12, Issue 1',
                'description' => 'Peer-reviewed articles on contemporary literary theory, postcolonial narratives, and comparative literature from faculty and graduate researchers.',
                'author' => 'Dr. Grace Adeyemi',
                'publisher' => 'EDAA Research Division',
                'publication_date' => '2025-11-20',
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'title' => 'Department Magazine: Autumn 2025',
                'category' => 'Department Magazine',
                'subtitle' => 'Faculty Spotlights and Academic Updates',
                'description' => 'Features on faculty research projects, new course offerings, and student achievements within the English Department.',
                'author' => 'Dr. Chidi Okonkwo',
                'publisher' => 'English Department',
                'publication_date' => '2025-10-05',
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'title' => 'Conference Proceedings: Language and Identity',
                'category' => 'Conference Proceedings',
                'subtitle' => 'EDAA International Symposium 2025',
                'description' => 'Selected papers from the international symposium on Language, Literature, and Identity in the African Diaspora held in August 2025.',
                'author' => 'Prof. Nkem Okafor',
                'publisher' => 'University Press',
                'publication_date' => '2025-09-30',
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'title' => 'Alumni Newsletter: Spring 2025',
                'category' => 'Newsletter',
                'subtitle' => 'Updates from the Alumni Network',
                'description' => 'Quarterly newsletter covering alumni achievements, upcoming events, mentorship programme updates, and career opportunities.',
                'author' => 'Mercy Uche',
                'publisher' => 'EDAA Secretariat',
                'publication_date' => '2025-04-01',
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'title' => 'Postcolonial Narratives: A Critical Anthology',
                'category' => 'Books',
                'subtitle' => 'Essays on African and Caribbean Literature',
                'description' => 'A collection of critical essays examining postcolonial themes in African and Caribbean fiction, poetry, and drama from the late twentieth century to the present.',
                'author' => 'Dr. Grace Adeyemi & Prof. Nkem Okafor',
                'publisher' => 'University Press',
                'publication_date' => '2025-06-15',
                'status' => 'published',
                'is_featured' => true,
            ],
            [
                'title' => 'Alumni Magazine 2025',
                'category' => 'Alumni Magazine',
                'subtitle' => 'Celebrating Twenty Years of EDAA',
                'description' => 'Special anniversary edition commemorating two decades of alumni engagement, with retrospective features and a photo gallery of past events.',
                'author' => 'EDAA Editorial Board',
                'publisher' => 'English Department Alumni Association',
                'publication_date' => '2025-03-20',
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'title' => 'Department Performance Report 2024',
                'category' => 'Reports',
                'subtitle' => 'Academic Year 2023-2024',
                'description' => 'Annual performance review covering enrollment figures, research output, staff development, and strategic goals for the English Department.',
                'author' => 'Head of Department',
                'publisher' => 'English Department',
                'publication_date' => '2024-12-10',
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'title' => 'Conference Proceedings: Digital Humanities',
                'category' => 'Conference Proceedings',
                'subtitle' => 'EDAA Workshop 2024',
                'description' => 'Proceedings from the workshop on Digital Humanities and Literary Analysis, featuring papers on computational text analysis and digital archives.',
                'author' => 'Dr. Samuel Mensah',
                'publisher' => 'EDAA Research Division',
                'publication_date' => '2024-09-15',
                'status' => 'published',
                'is_featured' => false,
            ],
            [
                'title' => 'Alumni Newsletter: Winter 2024',
                'category' => 'Newsletter',
                'subtitle' => 'Year-End Wrap-Up',
                'description' => 'Final newsletter of 2024 summarising the year\'s highlights, member milestones, and plans for the coming year.',
                'author' => 'Kofi Adjei',
                'publisher' => 'EDAA Secretariat',
                'publication_date' => '2024-12-20',
                'status' => 'draft',
                'is_featured' => false,
            ],
            [
                'title' => 'Research Monograph: Gender in African Poetry',
                'category' => 'Research',
                'subtitle' => 'Working Paper Series',
                'description' => 'An in-depth study of gender representation in contemporary African poetry, examining themes of identity, power, and resistance.',
                'author' => 'Ngozi Eze',
                'publisher' => 'EDAA Research Division',
                'publication_date' => '2024-11-05',
                'status' => 'draft',
                'is_featured' => false,
            ],
            [
                'title' => 'Annual Report 2024',
                'category' => 'Annual Report',
                'subtitle' => 'Financial and Activity Summary',
                'description' => 'Detailed report on the department\'s financial performance, alumni contributions, and programme outcomes for the 2024 cycle.',
                'author' => 'Department Office',
                'publisher' => 'University Press',
                'publication_date' => '2025-02-01',
                'status' => 'draft',
                'is_featured' => false,
            ],
            [
                'title' => 'Department Magazine: Spring 2024',
                'category' => 'Department Magazine',
                'subtitle' => 'New Beginnings',
                'description' => 'Features on new faculty appointments, curriculum revisions, and the launch of the creative writing concentration.',
                'author' => 'Dr. Chidi Okonkwo',
                'publisher' => 'English Department',
                'publication_date' => '2024-03-25',
                'status' => 'draft',
                'is_featured' => false,
            ],
        ];

        foreach ($publications as $data) {
            $categoryId = PublicationCategory::where('name', $data['category'])->first()->id;

            Publication::create([
                'publication_category_id' => $categoryId,
                'title' => $data['title'],
                'slug' => Str::slug($data['title']),
                'subtitle' => $data['subtitle'],
                'description' => $data['description'],
                'cover_image' => null,
                'document_path' => null,
                'document_original_name' => null,
                'document_size' => null,
                'document_mime_type' => null,
                'author' => $data['author'],
                'publisher' => $data['publisher'],
                'publication_date' => $data['publication_date'],
                'status' => $data['status'],
                'is_featured' => $data['is_featured'],
                'sort_order' => 0,
            ]);
        }
    }
}
