<?php
require 'db.php';

class Employee extends DBConnection{

    private $conn;

    public function __construct(){
        $instance = DBConnection::getInstance();
        $this->conn = $instance->getConnection();
    }

    /**
     * @method listEmployee (List all employee details)
     * @return array $row
     */
    public function listEmployee()
    {
        $sql = "select * from employees order by created_at desc";
        $result = mysqli_query($this->conn,$sql);
        $row = mysqli_fetch_all($result,MYSQLI_ASSOC);
        return $row;
    }

    /**
     * @method showSingleEmployee (Show single employee details)
     * @return array $row
     */
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

    /**
     * @method storeEmployeeDetails (Store Employee Details)
     * @param array $data 
     * @return boolean
     */
    public function storeEmployeeDetails($data)
    {
        $sql = "insert into employees (name, email, mobile, designation, salary) values ('".$data['name']."','".$data['email']."','".$data['mobile']."','".$data['designation']."','".$data['salary']."');";
        if($this->conn->query($sql) === TRUE){
            return true;
        } else {
            return false;
        }
    }

    
    /**
     * @method updateEmployee (Update Employee Details)
     * @param array $data 
     * @return boolean
     */
    public function updateEmployee($data)
    {
        $sql = "update employees set name = '".$data['name']."', email = '".$data['email']."',mobile = '".$data['mobile']."',designation = '".$data['designation']."',salary = '".$data['salary']."' where id = ".$data['id']."";
        if ($this->conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @method deleteEmployee (Delete Employee Details)
     * @param array $empId 
     * @return boolean
     */
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
