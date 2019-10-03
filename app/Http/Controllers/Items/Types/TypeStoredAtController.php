<?php

namespace Rulla\Http\Controllers\Items\Types;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Rulla\Http\Requests\CreateTypeStoredAtRequest;
use Rulla\Items\Types\ItemType;
use Rulla\Items\Types\TypeStoredAt;
use Illuminate\Http\Request;
use Rulla\Http\Controllers\Controller;

class TypeStoredAtController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        return view('items.types.storage_types.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateTypeStoredAtRequest $request
     * @return Response
     */
    public function store(CreateTypeStoredAtRequest $request)
    {
        if ($request->input('storage') === false && $request->input('checkout') === false) {
            TypeStoredAt::where($request->only(['stored_type_id', 'storage_type_id']))
                ->delete();

            return redirect()->route('items.types.view', $request->input('stored_type_id'));
        }

        TypeStoredAt::updateOrInsert($request->only(['stored_type_id', 'storage_type_id']), $request->validated());
        return redirect()->route('items.types.view', $request->input('stored_type_id'));
    }

    /**
     * Display the specified resource.
     *
     * @param TypeStoredAt $typeStoredAt
     * @return Response
     */
    public function show(TypeStoredAt $typeStoredAt)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param TypeStoredAt $typeStoredAt
     * @return Response
     */
    public function edit(TypeStoredAt $typeStoredAt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param TypeStoredAt $typeStoredAt
     * @return Response
     */
    public function update(Request $request, TypeStoredAt $typeStoredAt)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param TypeStoredAt $typeStoredAt
     * @return Response
     * @throws Exception
     */
    public function destroy(TypeStoredAt $stored)
    {
        abort_if($stored->stored_type_id <= 1000, 400, "Can't delete typeStoredAt with system types");
        abort_if($stored->storage_type_id <= 1000, 400, "Can't delete typeStoredAt with system types");

        $stored->delete();
        return redirect()
            ->back()
            ->with('notice', __('items.types.storage.deleted'));
    }
}
