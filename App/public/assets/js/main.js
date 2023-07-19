import { TaskManager } from "./task.js";

$(function() {
    const taskManager = new TaskManager();

    // defines what input fields will be visible
    var pageMap = [
        ['/view-task', ['#id_group', '#name_group', '#status_group', '#description_group']],
        ['/add-task', ['#name_group', '#description_group']],
        ['/edit-task', ['#id_group', '#name_group', '#status_group', '#description_group']]
    ];

    var path = window.location.pathname;

    pageMap.forEach(page => {
        if (page[0] === path)
        {
            if (page[0] === '/view-task')
            {
                $('#View-save-task').addClass('d-none')

                var cancelButton = document.getElementById("cancel-add");
                cancelButton.innerHTML = "Return";
            }

            page[1].forEach(input => {
                $(input).removeClass('d-none');
            })
        }
    });

    // set page buttons where-to-go location
    $('button').on('click', (function() {

        if ($(this).attr("href")) 
        {
            window.location.href = $(this).attr("href");
        }}
    ));

    // adds task
    $('#Add_task_form').on('submit', function(e) {
        $('.form-group').removeClass('has-error');
        $('.help-block').remove();

        e.preventDefault();

        const formTask = {
            id: null,
            name: $('#name').val(),
            description: $('#description').val(),
            status: false
        };

        console.log('add')
        taskManager.postTask(formTask, '/add-task', 'insert');
    });

    // edits task
    $('#Edit_task_form').on('submit', function(e) {
        $('.form-group').removeClass('has-error');
        $('.help-block').remove();

        e.preventDefault();

        const formTask = {
            id: $('#id').val(),
            name: $('#name').val(),
            description: $('#description').val(),
            status: $('#status').val()
        };

        console.log('edit')
        taskManager.postTask(formTask, '/edit-task', 'update');

    })

    // deletes task
    $('.delete-task-btn').on('click', function() {
        var taskId = $(this).val();
        
        taskManager.deleteTask(taskId);
    });

});

$(window).on("load", function() {
    
    $('.preloader').remove();

});