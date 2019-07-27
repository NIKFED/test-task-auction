<?php

namespace App\Http\Controllers;

use App\Events\UpdatePrice;
use App\Events\AuctionNextPicture;
use App\Events\AuctionInformation;
use App\pictures;
use Illuminate\Http\Request;

class AuctionController extends Controller
{
    public function index(Request $request)
    {
        $pictures_data = pictures::all();
        //->where('inAuction', '1');

        if ($request->expectsJson()) {
            return response()->json($pictures_data->toArray());
        }

        return view('auction.index', compact('pictures_data'));
    }


    public function updatePrice(Request $request)
    {
        UpdatePrice::dispatch($request->input('price'));
    }

    public function nextPicture()
    {
        AuctionNextPicture::dispatch();
    }

    public function setPictureData(Request $request)
    {
        AuctionInformation::dispatch($request->input('picture_data'));
    }
}
