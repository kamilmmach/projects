<?php

namespace App;

use App\Http\Requests\ChannelMessageRequest;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    protected $fillable = [
        'name', 'password',
    ];

    protected $dates = ['answered_at'];

    public function scopePending($query)
    {
        return $query->where('status_id', Status::getByName('pending')->id);
    }

    public function scopeNotPending($query)
    {
        return $query->where('status_id', "!=", Status::getByName('pending')->id);
    }

    public function scopeAccepted($query)
    {
        return $query->where('status_id', Status::getByName('accepted')->id);
    }

    public function scopeRejected($query)
    {
        return $query->where('status_id', Status::getByName('rejected')->id);
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function responder()
    {
        return $this->belongsTo(User::class, 'responder_id');
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function messages()
    {
        return $this->hasMany(ChannelMessage::class);
    }

    public function isPending()
    {
        return $this->status_id === 1;
    }

    public function addMessage($message)
    {
        $cm = new \App\ChannelMessage;
        $cm->message = $message;
        $cm->user_id = \Auth::user()->id;
        $cm->channel_id = $this->id;
        $cm->save();
    }

    public function setResponse($status)
    {
        if ($status == 'accepted') {
            // TeamSpeak3 create channel
            try {
                $ts3 = app('teamspeak');

                $client = $ts3->clientGetByUid(\Auth::user()->ts_uid);

                $channel_list = array_reverse($ts3->channelList());
                $first_reserved = [null, null, null];
                $save_res_prevcid = false;

                foreach ($channel_list as $channel_node) {
                    if ($channel_node['pid'] != 0) {
                        continue;
                    }

                    if ($save_res_prevcid) {
                        $first_reserved[2] = $channel_node['cid'];
                        $save_res_prevcid = false;
                    }

                    if ($channel_node['cid'] == 300) {
                        break;
                    }

                    $channel_name = $channel_node['channel_name']->toString();
                    $exploded_name = explode(' ', $channel_name);
                    $number = (int)substr($exploded_name[0], 1);

                    if ($exploded_name[1] == 'RESERVED') {
                        $first_reserved[0] = $channel_node;
                        $first_reserved[1] = $number;
                        $save_res_prevcid = true;
                    }
                }
                if ($first_reserved[0] != null) {
                    $first_reserved[0]->delete();

                    $channel_id = $ts3->channelCreate([
                        'channel_name' => '#' . ($first_reserved[1]) . ' ' . $this->name,
                        'channel_flag_permanent' => true,
                        'channel_codec_quality' => 6,
                        'channel_password' => $this->password,
                        'channel_order' => $first_reserved[2]
                    ]);
                } else {
                    $channel_name = $channel_list[0]['channel_name']->toString();
                    $exploded_name = explode(' ', $channel_name);
                    $number = (int)substr($exploded_name[0], 1);

                    $channel_id = $ts3->channelCreate([
                        'channel_name' => '#' . ($number + 1) . ' ' . $this->name,
                        'channel_flag_permanent' => true,
                        'channel_codec_quality' => 6,
                        'channel_password' => $this->password
                    ]);
                }

                $channel_groups = last($ts3->channelGroupList(['name' => 'Channel admin']));
                $client->setChannelGroup($channel_id, $channel_groups['cgid']);
            } catch (\TeamSpeak3_Exception $e) {
                session()->flash('setresponse_error', $e->getMessage());
                return false;
            }
        }

        // Don't update
        $this->timestamps = false;
        Status::getByName($status)->channels()->save($this);
        \Auth::user()->channelsRespondedTo()->save($this);
        $this->answered_at = \Carbon\Carbon::now();
        $this->save();

        $this->timestamps = true;

        return true;
    }
}
