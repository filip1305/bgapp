@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/games/">Games</a></li>
        <li class="breadcrumb-item active">View game</li>
    </ol>

    <div class="text-center">
        <h3>{{ $game->boardgame->name }}</h3>

        @if ( (Auth::user()->admin == 1) || (Auth::user()->id == $game->user_id))
            <div class="text-right">
                <a href="/game/edit/{{ $game->id }}" class="btn btn-default"><i class="fa fa-edit fa-fw"></i></a>
            </div>
        @endif
    </div>

    <div class="col-sm-5">

        <div class="col-sm-6">
            <h5><strong>Date:</strong></h5>
            {{ $game->date }}

            <h5><strong>Game length:</strong></h5>
            {{ $game->minutes }} min.
        </div>

        <div class="col-sm-6">
            <h5><strong>Expansions:</strong></h5>
            @foreach ($game->expansions as $expansion)
                {{ $expansion->name }} </br>
            @endforeach
        </div>

        <div class="clearfix"></div>

        <div class="col-sm-6">
            <h5><strong>Players:</strong></h5>
            @foreach ($game->players as $player)
                {{ $player->user->name }} </br>
            @endforeach
            @foreach ($game->guests as $guest)
                {{ $guest->name }} </br>
            @endforeach
        </div>

        <div class="col-sm-6">
            <h5><strong>Winner(s):</strong></h5>
            @foreach ($game->players as $player)
                @if ($player->winner)
                    {{ $player->user->name }} </br>
                @endif
            @endforeach
            @foreach ($game->guests as $guest)
                @if ($guest->winner)
                    {{ $guest->name }} </br>
                @endif
            @endforeach
        </div>

        <div class="clearfix"></div>

        <div class="col-sm-12">
            <h5><strong>Description:</strong></h5>
            <?php echo nl2br($game->description); ?>
        </div>
    </div>

    <div class="col-sm-7">
        <h5><strong>Comments:</strong></h5>

        @if (in_array(Auth::user()->id, $players))

            <form action="/game/comment/{{$game->id}}" method="POST">
                {{ csrf_field() }}

                <textarea name="comment" style="width:100%;" rows="5"></textarea>

                <button type="submit" class="btn btn-default">Comment</button>
            </form>

        @endif

        <table class="striped" width="100%">
            <tbody>
                @foreach ($game->comments as $comment)
                    <tr>
                        <td width="170px" style="border-bottom: 1px solid;">
                            {{ $comment->user->name }} </br>
                            {{ $comment->created_at }}
                        </td>
                        <td style="border-bottom: 1px solid;">
                            <?php echo nl2br($comment->comment); ?>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@stop