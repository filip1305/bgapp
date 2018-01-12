<p>Hello {{ $data['name'] }},</p>
<p>Welcome to IDNA Boardgame App! Please click on the following link to confirm your account:</p>
<p><a href="{{ URL::to('auth/activate/' . $token) }}">{{ URL::to('auth/activate/' . $token) }}</a></p>
<p>Best regards,</p>
<p>IDNA Boardgame App Team</p>