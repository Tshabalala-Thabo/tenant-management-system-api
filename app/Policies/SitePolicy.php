<?php

namespace App\Policies;

use App\Models\Site;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SitePolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * return void // i removed @ before the return
     */

    public function view(User $user, Site $site)
    {
        // Allow only landlords to view their own sites
        return $user->hasRole('landlord') && $site->user_id == $user->id;
    }

    /**
     * Determine whether the user can edit the site.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Site  $site
     * @return mixed
     */
    public function edit(User $user, Site $site)
    {
        // Allow only users with the 'edit sites' permission to edit sites
        return $user->can('edit sites') && $site->user_id == $user->id;
    }

    public function __construct()
    {
        //
    }
}
