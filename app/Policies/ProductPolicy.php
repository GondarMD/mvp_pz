<?php

namespace App\Policies;

use App\Models\User;

class ProductPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function create(User $user)
    {
        return $user->hasPermissionTo('create products');
    }

    public function viewAny(User $user)
    {
        return $user->hasPermissionTo('view products');
    }

    public function view(User $user)
    {
        return $user->hasPermissionTo('view products');
    }

    public function update(User $user)
    {
        return $user->hasPermissionTo('edit products');
    }
    
    public function delete(User $user)
    {
        return $user->hasPermissionTo('delete products');
    }

    
}
