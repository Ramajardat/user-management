<?php

$servername = "localhost";
$username = "root";
$password = "root";

try {
    $conn = new PDO("mysql:host=$servername;dbname=user", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
    if (isset($_POST['register'])) {
        $stmt = $conn->prepare("INSERT INTO
            users (fullname,email,password,cpassword,mobile,birth,role)
            VALUES (:n,:e ,:p ,:cp ,:m,:b,:r)");
        $stmt->bindParam(':n', $fullname);
        $stmt->bindParam(':e', $email);
        $stmt->bindParam(':p', $password);
        $stmt->bindParam(':cp', $cpassword);
        $stmt->bindParam(':m', $mobile);
        $stmt->bindParam(':b', $birth);
        $stmt->bindParam(':r', $role);



        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $mobile = $_POST['mobile'];
        $birth = $_POST['birth'];
        $role = $_POST['role'];



        $stmt->execute();
        header("Location: welcome.php");
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}






// by default, error messages are empty
$valid = $fnameErr = $emailErr = $passErr = $cpassErr = $birthErr = $mobileErr = '';

// by default,set input values are empty
$set_fullName  = $set_email = '';
extract($_POST);

if (isset($_POST['register'])) {

    //input fields are Validated with regular expression
    $validName = "/^[a-zA-Z ]*$/";
    $validEmail = "/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/";
    $uppercasePassword = "/(?=.*?[A-Z])/";
    $lowercasePassword = "/(?=.*?[a-z])/";
    $digitPassword = "/(?=.*?[0-9])/";
    $spacesPassword = "/^$|\s+/";
    $symbolPassword = "/(?=.*?[#?!@$%^&*-])/";
    $minEightPassword = "/.{8,}/";
    $mobileV = "/^(\+\d{1,3}[- ]?)?\d{14}$/";
    $datev = "/(((0|1)[0-9]|2[0-9]|3[0-1])\/(0[1-9]|1[0-2])\/((19|20)\d\d))$/";



    //  First Name Validation
    if (empty($fullname)) {
        $fnameErr = "First Name is Required";
    } else if (!preg_match($validName, $fullname)) {
        $fnameErr = "Digits are not allowed";
    } else {
        $fnameErr = true;
    }



    //Email Address Validation
    if (empty($email)) {
        $emailErr = "Email is Required";
    } else if (!preg_match($validEmail, $email)) {
        $emailErr = "Invalid Email Address";
    } else {
        $emailErr = true;
    }

    // password validation 
    if (empty($password)) {
        $passErr = "Password is Required";
    } elseif (!preg_match($uppercasePassword, $password) || !preg_match($lowercasePassword, $password) || !preg_match($digitPassword, $password) || !preg_match($symbolPassword, $password) || !preg_match($minEightPassword, $password) || preg_match($spacesPassword, $password)) {
        $passErr = "Password must be at least one uppercase letter, lowercase letter, digit, a special character with no spaces and minimum 8 length";
    } else {
        $passErr = true;
    }

    // form validation for confirm password
    if ($cpassword != $password) {
        $cpassErr = "Confirm Password doest Matched";
    } else {
        $cpassErr = true;
    }

    if (empty($mobile)) {
        $mobileErr = "Mobile is Required";
    } else if (!preg_match($mobileV, $mobile)) {
        $mobileErr = "Digits are not allowed";
    } else {
        $mobileErr = true;
    }

    //
    if (empty($birth)) {
        $birthErr = "Date of birth is Required";
    } else if (!preg_match($datev, $birth)) {
        $birthErr = "Eligibility 16 years ONLY";
    } else {
        $birthErr = true;
    }


    // check all fields are valid or not
    if ($fnameErr == 1 && $lnameErr == 1 && $emailErr == 1 && $passErr == 1 && $cpassErr == 1 && $birthErr == 1 &&  $mobileErr == 1) {
        $valid = "All fields are validated successfully";



        //legal input values
        $firstName = legal_input($first_name);
        $email =     legal_input($email);
        $password =  legal_input($password);


        // here you can write Sql Query to insert user data into database table
    } else {
        // set input values is empty until input field is invalid
        $set_firstName = $first_name;
        $set_email =    $email;
    }
}


// convert illegal input value to ligal value formate
function legal_input($value)
{
    $value = trim($value);
    $value = stripslashes($value);
    $value = htmlspecialchars($value);
    return $value;
}
if (isset($_POST['login'])) {
    $stmt = $conn->query("SELECT * FROM users WHERE email='$email' ");

    $user = $stmt->fetchAll();
    print_r($user);
    // header("Location: welcome.php");
    if (count($user) > 0) {
        if ($user[0]['role'] == 1) {
            header("Location: admin.php");
        } elseif ($user[0]['role'] == 2) {
            header("Location: welcome.php");
        }
    }
}
