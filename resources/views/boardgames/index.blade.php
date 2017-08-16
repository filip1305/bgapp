@extends('bgapp')

@section('content')

    <ul class="breadcrumbs">
        <li class="last"><a href="" onclick="return false">Boardgames</a></li>
    </ul>

    <div>
        <div class="center">
            <h3>Boardgames</h3>
        </div>

        <div class="right">
            <form action="/boardgames" method="GET" class="form-horizontal">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" name="search" placeholder="Search..." value="{{$search}}">
                    <span class="input-group-btn">
                        <button class="btn btn-default-sm" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
            <a href="/boardgame/add" class="button">Add new boardgame</a>
            <a href="/boardgame/refresh" class="button">Refresh BGG data</a>
        </div>
    </div>

    @if (count($boardgames) > 0)
        <div>
            <div>
                <table class="striped">

                    <thead>
                        <th>BGG Rank</th>
                        <th></th>
                        <th>Name</th>
                        <th>Players</th>
                        <th>Playing time [minutes]</th>
                        <th>BGG link</th>
                        <th>&nbsp;</th>
                    </thead>

                    <tbody>
                        @foreach ($boardgames as $boardgame)
                            <tr>
                                <td>{{ $boardgame->rank }}</td>
                                <td class="center"><img style="max-height: 50px; width: auto; " src="{{$boardgame->thumbnail}}" /></td>
                                <td>
                                    <a href="/boardgame/view/{{ $boardgame->id }}">{{ $boardgame->name }} ({{ $boardgame->yearpublished }})</a>
                                </td>
                                <td>{{ $boardgame->minplayers }} - {{ $boardgame->maxplayers }}</td>
                                <td>{{ $boardgame->minplaytime }} - {{ $boardgame->maxplaytime }}</td>
                                <td>
                                    @if (!empty($boardgame->bgg_link))
                                        <a href="{{ $boardgame->bgg_link }}" target="_blank">BGG link</a>
                                    @endif
                                </td>
                                <td><a href="/boardgame/edit/{{ $boardgame->id }}">Edit</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@stop