@extends('auth')

@section('content')

    <div class="text-center">

        <div class="text-center">
            <h3>Login</h3>
        </div>
        
        <form action="/auth/register" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <label>Name</label>
                <div>
                    <input type="text" name="name" value="{{ old('name') }}" style="width:200px;">
                </div>
            </div>

            <div class="form-group">
                <label>Email</label>
                <div>
                    <input type="email" name="email" value="{{ old('email') }}" style="width:200px;">
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div>
                    <input type="password" name="password" style="width:200px;">
                </div>
            </div>

            <div class="form-group">
                <label>Confirm Password</label>
                <div>
                    <input type="password" name="password_confirmation" style="width:200px;">
                </div>
            </div>

            <div class="form-group">
                <input type="checkbox" name="remember"> Remember Me
            </div>

            <button type="submit" class="btn btn-default" style="width:200px;">Register</button>
        </form>
    </div>
</div>
@stop