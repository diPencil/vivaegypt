<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\LiveChat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class SidebarBadgeController extends Controller
{
    /**
     * Return live counts for user sidebar badges.
     * Polled by master_layout to keep badges real-time.
     */
    public function counts()
    {
        $user = Auth::guard('web')->user();

        if (!$user) {
            return response()->json([
                'live_chat'      => 0,
                'bookings'       => 0,
                'orders'         => 0,
                'agent_support'  => 0,
                'support_ticket' => 0,
            ]);
        }

        $userId = $user->id;

        $liveChat = Schema::hasTable('live_chats')
            ? (int) LiveChat::where('user_id', $userId)->where('status', 'open')->sum('unread_user')
            : 0;

        $bookings = Schema::hasTable('bookings')
            ? (int) DB::table('bookings')
                ->where('user_id', $userId)
                ->whereIn('booking_status', ['pending', 'confirmed'])
                ->where('is_reviewed', 0)
                ->count()
            : 0;

        $orders = Schema::hasTable('orders')
            ? (int) DB::table('orders')
                ->where('user_id', $userId)
                ->whereIn('order_status', ['pending', 'processing'])
                ->count()
            : 0;

        $agentSupport   = $this->unseenSupportMessages($userId, 'agent');
        $supportTicket  = $this->unseenSupportMessages($userId, 'admin');

        return response()->json([
            'live_chat'      => $liveChat,
            'bookings'       => $bookings,
            'orders'         => $orders,
            'agent_support'  => $agentSupport,
            'support_ticket' => $supportTicket,
        ]);
    }

    /**
     * Count support ticket messages addressed to this user that they
     * have not yet seen, filtered by the ticket admin_type.
     */
    private function unseenSupportMessages(int $userId, string $adminType): int
    {
        if (!Schema::hasTable('support_tickets') || !Schema::hasTable('support_ticket_messages')) {
            return 0;
        }

        return (int) DB::table('support_ticket_messages as m')
            ->join('support_tickets as t', 't.id', '=', 'm.support_ticket_id')
            ->where('t.author_id', $userId)
            ->where('t.admin_type', $adminType)
            ->where('m.is_seen', 0)
            ->where('m.message_author_id', '!=', $userId)
            ->count();
    }
}
