<?php

namespace Tests\Feature\Items\Instances;

use Rulla\Items\Instances\Item;
use Rulla\Items\Instances\ItemCheckout;
use Rulla\Items\Types\ItemType;
use Tests\TestCase;

class ItemCheckoutTest extends TestCase
{
    public function testCheckout()
    {
        $this->login();

        $type = ItemType::create([
            'name' => 'Foo',
        ]);

        $item = Item::create([
            'tag' => 'Bar',
            'type_id' => $type->id,
        ]);

        $this->assertEquals(false, $item->isCheckedOut());

        $response = $this
            ->from($item->view_url)
            ->post(route('items.checkout.store'), [
                'item_id' => $item->id,
                'user_id' => $this->user->id,
            ]);

        $item->refresh();

        $response->assertRedirect($item->getActiveCheckout()->view_url);
        $this->assertEquals(true, $item->isCheckedOut());
    }

    public function testCheckoutShouldNotCreateDuplicates()
    {
        $this->login();

        $type = ItemType::create([
            'name' => 'Foo',
        ]);

        $item = Item::create([
            'tag' => 'Bar',
            'type_id' => $type->id,
        ]);

        $checkout = ItemCheckout::create([
            'item_id' => $item->id,
            'user_id' => $this->user->id,
        ]);

        $item->refresh();

        $this->assertEquals(true, $item->isCheckedOut());
        $this->assertEquals($checkout->id, $item->getActiveCheckout()->id);
        $this->assertEquals(1, ItemCheckout::where('item_id', $item->id)->active()->count());

        $this
            ->from($item->view_url)
            ->post(route('items.checkout.store'), [
                'item_id' => $item->id,
                'user_id' => $this->user->id,
            ])
            ->assertRedirect(route('home'));

        $item->refresh();

        $this->assertEquals(true, $item->isCheckedOut());
        $this->assertEquals($checkout->id, $item->getActiveCheckout()->id);
        $this->assertEquals(1, ItemCheckout::where('item_id', $item->id)->active()->count());
    }
}
