@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Boardgames</li>
    </ol>

    <div class="text-center">
        <h2>Boardgames</h2>
    </div>
        
    <div class="text-right">
        <div class="form-group">
            <a href="/boardgame/add" class="btn btn-default">Add new boardgame</a>
            @if ($admin == 1)
                <a href="/boardgame/refresh" class="btn btn-default">Refresh BGG data</a>
            @endif
        </div>            

        <form action="/boardgames" method="GET" class="form-inline">
            <div class="form-group">
                Name:
                <input type="text" class="form-control" name="name" placeholder="Name..." value="{{ $filters['name'] }}">
            </div>

            <div class="form-group">
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
            </div>

            <div class="form-group">
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
            </div>

            <div class="form-group">
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
            </div>

            <div class="form-group">
                Players:
                <input type="text" class="form-control" name="players" placeholder="#" value="{{ $filters['players'] }}" style="width:50px;">
            </div>

            <div class="form-group">
                Year:
                <input type="text" class="form-control" name="year" placeholder="####" value="{{ $filters['year'] }}" style="width:60px;">
            </div>

            <div class="form-group">
                <button class="btn btn-default" type="submit"><i class="fa fa-search fa-fw"></i></button>
                <a href="/boardgames" class="btn btn-default">Clear</a>
            </div>
        </form>
    </div>

    @if (count($boardgames) > 0)
        <table class="hover" id="data">

            <thead>
                <th width="70">Avg Rating</th>
                <th width="70">My Rating</th>
                <th width="100"></th>
                <th>Name</th>
                <th width="80">Players</th>
                <th width="200">Playing time [minutes]</th>
                <th width="100">&nbsp;</th>
            </thead>

            <tbody>
                @foreach ($boardgames as $boardgame)
                    <tr>
                        <td>
                            @if ($boardgame->avgRating())
                                {{ round($boardgame->avgRating(), 2) }}
                            @else
                                <span style="display:none">0</span>
                            @endif
                        </td>
                        <td>
                            @if ($boardgame->myRating())
                                {{ $boardgame->myRating() }}
                            @else
                                <span style="display:none">0</span>
                            @endif
                        </td>
                        <td class="text-center"><img style="max-height: 50px; width: auto; " src="{{$boardgame->thumbnail}}" /></td>
                        <td>
                            <a href="/boardgame/view/{{ $boardgame->id }}">{{ $boardgame->name }} ({{ $boardgame->yearpublished }})</a>
                        </td>
                        <td>{{ $boardgame->minplayers }} - {{ $boardgame->maxplayers }}</td>
                        <td>{{ $boardgame->minplaytime }} - {{ $boardgame->maxplaytime }}</td>
                        <td class="text-right">
                            <div class="btn-group">
                                @if (!empty($boardgame->bgg_link))
                                    <a href="{{ $boardgame->bgg_link }}" class="btn btn-default" target="_blank"><i class="fa fa-link fa-fw"></i></a>
                                @endif
                                @if ($admin == 1)
                                    <a href="/boardgame/edit/{{ $boardgame->id }}" class="btn btn-default"><i class="fa fa-edit fa-fw"></i></a>
                                @endif
                            </div> 
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center">
            No data
        </div>
    @endif

    <script type="text/javascript">

        $(document).ready(function() {
            $('#data').DataTable({
                searching: false,
                order: [[ 0, "desc" ]],
                columnDefs: [
                    { orderable: false, targets: 2 },
                    { orderable: false, targets: 6 }
                ]
            });
        });

    </script>
@stop