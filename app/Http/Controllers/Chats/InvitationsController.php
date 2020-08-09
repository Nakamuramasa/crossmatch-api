<?php

namespace App\Http\Controllers\Chats;

use Mail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Mail\SendInvitationToJoinTeam;
use App\Repositories\Contracts\{
    IUser,
    IChat,
    IInvitation
};

class InvitationsController extends Controller
{
    protected $invitations;
    protected $chats;
    protected $users;

    public function __construct(IInvitation $invitations, IChat $chats, IUser $users)
    {
        $this->invitations = $invitations;
        $this->chats = $chats;
        $this->users = $users;
    }

    public function invite(Request $request, $chatId)
    {
        $chat = $this->chats->find($chatId);
        $this->validate($request, [
            'email' => ['required', 'email']
        ]);

        $user = auth()->user();

        if($chat->hasPendingInvite($request->email)){
            return response()->json([
                'email' => 'Email already has a pending invite'
            ], 422);
        }

        $recipient = $this->users->findByEmail($request->email);

        if(! $recipient){
            $invitation = $this->invitations->create([
                'chat_id' => $chat->id,
                'sender_id' => $user->id,
                'recipient_email' => $request->email,
                'token' => md5(uniqid(microtime()))
            ]);
            Mail::to($request->email)->send(new SendInvitationToJoinTeam($invitation, false));

            return response()->json([
                'message' => 'Invitation sent to user'
            ], 200);
        }
    }

    public function resend($id)
    {

    }

    public function respond(Request $request, $id)
    {

    }

    public function destroy($id)
    {

    }
}
