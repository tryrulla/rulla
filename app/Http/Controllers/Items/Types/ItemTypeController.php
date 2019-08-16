<?php

namespace Rulla\Http\Controllers\Items\Types;

use Illuminate\Http\Response;
use Rulla\Items\Types\ItemType;
use Illuminate\Http\Request;
use Rulla\Http\Controllers\Controller;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $types = ItemType::orderByDesc('system')
            ->orderBy('name')
            ->paginate(50);

        return view('items.types.index', ['types' => $types]);
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
     * @param  int $id
     * @return Response
     */
    public function show(int $id)
    {
        $type = ItemType::with('parent', 'fields', 'fields.field')
            ->find($id);
        $storedAt = $type->storedAtIncludeParents();
        $storedHere = $type->storedHereIncludeParents();

        return view('items.types.view', ['type' => $type, 'storedAt' => $storedAt, 'storedHere' => $storedHere]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Rulla\Items\Types\ItemType  $itemType
     * @return Response
     */
    public function edit(ItemType $itemType)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \Rulla\Items\Types\ItemType  $itemType
     * @return Response
     */
    public function update(Request $request, ItemType $itemType)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Rulla\Items\Types\ItemType  $itemType
     * @return Response
     */
    public function destroy(ItemType $itemType)
    {
        //
    }
}
