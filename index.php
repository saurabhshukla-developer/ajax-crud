<?php session_start(); 
require('component/config.php');
require('component/myfunctions.php');
if(!isset($_SESSION['userDetails'])){
    header('Location: '.$baseUrl.'/login.php');
    exit();
}
?>
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
    <!-- header Nav Tabs -->
    <header class="bg-light">
        <nav class="container">
            <ul class="nav nav-tabs pt-3 border-0">
                <li class="nav-item">
                    <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home" aria-selected="true">
                        Home
                    </a>
                </li>
                <?php if($_SESSION['userDetails']['user_type'] == 'admin'){ ?>
                    <li class="nav-item">
                        <a class="nav-link" id="users-tab" data-toggle="tab" href="#all-users" role="tab" aria-controls="all-users" aria-selected="false">
                            Users
                        </a>
                    </li>
                <?php } ?>
                <li class="nav-item ml-auto">
                    <a class="nav-link text-danger" href="logout.php">Logout</a>
                </li>
            </ul>
        </nav>
    </header>

    <section class="container mt-5">
        <div class="tab-content" id="tab-content-div">
            <div class="tab-pane fade show active table-responsive"  id="home" role="tabpanel" aria-labelledby="home-tab">
                <h2 class="mb-0">Personal Details</h2>
                <hr>
                <table class="table table-striped table-bordered">
                    <thead class="thead-light">
                        <tr>
                        <th scope="col">S.No</th>
                        <th scope="col">Column Name</th>
                        <th scope="col">Value</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 1; foreach ($_SESSION['userDetails'] as $key => $value) { ?>
                            <tr>
                                <th scope="row"><?php echo $i;?></th>
                                <td><?php echo $key; ?></td>
                                <td><?php echo $value; ?></td>
                            </tr>
                        <?php $i++; } ?>
                        
                    </tbody>
                </table>
            </div>
            <div class="tab-pane fade table-responsive" id="all-users" role="tabpanel" aria-labelledby="users-tab">
                <?php if($_SESSION['userDetails']['user_type'] == 'admin'){ ?>
                    <h2 class="mb-0">All Users</h2>
                    <hr>
                    <table class="table table-striped table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">S.No</th>
                                <th scope="col">Name</th>
                                <th scope="col">Contact Number</th>
                                <th scope="col">Email</th>
                                <th scope="col">User Type</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $userDetails = getAllUserDetails(); $i = 1; foreach ($userDetails as $userDetail) { ?>
                                <tr>
                                    <th scope="row"><?php echo $i; ?></th>
                                    <td><?php echo $userDetail['name']; ?></td>
                                    <td><?php echo $userDetail['contact_number']; ?></td>
                                    <td><?php echo $userDetail['email']; ?></td>
                                    <td><?php echo ucfirst($userDetail['user_type']); ?></td>
                                </tr>
                            <?php $i++; } ?>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>
    </section>
    
</body>
</html>