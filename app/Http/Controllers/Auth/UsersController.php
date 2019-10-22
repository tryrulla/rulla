<?php

namespace Rulla\Http\Controllers\Auth;

use Exception;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Rulla\Authentication\Models\Groups\UserInGroup;
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
        $users = User::paginate(50);
        return view('users.profile.index', ['users' => $users]);
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
     * @param User $user
     * @return Response
     */
    public function show(User $user)
    {
        $user->loadMissing('assignedFaults', 'assignedFaults.item', 'assignedFaults.item.type');
        return view('users.profile.view', ['user' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param User $user
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
     * @param User $user
     * @return Response
     * @throws Exception
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'nullable|min:2',
        ]);

        if ($request->has('groups')) {
            try {
                DB::beginTransaction();

                $newGroups = collect(json_decode($request->get('groups')));
                $oldGroupIds = $user->groups()
                    ->pluck('groups.id')
                    ->toArray();

                UserInGroup::where('user_id', $user->id)
                    ->whereNotIn('group_id', $newGroups)
                    ->delete();

                $newGroups->each(function ($newGroupId) use ($user) {
                    UserInGroup::updateOrCreate([
                        'user_id' => $user->id,
                        'group_id' => $newGroupId,
                    ]);
                });

                $newGroupIds = $user->groups()
                    ->pluck('groups.id')
                    ->toArray();
                $user->addPendingChange('groups', $oldGroupIds, $newGroupIds);
                DB::commit();
            } catch (Exception $ex) {
                DB::rollback();
                throw $ex;
            }
        }

        $user->update($data);
        $user->savePendingChanges();
        return redirect($user->view_url);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return Response
     */
    public function destroy(User $user)
    {
        //
    }
}
