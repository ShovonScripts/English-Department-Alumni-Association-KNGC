<?php

namespace Database\Seeders;

use App\Models\ContactMessage;
use Illuminate\Database\Seeder;

class ContactMessageSeeder extends Seeder
{
    public function run(): void
    {
        if (ContactMessage::exists()) {
            return;
        }

        $names = [
            'Amara Okafor',
            'Chinedu Eze',
            'Fatima Bello',
            'Tunde Adeyemi',
            'Ngozi Nwosu',
            'Emeka Obi',
            'Aisha Mohammed',
            'Yusuf Abdullahi',
            'Chioma Igwe',
            'Olumide Bankole',
            'Blessing Okoro',
            'Kemi Adekunle',
            'Ibrahim Suleiman',
            'Adaeze Chukwu',
            'Musa Danjuma',
            'Funke Adebayo',
            'Emmanuel Okonkwo',
            'Halima Balarabe',
        ];

        $messages = [
            'Membership enquiry' => [
                'I would like to inquire about the alumni membership process. Could you kindly provide details on the steps involved and any associated fees?',
                'I graduated in 2018 and am interested in joining the alumni association. What documents do I need to submit?',
                'Please share information about the different membership tiers and the benefits associated with each.',
            ],
            'Event question' => [
                'When is the next alumni reunion scheduled? I would love to attend and reconnect with former classmates.',
                'Will there be a virtual option for the upcoming annual lecture? I am currently based abroad.',
                'Could you share details about the venue and registration process for the forthcoming alumni dinner?',
            ],
            'Share an alumni story' => [
                'I have an inspiring story about my career journey since graduating from the department. I would love to share it with the alumni community.',
                'One of our classmates has achieved remarkable success in the literary world. I think her story would inspire current students.',
                'I would like to nominate a fellow alumnus whose community development work deserves recognition.',
            ],
            'Submit a publication' => [
                'I recently published a novel and would like to feature it in the alumni publications section of the newsletter.',
                'My research paper on African literature has been accepted by an international journal. How can I share this with the department?',
                'I have compiled a collection of essays and would like to submit it for consideration in the alumni literary journal.',
            ],
            'Volunteering' => [
                'I am interested in volunteering as a mentor for current students. How can I get involved in the mentorship programme?',
                'Are there opportunities for alumni to contribute to departmental events or academic programmes?',
                'I would like to offer my time and expertise to support the alumni association\'s outreach initiatives.',
            ],
            'General question' => (
                [
                    'Could you provide updates on the department\'s recent achievements and future plans?',
                    'I would like to know if the department offers any short courses or workshops for alumni.',
                    'How can I update my contact details with the alumni office to ensure I receive all communications?',
                ]
            ),
        ];

        $subjects = array_keys($messages);

        for ($i = 0; $i < 18; $i++) {
            $subject = $subjects[$i % count($subjects)];
            $messageOptions = $messages[$subject];

            $status = match (true) {
                $i < 6 => ContactMessage::STATUS_UNREAD,
                $i < 13 => ContactMessage::STATUS_READ,
                default => ContactMessage::STATUS_ARCHIVED,
            };

            $daysAgo = 30 - $i;

            ContactMessage::create([
                'name' => $names[$i],
                'email' => strtolower(str_replace(' ', '.', $names[$i])).'@example.com',
                'phone' => fake()->optional(0.6)->phoneNumber(),
                'subject' => $subject,
                'message' => $messageOptions[array_rand($messageOptions)],
                'status' => $status,
                'ip_address' => fake()->ipv4(),
                'user_agent' => fake()->optional(0.3)->userAgent(),
                'read_at' => $status === ContactMessage::STATUS_READ ? now()->subDays($daysAgo - rand(1, 5)) : null,
                'archived_at' => $status === ContactMessage::STATUS_ARCHIVED ? now()->subDays($daysAgo - rand(1, 3)) : null,
                'created_at' => now()->subDays($daysAgo),
                'updated_at' => now()->subDays($daysAgo),
            ]);
        }
    }
}
