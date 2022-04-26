<?php
require_once "config.php";

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if ($_SERVER['REQUEST_METHOD'] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Username cannot be blank";
        echo "<script>alert('Username cannot be blank')</script>";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = ?";
        $stmt = mysqli_prepare($conn, $sql);
        if($stmt)
        {
            mysqli_stmt_bind_param($stmt, "s", $param_username);

            // Set the value of param username
            $param_username = trim($_POST['username']);

            // Try to execute this statement
            if(mysqli_stmt_execute($stmt)){
                mysqli_stmt_store_result($stmt);
                if(mysqli_stmt_num_rows($stmt) == 1)
                {
                    $username_err = "This username is already taken"; 
                    echo "<script>alert('This username is already taken')</script>";
                }
                else{
                    $username = trim($_POST['username']);
                }
            }
            else{
                echo "Something went wrong";
            }
        }
    }

    mysqli_stmt_close($stmt);


// Check for password
if(empty(trim($_POST['password']))){
    $password_err = "Password cannot be blank";
    echo "<script>alert('Password cannot be blank')</script>";
}
elseif(strlen(trim($_POST['password'])) < 5){
    $password_err = "Password cannot be less than 5 characters";
    echo "<script>alert('Password cannot be less than 5 characters')</script>";
}
else{
    $password = trim($_POST['password']);
}

// Check for confirm password field
if(trim($_POST['password']) !=  trim($_POST['confirm_password'])){
    $password_err = "Passwords should match";
    echo "<script>alert('Passwords should match')</script>";
}


// If there were no errors, go ahead and insert into the database
if(empty($username_err) && empty($password_err) && empty($confirm_password_err))
{
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $sql);
    if ($stmt)
    {
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);

        // Set these parameters
        $param_username = $username;
        $param_password = password_hash($password, PASSWORD_DEFAULT);

        // Try to execute the query
        if (mysqli_stmt_execute($stmt))
        {
            header("location: login.php");
        }
        else{
            echo "Something went wrong... cannot redirect!";
        }
    }
    mysqli_stmt_close($stmt);
}
mysqli_close($conn);
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/form.css">
    <!-- <link rel="stylesheet" media="screen and (max-width: 1225px)" href="assets/css/mediaquery2.css"> -->
    <link rel="stylesheet" media="screen and (max-width: 1030px)" href="assets/css/mediaquery.css">

</head>

<body>
    <!-- navbar section -->
    <div id="overlay">
        <a href="index.php#Home-Page">Home</a><br>
        <a href="index.php#about-us">About Us</a><br>
        <a href="register.php">Register</a><br>
        <a href="login.php">Login</a><br>
        <a href="index.php#recommended">Recommended</a><br>
        <a href="index.php#domains">Domains</a><br>
        <a href="index.php#reviews">Reviews</a><br>
        <a href="index.php#sponsors">Sponsors</a><br>
        <a href="index.php#faq">F.A.Qs</a><br>
        <a href="index.php#contact">Contact Us</a><br>
    </div>
    <div id="mob-navbar">
        <div id="hamburger">
            <div></div>
        </div>
    </div>
    <!-- super parent for background gif -->
    <div class="superParent homepage" id="fullpage">
        <!-- about us -->
        <section class="about-us section" id="about-us">
            <div class="wrapper">
                <div class="main-heading">QUERY FORM</div>
            </div>
            <div class="register" style="display:flex; align-items:center; justify-content:center;">
                    <div class="cardRegister">
                    <form action="" method="post">
                        <label for="fname">Name</label>
                        <input type="text" id="fname" name="fname" placeholder="Enter Full Name"><br>
                        <label for="lname">Instructor: </label>
                        <input type="text" id="instructor" name="instructor" placeholder="Enter password"><br>
                        <label>Courses</label><br>
                        <div class="courses">
                        <input type="checkbox" id="dsa" name="dsa" value="DSA">
                        <label for="dsa"> DSA </label><br>
                        <input type="checkbox" id="webdev" name="webdev" value="Web Development">
                        <label for="webdev"> Web Development </label><br>
                        <input type="checkbox" id="dbms" name="dbms" value="DBMS">
                        <label for="dbms"> DBMS </label><br>
                        <input type="checkbox" id="os" name="os" value="OS">
                        <label for="os"> Operating System </label><br>
                        <input type="checkbox" id="webmin" name="webmin" value="Web Mining">
                        <label for="webmin"> Web Mining </label><br>
                        </div>
                        <label>Course Content</label><br>
                        <div class="c-content">
                        <table>
                            <tr>
                                <th></th>
                                <th>Must Contain</th>
                                <th>Mustn't Contain</th>
                            </tr>
                            <tr>
                                <td>Course Content organized</td>
                                <td><input type="radio" name="organized" value="Must Contain"></td>
                                <td><input type="radio" name="organized" value="Mustn't Contain"></td>
                            </tr>
                            <tr>
                                <td>Course Workload</td>
                                <td><input type="radio" name="workload" value="Must Contain"></td>
                                <td><input type="radio" name="workload" value="Mustn't Contain"></td>
                            </tr>
                            <tr>
                                <td>Course Competitive Projects</td>
                                <td><input type="radio" name="projects" value="Must Contain"></td>
                                <td><input type="radio" name="projects" value="Mustn't Contain"></td>
                            </tr>
                            <tr>
                                <td>Daily dose of questions</td>
                                <td><input type="radio" name="questions" value="Must Contain"></td>
                                <td><input type="radio" name="questions" value="Mustn't Contain"></td>
                            </tr>  


                        </table><br>
                        </div>
                        
                        <label for="question1">What do you expect from the course?</label><br>
                        <input type="text" id="question1" name="expect" placeholder="Your Answer"><br>

                        <div class="submit" style="display: flex; align-items:center; justify-content:center;">
                            <input type="submit" value="SUBMIT">
                        </div>
                        </div>
                    </form>
            </div>
        </section>
    </div>
 <!-- js -->
 <script src="assets/js/script1.js"></script>
    <script>
        window.addEventListener('scroll', reveal);
        function reveal() {
            var reveals = document.getElementsByClassName('card');
            Array.from(reveals).forEach(element => {
                var windowHeight = window.innerHeight;
                var revealTop = element.getBoundingClientRect().top;
                var revealPoint = 100;

                if (revealTop < windowHeight - revealPoint) {
                    element.classList.add('active1');
                }
                else {
                    element.classList.remove('active1');
                }
            });
        }
    </script>
    <script>
         window.addEventListener('scroll', reveal);
        function reveal() {
            var reveals = document.getElementsByClassName('card1-container');
            Array.from(reveals).forEach(element => {
                var windowHeight = window.innerHeight;
                var revealTop = element.getBoundingClientRect().top;
                var revealPoint = 100;

                if (revealTop < windowHeight - revealPoint) {
                    element.classList.add('active1');
                }
                else {
                    element.classList.remove('active1');
                }
            });
        }
    </script>
</body>

</html>