<?php

namespace Database\Factories;

use App\Models\Alumni;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Alumni>
 */
class AlumniFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $firstNames = ['Rafiqul', 'Nusrat', 'Tanvir', 'Sabrina', 'Kamal', 'Farhana', 'Tanzeem', 'Mahmuda', 'Shafiul', 'Anisur', 'Rubina', 'Masum', 'Shahana', 'Jahangir', 'Taslima', 'Abdul', 'Salma', 'Rezaul'];
        $lastNames = ['Islam', 'Jahan', 'Ahmed', 'Rahman', 'Hossain', 'Begum', 'Khan', 'Chowdhury', 'Akter', 'Uddin', 'Parveen', 'Hasan', 'Biswas', 'Miah', 'Khatun', 'Alam', 'Siddiqui', 'Mahmud'];

        $firstName = $this->faker->randomElement($firstNames);
        $lastName = $this->faker->randomElement($lastNames);
        $fullName = $firstName.' '.$lastName;

        $batchStart = $this->faker->randomElement([2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009, 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017, 2018, 2019, 2020, 2021, 2022, 2023]);
        $batchEnd = $batchStart + 1;
        $batch = $batchStart.'-'.substr((string) $batchEnd, -2);
        $session = $batchStart.'/'.$batchEnd;

        $degrees = [
            'BA English',
            'BA English and Literary Studies',
            'BA English Language',
            'BA Literature in English',
            'MA English',
            'MA English Literature',
            'MA Creative Writing',
        ];

        $designations = [
            'Lecturer', 'Assistant Professor', 'Senior Lecturer', 'Journalist',
            'Content Writer', 'Translator', 'Editor', 'Teacher',
            'Researcher', 'Programme Officer', 'Communications Officer',
            'Literary Agent', 'Curriculum Developer', 'Librarian',
        ];

        $professions = [
            'Academia', 'Education', 'Media & Journalism', 'Publishing',
            'Arts & Culture', 'NGO', 'Communications', 'Public Service',
        ];

        $organizations = [
            'University of Dhaka', 'Jagannath University', 'Government Laboratory College',
            'The Daily Star', 'Prothom Alo', 'BRAC', 'UNICEF Bangladesh',
            'Bangla Academy', 'National Library', 'Primary Education Bureau',
            'Save the Children', 'World Bank Bangladesh',
        ];

        $cities = ['Dhaka', 'Chittagong', 'Sylhet', 'Rajshahi', 'Khulna', 'Barisal', 'Rangpur', 'Mymensingh'];
        $countries = ['Bangladesh'];

        $slug = Str::slug($fullName).'-'.$this->faker->unique()->numberBetween(1000, 9999);

        return [
            'full_name' => $fullName,
            'slug' => $slug,
            'profile_photo' => null,
            'student_id' => 'EN-'.$this->faker->unique()->numberBetween(2002000, 2099999),
            'batch' => $batch,
            'session' => $session,
            'graduation_year' => $batchStart + $this->faker->randomElement([3, 4, 5]),
            'degree' => $this->faker->randomElement($degrees),
            'designation' => $this->faker->randomElement($designations),
            'organization' => $this->faker->randomElement($organizations),
            'profession' => $this->faker->randomElement($professions),
            'city' => $this->faker->randomElement($cities),
            'country' => $this->faker->randomElement($countries),
            'bio' => $this->faker->paragraphs(2, true),
            'email' => strtolower($firstName.'.'.$lastName.'@example.org'),
            'phone' => '+880 1'.$this->faker->numerify('####-####'),
            'linkedin_url' => 'https://www.linkedin.com/in/'.$slug,
            'website_url' => $this->faker->optional(0.3)->url(),
            'is_featured' => $this->faker->boolean(20),
            'status' => Alumni::STATUS_ACTIVE,
            'sort_order' => $this->faker->numberBetween(0, 100),
        ];
    }

    /**
     * Mark the alumni as featured.
     */
    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => true]);
    }

    /**
     * Mark the alumni as inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn () => ['status' => Alumni::STATUS_INACTIVE]);
    }
}
