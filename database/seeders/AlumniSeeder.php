<?php

namespace Database\Seeders;

use App\Models\Alumni;
use Illuminate\Database\Seeder;

class AlumniSeeder extends Seeder
{
    /**
     * Seed the alumni directory.
     */
    public function run(): void
    {
        if (Alumni::exists()) {
            return;
        }

        $featured = [
            [
                'full_name' => 'Adaeze Okafor',
                'student_id' => 'EN-2010001',
                'batch' => '2010',
                'session' => '2010/2011',
                'graduation_year' => 2014,
                'degree' => 'BA English and Literary Studies',
                'designation' => 'Publishing Manager',
                'organization' => 'Harborline Publishers',
                'profession' => 'Publishing',
                'city' => 'Lagos',
                'country' => 'Nigeria',
                'bio' => 'Adaeze has spent over a decade championing African literature from the editing desk. She leads a team that publishes new voices across fiction, poetry and literary criticism, and mentors young editors through the association\'s publishing mentorship track.',
                'linkedin_url' => 'https://www.linkedin.com/in/adaeze-okafor',
                'website_url' => 'https://harborline.example.com',
                'is_featured' => true,
                'sort_order' => 1,
            ],
            [
                'full_name' => 'Kwame Mensah',
                'student_id' => 'EN-1998017',
                'batch' => '1998',
                'session' => '1998/1999',
                'graduation_year' => 2002,
                'degree' => 'BA English',
                'designation' => 'Senior Lecturer',
                'organization' => 'University of Cape Coast',
                'profession' => 'Academia',
                'city' => 'Accra',
                'country' => 'Ghana',
                'bio' => 'Kwame teaches postcolonial literature and creative writing. His research on narrative form has appeared in several international journals, and he coordinates the university\'s annual literary arts festival.',
                'linkedin_url' => 'https://www.linkedin.com/in/kwame-mensah',
                'is_featured' => true,
                'sort_order' => 2,
            ],
            [
                'full_name' => 'Halima Balogun',
                'student_id' => 'EN-2006012',
                'batch' => '2006',
                'session' => '2006/2007',
                'graduation_year' => 2010,
                'degree' => 'BA English Language',
                'designation' => 'Broadcast Producer',
                'organization' => 'Nova Broadcasting',
                'profession' => 'Media & Journalism',
                'city' => 'Nairobi',
                'country' => 'Kenya',
                'bio' => 'Halima produces documentary programming that gives voice to grassroots storytellers. Her work on language preservation in East Africa has won two regional media awards.',
                'linkedin_url' => 'https://www.linkedin.com/in/halima-balogun',
                'is_featured' => true,
                'sort_order' => 3,
            ],
            [
                'full_name' => 'Chidi Eze',
                'student_id' => 'EN-2003033',
                'batch' => '2003',
                'session' => '2003/2004',
                'graduation_year' => 2007,
                'degree' => 'MA English',
                'designation' => 'Poet & Literary Agent',
                'organization' => 'Atlas Literary Review',
                'profession' => 'Arts & Culture',
                'city' => 'London',
                'country' => 'United Kingdom',
                'bio' => 'Chidi is a poet and literary agent representing emerging writers from the diaspora. His debut collection was shortlisted for a major African literary prize.',
                'linkedin_url' => 'https://www.linkedin.com/in/chidi-eze',
                'website_url' => 'https://chidieze.example.com',
                'is_featured' => true,
                'sort_order' => 4,
            ],
            [
                'full_name' => 'Fatima Haddad',
                'student_id' => 'EN-1992039',
                'batch' => '1992',
                'session' => '1992/1993',
                'graduation_year' => 1996,
                'degree' => 'BA Literature in English',
                'designation' => 'National Archivist',
                'organization' => 'National Library Service',
                'profession' => 'Public Service',
                'city' => 'Cairo',
                'country' => 'Egypt',
                'bio' => 'Fatima leads the digital preservation unit at the national library, safeguarding the written record of the region for future generations of scholars and citizens.',
                'linkedin_url' => 'https://www.linkedin.com/in/fatima-haddad',
                'is_featured' => true,
                'sort_order' => 5,
            ],
        ];

        foreach ($featured as $record) {
            $record['email'] = strtolower(str_replace(' ', '.', $record['full_name'])).'@example.org';
            $record['status'] = Alumni::STATUS_ACTIVE;

            Alumni::create([
                ...$record,
                'slug' => Alumni::uniqueSlug($record['full_name']),
            ]);
        }

        Alumni::factory()
            ->count(13)
            ->create();
    }
}
