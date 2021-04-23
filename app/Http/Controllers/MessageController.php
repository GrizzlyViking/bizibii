<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        return view('admin.message.list');
    }

    public function show(Message $message): View
    {
        return view('admin.message.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.message.list');
    }
}
