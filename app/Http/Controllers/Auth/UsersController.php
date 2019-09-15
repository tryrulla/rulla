<?php

namespace Rulla\Http\Controllers\Auth;

use Illuminate\Http\Response;
use Rulla\Authentication\Models\User;
use Illuminate\Http\Request;
use Rulla\Http\Controllers\Controller;

class UsersController extends Controller
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

    public function self(Request $request)
    {
        return redirect()->route('user.profile.view', $request->user());
    }

    /**
     * Display the specified resource.
     *
     * @param  \Rulla\Authentication\Models\User  $user
     * @return Response
     */
    public function show(User $user)
    {
        return view('users.profile.view', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Rulla\Authentication\Models\User  $user
     * @return Response
     */
    public function edit(User $user)
    {
        return view('users.profile.edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  \Rulla\Authentication\Models\User  $user
     * @return Response
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'nullable|min:2',
        ]);

        $user->update($data);
        return redirect($user->view_url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Rulla\Authentication\Models\User  $user
     * @return Response
     */
    public function destroy(User $user)
    {
        //
    }
}
