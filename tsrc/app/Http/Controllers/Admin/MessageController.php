<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ChannelMessage;

class MessageController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function update(Request $request, ChannelMessage $message)
    {
    }

    public function destroy(ChannelMessage $message)
    {
        $message->delete();

        flash(trans('admin.message_destroy_success'), 'success');

        return back();
    }
}
