@extends(dashboard_layout())
@section('title')
<title>{{ __('translate.Live Chat') }} - #{{ $chat->id }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Live Chat') }}</h3>
    <p class="crancy-header__text">
        {{ __('translate.Dashboard') }} >>
        <a href="{{ dashboard_route('admin.live-chat.index') }}">{{ __('translate.Live Chat') }}</a>
        >> #{{ $chat->id }}
    </p>
@endsection

@section('body-content')
<style>
    :root { --lc-primary: #c62828; --lc-primary-hover: #b71c1c; }

    .lc-admin-header            { background: var(--lc-primary) !important; }
    .lc-bubble-admin            { background: var(--lc-primary) !important; color: #fff !important; }
    .lc-input-row               { display: grid !important; grid-template-columns: 1fr auto !important;
                                  gap: 10px; align-items: center; }
    #lc-reply-input             { width: 100% !important; box-sizing: border-box !important;
                                  border-radius: 50px !important; padding: 10px 18px !important;
                                  border: 1.5px solid #dee2e6 !important; outline: none !important;
                                  font-size: 14px !important; background: #fff !important;
                                  box-shadow: none !important; }
    #lc-reply-input:focus       { border-color: var(--lc-primary) !important; box-shadow: none !important; }
    #lc-send-btn,
    #lc-send-btn.lc-send-btn    { display: inline-flex !important; align-items: center; gap: 6px;
                                  width: auto !important; white-space: nowrap !important;
                                  border-radius: 50px !important; padding: 10px 22px !important;
                                  font-size: 14px !important; font-weight: 600 !important;
                                  background: var(--lc-primary) !important;
                                  background-color: var(--lc-primary) !important;
                                  border: none !important;
                                  color: #fff !important;
                                  transition: background .15s; }
    #lc-send-btn:hover,
    #lc-send-btn.lc-send-btn:hover { background: var(--lc-primary-hover) !important;
                                     background-color: var(--lc-primary-hover) !important; }
    /* ── Fixed-height chat card ── */
    .lc-chat-card     { display: flex !important; flex-direction: column !important;
                        height: calc(100vh - 220px) !important; min-height: 480px !important;
                        border-radius: 16px !important; overflow: hidden !important; }
    .lc-msg-area      { flex: 1 !important; overflow-y: auto !important;
                        padding: 20px; background: #f8f9fa;
                        display: flex; flex-direction: column; gap: 10px; }
    /* Sidebar card matches chat height */
    .lc-info-card     { position: sticky !important; top: 80px !important; }
</style>

<section class="crancy-adashboard crancy-show">
    <div class="container container__bscreen">
        <div class="row row__bscreen">
            <div class="col-12">
                <div class="crancy-body">
                    <div class="crancy-dsinner">
                        <div class="row mg-top-30">
                            <!-- Chat Area -->
                            <div class="col-lg-8 col-12">
                                <div class="card border-0 shadow-sm lc-chat-card">
                                    <!-- Header -->
                                    <div class="card-header lc-admin-header d-flex align-items-center justify-content-between"
                                         style="color:#fff;padding:14px 20px">
                                        <div class="d-flex align-items-center gap-3">
                                            <div style="width:40px;height:40px;background:rgba(255,255,255,0.2);border-radius:50%;display:flex;align-items:center;justify-content:center">
                                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                                </svg>
                                            </div>
                                            <div>
                                                <div class="fw-bold">{{ $chat->user?->name ?? __('translate.Deleted User') }}</div>
                                                <div style="font-size:12px;opacity:0.85">{{ $chat->user?->email }}</div>
                                            </div>
                                        </div>
                                        <span class="badge {{ $chat->status === 'open' ? 'bg-light text-success' : 'bg-secondary' }}">
                                            {{ $chat->status === 'open' ? __('translate.Open') : __('translate.Closed') }}
                                        </span>
                                    </div>

                                    <!-- Messages -->
                                    <div id="admin-lc-messages" class="lc-msg-area">
                                        @forelse($chat->messages as $msg)
                                            <div class="d-flex {{ $msg->sender_type === 'admin' ? 'justify-content-end' : 'justify-content-start' }}">
                                                <div class="{{ $msg->sender_type === 'admin' ? 'lc-bubble-admin' : '' }}"
                                                     style="max-width:72%;padding:10px 15px;border-radius:14px;font-size:14px;line-height:1.5;word-break:break-word;
                                                        {{ $msg->sender_type === 'admin'
                                                            ? 'border-bottom-right-radius:4px'
                                                            : 'background:#fff;color:#222;border-bottom-left-radius:4px;box-shadow:0 1px 4px rgba(0,0,0,0.08)' }}">
                                                    {{ $msg->message }}
                                                    <div style="font-size:10px;opacity:0.6;margin-top:3px;text-align:{{ $msg->sender_type === 'admin' ? 'right' : 'left' }}">
                                                        {{ $msg->sender_type === 'admin' ? __('translate.You') : ($chat->user?->name ?? __('translate.Customer')) }}
                                                        &middot; {{ $msg->created_at->format('h:i A') }}
                                                    </div>
                                                </div>
                                            </div>
                                        @empty
                                            <div class="text-center text-muted py-5" id="lc-no-msg">{{ __('translate.No messages yet') }}</div>
                                        @endforelse
                                    </div>

                                    <!-- Reply Form -->
                                    @if($chat->status === 'open')
                                    <div class="card-footer bg-white border-top" style="padding:14px 18px">
                                        <div class="lc-input-row">
                                            <input type="text" id="lc-reply-input"
                                                   placeholder="{{ __('translate.Type a reply') }}..."
                                                   maxlength="2000" autocomplete="off">
                                            <button id="lc-send-btn" class="btn lc-send-btn">
                                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"
                                                     stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                                </svg>
                                                <span id="lc-send-label">{{ __('translate.Send') }}</span>
                                            </button>
                                        </div>
                                        <div id="lc-send-error" class="text-danger mt-1" style="font-size:12px;display:none"></div>
                                    </div>
                                    @else
                                    <div class="card-footer bg-light text-center text-muted" style="font-size:13px;padding:12px">
                                        {{ __('translate.This conversation is closed') }}
                                    </div>
                                    @endif
                                </div>
                            </div>

                            <!-- Info Sidebar -->
                            <div class="col-lg-4 col-12 mt-4 mt-lg-0">
                                <div class="card border-0 shadow-sm p-4 lc-info-card" style="border-radius:16px">
                                    <h5 class="mb-3">{{ __('translate.Customer Info') }}</h5>
                                    @if($chat->user)
                                    <div class="mb-2"><strong>{{ __('translate.Name') }}:</strong> {{ $chat->user->name }}</div>
                                    <div class="mb-2"><strong>{{ __('translate.Email') }}:</strong> {{ $chat->user->email }}</div>
                                    @if($chat->user->phone)
                                    <div class="mb-2"><strong>{{ __('translate.Phone') }}:</strong> {{ $chat->user->phone }}</div>
                                    @endif
                                    @else
                                    <div class="text-muted">{{ __('translate.User not found') }}</div>
                                    @endif
                                    <hr>
                                    <div class="mb-2"><strong>{{ __('translate.Started') }}:</strong> {{ $chat->created_at->format('d M Y, h:i A') }}</div>
                                    <div class="mb-3"><strong>{{ __('translate.Messages') }}:</strong> <span id="lc-msg-count">{{ $chat->messages->count() }}</span></div>
                                    <hr>
                                    @if($chat->status === 'open')
                                    <form id="close-chat-form" action="{{ dashboard_route('admin.live-chat.close', $chat->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button type="button" class="btn btn-outline-secondary w-100" id="open-close-modal-btn">
                                            {{ __('translate.Close Chat') }}
                                        </button>
                                    </form>
                                    @else
                                    <form action="{{ dashboard_route('admin.live-chat.reopen', $chat->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <button class="btn btn-outline-success w-100">
                                            {{ __('translate.Reopen Chat') }}
                                        </button>
                                    </form>
                                    @endif
                                    <a href="{{ dashboard_route('admin.live-chat.index') }}" class="btn btn-outline-dark w-100 mt-2">
                                        &larr; {{ __('translate.All Chats') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Custom Close Chat Modal --}}
<div id="lc-close-modal" style="display:none;position:fixed;inset:0;z-index:9999;align-items:center;justify-content:center">
    {{-- backdrop --}}
    <div id="lc-modal-backdrop"
         style="position:absolute;inset:0;background:rgba(0,0,0,0.45);backdrop-filter:blur(3px)"></div>
    {{-- dialog --}}
    <div style="position:relative;background:#fff;border-radius:20px;padding:36px 32px;max-width:400px;width:90%;
                box-shadow:0 20px 60px rgba(0,0,0,0.18);text-align:center;animation:lcModalIn .2s ease">
        {{-- icon --}}
        <div style="width:64px;height:64px;border-radius:50%;background:rgba(198,40,40,0.1);
                    display:flex;align-items:center;justify-content:center;margin:0 auto 20px">
            <svg width="30" height="30" fill="none" viewBox="0 0 24 24"
                 stroke="var(--lc-primary,#c62828)" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636m12.728 12.728L5.636 5.636"/>
            </svg>
        </div>
        <h5 style="font-weight:700;margin-bottom:8px;color:#1a1a2e">{{ __('translate.Close Chat') }}</h5>
        <p style="color:#6b7280;font-size:14px;margin-bottom:28px">{{ __('translate.Close this chat?') }}</p>
        <div style="display:flex;gap:12px;justify-content:center">
            <button id="lc-modal-cancel"
                    style="flex:1;padding:10px 0;border-radius:12px;border:1.5px solid #e5e7eb;
                           background:#fff;color:#374151;font-weight:600;cursor:pointer;font-size:14px;
                           transition:background .15s">
                {{ __('translate.Cancel') }}
            </button>
            <button id="lc-modal-confirm"
                    style="flex:1;padding:10px 0;border-radius:12px;border:none;
                           background:var(--lc-primary,#c62828);color:#fff;font-weight:600;
                           cursor:pointer;font-size:14px;transition:opacity .15s">
                {{ __('translate.Close Chat') }}
            </button>
        </div>
    </div>
</div>

<style>
@keyframes lcModalIn {
    from { transform: scale(.92); opacity: 0; }
    to   { transform: scale(1);   opacity: 1; }
}
</style>

<script>
(function () {
    const container  = document.getElementById('admin-lc-messages');
    const sendBtn    = document.getElementById('lc-send-btn');
    const replyInput = document.getElementById('lc-reply-input');
    const sendLabel  = document.getElementById('lc-send-label');
    const sendError  = document.getElementById('lc-send-error');
    const countEl    = document.getElementById('lc-msg-count');

    const chatId = {{ $chat->id }};
    const csrf   = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';

    const you      = @json(__('translate.You'));
    const customer = @json(__('translate.Customer'));
    const noMsg    = @json(__('translate.No messages yet'));

    if (container) container.scrollTop = container.scrollHeight;

    function buildBubble(m) {
        const wrap   = document.createElement('div');
        wrap.className = `d-flex ${m.sender_type === 'admin' ? 'justify-content-end' : 'justify-content-start'}`;
        const bubble = document.createElement('div');
        if (m.sender_type === 'admin') bubble.classList.add('lc-bubble-admin');
        bubble.style.cssText = `max-width:72%;padding:10px 15px;border-radius:14px;font-size:14px;line-height:1.5;word-break:break-word;${
            m.sender_type === 'admin'
                ? 'border-bottom-right-radius:4px'
                : 'background:#fff;color:#222;border-bottom-left-radius:4px;box-shadow:0 1px 4px rgba(0,0,0,0.08)'
        }`;
        bubble.innerHTML = `${escHtml(m.message)}<div style="font-size:10px;opacity:0.6;margin-top:3px;text-align:${m.sender_type==='admin'?'right':'left'}">${m.sender_type==='admin'? you : customer} &middot; ${m.time}</div>`;
        wrap.appendChild(bubble);
        return wrap;
    }

    function escHtml(t) {
        const d = document.createElement('div');
        d.appendChild(document.createTextNode(t));
        return d.innerHTML;
    }

    @if($chat->status === 'open')
    // ─── AJAX send ───────────────────────────────────────────────
    async function sendMessage() {
        const text = replyInput ? replyInput.value.trim() : '';
        if (!text) return;

        sendBtn.disabled = true;
        sendLabel.textContent = '…';
        if (sendError) { sendError.style.display = 'none'; sendError.textContent = ''; }

        try {
            const res = await fetch(`{{ dashboard_url('admin/live-chat') }}/${chatId}/send`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'Accept': 'application/json',
                    'X-CSRF-TOKEN': csrf,
                },
                body: JSON.stringify({ message: text }),
            });

            const data = await res.json();

            if (res.ok && data.success) {
                if (replyInput) replyInput.value = '';
                // Remove "no messages" placeholder if present
                const noMsgEl = document.getElementById('lc-no-msg');
                if (noMsgEl) noMsgEl.remove();
                // Append new bubble
                container.appendChild(buildBubble(data.message));
                container.scrollTop = container.scrollHeight;
                if (countEl) countEl.textContent = parseInt(countEl.textContent || '0') + 1;
            } else {
                if (sendError) {
                    sendError.textContent = data.error ?? 'Error sending message.';
                    sendError.style.display = 'block';
                }
            }
        } catch (e) {
            if (sendError) {
                sendError.textContent = 'Network error. Please try again.';
                sendError.style.display = 'block';
            }
        } finally {
            sendBtn.disabled = false;
            sendLabel.textContent = ' {{ __("translate.Send") }}';
        }
    }

    if (sendBtn)    sendBtn.addEventListener('click', sendMessage);
    if (replyInput) replyInput.addEventListener('keydown', function (e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
    });

    // ─── Polling for new messages ────────────────────────────────
    let lastCount = {{ $chat->messages->count() }};

    setInterval(async () => {
        try {
            const res  = await fetch(`{{ dashboard_url('admin/live-chat') }}/${chatId}/messages`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf }
            });
            const data = await res.json();
            if (data.messages && data.messages.length !== lastCount) {
                lastCount = data.messages.length;
                if (countEl) countEl.textContent = lastCount;
                container.innerHTML = '';
                if (lastCount === 0) {
                    const empty = document.createElement('div');
                    empty.id = 'lc-no-msg';
                    empty.className = 'text-center text-muted py-5';
                    empty.textContent = noMsg;
                    container.appendChild(empty);
                } else {
                    data.messages.forEach(m => container.appendChild(buildBubble(m)));
                }
                container.scrollTop = container.scrollHeight;
            }
        } catch (e) {}
    }, 4000);
    @endif

    // ─── Close Chat Modal ─────────────────────────────────────────
    (function () {
        const openBtn    = document.getElementById('open-close-modal-btn');
        const modal      = document.getElementById('lc-close-modal');
        const backdrop   = document.getElementById('lc-modal-backdrop');
        const cancelBtn  = document.getElementById('lc-modal-cancel');
        const confirmBtn = document.getElementById('lc-modal-confirm');
        const closeForm  = document.getElementById('close-chat-form');

        if (!openBtn || !modal) return;

        function showModal() {
            modal.style.display = 'flex';
        }
        function hideModal() {
            modal.style.display = 'none';
        }

        openBtn.addEventListener('click', showModal);
        cancelBtn?.addEventListener('click', hideModal);
        backdrop?.addEventListener('click', hideModal);
        confirmBtn?.addEventListener('click', function () {
            if (closeForm) closeForm.submit();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') hideModal();
        });
    })();
})();
</script>
@endsection
