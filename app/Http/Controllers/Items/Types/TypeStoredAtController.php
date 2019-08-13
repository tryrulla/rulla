<?php

namespace Rulla\Http\Controllers\Items\Types;

use Rulla\Items\Types\ItemType;
use Rulla\Items\Types\TypeStoredAt;
use Illuminate\Http\Request;
use Rulla\Http\Controllers\Controller;

class TypeStoredAtController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        [$itemTypes, $locations] = ItemType::with('parents')
            ->where('system', false)
            ->orderByRaw('JSON_EXTRACT(name, \'$.en\')')
            ->get()
            ->partition(function (ItemType $it) {
                return $it->hasParent(1);
            });

        return view('items.types.storage_types.add', ['itemTypes' => $itemTypes, 'locations' => $locations]);
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
     * @param  \Rulla\Items\Types\TypeStoredAt  $typeStoredAt
     * @return \Illuminate\Http\Response
     */
    public function show(TypeStoredAt $typeStoredAt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Rulla\Items\Types\TypeStoredAt  $typeStoredAt
     * @return \Illuminate\Http\Response
     */
    public function edit(TypeStoredAt $typeStoredAt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Rulla\Items\Types\TypeStoredAt  $typeStoredAt
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TypeStoredAt $typeStoredAt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Rulla\Items\Types\TypeStoredAt  $typeStoredAt
     * @return \Illuminate\Http\Response
     */
    public function destroy(TypeStoredAt $typeStoredAt)
    {
        //
    }
}
