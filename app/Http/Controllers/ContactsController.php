<?php

namespace App\Http\Controllers;

use App\Events\NewMessage;
use App\Message;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;

class ContactsController extends Controller
{
    /**
    * Author: shamscorner
    * DateTime: 17/September/2019 - 19:03:54
    *
    * get contacts
    *
    */
    public function get()
    {
        // get all users except the authenticated one
        $contacts = User::where('id', '!=', auth()->id())->get();

        $unreadIds = Message::select(DB::raw('`from` as sender_id, count(`from`) as messages_count'))
            ->where('to', auth()->id())
            ->where('read', false)
            ->groupBy('from') // [["sender_id" => 4, "messages_count" => 15], ["sender_id" => 4, "messages_count" => 15]]
            ->get();

        $contacts = $contacts->map(function ($contact) use ($unreadIds) {
            $contactUnread = $unreadIds->where('sender_id', $contact->id)->first();

            $contact->unread = $contactUnread ? $contactUnread->messages_count : 0;

            return $contact;
        });
        
        return response()->json($contacts);
    }

    /**
    * Author: shamscorner
    * DateTime: 17/September/2019 - 20:32:34
    *
    * get messages for the user
    *
    */
    public function getMessagesFor($id)
    {

        // mark all messages with the selected contact as read
        Message::where('from', $id)->where('to', auth()->id())->update(['read' => true]);

        $messages = Message::where(function ($q) use ($id) {
            $q->where('from', auth()->id());
            $q->where('to', $id);
        })->orWhere(function ($q) use ($id) {
            $q->where('from', $id);
            $q->where('to', auth()->id());
        })->get(); // (a = 1 AND b = 2) OR (c = 1 OR d = 2)

        return response()->json($messages);
    }

    /**
    * Author: shamscorner
    * DateTime: 15/October/2019 - 02:18:54
    *
    * send the message and save
    *
    */
    public function send(Request $request)
    {
        $message = Message::create([
            'from' => auth()->id(),
            'to' => $request->contact_id,
            'text' => $request->text
        ]);

        broadcast(new NewMessage($message));

        return response()->json($message);
    }
}
