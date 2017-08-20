@extends('bgapp')

@section('content')

    <ul class="breadcrumbs">
        <li class="last"><a href="" onclick="return false">Expansions</a></li>
    </ul>

    <div>
        <div class="center">
            <h3>Expansions</h3>
        </div>

        <div class="right">
            <a href="/expansion/add" class="button">Add new expansion</a>
            @if ($admin == 1)
                <a href="/expansion/refresh" class="button">Refresh BGG data</a>
            @endif
            
            <form action="/expansions" method="GET" class="form-horizontal">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" name="search" placeholder="Search..." value="{{$search}}">
                    <span class="input-group-btn">
                        <button class="btn btn-default-sm" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    @if (count($expansions) > 0)
        <div>
            <div>
                <table class="striped">

                    <thead>
                        <th></th>
                        <th>Name</th>
                        <th>Boardgames</th>
                        <th>Players</th>
                        <th>Playing time [minutes]</th>
                        <th>BGG link</th>
                        <th>&nbsp;</th>
                    </thead>

                    <tbody>
                        @foreach ($expansions as $expansion)
                            <tr>
                                <td class="center"><img style="max-height: 50px; width: auto; " src="{{$expansion->thumbnail}}" /></td>
                                <td>
                                    <a href="/expansion/view/{{ $expansion->id }}">{{ $expansion->name }} ({{ $expansion->yearpublished }})</a>
                                </td>
                                <td>
                                    @foreach ($expansion->boardgames as $boardgame)
                                        <a href="/boardgame/view/{{ $boardgame->id }}">{{ $boardgame->name }} ({{ $boardgame->yearpublished }})</a>&nbsp;
                                    @endforeach
                                </td>
                                <td>{{ $expansion->minplayers }} - {{ $expansion->maxplayers }}</td>
                                <td>{{ $expansion->minplaytime }} - {{ $expansion->maxplaytime }}</td>
                                <td>
                                    @if (!empty($expansion->bgg_link))
                                        <a href="{{ $expansion->bgg_link }}" target="_blank">BGG link</a>
                                    @endif
                                </td>
                                <td><a href="/expansion/edit/{{ $expansion->id }}">Edit</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
@stop