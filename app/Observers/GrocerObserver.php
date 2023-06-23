<?php

namespace App\Observers;

class GrocerObserver
{
    public function creating($grocer)
    {
        $grocer->password = bcrypt($grocer->password);
        $grocer->state = 1;
    }

}
