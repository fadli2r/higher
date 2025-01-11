<?php

namespace App\Mail\Visualbuilder\EmailTemplates;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Visualbuilder\EmailTemplates\Traits\BuildGenericEmail;

class WorkerTaskUpdate extends Mailable
{
    use Queueable;
    use SerializesModels;
    use BuildGenericEmail;

    public $template = 'worker-task-update';
    public $workerTask;
    public $order;
    public $user;
    public $sendTo;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($workerTask)
    {
        $this->workerTask = $workerTask;
        $this->order = $workerTask->order;
        $this->user = $this->order->user;
        $this->sendTo = $this->user->email;
    }
}
