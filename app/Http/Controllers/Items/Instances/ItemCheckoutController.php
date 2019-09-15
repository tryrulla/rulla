<?php

namespace Rulla\Http\Controllers\Items\Instances;

use Illuminate\Http\Response;
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        $items = $request->get('item');
        $items = is_array($items) ? collect(...$items) : collect($items);

        $items->each(function ($id) use ($request) {
            $item = Item::find($id);
            if ($item) {
                $item->checkouts()->create([
                    'user_id' => $request->user()->id,
                ]);
            }
        });

        return redirect()->back();
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
