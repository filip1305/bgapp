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
    </div>

    @if (count($games) > 0)
        <table class="hover" id="data">

            <thead>
                <th>Boardgame</th>
                <th width="70">Date</th>
                <th width="100">No of players</th>
                <th width="100">Length min.</th>
                <th width="100">&nbsp;</th>
            </thead>

            <tbody>
                @foreach ($games as $game)
                    <tr>
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
                        <td class="text-right">
                            <div class="btn-group">
                                <a href="/game/view/{{ $game->id }}" class="btn btn-default"><i class="fa fa-eye fa-fw"></i></a>
                                @if (($user->admin == 1) || ($user->id == $game->user_id))
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
                order: [[ 1, "desc" ]],
                pageLength: 25,
                columnDefs: [
                    { orderable: false, targets: 4 }
                ]
            });
        });

    </script>
@stop