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
     * @param \Illuminate\Http\Request $request
     * @return Response
     * @throws ValidationException
     */
    public function store(Request $request)
    {
        $items = $request->input('item_id');
        $items = is_array($items) ? collect(...$items) : collect($items);

        $checkouts = collect();

        $data = $request->validate([
            'user_id' => 'nullable|exists:users,id',
            'location_id' => 'nullable|exists:item_types,id',
        ]);

        if (empty($data)) {
            throw ValidationException::withMessages([
                'item_id' => __('validation.at-least-one-checkout-target'),
            ]);
        }

        $items->each(function ($id) use ($data, $checkouts) {
            $item = Item::with('checkouts')
                ->find($id);

            if ($item && !$item->isCheckedOut()) {
                $checkouts->push($item->checkouts()->create($data));
            }
        });

        return $checkouts->count() === 1
            ? redirect()->to($checkouts->first()->view_url)
            : redirect()->route('items.checkout.index');
    }

    /**
     * Display the specified resource.
     *
     * @param ItemCheckout $checkout
     * @return Response
     */
    public function show(int $id)
    {
        $checkout = ItemCheckout::with('item', 'location', 'user')
            ->findOrFail($id);

        return view('items.instances.checkouts.view', ['checkout' => $checkout]);
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
        abort_if($checkout->returned_at !== null, 400, "Can't return already what is already returned");
        $checkout->returned_at = now();
        $checkout->save();
        return redirect()->back();
    }
}
