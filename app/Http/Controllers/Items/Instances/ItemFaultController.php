<?php

namespace Rulla\Http\Controllers\Items\Instances;

use Illuminate\Http\Response;
use Rulla\Http\Controllers\Controller;
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
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $fault = ItemFault::with('item', 'item.type')
            ->findOrFail($id);

        return view('items.instances.faults.view', ['fault' => $fault]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param ItemFault $itemFault
     * @return Response
     */
    public function edit(ItemFault $itemFault)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param ItemFault $itemFault
     * @return Response
     */
    public function update(Request $request, ItemFault $itemFault)
    {
        //
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
