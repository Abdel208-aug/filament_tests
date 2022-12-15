<?php

namespace App\Observers;

use App\Models\Contact;

class ContactObserver
{
    public function created(Contact $contact)
    {
        //
    }
    public function creating(Contact $contact):void
    {
        $contact->account()->associate(auth()->user());
    }
    
    public function updated(Contact $contact)
    {
        //
    }

    public function deleted(Contact $contact)
    {
        //
    }

    public function restored(Contact $contact)
    {
        //
    }

    public function forceDeleted(Contact $contact)
    {
        //
    }
}
