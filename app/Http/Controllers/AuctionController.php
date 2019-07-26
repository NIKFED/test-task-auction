<?php

namespace App\Http\Controllers;

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

}
