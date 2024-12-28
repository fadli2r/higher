<?php

namespace App\Observers;

use App\Models\Message;
use App\Models\TicketMessage;

class MessageObserver
{
    /**
     * Handle the Message "created" event.
     */
    public function creating(TicketMessage $message)
    {
        // Tetapkan sender_id secara otomatis
        if (auth()->check() && !$message->sender_id) {
            $message->sender_id = auth()->id();
        }
    }

    /**
     * Handle the Message "updated" event.
     */
    public function updated(TicketMessage $message): void
    {
        //
    }

    /**
     * Handle the Message "deleted" event.
     */
    public function deleted(TicketMessage $message): void
    {
        //
    }

    /**
     * Handle the Message "restored" event.
     */
    public function restored(TicketMessage $message): void
    {
        //
    }

    /**
     * Handle the Message "force deleted" event.
     */
    public function forceDeleted(TicketMessage $message): void
    {
        //
    }
}
