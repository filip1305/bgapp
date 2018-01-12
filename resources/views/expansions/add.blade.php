@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/expansions/">Expansions</a></li>
        <li class="breadcrumb-item active">Add new expansion</li>
    </ol>    

    <div class="text-center">

        <div class="text-center">
            <h3>Add new expansion</h3>
        </div>
        
        <form action="/expansion/add" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <label>Name</label>
                <div>
                    <input type="text" name="name" style="width:400px;">
                </div>
            </div>

            <div class="form-group">
                <label>Boardgames</label>
                <div>
                    <select name="boardgames[]" multiple="multiple" style="width:400px;">
                        @foreach ($boardgames as $boardgame)
                            <option value="{{ $boardgame->id }}">{{ $boardgame->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label>BoardGameGeek Link</label>
                <div>
                    <input type="text" name="bgg_link" style="width:400px;">
                </div>
            </div>

            <button type="submit" class="btn btn-default">Save</button>
        </form>
    </div>
@stop