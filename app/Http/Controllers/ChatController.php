<?php

namespace App\Http\Controllers;

use App\Events\Message;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function setMessage(request $request)
    {
        Message::dispatch($request->input('body'));
    }
}
