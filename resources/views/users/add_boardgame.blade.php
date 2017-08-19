@extends('bgapp')

@section('content')
    <ul class="breadcrumbs">
        <li><a href="/users/">Users</a></li>
        <li><a href="/user/view/{{ $user->id }}">{{ $user->name }}</a></li>
        <li class="last"><a href="" onclick="return false">Add new boardgame to collection</a></li>
    </ul>

    <div class="center">

        <div class="center">
            <h3>Add new boardgame to collection</h3>
        </div>
        
        <form action="/user/boardgame/add" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div>
                <label>Boardgame</label>
                <div>
                    <select name="boardgame" style="width:350px;">
                        @foreach ($boardgames as $boardgame)
                            <option value="{{ $boardgame->id }}">{{ $boardgame->name }}</option>
                        @endforeach
                    </select>
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