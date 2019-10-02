<?php

namespace Rulla\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Rulla\Authentication\Models\User;
use Rulla\Items\Instances\Item;
use Rulla\Items\Types\ItemType;

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
        $filters = $request->input('filters');
        $types = $filters['type'] ?? [];
        if (!is_array($types)) {
            $types = [$types];
        }

        $query = $filters['query'] ?? '';

        $results = collect();

        $typeOnly = '';

        if (preg_match('/([UT]|I[FC]?)(\d+)/', $query, $idMatches)) {
            $typeOnly = $idMatches[1];
            $filters['id'] = (int) $idMatches[2];
            $query = '';
        } else if (preg_match('/(\d+)/', $query, $idMatches) && sizeof($types) === 1) {
            $filters['id'] = (int) $idMatches[1];
            $query = '';
        }

        $id = intval($filters['id'] ?? '');

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

        if (in_array(Item::class, $types) && ($typeOnly === '' || $typeOnly === 'I')) {
            Item::query()
                ->where(function (Builder $builder) use ($query) {
                    if ($query && strlen($query) >= 1) {
                        return $builder->where('tag', 'like', '%' . $query . '%');
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
                ->map(function (Item $item) {
                    return [
                        'type' => Item::class,
                        'id' => $item->id,
                        'identifier' => $item->identifier,
                        'viewUrl' => $item->view_url,
                        'tag' => $item->tag,
                        'type_id' => $item->type_id,
                        'location_id' => $item->location_id,
                    ];
                })
                ->each(function ($item) use ($results) {
                    return $results->push($item);
                });
        }

        if (in_array(ItemType::class, $types) && ($typeOnly === '' || $typeOnly === 'T')) {
            ItemType::query()
                ->where(function (Builder $builder) use ($query) {
                    if ($query && strlen($query) >= 1) {
                        return $builder->where('name', 'like', '%' . $query . '%');
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
                ->map(function (ItemType $type) {
                    return [
                        'type' => Item::class,
                        'id' => $type->id,
                        'name' => $type->name,
                        'identifier' => $type->identifier,
                        'viewUrl' => $type->view_url,
                        'parent_id' => $type->parent_id,
                    ];
                })
                ->each(function ($type) use ($results) {
                    return $results->push($type);
                });
        }

        return response()->json(['results' => $results->toArray()]);
    }
}
