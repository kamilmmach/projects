<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Channel;
use App\ChannelMessage;
use App\Http\Requests\ChannelMessageRequest;
use Auth;

class ChannelMessageController extends Controller
{
    public function store(ChannelMessageRequest $request, Channel $channel)
    {
        $this->authorize('add-message', $channel);
        $channel->addMessage($request->get('message'));
        flash('Wiadomość dodana pomyślnie.', 'success');
        
        return back();
    }

    public function destroy(ChannelMessage $channelMessage)
    {
        $this->authorize($channelMessage);

        $channelMessage->delete();

        flash('Wiadomość została usunięta.', 'success');
        return back();
    }
}
