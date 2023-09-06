<?php 
$pageName = "signup";
$requireAuthentication = false;
include_once './includes/head.php';
require_once('./functions/login_register_function.php');

$firstName = $lastName = $email = $password1 = $password2 = '';
$errors = array();
if(isset($_POST['submit'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $password1 = $_POST['password1'];
    $password2 = $_POST['password2'];
    $errors =  register($firstName, $lastName, $email, $password1, $password2);
}

?>


<section class="signup">
<div class="container">
<?php foreach ($errors as $key => $error) :  ?>
                       <p style="color : #ff000"> <?=$error?> </p>
                    <?php endforeach ?>

    <form  method="post"  action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
            <h1>Sign Up</h1>
            <p>Please fill this form to create account</p>
        <hr />
        <label>First Name*</label>
        <input type="text" placeholder="First name" name="firstName" value="<?=$firstName?>" required />
        
        <label>Last Name</label>
        <input type="text" placeholder="Last name"  name="lastName" value="<?=$lastName?>" required />
       
        <label>Email</label>
        <input type="email" placeholder="Email" name="email" value="<?=$email?>" required />
      
        <label>Password</label>
        <input type="password" placeholder="Password" name="password1" value="<?=$password1?>" required />
       
        <label>Re-password</label>
        <input type="password" placeholder="Re-password" name="password2" value="<?=$password2?>" required />
        <p>
            By creating an account you agree our<a href="#">Terms and Privacy</a>
        </p>
        <button class="registerbtn" type="submit" name="submit">Sign Up</button>

        <div class="login">
        <p>Already have an account?<a href="login.php">Login</a></p>
        </form>
    </div>
</section>


<?php 
    include_once './includes/footer.php'
?>