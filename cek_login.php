<?php
include "config/koneksi.php";
function anti_injection($data){
  $filter = mysql_real_escape_string(stripslashes(strip_tags(htmlspecialchars($data,ENT_QUOTES))));
  return $filter;
}

$UserName = anti_injection($_POST['UserName']);
$PassWord  = anti_injection(md5($_POST['PassWord']));

// pastikan username dan password adalah berupa huruf atau angka.
if (!ctype_alnum($UserName) OR !ctype_alnum($PassWord)){
  include "error-login.php";
}
else {
$login=mysql_query("SELECT * FROM mx_user WHERE username='$UserName' AND password='$PassWord' AND Aktiv='Y'");
$ketemu=mysql_num_rows($login);
$r=mysql_fetch_array($login);

// Apabila username dan password ditemukan
if ($ketemu > 0){
  session_start();
  include "timeout.php";
	/*
  $_SESSION['KCFINDER']=array();
  $_SESSION['KCFINDER']['disabled'] = false;
  $_SESSION['KCFINDER']['uploadURL'] = "../tinymcpuk/gambar";
  $_SESSION['KCFINDER']['uploadDir'] = "";
	*/
  $_SESSION['is_login'] = 'yes';
  $_SESSION['id_User'] = $r['id_User'];
  $_SESSION['UserName'] = $r['UserName'];
  $_SESSION['PassWord'] = $r['PassWord'];
  $_SESSION['nm_Lengkap'] = $r['nm_Lengkap'];
  $_SESSION['UserLevel'] = $r['UserLevel'];
  $_SESSION['Sessid'] = $r['id_Session'];
  $_SESSION['Aktiv']  = $r['Aktiv'];
  
  // session timeout
  $_SESSION['login'] = 1;
  timer();

	//$sid_lama = session_id();
	
	//session_regenerate_id();

	//$sid_baru = session_id();

  //mysql_query("UPDATE users SET id_session='$sid_baru' WHERE username='$username'");
  header('location:chg_menu.php');
}
else{
  include "error-login.php";
}
}
?>
