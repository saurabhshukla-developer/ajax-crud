$(document).ready(function()
{
    var baseURL = "https://saurabh.localproject/personal/interview/secondquestion/";
    var all_employee_details = '';
    showAllEmployee();
    
    $('#btn-add-employee-modal').click(function()
    {
        $('#add-employee-form').trigger("reset");
        $('.modal-title').text('Add New Employee');
        $('.button-add-edit').text('Save');
        $('#add-employee-form').attr('action', baseURL+"api/handlerequest.php");
        $('input[name=operation]').val('add');
        $('input[name=id]').val('');
    });

    $(document).on("click",".edit-employee",function()
    {
        $('#add-employee-form').trigger("reset");
        $('.modal-title').text('Edit Employee Details');
        $('.button-add-edit').text('Save');
        $('#add-employee-form').attr('action', baseURL+"api/handlerequest.php");
        $('input[name=operation]').val('update');

        // Add values in form
        index = $(this).attr('data-index');
        $('input[name=emp_id]').val(all_employee_details[index].id);
        $('input[name=name]').val(capitalizeFirstLetter(all_employee_details[index].name));
        $('input[name=email]').val(all_employee_details[index].email);
        $('input[name=mobile]').val(all_employee_details[index].mobile);
        $('input[name=salary]').val(all_employee_details[index].salary);
        $('select[name=designation]').val(all_employee_details[index].designation);
    });

    $(document).on('click','.button-add-edit', function(e)
    {
        e.preventDefault();

        var name = $.trim($('input[name=name]').val());
        var email = $('input[name=email]').val();
        var mobile = $('input[name=mobile]').val();
        var salary = $('input[name=salary]').val();
        var designation = $('select[name=designation]').val();
        var errors = {};
        error_display = ['name_error', 'email_error', 'salary_error', 'mobile_error', 'designation_error'];
        for(let i=0; i<error_display.length; i++)
        {
            $('#'+error_display[i]).text('');
        }

        if(!name)
        {
            errors['name_error'] = 'Please Enter Valid Name';
        }
        if(!email)
        {
            errors['email_error'] = 'Please Enter Valid Email';
        }
        if(mobile.length == 0 || mobile.length != 10)
        {
            errors['mobile_error'] = 'Mobile Number should be 10 digits long';
        }
        if(!salary)
        {
            errors['salary_error'] = 'Please Enter Valid Salary';
        }
        if(!designation)
        {
            errors['designation_error'] = 'Please Enter Valid Designation';
        }
        if(!$.isEmptyObject(errors))
        {
            $.each(errors, function (i){
                $('#'+i).text(errors[i]);
            });
            errors = {};
            return;
        }

        var url = $('#add-employee-form').attr('action');
        var operation = $('input[name=operation]').val();
        var form_id = $('#add-employee-form');
        var data =  $('#add-employee-form').serialize();
        $.ajax({
            method: "post",
            url: url,
            data: data,
            async: false,
            dataType: 'json',
            success: function(response)
            {
                $( "#close-modal" ).trigger( "click" );
                showAllEmployee();
                if(operation == 'update')
                {
                    swal("Poof!", "Employee has been updated successfully", "success");
                }
                else{
                    swal("Poof!", "Employee has been added successfully", "success");
                }
            },
            error: function()
            {
                $( "#close-modal" ).trigger( "click" );
                if(operation == 'update')
                {
                    swal("oops!", "Could not update Employee, try adding again", "error");
                }
                else
                {
                    swal("oops!", "Could not add Employee, try adding again", "error");
                }
            } 
        });
    });

    $(document).on('click','.delete-btn', function()
    {
        var employee_id = $(this).attr('data-id');				
        url = baseURL+"api/handlerequest.php";
        swal({
            title: "Are you sure?",
            text: "Once deleted, you will not be able to recover Employee!",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        })
        .then((willDelete) => 
        {
            if (willDelete) 
            {
                $.ajax({
                    method: 'get',
                    url: url,
                    data: {emp_id: employee_id, operation:'delete'},
                    success: function(response)
                    {
                        swal("Poof!", "Employee has been deleted successfully", "success");
                        showAllEmployee();	
                    },
                    error: function()
                    {
                        swal("oops!", "Could not delete Employee data", "error");
                    } 
                });
            }
        });
    });

    function showAllEmployee()
    {
        $.ajax({
            type: 'get',
            url: 'api/handlerequest.php',
            async: false,
            dataType: 'json',
            success: function(response){
                if(response.status != 'success') {
                    swal("oops!", response.message, "error");
                }
                else if(response.data == '')
                {
                    $('#employee-data-tbody').html('<tr class="text-center"><td colspan="7">No data found</td></tr>');
                }
                else {
                    var employee_detail = '';
                    all_employee_details = employee_details = response.data;

                    for(i=0; i<employee_details.length; i++)
                    {
                        employee_detail += 
                                `<tr>
                                    <td>`+(i+1)+`</td>
                                    <td>`+capitalizeFirstLetter(employee_details[i].name)+`</td>
                                    <td>`+employee_details[i].email+`</td>
                                    <td>`+employee_details[i].mobile+`</td>
                                    <td>`+capitalizeFirstLetter(employee_details[i].designation)+`</td>
                                    <td>`+employee_details[i].salary+` LPA</td>
                                    <td>
                                        <a data-id="`+employee_details[i].id+`" data-index="`+i+`" class="btn btn-sm btn-info edit-employee" href="#add_employee" data-toggle="modal">
                                            Edit
                                        </a>
                                        <button data-id="`+employee_details[i].id+`"  data-index="`+i+`" class="btn btn-sm btn-danger delete-btn">
                                            Delete
                                        </button>
                                    </td>
                                </tr>`;
                    }
                    $('#employee-data-tbody').html(employee_detail);
                }           
            },
            error: function(){
                $('#employee-data-tbody').html('Some error occurred, please try again in some time');
            }
        });
    }

    function capitalizeFirstLetter(string){
        return string.charAt(0).toUpperCase() + string.slice(1);
    }

});