<?php

namespace Database\Factories;

use App\Models\CommitteeMember;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<CommitteeMember>
 */
class CommitteeMemberFactory extends Factory
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

        $positions = [
            'Executive Member',
            'Committee Member',
        ];

        $slug = Str::slug($fullName).'-'.$this->faker->unique()->numberBetween(1000, 9999);

        return [
            'name' => $fullName,
            'slug' => $slug,
            'position' => $this->faker->randomElement($positions),
            'profile_photo' => null,
            'short_bio' => $this->faker->optional(0.7)->sentence(),
            'biography' => $this->faker->optional(0.5)->paragraphs(2, true),
            'email' => $this->faker->optional(0.8)->safeEmail(),
            'linkedin_url' => 'https://www.linkedin.com/in/'.$slug,
            'website_url' => $this->faker->optional(0.4)->url(),
            'sort_order' => $this->faker->numberBetween(0, 100),
            'is_active' => true,
        ];
    }

    /**
     * Mark the committee member as inactive.
     */
    public function inactive(): static
    {
        return $this->state(fn () => ['is_active' => false]);
    }
}
