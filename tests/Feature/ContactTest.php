<?php

use App\Models\User;
use App\Models\Contact;
use App\DTOs\ContactDTO;
use Database\Seeders\PermissionsSeeder;
use App\Actions\Contact\CreateNewContact;

beforeEach(function () {
    $this->seed(PermissionsSeeder::class);
    
    $this->superAdmin = User::factory()->create();
    $this->superAdmin->assignRole('super-admin');

    $this->admin = User::factory()->create();
});

it('can successfully create a contact', function () {
    $contact = Contact::factory()->make();
    $contactDTO = new ContactDTO($contact->toArray());
    CreateNewContact::run($contactDTO);

    $this->assertDatabaseHas('contacts', $contact->toArray());
})->group('contact');

it('can successfully modify a contact with API acting as Super-Admin', function () {
    $contact = Contact::factory()->create();
    
    $response = $this->actingAs($this->superAdmin)
        ->putJson(route('api.contacts.update', $contact->id), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'email' => 'john.doe@example.com',
            'phone_number' => '+1234567890',
            'tax_id_code' => '1234567890',
        ]);

    $response->assertStatus(200);
    $this->assertDatabaseHas('contacts', [
        'id' => $contact->id,
        'first_name' => 'John',
        'last_name' => 'Doe',
        'date_of_birth' => '1990-01-01',
        'email' => 'john.doe@example.com',
        'phone_number' => '+1234567890',
        'tax_id_code' => '1234567890',
    ]);
})->group('contact');

it('can successfully delete a contact with API acting as Super-Admin', function () {
    $contact = Contact::factory()->create();
    
    $response = $this->actingAs($this->superAdmin)
        ->deleteJson(route('api.contacts.delete', $contact->id));

    $response->assertStatus(204);
    $this->assertDatabaseMissing('contacts', ['id' => $contact->id]);
})->group('contact');

it('cannot modify a contact with API acting as Admin', function () {
    $contact = Contact::factory()->create();
    
    $response = $this->actingAs($this->admin)
        ->putJson(route('api.contacts.update', $contact->id), [
            'first_name' => 'John',
            'last_name' => 'Doe',
            'date_of_birth' => '1990-01-01',
            'email' => 'john.doe@example.com',
            'phone_number' => '+1234567890',
            'tax_id_code' => '1234567890',
        ]);
    $response->assertStatus(403);
})->group('contact');

it('cannot delete a contact with API acting as Admin', function () {
    $contact = Contact::factory()->create();
    
    $response = $this->actingAs($this->admin)
        ->deleteJson(route('api.contacts.delete', $contact->id));
    $response->assertStatus(403);
})->group('contact');

it('cannot modify a contact with API acting as Guest', function () {
    $contact = Contact::factory()->create();
    
    $response = $this->putJson(route('api.contacts.update', $contact->id), [
        'first_name' => 'John',
        'last_name' => 'Doe',
        'date_of_birth' => '1990-01-01',
        'email' => 'john.doe@example.com',
        'phone_number' => '+1234567890',
        'tax_id_code' => '1234567890',
    ]);
    $response->assertStatus(401);
})->group('contact');

it('cannot delete a contact with API acting as Guest', function () {
    $contact = Contact::factory()->create();
    
    $response = $this->deleteJson(route('api.contacts.delete', $contact->id));
    $response->assertStatus(401);
})->group('contact');