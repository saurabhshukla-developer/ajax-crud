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
                        <th>Salary</th>
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
                                <form action="" method="post" id="add-employee-form" accept-charset="utf-8">
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
                                                <option value="Manager">Manager</option>
                                                <option value="Team Lead">Team Lead</option>
                                                <option value="Senior Developer">Senior Developer</option>
                                                <option value="Junior Developer">Junior Developer</option>
                                                <option value="Intern" selected>Intern</option>
                                            </select>
                                        </div>         
                                        <div class="col-md-4 form-group">
                                            <label for="salary">Salary</label><span class="text-danger">*</span>
                                            <input name="salary" type="number" class="form-control" placeholder="6" required>
                                            <small class="font-italic">Lakhs Per Anum(INR)</small>
                                        </div>                        
                                    </div>
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
            showAllEmployee();
            
            $('#btn-add-employee-modal').click(function()
            {
                $('.modal-title').text('Add New Employee');
                $('.button-add-edit').text('Save');
                $('#add-employee-form').attr('action', "#");
            });

            $(document).on("click",".edit-employee",function()
            {
                console.log('clicked');
                $('.modal-title').text('Edit Employee Details');
                $('.button-add-edit').text('Save');
                $('#add-employee-form').attr('action', "#");
            });

            $(document).on('click','.button-add-edit', function(e)
            {
                e.preventDefault();
                var url = $('#add-employee-form').attr('action');
                console.log(url);
                var form_id = $('#add-employee-form');
                var data =  $('#add-employee-form').serialize();
                console.log(data);
                $.ajax({
                    method: 'post',
                    url: url,
                    data: data,
                    // async: false,
                    // dataType: 'json',
                    success: function(response)
                    {
                        $( "#close-modal" ).trigger( "click" );			
                        showAllEmployee();	
                        swal("Poof!", "Employee has been added successfully", "success");
                        // $('#add_room').hide();
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
                var guestid = $(this).val();				
                console.log(guestid);
                url = "";
                console.log(url);
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
                        $.ajax
                        ({
                            method: 'post',
                            url: url,
                            data: {id: guestid},
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
                // $.ajax({
                //     type: 'post',
                //     url: 'https://technologyrevision.com/pgmanager/PG_Guests/employee_details',
                //     async: false,
                //     dataType: 'json',
                //     success: function(data){
                //         console.log(data);
                        var employee_detail = '';
                //         var pg_detail = '';
                //         var floor_detail = '';
                //         var i;
                //         $('#all-contacts').find('input').remove();
                //         employee_details = data.employee_details;
                        employee_details = [
                            {
                                name:           "Amisha Jain",
                                email:          "jainamisha566@gmail.com",
                                mobile:         "8959471500",
                                designation:    "Senior Developer",
                                salary:         "6 LPA"
                            },
                            {
                                name:           "Saurabh Shukla",
                                email:          "saurabhshukla.developer@gmail.com",
                                mobile:         "9119145983",
                                designation:    "Manager",
                                salary:         "16 LPA"
                            },
                            {
                                name:           "Amisha Only",
                                email:          "amishaonly@gmail.com",
                                mobile:         "7845128956",
                                designation:    "Intern",
                                salary:         "2.5 LPA"
                            },
                            {
                                name:           "Saurabh Only",
                                email:          "saurabhonly@gmail.com",
                                mobile:         "4845128956",
                                designation:    "Junior Developer",
                                salary:         "3.5 LPA"
                            }
                        ];


                        for(i=0; i<employee_details.length; i++)
                        {
                            console.log(employee_details[i].c_name);
                            employee_detail += 
                                    `<tr>
                                        <td>`+(i+1)+`</td>
                                        <td>`+employee_details[i].name+`</td>
                                        <td>`+employee_details[i].email+`</td>
                                        <td>`+employee_details[i].mobile+`</td>
                                        <td>`+employee_details[i].designation+`</td>
                                        <td>`+employee_details[i].salary+`</td>
                                        <td>
                                            <a data-id="`+employee_details[i].id+`" class="btn btn-sm btn-info edit-employee" href="#add_employee" data-toggle="modal">
                                                Edit
                                            </a>
                                            <button data-id="`+employee_details[i].id+`" class="btn btn-sm btn-danger delete-btn">
                                                Delete
                                            </button>
                                        </td>
                                    </tr>`;
                            $('#all-contacts').append('<input type="hidden" name="all_contact_input[]" value="'+employee_details[i].mobile+'">');
                        }
                        $('#employee-data-tbody').html(employee_detail);                        
                //     },
                //     error: function(){
                //         swal("oops!", "Could not get data", "error");
                //     }
                // });
            }
        });
    </script>
</body>
</html>