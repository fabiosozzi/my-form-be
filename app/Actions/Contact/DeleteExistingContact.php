<?php

namespace App\Actions\Contact;

use App\Models\Contact;
use Illuminate\Support\Facades\Gate;
use Lorisleiva\Actions\Concerns\AsAction;

class DeleteExistingContact
{
    use AsAction;

    public function handle(Contact $contact)
    {
        Gate::authorize('delete', $contact);

        $contact->delete();
    }
    
    public function asController(Contact $contact)
    {
        $this->handle($contact);

        return response()->json(null, 204);
    }
}
