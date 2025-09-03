<?php

namespace App\Policies;

use App\Models\ProductCategory;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class ProductCategoryPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
       // return false;
       return in_array($user->role, [
            'SUPER_ADMIN',
            'PROPERTY_MANAGER',
            'OFFICE_MANAGER',
            'SECURITY_PERSONNEL',
            'MAINTENANCE_STAFF',
            'CONSTRUCTION_SUPERVISOR'
       ]);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ProductCategory $productCategory): bool
    {
        //return false;
        return in_array($user->role, [
            'SUPER_ADMIN',
            'PROPERTY_MANAGER',
            'OFFICE_MANAGER',
            'SECURITY_PERSONNEL',
            'MAINTENANCE_STAFF',
            'CONSTRUCTION_SUPERVISOR'
        ]);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        //return false;
        return in_array($user->role, [
            'SUPER_ADMIN',
            'PROPERTY_MANAGER',
            'OFFICE_MANAGER',
            'SECURITY_PERSONNEL'
        ]);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ProductCategory $productCategory): bool
    {
        //return false;
        return in_array($user->role, [
            'SUPER_ADMIN',
            'PROPERTY_MANAGER',
            'OFFICE_MANAGER',
            'SECURITY_PERSONNEL'
        ]);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ProductCategory $productCategory): bool
    {
        //return false;
        return in_array($user->role, [
            'SUPER_ADMIN',
            'SECURITY_PERSONNEL'
        ]);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ProductCategory $productCategory): bool
    {
      //  return false;
      return in_array($user->role, [
            'SUPER_ADMIN',
            'PROPERTY_MANAGER',
            'OFFICE_MANAGER',
            'SECURITY_PERSONNEL'
      ]);
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ProductCategory $productCategory): bool
    {
        return false;
    }
}
