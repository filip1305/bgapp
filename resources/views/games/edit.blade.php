@extends('bgapp')

@section('content')
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="/games/">Games</a></li>
        <li class="breadcrumb-item active">Edit game</li>
    </ol>    

    <div>

        <h3>Edit game</h3>
        
        <form action="/game/edit/{{$game->id}}" method="POST">
            {{ csrf_field() }}

            <input type="hidden" id="players" name="players">
            <input type="hidden" id="gst" name="gst">
            <input type="hidden" id="expan" name="expan">

            <div class="form-group col-sm-12">

                <div class="col-sm-5">
                    <div class="form-group">
                        <label>Boardgames</label>
                        <div>
                            <select name="boardgame" id="boardgame" style="width:600px;" onchange="getExpansions();" value="{{ $game->boardgame_id }}">
                                @foreach ($boardgames as $boardgame)
                                    @if ($boardgame->id == $game->boardgame_id)
                                        <option value="{{ $boardgame->id }}" selected="selected">{{ $boardgame->name }}</option>
                                    @else
                                        <option value="{{ $boardgame->id }}">{{ $boardgame->name }}</option>
                                    @endif
                                @endforeach


                            </select>
                        </div>
                    </div>

                    <div class="form-group">
                        <div id="expansions"></div>
                    </div>

                    <div class="form-group">
                        <label>Date</label>
                        <div>
                            <input type="date" id="date" name="date" value="{{ $game->date }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Minutes</label>
                        <div>
                            <input id="minutes" name="minutes" value="{{ $game->minutes }}">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Player</label>
                        <div>
                            <select name="user" id="player" style="width:500px;">
                                @foreach ($users as $user)
                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                @endforeach
                            </select>
                            <button class="btn btn-default" type="button" id="add_player">Add Player</button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Guest</label>
                        <div>
                            <input type="text" name="guest" id="guest" style="width:500px;">

                            <button class="btn btn-default" type="button" id="add_guest">Add Guest</button>
                        </div>
                    </div>

                    <div id="result"></div>
                </div>

                <div class="col-sm-7">
                    <label>Description</label>
                    <div>
                        <textarea name="description" style="width:700px;" rows="10">{{ $game->description }}</textarea>
                    </div>
                </div>     
            </div>

            <div class="clear"></div>

            <button type="submit" class="btn btn-default">Save</button>
        </form>
    </div>

    <script type="text/javascript">
        var players = [];
        var guests = [];
        var expansions = [];

        $(document).ready(function() {

            <?php
                foreach ($game->players as $player) {
                    echo "var list = {};\n";

                    echo "list.id = " . $player->user_id . ";\n";
                    echo "list.name = '" . $player->user->name . "';\n";
                    echo "list.winner = " . $player->winner . ";\n";

                    echo "players.push(list);\n";
                }

                foreach ($game->guests as $guest) {
                    echo "var list = {};\n";

                    echo "list.name = '" . $guest->name . "';\n";
                    echo "list.winner = " . $guest->winner . ";\n";

                    echo "guests.push(list);\n";
                }

                foreach ($expansions as $expansion) {
                    echo "var list = {};\n";

                    echo "list.id = " . $expansion->id . ";\n";
                    echo 'list.name = "' . $expansion->name . '";';

                    if (in_array($expansion->id, $selected)) {
                        echo "list.selected = true;\n";
                    } else {
                        echo "list.selected = false;\n";
                    }

                    echo "expansions.push(list);\n";
                }
            ?>

            drawExpansions();
            drawTable();
        });

        // remoce compiler from table
        function getExpansions(){
            var id = $('#boardgame').val();
            
            $.ajax({
                dataType: "json",
                type: "POST",
                evalScripts: true,
                data: ({
                    "_token": "{{ csrf_token() }}",
                    "id": id
                }),
                url: '/expansion/get',
                success: function (data){
                    expansions = []
                    var index;
                    for (index = 0; index < data.length; ++index) {
                        var list = {};

                        list.id = data[index].id;
                        list.name = data[index].name;
                        list.selected = false;

                        expansions.push(list);
                    }

                    drawExpansions();
                },
                error: function (data){
                    alert(JSON.stringify(data));
                }
            });
        }

        // remoce compiler from table
        function removePlayer(id){
            players.splice(id, 1);

            drawTable();
        }

        // remoce compiler from table
        function winnerChb(id){
            players[id].winner = !players[id].winner;

            drawTable();
        }

        // remoce compiler from table
        function winnerChbG(id){
            guests[id].winner = !guests[id].winner;

            drawTable();
        }

        // remoce compiler from table
        function expansionChb(id){
            expansions[id].selected = !expansions[id].selected;

            drawExpansions();
        }

        // remoce compiler from table
        function removeGuest(id){
            guests.splice(id, 1);

            drawTable();
        }

        $("#add_player").click(function() {
            var name = $('#player option:selected').text();
            var id = $('#player').val();

            if (id === undefined || id === null) {
                return;
            }

            for (var i = 0; i < players.length; i++) {
                if (players[i].id == id) {
                    return;
                }
            }

            var list = {};

            list.id = id;
            list.name = name;
            list.winner = false;

            players.push(list);

            drawTable();
        });

        $("#add_guest").click(function() {
            var name = $('#guest').val();

            name = name.trim();

            if (name === '') {
                return;
            }

            for (var i = 0; i < guests.length; i++) {
                if (guests[i].name == name) {
                    return;
                }
            }

            var list = {};

            list.name = name;
            list.winner = false;

            guests.push(list);

            drawTable();
        });

        // draw table withe chosen compilers
        function drawTable(){
            $("#result").html("");
            if (players.length > 0 || guests.length > 0){
                $("#result").html('<table id="ops" style="width:600px;"></table>');
                var string = '';
                string += "<tr>";
                string += "<th width='250px'>Name</th>";
                string += "<th width='150px'>Winner?</th>";
                string += "<th></th>";
                string += "</tr>";

                for (var i = 0; i < players.length; i++) {
                    string += "<tr>";
                    string += "<td>"+players[i].name+"</td>";
                    if (players[i].winner) {
                        string += "<td><input type='checkbox' onclick='winnerChb("+i+");' checked></td>";
                    } else {
                        string += "<td><input type='checkbox' onclick='winnerChb("+i+");'></td>";
                    }
                    
                    string += "<td><a onclick='removePlayer("+i+");' class='button small red item_add'><i class='icon-remove-sign cursor'></i> Remove</a></td>";
                    string += "</tr>";
                };

                for (var i = 0; i < guests.length; i++) {
                    string += "<tr>";
                    string += "<td>"+guests[i].name+"</td>";
                    if (guests[i].winner) {
                        string += "<td><input type='checkbox' onclick='winnerChbG("+i+");' checked></td>";
                    } else {
                        string += "<td><input type='checkbox' onclick='winnerChbG("+i+");'></td>";
                    }
                    string += "<td><a onclick='removeGuest("+i+");' class='button small red item_add'><i class='icon-remove-sign cursor'></i> Remove</a></td>";
                    string += "</tr>";
                };

                $("#ops").append(string);
            }

            $("#expan").val(JSON.stringify(expansions));
            $("#gst").val(JSON.stringify(guests));
            $("#players").val(JSON.stringify(players));
        }

        // draw table withe chosen compilers
        function drawExpansions(){
            $("#expansions").html("");
            if (expansions.length > 0){
                $("#expansions").html('<table id="exp" style="width:600px;"></table>');
                var string = '';
                string += "<tr>";
                string += "<th width='550px'>Expansion</th>";
                string += "<th width='50px'>Used?</th>";
                string += "</tr>";

                for (var i = 0; i < expansions.length; i++) {
                    string += "<tr>";
                    string += "<td>"+expansions[i].name+"</td>";
                    if (expansions[i].selected) {
                        string += "<td><input type='checkbox' onclick='expansionChb("+i+");' checked></td>";
                    } else {
                        string += "<td><input type='checkbox' onclick='expansionChb("+i+");'></td>";
                    }
                    string += "</tr>";
                };

                $("#exp").append(string);
            }

            $("#expan").val(JSON.stringify(expansions));
            $("#gst").val(JSON.stringify(guests));
            $("#players").val(JSON.stringify(players));
        }

    </script>
@stop