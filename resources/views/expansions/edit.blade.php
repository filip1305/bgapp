@extends('bgapp')

@section('content')
    <ul class="breadcrumbs">
        <li><a href="/expansions/">Expansions</a></li>
        <li class="last"><a href="" onclick="return false">Edit expansion</a></li>
    </ul>

    <div class="center">

        <div class="center">
            <h3>Edit expansion</h3>
        </div>

        <form action="/expansion/edit/{{$expansion->id}}" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div>
                <label>Name</label>
                <div>
                    <input type="text" name="name" value="{{$expansion->name}}" style="width:350px;">
                </div>

                <label>Boardgames</label>
                <div>
                    <select name="boardgames[]" multiple="multiple" style="width:350px;">
                        @foreach ($boardgames as $boardgame)
                            @if (in_array($boardgame->id, $selected))
                                <option value="{{ $boardgame->id }}" selected="selected">{{ $boardgame->name }}</option>
                            @else
                                <option value="{{ $boardgame->id }}">{{ $boardgame->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>

                <label>BGG Link</label>
                <div>
                    <input type="text" name="bgg_link" value="{{$expansion->bgg_link}}" style="width:350px;">
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