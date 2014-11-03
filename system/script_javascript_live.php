<?php
if($rq!==true) { die("Invalid Access"); exit; }

if($user_player=='0') {
   $user_player = 'gamedefaultgirl';
}

?>

var GameEngineSpeed = parseInt(20),
    GameEngineInt = parseInt(48),
    GameHandleX = parseInt(0),
    GameHandleY = parseInt(0),
    GameSplash = '#gamesplash',
    GameBoard = '#gameboard',
    GameScript = '#gamescript',
    GamePlayerSelecter = '#gameplayerselecter',
    GamePlaceSelecter = '#gameplaceselecter',
    GamePlayer = '#<?php echo $user_player; ?>',
    GamePlayerCln = '<?php echo $user_player; ?>',
    GameWidth = parseInt($(GameBoard).width()),
    GameHeight = parseInt($(GameBoard).height()),
    UserWalkMaxY = parseInt(GameHeight - 32),
    UserWalkMaxX = parseInt(GameWidth - 32),
    GamePlayerPosZ = parseInt(11000 + <?php echo $user_posy; ?>),
    GamePlayerFacing = '<?php echo $user_facing; ?>',
    BallTickerA = '#FFFF00',
    BallTickerB = '#FFFF00',
    KeysPressed = {},
    DistancePI = 3;

function GameEngine() {
   GameEngineInt = parseInt(GameEngineInt + 1);
   if(GameEngineInt==parseInt(50)) {
      GameEngineInt = parseInt(0);
      $(GameScript).load('live.php?ajax=map');
      if(BallTickerB=='#FFFF00') { BallTickerB = '#80FF00'; } else { BallTickerB = '#FFFF00'; }
      $("#balltickerb").css("background-color",BallTickerB);
   }
   if(BallTickerA=='#FFFF00') { BallTickerA = '#80FF00'; } else { BallTickerA = '#FFFF00'; }
   $("#balltickera").css("background-color",BallTickerA);
   var FlipPlayerPos = $(GamePlayer).position(),
       FlipPlayerPosX = parseInt(FlipPlayerPos.left);
   if(FlipPlayerPosX>GameHandleX) {
      if(GamePlayerFacing!='left') {
         GamePlayerFacing = 'left';
         var PlayerPos = $(GamePlayer).position(),
             PlayerPosX = parseInt(PlayerPos.left),
             PlayerPosY = parseInt(PlayerPos.top),
             GameAjaxLink = 'live.php?ajax=update&x='+PlayerPosX+'&y='+PlayerPosY+'&f='+GamePlayerFacing;
         $(GameScript).load(GameAjaxLink);
      }
      $(GamePlayer).addClass('flipplayer');
   } else {
      if(GamePlayerFacing!='right') {
         GamePlayerFacing = 'right';
         var PlayerPos = $(GamePlayer).position(),
             PlayerPosX = parseInt(PlayerPos.left),
             PlayerPosY = parseInt(PlayerPos.top),
             GameAjaxLink = 'live.php?ajax=update&x='+PlayerPosX+'&y='+PlayerPosY+'&f='+GamePlayerFacing;
         $(GameScript).load(GameAjaxLink);
      }
      $(GamePlayer).removeClass('flipplayer');
   }
   $(GamePlayer).css({
      left: function(index ,Old) { return UserCalculateX(Old, 37, 39); },
      top: function(index, Old)  { return UserCalculateY(Old, 38, 40); }
   });
}

function GameEngineStartup() {
   <?php if($msg!='') { echo 'alert("'.$msg.'");'; } ?>
   $(GameSplash).hide();
   $(GameBoard).append('<div id="balltickera" class="ballticker"></div>');
   $(GameBoard).append('<div id="balltickerb" class="ballticker"></div>');
   $(GameBoard).append('<span id="gameroomtitle" title="Current location: <?php echo $user_room; ?>" class="gameroomtitle"><?php echo $user_room; ?></span>');
   $(GameBoard).append('<span class="gamechangeplace" title="Change your location." onclick="$(\'#gameplaceselecter\').slideToggle(\'slow\');">&#127970;</span>');
   // house &#127968; speaker &#128266; unlock &#128275; lock &#128274;
   $(GameBoard).append('<div class="gameplaceselecter" id="gameplaceselecter"><br>'
                          +'<div class="gameplaceoption" onclick="$(\''+GameScript+'\').load(\'live.php?ajax=changelocation&set=town-square\');">Town Square</div>'
                          +'<div class="gameplaceoption" onclick="$(\''+GameScript+'\').load(\'live.php?ajax=changelocation&set=beach\');">Beach</div>'
                      +'</div>');
   $(GamePlaceSelecter).hide();
   $(GameBoard).append('<span class="gamechangeplayer" title="Change your character." onclick="$(\'#gameplayerselecter\').slideToggle(\'slow\');">&#128105;</span>');
   $(GameBoard).append('<div id="gameplayerselecter" class="gameplayerselecter">'
                         +'<div class="gameplayerselecters">'
                            +'Current Character:<br>'
                            +'<div class="'+GamePlayerCln+'"></div>'
                         +'</div>'
                         +'<div class="gameplayerselecterd">'
                            +'Choose Character:<br>'
                            +'<div class="gamedefaultgirl" onclick="$(\''+GameScript+'\').load(\'./live.php?ajax=changeplayer&set=gamedefaultgirl\');" style="display: inline-block; position: relative !important; cursor: pointer;"></div>'
                            +'<div class="gamepimp" onclick="$(\''+GameScript+'\').load(\'./live.php?ajax=changeplayer&set=gamepimp\');" style="display: inline-block; position: relative !important; cursor: pointer;"></div>'
                         +'</div>'
                      +'</div>');
   $(GamePlayerSelecter).hide();
   $(GameBoard).append('<span class="gamemitemcontact" title="Manage your friends." onclick="$(\'#gamemitemcontactselecter\').slideToggle(\'slow\');">&#128106;</span>');
   $(GameBoard).append('<div id="gamemitemcontactselecter" class="gamemitemcontactselecter"><br>'
                         +'<div class="gamemitemcontactoption">Loading friends...</div>'
                      +'</div>');
   $("#gamemitemcontactselecter").hide();
   $(GameBoard).append('<span class="gamemitemprofile" title="View your user profile." onclick="$(\'#gamemitemprofileselecter\').slideToggle(\'slow\');">&#128111;</span>');
   $(GameBoard).append('<div id="gamemitemprofileselecter" class="gamemitemprofileselecter"><br>'
                         +'<div class="selecterbox">'
                            +'<p style="text-align: center;">Account Profile</p>'
                            +'<p>Account ID: <span style="float: right;"><?php echo $user_id; ?></span></p>'
                            +'<p>Registration date: <span style="float: right;"><?php echo date("n/j/Y g:i:s A",$user_date); ?></span></p>'
                            +'<p>Public Username: <span style="float: right;"><?php echo $user_username; ?></span></p>'
                            +'<p>Email: <span style="float: right;"><?php echo $user_email; ?></span></p>'
                            +'<p>Coins: <span style="float: right;"><?php echo $user_coins; ?></span></p>'
                            +'<p>Referrer: <span style="float: right;"><?php echo $user_referrer; ?></span></p>'
                            +'<p>Level: <span style="float: right;"><?php echo $user_level; ?></span></p>'
                            +'<p>XP: <span style="float: right;"><?php echo $user_xp; ?></span></p>'
                            +'<p>Status: <span style="float: right;"><?php echo $user_status; ?></span></p>'
                            +'<p style="color: #FF0000; text-align: center;">The coins listed are virtual and have no real value!</p>'
                         +'</div>'
                      +'</div>');
   $("#gamemitemprofileselecter").hide();
   $(GameBoard).append('<span class="gamemitemsettings" title="Change your account settings." onclick="$(\'#gamemitemsettingsselecter\').slideToggle(\'slow\');">&#128295;</span>');
   $(GameBoard).append('<div id="gamemitemsettingsselecter" class="gamemitemsettingsselecter"><br>'
                         +'<form action="live.php" method="POST">'
                            +'<input type="hidden" name="action" value="chnagepw">'
                            +'<div class="selecterbox">'
                               +'<p style="text-align: center;">Change Passord</p>'
                               +'<p><input type="password" name="oldpassword" placeholder="Old Password"></p>'
                               +'<p><input type="password" name="newpassword" placeholder="New Password"></p>'
                               +'<p><input type="password" name="reppassword" placeholder="Repeat New Password"></p>'
                               +'<p style="text-align: right;"><input type="submit" name="submit" value="Change Password"></p>'
                            +'</div>'
                         +'</form>'
                      +'</div>');
   $("#gamemitemsettingsselecter").hide();
   $(GameBoard).append('<span class="gamemitemlogout" title="Logout of your account." onclick="window.location = \'logout.php\';">&#128099;</span>');
   $(GameBoard).append('<input type="text" id="chatinput" placeholder="Type here to chat!">');
   $("#chatinput").focus();
   $(GameBoard).append('<div id="'+GamePlayerCln+'" class="'+GamePlayerCln+'"></div>');
   $(GamePlayer).css("left","<?php echo $user_posx; ?>px");
   $(GamePlayer).css("top","<?php echo $user_posy; ?>px");
   $(GamePlayer).css("z-index",GamePlayerPosZ);
   setInterval(GameEngine,GameEngineSpeed);
   $(window).keydown(function(event) {
      KeysPressed[event.which] = true;
      if(event.which == '38')      { //$(GamePlayer).css("background-position","0px 0px"); // up arrow
      } else if(event.which == '40') { //$(GamePlayer).css("background-position","0px 64px"); // down arrow
      } else if(event.which == '37') { //$(GamePlayer).css("background-position","0px 96px"); // left arrow
      } else if(event.which == '39') { //$(GamePlayer).css("background-position","0px 32px"); // right arrow
      } else if(event.which == '17') { if($(ChatInputBox).is(":hidden")) { $(ChatInputBox).show(); $("#chatmessagebutton").hide(); } else { $(ChatInputBox).hide(); $("#chatmessagebutton").show(); } // ctrl 32=spacebar
      }
   });
   $(window).keyup(function(event) {
      KeysPressed[event.which] = false;
      if((event.which == '38')||(event.which == '40')||(event.which == '37')||(event.which == '39')) {
         var PlayerPos = $(GamePlayer).position(),
             PlayerPosX = parseInt(PlayerPos.left),
             PlayerPosY = parseInt(PlayerPos.top),
             GameAjaxLink = 'live.php?ajax=update&x='+PlayerPosX+'&y='+PlayerPosY+'&f='+GamePlayerFacing;
         $(GameScript).load(GameAjaxLink);
         //$(GamePlayer).css("background-position", "0px 64px");
      }
   });
   $('#chatinput').keydown(function (e) {
      if(e.keyCode==13) { PostMsg(); }
   })
   $(GameBoard).dblclick(function(e) {
      var PlayerMoveX,
          PlayerMoveY,
          PlayerMoveZ = 0,
          PlayersCenterX = $(GamePlayer).width() / 2,
          PlayersCenterY = $(GamePlayer).height();
      if(e.pageX || e.pageY) {
         PlayerMoveX = e.pageX;
         PlayerMoveY = e.pageY;
      } else {
         PlayerMoveX = e.clientX + document.body.scrollLeft + document.documentElement.scrollLeft;
         PlayerMoveY = e.clientY + document.body.scrollTop + document.documentElement.scrollTop;
      }
      PlayerMoveX -= $(GameBoard).offset().left;
      PlayerMoveY -= $(GameBoard).offset().top;
      PlayerMoveX = parseInt(PlayerMoveX - PlayersCenterX);
      PlayerMoveY = parseInt(PlayerMoveY - PlayersCenterY);
      PlayerMoveZ = parseInt(11000 + PlayerMoveY);
      $(GamePlayer).css("z-index",PlayerMoveZ);
      $(GamePlayer).animate({ 'top': PlayerMoveY + 'px', 'left': PlayerMoveX + 'px'}, 1000, function() {
         var GameAjaxLink = 'live.php?ajax=update&x='+PlayerMoveX+'&y='+PlayerMoveY+'&f='+GamePlayerFacing;
         $(GameScript).load(GameAjaxLink);
         //$(GamePlayer).css("background-position", "0px 64px");
      });
   });
   $(GameBoard).mousemove(function(event) {
      GameHandle(event.pageX,event.pageY);
   });
}
function PostMsg() {
   var ChatInputPost = "live.php?ajax=chatter&msg="+encodeURIComponent($("#chatinput").val());
   $(GameScript).load(ChatInputPost);
   $("#chatinput").val("");
}
function FriendRemove(fid) {
   var FriendRefresher = '#ui'+fid,
       FriendRemoveAjax = "live.php?ajax=friend&rem="+fid;
   $(FriendRefresher).html("<span title='Currently are not friends.' onclick='FriendAdd("+fid+");' style='cursor: pointer;'>&#10133;</span>");
   $(GameScript).load(FriendRemoveAjax);
}
function FriendAdd(fid) {
   var FriendRefresher = '#ui'+fid,
       FriendAddAjax = "live.php?ajax=friend&add="+fid;
   $(FriendRefresher).html("<span title='Currently are friends.' onclick='FriendRemove("+fid+");' style='cursor: pointer;'>&#10134;</span>");
   $(GameScript).load(FriendAddAjax);
}
function GameHandle(x,y) {
   GameHandleX = x;
   GameHandleY = y;
}
function UserCalculateX(Old, SetA, SetB) {
   var NewValue = parseInt(Old, 10) - (KeysPressed[SetA] ? DistancePI : 0) + (KeysPressed[SetB] ? DistancePI : 0);
   return NewValue < 0 ? 0 : NewValue > UserWalkMaxX? UserWalkMaxX : NewValue;
}

function UserCalculateY(Old, SetA, SetB) {
   var NewValue = parseInt(Old, 10)
                - (KeysPressed[SetA] ? DistancePI : 0)
                + (KeysPressed[SetB] ? DistancePI : 0);
   return NewValue < 0 ? 0 : NewValue > UserWalkMaxY? UserWalkMaxY : NewValue;
}