@extends('bgapp')

@section('content')
    <ul class="breadcrumbs">
        <li><a href="/boardgames/">Boardgames</a></li>
        <li>Edit boardgame</li>
    </ul>

    <div class="center">

        <div class="center">
            <h3>Edit boardgame</h3>
        </div>

        <form action="/boardgame/edit/{{$boardgame->id}}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div>
                <label>Name</label>

                <div>
                    <input type="text" name="name" value="{{$boardgame->name}}">
                </div>

                <label>BGG Link</label>

                <div>
                    <input type="text" name="bgg_link" value="{{$boardgame->bgg_link}}">
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