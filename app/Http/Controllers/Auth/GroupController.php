<?php

namespace Rulla\Http\Controllers\Auth;

use Illuminate\Http\Response;
use Rulla\Authentication\Models\Groups\Group;
use Illuminate\Http\Request;
use Rulla\Http\Controllers\Controller;

class GroupController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize('viewAny', Group::class);
        $groups = Group::paginate(50);
        return view('users.groups.index', ['groups' => $groups]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $this->authorize('create', Group::class);
        return view('users.groups.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Group::class);
        $data = $request->validate([
            'name' => 'nullable|min:2',
        ]);

        $group = Group::create($data);
        return redirect($group->view_url);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function show(int $id)
    {
        $group = Group::findOrFail($id);
        $this->authorize('view', $group);
        return view('users.groups.view', ['group' => $group]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Response
     */
    public function edit(int $id)
    {
        $group = Group::findOrFail($id);
        $this->authorize('update', $group);
        return view('users.groups.edit', ['group' => $group]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, int $id)
    {
        $group = Group::findOrFail($id);
        $this->authorize('update', $group);

        $data = $request->validate([
            'name' => 'nullable|min:2',
        ]);

        $group->update($data);
        return redirect($group->view_url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Group $group
     * @return Response
     */
    public function destroy(Group $group)
    {
        $this->authorize('delete', $group);
    }
}
