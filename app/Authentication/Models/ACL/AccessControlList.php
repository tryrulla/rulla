<?php

namespace Rulla\Authentication\Models\ACL;

use Illuminate\Database\Eloquent\Model;
use Rulla\Comments\HasComments;
use Rulla\Comments\SavesActivityAsComments;
use Rulla\Meta\HasViewUrl;

class AccessControlList extends Model
{
    use HasViewUrl;
    use HasComments, SavesActivityAsComments;
    use HasAccessControl;

    protected $guarded = [];
    protected $casts = [
        'system' => 'boolean',
        'data' => 'object',
    ];

    public function getIdentifierPrefixLetter(): string
    {
        return 'A';
    }

    public static function defaultRuleList()
    {
        return self::orderByDesc('priority')
            ->get();
    }

    public function getFieldNameTranslationPrefix()
    {
        return 'acl.fields.';
    }
}
