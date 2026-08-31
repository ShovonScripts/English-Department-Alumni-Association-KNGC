<?php

namespace Database\Factories;

use App\Models\ContactMessage;
use Illuminate\Database\Eloquent\Factories\Factory;

class ContactMessageFactory extends Factory
{
    protected $model = ContactMessage::class;

    public function definition(): array
    {
        $subject = fake()->randomElement([
            'Membership enquiry',
            'Event question',
            'Share an alumni story',
            'Submit a publication',
            'Volunteering',
            'General question',
        ]);

        return [
            'name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'phone' => fake()->optional(0.6)->phoneNumber(),
            'subject' => $subject,
            'message' => fake()->paragraphs(3, true),
            'status' => ContactMessage::STATUS_UNREAD,
            'ip_address' => fake()->ipv4(),
            'user_agent' => fake()->optional(0.3)->userAgent(),
            'read_at' => null,
            'archived_at' => null,
        ];
    }

    public function unread(): static
    {
        return $this->state(fn () => [
            'status' => ContactMessage::STATUS_UNREAD,
            'read_at' => null,
        ]);
    }

    public function read(): static
    {
        return $this->state(fn () => [
            'status' => ContactMessage::STATUS_READ,
            'read_at' => now(),
        ]);
    }

    public function archived(): static
    {
        return $this->state(fn () => [
            'status' => ContactMessage::STATUS_ARCHIVED,
            'archived_at' => now(),
        ]);
    }
}
