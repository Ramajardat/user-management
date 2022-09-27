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
            users (fullname,email,password,cpassword,mobile,birth)
            VALUES (:n,:e ,:p ,:cp ,:m,:b)");
        $stmt->bindParam(':n', $fullname);
        $stmt->bindParam(':e', $email);
        $stmt->bindParam(':p', $password);
        $stmt->bindParam(':cp', $cpassword);
        $stmt->bindParam(':m', $mobile);
        $stmt->bindParam(':b', $birth);


        $fullname = $_POST['fullname'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        $mobile = $_POST['mobile'];
        $birth = $_POST['birth'];


        $stmt->execute();
        header("Location: welcome.php");
    }
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
