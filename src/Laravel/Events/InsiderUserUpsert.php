<?php

namespace KaracaTech\UseInsider\Laravel\Events;

use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class InsiderUserUpsert
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public array $identifiers,
        public array $attributes = []
    ) {}
} 