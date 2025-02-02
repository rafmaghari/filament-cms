<?php

namespace App\Traits;

use App\Models\Group;
use App\Models\GroupUser;
use App\Models\Organization;

trait HasConnection
{
    protected function groupsUnderMyCare($user)
    {
        $groupsUnderMyOrganization = Group::whereIn('organization_id', $user->organizations->plucK('id'))->get();
        return GroupUser::whereIn('group_id', $groupsUnderMyOrganization->pluck('id'))->get();
    }

    protected function myOrganization($user)
    {
        if ($user->hasRole('admin')) {
            return $user->organizations;
        } else {
            return Organization::where('id', $user->groups->organization->plucK('id'));
        }
    }
}
