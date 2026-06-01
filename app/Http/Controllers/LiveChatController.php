<?php

namespace App\Http\Controllers;

use App\Models\LiveChat;
use App\Models\LiveChatMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveChatController extends Controller
{
    public function chatPage(int $chatId = null)
    {
        $user = Auth::guard('web')->user();

        // All user chats ordered by latest activity
        $allChats = LiveChat::with(['lastMessage'])
            ->where('user_id', $user->id)
            ->orderByDesc('updated_at')
            ->get();

        $activeChat = null;
        $messages   = collect();

        // Only open a specific chat if explicitly requested
        if ($chatId) {
            $activeChat = $allChats->firstWhere('id', $chatId);
            if ($activeChat) {
                $activeChat->update(['unread_user' => 0]);
                $messages = $activeChat->messages()->get();
            }
        }

        return view('user.livechat', compact('allChats', 'activeChat', 'messages'));
    }

    public function newChat()
    {
        $user = Auth::guard('web')->user();

        // Check if there's already an open chat
        $existing = LiveChat::where('user_id', $user->id)
            ->where('status', 'open')
            ->latest()
            ->first();

        if ($existing) {
            return redirect()->route('user.live-chat.show', $existing->id);
        }

        $chat = LiveChat::create([
            'user_id'      => $user->id,
            'status'       => 'open',
            'unread_admin' => 0,
            'unread_user'  => 0,
        ]);

        return redirect()->route('user.live-chat.show', $chat->id);
    }

    public function startOrGet()
    {
        $user = Auth::guard('web')->user();

        $chat = LiveChat::firstOrCreate(
            ['user_id' => $user->id, 'status' => 'open'],
            ['unread_admin' => 0, 'unread_user' => 0]
        );

        return response()->json([
            'chat_id' => $chat->id,
            'status'  => $chat->status,
        ]);
    }

    public function getMessages(int $chatId)
    {
        $user = Auth::guard('web')->user();

        $chat = LiveChat::where('id', $chatId)->where('user_id', $user->id)->firstOrFail();

        $chat->update(['unread_user' => 0]);

        $messages = $chat->messages()->get()->map(fn ($m) => [
            'id'          => $m->id,
            'sender_type' => $m->sender_type,
            'message'     => $m->message,
            'time'        => $m->created_at->format('h:i A'),
        ]);

        return response()->json(['messages' => $messages]);
    }

    public function send(Request $request, int $chatId)
    {
        $request->validate(['message' => 'required|string|max:2000']);

        $user = Auth::guard('web')->user();

        $chat = LiveChat::where('id', $chatId)->where('user_id', $user->id)->firstOrFail();

        if ($chat->status === 'closed') {
            return response()->json(['error' => 'Chat is closed.'], 422);
        }

        LiveChatMessage::create([
            'chat_id'     => $chat->id,
            'sender_type' => 'user',
            'message'     => $request->message,
        ]);

        $chat->increment('unread_admin');

        return response()->json(['success' => true]);
    }

    public function unreadCount()
    {
        $user = Auth::guard('web')->user();

        $count = LiveChat::where('user_id', $user->id)
            ->where('status', 'open')
            ->sum('unread_user');

        return response()->json(['unread' => $count]);
    }
}
