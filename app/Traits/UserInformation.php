<?php

namespace App\Traits;

use App\Models\Group;
use App\Models\GroupUser;

trait UserInformation
{
    protected function userDetails()
    {
        return auth()->user();
    }
}
