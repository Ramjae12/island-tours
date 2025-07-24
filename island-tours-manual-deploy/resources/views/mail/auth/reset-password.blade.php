@component('mail::message')
<div style="text-align:center; margin-bottom: 24px;">
    <img src="{{ $logo }}" alt="Island Tours Logo" style="width:80px; height:80px; border-radius:50%; box-shadow:0 2px 8px #0002; margin-bottom: 8px;">
    <h1 style="color:#2563eb; margin:0;">Island Tours</h1>
</div>

# Reset Your Password

You are receiving this email because we received a password reset request for your account.

@component('mail::button', ['url' => $url])
Reset Password
@endcomponent

This password reset link will expire in 60 minutes.

If you did not request a password reset, no further action is required.

Thanks,<br>
TIEZA Island Tours
@endcomponent
