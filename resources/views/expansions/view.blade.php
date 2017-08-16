@extends('bgapp')

@section('content')
    <ul class="breadcrumbs">
        <li><a href="/expansions/">Expansions</a></li>
        <li class="last"><a href="" onclick="return false">View expansion</a></li>
    </ul>

    <div>
        <div class="center">
            <h3>{{ $expansion->name }}</h3>

            <div class="right">
                <a href="/expansion/edit/{{ $expansion->id }}">Edit</a>
            </div>
        </div>
    </div>

    <div class="col_3">
        @if (!empty($expansion->bgg_link))
            <img style="max-width: 100%; width: auto; " src="{{$expansion->image}}" />
        @endif
    </div>

    <div class="col_9">
        <div class="col_3">Name:</div><div class="col_9">{{ $expansion->name }} ({{ $expansion->yearpublished }})</div>
        <div class="col_3">Boardgames:</div>
        <div class="col_9">
            @foreach ($expansion->boardgames as $boardgame)
                <a href="/boardgame/view/{{ $boardgame->id }}">{{ $boardgame->name }} ({{ $boardgame->yearpublished }})</a>&nbsp;
            @endforeach
        </div>
        <div class="col_3">Players:</div><div class="col_9">{{ $expansion->minplayers }} - {{ $expansion->maxplayers }}</div>
        <div class="col_3">Playing time:</div><div class="col_9">{{ $expansion->minplaytime }} - {{ $expansion->maxplaytime }} Min</div>
        <div class="clear"></div>
        <div class="col_9">
            <h5>Description:</h5>
            <?php echo $expansion->description; ?>
        </div>
    </div>
@stop