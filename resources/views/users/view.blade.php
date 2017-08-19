@extends('bgapp')

@section('content')
    <ul class="breadcrumbs">
        <li><a href="/users/">Users</a></li>
        <li class="last"><a href="" onclick="return false">{{ $user->name }}</a></li>
    </ul>

    <div>
        Name: {{ $user->name }}
    <div>
    </div>
        Email: {{ $user->email }}
    </div>

    <div class="col_6">
        <h5>Boardgames</h5>

        @if ($me == 1)
            <div class="left">
                <a href="/user/boardgame/add" class="button small">Add</a>
            </div>
        @endif
        @if (count($user->boardgames))
            <table class="striped">

                <thead>
                    <th></th>
                    <th>Name</th>
                    <th>Players</th>
                    <th>Playing time [minutes]</th>
                    <th></th>
                </thead>

                <tbody>
                    @foreach ($user->boardgames as $boardgame)
                        <tr>
                            <td class="center"><img style="max-height: 50px; width: auto; " src="{{$boardgame->thumbnail}}" /></td>
                            <td>
                                <a href="/boardgame/view/{{ $boardgame->id }}">{{ $boardgame->name }} ({{ $boardgame->yearpublished }})</a>
                            </td>
                            <td>{{ $boardgame->minplayers }} - {{ $boardgame->maxplayers }}</td>
                            <td>{{ $boardgame->minplaytime }} - {{ $boardgame->maxplaytime }}</td>
                            <td>
                                @if ($me == 1)
                                    <a href="/user/boardgame/delete/{{ $boardgame->id }}" class="button" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    
    <div class="col_6">
        <h5>Expansions</h5>

        @if ($me == 1)
            <div class="left">
                <a href="/user/expansion/add" class="button small">Add</a>
            </div>
        @endif
        @if (count($user->expansions))        
            <table class="striped">

                <thead>
                    <th></th>
                    <th>Name</th>
                    <th>Players</th>
                    <th>Playing time [minutes]</th>
                    <th></th>
                </thead>

                <tbody>
                    @foreach ($user->expansions as $expansion)
                        <tr>
                            <td class="center"><img style="max-height: 50px; width: auto; " src="{{$expansion->thumbnail}}" /></td>
                            <td>
                                <a href="/expansion/view/{{ $expansion->id }}">{{ $expansion->name }} ({{ $expansion->yearpublished }})</a>
                            </td>
                            <td>{{ $expansion->minplayers }} - {{ $expansion->maxplayers }}</td>
                            <td>{{ $expansion->minplaytime }} - {{ $expansion->maxplaytime }}</td>
                            <td>
                                @if ($me == 1)
                                    <a href="/user/expansion/delete/{{ $expansion->id }}" class="button" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@stop