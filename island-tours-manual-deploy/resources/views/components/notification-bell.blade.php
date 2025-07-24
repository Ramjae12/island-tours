@php
    $notifications = Auth::user()->notifications()->latest()->take(10)->get();
    $unread = Auth::user()->unreadNotifications->count();
@endphp
<div class="notification-bell" style="position:relative;display:inline-block;">
    <button id="notif-bell-btn" style="background:none;border:none;cursor:pointer;position:relative;">
        <i class="fas fa-bell fa-lg"></i>
        @if($unread > 0)
            <span id="notif-bell-count" style="position:absolute;top:-5px;right:-5px;background:red;color:white;border-radius:50%;padding:2px 6px;font-size:10px;">{{ $unread }}</span>
        @endif
    </button>
    <div class="notification-dropdown" style="display:none;position:absolute;right:0;top:30px;background:white;box-shadow:0 2px 8px rgba(0,0,0,0.15);width:320px;z-index:1000;">
        <div style="max-height:300px;overflow-y:auto;">
            @forelse($notifications as $notification)
                <div style="padding:10px 15px;border-bottom:1px solid #eee;">
                    <div>{{ $notification->data['message'] ?? '' }}</div>
                    <div style="font-size:11px;color:#888;">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
            @empty
                <div style="padding:10px 15px;">No notifications.</div>
            @endforelse
        </div>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var bellWrapper = document.querySelector('.notification-bell');
        if (!bellWrapper) return;
        var bell = bellWrapper.querySelector('#notif-bell-btn');
        var dropdown = bellWrapper.querySelector('.notification-dropdown');
        var count = bellWrapper.querySelector('#notif-bell-count');
        if (bell && dropdown) {
            bell.addEventListener('click', function(e) {
                e.stopPropagation();
                dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                // Mark notifications as read when opening dropdown
                if (dropdown.style.display === 'block' && count) {
                    var csrf = document.querySelector('meta[name="csrf-token"]');
                    var token = csrf ? csrf.getAttribute('content') : '';
                    fetch('/notifications/mark-read', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': token,
                            'Accept': 'application/json',
                        },
                        credentials: 'same-origin',
                    }).then(r => {
                        if (r.ok) count.style.display = 'none';
                    });
                }
            });
            document.addEventListener('click', function() {
                dropdown.style.display = 'none';
            });
        }
    });
</script>
<style>
.notification-bell { margin-right: 24px; }
.notification-dropdown { border-radius: 8px; }
</style>
