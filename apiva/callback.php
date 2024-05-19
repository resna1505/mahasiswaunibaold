<?php

include_once __DIR__ . "/BniEnc.php";


// FROM BNI
$client_id = '12213';
$secret_key = '89ceb0584beb03c6faf0d88ead0ca9f9';


// URL utk simulasi pembayaran: http://dev.bni-ecollection.com/


$data = file_get_contents('php://input');

$data_json = json_decode($data, true);

if (!$data_json) {
	// handling orang iseng
	echo '{"status":"999","message":"jangan iseng :D"}';
}
else {
	if ($data_json['client_id'] === $client_id) {
		$data_asli = BniEnc::decrypt(
			$data_json['data'],
			$client_id,
			$secret_key
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
			echo '{"status":"000"}';
			exit;
		}
	}
}