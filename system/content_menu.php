<?php
if($rq!==true) { die("Invalid Access"); exit; }
?>
<div class="menu">
      <?php
      if(isUser($config_db_accounts)===true) {
         echo '<span class="menu-button" onclick="window.location.href=\'live.php\';" title="Village">Village</span>';
         if(in_array($user_email,$confid_admins)) {
            echo '<span class="menu-button" onclick="window.location.href=\'admin.php\';" title="Admin">Admin</span>';
         }
      } else {
         echo '<span class="menu-button" onclick="window.location.href=\'index.php\';" title="Village">Village</span>
               <span class="menu-button" onclick="window.location.href=\'register.php\';" title="Register">Register</span>';
      }
      ?>
</div>