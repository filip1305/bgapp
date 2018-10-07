@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/expansions/">Expansions</a></li>
        <li class="breadcrumb-item active">Edit new expansion</li>
    </ol>

    <div class="text-center">

        <div class="text-center">
            <h3>Edit expansion</h3>
        </div>

        <form action="/expansion/edit/{{$expansion->id}}" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <label>Boardgames</label>
                <div>
                    <select name="boardgames[]" multiple="multiple" style="width:400px;">
                        @foreach ($boardgames as $boardgame)
                            @if (in_array($boardgame->id, $selected))
                                <option value="{{ $boardgame->id }}" selected="selected">{{ $boardgame->name }}</option>
                            @else
                                <option value="{{ $boardgame->id }}">{{ $boardgame->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>BoardGameGeek Link</label>
                <div>
                    <input type="text" name="bgg_link" value="{{$expansion->bgg_link}}" style="width:400px;">
                </div>
            </div>

            <button type="submit" class="btn btn-default">Save</button>
        </form>
    </div>
@stop