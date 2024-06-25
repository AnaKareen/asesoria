<?php
include_once 'backend\controladores\login.class.php'
?>
<!DOCTYPE html>
<html lang="en">
<link rel="icon" type="image/png" sizes="90x90" href="backend\img\logo1.png">
<?php include __DIR__ . '\\backend\\h&f\\header.php'; ?>
<link rel="stylesheet" href="backend/css/styleheader.css" />


<div class="center">
    <form class="formlog" action="" method="POST">
        <img src="backend/img/logo.png" alt="">
        <div class="flex-column">
            <label>Email</label>
        </div>
        <div class="inputForm">
            <input type="text" class="input" name="username" value="<?php if (isset($_POST['username']))
                echo $_POST['username'] ?>" autocomplete="off" class="form-input span-2" placeholder="Usuario " />
            </div>

            <div class="flex-column">
                <label>Password</label>
            </div>
            <div class="inputForm">
                <input type="password" class="input" required="true" name="password" value="<?php if (isset($_POST['password']))
                echo MD5($_POST['password']) ?>" class="form-input span-2" placeholder="Contraseña" />


            </div>

            <div class="flex-row">

             <a href="login.php?action=forgot">Recuperar mi contraseña</a>
            </div>
            <button class="button-submit" type="submit" name="login">Sign In</button>


        </form>
    </div>



<?php include __DIR__ . '\\backend\\h&f\\footer.php'; ?>