@if(isset($general_setting->live_chat_status) && $general_setting->live_chat_status == 1)
<script src="https://unpkg.com/@lottiefiles/dotlottie-wc@0.9.10/dist/dotlottie-wc.js" type="module"></script>
<style>
    /* Move scroll-to-top button to the left so it doesn't overlap the chat widget */
    .scroll__top {
        right: auto !important;
        left: 28px !important;
    }
    @media only screen and (min-width: 992px) and (max-width: 1199px) {
        .scroll__top { left: 25px !important; right: auto !important; }
    }
    @media only screen and (min-width: 768px) and (max-width: 991px) {
        .scroll__top { left: 30px !important; right: auto !important; }
    }
    @media (max-width: 575px) {
        .scroll__top { left: 15px !important; right: auto !important; }
    }

    #live-chat-btn {
        position: fixed;
        bottom: 10px;
        right: 10px;
        z-index: 9999;
        width: 100px;
        height: 100px;
        background: transparent;
        border: none;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: transform 0.2s;
        padding: 0;
    }
    #live-chat-btn:hover { transform: scale(1.05); }
    #live-chat-badge {
        position: absolute;
        top: 15px;
        right: 15px;
        background: var(--tg-theme-secondary, #e53935);
        color: #fff;
        font-size: 11px;
        font-weight: 700;
        border-radius: 50%;
        min-width: 20px;
        height: 20px;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 0 4px;
    }
    #live-chat-window {
        position: fixed;
        bottom: 110px;
        right: 20px;
        z-index: 9999;
        width: 340px;
        max-height: 480px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 40px rgba(0,0,0,0.18);
        display: none;
        flex-direction: column;
        overflow: hidden;
        font-family: inherit;
    }

    #live-chat-hint {
        position: fixed;
        right: 105px;
        bottom: 35px;
        z-index: 9998;
        background: #fff;
        color: #212529;
        border-radius: 16px;
        padding: 10px 14px;
        min-width: 170px;
        box-shadow: 0 8px 28px rgba(0, 0, 0, 0.2);
        display: flex;
        flex-direction: column;
        gap: 3px;
        line-height: 1.3;
        cursor: pointer;
    }

    #live-chat-hint small {
        font-size: 12px;
        color: #6c757d;
        font-weight: 500;
    }

    #live-chat-hint strong {
        font-size: 15px;
        font-weight: 700;
        color: #222;
    }

    #live-chat-hint-close {
        position: absolute;
        top: -8px;
        right: -8px;
        width: 28px;
        height: 28px;
        border-radius: 50%;
        border: none;
        background: #5f5f5f;
        color: #fff;
        font-size: 18px;
        line-height: 1;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 0;
    }

    #live-chat-hint-close:hover {
        background: #474747;
    }

    @media (max-width: 767px) {
        #live-chat-btn {
            width: 80px;
            height: 80px;
            right: 5px;
            bottom: 5px;
        }

        #live-chat-window {
            bottom: 90px;
            right: 10px;
            width: calc(100% - 20px);
        }

        #live-chat-hint {
            right: 80px;
            bottom: 25px;
            min-width: 140px;
            padding: 8px 10px;
        }

        #live-chat-btn,
        #live-chat-window,
        #live-chat-hint {
            transition: opacity 0.18s ease, visibility 0.18s ease, transform 0.18s ease;
        }

        #live-chat-hint strong {
            font-size: 14px;
        }

        #live-chat-btn.lc-hidden-by-booking-bar,
        #live-chat-window.lc-hidden-by-booking-bar,
        #live-chat-hint.lc-hidden-by-booking-bar {
            opacity: 0 !important;
            visibility: hidden !important;
            pointer-events: none !important;
            transform: translateY(18px);
        }
    }

    #live-chat-window.open { display: flex; }
    .lc-header {
        background: var(--tg-theme-primary, #c62828) !important;
        color: #fff !important;
        padding: 14px 18px !important;
        font-weight: 700 !important;
        font-size: 14px !important;
    }
    .lc-avatar {
        width: 36px !important; height: 36px !important;
        background: rgba(255,255,255,0.25) !important;
        border-radius: 50% !important;
        display: flex !important; align-items: center !important; justify-content: center !important;
        flex-shrink: 0 !important;
    }
    .lc-close-btn {
        background: none; border: none; color: #fff; cursor: pointer;
        font-size: 22px; line-height: 1; padding: 0;
    }
    #lc-messages {
        flex: 1;
        overflow-y: auto;
        padding: 14px 14px 6px;
        display: flex;
        flex-direction: column;
        gap: 10px;
        min-height: 200px;
        max-height: 300px;
        background: #f8f9fa;
    }
    .lc-msg {
        max-width: 80%;
        padding: 9px 13px;
        border-radius: 14px;
        font-size: 13.5px;
        line-height: 1.5;
        word-break: break-word;
    }
    .lc-msg.user {
        background: var(--tg-theme-primary, #c62828);
        color: #fff;
        align-self: flex-end;
        border-bottom-right-radius: 4px;
    }
    .lc-msg.admin {
        background: #fff;
        color: #222;
        align-self: flex-start;
        border-bottom-left-radius: 4px;
        box-shadow: 0 1px 4px rgba(0,0,0,0.08);
    }
    .lc-msg-time {
        font-size: 10px;
        opacity: 0.65;
        display: block;
        margin-top: 3px;
        text-align: right;
    }
    .lc-msg.admin .lc-msg-time { text-align: left; }
    .lc-empty {
        text-align: center;
        color: #aaa;
        font-size: 13px;
        padding: 30px 0;
    }
    #lc-input-area {
        padding: 10px 12px;
        border-top: 1px solid #eee;
        display: flex;
        gap: 8px;
        background: #fff;
    }
    #lc-input-area input {
        flex: 1;
        border: 1px solid #ddd;
        border-radius: 20px;
        padding: 8px 14px;
        font-size: 13.5px;
        outline: none;
        transition: border-color 0.2s;
    }
    #lc-input-area input:focus { border-color: var(--tg-theme-primary, #c62828); }
    #lc-send-btn {
        background: var(--tg-theme-primary, #c62828);
        color: #fff;
        border: none;
        border-radius: 50%;
        width: 36px; height: 36px;
        cursor: pointer;
        display: flex; align-items: center; justify-content: center;
        flex-shrink: 0;
        transition: background 0.2s;
    }
    #lc-send-btn:hover { background: var(--tg-theme-secondary, #e53935); }
    .lc-status-bar {
        font-size: 11px;
        padding: 4px 14px;
        background: #fff8f8;
        color: var(--tg-theme-primary, #c62828);
        text-align: center;
        border-top: 1px solid #fde;
        display: none;
    }
    .lc-status-bar.closed { display: block; }
    /* Guest login prompt */
    #lc-guest-prompt {
        padding: 24px 20px;
        text-align: center;
        background: #f8f9fa;
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        gap: 12px;
    }
    #lc-guest-prompt p {
        color: #555;
        font-size: 14px;
        margin: 0;
        line-height: 1.6;
    }
    #lc-guest-prompt a {
        display: inline-block;
        background: var(--tg-theme-primary, #c62828);
        color: #fff;
        padding: 9px 24px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        text-decoration: none;
        transition: background 0.2s;
    }
    #lc-guest-prompt a:hover { background: var(--tg-theme-secondary, #e53935); color: #fff; }
</style>

<button id="live-chat-btn" title="{{ __('translate.Live Chat') }}">
    <span id="live-chat-badge"></span>
    <dotlottie-wc src="https://lottie.host/6892674f-5f92-4f67-b39c-f07f46050f69/OwVUi4Cl4e.lottie" style="width: 100%; height: 100%" autoplay loop></dotlottie-wc>
</button>

<div id="live-chat-hint" role="button" tabindex="0" aria-label="{{ __('translate.Live Chat') }}">
    <button type="button" id="live-chat-hint-close" aria-label="Close">&times;</button>
    <small>{{ __('translate.Live Support') }}</small>
    <strong>{{ __('translate.We reply as fast as we can') }}</strong>
</div>

<div id="live-chat-window">
    <div class="lc-header" style="display:flex!important;flex-direction:row!important;align-items:center!important;justify-content:space-between!important;flex-wrap:nowrap!important;gap:8px">
        <div style="display:flex!important;flex-direction:row!important;align-items:center!important;gap:10px;flex:1;min-width:0">
            <div class="lc-avatar" style="flex-shrink:0">
                <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
            </div>
            <div style="flex:1;min-width:0;overflow:hidden">
                <div style="font-size:14px;font-weight:700;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ __('translate.Live Support') }}</div>
                <div style="font-size:11px;font-weight:400;opacity:0.85;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">{{ __('translate.We reply as fast as we can') }}</div>
            </div>
        </div>
        <button class="lc-close-btn" id="lc-close" style="flex-shrink:0">&times;</button>
    </div>

    @auth('web')
    {{-- Logged-in: full chat interface --}}
    <div id="lc-messages">
        <div class="lc-empty" id="lc-empty-msg">{{ __('translate.Start a conversation') }}...</div>
    </div>
    <div class="lc-status-bar" id="lc-status-bar">{{ __('translate.This conversation is closed') }}</div>
    <div id="lc-input-area">
        <input type="text" id="lc-text-input" placeholder="{{ __('translate.Type a message') }}..." maxlength="2000" autocomplete="off">
        <button id="lc-send-btn" title="{{ __('translate.Send') }}">
            <svg width="18" height="18" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"/>
            </svg>
        </button>
    </div>
    @else
    {{-- Guest: login prompt --}}
    <div id="lc-guest-prompt">
        <svg width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="var(--tg-theme-primary, #c62828)" stroke-width="1.3">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
        </svg>
        <p>{{ __('translate.Please login to start a live chat with our support team') }}</p>
        <a href="{{ route('user.login') }}">{{ __('translate.Login to Chat') }}</a>
    </div>
    @endauth
</div>

<script>
(function() {
    var btn      = document.getElementById('live-chat-btn');
    var win      = document.getElementById('live-chat-window');
    var hint     = document.getElementById('live-chat-hint');
    var hintCloseBtn = document.getElementById('live-chat-hint-close');
    var closeBtn = document.getElementById('lc-close');
    var isOpen   = false;
    var bookingBarObserver = null;
    var hintReopenTimer = null;
    var hintDismissed = false;

    function isTourServicePage() {
        if (document.querySelector('main.tg-service-detail-page')) {
            return true;
        }

        return /\/tour-booking\/service(\/|$)/.test(window.location.pathname);
    }

    function isMobileViewport() {
        return window.matchMedia('(max-width: 767.98px)').matches;
    }

    function setChatHiddenByBookingBar(hidden) {
        btn.classList.toggle('lc-hidden-by-booking-bar', hidden);
        win.classList.toggle('lc-hidden-by-booking-bar', hidden);
        if (hint) {
            hint.classList.toggle('lc-hidden-by-booking-bar', hidden);
        }
    }

    function showHintBubble() {
        if (!hint || isOpen || hintDismissed) {
            return;
        }

        hint.style.display = 'flex';
    }

    function hideHintBubble() {
        if (!hint) {
            return;
        }

        hint.style.display = 'none';
    }

    function scheduleHintReopen() {
        if (!hint) {
            return;
        }

        if (hintReopenTimer) {
            clearTimeout(hintReopenTimer);
        }

        hintReopenTimer = setTimeout(function() {
            hintDismissed = false;
            showHintBubble();
        }, 10000);
    }

    function setupBookingBarDrivenChatVisibility() {
        if (!isTourServicePage()) {
            return;
        }

        var bookingBar = document.querySelector('.tg-mobile-sticky-booking-bar');
        if (!bookingBar) {
            return;
        }

        function syncChatVisibilityWithBookingBar() {
            var shouldHide = isMobileViewport() && bookingBar.classList.contains('show');
            setChatHiddenByBookingBar(shouldHide);
        }

        syncChatVisibilityWithBookingBar();

        bookingBarObserver = new MutationObserver(syncChatVisibilityWithBookingBar);
        bookingBarObserver.observe(bookingBar, {
            attributes: true,
            attributeFilter: ['class']
        });

        window.addEventListener('resize', function() {
            if (!isMobileViewport()) {
                setChatHiddenByBookingBar(false);
                return;
            }

            syncChatVisibilityWithBookingBar();
        });

        window.addEventListener('scroll', syncChatVisibilityWithBookingBar, { passive: true });
    }

    function toggleWindow() {
        isOpen = !isOpen;
        win.classList.toggle('open', isOpen);
        if (isOpen) {
            hideHintBubble();
            @auth('web')
            badge.style.display = 'none';
            if (!chatId) initChat();
            else pollMessages();
            startPolling();
            setTimeout(function(){ input && input.focus(); }, 150);
            @endauth
        } else {
            stopPolling();
            if (!hintDismissed) {
                showHintBubble();
            }
        }
    }

    btn.addEventListener('click', toggleWindow);
    closeBtn.addEventListener('click', toggleWindow);

    if (hint && hintCloseBtn) {
        hintCloseBtn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            hintDismissed = true;
            hideHintBubble();
            scheduleHintReopen();
        });

        hint.addEventListener('click', function() {
            if (!isOpen) {
                toggleWindow();
            }
        });

        hint.addEventListener('keydown', function(e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                if (!isOpen) {
                    toggleWindow();
                }
            }
        });
    }

    showHintBubble();
    setupBookingBarDrivenChatVisibility();

    @auth('web')
    var msgBox    = document.getElementById('lc-messages');
    var emptyMsg  = document.getElementById('lc-empty-msg');
    var input     = document.getElementById('lc-text-input');
    var sendBtn   = document.getElementById('lc-send-btn');
    var badge     = document.getElementById('live-chat-badge');
    var statusBar = document.getElementById('lc-status-bar');

    var chatId       = null;
    var lastMsgCount = 0;
    var pollInterval = null;
    var isClosed     = false;
    var csrfToken    = document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '';

    async function initChat() {
        try {
            var res  = await fetch('{{ route("user.live-chat.start") }}', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
            });
            var data = await res.json();
            chatId   = data.chat_id;
            isClosed = data.status === 'closed';
            updateStatusBar();
            pollMessages();
        } catch(e) { console.error(e); }
    }

    async function pollMessages() {
        if (!chatId) return;
        try {
            var res  = await fetch('{{ url("user/live-chat") }}/' + chatId + '/messages', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            var data = await res.json();
            renderMessages(data.messages);
        } catch(e) {}
    }

    function renderMessages(messages) {
        if (!messages || messages.length === 0) {
            emptyMsg.style.display = 'block';
            return;
        }
        emptyMsg.style.display = 'none';
        if (messages.length === lastMsgCount) return;
        lastMsgCount = messages.length;
        msgBox.innerHTML = '';
        messages.forEach(function(m) {
            var div = document.createElement('div');
            div.className = 'lc-msg ' + m.sender_type;
            div.innerHTML = escapeHtml(m.message) + '<span class="lc-msg-time">' + m.time + '</span>';
            msgBox.appendChild(div);
        });
        msgBox.scrollTop = msgBox.scrollHeight;
    }

    function escapeHtml(t) {
        var d = document.createElement('div');
        d.appendChild(document.createTextNode(t));
        return d.innerHTML;
    }

    async function sendMessage() {
        var msg = input.value.trim();
        if (!msg || !chatId || isClosed) return;
        input.value    = '';
        input.disabled = true;
        sendBtn.disabled = true;
        try {
            await fetch('{{ url("user/live-chat") }}/' + chatId + '/send', {
                method: 'POST',
                headers: { 'X-CSRF-TOKEN': csrfToken, 'Content-Type': 'application/json', 'Accept': 'application/json' },
                body: JSON.stringify({ message: msg }),
            });
            await pollMessages();
        } catch(e) {} finally {
            input.disabled   = false;
            sendBtn.disabled = false;
            input.focus();
        }
    }

    sendBtn.addEventListener('click', sendMessage);
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendMessage(); }
    });

    function startPolling() {
        stopPolling();
        pollInterval = setInterval(pollMessages, 4000);
    }
    function stopPolling() {
        if (pollInterval) { clearInterval(pollInterval); pollInterval = null; }
    }

    function updateStatusBar() {
        if (isClosed) {
            statusBar.classList.add('closed');
            input.disabled    = true;
            sendBtn.disabled  = true;
            input.placeholder = '{{ __("translate.Chat is closed") }}';
        } else {
            statusBar.classList.remove('closed');
            input.disabled    = false;
            sendBtn.disabled  = false;
        }
    }

    // Poll unread count in background
    setInterval(async function() {
        if (isOpen) return;
        try {
            var res  = await fetch('{{ route("user.live-chat.unread") }}', {
                headers: { 'Accept': 'application/json', 'X-CSRF-TOKEN': csrfToken }
            });
            var data = await res.json();
            if (data.unread > 0) {
                badge.textContent   = data.unread > 9 ? '9+' : data.unread;
                badge.style.display = 'flex';
            } else {
                badge.style.display = 'none';
            }
        } catch(e) {}
    }, 8000);
    @endauth
})();
</script>
@endif
