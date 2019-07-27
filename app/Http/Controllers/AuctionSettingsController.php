<?php

namespace App\Http\Controllers;

use App\AuctionSettings;
use App\Events\AuctionStart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuctionSettingsController extends Controller
{
    public function getTimer()
    {
        $timer_data = AuctionSettings::find(1);
//        ->where('inAuction', '1');

        return $timer_data->time;
    }

    public function auctionEnd(request $request)
    {
        $newPictures = $request->get('picture_data');
        foreach ($newPictures as $newPicture)
        {
            DB::table('pictures')
                ->where('id', $newPicture['id'])
                ->update([
                    'owner' => $newPicture['owner'],
                ]);
            if ($newPicture['owner'] != 'auction') {
                DB::table('pictures')
                    ->where('id', $newPicture['id'])
                    ->update([
                        'inAuction' => '0',
                        'buy_price' => $newPicture['buy_price']
                    ]);
            }
        }
    }

    public function auctionStart()
    {
        AuctionStart::dispatch();
    }
}
