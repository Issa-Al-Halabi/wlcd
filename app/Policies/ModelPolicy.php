<?php

namespace App\Policies;

use App\Breadcum;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ModelPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(User $user)
    {
        //
    }

   
    public function view(User $user)
    {
        //
    }

    
    public function create(User $user)
    {
        //
    }

    
    public function update(User $user)
    {
        //
    }

    
    public function delete(User $user)
    {
        //
    }

    
    public function restore(User $user)
    {
        //
    }

    
    public function forceDelete(User $user)
    {
        //
    }
}
