<?php
if($rq!==true) { die("Invalid Access"); exit; }
?>
<?php
if(isUser($config_db_accounts)===true) {
   echo '<div class="head-stats">
            Online: <span id="Online">'.$online_count.'</span>
            <span>Level: <span id="Level">'.$user_level.'</span> | <span id="XP">'.$user_xp.'</span> XP | <span id="Coins">'.$user_coins.'</span> Coins</span>
         </div>';
} else {
   echo '<div class="head-stats">
            Online: <span id="Online">'.$online_count.'</span>
         </div>';
}
?>