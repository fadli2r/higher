<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use App\Models\WorkerTask;
use App\Models\Product;
use App\Models\ProductWorkflow;
use App\Models\Order;


class CreateWorkerTask implements ShouldQueue
{
    use Queueable;

    protected $order;

    /**
     * Create a new job instance.
     */
    public function __construct($order)
    {

    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {

    }
}
