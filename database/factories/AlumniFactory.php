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
        $firstNames = ['Adaeze', 'Bolanle', 'Chidi', 'Fatima', 'Kwame', 'Halima', 'Tunde', 'Zainab', 'Emeka', 'Ngozi', 'Yusuf', 'Ama', 'Sefiu', 'Layla', 'Ibrahim', 'Kemi', 'Obi', 'Sana'];
        $lastNames = ['Okafor', 'Mensah', 'Haddad', 'Adebayo', 'Kamau', 'Balogun', 'Nair', 'Owusu', 'Diallo', 'Eze', 'Fontaine', 'Boateng', 'Abubakar', 'Mills', 'Adeyemi', 'Onwuka', 'Coker', 'Bello'];

        $firstName = $this->faker->randomElement($firstNames);
        $lastName = $this->faker->randomElement($lastNames);
        $fullName = $firstName.' '.$lastName;

        $batch = $this->faker->numberBetween(1985, 2018);
        $sessionStart = $batch;
        $sessionEnd = $sessionStart + 1;

        $degrees = [
            'BA English',
            'BA English and Literary Studies',
            'BA English Language',
            'BA Literature in English',
            'MA English',
            'MA Creative Writing',
            'PhD English Literature',
        ];

        $designations = [
            'Novelist', 'Poet', 'Senior Lecturer', 'Assistant Editor', 'Journalist',
            'Publishing Manager', 'Archivist', 'Translator', 'Screenwriter',
            'Education Consultant', 'Librarian', 'Copywriter', 'Communications Lead',
            'Literary Agent', 'Book Reviewer', 'Broadcast Producer',
        ];

        $professions = [
            'Academia', 'Publishing', 'Media & Journalism', 'Education',
            'Arts & Culture', 'Public Service', 'Communications',
        ];

        $organizations = [
            'Atlas Literary Review', 'University of Cape Coast', 'National Library Service',
            'Balogun & Sons Books', 'Harborline Publishers', 'Ministry of Culture',
            'Bayleaf Media Group', 'Civic Education Trust', 'The Eastlight Press',
            'Council for the Arts', 'Nova Broadcasting', 'Meridian Institute',
        ];

        $cities = ['Lagos', 'Accra', 'Nairobi', 'Cairo', 'London', 'Toronto', 'Dubai', 'Johannesburg', 'Mumbai', 'Paris', 'New York', 'Kigali'];
        $countries = ['Nigeria', 'Ghana', 'Kenya', 'Egypt', 'United Kingdom', 'Canada', 'United Arab Emirates', 'South Africa', 'India', 'France', 'United States', 'Rwanda'];

        $slug = Str::slug($fullName).'-'.$this->faker->unique()->numberBetween(1000, 9999);

        return [
            'full_name' => $fullName,
            'slug' => $slug,
            'profile_photo' => null,
            'student_id' => 'EN-'.$this->faker->unique()->numberBetween(2000000, 2099999),
            'batch' => (string) $batch,
            'session' => $sessionStart.'/'.$sessionEnd,
            'graduation_year' => $batch + $this->faker->randomElement([3, 4, 5]),
            'degree' => $this->faker->randomElement($degrees),
            'designation' => $this->faker->randomElement($designations),
            'organization' => $this->faker->randomElement($organizations),
            'profession' => $this->faker->randomElement($professions),
            'city' => $this->faker->randomElement($cities),
            'country' => $this->faker->randomElement($countries),
            'bio' => $this->faker->paragraphs(2, true),
            'email' => strtolower($firstName.'.'.$lastName.'@example.org'),
            'phone' => '+1 '.$this->faker->numerify('###-###-####'),
            'linkedin_url' => 'https://www.linkedin.com/in/'.$slug,
            'website_url' => $this->faker->optional(0.6)->url(),
            'is_featured' => $this->faker->boolean(25),
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
