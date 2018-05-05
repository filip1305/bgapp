@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/boardgames/">Boardgames</a></li>
        <li class="breadcrumb-item active">View boardgame</li>
    </ol>

    <div class="text-center">
        <h3>{{ $boardgame->name }}</h3>

        @if ( Auth::user()->admin == 1)
            <div class="text-right">
                <a href="/boardgame/edit/{{ $boardgame->id }}" class="btn btn-default"><i class="fa fa-edit fa-fw"></i></a>
            </div>
        @endif
    </div>

    <div class="col-sm-3">
        @if (!empty($boardgame->bgg_link))
            <div class="row">
                <img style="max-width: 100%; width: auto; " src="{{$boardgame->image}}" />
            </div>
        @endif
    </div>

    <div class="col-sm-9">
        <div class="row">
            <div class="col-sm-2"><strong>Name:</strong></div>
            <div class="col-sm-10">{{ $boardgame->name }} ({{ $boardgame->yearpublished }})</div>
        </div>

        <div class="row">
            <div class="col-sm-2"><strong>Players:</strong></div>
            <div class="col-sm-10">{{ $boardgame->minplayers }} - {{ $boardgame->maxplayers }}</div>
        </div>

        <div class="row">
            <div class="col-sm-2"><strong>Playing time:</strong></div>
            <div class="col-sm-10">{{ $boardgame->minplaytime }} - {{ $boardgame->maxplaytime }} Min</div>
        </div>

        <div class="row">
            <div class="col-sm-2"><strong>Categories:</strong></div>
            <div class="col-sm-10">
                <?php $string = ''; ?>
                @foreach ($boardgame->categories as $category)
                    <?php $string .= $category->name . ', '; ?>
                @endforeach
                {{ substr($string, 0, -2) }}&nbsp;
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><strong>Desinger:</strong></div>
            <div class="col-sm-10">
                <?php $string = ''; ?>
                @foreach ($boardgame->designers as $designer)
                    <?php $string .= $designer->name . ', '; ?>
                @endforeach
                {{ substr($string, 0, -2) }}&nbsp;
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><strong>Publishers:</strong></div>
            <div class="col-sm-10">
                <?php $string = ''; ?>
                @foreach ($boardgame->publishers as $publisher)
                    <?php $string .= $publisher->name . ', '; ?>
                @endforeach
                {{ substr($string, 0, -2) }}&nbsp;
            </div>
        </div>

        <div class="row">
            <div class="col-sm-9">
                <h5><strong>Description:</strong></h5>
                <?php echo $boardgame->description; ?>
            </div>
        </div>

        @if (count($boardgame->expansions))

            <div class="row">
                <div class="col-sm-9">
                    <h4><strong>Expansions</strong></h4>

                    <table class="table table-striped">

                        <thead>
                            <th></th>
                            <th>Name</th>
                            <th>Players</th>
                            <th>Playing time [minutes]</th>
                        </thead>

                        <tbody>
                            @foreach ($expansions as $expansion)
                                <tr>
                                    <td class="text-center"><img style="max-height: 50px; width: auto; " src="{{$expansion->thumbnail}}" /></td>
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
            </div>                
        @endif
    </div>
@stop