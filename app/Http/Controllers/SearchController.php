<?php

namespace Rulla\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Rulla\Authentication\Models\User;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $filters = $request->get('filters');
        $types = $filters['type'] ?? [];
        if (!is_array($types)) {
            $types = [$types];
        }

        $query = $filters['query'] ?? '';

        $results = collect();

        $typeOnly = '';

        if (preg_match('/([U])(\d+)/', $query, $idMatches)) {
            $typeOnly = $idMatches[1];
            $filters['id'] = (int) $idMatches[2];
            $query = '';
        }

        $id = intval($filters['id']);

        if (in_array(User::class, $types) && ($typeOnly === '' || $typeOnly === 'U')) {
            User::query()
                ->where(function (Builder $builder) use ($query) {
                    if ($query && strlen($query) >= 1) {
                        return $builder->where('name', 'like', '%' . $query . '%')
                            ->orWhere('email', 'like', '%' . $query . '%');
                    }

                    return $builder;
                })
                ->where(function (Builder $builder) use ($id) {
                    if ($id > 0) {
                        return $builder->where('id', $id);
                    }

                    return $builder;
                })
                ->get()
                ->map(function (User $user) {
                    return [
                        'type' => User::class,
                        'id' => $user->id,
                        'identifier' => $user->identifier,
                        'viewUrl' => $user->view_url,
                        'name' => $user->name,
                        'email' => $user->email,
                    ];
                })
                ->each(function ($user) use ($results) {
                    return $results->push($user);
                });
        }

        return response()->json(['results' => $results->toArray()]);
    }
}
