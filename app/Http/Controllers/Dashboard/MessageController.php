<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index()
    {
        $messages  = Message::orderBy('created_at', 'desc')->get();
        return view('dashboard.message.index', compact('messages'));
    }

    public function show($id)
    {
        $message = Message::find($id);
        return view('dashboard.message.show', compact('message'));
    }
}
