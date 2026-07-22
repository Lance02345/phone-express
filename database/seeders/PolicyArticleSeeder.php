<?php

namespace Database\Seeders;

use App\Models\PolicyArticle;
use Illuminate\Database\Seeder;

class PolicyArticleSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->articles() as $article) {
            PolicyArticle::updateOrCreate(['key' => $article['key']], $article);
        }
    }

    /**
     * @return array<int, array<string, mixed>>
     */
    private function articles(): array
    {
        return [
            [
                'key' => 'delivery',
                'slug' => 'delivery',
                'title' => 'Delivery guidance',
                'summary' => 'Confirm the destination, delivery charge and expected timing before completing payment.',
                'content' => [
                    ['heading' => 'Before you pay', 'body' => 'Share your delivery location with our team so they can confirm whether delivery is available, the applicable charge and the expected timeline.'],
                    ['heading' => 'When receiving an order', 'body' => 'Confirm the recipient details and inspect the package as directed by the Phone Express team.'],
                    ['heading' => 'Important', 'body' => 'Delivery availability, charges and timing can vary by destination and order. They are only confirmed when our team provides the final order details.'],
                ],
                'status' => 'guidance',
                'version' => 1,
                'is_public' => true,
            ],
            [
                'key' => 'warranty',
                'slug' => 'warranty',
                'title' => 'Warranty guidance',
                'summary' => 'Warranty coverage can vary by device, condition and supplier; request the exact terms for your phone.',
                'content' => [
                    ['heading' => 'Check the exact device', 'body' => 'Ask our team to confirm the warranty period and coverage for the specific phone or variant you are buying.'],
                    ['heading' => 'Keep your records', 'body' => 'Retain your receipt and any written warranty information supplied with the device.'],
                    ['heading' => 'Before requesting support', 'body' => 'Contact Phone Express with your purchase details and a description of the issue. The team will confirm the applicable next steps.'],
                ],
                'status' => 'guidance',
                'version' => 1,
                'is_public' => true,
            ],
            [
                'key' => 'returns',
                'slug' => 'returns',
                'title' => 'Returns and exchanges guidance',
                'summary' => 'Contact the team before returning a device so eligibility and the correct process can be confirmed.',
                'content' => [
                    ['heading' => 'Contact us first', 'body' => 'Do not send or hand over a device for return before the Phone Express team confirms the return or exchange process.'],
                    ['heading' => 'Provide purchase details', 'body' => 'Have your receipt, device details, purchase date and reason for the request available.'],
                    ['heading' => 'Eligibility', 'body' => 'Eligibility depends on the device, its condition, the reported issue and the terms supplied at purchase. The team must review the request before confirming an outcome.'],
                ],
                'status' => 'guidance',
                'version' => 1,
                'is_public' => true,
            ],
            [
                'key' => 'payment-plans',
                'slug' => 'payment-plans',
                'title' => 'Payment-plan guidance',
                'summary' => 'Website figures are estimates; eligibility and the final schedule must be confirmed before payment.',
                'content' => [
                    ['heading' => 'Website estimates', 'body' => 'Where shown, the deposit and installment amounts are estimates based on the current listed phone price.'],
                    ['heading' => 'Approval and eligibility', 'body' => 'A displayed estimate does not confirm eligibility or approval. Ask the team to confirm the requirements for the exact device.'],
                    ['heading' => 'Final schedule', 'body' => 'Review the confirmed deposit, installment amount, number of payments and any applicable terms before making a payment.'],
                ],
                'status' => 'guidance',
                'version' => 1,
                'is_public' => true,
            ],
        ];
    }
}
