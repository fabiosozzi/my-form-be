<?php

namespace App\Jobs;

use App\Models\Contact;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use League\Csv\Writer;
use SplTempFileObject;
use Illuminate\Support\Facades\Storage;

class ExportAndEmailContacts implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $email;

    /**
     * Create a new job instance.
     */
    public function __construct($email)
    {
        $this->email = $email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Create CSV file
        $csv = Writer::createFromFileObject(new SplTempFileObject());
        $csv->setDelimiter(';');
        $csv->setEnclosure('"');
        $csv->insertOne(['Nome', 'Cognome', 'Data di nascita', 'Email', 'Numero di telefono', 'Codice fiscale']);

        Contact::chunk(100, function ($contacts) use ($csv) {
            foreach ($contacts as $contact) {
                $csv->insertOne(
                    [
                        $contact->first_name,
                        $contact->last_name,
                        $contact->date_of_birth,
                        $contact->email,
                        $contact->phone_number,
                        $contact->tax_id_code,
                    ]
                );
            }
        });

        // Save CSV to disk
        $filePath = 'contacts.csv';
        Storage::disk('local')->put($filePath, $csv->toString());

        // Send email with CSV attachment
        Mail::raw('In allegato il CSV dei contatti estratti dal BE.', function ($message) use ($filePath) {
            $message->to($this->email)
                    ->subject('Estrazione contatti dal BE')
                    ->attach(Storage::path($filePath));
        });

        Storage::delete($filePath);
    }
}
