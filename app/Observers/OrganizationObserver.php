<?php

namespace App\Observers;

use App\Models\Organization;

class OrganizationObserver
{

    public function created(Organization $organization)
    {
    }

    public function creating(Organization $organization):void
    {
        $organization->account()->associate(auth()->user());
    }

    public function updated(Organization $organization)
    {
        
    }

    public function deleted(Organization $organization)
    {
        
    }

    public function restored(Organization $organization)
    {
        
    }

    public function forceDeleted(Organization $organization)
    {
        
    }
}
