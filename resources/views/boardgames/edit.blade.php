<div>
    <!-- New Task Form -->
    <form action="/boardgame/edit/{{$boardgame->id}}" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Task Name -->
        <div>
            <label>Task</label>

            <div>
                <input type="text" name="name" value="{{$boardgame->name}}">
            </div>

            <label>BGG Link</label>

            <div>
                <input type="text" name="bgg_link" value="{{$boardgame->bgg_link}}">
            </div>
        </div>

        <!-- Add Task Button -->
        <div>
            <div>
                <button type="submit">
                    Save
                </button>
            </div>
        </div>
    </form>
</div>