<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <?php 
        require('assets/bootstrap/bootstraplib.php');
    ?>
</head>
<body>
    <!-- header -->
    <header class="bg-light text-center p-3">
        <h4>Task 2 - Employee CRUD Using Ajax</h4>
    </header>

    <section class="container my-5">
        <div class="table-responsive">
            <div style="display:flex;">
                <h2 class="mb-0">Employee List</h2>
                <div class="ml-auto">
                    <a class="btn btn-primary" id="btn-add-employee-modal" href="#add_employee" data-toggle="modal">
                        Add Employee
                    </a>
                    <a class="btn btn-primary" href="">
                        Export To .CSV
                    </a>
                </div>
            </div>
            <hr class="mt-2">
            <table class="table table-striped table-bordered">
                <thead class="thead-light">
                    <tr>
                        <th scope="col">S.No</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Mobile</th>
                        <th>Designation</th>
                        <th>Salary(INR)</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="employee-data-tbody">
                    
                </tbody>
            </table>
        </div>
    </section>

    <div class="modal fade" id="add_employee" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document" style="overflow-y: initial !important">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal_label">New Employee Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" style="max-height:400px; overflow-y:auto;">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12 pt-2 mb-1" style="height:fit-content;">
                                <form action="" method="" id="add-employee-form" accept-charset="utf-8">
                                    <div class="row">
                                        <div class="col-md-4 form-group">
                                            <label for="name">Name</label><span class="text-danger">*</span>
                                            <input name="name" type="text" class="form-control" placeholder="Employee Name" required>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="email">Email</label><span class="text-danger">*</span>
                                            <input name="email" type="email" class="form-control" placeholder="employee@company.com" required>
                                        </div>      
                                        <div class="col-md-4 form-group">
                                            <label for="mobile">Mobile</label><span class="text-danger">*</span>
                                            <input name="mobile" type="text" class="form-control" placeholder="+91" required>
                                        </div>              
                                        <div class="col-md-4 form-group">
                                            <label for="designation">Designation</label><span class="text-danger">*</span>
                                            <select class="form-control" name="designation" required>
                                                <option value="manager">Manager</option>
                                                <option value="team lead">Team Lead</option>
                                                <option value="senior developer">Senior Developer</option>
                                                <option value="junior developer">Junior Developer</option>
                                                <option value="intern" selected>Intern</option>
                                            </select>
                                        </div>         
                                        <div class="col-md-4 form-group">
                                            <label for="salary">Salary</label><span class="text-danger">*</span>
                                            <input name="salary" type="number" class="form-control" placeholder="6" required>
                                            <small class="font-italic">Lakhs Per Anum(INR)</small>
                                        </div>                        
                                    </div>
                                    <input type="hidden" name="operation">
                                    <input type="hidden" name="id">
                                </form>
                            </div>
                        </div> <!--row end-->
                    </div> <!--container end-->
                </div>
                <div class="modal-footer">
                    <button type="button" id="close-modal" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary button-add-edit">
                        Save
                    </button>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script>
        $(document).ready(function()
        {
            var all_employee_details = '';
            showAllEmployee();
            
            $('#btn-add-employee-modal').click(function()
            {
                $('#add-employee-form').trigger("reset");
                $('.modal-title').text('Add New Employee');
                $('.button-add-edit').text('Save');
                $('#add-employee-form').attr('action', "http://localhost/saurabh/ajax-crud/api/handlerequest.php");
                $('input[name=operation]').val('add');
                $('input[name=id]').val('');
            });

            $(document).on("click",".edit-employee",function()
            {
                $('#add-employee-form').trigger("reset");
                console.log('clicked');
                $('.modal-title').text('Edit Employee Details');
                $('.button-add-edit').text('Save');
                $('#add-employee-form').attr('action', "http://localhost/saurabh/ajax-crud/api/handlerequest.php");
                $('input[name=operation]').val('edit');

                index = $(this).attr('data-index');
                console.log(index);
                $('input[name=id]').val(all_employee_details[index].id);
                $('input[name=name]').val(capitalizeFirstLetter(all_employee_details[index].name));
                $('input[name=email]').val(all_employee_details[index].email);
                $('input[name=mobile]').val(all_employee_details[index].mobile);
                $('input[name=salary]').val(all_employee_details[index].salary);
                $('select[name=designation]').val(all_employee_details[index].designation);
            });

            $(document).on('click','.button-add-edit', function(e)
            {
                e.preventDefault();
                var url = $('#add-employee-form').attr('action');
                var operation = $('input[name=operation]').val();
                console.log(url);
                var form_id = $('#add-employee-form');
                var data =  $('#add-employee-form').serialize();
                console.log(data);
                $.ajax({
                    method: "post",
                    url: url,
                    data: data,
                    async: false,
                    dataType: 'json',
                    success: function(response)
                    {
                        console.log('response : ', response);
                        $( "#close-modal" ).trigger( "click" );
                        showAllEmployee();
                        if(operation == 'edit')
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
                        swal("oops!", "Could not add Employee, try adding again", "error");
                    } 
                });
            });

            $(document).on('click','.delete-btn', function()
            {
                var employee_id = $(this).attr('data-id');				
                console.log(employee_id);
                url = "http://localhost/saurabh/ajax-crud/api/handlerequest.php";
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
                            data: {id: employee_id, operation:'delete'},
                            success: function(response)
                            {
                                console.log('delete response : ',response);
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
                    url: 'http://localhost/saurabh/ajax-crud/api/handlerequest.php',
                    async: false,
                    dataType: 'json',
                    success: function(response){
                        console.log(response);
                        if(response.status != 'success') {
                            swal("oops!", response.message, "error");
                        }
                        else if(response.data == '')
                        {
                            swal("oops!", 'No Data Found', "warning");
                        }
                        else {
                            var employee_detail = '';
                            all_employee_details = employee_details = response.data;
                            console.log(employee_details);

                            for(i=0; i<employee_details.length; i++)
                            {
                                console.log(employee_details[i].id);
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
                        swal("oops!", "Could not get data", "error");
                    }
                });
            }
            console.log('sfsjfkd : ',all_employee_details);


            function capitalizeFirstLetter(string){
                return string.charAt(0).toUpperCase() + string.slice(1);
            }

        });
    </script>
</body>
</html>