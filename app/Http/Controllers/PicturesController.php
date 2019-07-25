<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\pictures;


class PicturesController extends Controller
{
    public function index()
    {
        return view('gallery_pictures.index');
    }

    public function getAllPictures()
    {
        $pictures_data = pictures::all();

        return response()->json($pictures_data->toArray());
    }

    public function view(Request $request)
    {
        $picture_data = pictures::find(intval($request->id));

        return view('gallery_pictures.view', compact('picture_data'));
    }

    public function create()
    {
        return view('gallery_pictures.create');
    }
}
