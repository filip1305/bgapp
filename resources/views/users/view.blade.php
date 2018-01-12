@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/users/">Users</a></li>
        <li class="breadcrumb-item active">{{ $user->name }}</li>
    </ol>

    <div class="col-sm-12">
        <div>
            Name: {{ $user->name }}
        <div>
        </div>
            Email: <a href="mailto:{{ $user->email }}">{{ $user->email }}</a>
        </div>

        @if ($me == 1)
            <a href="/user/password" class="btn btn-default btn-sm">Change password</a>
        @endif
    </div>

    <div class="col-sm-6">
        <h4>Boardgames</h4>

        @if ($me == 1)
            <a href="/user/boardgame/add" class="btn btn-default btn-sm">Add</a>
        @endif
        @if (count($user->boardgames))
            <table class="hover"  id="data_bg">

                <thead>
                    <th></th>
                    <th>Name</th>
                    <th>Players</th>
                    <th>Playing time [minutes]</th>
                    <th></th>
                </thead>

                <tbody>
                    @foreach ($user->boardgames as $boardgame)
                        <tr>
                            <td class="text-center"><img style="max-height: 50px; width: auto; " src="{{$boardgame->thumbnail}}" /></td>
                            <td>
                                <a href="/boardgame/view/{{ $boardgame->id }}">{{ $boardgame->name }} ({{ $boardgame->yearpublished }})</a>
                            </td>
                            <td>{{ $boardgame->minplayers }} - {{ $boardgame->maxplayers }}</td>
                            <td>{{ $boardgame->minplaytime }} - {{ $boardgame->maxplaytime }}</td>
                            <td>
                                @if ($me == 1)
                                    <a href="/user/boardgame/delete/{{ $boardgame->id }}" class="btn btn-default btn-sm" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
    
    <div class="col-sm-6">
        <h4>Expansions</h4>

        @if ($me == 1)
            <a href="/user/expansion/add" class="btn btn-default btn-sm">Add</a>
        @endif
        @if (count($user->expansions))        
            <table class="hover"  id="data_ex">

                <thead>
                    <th></th>
                    <th>Name</th>
                    <th>Players</th>
                    <th>Playing time [minutes]</th>
                    <th></th>
                </thead>

                <tbody>
                    @foreach ($user->expansions as $expansion)
                        <tr>
                            <td class="text-center"><img style="max-height: 50px; width: auto; " src="{{$expansion->thumbnail}}" /></td>
                            <td>
                                <a href="/expansion/view/{{ $expansion->id }}">{{ $expansion->name }} ({{ $expansion->yearpublished }})</a>
                            </td>
                            <td>{{ $expansion->minplayers }} - {{ $expansion->maxplayers }}</td>
                            <td>{{ $expansion->minplaytime }} - {{ $expansion->maxplaytime }}</td>
                            <td>
                                @if ($me == 1)
                                    <a href="/user/expansion/delete/{{ $expansion->id }}" class="btn btn-default btn-sm" onclick="return confirm('Are you sure?')"><i class="fa fa-trash"></i></a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>

    <script type="text/javascript">

        $(document).ready(function() {
            $('#data_bg').DataTable({
                searching: false,
                order: [[ 1, "asc" ]],
                columnDefs: [
                    { orderable: false, targets: 0 },
                    { orderable: false, targets: 4 }
                ]
            });

            $('#data_ex').DataTable({
                searching: false,
                order: [[ 1, "asc" ]],
                columnDefs: [
                    { orderable: false, targets: 0 },
                    { orderable: false, targets: 4 }
                ]
            });
        });

    </script>
@stop