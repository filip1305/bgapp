@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/users/">Users</a></li>
        <li class="breadcrumb-item"><a href="/user/view/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a></li>
        <li class="breadcrumb-item active">Add boardgame to collection</li>
    </ol>

    <div class="text-center">

        <div class="text-center">
            <h3>Add boardgame to collection</h3>
        </div>
        
        <form action="/user/boardgame/add" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <label>Boardgame</label>
                <div>
                    <select name="boardgame" style="width:400px;">
                        @foreach ($boardgames as $boardgame)
                            <option value="{{ $boardgame->id }}">{{ $boardgame->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-default">Save</button>
        </form>
    </div>
@stop