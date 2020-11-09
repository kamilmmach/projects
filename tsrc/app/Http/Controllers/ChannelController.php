<?php

namespace App\Http\Controllers;

use App\Channel;
use App\Http\Requests\ChannelMessageRequest;
use App\Http\Requests\ChannelRequest;
use App\Status;
use App\Role;
use App\Mail\NewRequestCreated;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Http\Requests;
use Session;

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
        $channels = Auth::user()->channelsOwned->load(['status', 'responder']);
        return view('channels.index', compact('channels'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('channels.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ChannelRequest|Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ChannelRequest $request)
    {
        $request = $this->createRequest($request);

        //TODO: Notify all admins on email about a new channel request

        $admins = Role::getByName('admin')->users();
        foreach($admins as $admin) {
            Mail::to($admin->email)->send(new NewRequestCreated($request));
        }


        flash('Wniosek został utworzony pomyślnie.', 'success');
        return redirect(action('ChannelController@index'));
    }

    /**
     * Display the specified resource.
     *
     * @param Channel $channel
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function show(Channel $channel)
    {
        $this->authorize('show', $channel);

        $channel->load(['status', 'responder', 'messages', 'messages.user', 'messages.user.role']);

        return view('channels.show', compact('channel'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Channel $channel_request
     * @return \Illuminate\Http\Response
     * @internal param ChannelRequest $channel
     * @internal param int $id
     */
    public function edit(Channel $channel)
    {
        $statuses = Status::pluck('name', 'id');

        foreach($statuses as $v => $k)
            $statuses[$v] = trans('channel.status_' . $k);
        return view('channels.edit', compact('channel', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ChannelRequest|Request $request
     * @param Channel $channel
     * @return \Illuminate\Http\Response
     * @internal param Channel $channel_request
     * @internal param ChannelRequest $channel
     * @internal param int $id
     */
    public function update(ChannelRequest $request, Channel $channel)
    {
        $this->authorize($channel);
        
        $channel->update($request->all());
        if ($request->has('status')) {
            $this->authorize('edit-admin', $channel);
            $channel->status_id = $request->get('status');
            $channel->save();
        }
        
        flash('Edycja wniosku przebiegła pomyślnie', 'success');

        if (Auth::user()->isAdmin()) {
            return redirect(action('AdminController@index'));
        }
        
        return redirect(action('ChannelController@index'));
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param Channel $channel
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Channel $channel)
    {
        $this->authorize($channel);

        $channel->delete();
        
        flash('Wniosek usunięto pomyślnie.', 'success');
        
        return back();
    }

    public function respond(ChannelMessageRequest $request, Channel $channel)
    {
        $this->authorize($channel);

        if ($request->has('accept')) {
            if ($channel->setResponse('accepted', $request)) {
                flash('Wniosek został zaakceptowany.', 'success');
            } else {
                flash('Wystąpił problem przy tworzeniu kanału teamspeak. Wniosek nie został zaakceptowany. Błąd: ' . session()->get('setresponse_error'), 'danger');
            }
            return back();
        } elseif ($request->has('reject')) {
            $channel->setResponse('rejected', $request);
            flash('Wniosek został odrzucony.', 'success');
            return back();
        } else {
            flash('Coś poszło nie tak. (respond: brak akcji accept lub reject)', 'danger');
            return back();
        }
    }

    /**
     * @param ChannelRequest $request
     * @return App\Channel
     */
    private function createRequest(ChannelRequest $request)
    {
        $channel = new Channel($request->all());
        $channel->status_id = Status::getByName('pending')->id;
        $channel->owner_id = Auth::user()->id;
        $channel->save();

        if ($request->has('message')) {
            $channel->addMessage($request->input('message'));
        }

        return $channel;
    }
}
