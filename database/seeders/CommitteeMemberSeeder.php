<?php

namespace Database\Seeders;

use App\Models\CommitteeMember;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CommitteeMemberSeeder extends Seeder
{
    /**
     * Seed the EDAA-KNGC Full Committee 2024 (with 09 March 2026 updates).
     *
     * Ref. EDAA-KNGC 01/2024 (dated 15-11-2024) and Ref. EDAA/2026/March9 (dated 09-03-2026).
     */
    public function run(): void
    {
        $members = [
            // President
            [
                'name' => 'Nahidur Rob Zico',
                'position' => 'President',
                'short_bio' => 'Batch of 2002-03. Newly appointed President — Notice dated 09 March 2026.',
            ],
            [
                'name' => 'Suman Miah',
                'position' => 'General Secretary',
                'short_bio' => 'Batch of 2012-13. Signatory to both the 2024 and 2026 committee notices.',
            ],
            [
                'name' => 'Md. Jubair Abdullah',
                'position' => 'Immediate Past President',
                'short_bio' => 'President in the 2024 Committee Notice (Ref. EDAA-KNGC 01/2024, dated 15-11-2024).',
            ],

            // Senior Vice President / Vice Presidents
            [
                'name' => 'Asaduzzaman Asad',
                'position' => 'Senior Vice President',
                'short_bio' => 'Batch of 2002-03.',
            ],
            [
                'name' => 'Nur Rashel',
                'position' => 'Vice President',
                'short_bio' => 'Batch of 2007-08.',
            ],
            [
                'name' => 'Mamun Khan',
                'position' => 'Vice President',
                'short_bio' => 'Batch of 2008-09. Newly appointed — Notice dated 09 March 2026.',
            ],

            // Senior Joint Secretaries
            [
                'name' => 'Omar Khaium',
                'position' => 'Senior Joint Secretary',
                'short_bio' => 'Batch of 2008-09.',
            ],
            [
                'name' => 'MD Palas',
                'position' => 'Senior Joint Secretary',
                'short_bio' => 'Batch of 2009-10.',
            ],

            // Joint Secretaries
            [
                'name' => 'MD Rakib Hasan',
                'position' => 'Joint Secretary',
                'short_bio' => 'Batch of 2011-12.',
            ],
            [
                'name' => 'Nigar Sultana',
                'position' => 'Joint Secretary',
                'short_bio' => 'Batch of 2011-12.',
            ],
            [
                'name' => 'MD Anisur Rahman Sifat',
                'position' => 'Joint Secretary',
                'short_bio' => 'Batch of 2012-13.',
            ],
            [
                'name' => 'MD Rokibul Hasan',
                'position' => 'Joint Secretary',
                'short_bio' => 'Batch of 2012-13.',
            ],

            // Organizing Secretariat
            [
                'name' => 'MD. Yousuf Howlader',
                'position' => 'Organizing Secretary',
                'short_bio' => 'Batch of 2011-12.',
            ],
            [
                'name' => 'Zannatul Ferdous Riya',
                'position' => 'Additional Organizing Secretary',
                'short_bio' => 'Batch of 2012-13.',
            ],
            [
                'name' => 'MD. Naym Uddin',
                'position' => 'Additional Organizing Secretary',
                'short_bio' => 'Batch of 2012-13.',
            ],
            [
                'name' => 'Robiul Hasan Murad',
                'position' => 'Deputy Organizing Secretary',
                'short_bio' => 'Batch of 2015-16.',
            ],
            [
                'name' => 'MD Shydur Rahman',
                'position' => 'Deputy Organizing Secretary',
                'short_bio' => 'Batch of 2016-17.',
            ],
            [
                'name' => 'Shohag Parvez',
                'position' => 'Assistant Organizing Secretary',
                'short_bio' => 'Batch of 2011-12. Newly appointed — Notice dated 09 March 2026.',
            ],

            // Office Secretariat
            [
                'name' => 'MD Akhter Uj Jaman',
                'position' => 'Office Secretary',
                'short_bio' => 'Batch of 2012-13.',
            ],
            [
                'name' => 'MD Sabbir Hossen',
                'position' => 'Additional Office Secretary',
                'short_bio' => 'Batch of 2017-18.',
            ],
            [
                'name' => 'Sayma Sultana Snigdha',
                'position' => 'Deputy Office Secretary',
                'short_bio' => 'Batch of 2018-19.',
            ],

            // Finance Secretariat
            [
                'name' => 'SM Limon',
                'position' => 'Finance Secretary',
                'short_bio' => 'Batch of 2017-18.',
            ],
            [
                'name' => 'Monjurul Islam',
                'position' => 'Additional Finance Secretary',
                'short_bio' => 'Batch of 2013-14.',
            ],
            [
                'name' => 'MD. Tariqul Islam (Sayem)',
                'position' => 'Deputy Finance Secretary',
                'short_bio' => 'Batch of 2017-18.',
            ],
            [
                'name' => 'Md. Abu Sayeed Pranto',
                'position' => 'Assistant Financial Secretary',
                'short_bio' => 'Batch of 2018-19. Newly appointed — Notice dated 09 March 2026.',
            ],

            // Career Guide Line Secretariat
            [
                'name' => 'Iftekhar Ovi',
                'position' => 'Career Guide Line Secretary',
                'short_bio' => 'Batch of 2007-08.',
            ],
            [
                'name' => 'Khairul Alam',
                'position' => 'Additional Career Guide Line Secretary',
                'short_bio' => 'Batch of 2010-11.',
            ],
            [
                'name' => 'MD Munirul Islam',
                'position' => 'Deputy Career Guide Line Secretary',
                'short_bio' => 'Batch of 2011-12.',
            ],

            // Marketing Secretariat
            [
                'name' => 'MD. Shihab Ahmed',
                'position' => 'Marketing Secretary',
                'short_bio' => 'Batch of 2014-15.',
            ],
            [
                'name' => 'MD. Noyon Islam',
                'position' => 'Additional Marketing Secretary',
                'short_bio' => 'Batch of 2015-16.',
            ],
            [
                'name' => 'Afrina Hossain Bristy',
                'position' => 'Deputy Marketing Secretary',
                'short_bio' => 'Batch of 2017-18.',
            ],
            [
                'name' => 'Sanbir Hridoy',
                'position' => 'Assistant Marketing Secretary',
                'short_bio' => 'Batch of 2019-20. Newly appointed — Notice dated 09 March 2026.',
            ],

            // Law Secretariat
            [
                'name' => 'Fayzur Rahman',
                'position' => 'Law Secretary',
                'short_bio' => 'Batch of 2009-10.',
            ],
            [
                'name' => 'Apu Mallik',
                'position' => 'Deputy Law Secretary',
                'short_bio' => 'Batch of 2011-12.',
            ],

            // Welfare Secretariat
            [
                'name' => 'MD. Ismail Hossain Biddut',
                'position' => 'Welfare Management Secretary',
                'short_bio' => 'Batch of 2008-09.',
            ],
            [
                'name' => 'Anirban Sarkar',
                'position' => 'Additional Welfare Management Secretary',
                'short_bio' => 'Batch of 2013-14.',
            ],
            [
                'name' => 'Tuhin Mia',
                'position' => 'Deputy Welfare Management Secretary',
                'short_bio' => 'Batch of 2014-15.',
            ],
            [
                'name' => 'Farid Ahmed',
                'position' => 'Assistant Welfare Secretary',
                'short_bio' => 'Batch of 2018-19. Newly appointed — Notice dated 09 March 2026.',
            ],

            // Library & Publication Secretariat
            [
                'name' => 'Abdullah Ahad Milon',
                'position' => 'Library & Publication Secretary',
                'short_bio' => 'Batch of 2017-18.',
            ],
            [
                'name' => 'Nasim Ali Khan',
                'position' => 'Deputy Library & Publication Secretary',
                'short_bio' => 'Batch of 2017-18.',
            ],

            // IT Secretariat
            [
                'name' => 'MD Anisur Rahman Shoaib',
                'position' => 'IT Secretary',
                'short_bio' => 'Batch of 2007-08.',
            ],
            [
                'name' => 'Johirul Islam Shovon',
                'position' => 'Deputy IT Secretary',
                'short_bio' => 'Batch of 2018-19.',
            ],

            // Education & Commerce Secretariat
            [
                'name' => 'Juthi Dhar',
                'position' => 'Education & Commerce Secretary',
                'short_bio' => 'Batch of 2008-09.',
            ],
            [
                'name' => 'MD. Abu Salam Miah',
                'position' => 'Additional Education & Commerce Secretary',
                'short_bio' => 'Batch of 2010-11.',
            ],
            [
                'name' => 'Nurjahan Rahman Shikha',
                'position' => 'Deputy Education & Commerce Secretary',
                'short_bio' => 'Batch of 2014-15.',
            ],

            // Women Secretariat
            [
                'name' => 'Nusrat Jahan',
                'position' => 'Women Secretary',
                'short_bio' => 'Batch of 2010-11.',
            ],
            [
                'name' => 'Ananna Ahmed',
                'position' => 'Deputy Women Secretary',
                'short_bio' => 'Batch of 2013-14.',
            ],

            // Sports & Cultural Secretariat
            [
                'name' => 'Nazmun Nahar',
                'position' => 'Sports & Cultural Secretary',
                'short_bio' => 'Batch of 2009-10.',
            ],
            [
                'name' => 'MD Hasan Al-Farabi',
                'position' => 'Deputy Sports & Cultural Secretary',
                'short_bio' => 'Batch of 2016-17.',
            ],

            // Religious Secretariat
            [
                'name' => 'Abu Shiddiq Emon',
                'position' => 'Religious Secretary',
                'short_bio' => 'Batch of 2016-17.',
            ],
            [
                'name' => 'Meghla Chakraborty',
                'position' => 'Deputy Religious Secretary',
                'short_bio' => 'Batch of 2015-16.',
            ],

            // Executive Members (2026 Induction)
            [
                'name' => 'Fahim Hasan',
                'position' => 'Executive Member',
                'short_bio' => 'Batch of 2020-21. Inducted — Notice dated 09 March 2026.',
            ],
            [
                'name' => 'Rayhan Hossain',
                'position' => 'Executive Member',
                'short_bio' => 'Batch of 2020-21. Inducted — Notice dated 09 March 2026.',
            ],
            [
                'name' => 'Muen Islam Akib',
                'position' => 'Executive Member',
                'short_bio' => 'Batch of 2020-21. Inducted — Notice dated 09 March 2026.',
            ],
        ];

        foreach ($members as $index => $record) {
            CommitteeMember::updateOrCreate(
                ['slug' => Str::slug($record['name'])],
                [
                    'name' => $record['name'],
                    'position' => $record['position'],
                    'short_bio' => $record['short_bio'],
                    'sort_order' => $index + 1,
                    'is_active' => true,
                ]
            );
        }
    }
}
