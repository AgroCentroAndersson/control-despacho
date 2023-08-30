<?php

namespace App\Observers;

use App\Models\Grocer;

class GrocerObserver
{
    public function creating(Grocer $grocer): void
    {
        $grocer->password = bcrypt($grocer->password);
        $grocer->state = 1;
    }
}
