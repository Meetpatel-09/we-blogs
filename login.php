<?php
$title = "Log In";

require_once "config.php";

include("master_pages/header.php");

$email_error = $password_error = "";

$email = $password = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {


    if (empty(trim($_POST['email']))) {
        $email_error = "Please enter your email";
    } else {
        $email = $_POST['email'];
    }


    if (empty(trim($_POST['password']))) {
        $password_error = "Please enter your password";
    } else {
        $password = $_POST['password'];
    }


    if (empty($email_error) and empty($password_error)) {

        $sql = "SELECT id, email, password FROM user_tbl WHERE email = ?";

        $stmt = mysqli_prepare($conn, $sql);

        mysqli_stmt_bind_param($stmt, 's', $param_email);

        $param_email = $email;

        if (mysqli_stmt_execute($stmt)) {

            mysqli_stmt_store_result($stmt);

            if (mysqli_stmt_num_rows($stmt) == 1) {

                mysqli_stmt_bind_result($stmt, $id, $email, $hashed_password);

                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {

                        session_start();

                        $_SESSION['email'] = $email;
                        $_SESSION['id'] = $id;
                        $_SESSION['isLoggedIn'] = true;

                        header("location: index.php");
                    } else {
                        $password_error = "Incorrect Password";
                    }
                }
            } else {
                $email_error = "Email not registered";
            }
        }
    }
}

// sending/passing secure data then use POST method // pass data through body
// faster and limited data then use GET method // pass data through URL
?>

<div class="container px-5">
    <form method="POST" class="p-5">
        <div class="mb-3">
            <label for="exampleInputEmail1" class="form-label">Email address</label>
            <input type="email" class="form-control" name="email" id="exampleInputEmail1" value="<?php echo $email; ?>" aria-describedby="emailHelp">
            <div class="form-text text-danger"><?php echo $email_error; ?></div>
        </div>
        <div class="mb-3">
            <label for="exampleInputPassword1" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="exampleInputPassword1">
            <div class="form-text text-danger"><?php echo $password_error; ?></div>
        </div>
        <div class="mb-3 form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>


<?php
include("master_pages/footer.php");

// if ($email == "demo@gmail.com" and $pwd == "123456") {

//     echo '
// <div class="alert alert-success alert-dismissible fade show" role="alert">
// <strong>Login Successful!</strong>
// <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//     </div>
// ';
// } else {
//     echo '
// <div class="alert alert-danger alert-dismissible fade show" role="alert">
// <strong>Enter correct Email and Password!</strong>
// <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//     </div>
// ';
// }
?>