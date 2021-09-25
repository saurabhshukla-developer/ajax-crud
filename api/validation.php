<?php
class validateInput{
    public function validateEmail($email)
    {
        return (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) ? true : 'Please Enter Valid Email';
    }

    public function validatePassword($password)
    {
        // case sensitive ->
        // \W - special character
        // \s - whitespace
        // [0-9] - number
        // [a-z] - small letter
        // [A-Z] - captial letter

        if (strlen($password) <= 8) 
        {
            return "Length of your password must be greater than 8";
        }
        elseif( !preg_match("#[0-9]+#", $password) || 
                !preg_match("#[A-Z]+#", $password) || 
                !preg_match("#[a-z]+#", $password) ||
                !preg_match("#\W+#", $password)
        )
        {
            return "Password must contain at least one uppercase letter, one lowercase letter, one special symbol, and one number";
        } 
        else if(preg_match("#\s+#", $password))
        {
            return "Password must not contain any whitespaces";
        }
        else
        {
            return true;
        }
    }

    public function validateName($name)
    {
        return (preg_match ("/^[a-zA-z]*$/", $name) ) ? true : 'Name must be alphabet only.';
    }

    public function validateContactNumber($contactNumber)
    {
        if (strlen($contactNumber) != 10) 
        {
            return "Contact Number must be 10 digits long";
        }
        if(!preg_match('/^[1-9][0-9]*$/',$contactNumber)) // phone number is valid
        {
           return "Contact Number must only contain digits and should not start with 0";
        }
        return true;
    }
}
