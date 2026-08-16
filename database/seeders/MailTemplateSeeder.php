<?php

namespace Database\Seeders;

use App\Models\MailTemplate;
use Illuminate\Database\Seeder;

class MailTemplateSeeder extends Seeder
{
    public function run(): void
    {
        $samples = [
            [
                'name' => 'Welcome to Blood Link',
                'recipient_type' => 'All',
                'subject' => 'Welcome to Blood Link — Thank you for joining',
                'body' => "Dear Member,\n\nWelcome to Blood Link! We're thrilled to have you in our community of lifesavers.\n\nYour account is now active. You can update your profile, check your blood group, and start connecting with patients or donors near you.\n\nThank you for making a difference.\n\n— The Blood Link Team",
            ],
            [
                'name' => 'Blood Donation Drive Invitation',
                'recipient_type' => 'Donors',
                'subject' => 'Join our upcoming Blood Donation Drive',
                'body' => "Dear Donor,\n\nWe are organizing a blood donation drive and would love your support.\n\nDate: [DATE]\nTime: [TIME]\nVenue: [VENUE]\n\nEvery donation can save up to three lives. Please confirm your participation.\n\n— The Blood Link Team",
            ],
            [
                'name' => 'Urgent Blood Requirement',
                'recipient_type' => 'All',
                'subject' => 'Urgent: Blood required — Please help',
                'body' => "Dear Community,\n\nA patient urgently requires blood. If you or someone you know can help, please respond as soon as possible.\n\nBlood Group: [BLOOD GROUP]\nHospital: [HOSPITAL]\nContact: [CONTACT]\n\nThank you for your support.\n\n— The Blood Link Team",
            ],
            [
                'name' => 'Thank You for Your Donation',
                'recipient_type' => 'Donors',
                'subject' => 'Thank you for your generous donation',
                'body' => "Dear Donor,\n\nYour recent blood donation made a real difference. Thanks to you, a patient received the life-saving support they needed.\n\nWe look forward to seeing you at future drives.\n\n— The Blood Link Team",
            ],
            [
                'name' => 'Membership / Account Notice',
                'recipient_type' => 'All',
                'subject' => 'Update on your Blood Link account',
                'body' => "Dear Member,\n\nThis is an update regarding your Blood Link account.\n\n[ADD DETAILS]\n\nIf you have any questions, feel free to reach out.\n\n— The Blood Link Team",
            ],
        ];

        foreach ($samples as $sample) {
            MailTemplate::firstOrCreate(
                ['name' => $sample['name']],
                [
                    'subject' => $sample['subject'],
                    'body' => $sample['body'],
                    'recipient_type' => $sample['recipient_type'],
                    'created_by' => null,
                ]
            );
        }
    }
}
