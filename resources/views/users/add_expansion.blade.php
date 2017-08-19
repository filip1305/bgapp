@extends('bgapp')

@section('content')
    <ul class="breadcrumbs">
        <li><a href="/users/">Users</a></li>
        <li><a href="/user/view/{{ $user->id }}">{{ $user->name }}</a></li>
        <li class="last"><a href="" onclick="return false">Add new expansion to collection</a></li>
    </ul>

    <div class="center">

        <div class="center">
            <h3>Add new expansion to collection</h3>
        </div>
        
        <form action="/user/expansion/add" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div>
                <label>Expansion</label>
                <div>
                    <select name="expansion" style="width:350px;">
                        @foreach ($expansions as $expansion)
                            <option value="{{ $expansion->id }}">{{ $expansion->name }}</option>
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