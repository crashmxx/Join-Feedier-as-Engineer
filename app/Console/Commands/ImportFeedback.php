<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use App\Models\Feedback;
class ImportFeedback extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import:feedback';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import feedbacks from an external CSV file.';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        // Fetch data from the external source
        $response = Http::get('https://feedier-production.s3.eu-west-1.amazonaws.com/special/Reviews+Import.csv');

        if ($response->successful()) {
            // Parse CSV data from the response body

            /**
             * We prefer to use a temporary file handle to read the CSV data
             * less memory consumption and better performance and
             * no problem with the fact that some CSV lines contain newlines (could be a problem with the explode function
             */
            $csv_data = $response->body();
            $temp = fopen("php://temp", "r+");
            fwrite($temp, $csv_data);
            rewind($temp);
            $feedbacks = [];
            // Read CSV data from the temporary file handle line by line
            while (($row = fgetcsv($temp)) !== false) {
                // Extract the first column (Reviews Content)
                $feedback_content = $row[0];
                if (empty($feedback_content)) {
                    continue;
                }
                // Extract the creation date from the third column
                $creation_date = $row[2] ?? now();
                /**
                 * Store the feedback content and creation date in the array
                 * /!\ Assuming CSV format is [Reviews Content,Rating,Start Date,Address,Appartments,Source]
                 * BUT we only need the first column (description field in our model) and the creation date
                 *
                 * @todo Ideally it would be better to have a CSV format like [description,created_at] or the necessary fields in DB (or a json field)
                 * and a field to save the timestamp of the import
                 */
                $feedbacks[] = [
                    'description' => $feedback_content,
                    'created_at' => $creation_date,
                    'updated_at' => $creation_date,
                    'type' => 'external',
                ];
            }
            fclose($temp);

            // Insert feedbacks into the database
            foreach ($feedbacks as $feedback) {
                Feedback::create($feedback);
            }
            $this->info('Feedbacks fetched and inserted successfully.');
        } else {
            $this->error('Failed to fetch feedbacks from the external source.');
        }
    }
}
