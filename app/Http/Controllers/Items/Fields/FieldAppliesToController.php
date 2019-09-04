<?php

namespace Rulla\Http\Controllers\Items\Fields;

use Illuminate\Http\Response;
use Rulla\Http\Requests\FieldAppliesToRequest;
use Rulla\Items\Fields\Field;
use Rulla\Items\Fields\FieldAppliesTo;
use Illuminate\Http\Request;
use Rulla\Http\Controllers\Controller;
use Rulla\Items\Types\ItemType;

class FieldAppliesToController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $fields = Field::where('system', false)
            ->orderBy('name')
            ->get();

        $types = ItemType::orderByDesc('system')
            ->orderBy('name')
            ->get();

        return view('items.fields.applies_to.add', ['fields' => $fields->values(), 'types' => $types->values()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param FieldAppliesToRequest $request
     * @return Response
     */
    public function store(FieldAppliesToRequest $request)
    {
        $fieldAppliesTo = FieldAppliesTo::create($request->validated());
        return redirect()->route('items.fields.view', $fieldAppliesTo->field_id);
    }

    /**
     * Display the specified resource.
     *
     * @param FieldAppliesTo $fieldAppliesTo
     * @return Response
     */
    public function show(FieldAppliesTo $fieldAppliesTo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param FieldAppliesTo $fieldAppliesTo
     * @return Response
     */
    public function edit(FieldAppliesTo $fieldAppliesTo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param FieldAppliesTo $fieldAppliesTo
     * @return Response
     */
    public function update(Request $request, FieldAppliesTo $fieldAppliesTo)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param FieldAppliesTo $fieldAppliesTo
     * @return Response
     */
    public function destroy(FieldAppliesTo $fieldAppliesTo)
    {
        //
    }
}
