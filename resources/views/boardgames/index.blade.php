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
                                    <div>{{ $boardgame->name }}</div>
                                </td>

                                <td>
                                    <div>{{ $boardgame->bgg_link }}</div>
                                </td>

                                <td>
                                    <!-- TODO: Delete Button -->
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
