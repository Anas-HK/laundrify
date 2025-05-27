<?php

namespace App\Console\Commands;

use App\Models\Service;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class UpdateServiceCategories extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:update-service-categories';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update existing services with default categories';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting to update service categories...');
        
        // Get all services without a category
        $services = Service::whereNull('category')->get();
        $count = $services->count();
        
        $this->info("Found {$count} services without categories");
        
        // Default categories to assign based on service name keywords
        $categoryMap = [
            'wash' => 'Washing',
            'dry' => 'Dry Cleaning',
            'iron' => 'Ironing',
            'fold' => 'Folding',
            'press' => 'Pressing',
            'clean' => 'Cleaning',
            'stain' => 'Stain Removal',
            'steam' => 'Steam Cleaning',
            'repair' => 'Repairs',
            'alter' => 'Alterations'
        ];
        
        $updated = 0;
        
        foreach ($services as $service) {
            $serviceName = strtolower($service->service_name);
            $assignedCategory = 'Other'; // Default category
            
            // Try to find a matching category based on keywords in service name
            foreach ($categoryMap as $keyword => $category) {
                if (strpos($serviceName, $keyword) !== false) {
                    $assignedCategory = $category;
                    break;
                }
            }
            
            $service->category = $assignedCategory;
            $service->save();
            $updated++;
            
            if ($updated % 50 === 0) {
                $this->info("Updated {$updated} services so far...");
            }
        }
        
        $this->info("Successfully updated {$updated} services with categories");
    }
}
