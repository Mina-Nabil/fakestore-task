<?php

namespace App\Console\Commands;

use App\Exceptions\ApiCallException;
use App\Services\AbstractServices\ProductsService;
use Illuminate\Console\Command;

class SyncProducts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:sync-products';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync products from the FakeStoreAPI';

    /**
     * Execute the console command.
     */
    public function handle(ProductsService $productsService)
    {
        $this->info('Syncing products from the FakeStoreAPI...');
        $oldCount = $productsService->getProductCount();
        try {
            $productsService->importProducts();
        } catch (ApiCallException $e) {
            $this->error($e->getMessage());
            return;
        }
        $newCount = $productsService->getProductCount();
        $this->info("Products synced successfully, products count before sync is $oldCount, after sync is $newCount.");
    }
}
