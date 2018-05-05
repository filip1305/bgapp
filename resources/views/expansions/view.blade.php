@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/expansions/">Expansions</a></li>
        <li class="breadcrumb-item active">View expansion</li>
    </ol>

    <div class="text-center">
        <h3>{{ $expansion->name }}</h3>

        @if ( Auth::user()->admin == 1)
            <div class="text-right">
                <a href="/expansion/edit/{{ $expansion->id }}" class="btn btn-default"><i class="fa fa-edit fa-fw"></i></a>
            </div>
        @endif
    </div>

    <div class="col-sm-3">
        @if (!empty($expansion->bgg_link))
            <img style="max-width: 100%; width: auto; " src="{{$expansion->image}}" />
        @endif
    </div>

    <div class="col-sm-9">
        <div class="row">
            <div class="col-sm-2"><strong>Name:</strong></div>
            <div class="col-sm-10">{{ $expansion->name }} ({{ $expansion->yearpublished }})</div>
        </div>
        
        <div class="row">
            <div class="col-sm-2"><strong>Boardgames:</strong></div>
            <div class="col-sm-10">
                @foreach ($expansion->boardgames as $boardgame)
                    <a href="/boardgame/view/{{ $boardgame->id }}">{{ $boardgame->name }} ({{ $boardgame->yearpublished }})</a>&nbsp;
                @endforeach
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-2"><strong>Players:</strong></div>
            <div class="col-sm-10">{{ $expansion->minplayers }} - {{ $expansion->maxplayers }}</div>
        </div>
        
        <div class="row">
            <div class="col-sm-2"><strong>Playing time:</strong></div>
            <div class="col-sm-10">{{ $expansion->minplaytime }} - {{ $expansion->maxplaytime }} Min</div>
        </div>

        <div class="row">
            <div class="col-sm-2"><strong>Categories:</strong></div>
            <div class="col-sm-10">
                <?php $string = ''; ?>
                @foreach ($expansion->categories as $category)
                    <?php $string .= $category->name . ', '; ?>
                @endforeach
                {{ substr($string, 0, -2) }}&nbsp;
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><strong>Desinger:</strong></div>
            <div class="col-sm-10">
                <?php $string = ''; ?>
                @foreach ($expansion->designers as $designer)
                    <?php $string .= $designer->name . ', '; ?>
                @endforeach
                {{ substr($string, 0, -2) }}&nbsp;
            </div>
        </div>

        <div class="row">
            <div class="col-sm-2"><strong>Publishers:</strong></div>
            <div class="col-sm-10">
                <?php $string = ''; ?>
                @foreach ($expansion->publishers as $publisher)
                    <?php $string .= $publisher->name . ', '; ?>
                @endforeach
                {{ substr($string, 0, -2) }}&nbsp;
            </div>
        </div>

        <div class="row">
            <div class="col-sm-9">
                <h5><strong>Description:</strong></h5>
                <?php echo $expansion->description; ?>
            </div>
        </div>
    </div>
@stop