<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Rulla\Authentication\Models\AuthenticationSource;
use Rulla\Authentication\Models\Groups\Group;
use Rulla\Authentication\Models\User;
use Rulla\Authentication\Providers\LocalAuthenticationProvider;
use Rulla\Comments\Comment;
use Rulla\Comments\CommentType;
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
        $this->call([
            AuthSeed::class,
            CableSeed::class,
            CheckoutSeed::class,
        ]);

        factory(ItemType::class, 'location', 50)->create();
        factory(ItemType::class, 50)->create();

        $faker = Faker\Factory::create();
        ItemFault::each(function (ItemFault $fault) use ($faker) {
            Comment::create([
                'user_id' => $faker->numberBetween(1, 20),
                'commentable_id' => $fault->id,
                'commentable_type' => ItemFault::class,
                'comment_type' => CommentType::comment(),
                'data' => ['text' => $faker->sentence],
            ]);

            Comment::create([
                'user_id' => $faker->numberBetween(1, 20),
                'commentable_id' => $fault->id,
                'commentable_type' => ItemFault::class,
                'comment_type' => CommentType::comment(),
                'data' => ['text' => $faker->sentence],
            ]);
        });
    }
}
