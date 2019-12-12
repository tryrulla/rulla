<?php

namespace Rulla\Authentication\Models\ACL;

use Spatie\Enum\Enum;

/**
 * @method static self DEFAULT()
 * @method static self LIST()
 * @method static self VIEW()
 * @method static self EDIT()
 * @method static self CREATE()
 * @method static self DELETE()
 * @method static self FORCEDELETE()
 */
class AccessControlAction extends Enum
{}
