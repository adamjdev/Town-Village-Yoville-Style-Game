<?php
if($rq!==true) { die("Invalid Access"); exit; }

session_start();
error_reporting(0);

if(file_exists('./system/system_functions.php')) { require'./system/system_functions.php'; }
else{ die('Functions file path is off or the file is gone'); }

$config_db_host = 'localhost';   // db server
$config_db_ln = 'username';      // db username
$config_db_pw = 'password';      // db password
$config_db_db = 'database_name'; // db name

$config_domain = 'http://hub.6te.net/village/';   // url to site, and path if not in root
$config_domainpath = '/village';        // folder path if not in root, if in root leave blank
$config_current_page = $_SERVER["REQUEST_URI"];

$confid_admins = array('the@adminsemail.com');  // admins email

$config_registrations = True;  // false to disable, true to enable registrations

$date = strtotime('now');
$ip = $_SERVER['REMOTE_ADDR'];

$config_db_preffix = 'pt_';
$config_db_accounts = $config_db_preffix.'accounts';
$config_db_transactions = $config_db_preffix.'transactions';
$config_db_chat = $config_db_preffix.'chat';
$config_db_friends = $config_db_preffix.'friends';

// $config_db_accounts - id,date,ip,last_date,last_ip,username,email,password,coins,xp,level,referrer,player,posx,posy,facing,room,status
// $config_db_transactions - id,date,user_id,type,coin,coins,amount,status
// $config_db_chat - id,date,room,user_id,username,message,status
// $config_db_friends - id,username,friend

mysql_connect($config_db_host, $config_db_ln, $config_db_pw) or die("Connection error: Unable to connect to database.");
mysql_select_db($config_db_db) or die("Connection error: Unable to select database.");

$sql = mysql_query("CREATE TABLE IF NOT EXISTS $config_db_accounts (id int(11) NOT NULL auto_increment,date varchar(300),ip TEXT,last_date varchar(300),last_ip TEXT,username TEXT,email TEXT,password TEXT,coins TEXT,xp TEXT,level TEXT,referrer TEXT,player TEXT,posx TEXT,posy TEXT,facing TEXT,room TEXT,status varchar(10), PRIMARY KEY(id))");
$sql = mysql_query("CREATE TABLE IF NOT EXISTS $config_db_transactions (id int(11) NOT NULL auto_increment,date varchar(300),user_id TEXT,type TEXT,coin TEXT,coins TEXT,amount TEXT,status varchar(10), PRIMARY KEY(id))");
$sql = mysql_query("CREATE TABLE IF NOT EXISTS $config_db_chat (id int(11) NOT NULL auto_increment,date varchar(300),room TEXT,user_id TEXT,username TEXT,message TEXT,status varchar(10), PRIMARY KEY(id))");
$sql = mysql_query("CREATE TABLE IF NOT EXISTS $config_db_friends (id int(11) NOT NULL auto_increment,username TEXT,friend TEXT, PRIMARY KEY(id))");

if(isset($_GET['promo'])) {
   $_SESSION['ref'] = security($_GET['promo']);
}

$online_count = 0;
$q = mysql_query("SELECT last_date, username FROM $config_db_accounts WHERE status='1'");
while($r = mysql_fetch_assoc($q)) {
   $on_last_date = $r['last_date'];
   $on_last_username = $r['username'];
   $date_past = strtotime('now -2 minutes');
   if($date_past<$on_last_date) {
      $online_count = $online_count + 1;
      //if($online_count=='1') { $online_list .= $on_last_username; }
      //else { $online_list .= ', '.$on_last_username; }
   }
}
$online_list = 'Online: '.$online_count;

if(isUser($config_db_accounts)===true) {
   $user_email = security($_SESSION['pu']);
   $_SESSION['pu'] = $_SESSION['pu'];
   $q = mysql_query("SELECT * FROM $config_db_accounts WHERE email='$user_email'");
   $r = mysql_fetch_assoc($q);
   $user_id = $r['id'];
   $user_date = $r['date'];
   $user_username = $r['username'];
   $user_email = $r['email'];
   $user_password = $r['password'];
   $user_coins = $r['coins'];
   $user_xp = $r['xp'];
   $user_level = $r['level'];
   $user_referrer = $r['referrer'];
   $user_player = $r['player'];
   $user_posx = $r['posx'];
   $user_posy = $r['posy'];
   $user_facing = $r['facing'];
   $user_room = $r['room'];
   $user_status = $r['status'];
   // $user_house = unserialize(base64_decode($user_house_data));
   if($_SERVER["REQUEST_URI"]==$config_domainpath.'/live.php?ajax=map') {
      $q = mysql_query("UPDATE $config_db_accounts SET last_date='$date' WHERE email='$user_email'");
   }
   $q = mysql_query("UPDATE $config_db_accounts SET last_ip='$ip' WHERE email='$user_email'");
   $challenge = $user_level * '1000';
   $user_xp_percent = ($user_xp / $challenge) * '100';
   if($user_xp>$challenge) {
      $updatecoins = $user_coins + $user_level;
      $user_xp = '0';
      $user_level = $user_level + '1';
      $Queryo = mysql_query("UPDATE $config_db_accounts SET xp='$user_xp' WHERE email='$user_email'");
      $Queryo = mysql_query("UPDATE $config_db_accounts SET level='$user_level' WHERE email='$user_email'");
      $Queryo = mysql_query("UPDATE $config_db_accounts SET coins='$updategold' WHERE email='$user_email'");
   }
   if($user_room=='Town Square') {
      $cpbg = 'img_gameboard.png';
   } elseif($user_room=='Beach') {
      $cpbg = 'img_gameboard_beach.png';
   } else {
      $cpbg = 'img_gameboard.png';
   }
}

?>