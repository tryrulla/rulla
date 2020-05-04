<?php

use Illuminate\Database\Seeder;
use Rulla\Items\Types\ItemType;

class TypeSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(ItemType::class, 'location', 50)->create();
        factory(ItemType::class, 50)->create();
    }
}
