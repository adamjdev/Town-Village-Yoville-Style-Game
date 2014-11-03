<?php
$rq = true;
require'./system/system_config.php';
if(isUser($config_db_accounts)!==true) {
   header("Location: $config_domain");
}

if(!in_array($user_email,$confid_admins)){
   header("Location: $config_domain");
}
?>
<!doctype html>
<html>
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
   <title>Admin Options</title>
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
            <p class="content-title">Admin Options</p>
            <ul>
               <li><a href="admin_charecters_add.php">Add Charecters</a></li>
               <li><a href="admin_charecters_view.php">View Charecters</a></li>
            </ul>
         </div>
      </div>
      <?php require'./system/content_footer.php'; ?>
   </div>
</body>
</html>