<?php
if($rq!==true) { die("Invalid Access"); exit; }
?>
      html, body {
         height: 100%;
         padding: 0px;
         margin: 0px;
      }
      body {
         font-family: 'Open Sans', sans-serif;
         font-size: 14px;
      }
      a {
         color: #FFFF00;
         text-decoration: none;
      }
      a[target="_blank"] {
         color: #FF0000;
      }
      input[type="text"], input[type="password"], input[type="email"], input[type="url"], input[type="tel"] {
         width: 100%;
         height: 22px;
         line-height: 22px;
         background: #FFFFFF;
         border: 1px solid #FF0000;
         border-radius: 4px;
         font-size: 16px;
         padding: 0px 3px;
         margin: 0px;
         cursor: pointer;
      }
      input[type="submit"], input[type="button"] {
         height: 28px;
         line-height: 28px;
         background: #FF0000;
         border: 0px;
         font-size: 14px;
         font-weight: bold;
         color: #FFFFFF;
         padding: 4px 10px;
         margin: 0px;
         cursor: pointer;
      }
      input[type="submit"]:hover, input[type="button"]:hover {
         color: #FFFF00;
      }
      .shell {
         position: relative;
         display: block;
         width: 100%;
         height: 100%;
         background: #222222;
         color: #FFFFFF;
         padding: 0px;
         margin: 0px;
      }
      .head-title {
         font-family: 'Indie Flower', cursive;
         font-size: 28px;
         font-weight: bold;
         z-index: 28001;
      }
      .head-stats {
         float: right;
         height: 22px;
         line-height: 22px;
         border: 0px;
         font-size: 12px;
         font-weight: bold;
         text-align: right;
         padding: 2px 4px;
         z-index: 28001;
      }
      .menu {
         width: 100%;
         background: #333333;
         padding: 0px;
         margin: 0px;
         z-index: 27001;
      }
      .menu-button {
         display: inline-block;
         height: 22px;
         line-height: 22px;
         background: #333333;
         color: #FFFF00;
         font-size: 14px;
         font-weight: bold;
         padding: 3px 6px;
         margin: 0px;
         cursor: pointer;
      }
      .menu-button:hover {
         background: #444444;
         color: #FFFFFF;
      }
      .content {
         display: block;
         width: 100%;
         height: calc(100% - 58px);
         background: url('./system/img_gamesplash.jpg');
         background-size: 100% 100%;
         background-repeat: no-repeat;
         color: #FFFFFF;
         font-size: 14px;
         padding: 0px;
         margin: 0px;
      }
      .footer {
         height: 22px;
         line-height: 22px;
         color: #FFFFFF;
         font-size: 12px;
         text-align: center;
         padding: 3px 0px;
         margin: 0px;
         z-index: 27001;
      }
      .content-pad {
         padding: 10px;
      }
      .content-title {
         font-family: 'Indie Flower', cursive;
         font-size: 18px; 
         font-weight: bold;
         text-align: center;
      }
      .selecterbox {
         width: 90%;
         background: #DDDDDD;
         border: 1px solid #333333;
         color: #000000;
         padding: 10px;
         margin: 10px auto;
      }
      .content-form {
         width: 40%;
         padding: 0px;
         margin: 10px auto;
      }

      
      #gameboard {
         position: relative;
         display: block;
         width: 100%;
         height: 100%;
         background: url('./system/<?php echo $cpbg; ?>');
         background-size: 100% 100%;
         background-repeat: repeat;
         border: 0px none #000000;
         padding: 0px;
         margin: 0px auto;
         z-index: 10001;
      }
      

      #gamesplash {
         width: 100%;
         height: 100%;
         background: url('./system/img_gamesplash.jpg');
         background-size: 100% 100%;
         background-repeat: no-repeat;
      }
      .gamesplashtext {
         position: absolute;
         top: 80px;
         left: calc(50% - 150px);
         width: 300px
         text-align: center;
         z-index: 19001;
      }
      .StartButton {
         position: absolute;
         top: 160px;
         left: calc(50% - 50px);
         width: 100px
         text-align: center;
         width: 100px !important;
         z-index: 19001;
      }

      .gameroomtitle {
         position: absolute;
         top: 0px;
         left: 3px;
         width: 100px;
         background: #FEFFE8;
         background: -moz-linear-gradient(top,  #FEFFE8 0%, #D6DBBF 100%);
         background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FEFFE8), color-stop(100%,#D6DBBF));
         background: -webkit-linear-gradient(top,  #FEFFE8 0%,#D6DBBF 100%);
         background: -o-linear-gradient(top,  #FEFFE8 0%,#D6DBBF 100%);
         background: -ms-linear-gradient(top,  #FEFFE8 0%,#D6DBBF 100%);
         background: linear-gradient(to bottom,  #FEFFE8 0%,#D6DBBF 100%);
         filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#FEFFE8', endColorstr='#D6DBBF',GradientType=0 );
         border: 1px solid #D6DBBF;
         border-radius: 0px 0px 4px 4px;
         color: #333333;
         font-family: verdana;
         font-size: 12px;
         font-weight: bold;
         padding: 1px 6px;
         margin: 0px;
         z-index: 19019;
      }
      .gamechangeplayer, .gamechangeplace, .gamemitemprofile, .gamemitemsettings, .gamemitemcontact, .gamemitemlogout {
         position: absolute;
         top: 0px;
         background: #FEFFE8;
         background: -moz-linear-gradient(top,  #FEFFE8 0%, #D6DBBF 100%);
         background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,#FEFFE8), color-stop(100%,#D6DBBF));
         background: -webkit-linear-gradient(top,  #FEFFE8 0%,#D6DBBF 100%);
         background: -o-linear-gradient(top,  #FEFFE8 0%,#D6DBBF 100%);
         background: -ms-linear-gradient(top,  #FEFFE8 0%,#D6DBBF 100%);
         background: linear-gradient(to bottom,  #FEFFE8 0%,#D6DBBF 100%);
         filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#FEFFE8', endColorstr='#D6DBBF',GradientType=0 );
         border: 1px solid #D6DBBF;
         border-radius: 0px 0px 4px 4px;
         color: #333333;
         font-family: verdana;
         font-size: 12px;
         font-weight: bold;
         padding: 1px 6px;
         margin: 0px;
         cursor: pointer;
         z-index: 19019;
      }
      .gamechangeplace {
         left: 126px;
      }
      .gamechangeplayer {
         left: 160px;
      }
      .gamemitemcontact {
         left: 193px;
      }
      .gamemitemprofile {
         left: 226px;
      }
      .gamemitemsettings {
         left: 259px;
      }
      .gamemitemlogout {
         right: 3px;
      }
      #balltickera {
         bottom: 3px;
         right: 3px;
      }
      #balltickerb {
         bottom: 3px;
         right: 15px;
      }
      .ballticker {
         position: absolute;
         width: 8px;
         height: 8px;
         border: 1px solid #000000;
         border-radius: 100%;
         padding: 0px;
         margin: -1px;
         z-index: 29001;
      }


      .flipplayer {
         transform: scale(-1, 1);
         -moz-transform: scale(-1, 1);
         -webkit-transform: scale(-1, 1);
         -o-transform: scale(-1, 1);
         -khtml-transform: scale(-1, 1);
         -ms-transform: scale(-1, 1);
      }
      .gameusername {
         position: absolute;
         height: 18px;
         line-height: 18px;
         background-color: #FFFFFF;
         border: 1px solid #DDDDDD;
         border-radius: 4px;
         color: #333333;
         text-align: center;
         font-family: verdana;
         font-size: 12px;
         padding: 1px 4px;
         margin: 0px;
         opacity: 0.4;
         filter: alpha(opacity=40);
         z-index: 11001;
      }
      .gameusermsg {
         position: absolute;
         width: 115px;
         background-color: #FFFFFF;
         border: 1px solid #DDDDDD;
         border-radius: 4px;
         color: #333333;
         font-family: verdana;
         font-size: 12px;
         padding: 1px;
         margin: 0px;
         opacity: 0.8;
         filter: alpha(opacity=80);
         z-index: 11001;
      }


      .gameplaceselecter {
         display: block;
         position: absolute;
         top: 0px;
         left: 0px;
         width: 170px;
         background: #555555;
         padding: 0px;
         margin: 0px;
         z-index: 19002;
      }
      .gameplaceoption {
         width: (100% - 6px);
         border: 0px;
         border-bottom: 1px solid #333333;
         color: #FFFF00;
         font-size: 14px;
         font-weight: bold;
         padding: 3px;
         margin: 0px;
         cursor: pointer;
      }
      .gameplaceoption:hover {
         background: #444444;
         color: #FFFFFF;
      }
      .gamemitemcontactselecter {
         display: block;
         position: absolute;
         top: 0px;
         left: 0px;
         width: 200px;
         height: 280px;
         background: #DDDDDD;
         color: #000000;
         padding: 0px;
         margin: 0px;
         overflow-x: hidden;
         overflow-y: visible;
         z-index: 19002;
      }
      .gamemitemcontactoption {
         width: (100% - 6px);
         border: 0px;
         border-top: 1px solid #CCCCCC;
         color: #000000;
         font-size: 14px;
         font-weight: bold;
         padding: 3px;
         margin: 0px;
      }
      .gamemitemcontactoption:hover {
         background: #BBBBBB;
         color: #000000;
      }
      .gameplayerselecter, .gamemitemprofileselecter, .gamemitemsettingsselecter {
         display: block;
         position: absolute;
         top: 0px;
         left: 0px;
         width: 100%;
         height: 100%;
         background: #555555;
         color: #FFFFFF;
         padding: 0px;
         margin: 0px;
         z-index: 19002;
      }
      .gameplayerselecters {
         display: inline-block;
         width: calc(50% - 15px);
         height: calc(100% - 60px);
         background: #DDDDDD;
         color: #000000;
         vertical-align: top;
         padding: 0px;
         margin: 30px 5px 30px 10px;
      }
      .gameplayerselecterd {
         display: inline-block;
         width: calc(50% - 15px);
         height: calc(100% - 60px);
         background: #DDDDDD;
         color: #000000;
         vertical-align: top;
         overflow-x: hidden;
         overflow-y: visible;
         padding: 0px;
         margin: 30px 10px 30px 5px;
      }


      .gamedefaultgirl {
         position: absolute;
         width: 119px;
         height: 200px;
         background: url('./system/img_player_default_female.png');
         z-index: 11001;
      }
      .gamepimp {
         position: absolute;
         width: 119px;
         height: 200px;
         background: url('./system/img_player_pimp.png');
         z-index: 11001;
      }


      #chatinput {
         position: absolute;
         bottom: 0px;
         left: 0px;
         width: calc(100% - 2px);
         height: 20px;
         line-height: 20px;
         background: #FFFFFF;
         border: 1px solid #000000;
         border-radius: 0px;
         font-family: verdana;
         font-size: 14px;
         padding: 0px;
         margin: 0px;
         opacity: 0.6;
         cursor: pointer;
         z-index: 20002;
      }

      
      .animation {
         background-image: url(sprite.png);
         height: 40px;
         width: 40px;
      }
      .animation:hover {
         -webkit-animation: sprite-animation .6s steps(4,end) infinite;
         animation: sprite-animation .6s steps(4,end) infinite;
      }
      @-webkit-keyframes sprite-animation {
         from { background-position: 0 0; }
         to { background-position: -160px 0; }
      }
      @keyframes sprite-animation {
         from { background-position: 0 0; }
         to { background-position: -160px 0; }
      }
