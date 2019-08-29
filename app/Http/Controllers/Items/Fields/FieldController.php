<?php

namespace Rulla\Http\Controllers\Items\Fields;

use Illuminate\Http\Response;
use Rulla\Http\Controllers\Controller;
use Rulla\Items\Fields\Field;
use Illuminate\Http\Request;

class FieldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $fields = Field::orderByDesc('system')
            ->orderBy('name')
            ->paginate(50);

        return view('items.fields.index', ['fields' => $fields]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('items.fields.add');
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
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $field = Field::with('values', 'values.field', 'appliesTo', 'appliesTo.type')
            ->find($id);
        return view('items.fields.view', ['field' => $field]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Rulla\Items\Fields\Field  $field
     * @return Response
     */
    public function edit(Field $field)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \Rulla\Items\Fields\Field  $field
     * @return Response
     */
    public function update(Request $request, Field $field)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Rulla\Items\Fields\Field  $field
     * @return Response
     */
    public function destroy(Field $field)
    {
        //
    }
}
