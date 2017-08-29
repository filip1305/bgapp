@extends('bgapp')

@section('content')

    <ul class="breadcrumbs">
        <li class="last"><a href="" onclick="return false">Users</a></li>
    </ul>

    <div>
        <div class="center">
            <h3>Users</h3>
        </div>

        <div class="right">
            <form action="/users" method="GET" class="form-horizontal">
                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" name="search" placeholder="Search..." value="{{$search}}">
                    <span class="input-group-btn">
                        <button class="btn btn-default-sm" type="submit">
                            <i class="fa fa-search"></i>
                        </button>
                    </span>
                </div>
            </form>
        </div>
    </div>

    @if (count($users) > 0)
        <div>
            <div>
                <table class="striped" id="data">

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
            </div>
        </div>
    @else
        <div class="center">
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