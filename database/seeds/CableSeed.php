<?php

use Illuminate\Database\Seeder;
use Rulla\Items\Fields\Field;
use Rulla\Items\Fields\FieldAppliesTo;
use Rulla\Items\Fields\FieldType;
use Rulla\Items\Fields\FieldValue;
use Rulla\Items\Types\ItemType;

class CableSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
