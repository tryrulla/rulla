<?php

namespace Rulla\Http\Controllers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Rulla\Authentication\Models\ACL\AccessControlList;
use Rulla\Authentication\Models\Groups\Group;
use Rulla\Authentication\Models\User;
use Rulla\Items\Instances\Item;
use Rulla\Items\Types\ItemType;

class SearchController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return Response
     */
    public function __invoke(Request $request)
    {
        $filters = $request->input('filters');
        $results = self::search($filters, true);

        return response()->json(['results' => $results->toArray()]);
    }

    /**
     * @param array $filters
     * @param bool $map
     */
    public static function search(array $filters, $map = false)
    {
        $types = $filters['type'] ?? [];
        if (!is_array($types)) {
            $types = [$types];
        }

        $query = $filters['query'] ?? '';

        $results = collect();

        $typeOnly = '';

        if (preg_match('/([UTGA]|I[FC]?)(\d+)/', $query, $idMatches)) {
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
                ->map(function (User $user) use ($map) {
                    if (!$map) {
                        return $user;
                    }

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
                ->where(function (Builder $builder) use ($filters) {
                    if (array_key_exists('storage-location', $filters)) {
                        $type = Item::findOrFail($filters['storage-location']['id'])
                            ->type()
                            ->with('parents')
                            ->where('system', false)
                            ->firstOrFail();

                        return $builder->whereIn('type_id', function (QueryBuilder $query) use ($type, $filters) {
                            return $query->from('item_types')
                                ->whereIn('id', function (QueryBuilder $query) use ($type, $filters) {
                                    return $query->from('type_stored_ats')
                                        ->whereIn('stored_type_id', $type->getAllParentIds(true))
                                        ->where($filters['storage-location']['stored_at'])
                                        ->select('storage_type_id');
                                })
                                ->select('id');
                        });
                    }

                    return $builder;
                })
                ->get()
                ->map(function (Item $item) use ($map) {
                    if (!$map) {
                        return $item;
                    }

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
                ->with(array_key_exists('type-has-parent', $filters) ? ['parents'] : [])
                ->get()
                ->filter(function (ItemType $type) use ($filters) {
                    if (array_key_exists('type-has-parent', $filters)) {
                        return $type->hasParent($filters['type-has-parent'], true);
                    }

                    return true;
                })
                ->map(function (ItemType $type) use ($map) {
                    if (!$map) {
                        return $type;
                    }

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

        if (in_array(Group::class, $types) && ($typeOnly === '' || $typeOnly === 'G')) {
            Group::query()
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
                ->map(function (Group $group) use ($map) {
                    if (!$map) {
                        return $group;
                    }

                    return [
                        'type' => Group::class,
                        'id' => $group->id,
                        'identifier' => $group->identifier,
                        'viewUrl' => $group->view_url,
                        'name' => $group->name,
                    ];
                })
                ->each(function ($group) use ($results) {
                    return $results->push($group);
                });
        }

        if (in_array(AccessControlList::class, $types) && ($typeOnly === '' || $typeOnly === 'A')) {
            AccessControlList::query()
                ->where(function (Builder $builder) use ($id) {
                    if ($id > 0) {
                        return $builder->where('id', $id);
                    }

                    return $builder;
                })
                ->where(function (Builder $builder) use ($filters) {
                    if ($filters['system'] === true || $filters['system'] == false) {
                        return $builder->where('system', $filters['system']);
                    }

                    return $builder;
                })
                ->get()
                ->map(function (AccessControlList $acl) use ($map) {
                    if (!$map) {
                        return $acl;
                    }

                    return [
                        'type' => AccessControlList::class,
                        'id' => $acl->id,
                        'identifier' => $acl->identifier,
                        'viewUrl' => $acl->view_url,
                    ];
                })
                ->each(function ($acl) use ($results) {
                    return $results->push($acl);
                });
        }

        return $results;
    }
}
