<?php

namespace Rulla\Http\Controllers\Items\Instances;

use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Rulla\Http\Controllers\Controller;
use Rulla\Http\Requests\CreateInstanceRequest;
use Rulla\Items\Fields\Field;
use Rulla\Items\Instances\Item;
use Illuminate\Http\Request;
use Rulla\Items\Types\ItemType;
use Validator;

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

        $fields = $this->fields($type);

        return response()->json($locations);
    }

    public function getApplicableFields(int $id)
    {
        $type = ItemType::with('parents')
            ->where('system', false)
            ->findOrFail($id);

        return response()->json($this->fields($type));
    }

    private function fields(ItemType $type)
    {
        $typeIdsForFields = $type->getAllParentIds(true);

        return Field::whereHas('appliesTo', function (\Illuminate\Database\Eloquent\Builder $query) use ($typeIdsForFields) {
            $query->where('apply_to_item', true)
                ->whereIn('type_id', $typeIdsForFields);
        })
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateInstanceRequest $request
     * @return Response
     * @throws Exception
     */
    public function store(CreateInstanceRequest $request)
    {
        $item = Item::create($request->validated());
        $item->processFieldUpdate($request);

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
        $item = Item::with('type', 'location', 'locatedHere', 'fields')
            ->findOrFail($id);

        return view('items.instances.view', ['item' => $item]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id)
    {
        $item = Item::with('location', 'type', 'type.parents', 'fields')
            ->findOrFail($id);

        [$types, $locations] = ItemType::with('parents')
            ->where('system', false)
            ->orderBy('name')
            ->get()
            ->partition(function (ItemType $type) {
                return $type->hasParent(1);
            });

        $fields = $this->fields($item->type);

        return view('items.instances.edit', ['item' => $item, 'types' => $types->values(), 'locations' => $locations->values(), 'fields' => $fields]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     * @throws Exception
     */
    public function update(Request $request, int $id)
    {
        $item = Item::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'tag' => [
                'nullable',
                Rule::unique('items', 'tag')->ignore($item->id, 'id'),
            ],
            'type_id' => [
                'required',
                Rule::exists('item_types', 'id')->where('system', 'false'),
            ],
        ]);

        $validator->sometimes(['location_id', 'location_type'], ['required'], function ($input) {
            return in_array($input->location_type, [ItemType::class, Item::class]);
        });

        $item->update($validator->validated());
        $item->processFieldUpdate($request);
        return redirect($item->view_url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Item $item
     * @return Response
     */
    public function destroy(Item $item)
    {
        //
    }
}
