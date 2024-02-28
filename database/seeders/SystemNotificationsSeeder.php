<?php

namespace Database\Seeders;

use App\Models\SystemNotification;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SystemNotificationsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $notifications = [
            [
                'name' => 'Order Creation',
                'type' => 'SMS',
                'code' => 'ORDER_CREATION',
                'description' => 'Order Creation notification',
                'active' => true,
            ],
            [
                'name' => 'Order Invoicing & Reciepting (Order submited)',
                'type' => 'SMS',
                'code' => 'ORDER_INVOICING',
                'description' => 'Order Invoicing notification',
                'active' => true,
            ],
            [
                'name' => 'Order First assigned',
                'type' => 'SMS',
                'code' => 'ORDER_FIRST_ASSIGNED',
                'description' => 'Order first assigned notification',
                'active' => true,
            ],
            [
                'name' => 'Production stage is complete',
                'type' => 'SMS',
                'code' => 'PROD_STAGE_COMPLETED',
                'description' => 'Production stage completed',
                'active' => true,
            ],
            [
                'name' => 'Once Order is dipatched',
                'type' => 'SMS',
                'code' => 'ORDER_DISPATCH',
                'description' => 'Order fully dispatched',
                'active' => true,
            ],
            [
                'name' => 'Order Invoicing & Reciepting (Order submited)',
                'type' => 'EMAIL',
                'code' => 'ORDER_INVOICE_EMAIL',
                'description' => 'Order Invoicing & Reciepting (Order submited)',
                'active' => true,
            ],
        ];

        // Insert data into the database
        foreach ($notifications as $notification) {
            SystemNotification::create($notification);
        }
    }
}
