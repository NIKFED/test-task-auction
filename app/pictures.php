<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class pictures extends Model
{
    protected $table = 'pictures';

    protected $fillable = ['id', 'name', 'author',
        'description', 'start_price', 'min_increment',
        'buy_price', 'owner',
        'max_increment', 'release', 'image'];

    public static function find(int $id)
    {
        $picture_data = DB::select('select * from pictures where id = ?', [$id]);
        $picture_data = $picture_data[0];

        return $picture_data;
    }

}
