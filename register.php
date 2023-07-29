<?php
$title = "Register";

ob_start();
require_once "config.php";

include("master_pages/header.php");

$fname_error = $lname_error = $email_error = $pwd_error = $address_error = $cname_error = $mobile_error = $gender_error = $h1_error = $h2_error = $h3_error = $state_error = "";
$fname = $lname = $email = $pwd = $address = $cname = $mobile = $gender = $h1 = $h2 = $h3 = $state = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if (empty($_POST['fName'])) {
            $fname_error = "Please Enter your full name";
        } else {
            $fname = $_POST['fName'];
        }

        if (empty(trim($_POST['lName']))) {
            $lname_error = "Please Enter your last name";
        } else {
            $lname = $_POST['lName'];
        }

        if (empty(trim($_POST['email']))) {
            $email_error = "Please Enter your Email address";
        } else {

            $stmt = mysqli_prepare($conn, "SELECT id FROM user_tbl WHERE email = ?");

            if ($stmt) {

                mysqli_stmt_bind_param($stmt, 's', $p_email);

                $p_email = $_POST['email'];

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) > 0) {
                        $email_error = "Email already registered";
                    } else {
                        $email = $_POST['email'];
                    }
                }
            }
        }

        if (empty(trim($_POST['mobile']))) {
            $mobile_error = "Please Enter your Mobile number";
        } else {

            $query = "SELECT mobile FROM user_tbl WHERE mobile = ?";

            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {

                mysqli_stmt_bind_param($stmt, 's', $p_mobile);

                $p_mobile = $_POST['mobile'];

                if (mysqli_stmt_execute($stmt)) {
                    mysqli_stmt_store_result($stmt);

                    if (mysqli_stmt_num_rows($stmt) == 1) {
                        $mobile_error = "Number already registered";
                    } else {
                        $mobile = $_POST['mobile'];
                    }
                }
            }
        }

        if (isset($_POST['Hobby1'])) {
            $h1 = $_POST['Hobby1'];
        } else {
            echo "";
        }
        if (isset($_POST['Hobby2'])) {
            $h2 = $_POST['Hobby2'];
        } else {
            echo "";
        }
        if (isset($_POST['Hobby3'])) {
            $h3 = $_POST['Hobby3'];
        } else {
            echo "";
        }

        $address = $_POST['address'];

        if (empty(trim($_POST['password']))) {
            $pwd_error = "Please Create a password";
        } else {
            if (strlen($_POST['password']) < 6) {
                $pwd_error = "Password length must be between 6 to 12 charactors";
            } else {
                $pwd = $_POST['password'];
            }
        }

        if (isset($_POST['gender'])) {
            $gender = $_POST['gender'];
        } else {
            $gender_error = "Select Gender";
        }

        if ($_POST['state'] == "Not Selected") {
            $state_error = "Please select a State";
        } else {
            $state = $_POST['state'];
        }


        if (empty($fname_error) and empty($lname_error) and empty($email_error) and empty($pwd_error) and empty($gender_error) and empty($state_error) and empty($mobile_error)) {


            $query = "INSERT INTO user_tbl(name, email, mobile, address, gender, hobbies1, hobbies2, hobbies3, state, password) VALUES (?,?,?,?,?,?,?,?,?,?)";

            $stmt = mysqli_prepare($conn, $query);

            if ($stmt) {

                mysqli_stmt_bind_param($stmt, "ssssssssss", $p_name, $p_email, $p_mobile, $p_address, $p_gender, $p_hobbies1, $p_hobbies2, $p_hobbies3, $p_state, $p_password);

                $p_name = $fname . " " . $lname;
                $p_email = $email;
                $p_mobile = $mobile;
                $p_address = $address;
                $p_gender = $gender;
                $p_hobbies1 = $h1;
                $p_hobbies2 = $h2;
                $p_hobbies3 = $h3;
                $p_state = $state;
                $p_password = password_hash($pwd, PASSWORD_DEFAULT);

                if (mysqli_stmt_execute($stmt)) {
                    header("location: login.php");
                } else {
                    echo "Someting went wrong";
                }
            } else {
                echo "Database error";
            }
            mysqli_stmt_close($stmt);
        }
        mysqli_close($conn);
    }

?>

<div class="container p-5">

     <form class="row g-3 px-5" method="POST">
          <div class="col-md-6">
               <label for="inputFName" class="form-label">First Name</label>
               <input type="text" class="form-control" name="fName" id="inputFName" value="<?php echo $fname; ?>">
               <div class="form-text text-danger"><?php echo $fname_error; ?></div>
          </div>
          <div class="col-md-6">
               <label for="inputLastName" class="form-label">Last Name</label>
               <input type="text" class="form-control" name="lName" id="inputLastName" value="<?php echo $lname; ?>">
               <div class="form-text text-danger"><?php echo $lname_error; ?></div>
          </div>
          <div class="col-md-6">
               <label for="inputEmail4" class="form-label">Email</label>
               <input type="email" class="form-control" name="email" id="inputEmail4" value="<?php echo $email; ?>">
               <div class="form-text text-danger"><?php echo $email_error; ?></div>
          </div>
          <div class="col-md-6">
               <label for="inputPassword4" class="form-label">Password</label>
               <input type="password" class="form-control" name="password" id="inputPassword4"
                    value="<?php echo $pwd; ?>">
               <div class="form-text text-danger"><?php echo $pwd_error; ?></div>
          </div>
          <div class="col-12">
               <label for="inputAddress" class="form-label">Address</label>
               <input type="text" class="form-control" name="address" id="inputAddress" value="<?php echo $address; ?>">
          </div>
          <div class="col-md-6">
               <label for="inputMobile" class="form-label">Mobile</label>
               <input type="number" class="form-control" name="mobile" id="inputMobile" value="<?php echo $mobile; ?>">
               <div class="form-text text-danger"><?php echo $mobile_error; ?></div>
          </div>
          <div class="col-md-6">
               <label for="inputCity" class="form-label">City</label>
               <input type="text" class="form-control" name="cName" id="inputCity">
          </div>
          <div class="col-md-6">
               <label for="inputGender" class="form-label">Gender&nbsp;<span
                         class="form-text text-danger"><?php echo $gender_error; ?></span></label>
               <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" value="Male" id="inputGenderMale"
                         <?php echo $gender ==  "Male" ? "checked" : ""; ?>>
                    <label class="form-check-label" for="inputGenderMale">
                         Male
                    </label>
               </div>
               <div class="form-check">
                    <input class="form-check-input" type="radio" name="gender" value="Female" id="inputGenderFemale"
                         <?php echo $gender ==  "Femail" ? "checked" : ""; ?>>
                    <label class="form-check-label" for="inputGenderFemale">
                         Female
                    </label>
               </div>
          </div>
          <div class="col-md-6">
               <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Reading" name="Hobby1" id="checkbox1"
                         <?php echo $h1 ==  "Reading" ? "checked" : ""; ?>>
                    <label class="form-check-label" for="checkbox1">
                         Reading
                    </label>
               </div>
               <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Coding" name="Hobby2" id="checkbox2"
                         <?php echo $h2 ==  "Coding" ? "checked" : ""; ?>>
                    <label class="form-check-label" for="checkbox2">
                         Coding
                    </label>
               </div>
               <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="Designing" name="Hobby3" id="checkbox3">
                    <label class="form-check-label" for="checkbox3">
                         Designing
                    </label>
               </div>
          </div>
          <div class="col-12">

               <select class="form-select" name="state" aria-label="Default select example">
                    <option selected value="Not Selected">Select State</option>
                    <option value="Gujarat">Gujarat</option>
                    <option value="Other">Other</option>
               </select>
               <span class="form-text text-danger"><?php echo $state_error ?></span>
          </div>
          <div class="col-12">
               <button type="submit" class="btn btn-primary">Sign Up</button>
          </div>
     </form>

</div>

<?php

include("master_pages/footer.php");

// echo "<br>" . $fname = $_POST['fName']; // text field // input type text
// echo "<br>" . $lname = $_POST['lName'];
// echo "<br>" . $email = $_POST['email'];
// echo "<br>" . $pwd = $_POST['password'];
// echo "<br>" . $address = $_POST['address'];
// echo "<br>" . $cname = $_POST['cName'];
// echo "<br>" . $mobile = $_POST['mobile'];


// if (isset($_POST['gender'])) {
//     echo $gender = $_POST['gender'];
// } else {
//     echo "<br>" . "Select Gender";
// }


// if (isset($_POST['Hobby1'])) {
//     echo $h1 = $_POST['Hobby1'];
// } else {
//     echo "";
// }
// if (isset($_POST['Hobby2'])) {
//     echo $h2 = $_POST['Hobby2'];
// } else {
//     echo "";
// }
// if (isset($_POST['Hobby3'])) {
//     echo $h3 = $_POST['Hobby3'];
// } else {
//     echo "";
// }

// echo "<br>" . $state = $_POST['state'];

?>