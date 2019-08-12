<?php

namespace Rulla\Http\Controllers\Items\Types;

use Rulla\Items\Types\ItemType;
use Illuminate\Http\Request;
use Rulla\Http\Controllers\Controller;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('items.types.index', ['types' => ItemType::paginate(50)]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \Rulla\Items\Types\ItemType  $type
     * @return \Illuminate\Http\Response
     */
    public function show(ItemType $type)
    {
        return view('items.types.view', ['type' => $type]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Rulla\Items\Types\ItemType  $itemType
     * @return \Illuminate\Http\Response
     */
    public function edit(ItemType $itemType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Rulla\Items\Types\ItemType  $itemType
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ItemType $itemType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Rulla\Items\Types\ItemType  $itemType
     * @return \Illuminate\Http\Response
     */
    public function destroy(ItemType $itemType)
    {
        //
    }
}
