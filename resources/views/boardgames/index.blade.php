<!DOCTYPE html>
<html>
    <head>
        <title>Boardgames</title>

        <style>
            table, th, td {
                border: 1px solid black;
            }
        </style>
    </head>
    <body>
        @if (count($boardgames) > 0)
        <div>
            <div>
                Boardgames
            </div>

            <div>
                <table>

                    <!-- Table Headings -->
                    <thead>
                        <th>Name</th>
                        <th>BGG link</th>
                        <th>&nbsp;</th>
                    </thead>

                    <!-- Table Body -->
                    <tbody>
                        @foreach ($boardgames as $boardgame)
                            <tr>
                                <!-- Task Name -->
                                <td>
                                    <div>
                                        {{ $boardgame->name }}
                                    </div>
                                </td>

                                <td>
                                    <div>
                                         <a href="{{ $boardgame->bgg_link }}" target="_blank">link</a> 
                                    </div>
                                </td>

                                <td>
                                    <div>
                                        <a href="/boardgame/edit/{{ $boardgame->id }}">Edit</a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
    </body>
</html>
