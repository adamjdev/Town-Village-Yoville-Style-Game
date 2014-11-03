<?php
function validate_email($email) {
   $return = false;
   if(strpos($email,'@')!==false) {
      if(strpos($email,'.')!==false) {
         $exploded = explode("@",$email);
         $user = $exploded[0];
         $suffix = substr($email,strrpos($email,'.')+1);
         $pre_user = $user.'@';
         $pre_suffix = '.'.$suffix;
         $carrier = str_replace($pre_user,'',$email);
         $carrier = str_replace($pre_suffix,'',$carrier);
         // strpos stripos - ($user)@($carrier).($suffix)
         if($user!='') {
            if($carrier!='') {
               $suffixes = array('ac','ad','ae','aero','af','ag','ai','al','am','an','ao','aq','ar','arpa','as','asia','at','au','aw','ax','az','ba','bb','bd','be','bf','bg','bh','bi','biz','bj','bm','bn','bo','br','bs','bt','bv','bw','by','bz','ca','cat','cc','cd','cf','cg','ch','ci','ck','cl','cm','cn','co','com','coop','cr','cs','cu','cv','cx','cy','cz','dd','de','dj','dk','dm','do','dz','ec','edu','ee','eg','eh','er','es','et','eu','fi','firm','fj','fk','fm','fo','fr','fx','ga','gb','gd','ge','gf','gh','gi','gl','gm','gn','gov','gp','gq','gr','gs','gt','gu','gw','gy','hk','hm','hn','hr','ht','hu','id','ie','il','im','in','info','int','io','iq','ir','is','it','je','jm','jo','jobs','jp','ke','kg','kh','ki','km','kn','kp','kr','kw','ky','kz','la','lb','lc','li','lk','lr','ls','lt','lu','lv','ly','ma','mc','md','me','mg','mh','mil','mk','ml','mm','mn','mo','mobi','mp','mq','mr','ms','mt','mu','museum','mv','mw','mx','my','mz','na','name','nato','nc','ne','net','nf','ng','ni','nl','no','nom','np','nr','nt','nu','nz','om','org','pa','pe','pf','pg','ph','pk','pl','pm','pn','post','pr','pro','ps','pt','pw','py','qa','re','ro','ru','rw','sa','sb','sc','sd','se','sg','sh','si','sj','sk','sl','sm','sn','so','sr','ss','st','store','su','sv','sy','sz','tc','td','tel','tf','tg','th','tj','tk','tl','tm','tn','to','tp','tr','travel','tt','tv','tw','tz','ua','ug','uk','um','us','uy','va','vc','ve','vg','vi','vn','vu','web','wf','ws','xxx','ye','yt','yu','za','zm','zr','zw');
               if(in_array($suffix,$suffixes)) {
                  $return = true;
               }
            }
         }
      }
   }
   return $return;
}
function validate_username($merchant) {
   $return = true;
   $deniers = array('$','{','}','[',']','(',')','@','#','%','^','&','*','+','-','/','\\','|','=','_','!','`','~','<','>',';',':');
   foreach($deniers as $denied) {
      if(strpos($merchant,$denied)!==false) {
         $return = false;
      }
   }
   if($merchant=='') {
      $return = false;
   }
   return $return;
}
function security($value) {
   if(is_array($value)) {
      $value = array_map('security', $value);
   } else {
      if(!get_magic_quotes_gpc()) {
         $value = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
      } else {
         $value = htmlspecialchars(stripslashes($value), ENT_QUOTES, 'UTF-8');
      }
      $value = str_replace("\\", "\\\\", $value);
   }
   return $value;
}
function encrypy($word) {
   $salt = sha1(md5('6B5sO90oZ'.$word.'1Qy7SKla4'));
   $encrypy_word = md5(sha1(md5($word.$salt)).$salt);
   return $encrypy_word;
}
function satoshisize($satoshitize) {
   return rtrim(rtrim(sprintf("%.8f", $satoshitize), "0"), ".");
}
function fee_withdraw($coin) {
   $fee = satoshisize(security('0.0005'));
   return $fee;
}
function minimum_withdraw($coin) {
   $min = satoshisize(security('0.001'));
   return $min;
}
function get_data($url) {
   $ch = curl_init();
   $timeout = 15;
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
   curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
   $data = curl_exec($ch);
   curl_close($ch);
   return $data;
}
function isUser($config_db_accounts) {
   if(isset($_SESSION['pu'])) {
      $email = security($_SESSION['pu']);
      $Query = mysql_query("SELECT email FROM $config_db_accounts WHERE email='$email'");
      if(mysql_num_rows($Query) === 1) { return true; } else { return false; }
   } else {
      return false;
   }
}
function altaccept_apikeys() {
   $apikeys = array('keya' => '5v3gq345f',
                    'keyb' => 'bw45bw4gpi');
   return $apikeys;
}
function altaccept_push($data) {
   $apikeys = altaccept_apikeys();
   $para = array("action" => urlencode("sell"),"keya" => urlencode($apikeys['keya']),"keyb" => urlencode($apikeys['keyb']),"coin" => urlencode($data['coin']),"amount" => urlencode($data['amount']),"email" => urlencode($data['email']),"comments" => urlencode($data['comments']),"success_url" => urlencode($data['success_url']));
   foreach($para as $key=>$value) { $params .= $key."=".$value."&"; }
   rtrim($params, "&");
   $ch = curl_init();
   curl_setopt($ch,CURLOPT_URL, "http://www.altaccept.com/api.php");
   curl_setopt($ch,CURLOPT_POST, count($para));
   curl_setopt($ch,CURLOPT_POSTFIELDS, $params);
   curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
   $feed_json = curl_exec($ch);
   curl_close($ch);
   $feed_arry = json_decode($feed_json,true);
   $address = $feed_arry['address'];
   return $address;
}
function altaccept_invoices() {
   $apikeys = altaccept_apikeys();
   $url = 'http://www.altaccept.com/api.php?act=invoices&keya='.$apikeys['keya'].'&keyb='.$apikeys['keyb'];
   $ch = curl_init();
   curl_setopt($ch,CURLOPT_URL, $url);
   curl_setopt($ch,CURLOPT_RETURNTRANSFER, 1);
   $feed_json = curl_exec($ch);
   curl_close($ch);
   return $feed_json;
}
?>