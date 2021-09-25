<?php
require 'db.php';
require('config.php');
require('validation.php');
$instance = DBConnection::getInstance();
$conn = $instance->getConnection();
if(!isset($_SESSION)) 
{ 
    session_start(); 
}


// For Signup
if(isset($_POST['signup-submit'])){
    $name = filter_input_value($_POST["signup-name"]);
    $email = filter_input_value($_POST["signup-email"]);
    $password = filter_input_value($_POST["signup-password"]);
    $confpassword = filter_input_value($_POST["signup-conf-password"]);
    $contactnumber = filter_input_value($_POST["signup-contactnumber"]);
    $usertype = filter_input_value($_POST["signup-usertype"]);
    check_unique_email($email);
    validate_signup_form($name, $email, $password, $confpassword, $contactnumber, $usertype);
    user_signup($name, $email, $password, $contactnumber, $usertype);
}

// For Login
if(isset($_POST['login-submit'])){
    global $baseUrl;
    $validation = new validateInput();
    $data['email'] = filter_input_value($_POST["login-email"]);
    $data['password'] = filter_input_value($_POST["login-password"]);
    if(isset($_POST["rememberme"])){
        $data['rememberMe'] = filter_input_value($_POST["rememberme"]);
    }

    // Validate Email
    $email_validate = $validation->validateEmail($data['email']);
    if($email_validate !== true)
    {
        $_SESSION['errors']['login-email'] = $email_validate;
        header('Location: '.$baseUrl.'/login.php');
        exit();
    }
    user_login($data);
}

/**
 * @method loginViaCookie ( For User LogIn through Cookie)
 * @param array $data
 */
function loginViaCookie($data)
{
    global $conn;
    global $baseUrl;
    $userId = $data['user_id'];
    $cookie_value = $data['user_cookie_value'];
    $sql = "select * from users where id=$userId and cookie_value = '$cookie_value' and status = 1";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if(count($row) > 0){
        $_SESSION['userDetails'] = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'email' => $row['email'],
            'contact_number' => $row['contact_number'],
            'user_type' => $row['user_type'],
            'status' => $row['status'],
            'created_at' => $row['created_at']
        );
        header('Location: '.$baseUrl.'/dashboard.php');
        exit();
    } else {
        header('Location: '.$baseUrl.'/login.php');
        exit();
    }
}



/**
 * @method filter_input_value ( Filter Form Input Value)
 * @param string $data
 */
function filter_input_value($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/**
 * @method validate_signup_form ( Validate SignUp Form Values)
 * @param string $name
 * @param string $email
 * @param string $password
 * @param string $confpassword
 * @param integer $contactnumber
 * @param string $usertype
 */
function validate_signup_form($name, $email, $password, $confpassword, $contactnumber, $usertype)
{
    global $baseUrl;
    $validation = new validateInput();
    $validation_error_count = 0;
    $email_validate             = $validation->validateEmail($email);
    $password_validate          = $validation->validatePassword($password);
    $name_validate              = $validation->validateName($name);
    $contactnumber_validate     = $validation->validateContactNumber($contactnumber);

    if($email_validate !== true)
    {
        $validation_error_count++;
        $_SESSION['errors']['signup-email'] = $email_validate;
    }
    if($password_validate !== true)
    {
        $validation_error_count++;
        $_SESSION['errors']['signup-password'] = $password_validate;
    }
    if($name_validate !== true)
    {
        $validation_error_count++;
        $_SESSION['errors']['signup-name'] = $name_validate;
    }
    if($contactnumber_validate !== true)
    {
        $validation_error_count++;
        $_SESSION['errors']['signup-contactnumber'] = $contactnumber_validate;
    }
    if($password != $confpassword)
    {
        $validation_error_count++;
        $_SESSION['errors']['signup-conf-password'] = 'Password and Confirm Password do not match';
    }
    if(!in_array($usertype, ['employee', 'admin']))
    {
        $validation_error_count++;
        $_SESSION['errors']['signup-usertype'] = 'User Type can be either Employee or Admin';
    }
    
    if($validation_error_count > 0)
    {
        header('Location: '.$baseUrl.'/signup.php');
        exit();
    }
}

/**
 * @method user_login ( For User LogIn)
 * @param array $data
 */
function user_login($data)
{
    global $baseUrl;
    global $conn;
    $email = $data['email'];
    $password = $data['password'];
    $sql = "select * from users where email='$email' and status = 1";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if(($row !== null) && (count($row) > 0)){
        if (!password_verify($password, $row['password'])){
            $_SESSION['errors']['login-error'] = 'Incorrect Email Or Password';
            header('Location: '.$baseUrl.'/login.php');
            exit();
        } else {
            $_SESSION['userDetails'] = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'email' => $row['email'],
                'contact_number' => $row['contact_number'],
                'user_type' => $row['user_type'],
                'status' => $row['status'],
                'created_at' => $row['created_at']
            );
            if(isset($data['rememberMe'])){
                $bytes = random_bytes(20);
                $uniqueId = bin2hex($bytes);
                setcookie('user_id', $row['id'], time() + (86400 * 30), "/");
                setcookie('user_cookie_value', $uniqueId, time() + (86400 * 30), "/");
                $sql = "UPDATE users set cookie_value = '$uniqueId' where id = ".$row['id']."";
                $conn->query($sql);
            }
            header('Location: '.$baseUrl.'/dashboard.php');
            exit();
        }
        // print_r($row[0]['password']);
    } else {
        $_SESSION['errors']['login-error'] = 'Incorrect Email Or Password';
        header('Location: '.$baseUrl.'/login.php');
        exit();
    }
}

/**
 * @method user_signup ( For User SignUp)
 * @param string $name
 * @param string $email
 * @param string $password
 * @param string $contactnumber
 * @param string $usertype
 */
function user_signup($name, $email, $password, $contactnumber, $usertype)
{
    global $baseUrl;
    global $conn;
    $secure_pass = password_hash($password, PASSWORD_BCRYPT);
    $sql = "INSERT INTO users (`name`, `email`, `password`, `contact_number`, `user_type`)
            VALUES ('$name', '$email', '$secure_pass', '$contactnumber', '$usertype')";
    if ($conn->query($sql) === TRUE) {
        $last_id = $conn->insert_id;
        $_SESSION['userDetails'] = array(
            'id' => $last_id,
            'name' => $name,
            'email' => $email,
            'contact_number' => $contactnumber,
            'user_type' => $usertype,
            'status' => 1
        );
        header('Location: '.$baseUrl.'/dashboard.php');
        exit();
    } else {
        header('Location: '.$baseUrl.'/login.php');
        exit();
    }
}

/**
 * @method check_unique_email ( Check if Email is Unique while signup)
 * @param string $email
 */
function check_unique_email($email)
{
    global $baseUrl;
    global $conn;
    $sql = "select * from users where email='$email'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);
    if(($row !== null) && (count($row) > 0)){
        $_SESSION['errors']['signup-email'] = 'This email is already registered';
        header('Location: '.$baseUrl.'/signup.php');
        exit();
    }
}

?>
