@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/users/">Users</a></li>
        <li class="breadcrumb-item"><a href="/user/view/{{ Auth::user()->id }}">{{ Auth::user()->name }}</a></li>
        <li class="breadcrumb-item active">Add expansion to collection</li>
    </ol>

    <div class="text-center">

        <div class="text-center">
            <h3>Add expansion to collection</h3>
        </div>
        
        <form action="/user/expansion/add" method="POST">
            {{ csrf_field() }}

            <div class="form-group">
                <label>Expansion</label>
                <div>
                    <select name="expansion" style="width:400px;">
                        @foreach ($expansions as $expansion)
                            <option value="{{ $expansion->id }}">{{ $expansion->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <button type="submit" class="btn btn-default">Save</button>
        </form>
    </div>
@stop