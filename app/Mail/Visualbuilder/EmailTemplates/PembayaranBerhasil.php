<?php

namespace App\Mail\Visualbuilder\EmailTemplates;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Visualbuilder\EmailTemplates\Traits\BuildGenericEmail;

class PembayaranBerhasil extends Mailable
{
    use Queueable;
    use SerializesModels;
    use BuildGenericEmail;

    public $template = 'pembayaran-berhasil';
    public $sendTo;
    public $transaction;
    public $detail;
    public $user;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($transaction)
    {
        
        $this->transaction = $transaction;
        $this->user = $transaction->user;
        $this->sendTo = $transaction->user->email;
        
        // dd($transaction->toArray());
    }
}
