<?php
if($rq!==true) { die("Invalid Access"); exit; }
?>

var PageSpeed = parseInt(1000);
function PageStartup() {
   setInterval(PageDisplay,PageSpeed);
}
function PageDisplay() {
   var d = new Date(),
       datetime = (d.getMonth()+1)+"/"+d.getDate()+"/"+d.getFullYear()+" @ "+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds(),
       RandomColor = '#'+Math.round(0xffffff * Math.random()).toString(16);
   $("#date").html(datetime);
   // $("#date").css("color", RandomColor);
}
setTimeout(PageStartup,20);
