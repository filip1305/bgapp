@extends('bgapp')

@section('content')

        @if (count($boardgames) > 0)
        <div>
            <div class="center">
                <h3>Boardgames</h3>
            </div>

            <div class="right">
                <a href="/boardgame/add" class="button">Add new boardgame</a>
            </div>

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
                                <td>{{ $boardgame->name }} ({{ $boardgame->yearpublished }})</td>
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