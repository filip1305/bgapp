@extends('auth')

@section('content')

    <div class="text-center">

        <div class="text-center">
            <h3>Reset password</h3>
        </div>
        
        <form action="/auth/recover" method="POST">
            {{ csrf_field() }}

            <input type="hidden" name="code" value="{{ $code }}">

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

            <button type="submit" class="btn btn-default" style="width:200px;">Submit</button>            
        </form>
    </div>
</div>
@stop