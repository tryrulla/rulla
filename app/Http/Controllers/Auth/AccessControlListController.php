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

    public function create()
    {
        //
    }

    public function store(Request $request)
    {
        //
    }

    public function show(int $id)
    {
        $acl = AccessControlList::with([])
            ->findOrFail($id);

        $this->authorize('view', $acl);
        return view('acls.view', ['acl' => $acl]);
    }

    public function edit(AccessControlList $acl)
    {
        //
    }

    public function update(Request $request, AccessControlList $acl)
    {
        //
    }

    public function destroy(AccessControlList $acl)
    {
        //
    }
}
