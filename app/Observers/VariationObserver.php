<?php

namespace App\Observers;

use App\Models\Variation;
use App\Notifications\Variation\VariationBecomeUnavailable;

class VariationObserver
{
    public function updated(Variation $variation)
    {
        if ($variation->quantity <= 0) {
            notify()->send($variation->customers, new VariationBecomeUnavailable());
            $variation->customers()->detach();
        }
    }

    public function restored()
    {
        // todo:send notification to user that variation become available
    }

    public function deleted()
    {
        // todo:send notification to user that variation become unavailable
        // todo:remove from every wish list
        // todo:remove from every cart
    }
}
