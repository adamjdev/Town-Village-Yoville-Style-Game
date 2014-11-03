<?php
$rq = true;
require'./system/system_config.php';
if(isUser($config_db_accounts)===true) {
   header("Location: $config_domain");
}

$msg = '';
if(isset($_POST['submit'])) {
   if(!isset($_POST['username'])) {
      $msg = 'No username entered!';
   } elseif(!isset($_POST['email'])) {
      $msg = 'No email entered!';
   } elseif(!isset($_POST['password'])) {
      $msg = 'No password entered!';
   } elseif(!isset($_POST['repeat'])) {
      $msg = 'Password not repeated!';
   } else {
      $username = security($_POST['username']);
      $email = security($_POST['email']);
      $password = encrypy(security($_POST['password']));
      $repeat = encrypy(security($_POST['repeat']));
      $Function_Query1 = mysql_query("SELECT email FROM $config_db_accounts WHERE email='$email'");
      $Function_Query2 = mysql_query("SELECT username FROM $config_db_accounts WHERE username='$username'");
      if($password!==$repeat) {
         $msg = 'Passwords did not match!';
      } elseif($config_registrations!==true) {
         $msg = 'Registration is disabled.';
      } elseif(validate_email($email)!==true) {
         $msg = 'Invalid email entered!';
      } elseif(validate_username($username)!==true) {
         $msg = 'Invalid username entered!';
      } elseif((strlen($username)<=3)&&(strlen($username)>=15)) {
         $msg = 'Usernames between 3 and 15 charecters!';
      } elseif(mysql_num_rows($Function_Query1) === 1) {
         $msg = 'Email already has an account!';
      } elseif(mysql_num_rows($Function_Query2) === 1) {
         $msg = 'Username is already used!';
      } else {
         if(isset($_SESSION['ref'])) {
            $ref = $_SESSION['ref'];
         } else {
            $ref = '1';
         }
         $Qy = mysql_query("INSERT INTO $config_db_accounts (id,date,ip,last_date,last_ip,username,email,password,coins,xp,level,referrer,player,posx,posy,facing,room,status) VALUES ('','$date','$ip','$date','$ip','$username','$email','$password','0','0','1','$ref','0','60','60','right','Town Square','1')");
         $msg = 'Account created. You can now login.';
      }
   }
}
?>
<!doctype html>
<html>
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
   <title>Village &#128106; - Register</title>
   <link rel="icon" type="image/png" href="./system/img_icon.png">
   <link href='http://fonts.googleapis.com/css?family=Indie+Flower' rel='stylesheet' type='text/css'>
   <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
   <script type="text/javascript" src="./system/script_jquery-1.9.1.js"></script>
   <script type="text/javascript"><?php require'./system/script_javascript.php'; ?></script>
   <style type="text/css"><?php require'./system/script_css.php'; ?></style>
</head>
<body>
   <div class="shell">
      <?php require'./system/content_header.php'; ?>
      <?php require'./system/content_menu.php'; ?>
      <div class="content">
         <div class="content-pad">
            <div class="content-form">
               <span class="content-title">Join Village Today!</span>
               <?php if($msg!='') { echo '<p style="text-align: center;">'.$msg.'</p>'; } ?>
               <form action="register.php" method="POST">
                  <p><input type="text" name="username" placeholder="Public Username" required></p>
                  <p><input type="email" name="email" placeholder="Email Address" required></p>
                  <p><input type="password" name="password" placeholder="Password" required></p>
                  <p><input type="password" name="repeat" placeholder="Repeat Password" required></p>
                  <p style="text-align: right;"><input type="submit" name="submit" value="Register" required></p>
               </form>
            </div>
         </div>
      </div>
      <?php require'./system/content_footer.php'; ?>
   </div>
</body>
</html>