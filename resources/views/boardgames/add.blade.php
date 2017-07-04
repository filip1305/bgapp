<div>
    <!-- New Task Form -->
    <form action="/boardgame/add" method="POST" class="form-horizontal">
        {{ csrf_field() }}

        <!-- Task Name -->
        <div>
            <label>Task</label>

            <div>
                <input type="text" name="name">
            </div>

            <label>BGG Link</label>

            <div>
                <input type="text" name="bgg_link">
            </div>
        </div>

        <!-- Add Task Button -->
        <div>
            <div>
                <button type="submit">
                    Add Task
                </button>
            </div>
        </div>
    </form>
</div>