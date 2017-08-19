@extends('auth')

@section('content')

    <div class="center">

        <div class="center">
            <h3>Login</h3>
        </div>
        
        <form action="/auth/login" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div>
                <label>Name</label>
                <div>
                    <input type="text" name="name" value="{{ old('name') }}">
                </div>
            </div>

            <div>
                <label>Email</label>
                <div>
                    <input type="email" name="email" value="{{ old('email') }}">
                </div>
            </div>

            <div>
                <label>Password</label>
                <div>
                    <input type="password" name="password">
                </div>
            </div>

            <div>
                <label>Confirm Password</label>
                <div>
                    <input type="password" name="password_confirmation">
                </div>
            </div>

            <div>
                <input type="checkbox" name="remember"> Remember Me
            </div>

            <div>
                <button type="submit">Register</button>
            </div>
        </form>
    </div>
</div>
@stop