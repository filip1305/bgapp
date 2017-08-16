@extends('bgapp')

@section('content')
    <ul class="breadcrumbs">
        <li><a href="/expansions/">Expansions</a></li>
        <li class="last"><a href="" onclick="return false">Create new expansion</a></li>
    </ul>

    <div class="center">

        <div class="center">
            <h3>Create new expansion</h3>
        </div>
        
        <form action="/expansion/add" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div>
                <label>Name</label>
                <div>
                    <input type="text" name="name" style="width:350px;">
                </div>

                <label>Boardgames</label>
                <div>
                    <select name="boardgames[]" multiple="multiple" style="width:350px;">
                        @foreach ($boardgames as $boardgame)
                            <option value="{{ $boardgame->id }}">{{ $boardgame->name }}</option>
                        @endforeach
                    </select>
                </div>

                <label>BGG Link</label>
                <div>
                    <input type="text" name="bgg_link" style="width:350px;">
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