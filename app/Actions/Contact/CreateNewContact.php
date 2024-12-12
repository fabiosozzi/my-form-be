<?php

namespace App\Actions\Contact;

use App\DTOs\ContactDTO;
use App\Http\Resources\ContactResource;
use App\Models\Contact;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsAction;

class CreateNewContact
{
    use AsAction;

    public function handle(ContactDTO $contactDTO): Contact
    {
        return Contact::create($contactDTO->toArray());
    }

    public function asController(ContactDTO $contactDTO): JsonResponse
    {
        return response()->json(new ContactResource($this->handle($contactDTO)));
    }
}
