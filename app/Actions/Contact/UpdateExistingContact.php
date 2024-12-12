<?php

namespace App\Actions\Contact;

use App\Models\Contact;
use App\DTOs\ContactDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Http\Resources\ContactResource;
use Lorisleiva\Actions\Concerns\AsAction;

class UpdateExistingContact
{
    use AsAction;

    public function handle(Contact $contact, ContactDTO $contactDTO): Contact
    {
        Gate::authorize('update', $contact);

        $contact->update($contactDTO->toArray());
        return $contact;
    }

    public function asController(Contact $contact, ContactDTO $contactDTO): JsonResponse
    {
        return response()->json(new ContactResource($this->handle($contact, $contactDTO)));
    }
}
