@extends('bgapp')

@section('content')
    <ul class="breadcrumbs">
        <li><a href="/users/">Users</a></li>
        <li><a href="/user/view/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a></li>
        <li class="last"><a href="" onclick="return false">Change password</a></li>
    </ul>

    <div class="center">

        <div class="center">
            <h3>Change password</h3>
        </div>
        
        <form action="/user/password" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div>
                <label>Old password</label>
                <div>
                    <input type="password" name="old_password">
                </div>
            </div>

            <div>
                <label>New Password</label>
                <div>
                    <input type="password" name="new_password">
                </div>
            </div>

            <div>
                <label>Confirm Password</label>
                <div>
                    <input type="password" name="password_confirmation">
                </div>
            </div>

            <div>
                <div>
                    <button type="submit">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
@stop