<?php

namespace App\Http\Controllers\Admin;

use App\Models\LiveChat;
use App\Models\LiveChatMessage;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LiveChatController extends Controller
{
    public function index()
    {
        $chats = LiveChat::with(['user', 'lastMessage'])
            ->orderByDesc('updated_at')
            ->paginate(20);

        $totalUnread = LiveChat::sum('unread_admin');

        return view('admin.livechat.index', compact('chats', 'totalUnread'));
    }

    public function show(int $id)
    {
        $chat = LiveChat::with(['user', 'messages'])->findOrFail($id);

        $chat->update(['unread_admin' => 0]);

        return view('admin.livechat.show', compact('chat'));
    }

    public function send(Request $request, int $id)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $chat = LiveChat::findOrFail($id);

        if ($chat->status === 'closed') {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'error' => 'Chat is closed.'], 422);
            }
            return back()->with(['message' => 'Chat is closed.', 'alert-type' => 'error']);
        }

        $msg = LiveChatMessage::create([
            'chat_id'     => $chat->id,
            'sender_type' => 'admin',
            'message'     => $request->message,
        ]);

        $chat->increment('unread_user');
        $chat->touch();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => [
                    'id'          => $msg->id,
                    'sender_type' => 'admin',
                    'message'     => $msg->message,
                    'time'        => $msg->created_at->format('h:i A'),
                ],
            ]);
        }

        return back()->with(['message' => 'Message sent.', 'alert-type' => 'success']);
    }

    public function close(int $id)
    {
        LiveChat::findOrFail($id)->update(['status' => 'closed']);

        return back()->with(['message' => 'Chat closed.', 'alert-type' => 'success']);
    }

    public function reopen(int $id)
    {
        LiveChat::findOrFail($id)->update(['status' => 'open']);

        return back()->with(['message' => 'Chat reopened.', 'alert-type' => 'success']);
    }

    public function getMessages(int $id)
    {
        $chat = LiveChat::findOrFail($id);
        $chat->update(['unread_admin' => 0]);

        $messages = $chat->messages()->get()->map(fn ($m) => [
            'id'          => $m->id,
            'sender_type' => $m->sender_type,
            'message'     => $m->message,
            'time'        => $m->created_at->format('h:i A'),
        ]);

        return response()->json([
            'messages' => $messages,
            'status'   => $chat->status,
        ]);
    }

    public function unreadCount()
    {
        $count = LiveChat::sum('unread_admin');
        return response()->json(['unread' => $count]);
    }

    public function indexJson()
    {
        $chats = LiveChat::with(['user', 'lastMessage'])
            ->orderByDesc('updated_at')
            ->get()
            ->map(function ($c) {
                $last = $c->lastMessage->first();
                return [
                    'id'            => $c->id,
                    'user_name'     => $c->user?->name,
                    'user_email'    => $c->user?->email,
                    'status'        => $c->status,
                    'unread_admin'  => $c->unread_admin,
                    'last_message'  => $last ? \Str::limit($last->message, 50) : null,
                    'updated_at'    => $c->updated_at->format('d M Y, h:i A'),
                    'show_url'      => route('admin.live-chat.show', $c->id),
                ];
            });

        return response()->json([
            'chats'        => $chats,
            'total_unread' => $chats->sum('unread_admin'),
        ]);
    }
}
