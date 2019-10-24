<?php

namespace Rulla\Authentication\Models\ACL;

use Spatie\Enum\Enum;

/**
 * @method static self ALLOW()
 * @method static self DENY()
 * @method static self DEFAULT()
 */
class AccessControlAction extends Enum
{}
