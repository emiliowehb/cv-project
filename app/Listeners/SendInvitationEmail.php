<?php

namespace App\Listeners;

use App\Events\NewMemberInvited;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendInvitationEmail
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(NewMemberInvited $event): void
    {
        $data = $event->data;
        $link = route('register.invite', ['invite_code' => $data['code'], 'email' => $data['invited_email']]);

        Mail::send('emails.invitation', ['link' => $link, 'workspace_name' => $data['workspace_name'], 'full_name' => $data['full_name']], function ($message) use ($data) {
            $message->to($data['invited_email'])
                    ->subject('You are invited to join our workspace');
        });
    }
}
