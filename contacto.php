<!DOCTYPE html>
<html lang="en">
<link rel="icon" type="image/png" sizes="90x90" href="backend\img\logo1.png">
<?php include __DIR__ . '\\backend\\h&f\\header.php'; ?>
<link rel="stylesheet" href="backend/css/styleheader.css" />
<h1 class="center">Contacto</h1>
<br>

<div class="col-izq">
<iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7568835.159557296!2d-106.29917439999994!3d22.13663779999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x842a98d806050e9b%3A0x82f48ac7b1f71498!2sPI%20Asesor%C3%ADa!5e0!3m2!1ses-419!2smx!4v1716833482196!5m2!1ses-419!2smx"
        width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>
<div class="col-der">
<div class="center">
    <form class="formlog" action="" method="POST">
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

                <span class="span">Forgot password?</span>
            </div>
            <button class="button-submit" type="submit" name="login">Sign In</button>


        </form>
    </div>
</div>
<?php include __DIR__ . '\\backend\\h&f\\footer.php'; ?>