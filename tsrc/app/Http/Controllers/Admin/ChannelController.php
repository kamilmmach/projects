<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Channel;
use App\Status;
use App\Http\Requests;
use App\Http\Requests\Admin\UpdateChannel;
use App\Http\Controllers\Controller;

class ChannelController extends Controller
{
    public function __construct() 
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $page = [
            'title' => trans('admin.channels'),
            'description' => trans('admin.channels_description'),
        ];

        $channels = Channel::all();

        return view('admin.channels.index', compact('page', 'channels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storemsg(Request $request, Channel $channel)
    {
        $this->validate($request, [
            'message' => 'required',
        ]);

        $channel->addMessage($request['message']);

        flash(trans('admin.message_add_success'), 'success');

        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function show(Channel $channel)
    {
        $page = [
            'title' => trans('admin.channel_show'),
            'description' => ''
        ];

        return view('admin.channels.show', compact('page', 'channel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function edit(Channel $channel)
    {
        $page = [
            'title' => trans('admin.edit_channel'),
        ];

        $status_names = Status::pluck('name', 'id');

        $status_names = $status_names->map(function($name) {
          return trans('channel.status_' . $name);
        });

        return view('admin.channels.edit', compact('page', 'channel', 'status_names'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateChannel $request, Channel $channel)
    {
        $channel->status_id = $request->status;
        $channel->name = $request->name;
        $channel->password = $request->password;
        if($channel->status->isPending())
        {
            $channel->responder_id = null;
            $channel->answered_at = null;
        }

        $channel->save();

        flash(trans('flash.data_updated_success'), 'success');

        return back();

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  Channel  $channel
     * @return \Illuminate\Http\Response
     */
    public function destroy(Channel $channel)
    {
        $channel->delete();

        flash(trans('admin.channel_destroy_success'), 'success');
        return back();
    }

    public function accept(Request $request, Channel $channel)
    {
        // TODO: Check whether user has permissions to accept the channel request
        //

        // Can't accept an already resolved request
        if(!$channel->isPending())
            return abort(404); // Should it show 404 or a message that the request has already been resolved?

        if($channel->setResponse('accepted'))
        {
            flash(trans('admin.channel_accept_success', ['channel_name' => $channel->name]), 'success');
        }
        else
        {
            flash(trans('admin.channel_accept_error', ['channel_name' => $channel->name]), 'danger');
        }

        return back();


    }

    public function reject(Request $request, Channel $channel)
    {
        // TODO: Check whether user has permissions to accept the channel request
        //

        // Can't accept an already resolved request
        if(!$channel->isPending())
            return abort(404); // Should it show 404 or a message that the request has already been resolved?

        if($channel->setResponse('rejected'))
        {
            flash(trans('admin.channel_reject_success', ['channel_name' => $channel->name]), 'success');
        }

        return back();
    }
}
