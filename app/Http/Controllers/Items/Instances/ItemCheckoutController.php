<?php

namespace Rulla\Http\Controllers\Items\Instances;

use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Rulla\Http\Controllers\Controller;
use Rulla\Items\Instances\Item;
use Rulla\Items\Instances\ItemCheckout;
use Illuminate\Http\Request;

class ItemCheckoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('items.instances.checkouts.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $items = $request->input('item');
        $items = is_array($items) ? collect(...$items) : collect($items);

        $checkouts = collect();

        $userId = $request->input('user_id');
        $locationId = $request->input('location_id');

        $items->each(function ($id) use ($request, $checkouts, $userId, $locationId) {
            $item = Item::with('checkouts')
                ->find($id);

            if ($item && !$item->isCheckedOut()) {
                $checkouts->push($item->checkouts()->create([
                    'user_id' => $userId,
                    'location_id' => $locationId,
                ]));
            }
        });

        return $checkouts->count() === 1
            ? redirect()->route('items.checkout.show', $checkouts->first()->identifier)
            : redirect()->route('items.checkout.index');
    }

    /**
     * Display the specified resource.
     *
     * @param ItemCheckout $checkout
     * @return Response
     */
    public function show(ItemCheckout $checkout)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ItemCheckout $checkout
     * @return Response
     */
    public function edit(ItemCheckout $checkout)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param ItemCheckout $checkout
     * @return Response
     */
    public function update(Request $request, ItemCheckout $checkout)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ItemCheckout $checkout
     * @return Response
     */
    public function destroy(ItemCheckout $checkout)
    {
        $checkout->returned_at = now();
        $checkout->save();
        return redirect()->back();
    }
}
