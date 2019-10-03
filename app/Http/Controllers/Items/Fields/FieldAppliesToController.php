<?php

namespace Rulla\Http\Controllers\Items\Fields;

use Exception;
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
        if ($request->input('apply_to_item') === false && $request->input('apply_to_type') === false) {
            FieldAppliesTo::where($request->only(['field_id', 'type_id']))
                ->delete();

            return redirect()->route('items.fields.view', $request->input('field_id'));
        }

        FieldAppliesTo::updateOrInsert($request->only(['field_id', 'type_id']), $request->validated());
        return redirect()->route('items.fields.view', $request->input('field_id'));
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
     * @param FieldAppliesTo $fat
     * @return Response
     * @throws Exception
     */
    public function destroy(FieldAppliesTo $fat)
    {
        $fat->delete();
        return redirect()
            ->route('items.fields.view', $fat->field_id)
            ->with('notice', __('items.fields.apply_to.deleted'));
    }
}
