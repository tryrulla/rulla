<?php

use Carbon\Carbon;
use Rulla\Comments\Comment;
use Illuminate\Database\Seeder;
use Rulla\Items\Instances\Item;
use Rulla\Comments\CommentType;
use Rulla\Items\Instances\ItemCheckout;
use Rulla\Items\Instances\ItemFault;
use Rulla\Items\Types\ItemType;

class CheckoutFaultSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        ItemType::with('parents')
            ->get()
            ->filter(function (ItemType $type) {
                return $type->hasParent(1, false);
            })
            ->each(function (ItemType $type) use ($faker) {
                for ($i = 0; $i < $faker->numberBetween(0, 10); $i++) {
                    $item = Item::create([
                        'type_id' => $type->id,
                    ]);

                    if ($faker->boolean(67)) {
                        $max = $faker->numberBetween(1, 5);
                        for ($i = 0; $i < $max; $i++) {
                            ItemCheckout::create([
                                'item_id' => $item->id,
                                'user_id' => $faker->numberBetween(1, 20),
                                'created_at' => Carbon::now()->addMinutes(-3 - ($max - $i)),
                                'returned_at' => Carbon::now()->addMinutes(-2 - ($max - $i)),
                            ]);
                        }
                    }

                    if ($faker->boolean(33)) {
                        ItemCheckout::create([
                            'item_id' => $item->id,
                            'user_id' => $faker->numberBetween(1, 20),
                            'created_at' => Carbon::now()->addMinutes(-1),
                        ]);
                    }

                    if ($faker->boolean(33)) {
                        ItemFault::create([
                            'item_id' => $item->id,
                            'title' => $faker->words(3, true),
                            'description' => $faker->sentences($faker->numberBetween(2, 6), true) . "\n\n" . $faker->sentences($faker->numberBetween(2, 6), true) . "\n\n" . $faker->sentences($faker->numberBetween(2, 6), true),
                        ]);
                    }
                }
            });

        ItemFault::each(function (ItemFault $fault) use ($faker) {
            for ($i = 0; $i < $faker->numberBetween(1, 3); $i++) {
                Comment::create([
                    'user_id' => $faker->numberBetween(1, 20),
                    'commentable_id' => $fault->id,
                    'commentable_type' => ItemFault::class,
                    'comment_type' => CommentType::comment(),
                    'data' => ['text' => $faker->sentence],
                ]);
            }
        });
    }
}
