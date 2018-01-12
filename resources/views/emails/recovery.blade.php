<p>Hello {{ $data['name'] }},</p>
<p>Please click <a href="{{ URL::to('auth/recover/' . $token) }}">here</a> to reset your password.</p>
<p>Best regards,</p>
<p>IDNA Boardgame App Team</p>