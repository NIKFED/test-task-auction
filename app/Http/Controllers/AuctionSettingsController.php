<?php

namespace App\Http\Controllers;

use App\AuctionSettings;
use App\Events\AuctionInformation;
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

    public function setPictureData(request $request)
    {
        AuctionInformation::dispatch($request->input('picture_data'));
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

    public function auctionStart(request $request)
    {
        AuctionStart::dispatch($request->input('start_auction'));
    }
}
