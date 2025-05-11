<?php

namespace App\Policies;

use App\Models\User;
use App\Models\WarehouseLocation;
use Illuminate\Auth\Access\Response;

class WarehouseLocationPolicy
{
    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, WarehouseLocation $warehouseLocation): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, WarehouseLocation $warehouseLocation): bool
    {
        return $user->role === 'admin';
    }

}
