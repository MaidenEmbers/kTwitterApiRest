<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Location extends Eloquent
{
    protected $connection = 'mongodb';
}
