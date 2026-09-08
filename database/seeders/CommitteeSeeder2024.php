<?php

namespace Database\Seeders;

use App\Models\Alumni;
use App\Models\Committee;
use App\Models\CommitteeRole;
use App\Models\CommitteeType;
use App\Models\Membership;
use App\Models\MembershipTier;
use App\Models\MembershipType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

/**
 * Seeds the full EDAA-KNGC Executive Committee 2024 (with 2026 updates).
 *
 * Creates for each member:
 *  1. Alumni record (profile with batch)
 *  2. User account (email + default password for login)
 *  3. Membership record (active, public)
 *  4. Committee role assignment
 *
 * Login credentials: email → edaa2024 (default, user can change)
 */
class CommitteeSeeder2024 extends Seeder
{
    private string $defaultPassword = 'edaa2024';

    public function run(): void
    {
        $this->command->info('Seeding EDAA-KNGC Full Committee 2024 (with 2026 updates)...');

        // ── Ensure required seeders run first ──────────────────────
        $this->call(MembershipTypeSeeder::class);
        $this->call(MembershipTierSeeder::class);

        $execType = CommitteeType::updateOrCreate(
            ['slug' => 'executive-committee'],
            [
                'name' => 'Executive Committee',
                'description' => 'The main governing body of the Alumni Association, responsible for policy decisions, event planning, and organizational oversight.',
                'is_active' => true,
                'sort_order' => 1,
            ]
        );

        $committee = Committee::updateOrCreate(
            ['slug' => 'executive-committee-2024'],
            [
                'committee_type_id' => $execType->id,
                'name' => 'Executive Committee 2024',
                'description' => 'Full committee elected in 2024 with 2026 updates. Ref: EDAA-KNGC 01/2024, dated 15-11-2024. Updated via Notice Ref. EDAA/2026/March9, dated 09 March 2026.',
                'start_year' => 2024,
                'end_year' => 2025,
                'is_current' => true,
                'sort_order' => 1,
            ]
        );

        // Unmark any other current committees of same type
        Committee::where('committee_type_id', $execType->id)
            ->where('is_current', true)
            ->where('id', '!=', $committee->id)
            ->update(['is_current' => false]);

        // ── Roles ──────────────────────────────────────────────────
        $roles = $this->seedRoles();

        // ── Committee Members ──────────────────────────────────────
        $members = $this->getCommitteeMembers();

        $types = MembershipType::query()->pluck('id', 'slug');
        $tiers = MembershipTier::query()->pluck('id', 'slug');
        $execTypeId = $types['executive-committee-member'] ?? $types['general-member'];

        $sortOrder = 1;
        $created = 0;
        $skipped = 0;

        foreach ($members as $member) {
            // 1. Create Alumni
            $alumni = Alumni::updateOrCreate(
                ['slug' => Alumni::uniqueSlug($member['full_name'])],
                [
                    'full_name' => $member['full_name'],
                    'student_id' => $member['student_id'],
                    'batch' => $member['batch'],
                    'session' => $member['session'],
                    'graduation_year' => $member['graduation_year'],
                    'degree' => 'BA English',
                    'email' => $member['email'],
                    'status' => Alumni::STATUS_ACTIVE,
                ]
            );

            // 2. Create User account (if not exists)
            $user = User::firstOrCreate(
                ['email' => $member['email']],
                [
                    'name' => $member['full_name'],
                    'password' => bcrypt($this->defaultPassword),
                    'is_admin' => false,
                    'alumni_id' => $alumni->id,
                    'status' => 'active',
                    'verified_at' => now(),
                ]
            );

            // Link alumni to user if not already linked
            if (! $user->alumni_id) {
                $user->update(['alumni_id' => $alumni->id]);
            }

            // 3. Create Membership (if not exists)
            $membership = $alumni->membership;
            if (! $membership) {
                $membership = Membership::create([
                    'alumni_id' => $alumni->id,
                    'membership_type_id' => $execTypeId,
                    'membership_tier_id' => $tiers['gold'] ?? null,
                    'membership_number' => Membership::generateMembershipNumber(),
                    'status' => Membership::STATUS_ACTIVE,
                    'joined_at' => '2024-11-15',
                    'approved_at' => '2024-11-15',
                    'is_public' => true,
                    'show_on_leaderboard' => true,
                    'notes' => 'Committee member — Ref: EDAA-KNGC 01/2024',
                ]);
            }

            // 4. Assign to Committee
            $roleSlug = $member['role_slug'];
            $roleId = $roles[$roleSlug] ?? null;

            if ($roleId) {
                DB::table('committee_pivot')->updateOrInsert(
                    [
                        'committee_id' => $committee->id,
                        'membership_id' => $membership->id,
                    ],
                    [
                        'committee_role_id' => $roleId,
                        'sort_order' => $sortOrder++,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]
                );
                $created++;
            } else {
                $this->command->warn("  Role not found: {$roleSlug} for {$member['full_name']}");
                $skipped++;
            }
        }

        $this->command->info("Done! {$created} committee members seeded. {$skipped} skipped.");
        $this->command->info("Default login password: {$this->defaultPassword}");
    }

    private function seedRoles(): array
    {
        $rolesData = [
            // Main roles (hierarchical order)
            ['name' => 'President', 'slug' => 'president', 'sort_order' => 1],
            ['name' => 'Senior Vice President', 'slug' => 'senior-vice-president', 'sort_order' => 2],
            ['name' => 'Vice President', 'slug' => 'vice-president', 'sort_order' => 3],
            ['name' => 'General Secretary', 'slug' => 'general-secretary', 'sort_order' => 4],
            ['name' => 'Senior Joint Secretary', 'slug' => 'senior-joint-secretary', 'sort_order' => 5],
            ['name' => 'Joint Secretary', 'slug' => 'joint-secretary', 'sort_order' => 6],
            ['name' => 'Organizing Secretary', 'slug' => 'organizing-secretary', 'sort_order' => 7],
            ['name' => 'Additional Organizing Secretary', 'slug' => 'additional-organizing-secretary', 'sort_order' => 8],
            ['name' => 'Deputy Organizing Secretary', 'slug' => 'deputy-organizing-secretary', 'sort_order' => 9],
            ['name' => 'Assistant Organizing Secretary', 'slug' => 'assistant-organizing-secretary', 'sort_order' => 10],
            ['name' => 'Office Secretary', 'slug' => 'office-secretary', 'sort_order' => 11],
            ['name' => 'Additional Office Secretary', 'slug' => 'additional-office-secretary', 'sort_order' => 12],
            ['name' => 'Deputy Office Secretary', 'slug' => 'deputy-office-secretary', 'sort_order' => 13],
            ['name' => 'Finance Secretary', 'slug' => 'finance-secretary', 'sort_order' => 14],
            ['name' => 'Additional Finance Secretary', 'slug' => 'additional-finance-secretary', 'sort_order' => 15],
            ['name' => 'Deputy Finance Secretary', 'slug' => 'deputy-finance-secretary', 'sort_order' => 16],
            ['name' => 'Assistant Financial Secretary', 'slug' => 'assistant-financial-secretary', 'sort_order' => 17],
            ['name' => 'Career Guide Line Secretary', 'slug' => 'career-guide-line-secretary', 'sort_order' => 18],
            ['name' => 'Additional Career Guide Line Secretary', 'slug' => 'additional-career-guide-line-secretary', 'sort_order' => 19],
            ['name' => 'Deputy Career Guide Line Secretary', 'slug' => 'deputy-career-guide-line-secretary', 'sort_order' => 20],
            ['name' => 'Marketing Secretary', 'slug' => 'marketing-secretary', 'sort_order' => 21],
            ['name' => 'Additional Marketing Secretary', 'slug' => 'additional-marketing-secretary', 'sort_order' => 22],
            ['name' => 'Deputy Marketing Secretary', 'slug' => 'deputy-marketing-secretary', 'sort_order' => 23],
            ['name' => 'Assistant Marketing Secretary', 'slug' => 'assistant-marketing-secretary', 'sort_order' => 24],
            ['name' => 'Law Secretary', 'slug' => 'law-secretary', 'sort_order' => 25],
            ['name' => 'Deputy Law Secretary', 'slug' => 'deputy-law-secretary', 'sort_order' => 26],
            ['name' => 'Welfare Management Secretary', 'slug' => 'welfare-management-secretary', 'sort_order' => 27],
            ['name' => 'Additional Welfare Management Secretary', 'slug' => 'additional-welfare-management-secretary', 'sort_order' => 28],
            ['name' => 'Deputy Welfare Management Secretary', 'slug' => 'deputy-welfare-management-secretary', 'sort_order' => 29],
            ['name' => 'Assistant Welfare Secretary', 'slug' => 'assistant-welfare-secretary', 'sort_order' => 30],
            ['name' => 'Library & Publication Secretary', 'slug' => 'library-publication-secretary', 'sort_order' => 31],
            ['name' => 'Deputy Library & Publication Secretary', 'slug' => 'deputy-library-publication-secretary', 'sort_order' => 32],
            ['name' => 'IT Secretary', 'slug' => 'it-secretary', 'sort_order' => 33],
            ['name' => 'Deputy IT Secretary', 'slug' => 'deputy-it-secretary', 'sort_order' => 34],
            ['name' => 'Education & Commerce Secretary', 'slug' => 'education-commerce-secretary', 'sort_order' => 35],
            ['name' => 'Additional Education & Commerce Secretary', 'slug' => 'additional-education-commerce-secretary', 'sort_order' => 36],
            ['name' => 'Deputy Education & Commerce Secretary', 'slug' => 'deputy-education-commerce-secretary', 'sort_order' => 37],
            ['name' => 'Women Secretary', 'slug' => 'women-secretary', 'sort_order' => 38],
            ['name' => 'Deputy Women Secretary', 'slug' => 'deputy-women-secretary', 'sort_order' => 39],
            ['name' => 'Sports & Cultural Secretary', 'slug' => 'sports-cultural-secretary', 'sort_order' => 40],
            ['name' => 'Deputy Sports & Cultural Secretary', 'slug' => 'deputy-sports-cultural-secretary', 'sort_order' => 41],
            ['name' => 'Religious Secretary', 'slug' => 'religious-secretary', 'sort_order' => 42],
            ['name' => 'Deputy Religious Secretary', 'slug' => 'deputy-religious-secretary', 'sort_order' => 43],
            ['name' => 'Executive Member', 'slug' => 'executive-member', 'sort_order' => 44],
        ];

        $roleIds = [];
        foreach ($rolesData as $role) {
            $record = CommitteeRole::updateOrCreate(
                ['slug' => $role['slug']],
                $role
            );
            $roleIds[$role['slug']] = $record->id;
        }

        return $roleIds;
    }

    private function getCommitteeMembers(): array
    {
        return [
            // ── PRESIDENT ──────────────────────────────────────────
            [
                'full_name' => 'Nahidur Rob Zico',
                'email' => 'nahidur.zico@edaa.kngc.edu',
                'batch' => '2002-03',
                'session' => '2002/2003',
                'graduation_year' => 2006,
                'student_id' => 'EN-2002001',
                'role_slug' => 'president',
            ],
            [
                'full_name' => 'Md. Jubair Abdullah',
                'email' => 'jubair.abdullah@edaa.kngc.edu',
                'batch' => '2002-03',
                'session' => '2002/2003',
                'graduation_year' => 2006,
                'student_id' => 'EN-2002002',
                'role_slug' => 'president',
            ],

            // ── GENERAL SECRETARY ──────────────────────────────────
            [
                'full_name' => 'Suman Miah',
                'email' => 'suman.miah@edaa.kngc.edu',
                'batch' => '2012-13',
                'session' => '2012/2013',
                'graduation_year' => 2016,
                'student_id' => 'EN-2012001',
                'role_slug' => 'general-secretary',
            ],

            // ── SENIOR VICE PRESIDENT ──────────────────────────────
            [
                'full_name' => 'Asaduzzaman Asad',
                'email' => 'asaduzzaman.asad@edaa.kngc.edu',
                'batch' => '2002-03',
                'session' => '2002/2003',
                'graduation_year' => 2006,
                'student_id' => 'EN-2002003',
                'role_slug' => 'senior-vice-president',
            ],

            // ── VICE PRESIDENT ─────────────────────────────────────
            [
                'full_name' => 'Nur Rashel',
                'email' => 'nur.rashel@edaa.kngc.edu',
                'batch' => '2007-08',
                'session' => '2007/2008',
                'graduation_year' => 2011,
                'student_id' => 'EN-2007001',
                'role_slug' => 'vice-president',
            ],
            [
                'full_name' => 'Mamun Khan',
                'email' => 'mamun.khan@edaa.kngc.edu',
                'batch' => '2008-09',
                'session' => '2008/2009',
                'graduation_year' => 2012,
                'student_id' => 'EN-2008001',
                'role_slug' => 'vice-president',
            ],

            // ── SENIOR JOINT SECRETARY ─────────────────────────────
            [
                'full_name' => 'Omar Khaium',
                'email' => 'omar.khaium@edaa.kngc.edu',
                'batch' => '2008-09',
                'session' => '2008/2009',
                'graduation_year' => 2012,
                'student_id' => 'EN-2008002',
                'role_slug' => 'senior-joint-secretary',
            ],
            [
                'full_name' => 'MD Palas',
                'email' => 'md.palas@edaa.kngc.edu',
                'batch' => '2009-10',
                'session' => '2009/2010',
                'graduation_year' => 2013,
                'student_id' => 'EN-2009001',
                'role_slug' => 'senior-joint-secretary',
            ],

            // ── JOINT SECRETARY ────────────────────────────────────
            [
                'full_name' => 'MD Rakib Hasan',
                'email' => 'rakib.hasan@edaa.kngc.edu',
                'batch' => '2011-12',
                'session' => '2011/2012',
                'graduation_year' => 2015,
                'student_id' => 'EN-2011001',
                'role_slug' => 'joint-secretary',
            ],
            [
                'full_name' => 'Nigar Sultana',
                'email' => 'nigar.sultana@edaa.kngc.edu',
                'batch' => '2011-12',
                'session' => '2011/2012',
                'graduation_year' => 2015,
                'student_id' => 'EN-2011002',
                'role_slug' => 'joint-secretary',
            ],
            [
                'full_name' => 'MD Anisur Rahman Sifat',
                'email' => 'anisur.sifat@edaa.kngc.edu',
                'batch' => '2012-13',
                'session' => '2012/2013',
                'graduation_year' => 2016,
                'student_id' => 'EN-2012002',
                'role_slug' => 'joint-secretary',
            ],
            [
                'full_name' => 'MD Rokibul Hasan',
                'email' => 'rokibul.hasan@edaa.kngc.edu',
                'batch' => '2012-13',
                'session' => '2012/2013',
                'graduation_year' => 2016,
                'student_id' => 'EN-2012003',
                'role_slug' => 'joint-secretary',
            ],

            // ── ORGANIZING SECRETARY ───────────────────────────────
            [
                'full_name' => 'MD. Yousuf Howlader',
                'email' => 'yousuf.howlader@edaa.kngc.edu',
                'batch' => '2011-12',
                'session' => '2011/2012',
                'graduation_year' => 2015,
                'student_id' => 'EN-2011003',
                'role_slug' => 'organizing-secretary',
            ],

            // ── ADDITIONAL ORGANIZING SECRETARY ────────────────────
            [
                'full_name' => 'Zannatul Ferdous Riya',
                'email' => 'zannatul.riya@edaa.kngc.edu',
                'batch' => '2012-13',
                'session' => '2012/2013',
                'graduation_year' => 2016,
                'student_id' => 'EN-2012004',
                'role_slug' => 'additional-organizing-secretary',
            ],
            [
                'full_name' => 'MD. Naym Uddin',
                'email' => 'naym.uddin@edaa.kngc.edu',
                'batch' => '2012-13',
                'session' => '2012/2013',
                'graduation_year' => 2016,
                'student_id' => 'EN-2012005',
                'role_slug' => 'additional-organizing-secretary',
            ],

            // ── DEPUTY ORGANIZING SECRETARY ────────────────────────
            [
                'full_name' => 'Robiul Hasan Murad',
                'email' => 'robiul.murad@edaa.kngc.edu',
                'batch' => '2015-16',
                'session' => '2015/2016',
                'graduation_year' => 2019,
                'student_id' => 'EN-2015001',
                'role_slug' => 'deputy-organizing-secretary',
            ],
            [
                'full_name' => 'MD Shydur Rahman',
                'email' => 'shydur.rahman@edaa.kngc.edu',
                'batch' => '2016-17',
                'session' => '2016/2017',
                'graduation_year' => 2020,
                'student_id' => 'EN-2016001',
                'role_slug' => 'deputy-organizing-secretary',
            ],

            // ── ASSISTANT ORGANIZING SECRETARY ─────────────────────
            [
                'full_name' => 'Shohag Parvez',
                'email' => 'shohag.parvez@edaa.kngc.edu',
                'batch' => '2011-12',
                'session' => '2011/2012',
                'graduation_year' => 2015,
                'student_id' => 'EN-2011004',
                'role_slug' => 'assistant-organizing-secretary',
            ],

            // ── OFFICE SECRETARY ───────────────────────────────────
            [
                'full_name' => 'MD Akhter Uj Jaman',
                'email' => 'akhter.jaman@edaa.kngc.edu',
                'batch' => '2012-13',
                'session' => '2012/2013',
                'graduation_year' => 2016,
                'student_id' => 'EN-2012006',
                'role_slug' => 'office-secretary',
            ],

            // ── ADDITIONAL OFFICE SECRETARY ────────────────────────
            [
                'full_name' => 'MD Sabbir Hossen',
                'email' => 'sabbir.hossen@edaa.kngc.edu',
                'batch' => '2017-18',
                'session' => '2017/2018',
                'graduation_year' => 2021,
                'student_id' => 'EN-2017001',
                'role_slug' => 'additional-office-secretary',
            ],

            // ── DEPUTY OFFICE SECRETARY ────────────────────────────
            [
                'full_name' => 'Sayma Sultana Snigdha',
                'email' => 'sayma.snigdha@edaa.kngc.edu',
                'batch' => '2018-19',
                'session' => '2018/2019',
                'graduation_year' => 2022,
                'student_id' => 'EN-2018001',
                'role_slug' => 'deputy-office-secretary',
            ],

            // ── FINANCE SECRETARY ──────────────────────────────────
            [
                'full_name' => 'SM Limon',
                'email' => 'sm.limon@edaa.kngc.edu',
                'batch' => '2017-18',
                'session' => '2017/2018',
                'graduation_year' => 2021,
                'student_id' => 'EN-2017002',
                'role_slug' => 'finance-secretary',
            ],

            // ── ADDITIONAL FINANCE SECRETARY ───────────────────────
            [
                'full_name' => 'Monjurul Islam',
                'email' => 'monjurul.islam@edaa.kngc.edu',
                'batch' => '2013-14',
                'session' => '2013/2014',
                'graduation_year' => 2017,
                'student_id' => 'EN-2013001',
                'role_slug' => 'additional-finance-secretary',
            ],

            // ── DEPUTY FINANCE SECRETARY ───────────────────────────
            [
                'full_name' => 'MD. Tariqul Islam (Sayem)',
                'email' => 'tariqul.sayem@edaa.kngc.edu',
                'batch' => '2017-18',
                'session' => '2017/2018',
                'graduation_year' => 2021,
                'student_id' => 'EN-2017003',
                'role_slug' => 'deputy-finance-secretary',
            ],

            // ── ASSISTANT FINANCIAL SECRETARY ──────────────────────
            [
                'full_name' => 'Md. Abu Sayeed Pranto',
                'email' => 'abu.pranto@edaa.kngc.edu',
                'batch' => '2018-19',
                'session' => '2018/2019',
                'graduation_year' => 2022,
                'student_id' => 'EN-2018002',
                'role_slug' => 'assistant-financial-secretary',
            ],

            // ── CAREER GUIDE LINE SECRETARY ────────────────────────
            [
                'full_name' => 'Iftekhar Ovi',
                'email' => 'iftekhar.ovi@edaa.kngc.edu',
                'batch' => '2007-08',
                'session' => '2007/2008',
                'graduation_year' => 2011,
                'student_id' => 'EN-2007002',
                'role_slug' => 'career-guide-line-secretary',
            ],

            // ── ADDITIONAL CAREER GUIDE LINE SECRETARY ─────────────
            [
                'full_name' => 'Khairul Alam',
                'email' => 'khairul.alam@edaa.kngc.edu',
                'batch' => '2010-11',
                'session' => '2010/2011',
                'graduation_year' => 2014,
                'student_id' => 'EN-2010001',
                'role_slug' => 'additional-career-guide-line-secretary',
            ],

            // ── DEPUTY CAREER GUIDE LINE SECRETARY ─────────────────
            [
                'full_name' => 'MD Munirul Islam',
                'email' => 'munirul.islam@edaa.kngc.edu',
                'batch' => '2011-12',
                'session' => '2011/2012',
                'graduation_year' => 2015,
                'student_id' => 'EN-2011005',
                'role_slug' => 'deputy-career-guide-line-secretary',
            ],

            // ── MARKETING SECRETARY ────────────────────────────────
            [
                'full_name' => 'MD. Shihab Ahmed',
                'email' => 'shihab.ahmed@edaa.kngc.edu',
                'batch' => '2014-15',
                'session' => '2014/2015',
                'graduation_year' => 2018,
                'student_id' => 'EN-2014001',
                'role_slug' => 'marketing-secretary',
            ],

            // ── ADDITIONAL MARKETING SECRETARY ─────────────────────
            [
                'full_name' => 'MD. Noyon Islam',
                'email' => 'noyon.islam@edaa.kngc.edu',
                'batch' => '2015-16',
                'session' => '2015/2016',
                'graduation_year' => 2019,
                'student_id' => 'EN-2015002',
                'role_slug' => 'additional-marketing-secretary',
            ],

            // ── DEPUTY MARKETING SECRETARY ─────────────────────────
            [
                'full_name' => 'Afrina Hossain Bristy',
                'email' => 'afrina.bristy@edaa.kngc.edu',
                'batch' => '2017-18',
                'session' => '2017/2018',
                'graduation_year' => 2021,
                'student_id' => 'EN-2017004',
                'role_slug' => 'deputy-marketing-secretary',
            ],

            // ── ASSISTANT MARKETING SECRETARY ──────────────────────
            [
                'full_name' => 'Sanbir Hridoy',
                'email' => 'sanbir.hridoy@edaa.kngc.edu',
                'batch' => '2019-20',
                'session' => '2019/2020',
                'graduation_year' => 2023,
                'student_id' => 'EN-2019001',
                'role_slug' => 'assistant-marketing-secretary',
            ],

            // ── LAW SECRETARY ──────────────────────────────────────
            [
                'full_name' => 'Fayzur Rahman',
                'email' => 'fayzur.rahman@edaa.kngc.edu',
                'batch' => '2009-10',
                'session' => '2009/2010',
                'graduation_year' => 2013,
                'student_id' => 'EN-2009002',
                'role_slug' => 'law-secretary',
            ],

            // ── DEPUTY LAW SECRETARY ───────────────────────────────
            [
                'full_name' => 'Apu Mallik',
                'email' => 'apu.mallik@edaa.kngc.edu',
                'batch' => '2011-12',
                'session' => '2011/2012',
                'graduation_year' => 2015,
                'student_id' => 'EN-2011006',
                'role_slug' => 'deputy-law-secretary',
            ],

            // ── WELFARE MANAGEMENT SECRETARY ───────────────────────
            [
                'full_name' => 'MD. Ismail Hossain Biddut',
                'email' => 'ismail.biddut@edaa.kngc.edu',
                'batch' => '2008-09',
                'session' => '2008/2009',
                'graduation_year' => 2012,
                'student_id' => 'EN-2008003',
                'role_slug' => 'welfare-management-secretary',
            ],

            // ── ADDITIONAL WELFARE MANAGEMENT SECRETARY ────────────
            [
                'full_name' => 'Anirban Sarkar',
                'email' => 'anirban.sarkar@edaa.kngc.edu',
                'batch' => '2013-14',
                'session' => '2013/2014',
                'graduation_year' => 2017,
                'student_id' => 'EN-2013002',
                'role_slug' => 'additional-welfare-management-secretary',
            ],

            // ── DEPUTY WELFARE MANAGEMENT SECRETARY ────────────────
            [
                'full_name' => 'Tuhin Mia',
                'email' => 'tuhin.mia@edaa.kngc.edu',
                'batch' => '2014-15',
                'session' => '2014/2015',
                'graduation_year' => 2018,
                'student_id' => 'EN-2014002',
                'role_slug' => 'deputy-welfare-management-secretary',
            ],

            // ── ASSISTANT WELFARE SECRETARY ────────────────────────
            [
                'full_name' => 'Farid Ahmed',
                'email' => 'farid.ahmed@edaa.kngc.edu',
                'batch' => '2018-19',
                'session' => '2018/2019',
                'graduation_year' => 2022,
                'student_id' => 'EN-2018003',
                'role_slug' => 'assistant-welfare-secretary',
            ],

            // ── LIBRARY & PUBLICATION SECRETARY ────────────────────
            [
                'full_name' => 'Abdullah Ahad Milon',
                'email' => 'abdullah.milon@edaa.kngc.edu',
                'batch' => '2017-18',
                'session' => '2017/2018',
                'graduation_year' => 2021,
                'student_id' => 'EN-2017005',
                'role_slug' => 'library-publication-secretary',
            ],

            // ── DEPUTY LIBRARY & PUBLICATION SECRETARY ─────────────
            [
                'full_name' => 'Nasim Ali Khan',
                'email' => 'nasim.khan@edaa.kngc.edu',
                'batch' => '2017-18',
                'session' => '2017/2018',
                'graduation_year' => 2021,
                'student_id' => 'EN-2017006',
                'role_slug' => 'deputy-library-publication-secretary',
            ],

            // ── IT SECRETARY ───────────────────────────────────────
            [
                'full_name' => 'MD Anisur Rahman Shoaib',
                'email' => 'anisur.shoaib@edaa.kngc.edu',
                'batch' => '2007-08',
                'session' => '2007/2008',
                'graduation_year' => 2011,
                'student_id' => 'EN-2007003',
                'role_slug' => 'it-secretary',
            ],

            // ── DEPUTY IT SECRETARY ────────────────────────────────
            [
                'full_name' => 'Johirul Islam Shovon',
                'email' => 'johirul.shovon@edaa.kngc.edu',
                'batch' => '2018-19',
                'session' => '2018/2019',
                'graduation_year' => 2022,
                'student_id' => 'EN-2018004',
                'role_slug' => 'deputy-it-secretary',
            ],

            // ── EDUCATION & COMMERCE SECRETARY ─────────────────────
            [
                'full_name' => 'Juthi Dhar',
                'email' => 'juthi.dhar@edaa.kngc.edu',
                'batch' => '2008-09',
                'session' => '2008/2009',
                'graduation_year' => 2012,
                'student_id' => 'EN-2008004',
                'role_slug' => 'education-commerce-secretary',
            ],

            // ── ADDITIONAL EDUCATION & COMMERCE SECRETARY ──────────
            [
                'full_name' => 'MD. Abu Salam Miah',
                'email' => 'abu.salam@edaa.kngc.edu',
                'batch' => '2010-11',
                'session' => '2010/2011',
                'graduation_year' => 2014,
                'student_id' => 'EN-2010002',
                'role_slug' => 'additional-education-commerce-secretary',
            ],

            // ── DEPUTY EDUCATION & COMMERCE SECRETARY ──────────────
            [
                'full_name' => 'Nurjahan Rahman Shikha',
                'email' => 'nurjahan.shikha@edaa.kngc.edu',
                'batch' => '2014-15',
                'session' => '2014/2015',
                'graduation_year' => 2018,
                'student_id' => 'EN-2014003',
                'role_slug' => 'deputy-education-commerce-secretary',
            ],

            // ── WOMEN SECRETARY ────────────────────────────────────
            [
                'full_name' => 'Nusrat Jahan',
                'email' => 'nusrat.jahan@edaa.kngc.edu',
                'batch' => '2010-11',
                'session' => '2010/2011',
                'graduation_year' => 2014,
                'student_id' => 'EN-2010003',
                'role_slug' => 'women-secretary',
            ],

            // ── DEPUTY WOMEN SECRETARY ─────────────────────────────
            [
                'full_name' => 'Ananna Ahmed',
                'email' => 'ananna.ahmed@edaa.kngc.edu',
                'batch' => '2013-14',
                'session' => '2013/2014',
                'graduation_year' => 2017,
                'student_id' => 'EN-2013003',
                'role_slug' => 'deputy-women-secretary',
            ],

            // ── SPORTS & CULTURAL SECRETARY ────────────────────────
            [
                'full_name' => 'Nazmun Nahar',
                'email' => 'nazmun.nahar@edaa.kngc.edu',
                'batch' => '2009-10',
                'session' => '2009/2010',
                'graduation_year' => 2013,
                'student_id' => 'EN-2009003',
                'role_slug' => 'sports-cultural-secretary',
            ],

            // ── DEPUTY SPORTS & CULTURAL SECRETARY ─────────────────
            [
                'full_name' => 'MD Hasan Al-Farabi',
                'email' => 'hasan.farabi@edaa.kngc.edu',
                'batch' => '2016-17',
                'session' => '2016/2017',
                'graduation_year' => 2020,
                'student_id' => 'EN-2016002',
                'role_slug' => 'deputy-sports-cultural-secretary',
            ],

            // ── RELIGIOUS SECRETARY ────────────────────────────────
            [
                'full_name' => 'Abu Shiddiq Emon',
                'email' => 'shiddiq.emon@edaa.kngc.edu',
                'batch' => '2016-17',
                'session' => '2016/2017',
                'graduation_year' => 2020,
                'student_id' => 'EN-2016003',
                'role_slug' => 'religious-secretary',
            ],

            // ── DEPUTY RELIGIOUS SECRETARY ─────────────────────────
            [
                'full_name' => 'Meghla Chakraborty',
                'email' => 'meghla.chakraborty@edaa.kngc.edu',
                'batch' => '2015-16',
                'session' => '2015/2016',
                'graduation_year' => 2019,
                'student_id' => 'EN-2015003',
                'role_slug' => 'deputy-religious-secretary',
            ],

            // ── EXECUTIVE MEMBERS (2026 INDUCTION) ─────────────────
            [
                'full_name' => 'Fahim Hasan',
                'email' => 'fahim.hasan@edaa.kngc.edu',
                'batch' => '2020-21',
                'session' => '2020/2021',
                'graduation_year' => 2024,
                'student_id' => 'EN-2020001',
                'role_slug' => 'executive-member',
            ],
            [
                'full_name' => 'Rayhan Hossain',
                'email' => 'rayhan.hossain@edaa.kngc.edu',
                'batch' => '2020-21',
                'session' => '2020/2021',
                'graduation_year' => 2024,
                'student_id' => 'EN-2020002',
                'role_slug' => 'executive-member',
            ],
            [
                'full_name' => 'Muen Islam Akib',
                'email' => 'muen.akib@edaa.kngc.edu',
                'batch' => '2020-21',
                'session' => '2020/2021',
                'graduation_year' => 2024,
                'student_id' => 'EN-2020003',
                'role_slug' => 'executive-member',
            ],
        ];
    }
}
