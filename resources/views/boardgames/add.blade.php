@extends('bgapp')

@section('content')
    <ul class="breadcrumbs">
        <li><a href="/boardgames/">Boardgames</a></li>
        <li class="last"><a href="" onclick="return false">Create new boardgame</a></li>
    </ul>

    <div class="center">

        <div class="center">
            <h3>Create new boardgame</h3>
        </div>
        
        <form action="/boardgame/add" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div>
                <label>Name</label>

                <div>
                    <input type="text" name="name">
                </div>

                <label>BGG Link</label>

                <div>
                    <input type="text" name="bgg_link">
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