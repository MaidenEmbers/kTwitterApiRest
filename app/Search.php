<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;

class Search extends Eloquent
{
    protected $connection = 'mongodb';
}
