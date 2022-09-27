<?php
require_once 'validation-script.php';

if (isset($_POST['update'])) {
    // Get the userid
    $userid = $_GET['id'];
    // Posted Values  
    $fname = $_POST['fullname'];
    $Email = $_POST['email'];
    $Birthday = $_POST['birth'];
    $role = $_POST['role'];
    $Mobile = $_POST['mobile'];
    $Password = $_POST['password'];

    // Query for Query for Updation
    $sql = "update users set fullname=:fn,email=:em,birth=:br,role=:ro,mobile=:mo,password=:pas where email='$userid'";
    //Prepare Query for Execution
    $query = $conn->prepare($sql);
    // Bind the parameters
    $query->bindParam(':br', $Birthday, PDO::PARAM_STR);
    $query->bindParam(':fn', $fname, PDO::PARAM_STR);
    $query->bindParam(':em', $Email, PDO::PARAM_STR);
    $query->bindParam(':ro', $role, PDO::PARAM_STR);
    $query->bindParam(':mo', $Mobile, PDO::PARAM_STR);
    $query->bindParam(':pas', $Password, PDO::PARAM_STR);
    // Query Execution
    $query->execute();
    // Mesage after updation
    echo "<script>alert('Record Updated successfully');</script>";
    // Code for redirection
    echo "<script>window.location.href='admin.php'</script>";
}

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Add New User</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>

<body>

    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <h3>Update user Information</h3>
                <hr />
            </div>
        </div>

        <?php
        // Get the userid
        $userid = $_GET['id'];
        $sql = "SELECT role,fullname,email,mobile,birth,password from users where email=:uid";
        //Prepare the query:
        $query = $conn->prepare($sql);
        //Bind the parameters
        $query->bindParam(':uid', $userid, PDO::PARAM_STR);
        //Execute the query:
        $query->execute();
        //Assign the data which you pulled from the database (in the preceding step) to a variable.
        $results = $query->fetchAll(PDO::FETCH_OBJ);
        //In case that the query returned at least one record, we can echo the records within a foreach loop:
        foreach ($results as $result) {

        ?>

            <form name="insertrecord" method="post">
                <div class="row">
                    <div class="col-md-4"><b>Full Name</b>
                        <input type="text" name="fullname" value="<?php echo htmlentities($result->fullname); ?>" class="form-control" required>
                    </div>
                    <div class="col-md-4"><b>Email</b>
                        <input type="text" name="email" class="form-control" value="<?php echo htmlentities($result->email); ?>" required>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4"><b>Birthday</b>
                        <input type="text" name="birth" class="form-control" value="<?php echo htmlentities($result->birth); ?>" required>
                    </div>
                    <div class="col-md-4"><b>role</b>
                        <select name="role" class="form-control" id="role" value="<?php echo htmlentities($result->role); ?>">
                            <option value="2">2</option>
                            <option value="1">1</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-4"><b>Mobile</b>
                        <input type="text" name="mobile" class="form-control" value="<?php echo htmlentities($result->mobile); ?>" required>
                    </div>


                    <div class="col-md-4"><b>Password</b>
                        <input type="text" name="password" class="form-control" value="<?php echo htmlentities($result->password); ?>" required>
                    </div>
                </div>

                <div class="row" style="margin-top:1%">
                    <div class="col-md-8">
                        <input type="submit" name="update" value="Update" style="width:100%">
                    </div>
                </div>

            </form>
        <?php } ?>
        <script async src="//pagead2.googlesyndication.com/pagead/js/adsbygoogle.js"></script>
        <!-- textaddneww -->
        <ins class="adsbygoogle" style="display:inline-block;width:728px;height:15px" data-ad-client="ca-pub-8906663933481361" data-ad-slot="3318815534"></ins>
    </div>
    </div>
</body>

</html>