<?php

use App\Models\User;
use App\Models\Order;
use App\Models\Variation;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::all();
        foreach ($users as $user) {
            $statuses = enum('order.status');
            $user->orders()->createMany(
                $user->addresses->map(function ($address) use ($statuses) {
                    $address['status'] = $statuses[array_rand($statuses)]['value'];
                    return $address;
                })->toArray()
            );

            $orders = $user->orders;
            foreach ($orders as $order) {
                $variations = Variation::inRandomOrder()
                    ->select(['id as variation_id', 'price'])
                    ->selectRaw('quantity - 1 as quantity')
                    ->take(2)
                    ->get()
                    ->toArray();

                foreach ($variations as $variation) {
                    $sql[$order->id] = $variation;
                }
                /* @var Order $order */
                $order->variations()->sync($sql, false);
                $sql = null;
            }
        }
        DB::table('orders_products')->update(['options' => json_encode([])]);
    }
}
