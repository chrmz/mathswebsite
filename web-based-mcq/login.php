<?php 
  
    $pageName = "login";
    $requireAuthentication = false;
    include_once './includes/head.php';
    require_once('./functions/login_register_function.php');
    $username = '';
    $errors = array();
    if(isset($_POST['submit'])) {
        $username = $_POST['username'];
        $password = $_POST['password'];
        $errors =  login($username, $password);
    }
?>



<section>

<div class="modal">
    
            <form  method="post" class="modal-content " action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']);?>">
       
            <div class="imgcontainer">
            <img src="images/mathmania.png"  class="avatar" />
             </div>
             <div class="container">
                    <?php foreach ($errors as $key => $error) :  ?>
                       <p style="color : #ff000"> <?=$error?> </p>
                    <?php endforeach ?>

            <label>
                Username
            </label>
            <input type="text" placeholder="Username" name="username" value="<?=$username?>"/>
            <br />
            <label>
                Password
            </label>
            <input type="password" placeholder="Password" name="password"/>
            <br />
            <input type="checkbox">Remember me
            <button type="submit" name="submit">Login</button>
            <label>
                <p>Forget <a href="#">Password</a></p>
            </label>
            <label>
                <p>No Account?<a href="signup.php">signup</a></p>
            </label>
        </div>
         </form>    
        </div>
</section>