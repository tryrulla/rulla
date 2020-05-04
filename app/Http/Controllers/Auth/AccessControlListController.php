<?php

namespace Rulla\Http\Controllers\Auth;

use Illuminate\Http\Response;
use Illuminate\Auth\Access\AuthorizationException;
use Rulla\Authentication\Models\ACL\AccessControlList;
use Illuminate\Http\Request;
use Rulla\Http\Controllers\Controller;

class AccessControlListController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $this->authorize('viewAny', AccessControlList::class);
        $acls = AccessControlList::orderByDesc('priority')->paginate(50);
        return view('acls.index', ['acls' => $acls]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return void
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return void
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
     * @throws AuthorizationException
     */
    public function show(int $id)
    {
        $acl = AccessControlList::with([])
            ->findOrFail($id);

        $this->authorize('view', $acl);
        return view('acls.view', ['acl' => $acl]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param AccessControlList $acl
     * @return void
     */
    public function edit(AccessControlList $acl)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param AccessControlList $acl
     * @return void
     */
    public function update(Request $request, AccessControlList $acl)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param AccessControlList $acl
     * @return void
     */
    public function destroy(AccessControlList $acl)
    {
        //
    }
}
