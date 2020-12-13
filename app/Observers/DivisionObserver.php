<?php

namespace App\Observers;

use App\Models\Division;
use Illuminate\Support\Facades\Schema;

class DivisionObserver
{
    /**
     * Handle the Division "creating" event.
     *
     * @param \App\Models\Division $division
     * @return void
     */
    public function creating(Division $division)
    {

dd('creating');
    }

    /**
     * Handle the Division "created" event.
     *
     * @param \App\Models\Division $division
     * @return void
     */
    public function created(Division $division)
    {
        dd('DivisionObserver/created');
    }

    /**
     * Handle the Division "updating" event.
     *
     * @param \App\Models\Division $division
     * @return void
     */
    public function updating(Division $division)
    {
        dd('DivisionObserver/updating');
    }

    /**
     * Handle the Division "updated" event.
     *
     * @param \App\Models\Division $division
     * @return void
     */
    public function updated(Division $division)
    {
        //
    }

    /**
     * Handle the Division "deleted" event.
     *
     * @param \App\Models\Division $division
     * @return void
     */
    public function deleted(Division $division)
    {
        //
    }

    /**
     * Handle the Division "restored" event.
     *
     * @param \App\Models\Division $division
     * @return void
     */
    public function restored(Division $division)
    {
        //
    }

    /**
     * Handle the Division "force deleted" event.
     *
     * @param \App\Models\Division $division
     * @return void
     */
    public function forceDeleted(Division $division)
    {
        //
    }
}
