<?php

namespace Rulla\Http\Controllers\Items\Instances;

use Illuminate\Http\Response;
use Rulla\Http\Controllers\Controller;
use Rulla\Items\Instances\Item;
use Illuminate\Http\Request;
use Rulla\Items\Types\ItemType;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = Item::with('type', 'location')
            ->paginate(50);

        return view('items.instances.index', ['items' => $items]);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        [$types, $locationTypes] = ItemType::with('parents')
            ->where('system', false)
            ->orderBy('name')
            ->get()
            ->partition(function (ItemType $type) {
                return $type->hasParent(1);
            });

        $locations = $locationTypes->merge(collect());

        return view('items.instances.add', ['types' => $types->values(), 'locations' => $locations->values()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Rulla\Items\Instances\Item  $item
     * @return Response
     */
    public function show(Item $item)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Rulla\Items\Instances\Item  $item
     * @return Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \Rulla\Items\Instances\Item  $item
     * @return Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Rulla\Items\Instances\Item  $item
     * @return Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
