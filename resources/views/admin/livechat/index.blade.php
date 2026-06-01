@extends(dashboard_layout())
@section('title')
<title>{{ __('translate.Live Chat') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Live Chat') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.Live Chat') }}</p>
@endsection

@section('body-content')
<section class="crancy-adashboard crancy-show">
    <div class="container container__bscreen">
        <div class="row row__bscreen">
            <div class="col-12">
                <div class="crancy-body">
                    <div class="crancy-dsinner">
                        <div class="crancy-table mg-top-30">
                            <div class="crancy-table__heading" style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px">
                                <h3 class="crancy-table__title" style="margin:0">
                                    {{ __('translate.Live Chat Conversations') }}
                                    <span id="lc-unread-badge"
                                          class="badge bg-danger ms-2"
                                          style="{{ $totalUnread > 0 ? '' : 'display:none' }}">
                                        {{ $totalUnread }}
                                    </span>
                                </h3>
                                {{-- Live indicator --}}
                                <div style="display:flex;align-items:center;gap:8px;font-size:13px;color:#6b7280">
                                    <span id="lc-live-dot"
                                          style="display:inline-block;width:8px;height:8px;border-radius:50%;
                                                 background:#22c55e;animation:lcPulse 1.4s infinite"></span>
                                    <span id="lc-live-label">{{ __('translate.Live') }}</span>
                                </div>
                            </div>

                            {{-- New-chat notification bar (hidden by default) --}}
                            <div id="lc-new-notify"
                                 style="display:none;margin-top:12px;padding:10px 16px;border-radius:10px;
                                        background:#fef3c7;border:1px solid #fcd34d;
                                        font-size:13px;font-weight:600;color:#92400e;
                                        display:none;align-items:center;gap:10px">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                </svg>
                                <span id="lc-new-notify-text"></span>
                                <button onclick="location.reload()"
                                        style="margin-left:auto;padding:4px 12px;border-radius:8px;border:none;
                                               background:#92400e;color:#fff;font-size:12px;cursor:pointer">
                                    {{ __('translate.Refresh') }}
                                </button>
                            </div>

                            <div class="crancy-table__main">
                                <table class="table crancy-table__inner mg-top-20">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>{{ __('translate.Customer') }}</th>
                                            <th>{{ __('translate.Status') }}</th>
                                            <th>{{ __('translate.Unread') }}</th>
                                            <th>{{ __('translate.Last Message') }}</th>
                                            <th>{{ __('translate.Date') }}</th>
                                            <th>{{ __('translate.Action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody id="lc-tbody">
                                        @forelse($chats as $chat)
                                        <tr id="lc-row-{{ $chat->id }}">
                                            <td>{{ $chat->id }}</td>
                                            <td>
                                                @if($chat->user)
                                                    <strong>{{ $chat->user->name }}</strong><br>
                                                    <small class="text-muted">{{ $chat->user->email }}</small>
                                                @else
                                                    <span class="text-muted">{{ __('translate.Deleted User') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($chat->status === 'open')
                                                    <span class="badge bg-success">{{ __('translate.Open') }}</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ __('translate.Closed') }}</span>
                                                @endif
                                            </td>
                                            <td id="lc-unread-{{ $chat->id }}">
                                                @if($chat->unread_admin > 0)
                                                    <span class="badge bg-danger">{{ $chat->unread_admin }}</span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td id="lc-last-{{ $chat->id }}">
                                                @if($chat->lastMessage->first())
                                                    <span class="text-muted" style="font-size:13px">
                                                        {{ Str::limit($chat->lastMessage->first()->message, 50) }}
                                                    </span>
                                                @else
                                                    <span class="text-muted">—</span>
                                                @endif
                                            </td>
                                            <td id="lc-date-{{ $chat->id }}">{{ $chat->updated_at->format('d M Y, h:i A') }}</td>
                                            <td>
                                                <a href="{{ dashboard_route('admin.live-chat.show', $chat->id) }}"
                                                   class="crancy-btn crancy-btn--sm crancy-btn--border">
                                                    {{ __('translate.View') }}
                                                </a>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr id="lc-empty-row">
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                {{ __('translate.No conversations yet') }}
                                            </td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>

                                <div class="mt-3">{{ $chats->links() }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
@keyframes lcPulse {
    0%, 100% { opacity: 1; transform: scale(1); }
    50%       { opacity: .4; transform: scale(.7); }
}
</style>

<script>
(function () {
    const csrf       = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';
    const jsonUrl    = '{{ dashboard_route("admin.live-chat.json") }}';
    const badge      = document.getElementById('lc-unread-badge');
    const notify     = document.getElementById('lc-new-notify');
    const notifyText = document.getElementById('lc-new-notify-text');
    const tbody      = document.getElementById('lc-tbody');

    // Track known chat IDs on first load
    let knownIds = new Set([
        @foreach($chats as $chat) {{ $chat->id }}, @endforeach
    ]);

    let prevUnread = {{ $totalUnread }};

    function esc(t) {
        return String(t ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    }

    function updateRow(c) {
        // Update unread cell
        const unreadCell = document.getElementById('lc-unread-' + c.id);
        if (unreadCell) {
            unreadCell.innerHTML = c.unread_admin > 0
                ? `<span class="badge bg-danger">${c.unread_admin}</span>`
                : `<span class="text-muted">—</span>`;
        }
        // Update last message cell
        const lastCell = document.getElementById('lc-last-' + c.id);
        if (lastCell) {
            lastCell.innerHTML = c.last_message
                ? `<span class="text-muted" style="font-size:13px">${esc(c.last_message)}</span>`
                : `<span class="text-muted">—</span>`;
        }
        // Update date cell
        const dateCell = document.getElementById('lc-date-' + c.id);
        if (dateCell) dateCell.textContent = c.updated_at;
    }

    function addNewRow(c) {
        // Remove empty-state row if present
        document.getElementById('lc-empty-row')?.remove();

        const tr = document.createElement('tr');
        tr.id = 'lc-row-' + c.id;
        const statusBadge = c.status === 'open'
            ? `<span class="badge bg-success">{{ __('translate.Open') }}</span>`
            : `<span class="badge bg-secondary">{{ __('translate.Closed') }}</span>`;
        const unread = c.unread_admin > 0
            ? `<span class="badge bg-danger">${c.unread_admin}</span>`
            : `<span class="text-muted">—</span>`;
        const lastMsg = c.last_message
            ? `<span class="text-muted" style="font-size:13px">${esc(c.last_message)}</span>`
            : `<span class="text-muted">—</span>`;
        const userInfo = c.user_name
            ? `<strong>${esc(c.user_name)}</strong><br><small class="text-muted">${esc(c.user_email)}</small>`
            : `<span class="text-muted">{{ __('translate.Deleted User') }}</span>`;

        tr.innerHTML = `
            <td>${c.id}</td>
            <td>${userInfo}</td>
            <td>${statusBadge}</td>
            <td id="lc-unread-${c.id}">${unread}</td>
            <td id="lc-last-${c.id}">${lastMsg}</td>
            <td id="lc-date-${c.id}">${c.updated_at}</td>
            <td><a href="${c.show_url}" class="crancy-btn crancy-btn--sm crancy-btn--border">{{ __('translate.View') }}</a></td>
        `;
        // Add with highlight animation
        tr.style.cssText = 'background:#fef9c3;transition:background 2s';
        tbody.prepend(tr);
        setTimeout(() => { tr.style.background = ''; }, 100);
    }

    async function poll() {
        try {
            const res  = await fetch(jsonUrl, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf }
            });
            const data = await res.json();
            if (!data.chats) return;

            let hasNew = false;

            data.chats.forEach(c => {
                if (!knownIds.has(c.id)) {
                    // Brand new chat
                    knownIds.add(c.id);
                    addNewRow(c);
                    hasNew = true;
                } else {
                    updateRow(c);
                }
            });

            // Update total unread badge
            const total = data.total_unread ?? 0;
            if (badge) {
                badge.textContent = total;
                badge.style.display = total > 0 ? '' : 'none';
            }

            // Show notification for new chats
            if (hasNew && notify && notifyText) {
                notifyText.textContent = '{{ __("translate.New Chat") }}: {{ __("translate.New conversations received") }}';
                notify.style.display = 'flex';
            }

        } catch (e) {
            // silent
        }
    }

    // Poll every 5 seconds
    setInterval(poll, 5000);
})();
</script>
@endsection
