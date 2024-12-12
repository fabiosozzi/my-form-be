<?php

namespace App\Actions\Contact;

use App\Jobs\ExportAndEmailContacts;
use Lorisleiva\Actions\Concerns\AsAction;

class ExportContactToCSV
{
    use AsAction;

    public function handle()
    {
        // Export all contacts to a CSV file
        ExportAndEmailContacts::dispatch(config('app.export_csv_recipient'));
    }
}
