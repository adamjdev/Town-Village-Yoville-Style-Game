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
   if($settings_action=='add') {
      $Tcategory = security($_POST['category']);
      $Tname = security($_POST['name']);
      $Tpath = security($_POST['path']);
      $Tprice = security($_POST['price']);
      $Q = mysql_query("INSERT INTO $config_db_tiles (id,tile_category,tile_name,tile_price,tile_path,status) VALUES ('','$Tcategory','$Tname','$Tprice','$Tpath','1')");
      $msg = 'Success: Tile was added!';
   }
}
?>
<!doctype html>
<html>
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
   <title>Admin Add Tile</title>
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
            <p class="content-title">Add Tile</p>
            <?php if($msg!='') { echo '<p style="text-align: center;">'.$msg.'</p>'; } ?>
            <form action="admin_tileadd.php" method="POST">
               <input type="hidden" name="action" value="add">
               <div class="content-box6">
                  <p style="text-align: center;">Add Tile</p>
                  <p><input type="text" name="category" placeholder="Tile Category" required></p>
                  <p><input type="text" name="name" placeholder="Tile Name" required></p>
                  <p><input type="text" name="path" placeholder="Tile Path" required></p>
                  <p><input type="text" name="price" placeholder="Tile Price" required></p>
                  <p style="text-align: right;"><input type="submit" name="submit" value="Add Tile"></p>
               </div>
            </form>
         </div>
      </div>
      <?php require'./system/content_footer.php'; ?>
   </div>
</body>
</html>