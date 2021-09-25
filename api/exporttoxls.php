<?php
require 'employee.php';
$employee = new Employee();
$employees = $employee->listEmployee();

$html = "<table><tr><td>S.No</td><td>Id</td><td>Name</td><td>Email</td><td>mobile</td><td>Designation</td><td>Salary</td><td>Created At</td></tr>";
$sno = 1;
foreach ($employees as $key => $value) {
    $html.= "<tr><td>".$sno."</td><td>".$value['id']."</td><td>".$value['name']."</td><td>".$value['email']."</td><td>".$value['mobile']."</td><td>".$value['designation']."</td><td>".$value['salary']."</td><td>".$value['created_at']."</td></tr>";
    $sno++;
}
$html.="</table>";
header("Content-type:application/xls");
header("Content-Disposition: attachment;filename=employeedata.xls");
echo $html;
