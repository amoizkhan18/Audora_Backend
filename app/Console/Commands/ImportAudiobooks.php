<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Audiobook;
use Illuminate\Support\Facades\Storage;

class ImportAudiobooks extends Command
{
    protected $signature = 'audiobooks:import';
    protected $description = 'Import audiobooks from CSV file';

    public function handle()
    {
        $path = storage_path('app/public/descriptionsaudiobooks.csv');

        if (!file_exists($path)) {
            $this->error("File not found: $path");
            return;
        }

        $file = fopen($path, 'r');

        // Read header
        $header = fgetcsv($file);

        while (($row = fgetcsv($file)) !== false) {
            $data = array_combine($header, $row);

            Audiobook::create([
                'title'      => $data['title'] ?? null,
                'author'     => $data['author'] ?? null,
                'imageurl'   => $data['imageurl'] ?? null,
                'extra'      => $data['extra'] ?? null,
                'genres'     => $data['genres'] ?? null,
                'bookdesc'   => $data['bookdesc'] ?? null,
                'bookurl'    => $data['bookurl'] ?? null,
                'audiolinks' => $data['audiolinks'] ?? null,
            ]);
        }

        fclose($file);

        $this->info('Audiobooks imported successfully.');
    }
}
