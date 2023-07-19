export class TaskManager
{
    postTask(taskDTO, url, type)
    {
        console.log(url);
        console.log(type);
        
        $.ajax({
            type: 'POST',
            url: url,
            data: {
                action: type,
                data: taskDTO,
            },
            dataType: 'json',
            encode: true,
        }).done(function (data) {
            if (!data.success) 
            {
                var fields = [
                    {id: 'name', group: 'name_group', errorClass: 'border-danger', successClass: 'border-success'},
                    {id: 'description', group: 'description_group', errorClass: 'border-danger', successClass: 'border-success'},
                ];
                
                // adds specific notification messages for all input fields
                for (var i = 0; i < fields.length; i++) 
                {
                    var field = fields[i];
                    var $elem = $('#' + field.id);
                    var $group = $('#' + field.group);
                
                    if (data.errors[field.id]) 
                    {
                        $elem.removeClass(field.successClass);
                        $elem.addClass(field.errorClass);
                        $group.addClass('has-error');
                        $group.append('<div class="help-block text-danger my-2">' + data.errors[field.id] + '</div>' );
                    } else {
                        $elem.removeClass(field.errorClass);
                        $elem.addClass(field.successClass);
                        $group.removeClass('has-error');
                        $group.find('.help-block').remove();
                    }
                }         
            } else {
                // goes back to home
                window.location.replace("/");
            }

        }).fail(function (data) {
            console.log(data);
            Swal.fire({
                icon: 'error',
                title: 'Fatal Error...',
                text: 'Could not reach server! Try again!',
            }).then((result) => {
                // refreshs page
                window.location.reload(true);
            }); 
        });
    }

    deleteTask(taskId)
    {
        $.ajax({
            type: 'POST',
            url: '/',
            data: {
                action: 'delete',
                data: taskId,
            },
            dataType: 'json',
            encode: true,
        }).done(function() { 
            // reloads product-list     
            $('#item_' + taskId).remove();

        }).fail(function(response) {
            console.log(response);
            
            Swal.fire({
                icon: 'error',
                title: 'Fatal Error...',
                text: 'Could not reach server! Try again!',
            }).then((result) => {
                // refreshs page
                window.location.reload(true);
            }); 
        });
    }
}