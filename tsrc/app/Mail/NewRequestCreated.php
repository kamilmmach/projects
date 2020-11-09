<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class NewRequestCreated extends Mailable
{
    use Queueable, SerializesModels;

    protected $request;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($request)
    {
        $this->request = $request;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $introLines = [
            trans('emails.request_created.intro_line_1', [
                'username' => $this->request->owner->name, 
                'requestname' => $this->request->name,
            ]),
        ];
        $level = 'default';
        $actionText = trans('emails.request_created.action_text');
        $actionUrl = route('admin.channels.show', $this->request->id);
        return $this->view('emails.request_created', compact('introLines', 'level', 'actionText', 'actionUrl'));
    }
}
