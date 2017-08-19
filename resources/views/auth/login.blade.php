@extends('auth')

@section('content')

    <div class="center">

        <div class="center">
            <h3>Login</h3>
        </div>
        
        <form action="/auth/login" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div>
                <label>Email</label>
                <div>
                    <input type="email" name="email" value="{{ old('email') }}">
                </div>
            </div>

            <div>
                <label>Password</label>
                <div>
                    <input type="password" name="password" id="password">
                </div>
            </div>

            <div>
                <input type="checkbox" name="remember"> Remember Me
            </div>

            <div>
                <button type="submit">Login</button>
                <a href="/auth/register">Register</a>
            </div>
        </form>
    </div>
</div>
@stop