<?php

namespace App;

use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use \Carbon\Carbon;
class Tweet extends Eloquent
{
    protected $connection = 'mongodb';
    protected $collection = 'tweets';

    public function ScopeRelatedTweets($query, $search_id)
    {
        return $query->where('busquedaId', '=', $search_id);
    }

    public function ScopeStartDate($query, Carbon $start_date)
    {
        return $query->where('postedTime', '>=', $start_date);
    }

    public function ScopeEndDate($query, Carbon $end_date)
    {
        return $query->where('postedTime', '<=', $end_date);
    }

    public function ScopePostTweets($query)
    {
        return $query->where('verb', '=', "post");
    }

    public function ScopeShareTweets($query)
    {
        return $query->where('verb', '=', "share");
    }

    public function ScopeFilteredTweet($query, $search_id, Carbon $start_date, Carbon $end_date){
        return $query->relatedTweets($search_id)
                    ->startDate($start_date)
                    ->startDate($end_date);
    }

}
