<?php
$rq = true;
require'./system/system_config.php';
if(isUser($config_db_accounts)!==true) {
   header("Location: $config_domain");
}

if(!in_array($user_email,$confid_admins)){
   header("Location: $config_domain");
}

$msg = '';
if(isset($_POST['action'])) {
   $settings_action = security($_POST['action']);
   if($settings_action=='chnagepw') {
      $oldpassword = encrypy(security($_POST['oldpassword']));
      $newpassword = encrypy(security($_POST['newpassword']));
      $reppassword = encrypy(security($_POST['reppassword']));
      $Function_Query1 = mysql_query("SELECT email, password FROM $config_db_accounts WHERE email='$user_email' and password='$oldpassword'");
      if(mysql_num_rows($Function_Query1) !== 1) {
         $msg = 'Current password was invalid!';
      } elseif($newpassword!==$reppassword) {
         $msg = 'New password not repeated correctly!';
      } else {
         $q = mysql_query("UPDATE $config_db_accounts SET password='$newpassword' WHERE email='$user_email'");
         $msg = 'Account password has been changed!';
      }
   }

}
?>
<!doctype html>
<html>
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
   <title>Admin List Tiles</title>
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
            <p class="content-title">Tile List</p>
            <?php 
            if($msg!='') { echo '<p style="text-align: center;">'.$msg.'</p>'; } 
            echo '<span style="display: inline-block; width: 40px;">ID</span>
                  <span style="display: inline-block; width: 100px;">Category</span>
                  <span style="display: inline-block; width: 120px;">Name</span>
                  <span style="display: inline-block; width: 60px;">Price</span>
                  <span style="display: inline-block; width: 240px;">Path</span>
                  <span style="display: inline-block; width: 60px;">Status</span>
                  <br>';
            $q = mysql_query("SELECT * FROM $config_db_tiles ORDER BY tile_category ASC");
            while($r = mysql_fetch_assoc($q)) {
               $tile_id = $r['id'];
               $tile_category = $r['tile_category'];
               $tile_name = $r['tile_name'];
               $tile_price = $r['tile_price'];
               $tile_path = $r['tile_path'];
               $tile_status = $r['status'];
               if($tile_status==1) { $tile_status = 'Active'; } else { $tile_status = 'Disabled'; }
               echo '<span style="display: inline-block; width: 40px;">'.$tile_id.'</span>
                     <span style="display: inline-block; width: 100px;">'.$tile_category.'</span>
                     <span style="display: inline-block; width: 120px;">'.$tile_name.'</span>
                     <span style="display: inline-block; width: 60px;">'.$tile_price.'</span>
                     <span style="display: inline-block; width: 240px;">'.$tile_path.'</span>
                     <span style="display: inline-block; width: 60px;">'.$tile_status.'</span>
                     <br>';
            }
            ?>

         </div>
      </div>
      <?php require'./system/content_footer.php'; ?>
   </div>
</body>
</html>