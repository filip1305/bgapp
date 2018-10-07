@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Statistics</li>
    </ol>

    <div class="text-center">
        <h2>Statistics</h2>
    </div>

    <div class="col-sm-2">
        <h3>Hall of Fame</h3>

        <table class="hover" id="all_users_table">

            <thead>
            <th>User</th>
            <th width="50"></th>
            </thead>

            <tbody>
            @foreach ($allUsersData as $allUserData)
                <tr>
                    <td>{{ $allUserData->name }}</td>
                    <td>{{ $allUserData->percent }} %</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-sm-5">
        <h3>Played games</h3>

        <table class="hover" id="boardgames_table">

            <thead>
            <th>Boardgame</th>
            <th width="60">Count</th>
            <th width="70">Minutes</th>
            <th width="40">Avg</th>
            </thead>

            <tbody>
            @foreach ($boardgamesData as $boardgameData)
                <tr>
                    <td>{{ $boardgameData->name }}</td>
                    <td>{{ $boardgameData->count }}</td>
                    <td>{{ $boardgameData->minutes }}</td>
                    <td>{{ $boardgameData->avg }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <form action="/statistics" method="GET" class="form-inline">

    <div class="col-sm-2">
        <h3>Boardgame Statistic</h3>

        <select name="boardgameId" style="width: 100%;">
            @if ($filters['boardgameId'] == 0)
                <option value="0" selected="selected">- All -</option>
            @else
                <option value="0">- All -</option>
            @endif
            @foreach ($boardgames as $boardgame)
                @if ($boardgame->id == $filters['boardgameId'])
                    <option value="{{ $boardgame->id }}" selected="selected">{{ $boardgame->name }}</option>
                @else
                    <option value="{{ $boardgame->id }}">{{ $boardgame->name }}</option>
                @endif
            @endforeach
        </select>

        <table class="hover" id="bg_teble">

            <thead>
            <th>User</th>
            <th width="50"></th>
            </thead>

            <tbody>
            @foreach ($bestByBoardgameData as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->percent }} %</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="col-sm-3">
        <h3>Player Statistic</h3>

        <select name="userId" style="width: 80%;">
            @if ($filters['userId'] == 0)
                <option value="0" selected="selected">- All -</option>
            @else
                <option value="0">- All -</option>
            @endif
            @foreach ($users as $user)
                @if ($user->id == $filters['userId'])
                    <option value="{{ $user->id }}" selected="selected">{{ $user->name }}</option>
                @else
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endif
            @endforeach
        </select>

        <div class="form-group">
            <button class="btn btn-default" type="submit"><i class="fa fa-search fa-fw"></i></button>
        </div>
        </form>

        <table class="hover" id="user_teble">

            <thead>
            <th>Boardgame</th>
            <th width="50"></th>
            </thead>

            <tbody>
            @foreach ($userData as $boardgame)
                <tr>
                    <td>{{ $boardgame->name }}</td>
                    <td>{{ $boardgame->percent }} %</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <script type="text/javascript">

        $(document).ready(function() {
            $('#all_users_table').DataTable({
                searching: false,
                pageLength: 25,
                ordering: false,
                columnDefs: [
                    { targets: 1, className: 'dt-body-right'}
                ]
            });

            $('#user_teble').DataTable({
                searching: false,
                pageLength: 25,
                ordering: false,
                columnDefs: [
                    { targets: 1, className: 'dt-body-right'}
                ]
            });

            $('#bg_teble').DataTable({
                searching: false,
                pageLength: 25,
                ordering: false,
                columnDefs: [
                    { targets: 1, className: 'dt-body-right'}
                ]
            });

            $('#boardgames_table').DataTable({
                searching: false,
                pageLength: 25,
                order: [[ 2, "desc" ]],
                columnDefs: [
                    { targets: 1, className: 'dt-body-right'},
                    { targets: 2, className: 'dt-body-right'},
                    { targets: 3, className: 'dt-body-right'}
                ]
            });
        });

    </script>

@stop