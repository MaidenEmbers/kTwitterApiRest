<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Tweet;
use \Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use \MongoDB\BSON\UTCDateTime;

class PublicApiController extends Controller
{

//Endpoint 1
    public function getTotalTweets(Request $request, $search_id)
    {
      if(!$request->has('start_date'))
        $errors['start_date'] = 'The start date is required';
      if(!$request->has('end_date'))
        $errors['end_date'] = 'The end date is required';

      $start_date = $request->input('start_date');
      $end_date = $request->input('end_date');

      if($start_date>$end_date)
        $errors['start_date'] = 'The start date most be smaller than end_date';

      try{
        $start_date = new Carbon($start_date);
      }catch(\Exception $e){
        $errors['start_date'] = 'invalid format';
      }
      try{
        $end_date = new Carbon($end_date);
      }catch(\Exception $e){
        $errors['end_date'] = 'invalid format';
      }

      if(!empty($errors))
        return response()->json($errors, 400);



      $query = Tweet::relatedTweets($search_id)
              ->startDate(new Carbon($start_date))
              ->endDate(new Carbon($end_date));

      // $results = $query->paginate(10);

      $results['tweets'] = $query->count();
      $users = $query->distinct('usuario.preferredUsername')->get();
      $hash = $query->distinct('hashtags')->get();
      $mentions = $query->distinct('menciones')->get();

      $results['unique_users'] = [
        'count' => $users->count()
      ];

      $results['unique_hashtags'] = [
        'count' => $hash->count()
      ];

      $results['unique_user_mentions'] = [
        'count' => $mentions->count()
      ];

      return response()->json($results);

    }

    //Endpoint 2

    function getTopUser(Request $request, $search_id){
      if(!$request->has('start_date'))
        $errors['start_date'] = 'The start date is required';
      if(!$request->has('end_date'))
        $errors['end_date'] = 'The end date is required';

      $start_date = $request->input('start_date');
      $end_date = $request->input('end_date');

      if($start_date>$end_date)
        $errors['start_date'] = 'The start date most be smaller than end_date';

      try{
        $start_date = new Carbon($start_date);
      }catch(\Exception $e){
        $errors['start_date'] = 'invalid format';
      }
      try{
        $end_date = new Carbon($end_date);
      }catch(\Exception $e){
        $errors['end_date'] = 'invalid format';
      }

      if(!empty($errors))
        return response()->json($errors, 400);


      $query = Tweet::raw(function($collection) use ($search_id, $start_date, $end_date){
        return $collection->aggregate([
          ['$match' => [
            'busquedaId' => $search_id,
            'postedTime' => [
              '$gte' => new UTCDateTime(new Carbon($start_date)),
              '$lte' => new UTCDateTime(new Carbon($end_date)),
            ]
          ]],
          ['$group' => [
            '_id' => '$usuario.preferredUsername',
            'count' => ['$sum' => 1]
          ]],
          ['$sort' => ['count' => -1]],
          ['$limit' => 1]
        ]);
      });
      $result = $query->first();
      return response()->json([
        'username' => $result['attributes']['_id'],
        'ocurrencies' => $result['attributes']['count'],
      ]);

    }

    //Endpoint 3

    function getTopTenHashtag(Request $request, $search_id){
      if(!$request->has('start_date'))
        $errors['start_date'] = 'The start date is required';
      if(!$request->has('end_date'))
        $errors['end_date'] = 'The end date is required';

      $start_date = $request->input('start_date');
      $end_date = $request->input('end_date');

      if($start_date>$end_date)
        $errors['start_date'] = 'The start date most be smaller than end_date';

      try{
        $start_date = new Carbon($start_date);
      }catch(\Exception $e){
        $errors['start_date'] = 'invalid format';
      }
      try{
        $end_date = new Carbon($end_date);
      }catch(\Exception $e){
        $errors['end_date'] = 'invalid format';
      }

      if(!empty($errors))
        return response()->json($errors, 400);


      $query = Tweet::raw(function($collection) use ($search_id, $start_date, $end_date){
        return $collection->aggregate([
          ['$match' => [
            'busquedaId' => $search_id,
            'postedTime' => [
              '$gte' => new UTCDateTime(new Carbon($start_date)),
              '$lte' => new UTCDateTime(new Carbon($end_date)),
            ]
          ]],
          ['$unwind' => '$hashtags'],
          ['$group' => [
            '_id' => '$hashtags',
            'count' => ['$sum' => 1]
          ]],
          ['$sort' => ['count' => -1]],
          ['$limit' => 10]
        ]);
      });
      $result = $query->take(10);
      $arr = array();
      foreach ($result as $hash) {
        $arr[] = [
          'hashtag' => $hash['_id'],
          'ocurrencies' => $hash['count']
        ];
      }
      return response()->json($arr);

    }

    //Endpoint 4

    public function getTweetsPercents(Request $request, $search_id)
    {
      if(!$request->has('start_date'))
        $errors['start_date'] = 'The start date is required';
      if(!$request->has('end_date'))
        $errors['end_date'] = 'The end date is required';

      $start_date = $request->input('start_date');
      $end_date = $request->input('end_date');

      if($start_date>$end_date)
        $errors['start_date'] = 'The start date most be smaller than end_date';

      try{
        $start_date = new Carbon($start_date);
      }catch(\Exception $e){
        $errors['start_date'] = 'invalid format';
      }
      try{
        $end_date = new Carbon($end_date);
      }catch(\Exception $e){
        $errors['end_date'] = 'invalid format';
      }

      if(!empty($errors))
        return response()->json($errors, 400);


      //query para tweets originales
      $queryP = Tweet::relatedTweets($search_id)
              ->startDate(new Carbon($start_date))
              ->endDate(new Carbon($end_date))
              ->postTweets();

      //query para retweets
      $queryS = Tweet::relatedTweets($search_id)
              ->startDate(new Carbon($start_date))
              ->endDate(new Carbon($end_date))
              ->shareTweets();

      $total = $queryP->count() + $queryS->count();

      $percentP = (($queryP->count())*100)/$total;
      $percentS = (($queryS->count())*100)/$total;

      // $results = $query->paginate(10);

      $results['percent_original_tweets'] = [
        'percent' => $percentP,
      ];

      $results['percent_retweets'] = [
        'percent' => $percentS,
      ];

      return response()->json($results);

    }
}
