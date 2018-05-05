@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/users/">Users</a></li>
        <li class="breadcrumb-item"><a href="/user/view/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a></li>
        <li class="breadcrumb-item active">Change password</li>
    </ol>

    <div class="text-center">

        <div class="text-center">
            <h3>Change password</h3>
        </div>
        
        <form action="/user/password" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <label>Old password</label>
                <div>
                    <input type="password" name="old_password">
                </div>
            </div>

            <div class="form-group">
                <label>New password</label>
                <div>
                    <input type="password" name="new_password">
                </div>
            </div>

            <div class="form-group">
                <label>Confirm password</label>
                <div>
                    <input type="password" name="password_confirmation">
                </div>
            </div>

            <button type="submit" class="btn btn-default">Save</button>
        </form>
    </div>
@stop