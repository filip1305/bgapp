@extends('bgapp')

@section('content')

    <div>
        <div class="center">
            <h3>{{ $boardgame->name }}</h3>
        </div>
    </div>

    <div class="col_3">
        @if (!empty($boardgame->bgg_link))
            <img style="max-width: 100%; width: auto; " src="{{$boardgame->image}}" />
        @endif
    </div>

    <div class="col_9">
        <div class="col_3">Name:</div><div class="col_9">{{ $boardgame->name }} ({{ $boardgame->yearpublished }})</div>
        <div class="col_3">Players:</div><div class="col_9">{{ $boardgame->minplayers }} - {{ $boardgame->maxplayers }}</div>
        <div class="col_3">Playing time:</div><div class="col_9">{{ $boardgame->minplaytime }} - {{ $boardgame->maxplaytime }} Min</div>
        <div class="clear"></div>
        <div class="col_9">
            <h5>Description:</h5>
            <?php echo $boardgame->description; ?>
        </div>
    </div>
@stop