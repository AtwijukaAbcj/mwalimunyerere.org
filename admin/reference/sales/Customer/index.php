<!-- Code by Brave Coder - https://youtube.com/BraveCoder -->
<?php 

// $host="localhost";
// $user="root";
// $password="";
// $db="blog";

$conn = mysqli_connect("localhost", "root", "", "blog");
// mysql_select_db($conn);
// if($conn){

//     echo "Connected";
// }else{
//     echo "not connected";
// }
// include 'config.php';
$msg = "";

if(isset($_POST['username'])){
    
    $username=$_POST['username'];
    $password=$_POST['password'];
    $sql="select * from pharmacylogin where user='".$username."'AND Pass='".$password."' limit 1";
    $result = mysqli_query($conn, $sql);
    
    // if(mysql_num_rows($result)==1){
    //     echo " You Have Successfully Logged in";
    //     exit();
    // }
    if ($result) {
        header("Location: list.php");
        //Create an instance; passing `true` enables exceptions
        
        exit();

    }else{
        echo " You Have Entered Incorrect Password";
        exit();
    }
        
}
?>

<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Login </title>
    <!-- Meta tag Keywords -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8" />
    <meta name="keywords"
        content="Login Form" />
    <!-- //Meta tag Keywords -->

    <link href="//fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">

    <!--/Style-CSS -->
    <link rel="stylesheet" href="css/style.css" type="text/css" media="all" />
    <!--//Style-CSS -->

    <script src="https://kit.fontawesome.com/af562a2a63.js" crossorigin="anonymous"></script>

</head>

<body>

    <!-- form section start -->
    <section class="w3l-mockup-form">
        <div class="container">
            <!-- /form -->
            <div class="workinghny-form-grid">
                <div class="main-mockup">
                    <div class="alert-close">
                        <span class="fa fa-close"></span>
                    </div>
                    <div class="w3l_form align-self">
                        <div class="left_grid_info">
                            <img src="images/image.svg" alt="">
                        </div>
                    </div>
                    <div class="content-wthree">
                        <h2>Login Now</h2>
                        <p> </p>
                        <?php echo $msg; ?>
                        <form action="" method="post">
                            <input type="username" class="username" name="username" placeholder="username" placeholder="Enter Your Username" required />
                            <input type="password" class="password" name="password" placeholder="Enter Your Password" style="margin-bottom: 2px;" required>
                            <p><a href="forgot-password.php" style="margin-bottom: 15px; display: block; text-align: right;">Forgot Password?</a></p>
                            <button name="submit" name="submit" class="btn" type="submit">Login</button>
                        </form>
                        <!-- <div class="social-icons">
                            <p>Create Account! <a href="register.php">Register</a>.</p>
                        </div> -->
                    </div>
                </div>
            </div>
            <!-- //form -->
        </div>
    </section>
    <!-- //form section start -->

    <script src="js/jquery.min.js"></script>
    <script>
        $(document).ready(function (c) {
            $('.alert-close').on('click', function (c) {
                $('.main-mockup').fadeOut('slow', function (c) {
                    $('.main-mockup').remove();
                });
            });
        });
    </script>

</body>

</html>