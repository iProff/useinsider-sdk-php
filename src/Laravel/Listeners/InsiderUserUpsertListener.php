<?php

namespace KaracaTech\UseInsider\Laravel\Listeners;

use KaracaTech\UseInsider\Laravel\Events\InsiderUserUpsert;
use KaracaTech\UseInsider\Laravel\Facades\Insider;
use Illuminate\Contracts\Queue\ShouldQueue;

class InsiderUserUpsertListener implements ShouldQueue
{
    public function handle(InsiderUserUpsert $event): void
    {
        Insider::customers()->upsert(
            identifiers: $event->identifiers,
            attributes: $event->attributes
        );
    }
} 