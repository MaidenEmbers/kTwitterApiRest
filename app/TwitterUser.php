<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;


class TwitterUser extends Eloquent
{
    protected $connection = 'mongodb';
}
