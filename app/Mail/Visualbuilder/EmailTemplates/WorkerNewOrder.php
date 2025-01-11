<?php

namespace App\Mail\Visualbuilder\EmailTemplates;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Visualbuilder\EmailTemplates\Traits\BuildGenericEmail;

class WorkerNewOrder extends Mailable
{
    use Queueable;
    use SerializesModels;
    use BuildGenericEmail;

    public $template = 'worker-new-order';
    public $order;
    public $worker;
    public $product;
    public $user;
    public $sendTo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($order, $worker, $product)
    {
        $this->order = $order;
        $this->worker = $worker;
        $this->product = $product;
        $this->user = $worker->user;
        $this->sendTo = $this->user->email;
    }
}
