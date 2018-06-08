@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item active">Users</li>
    </ol>

    <div class="text-center">
        <h2>Users</h2>
    </div>

    <div class="text-right">        
        <form action="/users" method="GET" class="form-inline">
            <div class="form-group">
                Name:
                <input type="text" class="form-control" name="name" placeholder="Name..." value="{{ $name }}">
            </div>

            <div class="form-group">
                <button class="btn btn-default" type="submit"><i class="fa fa-search fa-fw"></i></button>
                <a href="/users" class="btn btn-default">Clear</a>
            </div>
        </form>
    </div>

    @if (count($users) > 0)
        <table class="hover" id="data">

            <thead>
                <th>Name</th>
                <th>Email</th>
                <th>Bg (exp)</th>
            </thead>

            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td>
                            <a href="/user/view/{{ $user->id }}">{{ $user->name }}</a>
                        </td>
                        <td><a href="mailto:{{ $user->email }}">{{ $user->email }}</a></td>
                        <td>{{ count($user->boardgames) }} ({{ count($user->expansions) }})</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <div class="text-center">
            No data
        </div>
    @endif

    <script type="text/javascript">

        $(document).ready(function() {
            $('#data').DataTable({
                searching: false
            });
        });

    </script>

@stop