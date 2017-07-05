@extends('bgapp')

@section('content')
    <div class="center">

        <div class="center">
            <h3>Create new boardgame</h3>
        </div>
        
        <form action="/boardgame/add" method="POST" class="form-horizontal">
            {{ csrf_field() }}

            <div>
                <label>Name</label>

                <div>
                    <input type="text" name="name">
                </div>

                <label>BGG Link</label>

                <div>
                    <input type="text" name="bgg_link">
                </div>
            </div>

            <div>
                <div>
                    <button type="submit">
                        Save
                    </button>
                </div>
            </div>
        </form>
    </div>
@stop