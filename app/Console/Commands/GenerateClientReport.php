<?php

namespace App\Console\Commands;

use App\Models\Client;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class GenerateClientReport extends Command
{
    protected $signature = 'reports:clients {--path=reports}';
    protected $description = 'Generate a CSV report of all clients';

    public function handle(): int
    {
        $path = rtrim($this->option('path'), '/');
        $filename = $path . '/clients_' . now()->format('Ymd_His') . '.csv';

        $stream = fopen('php://temp', 'w+');
        fputcsv($stream, [
            'ID',
            'Family Code',
            'Family Head',
            'Client Name',
            'Mobile',
            'Email',
            'RM',
            'Partner',
            'PAN',
            'DOB',
            'City',
            'State',
        ]);

        Client::orderBy('id')->chunk(500, function ($clients) use ($stream) {
            foreach ($clients as $client) {
                fputcsv($stream, [
                    $client->id,
                    $client->family_code,
                    $client->family_head,
                    $client->client_name,
                    $client->primary_mobile_number,
                    $client->primary_email_number,
                    $client->rm,
                    $client->partner,
                    $client->pan_card_number,
                    $client->dob,
                    $client->city,
                    $client->state,
                ]);
            }
        });

        rewind($stream);
        Storage::disk('local')->put($filename, stream_get_contents($stream));
        fclose($stream);

        $this->info('Report generated: storage/app/' . $filename);

        return Command::SUCCESS;
    }
}
