<?php
require 'employee.php';
$employee = new Employee();

switch($_SERVER['REQUEST_METHOD']){
    case 'GET':
        if(isset($_GET['emp_id'])){
            echo $_GET['emp_id'];
        } else {
            $data = fetchAllEmployeeDetails();
            echo json_encode($data);
            exit();
        }
        exit();
    case 'POST':
        echo 'post';
        exit();
    case 'PUT':
        echo 'put';
        exit();
    case 'DELETE':
        echo 'delete';
        exit();
}

function fetchAllEmployeeDetails()
{
    global $employee;
    $employees = $employee->listEmployee();
    $data = [
        'status' => 'success',
        'message' => 'Fetch Successful',
        'data' => $employees
    ];
    return $data;
}