<?php

namespace Database\Seeders;

use App\Models\BillingTransaction;
use App\Models\Tool;
use App\Models\Vendor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BillingTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $vendors = Vendor::with('tools')->get();

        if ($vendors->isEmpty()) {
            return;
        }

        $types = ['upgrade', 'sponsorship', 'analytics'];
        $statuses = ['paid', 'paid', 'paid', 'pending', 'refunded'];
        $amounts = [29.00, 79.00, 199.00, 290.00, 790.00, 1990.00];

        foreach ($vendors as $vendor) {
            $tool = $vendor->tools->first();

            // Create 1-3 transactions per vendor
            $numTransactions = rand(1, 3);
            for ($i = 0; $i < $numTransactions; $i++) {
                $status = $statuses[array_rand($statuses)];
                $type = $types[array_rand($types)];
                $amount = $amounts[array_rand($amounts)];

                BillingTransaction::create([
                    'vendor_id' => $vendor->id,
                    'tool_id' => $tool ? $tool->id : null,
                    'amount' => $amount,
                    'currency' => 'USD',
                    'type' => $type,
                    'status' => $status,
                    'external_tx_id' => 'ch_' . Str::random(16),
                    'created_at' => now()->subDays(rand(1, 60))->subHours(rand(1, 23)),
                ]);
            }
        }
    }
}
