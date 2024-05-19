<?php
#echo "aaaa";exit();
#error_reporting(1);
include_once __DIR__ . "/BniEnc.php";
$root = "../";
include( $root."header.php" );

// FROM BNI
#$client_id1 = '10270';
#$client_id2 = '55554';

$client_id1 = '12213';
$client_id2 = '22253';
$client_id3 = '22256';

// URL utk simulasi pembayaran: http://dev.bni-ecollection.com/
$data = file_get_contents('php://input');

$data_json = json_decode($data, true);
#print_r($data_json);
#exit();
if (!$data_json) {
	// handling orang iseng
	echo '{"status":"999","message":"jangan iseng :D"}';
}
else {
	if ($data_json['client_id'] === $client_id1) {
		$qSecret1 = "SELECT SECRETKEY FROM komponenpembayaran WHERE 1=1 AND KODEREKENING2='{$client_id1}'";
		$hSecret1 = mysqli_query($koneksi,$qSecret1);
		$dSecret1 = mysqli_fetch_array($hSecret1);
		$secret_key1=$dSecret1['SECRETKEY'];


		$data_asli = BniEnc::decrypt(
			$data_json['data'],
			$client_id1,
			$secret_key1
		);

		if (!$data_asli) {
			// handling jika waktu server salah/tdk sesuai atau secret key salah
			echo '{"status":"999","message":"waktu server tidak sesuai NTP atau secret key salah."}';
		}
		else {
			
			$qInsert = "INSERT INTO bniva_paid (trx_id,virtual_account,customer_name,trx_amount,payment_amount,cumulative_payment_amount,
			payment_ntb,datetime_payment,datetime_payment_iso8601) 
			VALUES ('{$data_asli[trx_id]}','{$data_asli[virtual_account]}','{$data_asli[customer_name]}','{$data_asli[trx_amount]}',
			'{$data_asli[payment_amount]}','{$data_asli[cumulative_payment_amount]}','{$data_asli[payment_ntb]}',
			'{$data_asli[datetime_payment]}','{$data_asli[datetime_payment_iso8601]}')";
			#echo $qInsert.'<br>';exit();
			mysqli_query($koneksi,$qInsert);
        		if (mysqli_affected_rows($koneksi) > 0) {
				echo '{"status":"000"}';
			}
			exit;
		}
	}

	if ($data_json['client_id'] === $client_id2) {
		$qSecret2 = "SELECT SECRETKEY FROM komponenpembayaran WHERE 1=1 AND KODEREKENING='{$client_id2}'";
		$hSecret2 = mysqli_query($koneksi,$qSecret2);
		$dSecret2 = mysqli_fetch_array($hSecret2);
		$secret_key2=$dSecret2['SECRETKEY'];

		$data_asli = BniEnc::decrypt(
			$data_json['data'],
			$client_id2,
			$secret_key2
		);

		if (!$data_asli) {
			// handling jika waktu server salah/tdk sesuai atau secret key salah
			echo '{"status":"999","message":"waktu server tidak sesuai NTP atau secret key salah."}';
		}
		else {
			// insert data asli ke db
			
			$qInsert2 = "INSERT INTO bniva_paid (trx_id,virtual_account,customer_name,trx_amount,payment_amount,cumulative_payment_amount,
			payment_ntb,datetime_payment,datetime_payment_iso8601) 
			VALUES ('{$data_asli[trx_id]}','{$data_asli[virtual_account]}','{$data_asli[customer_name]}','{$data_asli[trx_amount]}',
			'{$data_asli[payment_amount]}','{$data_asli[cumulative_payment_amount]}','{$data_asli[payment_ntb]}',
			'{$data_asli[datetime_payment]}','{$data_asli[datetime_payment_iso8601]}')";
			#echo $q.'<br>';
			mysqli_query($koneksi,$qInsert2);
        		if (mysqli_affected_rows($koneksi) > 0) {
				echo '{"status":"000"}';
			}
			exit;
		}
	}

	if ($data_json['client_id'] === $client_id3) {
		$qSecret3 = "SELECT SECRETKEY FROM komponenpembayaran WHERE 1=1 AND KODEREKENING='{$client_id3}'";
		$hSecret3 = mysqli_query($koneksi,$qSecret3);
		$dSecret3 = mysqli_fetch_array($hSecret3);
		$secret_key3=$dSecret3['SECRETKEY'];

		$data_asli = BniEnc::decrypt(
			$data_json['data'],
			$client_id3,
			$secret_key3
		);

		if (!$data_asli) {
			// handling jika waktu server salah/tdk sesuai atau secret key salah
			echo '{"status":"999","message":"waktu server tidak sesuai NTP atau secret key salah."}';
		}
		else {
			// insert data asli ke db
			
			$qInsert3 = "INSERT INTO bniva_paid (trx_id,virtual_account,customer_name,trx_amount,payment_amount,cumulative_payment_amount,
			payment_ntb,datetime_payment,datetime_payment_iso8601) 
			VALUES ('{$data_asli[trx_id]}','{$data_asli[virtual_account]}','{$data_asli[customer_name]}','{$data_asli[trx_amount]}',
			'{$data_asli[payment_amount]}','{$data_asli[cumulative_payment_amount]}','{$data_asli[payment_ntb]}',
			'{$data_asli[datetime_payment]}','{$data_asli[datetime_payment_iso8601]}')";
			#echo $q.'<br>';
			mysqli_query($koneksi,$qInsert3);
        		if (mysqli_affected_rows($koneksi) > 0) {
				echo '{"status":"000"}';
			}
			exit;
		}
	}

}
?>

