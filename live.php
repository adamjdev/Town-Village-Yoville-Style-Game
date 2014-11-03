<?php
$rq = true;
require'./system/system_config.php';
if(isUser($config_db_accounts)!==true) {
   echo '<script type="text/javascript">
            window.location = "index.php";
            function relayer() {
               window.location = "index.php";
            }
            setTimeout(relayer(), 10);
         </script>';
   die("");
   exit;
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
         $msg = 'New password was not repeated correctly!';
      } else {
         $q = mysql_query("UPDATE $config_db_accounts SET password='$newpassword' WHERE email='$user_email'");
         $msg = 'Account password has been changed!';
      }
   }
}

if(isset($_GET['ajax'])) {
   $ajax = security($_GET['ajax']);
   if($ajax=='changelocation') {
      $ajax_set = security($_GET['set']);
      if($ajax_set=='town-square') {
         $q = mysql_query("UPDATE $config_db_accounts SET room='Town Square' WHERE email='$user_email'");
      } elseif($ajax_set=='beach') {
         $q = mysql_query("UPDATE $config_db_accounts SET room='Beach' WHERE email='$user_email'");
      }
      echo '<script type="text/javascript">
               window.location = "live.php";
               function relayer() {
                  window.location = "live.php";
               }
               setTimeout(relayer(), 10);
            </script>';
   }
   if($ajax=='friend') {
      if(isset($_GET['add'])) {
         $ajax_add = security($_GET['add']);
         $Qy = mysql_query("INSERT INTO $config_db_friends (id,username,friend) VALUES ('','$user_username','$ajax_add')");
      }
      if(isset($_GET['rem'])) {
         $ajax_rem = security($_GET['rem']);
         $Qy = mysql_query("DELETE FROM $config_db_friends WHERE friend='$ajax_rem'");
      }
   }
   if($ajax=='changeplayer') {
      $ajax_set = security($_GET['set']);
      if($ajax_set=='gamedefaultgirl') {
         $q = mysql_query("UPDATE $config_db_accounts SET player='gamedefaultgirl' WHERE email='$user_email'");
      } elseif($ajax_set=='gamepimp') {
         $q = mysql_query("UPDATE $config_db_accounts SET player='gamepimp' WHERE email='$user_email'");
      }
      echo '<script type="text/javascript">
               window.location = "live.php";
               function relayer() {
                  window.location = "live.php";
               }
               setTimeout(relayer(), 10);
            </script>';
   }
   if($ajax=='chatter') {
      $ajax_msg = security($_GET['msg']);
      if($ajax_msg!='') {
         $Qy = mysql_query("INSERT INTO $config_db_chat (id,date,room,user_id,username,message,status) VALUES ('','$date','$user_room','$user_id','$user_username','$ajax_msg','1')");
      }
   }
   if(($ajax=='update')&&(isset($_GET['x']))&&(isset($_GET['y']))&&(isset($_GET['f']))) {
      $ajaxX = security($_GET['x']);
      $ajaxY = security($_GET['y']);
      $ajaxF = security($_GET['f']);
      if($ajaxX>0) { $q = mysql_query("UPDATE $config_db_accounts SET posx='$ajaxX' WHERE email='$user_email'"); }
      if($ajaxY>0) { $q = mysql_query("UPDATE $config_db_accounts SET posy='$ajaxY' WHERE email='$user_email'"); }
      // &&($ajaxX<800)
      // &&($ajaxY<420)
      $q = mysql_query("UPDATE $config_db_accounts SET facing='$ajaxF' WHERE email='$user_email'");
   }
   if($ajax=='map') {
      $q = mysql_query("SELECT id, last_date, username, player, posx, posy, facing, room FROM $config_db_accounts WHERE status='1'");
      while($r = mysql_fetch_assoc($q)) {
         $up_id = $r['id'];
         $up_last_date = $r['last_date'];
         $up_username = $r['username'];
         $up_player = $r['player'];
         $up_posx = $r['posx'];
         $up_posy = $r['posy'];
         $up_facing = $r['facing'];
         $up_room = $r['room'];
         $qqq = mysql_query("SELECT * FROM $config_db_friends WHERE username='$user_username' AND friend='$up_id'");
         if(mysql_num_rows($qqq) == 0) {
            $up_usernametag = '&#128100; '.$up_username.' <span id="ui'.$up_id.'"><span title="Currently are not friends." onclick="FriendAdd('.$up_id.');" style="cursor: pointer;">&#10133;</span></span>';
         } else {
            $up_usernametag = '&#128100; '.$up_username.' <span id="ui'.$up_id.'"><span title="Currently are friends." onclick="FriendRemove('.$up_id.');" style="cursor: pointer;">&#10134;</span></span>';
         }
         if($up_player=='0') { $up_player = 'gamedefaultgirl'; }
         if($user_room!=$up_room) {
            echo '<script type="text/javascript">
                     var OnlineUser = "#'.$up_id.'",
                         OnlineUserUid = "#u'.$up_id.'",
                         OnlineUserCid = "#c'.$up_id.'";
                     if($(OnlineUser).length) {
                        $(OnlineUser).remove();
                        $(OnlineUserUid).remove();
                        if($(OnlineUserCid).length) {
                           $(OnlineUserCid).remove();
                        }
                     }
                  </script>';
         } else {
            $qq = mysql_query("SELECT date, message FROM $config_db_chat WHERE room='$user_room' AND user_id='$up_id' ORDER BY id DESC LIMIT 1");
            $rr = mysql_fetch_assoc($qq);
            $up_chat_date = $rr['date'];
            $up_chat_message = $rr['message'];
            $date_past = strtotime('now -20 seconds');
            $date_msg_exp = strtotime('now -20 seconds');
            if($up_chat_date=='') { $up_chat_date = strtotime('now -10 minutes'); }
            if($date_past>$up_last_date) {
               echo '<script type="text/javascript">
                        var OnlineUser = "#'.$up_id.'",
                            OnlineUserUid = "#u'.$up_id.'",
                            OnlineUserCid = "#c'.$up_id.'";
                        if($(OnlineUser).length) {
                           $(OnlineUser).remove();
                           $(OnlineUserUid).remove();
                           if($(OnlineUserCid).length) {
                              $(OnlineUserCid).remove();
                           }
                        }
                     </script>';
            } elseif($user_id!=$up_id) {
               echo '<script type="text/javascript">
                        var OnlineUser = "#'.$up_id.'",
                            OnlineUserUid = "#u'.$up_id.'",
                            OnlineUserCid = "#c'.$up_id.'",
                            OnlineUserCln = "'.$up_id.'";
                        if('.$date_msg_exp.'>'.$up_chat_date.') {
                           if($(OnlineUserCid).length) {
                              $(OnlineUserCid).remove();
                           }
                        }
                        if($(OnlineUser).length) {
                           var OnlineUserPos = $(OnlineUser).position(),
                               OnlineUserPosX = parseInt(OnlineUserPos.left),
                               OnlineUserPosY = parseInt(OnlineUserPos.top),
                               OnlineUserPosZ = parseInt(11000 + OnlineUserPosY);
                           if(!$(OnlineUser).hasClass("'.$up_player.'")) {
                              $(OnlineUser).removeClass();
                              $(OnlineUser).addClass("'.$up_player.'");
                           }
                           if('.$date_msg_exp.'<'.$up_chat_date.') {
                              if(!$(OnlineUserCid).length) {
                                 $(GameBoard).append(\'<div id="c\'+OnlineUserCln+\'" class="gameusermsg">'.$up_chat_message.'</div>\');
                                 var OnlineUserCidPosX = parseInt('.$up_posx.')+"px",
                                     OnlineUserCidPosY =  parseInt('.$up_posy.' - ($(OnlineUserCid).height() + 10))+"px";
                                 $(OnlineUserCid).css("left",OnlineUserCidPosX);
                                 $(OnlineUserCid).css("top",OnlineUserCidPosY);
                                 $(OnlineUserCid).css("z-index",OnlineUserPosZ);
                              } else {
                                 $(OnlineUserCid).html("'.$up_chat_message.'");
                              }
                           }
                           if((OnlineUserPosX!='.$up_posx.')||(OnlineUserPosY!='.$up_posy.')) {
                              $(OnlineUser).css("z-index",OnlineUserPosZ);
                              var OnlineUserUidPosX = parseInt('.$up_posx.' + ($(OnlineUser).width() / 2))+"px",
                                  OnlineUserUidPosML = "-"+parseInt($(OnlineUserUid).width() / 2)+"px",
                                  OnlineUserUidPosY = parseInt('.$up_posy.' + $(OnlineUser).height())+"px";
                              $(OnlineUserUid).css("z-index",OnlineUserPosZ);
                              $(OnlineUserUid).css("left",OnlineUserUidPosX);
                              $(OnlineUserUid).css("top",OnlineUserUidPosY);
                              $(OnlineUserUid).css("margin-left",OnlineUserUidPosML);
                              if($(OnlineUserCid).length) {
                                 var OnlineUserCidPosX = parseInt('.$up_posx.')+"px",
                                     OnlineUserCidPosY =  parseInt('.$up_posy.' - ($(OnlineUserCid).height() + 10))+"px";
                                 $(OnlineUserCid).css("left",OnlineUserCidPosX);
                                 $(OnlineUserCid).css("top",OnlineUserCidPosY);
                                 $(OnlineUserCid).css("z-index",OnlineUserPosZ);
                              }
                              $(OnlineUser).animate({ \'top\': '.$up_posy.' + \'px\', \'left\': '.$up_posx.' + \'px\'}, 1000, function() {
                              });
                           }
                           if("'.$up_facing.'"=="left") { $(OnlineUser).addClass("flipplayer"); }
                           else { $(OnlineUser).removeClass("flipplayer"); }
                        } else {
                           $(GameBoard).append(\'<div id="\'+OnlineUserCln+\'" title="'.$up_username.'" class="'.$up_player.'"></div>\');
                           $(GameBoard).append(\'<div id="u\'+OnlineUserCln+\'" title="'.$up_username.'" class="gameusername">'.$up_usernametag.'</div>\');
                           $(OnlineUser).css("left","'.$up_posx.'px");
                           $(OnlineUser).css("top","'.$up_posy.'px");
                           var OnlineUserUidPosX = parseInt('.$up_posx.' + ($(OnlineUser).width() / 2))+"px",
                               OnlineUserUidPosY = parseInt('.$up_posy.' + $(OnlineUser).height())+"px",
                               OnlineUserUidPosML = "-"+parseInt($(OnlineUserUid).width() / 2)+"px";
                           $(OnlineUserUid).css("left",OnlineUserUidPosX);
                           $(OnlineUserUid).css("top",OnlineUserUidPosY);
                           $(OnlineUserUid).css("margin-left",OnlineUserUidPosML);
                           var OnlineUserPosZ = parseInt(11000 + '.$up_posy.');
                           $(OnlineUser).css("z-index",OnlineUserPosZ);
                           $(OnlineUserUid).css("z-index",OnlineUserPosZ);
                        }
                     </script>';
            } elseif($user_id==$up_id) {
               echo '<script type="text/javascript">
                        var OnlinePlayerCln = "'.$up_id.'",
                            OnlinePlayerCid = "#c'.$up_id.'";
                        if("'.$date_msg_exp.'">"'.$up_chat_date.'") {
                           if($(OnlinePlayerCid).length) {
                              $(OnlinePlayerCid).remove();
                           }
                        }
                        var OnlinePlayerPos = $(GamePlayer).position(),
                            OnlinePlayerPosX = parseInt(OnlinePlayerPos.left),
                            OnlinePlayerPosY = parseInt(OnlinePlayerPos.top),
                            OnlinePlayerPosZ = parseInt(11000 + OnlinePlayerPosY);
                        if("'.$date_msg_exp.'"<"'.$up_chat_date.'") {
                           if(!$(OnlinePlayerCid).length) {
                              $(GameBoard).append(\'<div id="c\'+OnlinePlayerCln+\'" class="gameusermsg">'.$up_chat_message.'</div>\');
                              var OnlinePlayerCidPosX = parseInt('.$up_posx.')+"px",
                                  OnlinePlayerCidPosY =  parseInt('.$up_posy.' - ($(OnlinePlayerCid).height() + 10))+"px";
                              $(OnlinePlayerCid).css("left",OnlinePlayerCidPosX);
                              $(OnlinePlayerCid).css("top",OnlinePlayerCidPosY);
                              $(OnlinePlayerCid).css("z-index",OnlinePlayerPosZ);
                           } else {
                              $(OnlinePlayerCid).html("'.$up_chat_message.'");
                           }
                        }
                        var OnlinePlayerCidPosX = parseInt('.$up_posx.')+"px",
                            OnlinePlayerCidPosY =  parseInt('.$up_posy.' - ($(OnlinePlayerCid).height() + 10))+"px";
                        $(OnlinePlayerCid).css("left",OnlinePlayerCidPosX);
                        $(OnlinePlayerCid).css("top",OnlinePlayerCidPosY);
                        $(OnlinePlayerCid).css("z-index",OnlinePlayerPosZ);
                     </script>';
            }
         }
      }
      $friends_div = '<br><div class=\'gamemitemcontactoption\'>Friends List:</div>';
      $qqq = mysql_query("SELECT * FROM $config_db_friends WHERE username='$user_username'");
      if(mysql_num_rows($qqq) == 0) {
         $friends_div .= '<div class=\'gamemitemcontactoption\'>No friends added.</div>';
      } else {
         $qqq = mysql_query("SELECT * FROM $config_db_friends WHERE username='$user_username' ORDER BY friend ASC");
         while($rrr = mysql_fetch_assoc($qqq)) {
            $friend_id = $rrr['friend'];
            $qqi = mysql_query("SELECT username FROM $config_db_accounts WHERE id='$friend_id'");
            $rri = mysql_fetch_assoc($qqi);
            $friend_username = $rri['username'];
            $friends_div .= '<div class=\'gamemitemcontactoption\'>'.$friend_username.' <span style=\'float: right;\'><span title=\'Remove from friends.\' onclick=\'FriendRemove('.$friend_id.');\' style=\'cursor: pointer;\'>&#10134;</span></span></div>';
         }
      }
      echo '<script type="text/javascript">
               $("#Coins").html("'.$user_coins.'");
               $("#Level").html("'.$user_level.'");
               $("#XP").html("'.$user_xp.'");
               $("#Online").html("'.$online_count.'");
               if($("#gamemitemcontactselecter").length) {
                  $("#gamemitemcontactselecter").html("'.$friends_div.'");
               }
               if(document.title!="Porntown \uD83D\uDC6A '.$online_count.'") {
                  document.title = "Porntown \uD83D\uDC6A '.$online_count.'";
               }
            </script>';
   }
   die('');
   exit;
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
<body onload="GameEngineStartup();">
   <div class="shell">
      <?php require'./system/content_header.php'; ?>
      <?php require'./system/content_menu.php'; ?>
      <div class="content">
         <div id="gameboard">
            <div id="gamesplash">
               <div class="gamesplashtext">
                  Welcome! Please wait,<br>
                  while the game loads.
               </div>
            </div>
         </div>
         <span id="gamescript"></span>
      </div>
      <?php require'./system/content_footer.php'; ?>
   </div>
   <script type="text/javascript"><?php require'./system/script_javascript_live.php'; ?></script>
</body>
</html>