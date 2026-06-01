@extends('user.master_layout')

@section('title')
    <title>{{ __('translate.Live Chat') }}</title>
@endsection

@section('body-header')
    <h3 class="crancy-header__title m-0">{{ __('translate.Live Chat') }}</h3>
    <p class="crancy-header__text">{{ __('translate.Dashboard') }} >> {{ __('translate.Live Chat') }}</p>
@endsection

@section('body-content')
<style>
/* ── Prevent page scroll on chat page ───────────────────── */
body,
.crancy-body-area,
.crancy-smenu + div,
section.crancy-adashboard {
    overflow: hidden !important;
}

/* ── Main layout ────────────────────────────────────────── */
.ulc-shell {
    display: grid !important;
    grid-template-columns: 280px 1fr !important;
    gap: 0;
    height: calc(100vh - 170px) !important;
    min-height: 460px !important;
    border-radius: 18px;
    overflow: hidden !important;
    box-shadow: 0 4px 32px rgba(0,0,0,0.10);
    background: #fff;
    margin: 20px 0 0 !important;
}

/* ── Left sidebar ───────────────────────────────────────── */
.ulc-sidebar {
    background: #f7f8fc;
    border-right: 1px solid #eaecf0;
    display: flex !important;
    flex-direction: column !important;
    overflow: hidden;
}
.ulc-sidebar-head {
    padding: 18px 16px 14px;
    border-bottom: 1px solid #eaecf0;
    background: #fff;
}
.ulc-sidebar-title {
    font-size: 15px;
    font-weight: 700;
    color: #1a1a2e;
    margin: 0 0 10px;
}
.ulc-new-btn {
    width: 100%;
    padding: 8px 14px;
    border-radius: 10px;
    border: 1.5px dashed var(--tg-theme-primary, #c62828);
    background: transparent;
    color: var(--tg-theme-primary, #c62828);
    font-size: 13px;
    font-weight: 600;
    cursor: pointer;
    transition: background .15s, color .15s;
    display: flex !important;
    align-items: center;
    justify-content: center;
    gap: 6px;
    text-decoration: none;
}
.ulc-new-btn:hover {
    background: var(--tg-theme-primary, #c62828);
    color: #fff;
}
.ulc-chat-list { flex: 1; overflow-y: auto; padding: 8px 0; }
.ulc-chat-item {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 10px;
    padding: 12px 16px;
    cursor: pointer;
    transition: background .15s;
    text-decoration: none;
    border-left: 3px solid transparent;
}
.ulc-chat-item:hover  { background: #eef0f6; }
.ulc-chat-item.active { background: #eef0f6; border-left-color: var(--tg-theme-primary, #c62828); }
.ulc-chat-dot {
    width: 38px; height: 38px; border-radius: 50%; flex-shrink: 0;
    background: var(--tg-theme-primary, #c62828);
    display: flex !important; align-items: center; justify-content: center;
    color: #fff; font-size: 14px; font-weight: 700;
}
.ulc-chat-dot.closed { background: #9ca3af; }
.ulc-chat-meta { flex: 1; min-width: 0; }
.ulc-chat-meta-top {
    display: flex !important;
    flex-direction: row !important;
    align-items: center;
    justify-content: space-between;
    gap: 4px;
}
.ulc-chat-id    { font-size: 13px; font-weight: 700; color: #1a1a2e; }
.ulc-chat-badge {
    font-size: 10px; font-weight: 700; padding: 2px 7px; border-radius: 20px;
    background: #d1fae5; color: #065f46;
}
.ulc-chat-badge.closed { background: #f3f4f6; color: #6b7280; }
.ulc-chat-preview { font-size: 12px; color: #6b7280; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-top: 2px; }
.ulc-unread-dot {
    width: 8px; height: 8px; border-radius: 50;
    background: var(--tg-theme-primary, #c62828);
    flex-shrink: 0;
}

/* ── Right chat panel ───────────────────────────────────── */
.ulc-panel {
    display: flex !important;
    flex-direction: column !important;
    overflow: hidden;
    background: #fff;
}
.ulc-panel-head {
    padding: 16px 22px;
    border-bottom: 1px solid #eaecf0;
    background: var(--tg-theme-primary, #c62828);
    color: #fff;
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 12px;
    flex-shrink: 0;
}
.ulc-panel-avatar {
    width: 40px; height: 40px; border-radius: 50%; flex-shrink: 0;
    background: rgba(255,255,255,.22);
    display: flex !important; align-items: center; justify-content: center;
}
.ulc-panel-info { flex: 1; min-width: 0; }
.ulc-panel-name { font-size: 15px; font-weight: 700; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.ulc-panel-sub  { font-size: 11px; opacity: .8; white-space: nowrap; }
.ulc-status-badge {
    font-size: 11px; font-weight: 700; padding: 3px 10px; border-radius: 20px; flex-shrink: 0;
    background: rgba(255,255,255,.2); color: #fff;
}

/* ── Messages area ──────────────────────────────────────── */
.ulc-messages {
    flex: 1;
    overflow-y: auto;
    padding: 20px;
    background: #f7f8fc;
    display: flex !important;
    flex-direction: column !important;
    gap: 12px;
}
.ulc-bubble-wrap-user  { display: flex !important; justify-content: flex-end !important; }
.ulc-bubble-wrap-admin { display: flex !important; justify-content: flex-start !important; }
.ulc-bubble {
    max-width: 68%; padding: 10px 15px; font-size: 14px;
    line-height: 1.55; word-break: break-word;
}
.ulc-bubble-user  { background: var(--tg-theme-primary, #c62828); color: #fff; border-radius: 18px 18px 4px 18px; }
.ulc-bubble-admin { background: #fff; color: #1a1a2e; border-radius: 18px 18px 18px 4px; box-shadow: 0 1px 6px rgba(0,0,0,.08); }
.ulc-time { font-size: 10px; opacity: .6; margin-top: 4px; display: block; }
.ulc-empty-state {
    flex: 1; display: flex !important; flex-direction: column !important;
    align-items: center; justify-content: center;
    gap: 10px; color: #9ca3af; padding: 40px 0;
}

/* ── Input area ─────────────────────────────────────────── */
.ulc-footer {
    padding: 14px 18px;
    border-top: 1px solid #eaecf0;
    background: #fff;
    flex-shrink: 0;
}
.ulc-input-row { display: grid !important; grid-template-columns: 1fr auto !important; gap: 10px; align-items: center; }
.ulc-input {
    width: 100% !important; box-sizing: border-box !important;
    border: 1.5px solid #e5e7eb !important; border-radius: 50px !important;
    padding: 10px 18px !important; font-size: 14px !important;
    outline: none !important; background: #fff !important; box-shadow: none !important;
}
.ulc-input:focus { border-color: var(--tg-theme-primary, #c62828) !important; }
.ulc-send {
    display: inline-flex !important; align-items: center; gap: 6px;
    width: auto !important; white-space: nowrap !important;
    border: none !important; border-radius: 50px !important; padding: 10px 22px !important;
    font-size: 14px; font-weight: 600;
    background: var(--tg-theme-primary, #c62828) !important; color: #fff !important;
    cursor: pointer; transition: opacity .15s;
}
.ulc-send:hover   { opacity: .85; }
.ulc-send:disabled{ opacity: .5; cursor: default; }
.ulc-closed-bar {
    padding: 12px; text-align: center; font-size: 13px;
    color: #6b7280; background: #f9fafb;
    border-top: 1px solid #eaecf0; flex-shrink: 0;
}

/* ── Responsive ─────────────────────────────────────────── */
@media (max-width: 767px) {
    .ulc-shell { grid-template-columns: 1fr !important; height: auto; max-height: none; }
    .ulc-sidebar { max-height: 220px; border-right: none; border-bottom: 1px solid #eaecf0; }
}
</style>

<section class="crancy-adashboard crancy-show">
    <div class="container container__bscreen">
        <div class="row row__bscreen">
            <div class="col-12" style="padding:0">

                <div class="ulc-shell">

                    {{-- ══ LEFT SIDEBAR ══════════════════════════════════ --}}
                    <div class="ulc-sidebar">
                        <div class="ulc-sidebar-head">
                            <p class="ulc-sidebar-title">{{ __('translate.Live Chat') }}</p>
                            @if($allChats->where('status','open')->isEmpty())
                            <form method="POST" action="{{ route('user.live-chat.new') }}">
                                @csrf
                                <button type="submit" class="ulc-new-btn">
                                    <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    {{ __('translate.New Chat') }}
                                </button>
                            </form>
                            @endif
                        </div>

                        <div class="ulc-chat-list">
                            @forelse($allChats as $c)
                            @php
                                $lastMsg = $c->lastMessage->first();
                                $preview = $lastMsg ? \Str::limit($lastMsg->message, 32) : __('translate.No messages yet');
                                $isActive = $activeChat && $c->id === $activeChat->id;
                            @endphp
                            <a href="{{ route('user.live-chat.show', $c->id) }}"
                               class="ulc-chat-item {{ $isActive ? 'active' : '' }}">
                                <div class="ulc-chat-dot {{ $c->status === 'closed' ? 'closed' : '' }}">
                                    #{{ $c->id }}
                                </div>
                                <div class="ulc-chat-meta">
                                    <div class="ulc-chat-meta-top">
                                        <span class="ulc-chat-id">{{ __('translate.Chat') }} #{{ $c->id }}</span>
                                        <span class="ulc-chat-badge {{ $c->status === 'closed' ? 'closed' : '' }}">
                                            {{ $c->status === 'open' ? __('translate.Open') : __('translate.Closed') }}
                                        </span>
                                    </div>
                                    <div class="ulc-chat-preview">{{ $preview }}</div>
                                </div>
                                @if($c->unread_user > 0 && !$isActive)
                                <div class="ulc-unread-dot"></div>
                                @endif
                            </a>
                            @empty
                            <div style="padding:24px 16px;text-align:center;color:#9ca3af;font-size:13px">
                                {{ __('translate.No conversations yet') }}
                            </div>
                            @endforelse
                        </div>
                    </div>

                    {{-- ══ RIGHT CHAT PANEL ══════════════════════════════ --}}
                    <div class="ulc-panel">

                    @if($activeChat)
                        {{-- ── Active chat ──────────────────────────────── --}}
                        <div class="ulc-panel-head">
                            <div class="ulc-panel-avatar">
                                <svg width="20" height="20" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="1.8">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <div class="ulc-panel-info">
                                <div class="ulc-panel-name">{{ __('translate.Live Support') }}</div>
                                <div class="ulc-panel-sub">{{ __('translate.We reply as fast as we can') }}</div>
                            </div>
                            <span class="ulc-status-badge">
                                {{ $activeChat->status === 'open' ? __('translate.Open') : __('translate.Closed') }}
                            </span>
                        </div>

                        {{-- Messages --}}
                        <div class="ulc-messages" id="ulc-messages">
                            @if($messages->isEmpty())
                                <div class="ulc-empty-state" id="ulc-empty">
                                    <svg width="52" height="52" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="1.1" style="opacity:.3">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                    </svg>
                                    <span>{{ __('translate.Start a conversation') }}...</span>
                                </div>
                            @else
                                @foreach($messages as $msg)
                                <div class="ulc-bubble-wrap-{{ $msg->sender_type }}">
                                    <div class="ulc-bubble ulc-bubble-{{ $msg->sender_type }}">
                                        {{ $msg->message }}
                                        <span class="ulc-time" style="text-align:{{ $msg->sender_type === 'user' ? 'right' : 'left' }}">
                                            {{ $msg->sender_type === 'user' ? __('translate.You') : __('translate.Support') }}
                                            &middot; {{ $msg->created_at->format('h:i A') }}
                                        </span>
                                    </div>
                                </div>
                                @endforeach
                            @endif
                        </div>

                        {{-- Input / Closed --}}
                        @if($activeChat->status === 'open')
                        <div class="ulc-footer">
                            <div class="ulc-input-row">
                                <input type="text" id="ulc-input" class="ulc-input"
                                       placeholder="{{ __('translate.Type a message') }}..."
                                       maxlength="2000" autocomplete="off">
                                <button id="ulc-send" class="ulc-send">
                                    <svg width="15" height="15" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="2.2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                              d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
                                    </svg>
                                    {{ __('translate.Send') }}
                                </button>
                            </div>
                            <div id="ulc-error" style="color:#dc2626;font-size:12px;margin-top:6px;display:none"></div>
                        </div>
                        @else
                        <div class="ulc-closed-bar">{{ __('translate.This conversation is closed') }}</div>
                        @endif

                    @else
                        {{-- ── No chat selected: welcome / empty state ──── --}}
                        <div style="flex:1;display:flex!important;flex-direction:column!important;
                                    align-items:center;justify-content:center;
                                    gap:20px;padding:40px 30px;text-align:center;background:#f7f8fc">
                            <div style="width:90px;height:90px;border-radius:50%;
                                        background:rgba(198,40,40,.08);
                                        display:flex!important;align-items:center;justify-content:center">
                                <svg width="44" height="44" fill="none" viewBox="0 0 24 24"
                                     stroke="var(--tg-theme-primary,#c62828)" stroke-width="1.3">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                            </div>
                            <div>
                                <h5 style="font-weight:700;color:#1a1a2e;margin-bottom:8px">
                                    {{ __('translate.Live Support') }}
                                </h5>
                                <p style="color:#6b7280;font-size:14px;margin:0;line-height:1.6;max-width:280px">
                                    {{ __('translate.Select a conversation from the left or start a new one') }}
                                </p>
                            </div>

                            @if($allChats->where('status','open')->isEmpty())
                            {{-- No open chat exists → show start button --}}
                            <form method="POST" action="{{ route('user.live-chat.new') }}">
                                @csrf
                                <button type="submit"
                                        style="padding:12px 32px;border-radius:50px;border:none;
                                               background:var(--tg-theme-primary,#c62828);color:#fff;
                                               font-size:14px;font-weight:700;cursor:pointer;
                                               display:inline-flex;align-items:center;gap:8px;
                                               transition:opacity .15s">
                                    <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                         stroke="currentColor" stroke-width="2.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/>
                                    </svg>
                                    {{ __('translate.Start New Chat') }}
                                </button>
                            </form>
                            @else
                            {{-- Has open chat → prompt to select it --}}
                            <a href="{{ route('user.live-chat.show', $allChats->firstWhere('status','open')->id) }}"
                               style="padding:12px 32px;border-radius:50px;text-decoration:none;
                                      background:var(--tg-theme-primary,#c62828);color:#fff;
                                      font-size:14px;font-weight:700;
                                      display:inline-flex;align-items:center;gap:8px">
                                <svg width="16" height="16" fill="none" viewBox="0 0 24 24"
                                     stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                                </svg>
                                {{ __('translate.Continue Chat') }}
                            </a>
                            @endif
                        </div>
                    @endif

                    </div>{{-- /panel --}}
                </div>{{-- /shell --}}

            </div>
        </div>
    </div>
</section>

<script>
// Fix shell height to exactly fill remaining viewport
(function fixHeight() {
    const shell = document.querySelector('.ulc-shell');
    if (!shell) return;
    function resize() {
        const top  = shell.getBoundingClientRect().top + window.scrollY;
        const h    = window.innerHeight - top - 16;
        shell.style.height = Math.max(h, 400) + 'px';
    }
    resize();
    window.addEventListener('resize', resize);
})();

@if($activeChat)
(function () {
    const msgBox  = document.getElementById('ulc-messages');
    const input   = document.getElementById('ulc-input');
    const sendBtn = document.getElementById('ulc-send');
    const errEl   = document.getElementById('ulc-error');

    const chatId  = {{ $activeChat->id }};
    const csrf    = document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}';
    const you     = @json(__('translate.You'));
    const support = @json(__('translate.Support'));

    if (msgBox) msgBox.scrollTop = msgBox.scrollHeight;

    function buildBubble(m) {
        const isUser = m.sender_type === 'user';
        const wrap   = document.createElement('div');
        wrap.className = isUser ? 'ulc-bubble-wrap-user' : 'ulc-bubble-wrap-admin';
        const bbl    = document.createElement('div');
        bbl.className = `ulc-bubble ${isUser ? 'ulc-bubble-user' : 'ulc-bubble-admin'}`;
        bbl.innerHTML = `${escHtml(m.message)}<span class="ulc-time" style="text-align:${isUser?'right':'left'}">${isUser ? you : support} &middot; ${m.time}</span>`;
        wrap.appendChild(bbl);
        return wrap;
    }

    function escHtml(t) {
        const d = document.createElement('div');
        d.appendChild(document.createTextNode(t));
        return d.innerHTML;
    }

    @if($activeChat->status === 'open')
    // ── Send ─────────────────────────────────────────────────
    async function doSend() {
        const text = input?.value.trim();
        if (!text) return;
        sendBtn.disabled = true;
        if (errEl) { errEl.style.display = 'none'; errEl.textContent = ''; }

        try {
            const res  = await fetch(`{{ url('user/live-chat') }}/${chatId}/send`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf },
                body: JSON.stringify({ message: text }),
            });
            const data = await res.json();
            if (res.ok && data.success) {
                input.value = '';
                document.getElementById('ulc-empty')?.remove();
                const now  = new Date();
                const time = now.toLocaleTimeString([], { hour: '2-digit', minute: '2-digit' });
                msgBox.appendChild(buildBubble({ sender_type: 'user', message: text, time }));
                msgBox.scrollTop = msgBox.scrollHeight;
            } else {
                if (errEl) { errEl.textContent = data.error ?? '{{ __("translate.Error") }}'; errEl.style.display = 'block'; }
            }
        } catch (e) {
            if (errEl) { errEl.textContent = 'Network error.'; errEl.style.display = 'block'; }
        } finally {
            sendBtn.disabled = false;
            input?.focus();
        }
    }

    sendBtn?.addEventListener('click', doSend);
    input?.addEventListener('keydown', e => { if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); doSend(); } });

    // ── Poll ─────────────────────────────────────────────────
    let lastCount = {{ $messages->count() }};
    setInterval(async () => {
        try {
            const res  = await fetch(`{{ url('user/live-chat') }}/${chatId}/messages`, {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrf }
            });
            const data = await res.json();
            if (data.messages && data.messages.length !== lastCount) {
                lastCount = data.messages.length;
                msgBox.innerHTML = '';
                if (!lastCount) {
                    const empty = document.createElement('div');
                    empty.id = 'ulc-empty'; empty.className = 'ulc-empty-state';
                    empty.innerHTML = `<span>{{ __('translate.Start a conversation') }}...</span>`;
                    msgBox.appendChild(empty);
                } else {
                    data.messages.forEach(m => msgBox.appendChild(buildBubble(m)));
                }
                msgBox.scrollTop = msgBox.scrollHeight;
            }
        } catch (e) {}
    }, 4000);
    @endif
})();
@endif
</script>
@endsection
