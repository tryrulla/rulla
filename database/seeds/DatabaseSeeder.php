<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Rulla\Authentication\Models\AuthenticationSource;
use Rulla\Authentication\Models\User;
use Rulla\Authentication\Providers\LocalAuthenticationProvider;
use Rulla\Items\Fields\Field;
use Rulla\Items\Fields\FieldAppliesTo;
use Rulla\Items\Fields\FieldType;
use Rulla\Items\Fields\FieldValue;
use Rulla\Items\Instances\Item;
use Rulla\Items\Instances\ItemCheckout;
use Rulla\Items\Instances\ItemFault;
use Rulla\Items\Types\ItemType;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        AuthenticationSource::create([
            'name' => 'Rulla Local Account',
            'type' => LocalAuthenticationProvider::class,
        ]);

        factory(User::class)->create([
            'name' => 'Administrator',
            'email' => 'admin@example.org'
        ]);

        factory(User::class, 19)->create();

        $cableType = factory(ItemType::class)->create([
            'name' => 'Cable'
        ]);

        $lengthField = Field::create([
            'name' => 'Length',
            'type' => FieldType::number(),
            'extra_options' => json_encode(['unit' => 'm', 'decimals' => 1]),
        ]);

        FieldAppliesTo::create([
            'field_id' => $lengthField->id,
            'type_id' => $cableType->id,
            'apply_to_type' => true,
        ]);

        collect([
            ItemType::create([
                'parent_id' => $cableType->id,
                'name' => 'Ethernet Cable',
            ]),
            ItemType::create([
                'parent_id' => $cableType->id,
                'name' => 'HDMI Cable',
            ]),
        ])->each(function (ItemType $it) use ($lengthField) {
            collect([0.5, 1, 1.5, 2, 3, 5, 10, 15, 20, 25, 50])->each(function ($len) use ($lengthField, $it) {
                $type = ItemType::create([
                    'name' => $len . 'm ' . $it->name,
                    'parent_id' => $it->id,
                ]);

                FieldValue::create([
                    'field_id' => $lengthField->id,
                    'value_holder_id' => $type->id,
                    'value_holder_type' => ItemType::class,
                    'value' => ['number' => $len],
                ]);
            });
        });

        factory(ItemType::class, 'location', 50)->create();
        factory(ItemType::class, 50)->create();

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
    }
}
