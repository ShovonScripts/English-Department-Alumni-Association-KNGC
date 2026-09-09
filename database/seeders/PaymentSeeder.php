<?php

namespace Database\Seeders;

use App\Enums\PaymentStatus;
use App\Models\FeePlan;
use App\Models\Membership;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run(): void
    {
        $admin = User::where('is_admin', true)->first()
            ?? User::factory()->admin()->create();

        $payments = [
            // Chidi Eze - paid executive contribution
            ['student_id' => 'EN-2010001', 'amount' => 100.00, 'status' => PaymentStatus::Paid->value, 'reference' => 'CHIDI-PAID-001'],
            // Adaeze Okafor - paid general contribution
            ['student_id' => 'EN-2012001', 'amount' => 50.00, 'status' => PaymentStatus::Paid->value, 'reference' => 'ADAEZE-PAID-001'],
            // Halima Balogun - two partial payments (30 + 20)
            ['student_id' => 'EN-2014001', 'amount' => 30.00, 'status' => PaymentStatus::Partial->value, 'reference' => 'HALIMA-PARTIAL-001'],
            ['student_id' => 'EN-2014001', 'amount' => 20.00, 'status' => PaymentStatus::Partial->value, 'reference' => 'HALIMA-PARTIAL-002'],
            // Kwame Mensah - zero contribution (no payment)
            // Fatima Haddad - waived
            ['student_id' => 'EN-2013001', 'amount' => 0.00, 'status' => PaymentStatus::Waived->value, 'reference' => 'FATIMA-WAIVED-001'],
            // Tunde Balogun - void payment
            ['student_id' => 'EN-2015001', 'amount' => 50.00, 'status' => PaymentStatus::Void->value, 'reference' => 'TUNDE-VOID-001'],
        ];

        foreach ($payments as $data) {
            $membership = Membership::whereHas('alumni', fn ($q) => $q->where('student_id', $data['student_id']))->first();

            if (!$membership) {
                continue;
            }

            $plan = FeePlan::where('membership_type_id', $membership->membership_type_id)->first()
                ?? FeePlan::factory()->create(['membership_type_id' => $membership->membership_type_id]);

            $paymentData = [
                'membership_id' => $membership->id,
                'fee_plan_id' => $plan->id,
                'amount' => $data['amount'],
                'currency' => 'BDT',
                'payment_number' => Payment::generatePaymentNumber(),
                'status' => $data['status'],
                'paid_at' => now()->subDays(rand(1, 90))->toDateString(),
                'reference' => $data['reference'],
                'recorded_by' => $admin->id,
            ];

            if ($data['status'] === PaymentStatus::Void->value) {
                $paymentData['voided_at'] = now()->toDateTimeString();
                $paymentData['voided_by'] = $admin->id;
                $paymentData['void_reason'] = 'Test void for seeder data.';
            }

            Payment::updateOrCreate(
                ['reference' => $data['reference']],
                $paymentData
            );
        }
    }
}
