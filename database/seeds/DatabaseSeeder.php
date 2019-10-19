<?php

use Illuminate\Database\Seeder;
use Rulla\Comments\Comment;
use Rulla\Comments\CommentType;
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
