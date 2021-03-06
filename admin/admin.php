<?php
//token is not set yet so we will make it
if (!isset($settings["admin_authtoken"])){
  $settings["admin_authtoken"]=codegenerate(60);
}

$settings["admin_password"]="authdonesetupdone";
$settings_update=true;

include("admin/functions.php");

//Call home our key so we know we can be used
$domain=str_replace("www.", "", $_SERVER['HTTP_HOST']);
$checkin=get_contents("https://codewithss.org/api/instance_callhome?domain=".$domain."&authtoken=".$settings["admin_authtoken"]."");

//See if we are a API call
if (isset($_GET["command"])){
  include("admin/api.php");
}

//If we are not API call we are a page response to show the key
if (!isset($_GET["command"])){

  include("admin/top.php");

  $checkin=get_contents("https://codewithss.org/api/instance_setupfinished?authtoken=".$settings["admin_authtoken"]."");
  if ($checkin=="false"){
    echo '<div class="form-header"><h3>Connect Code</h3></div><div class="form-content">To setup this new instance and control it\'s updates and more go to <a href=\'https://codewithss.org/connect\' target=\'_new\'>https://codewithss.org/connect</a> and enter the code below to connect with your account.<BR><BR>';
    echo '<pre><code>'.$settings["admin_authtoken"].'</code></pre>';
    echo '</div>';
  }else{
    echo '<div class="form-header"><h3>All setup</h3></div><div class="form-content">You are all setup. You can manage your site install via your account on <a href=\'https://codewithss.org\' target=\'_new\'>https://codewithss.org</a>';
    echo '</div>';
  }

  include("admin/bottom.php");

}

?>
