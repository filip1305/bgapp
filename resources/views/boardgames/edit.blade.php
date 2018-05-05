@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/boardgames/">Boardgames</a></li>
        <li class="breadcrumb-item active">Edit boardgame</li>
    </ol>

    <div class="text-center">

        <div class="text-center">
            <h3>Edit boardgame</h3>
        </div>

        <form action="/boardgame/edit/{{$boardgame->id}}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div class="form-group">
                <label>Name</label>
                <div>
                    <input type="text" name="name" value="{{$boardgame->name}}" style="width:400px;">
                </div>
            </div>

            <div class="form-group">
                <label>BoardGameGeek Link</label>
                <div>
                    <input type="text" name="bgg_link" value="{{$boardgame->bgg_link}}" style="width:400px;">
                </div>
            </div>

            <button type="submit" class="btn btn-default">Save</button>
        </form>
    </div>
@stop