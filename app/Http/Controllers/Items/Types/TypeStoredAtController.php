<?php

namespace Rulla\Http\Controllers\Items\Types;

use Illuminate\Validation\Rule;
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
            ->orderBy('name')
            ->get()
            ->partition(function (ItemType $it) {
                return $it->hasParent(1);
            });

        return view('items.types.storage_types.add', ['itemTypes' => $itemTypes->values(), 'locations' => $locations->values()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'stored_type_id' => [
                'required',
                Rule::exists('item_types', 'id')->where('system', 'false'),
            ],
            'storage_type_id' => [
                'required',
                Rule::exists('item_types', 'id')->where('system', 'false'),
            ]
        ]);

        $typeStoredAt = TypeStoredAt::create($data);
        return redirect()->route('items.types.view', $typeStoredAt->stored_type_id);
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
