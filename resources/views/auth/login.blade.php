@extends('auth')

@section('content')

    <div class="text-center">

        <div class="text-center">
            <h3>Login</h3>
        </div>
        
        <form action="/auth/login" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <label>Email</label>
                <div>
                    <input type="email" name="email" value="{{ old('email') }}" style="width:200px;">
                </div>
            </div>

            <div class="form-group">
                <label>Password</label>
                <div>
                    <input type="password" name="password" id="password" style="width:200px;">
                </div>
            </div>

            <div class="form-group">
                <input type="checkbox" name="remember"> Remember Me
            </div>

            <button type="submit" class="btn btn-default" style="width:200px;">Login</button>

            <h6><a href="/auth/identify">Forgot password</a></h6>
            <h6><a href="/auth/register">Create account</a></h6>
            
        </form>
    </div>
</div>
@stop