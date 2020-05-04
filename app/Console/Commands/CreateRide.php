<?php

namespace App\Console\Commands;

use App\Models\Car;
use App\Models\Club;
use App\Models\Order;
use App\Models\Ride;
use App\Models\RidePoint;
use App\Models\Item;
use App\Models\User;
use App\Events\ItemUpdated;
use App\Events\RideCreated;
use App\Events\RideUpdated;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;

class CreateRide extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ride:create';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create ride for available order';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
            
        $headers = ['status', 'distance', 'delay'];
        $items = Item::all(['status', 'distance', 'delay'])->toArray();
        $this->table($headers, $items);
        
        
        $items = Item::where('status', 'ping')->get();
        $bar = $this->output->createProgressBar(count($items));
        $bar->start();
        foreach ($items as $item) {
            $this->performTask($item);
            $bar->advance();
        }
        $bar->finish();
    }

    /**
     * Perform task for this order item.
     *
     * @Param App\Models\Item $item
     * @return mixed
     */
    public function performTask($item)
    {
    }
}
