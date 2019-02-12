<?php

use App\Models\User;
use App\Models\Order;
use App\Models\Variation;
use Illuminate\Database\Seeder;

class OrdersTableSeeder extends Seeder
{
    public function run()
    {
        $users = User::inRandomOrder()->take(ceil(User::count() / 2))->get();
        foreach ($users as $user) {
            $user->orders()->createMany(
                $user->addresses->toArray()
            );

            $orders = $user->orders;
            foreach ($orders as $order) {
                $variations = Variation::inRandomOrder()
                    ->select(['id as variation_id', 'price'])
                    ->selectRaw('quantity - 1 as count')
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
        DB::table('orders_products')->where('count', '<', 2)
            ->update(['count' => DB::raw('RAND() * 10')]);
    }
}
