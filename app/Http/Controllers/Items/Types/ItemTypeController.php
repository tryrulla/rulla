<?php

namespace Rulla\Http\Controllers\Items\Types;

use DB;
use Exception;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;
use Rulla\Items\Fields\Field;
use Rulla\Items\Types\ItemType;
use Illuminate\Http\Request;
use Rulla\Http\Controllers\Controller;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $types = ItemType::orderByDesc('system')
            ->orderBy('name')
            ->paginate(50);

        return view('items.types.index', ['types' => $types]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $parents = ItemType::orderByDesc('system')
            ->orderBy('name')
            ->get();

        return view('items.types.add', ['parents' => $parents]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     * @throws Exception
     */
    public function store(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|min:2',
            'parent_id' => [
                'required',
                Rule::exists('item_types', 'id'),
            ]
        ]);

        $type = ItemType::create($fields);
        $type->processFieldUpdate($request);

        return redirect($type->view_url);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function show(int $id)
    {
        $type = ItemType::with('parent', 'parents', 'children', 'fields', 'fields.field', 'instances', 'instances.location', 'locatedHere', 'locatedHere.location')
            ->findOrFail($id);
        $storedAt = $type->storedAtIncludeParents();
        $storedHere = $type->storedHereIncludeParents();

        return view('items.types.view', ['type' => $type, 'storedAt' => $storedAt, 'storedHere' => $storedHere]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id)
    {
        $type = ItemType::with('parent', 'fields', 'fields.field')
            ->find($id);

        abort_if($type->system, 400, 'System can\'t be edited');

        $parentChoices = ItemType::with('parents')
            ->orderBy('name')
            ->get()
            ->filter(function (ItemType $it) use ($type) {
                return !$it->hasParent($type->id);
            })
            ->filter(function (ItemType $it) use ($type) {
                return $it->hasParent($type->getGrandparent(), true);
            })
            ->values();


        $fields = $this->fields($type);

        return view('items.types.edit', ['type' => $type, 'parentChoices' => $parentChoices, 'fields' => $fields]);
    }

    public function getFields(int $id) {
        return response()->json($this->fields(ItemType::findOrFail($id)));
    }

    private function fields(ItemType $type) {
        $typeIdsForFields = $type->getAllParentIds()
            ->push($type->id);

        return Field::whereHas('appliesTo', function (Builder $query) use ($typeIdsForFields) {
            $query->where('apply_to_type', true)
                ->whereIn('type_id', $typeIdsForFields);
        })
            ->get();
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
        $type = ItemType::with('parents')
            ->find($id);

        abort_if($type->system, 400, 'System can\'t be edited');

        $type->processFieldUpdate($request);

        $newData = $request->validate([
            'name' => 'required|min:2',
            'parent_id' => [
                'required',
                Rule::exists('item_types', 'id')->whereNot('id', $type->id),
                function ($attribute, $value, $fail) use ($type) {
                    $another = ItemType::with('parents')
                        ->findOrFail($value);

                    while ($another->parents) {
                        if ($another->id === $type->id) {
                            $fail('Type tree may not generate a loop.');
                            return;
                        }

                        $another = $another->parents;
                    }

                    // another = new grandparent (logic!)
                    $ogGrandparent = $type->getGrandparent();

                    if ($another->id !== $ogGrandparent->id) {
                        $fail('Grantparent can\'t be changed');
                        return;
                    }

                    // TODO: Validate custom fields and storage
                }
            ]
        ]);

        $type->update($newData);
        return redirect($type->view_url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Rulla\Items\Types\ItemType  $itemType
     * @return Response
     */
    public function destroy(ItemType $itemType)
    {
        //
    }
}
