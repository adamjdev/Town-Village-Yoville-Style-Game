<?php
$rq = true;
require'./system/system_config.php';
if(isUser($config_db_accounts)===true) {
   header("Location: live.php");
}

$msg = '';
if(isset($_POST['submit'])) {
   if(!isset($_POST['email'])) {
      $msg = 'No email entered!';
   } elseif(!isset($_POST['password'])) {
      $msg = 'No password entered!';
   } else {
      $email = security($_POST['email']);
      $password = encrypy(security($_POST['password']));
      $Function_Query1 = mysql_query("SELECT email, password FROM $config_db_accounts WHERE email='$email' and password='$password'");
      $Function_Query2 = mysql_query("SELECT email, password, status FROM $config_db_accounts WHERE email='$email' and password='$password' and status='1'");
      if(validate_email($email)!==true) {
         $msg = 'Invalid email entered!';
      } elseif(mysql_num_rows($Function_Query1) !== 1) {
         $msg = 'Invalid login credentials!';
      } elseif(mysql_num_rows($Function_Query2) !== 1) {
         $msg = 'Account is disabled!';
      } else {
         $_SESSION['pu'] = $email;
         $msg = 'Logged in successfully.
                 <script type="text/javascript">
                    window.location = "live.php";
                    function relayer() {
                       window.location = "live.php";
                    }
                    setTimeout(relayer(), 10);
                 </script>';
      }
   }
}
?>
<!doctype html>
<html>
<head>
   
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
   <title>Village &#128106;</title>
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
         <br>
         <p style="text-align: center;">Welcome to Village!</p>
         <div class="selecterbox" style="width: 60% !important;">
            <span class="content-title">Login below!</span>
            <?php if($msg!='') { echo '<p style="text-align: center;">'.$msg.'</p>'; } ?>
            <form action="index.php" method="POST">
               <p><input type="email" name="email" placeholder="Email Address" required></p>
               <p><input type="password" name="password" placeholder="Password" required></p>
               <p style="text-align: right;"><input type="submit" name="submit" value="Login" required></p>
            </form>
         </div>
      </div>
      <?php require'./system/content_footer.php'; ?>
   </div>
</body>
</html>