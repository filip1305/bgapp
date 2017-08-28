@extends('bgapp')

@section('content')
    <ul class="breadcrumbs">
        <li><a href="/boardgames/">Boardgames</a></li>
        <li class="last"><a href="" onclick="return false">View boardgame</a></li>
    </ul>

    <div>
        <div class="center">
            <h3>{{ $boardgame->name }}</h3>

            <div class="right">
                <a href="/boardgame/edit/{{ $boardgame->id }}">Edit</a>
            </div>
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

        <div class="col_3">Categories:</div><div class="col_9">
            <?php $string = ''; ?>
            @foreach ($boardgame->categories as $category)
                <?php $string .= $category->name . ', '; ?>
            @endforeach
            {{ substr($string, 0, -2) }}&nbsp;
        </div>

        <div class="col_3">Desinger:</div><div class="col_9">
            <?php $string = ''; ?>
            @foreach ($boardgame->designers as $designer)
                <?php $string .= $designer->name . ', '; ?>
            @endforeach
            {{ substr($string, 0, -2) }}&nbsp;
        </div>

        <div class="col_3">Publishers:</div><div class="col_9">
            <?php $string = ''; ?>
            @foreach ($boardgame->publishers as $publisher)
                <?php $string .= $publisher->name . ', '; ?>
            @endforeach
            {{ substr($string, 0, -2) }}&nbsp;
        </div>
        
        <div class="col_9">
            <h5>Description:</h5>
            <?php echo $boardgame->description; ?>
        </div>

        @if (count($boardgame->expansions))
            <div class="col_9">
                <h5>Expansions</h5>

                <table class="striped">

                    <thead>
                        <th></th>
                        <th>Name</th>
                        <th>Players</th>
                        <th>Playing time [minutes]</th>
                    </thead>

                    <tbody>
                        @foreach ($expansions as $expansion)
                            <tr>
                                <td class="center"><img style="max-height: 50px; width: auto; " src="{{$expansion->thumbnail}}" /></td>
                                <td>
                                    <a href="/expansion/view/{{ $expansion->id }}">{{ $expansion->name }} ({{ $expansion->yearpublished }})</a>
                                </td>
                                <td>{{ $expansion->minplayers }} - {{ $expansion->maxplayers }}</td>
                                <td>{{ $expansion->minplaytime }} - {{ $expansion->maxplaytime }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@stop