@extends('auth')

@section('content')

    <div class="text-center">

        <div class="text-center">
            <h3>Forgot password</h3>
        </div>
        
        <form action="/auth/identify" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <label>Email</label>
                <div>
                    <input type="email" name="email" value="{{ old('email') }}" style="width:200px;">
                </div>
            </div>

            <button type="submit" class="btn btn-default" style="width:200px;">Submit</button>            
        </form>
    </div>
</div>
@stop