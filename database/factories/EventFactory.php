<?php

namespace Database\Factories;

use App\Models\Event;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Event>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $titles = [
            'Annual Alumni Lecture',
            'Homecoming Weekend',
            'Poetry Evening: New Voices',
            'Career Conversation: Publishing & Media',
            "Writers' Workshop: The Short Story",
            'Annual General Meeting',
            'Literary Awards Night',
            'Alumni Mentorship Launch',
            'Book Club: African Fiction',
            'Farewell Reception for Prof. Okonkwo',
            'Cultural Night & Drama Festival',
            'Scholarship Fund Gala',
            'Research Symposium',
            'English Department Open Day',
            'Alumni Sports Day',
        ];

        $venues = [
            'Faculty of Arts, Great Hall',
            'English Department Campus',
            'Library Reading Room',
            'University Banquet Hall',
            'Department Seminar Room',
            'Online (Zoom)',
            'Faculty of Arts, Room 204',
            'University Auditorium',
        ];

        $cities = ['Lagos', 'Accra', 'Nairobi', 'Cairo', 'Ibadan', 'Abuja', 'Kampala'];
        $countries = ['Nigeria', 'Ghana', 'Kenya', 'Egypt', 'Uganda'];

        $organizers = [
            'EDAA Events Committee',
            'English Department',
            'Alumni Relations Office',
            'EDAA Executive Council',
        ];

        $title = $this->faker->unique()->randomElement($titles);
        $eventDate = $this->faker->dateTimeBetween('-3 months', '+6 months');

        return [
            'title' => $title,
            'slug' => Str::slug($title).'-'.$this->faker->unique()->numberBetween(1000, 9999),
            'category_id' => null,
            'cover_image' => null,
            'short_description' => $this->faker->sentence(12),
            'description' => '<p>'.$this->faker->paragraph(3).'</p>',
            'event_date' => $eventDate->format('Y-m-d'),
            'start_time' => $this->faker->randomElement(['09:00', '10:00', '14:00', '16:00', '18:00', null]),
            'end_time' => $this->faker->randomElement(['12:00', '14:00', '16:00', '18:00', '20:00', null]),
            'venue' => $this->faker->optional(0.8)->randomElement($venues),
            'address' => $this->faker->optional(0.5)->streetAddress(),
            'city' => $this->faker->optional(0.7)->randomElement($cities),
            'country' => $this->faker->optional(0.7)->randomElement($countries),
            'organizer' => $this->faker->optional(0.7)->randomElement($organizers),
            'capacity' => $this->faker->optional(0.5)->numberBetween(20, 500),
            'registration_deadline' => $this->faker->optional(0.4)->dateTimeBetween('-1 month', '-1 day'),
            'status' => Event::STATUS_DRAFT,
            'is_featured' => $this->faker->boolean(20),
            'sort_order' => $this->faker->numberBetween(0, 50),
        ];
    }

    /**
     * Mark the event as published.
     */
    public function published(): static
    {
        return $this->state(fn () => ['status' => Event::STATUS_PUBLISHED]);
    }

    /**
     * Mark the event as featured.
     */
    public function featured(): static
    {
        return $this->state(fn () => ['is_featured' => true]);
    }

    /**
     * Set event in the past.
     */
    public function past(): static
    {
        return $this->state(fn () => [
            'event_date' => now()->subDays(rand(30, 365))->format('Y-m-d'),
        ]);
    }

    /**
     * Set event in the future.
     */
    public function upcoming(): static
    {
        return $this->state(fn () => [
            'event_date' => now()->addDays(rand(7, 180))->format('Y-m-d'),
        ]);
    }
}
