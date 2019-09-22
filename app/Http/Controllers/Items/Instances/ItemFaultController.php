<?php

namespace Rulla\Http\Controllers\Items\Instances;

use Illuminate\Http\Response;
use Rulla\Http\Controllers\Controller;
use Rulla\Http\Requests\EditItemFaultRequest;
use Rulla\Items\Instances\ItemFault;
use Illuminate\Http\Request;

class ItemFaultController extends Controller
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
        return view('items.instances.faults.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|max:150',
            'description' => 'required',
            'item_id' => 'required|exists:items,id',
            'assignee_id' => 'nullable|exists:users,id',
        ]);

        $fault = ItemFault::create($data);
        return redirect($fault->view_url);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $fault = ItemFault::with('item', 'item.type', 'assignee', 'comments', 'comments.user')
            ->findOrFail($id);

        return view('items.instances.faults.view', ['fault' => $fault]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id)
    {
        $fault = ItemFault::findOrFail($id);
        return view('items.instances.faults.edit', ['fault' => $fault]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(EditItemFaultRequest $request, int $id)
    {
        $fault = ItemFault::findOrFail($id);
        $fault->update($request->validated());
        return redirect($fault->view_url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ItemFault $itemFault
     * @return Response
     */
    public function destroy(ItemFault $itemFault)
    {
        //
    }
}
