<?php

namespace Rulla\Http\Controllers\Items\Instances;

use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Rulla\Http\Controllers\Controller;
use Rulla\Http\Requests\CreateInstanceRequest;
use Rulla\Items\Instances\Item;
use Illuminate\Http\Request;
use Rulla\Items\Types\ItemType;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $items = Item::with('type', 'location')
            ->paginate(50);

        return view('items.instances.index', ['items' => $items]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        [$types, $locations] = ItemType::with('parents')
            ->where('system', false)
            ->orderBy('name')
            ->get()
            ->partition(function (ItemType $type) {
                return $type->hasParent(1);
            });

        return view('items.instances.add', ['types' => $types->values(), 'locations' => $locations->values()]);
    }

    /**
     * @param int $id
     * @return JsonResponse
     */
    public function getApplicableLocations(int $id)
    {
        $type = ItemType::with('parents')
            ->where('system', false)
            ->findOrFail($id);

        $locations = Item::whereIn('type_id', function (Builder $query) use ($type) {
            return $query->from('item_types')
                ->whereIn('id', function (Builder $query) use ($type) {
                    return $query->from('type_stored_ats')
                        ->whereIn('stored_type_id', $type->getAllParentIds())
                        ->select('storage_type_id');
                })
                ->select('id');
            })
            ->get();

        return response()->json($locations);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateInstanceRequest $request
     * @return Response
     */
    public function store(CreateInstanceRequest $request)
    {
        $item = Item::create($request->validated());
        return redirect($item->view_url);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return void
     */
    public function show(int $id)
    {
        $item = Item::with('type', 'location', 'locatedHere')
            ->findOrFail($id);

        return view('items.instances.view', ['item' => $item]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Rulla\Items\Instances\Item  $item
     * @return Response
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \Rulla\Items\Instances\Item  $item
     * @return Response
     */
    public function update(Request $request, Item $item)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Rulla\Items\Instances\Item  $item
     * @return Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
