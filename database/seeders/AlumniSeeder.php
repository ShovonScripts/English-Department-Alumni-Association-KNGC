<?php

namespace Database\Seeders;

use App\Models\Alumni;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class AlumniSeeder extends Seeder
{
    public function run(): void
    {
        $alumni = [
            ['full_name' => 'Chidi Eze', 'student_id' => 'EN-2010001', 'batch' => '2010-11', 'session' => '2010/2011', 'graduation_year' => 2014, 'email' => 'chidi.eze@example.org', 'city' => 'Lagos', 'country' => 'Nigeria', 'profession' => 'Academia', 'organization' => 'University of Lagos', 'designation' => 'Associate Professor', 'status' => Alumni::STATUS_ACTIVE, 'is_featured' => false],
            ['full_name' => 'Adaeze Okafor', 'student_id' => 'EN-2012001', 'batch' => '2012-13', 'session' => '2012/2013', 'graduation_year' => 2016, 'email' => 'adaeze.okafor@example.org', 'city' => 'Abuja', 'country' => 'Nigeria', 'profession' => 'Media & Journalism', 'organization' => 'Daily Trust', 'designation' => 'Senior Editor', 'status' => Alumni::STATUS_ACTIVE, 'is_featured' => false],
            ['full_name' => 'Halima Balogun', 'student_id' => 'EN-2014001', 'batch' => '2014-15', 'session' => '2014/2015', 'graduation_year' => 2018, 'email' => 'halima.balogun@example.org', 'city' => 'Ibadan', 'country' => 'Nigeria', 'profession' => 'Education', 'organization' => 'University of Ibadan', 'designation' => 'Lecturer', 'status' => Alumni::STATUS_ACTIVE, 'is_featured' => false],
            ['full_name' => 'Kwame Mensah', 'student_id' => 'EN-2011001', 'batch' => '2011-12', 'session' => '2011/2012', 'graduation_year' => 2015, 'email' => 'kwame.mensah@example.org', 'city' => 'Accra', 'country' => 'Ghana', 'profession' => 'Publishing', 'organization' => 'Sub-Saharan Publishers', 'designation' => 'Managing Editor', 'status' => Alumni::STATUS_ACTIVE, 'is_featured' => false],
            ['full_name' => 'Fatima Haddad', 'student_id' => 'EN-2013001', 'batch' => '2013-14', 'session' => '2013/2014', 'graduation_year' => 2017, 'email' => 'fatima.haddad@example.org', 'city' => 'Dhaka', 'country' => 'Bangladesh', 'profession' => 'NGO', 'organization' => 'BRAC', 'designation' => 'Programme Officer', 'status' => Alumni::STATUS_ACTIVE, 'is_featured' => false],
            ['full_name' => 'Tunde Balogun', 'student_id' => 'EN-2015001', 'batch' => '2015-16', 'session' => '2015/2016', 'graduation_year' => 2019, 'email' => 'tunde.balogun@example.org', 'city' => 'Lagos', 'country' => 'Nigeria', 'profession' => 'Communications', 'organization' => 'Lagos State Government', 'designation' => 'Communications Officer', 'status' => Alumni::STATUS_ACTIVE, 'is_featured' => false],
            ['full_name' => 'Nadia Karim', 'student_id' => 'EN-2016001', 'batch' => '2016-17', 'session' => '2016/2017', 'graduation_year' => 2020, 'email' => 'nadia.karim@example.org', 'city' => 'Dhaka', 'country' => 'Bangladesh', 'profession' => 'Education', 'organization' => 'Dhaka University', 'designation' => 'Assistant Professor', 'status' => Alumni::STATUS_ACTIVE, 'is_featured' => false],
        ];

        foreach ($alumni as $data) {
            Alumni::updateOrCreate(
                ['student_id' => $data['student_id']],
                array_merge($data, [
                    'slug' => Str::slug($data['full_name']),
                ])
            );
        }
    }
}
