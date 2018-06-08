@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Games</li>
    </ol>

    <div class="text-center">
        <h2>Games</h2>
    </div>
        
    <div class="text-right">
        <div class="form-group">
            <a href="/game/add" class="btn btn-default">Add new game</a>
        </div>

        <form action="/games" method="GET" class="form-inline">

            <div class="form-group">
                Boardgame:
                <select name="boardgame">
                    @if ($filters['boardgame'] == 0)
                        <option value="0" selected="selected">- All -</option>
                    @else
                        <option value="0">- All -</option>
                    @endif
                    @foreach ($boardgames as $boardgame)
                        @if ($boardgame->id == $filters['boardgame'])
                            <option value="{{ $boardgame->id }}" selected="selected">{{ $boardgame->name }}</option>
                        @else
                            <option value="{{ $boardgame->id }}">{{ $boardgame->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                Player:
                <select name="player">
                    @if ($filters['player'] == 0)
                        <option value="0" selected="selected">- All -</option>
                    @else
                        <option value="0">- All -</option>
                    @endif
                    @foreach ($users as $user)
                        @if ($user->id == $filters['player'])
                            <option value="{{ $user->id }}" selected="selected">{{ $user->name }}</option>
                        @else
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                Date from:
                <input type="date" id="dateFrom" name="dateFrom" value="{{ $filters['dateFrom'] }}">
            </div>

            <div class="form-group">
                Date to:
                <input type="date" id="dateTo" name="dateTo" value="{{ $filters['dateTo'] }}">
            </div>

            <div class="form-group">
                <button class="btn btn-default" type="submit"><i class="fa fa-search fa-fw"></i></button>
                <a href="/games" class="btn btn-default">Clear</a>
            </div>
        </form>
    </div>

    @if (count($games) > 0)
        <table class="hover" id="data">

            <thead>
                <th width="100"></th>
                <th>Boardgame</th>
                <th width="70">Date</th>
                <th width="100">No of players</th>
                <th width="100">Length min.</th>
                <th width="150">Created by</th>
                <th width="100">&nbsp;</th>
            </thead>

            <tbody>
                @foreach ($games as $game)
                    <tr>
                        <td class="text-center">
                            <img style="max-height: 50px; width: auto; " src="{{$game->boardgame->thumbnail}}"/>
                        </td>
                        <td>
                            {{ $game->boardgame->name }}
                        </td>
                        <td>
                            {{ $game->date }}
                        </td>
                        <td>
                            {{ count($game->players) + count($game->guests) }}
                        </td>
                        <td>
                            {{ $game->minutes }}
                        </td>
                        <td>
                            {{ $game->user->name }}
                        </td>
                        <td class="text-right">
                            <div class="btn-group">
                                <a href="/game/view/{{ $game->id }}" class="btn btn-default"><i class="fa fa-eye fa-fw"></i></a>
                                @if ((Auth::user()->admin == 1) || ($user->id == $game->user_id))
                                    <a href="/game/edit/{{ $game->id }}" class="btn btn-default"><i class="fa fa-edit fa-fw"></i></a>
                                @endif
                            </div> 
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center">
            <h4>There are no results that match your search<h4>
        </div>
    @endif

    <script type="text/javascript">

        $(document).ready(function() {
            $('#data').DataTable({
                searching: false,
                order: [[ 2, "desc" ]],
                pageLength: 25,
                columnDefs: [
                    { orderable: false, targets: 0 },
                    { orderable: false, targets: 5 }
                ]
            });
        });

    </script>
@stop