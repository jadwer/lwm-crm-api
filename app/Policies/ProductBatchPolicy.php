<?php

namespace App\Policies;

use App\Models\ProductBatch;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductBatchPolicy
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
    public function update(User $user, ProductBatch $productBatch): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductBatch $productBatch): bool
    {
        return $user->role === 'admin';
    }

}
