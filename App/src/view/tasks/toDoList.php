<body class="d-flex flex-column min-vh-100">
    <div class="preloader">
        <div class="loader"></div>
    </div>
    <div class="my-5 mx-md-5">
        <div class="card bg-white shadow-lg container-fluid w-50 rounded-4 p-0">
            <div class="card-header border-1">
            </div>
            <div class=" my-5 mx-4">
                <div class="w-100 d-inline-flex align-items-center justify-content-between">
                    <h3>To-Do List</h3>
                    <div class="input-group w-25 justify-content-end">
                            <a href="/add-task" id="add-task" class="btn btn-outline-primary">Add</a>
                    </div>
                </div>
                <hr>
                <div class="container m-0 p-0 d-flex w-100">
                    <div id="to-do-list" class="list-group list-group-flush d-flex w-100">

                        <?php foreach($taskListDTO->getList() as $task): // render to-do list array in html ?>

                            <div id="item_<?php echo $task['id'] ?>" class="list-group-item d-inline-flex align-items-center justify-content-between">
                                <div class="d-inline-flex">
                                    <a href="/view-task?id=<?php echo htmlspecialchars($task['id']); ?>" id="view-task" class="btn btn-primary rounded-4 mx-2">View</a>
                                    <a href="/edit-task?id=<?php echo htmlspecialchars($task['id']); ?>" id="edit-task" class="btn btn-outline-secondary rounded-4 mx-2">Edit</a>
                                </div>
                                <div class="d-none">
                                    <p><?php echo htmlspecialchars($task['id']); ?></p>
                                </div>
                                <div class="d-flex">
                                    <p><?php echo htmlspecialchars($task['name']); ?></p>
                                </div>
                                <div class="d-flex">
                                    <button id="delete-task-btn" class="btn btn-danger rounded-4 delete-task-btn" value="<?php echo $task['id'] ?>">Delete</button>
                                </div>
                            </div>

                        <?php endforeach; ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
