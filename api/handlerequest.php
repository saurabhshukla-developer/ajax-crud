<?php
require 'employee.php';
$employee = new Employee();

/**
 * Switch Case for handling Requests and sending the data to specific methods
 */
switch($_SERVER['REQUEST_METHOD']){
    /**
     * Method to Get all employee, get single employee details and delete emaployee
     */
    case 'GET':
        if(isset($_GET['emp_id'])){
            if(isset($_GET['operation']) && $_GET['operation'] == 'delete'){
                $data = deleteEmployee($_GET['emp_id']);    
            } else {
                $data = fetchSingleEmployeeDetail($_GET['emp_id']);
            }
            echo json_encode($data);
        } else {
            $data = fetchAllEmployeeDetails();
            echo json_encode($data);
        }
        exit();

    /**
     * Method to Store and Update Employee Details
     */
    case 'POST':
        $data['name'] = $_POST['name'];
        $data['email'] = $_POST['email'];
        $data['mobile'] = $_POST['mobile'];
        $data['designation'] = $_POST['designation'];
        $data['salary'] = $_POST['salary'];
        if(isset($_POST['operation']) && $_POST['operation'] == 'update'){
            $data['id'] = $_POST['emp_id'];
            $data = updateEmployee($data);
            echo json_encode($data);
        } else {
            $data = storeEmployeeDetails($data);
            echo json_encode($data);
        }
        exit();
}


/**
 * @method fetchAllEmployeeDetails (Fetch all employee details)
 * @return array $data
 */
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

/**
 * @method fetchSingleEmployeeDetail (Fetch Single employee detail)
 * @return array $data
 */
function fetchSingleEmployeeDetail($id)
{
    global $employee;
    $employees = $employee->showSingleEmployee($id);
    if($employees == false){
        $data = [
            'status' => 'error',
            'message' => 'No data available'
        ];
    } else {
        $data = [
            'status' => 'success',
            'message' => 'Fetch Successful',
            'data' => $employees
        ];  
    }
    return $data;
}

/**
 * @method storeEmployeeDetails (Store employee detail)
 * @param array $data
 * @return array $data
 */
function storeEmployeeDetails($data)
{
    global $employee;
    $status = $employee->storeEmployeeDetails($data);
    if($status == false){
        $data = [
            'status' => 'error',
            'message' => 'Errot In Storing Employee'
        ];
    } else {
        $data = [
            'status' => 'success',
            'message' => 'Employee Added Successfully'
        ];  
    }
    return $data;
}

/**
 * @method updateEmployee (Update employee detail)
 * @param array $data
 * @return array $data
 */
function updateEmployee($data)
{
    global $employee;
    $status = $employee->updateEmployee($data);
    if($status == false){
        $data = [
            'status' => 'error',
            'message' => 'Errot In Updating Employee'
        ];
    } else {
        $data = [
            'status' => 'success',
            'message' => 'Employee Updated Successfully'
        ];  
    }
    return $data;
}

/**
 * @method deleteEmployee (Delete employee)
 * @param integer $empId
 * @return array $data
 */
function deleteEmployee($empId)
{
    global $employee;
    $status = $employee->deleteEmployee($empId);
    if($status == false){
        $data = [
            'status' => 'error',
            'message' => 'Errot In Deleting Employee'
        ];
    } else {
        $data = [
            'status' => 'success',
            'message' => 'Employee Deleted Successfully'
        ];  
    }
    return $data;
}