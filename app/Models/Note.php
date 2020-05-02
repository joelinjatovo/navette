<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    /**
     * Get the owning notable model.
     */
    public function notable()
    {
        return $this->morphTo();
    }
}
