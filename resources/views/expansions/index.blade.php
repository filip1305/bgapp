@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Expansions</li>
    </ol>

    <div class="text-center">
        <h2>Expansions</h2>
    </div>

    <div class="text-right">
        <div class="form-group">
            <a href="/expansion/add" class="btn btn-default">Add new expansion</a>
            @if ($admin == 1)
                <a href="/expansion/refresh" class="btn btn-default">Refresh BGG data</a>
            @endif
        </div>
        
        <form action="/expansions" method="GET" class="form-inline">
            <div class="form-group">
                Name:
                <input type="text" class="form-control" name="name" placeholder="Name..." value="{{ $search }}">
            </div>

            <div class="form-group">
                <button class="btn btn-default" type="submit"><i class="fa fa-search fa-fw"></i></button>
                <a href="/expansions" class="btn btn-default">Clear</a>
            </div>
        </form>
    </div>

    @if (count($expansions) > 0)
        <table class="hover" id="data">

            <thead>
                <th width="100"></th>
                <th>Name</th>
                <th>Boardgames</th>
                <th width="80">Players</th>
                <th width="200">Playing time [minutes]</th>
                <th width="100">&nbsp;</th>
            </thead>

            <tbody>
                @foreach ($expansions as $expansion)
                    <tr>
                        <td class="text-center"><img style="max-height: 50px; width: auto; " src="{{$expansion->thumbnail}}" /></td>
                        <td>
                            <a href="/expansion/view/{{ $expansion->id }}">{{ $expansion->name }} ({{ $expansion->yearpublished }})</a>
                        </td>
                        <td>
                            @foreach ($expansion->boardgames as $boardgame)
                                <a href="/boardgame/view/{{ $boardgame->id }}">{{ $boardgame->name }} ({{ $boardgame->yearpublished }})</a>&nbsp;
                            @endforeach
                        </td>
                        <td>{{ $expansion->minplayers }} - {{ $expansion->maxplayers }}</td>
                        <td>{{ $expansion->minplaytime }} - {{ $expansion->maxplaytime }}</td>
                        <td class="text-right">
                            <div class="btn-group">
                                @if (!empty($boardgame->bgg_link))
                                    <a href="{{ $expansion->bgg_link }}" class="btn btn-default" target="_blank"><i class="fa fa-link fa-fw"></i></a>
                                @endif
                                @if ($admin == 1)
                                    <a href="/expansion/edit/{{ $expansion->id }}" class="btn btn-default"><i class="fa fa-edit fa-fw"></i></a>
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
                order: [[ 1, "asc" ]],
                pageLength: 25,
                columnDefs: [
                    { orderable: false, targets: 0 },
                    { orderable: false, targets: 5 }
                ]
            });
        });

    </script>
@stop