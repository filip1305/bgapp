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
            <a href="/boardgame/add" class="button">Add new boardgame</a>
            @if ($admin == 1)
                <a href="/boardgame/refresh" class="button">Refresh BGG data</a>
            @endif

            <form action="/boardgames" method="GET" class="form-horizontal">
                <div class="input-group custom-search-form">
                    Name: <input type="text" class="form-control" name="name" placeholder="Name..." value="{{ $filters['name'] }}">
                    Category:
                    <select name="category">
                        @if ($filters['category'] == 0)
                            <option value="0" selected="selected">- All -</option>
                        @else
                            <option value="0">- All -</option>
                        @endif
                        @foreach ($categories as $category)
                            @if ($category->id == $filters['category'])
                                <option value="{{ $category->id }}" selected="selected">{{ $category->name }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    Publisher:
                    <select name="publisher">
                        @if ($filters['publisher'] == 0)
                            <option value="0" selected="selected">- All -</option>
                        @else
                            <option value="0">- All -</option>
                        @endif
                        @foreach ($publishers as $publisher)
                            @if ($publisher->id == $filters['publisher'])
                                <option value="{{ $publisher->id }}" selected="selected">{{ $publisher->name }}</option>
                            @else
                                <option value="{{ $publisher->id }}">{{ $publisher->name }}</option>
                            @endif
                        @endforeach
                    </select>
                    Type:
                    <select name="type">
                        @if ($filters['type'] == 0)
                            <option value="0" selected="selected">- All -</option>
                            <option value="1">Only mine</option>
                        @else
                            <option value="0">- All -</option>
                            <option value="1" selected="selected">Only mine</option>
                        @endif
                    </select>
                    Players: <input type="text" class="form-control" name="players" placeholder="#" value="{{ $filters['players'] }}" style="width:50px;">
                    Year: <input type="text" class="form-control" name="year" placeholder="####" value="{{ $filters['year'] }}" style="width:50px;">
                    <span class="input-group-btn">
                        <button class="btn btn-default-sm" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                        <a href="/boardgames" class="button">Clear</a>
                    </span>
                </div>
            </form>
        </div>
    </div>

    @if (count($boardgames) > 0)
        <div>
            <div>
                <table class="striped" id="data">

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
                                <td>
                                    @if ($boardgame->rank == 0)
                                        <span style="display:none">999999</span>0
                                    @else
                                        {{ $boardgame->rank }}
                                    @endif
                                </td>
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
    @else
        <div class="center">
            No data
        </div>
    @endif

    <script type="text/javascript">

        $(document).ready(function() {
            $('#data').DataTable({
                searching: false,
                columnDefs: [
                    { orderable: false, targets: 1 },
                    { orderable: false, targets: 5 },
                    { orderable: false, targets: 6 }
                ]
            });
        });

    </script>
@stop