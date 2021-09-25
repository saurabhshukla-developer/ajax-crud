<?php
    $baseURL = 'https://saurabh.localproject/personal/interview/secondquestion/';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
                    <a class="btn btn-primary" href="<?php echo $baseURL;?>api/exporttoxls.php">
                        Export To .XLS
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
                                            <span id="name_error" class="text-danger"></span>
                                        </div>
                                        <div class="col-md-4 form-group">
                                            <label for="email">Email</label><span class="text-danger">*</span>
                                            <input name="email" type="email" class="form-control" placeholder="employee@company.com" required>
                                            <span id="email_error" class="text-danger"></span>
                                        </div>      
                                        <div class="col-md-4 form-group">
                                            <label for="mobile">Mobile</label><span class="text-danger">*</span>
                                            <input name="mobile" type="text" class="form-control" placeholder="+91" required>
                                            <span id="mobile_error" class="text-danger"></span>
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
                                            <span id="designation_error" class="text-danger"></span>
                                        </div>         
                                        <div class="col-md-4 form-group">
                                            <label for="salary">Salary</label><span class="text-danger">*</span>
                                            <input name="salary" type="number" class="form-control" placeholder="6" required>
                                            <small class="font-italic">Lakhs Per Anum(INR)</small>
                                            <span id="salary_error" class="text-danger"></span>
                                        </div>                        
                                    </div>
                                    <input type="hidden" name="operation">
                                    <input type="hidden" name="emp_id">
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
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="myscript.js"></script>
</body>
</html>