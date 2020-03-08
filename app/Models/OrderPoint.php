<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderPoint extends Pivot
{
    const TYPE_START = 'start';
    
    const TYPE_END = 'end';
}
