<?php

require 'db.php';

class Employee extends DBConnection{

    private $conn;

    public function __construct(){
        $instance = DBConnection::getInstance();
        $this->conn = $instance->getConnection();
    }

    public function listEmployee()
    {
        $sql = "select * from employees";
        $result = mysqli_query($this->conn,$sql);
        $row = mysqli_fetch_all($result,MYSQLI_ASSOC);
        return $row;
    }

    public function showSingleEmployee($empId)
    {
        $sql = "select * from employees where id = $empId";
        $result = mysqli_query($this->conn,$sql);
        $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
        if($row === null){
            return false;
        }
        return $row;
    }

    public function updateEmployee($data)
    {
        $sql = "update employees set name = '".$data['name']."', email = '".$data['email']."',mobile = '".$data['mobile']."',designation = '".$data['designation']."',salary = '".$data['salary']."' where id = ".$data['id']."";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteEmployee($empId)
    {
        $sql = "delete from employees where id = ".$empId;
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }
}

// $employee = new Employee();
// $data['id'] = 3;
// $data['name'] = 'Chnage User';
// $data['email'] = 'newemail1@gmail.com';
// $data['mobile'] = '2525252525';
// $data['designation'] = 'new desg';
// $data['salary'] = '85858585';

// print_r($employee->deleteEmployee(3));