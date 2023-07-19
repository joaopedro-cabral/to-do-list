<body class="d-flex flex-column min-vh-100">
    <div class="preloader">
        <div class="loader"></div>
    </div>

    <?php $thisPage = new \App\Models\PageHandler($_SERVER['REQUEST_URI']); ?>

    <form id="<?php echo $thisPage->getPage($pagesMap); ?>_task_form" method="POST" novalidate>
        <div class="my-5 mx-md-5">
            <div class="bg-white shadow-lg container-fluid w-50 rounded-4 py-2 px-4">
                <div class="my-4 mx-4">
                    <?php echo $pageTile = $thisPage->setTitle($pagesMap) ?>
                    <hr>
                    <div id="id_group" class="d-inline-flex form-group my-3 d-none">
                        <label class="col-form-label" for="id">ID</label>
                        <div>
                            <input type="text" class="form-control rounded-4 mx-3 w-25" name="id" id="id" value="<?php echo isset($taskDTO) ? htmlspecialchars($taskDTO->getProperty('id')) : ''; ?>" readonly>
                        </div>
                    </div>
                    <div id="name_group" class="form-group my-3 d-none">
                        <label class="col-form-label" for="name">Name</label>
                        <div>
                            <input type="text" class="form-control rounded-4" name="name" id="name" value="<?php echo isset($taskDTO) ? htmlspecialchars($taskDTO->getProperty('name')) : ''; ?>" placeholder="Task name..." <?php if ($thisPage->getPage($pagesMap) === 'View') echo 'disabled'; ?>>
                        </div>
                    </div>
                    <div id="description_group" class="form-group my-3 d-none">
                        <label class="col-form-label" for="description">Description</label>
                        <div>
                            <textarea class="form-control rounded-4" name="description" id="description" rows="6" placeholder="Describe your task..." <?php if ($thisPage->getPage($pagesMap) === 'View') echo 'disabled'; ?>><?php echo isset($taskDTO) ? htmlspecialchars($taskDTO->getProperty('description')) : ''; ?></textarea>
                        </div>
                    </div>
                    <div id="status_group" class="form-group my-3 d-none">
                        <label class="col-form-label" for="status">Status</label>
                        <div>
                            <select class="form-select rounded-pill" name="status" id="status" <?php if ($thisPage->getPage($pagesMap) === 'View') echo 'disabled'; ?>>
                                <?php

                                $selectOptions = $thisPage->renderSelect($taskDTO);

                                foreach($selectOptions as $option)
                                {
                                    echo $option;
                                }

                                ?>
                            </select>
                        </div>
                    </div>
                    <div id="action_group" class="form-group my-3 d-flex justify-content-center">
                        <a href="/" id="cancel-add" class="btn btn-outline-danger rounded-4 mx-2">Cancel</a>
                        <button type="submit" name="submit" id="<?php echo $thisPage->getPage($pagesMap)?>-save-task" class="btn btn-primary text-light rounded-4 mx-2">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </form> 


</body>