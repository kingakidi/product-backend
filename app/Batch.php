<?php
/**
 * Created by PhpStorm.
 * User: USER
 * Date: 6/29/2018
 * Time: 10:15 AM
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Batch extends Model
{

    public function getCreatedAtAttribute($timestamp)
    {
        $date = new \DateTime($timestamp);
        $date = $date->format('F d, Y');
        return $date;
    }

    public function products(){
        return $this->hasMany('App\Product');
    }
}