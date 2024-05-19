<?php

include_once __DIR__ . "/BniEnc.php";

// FROM BNI
$client_id = '12213';
$secret_key = '89ceb0584beb03c6faf0d88ead0ca9f9';
$url = 'https://apibeta.bni-ecollection.com/';

$dataMahasiswa = "
    SELECT
        b.NAMA,
        b.EMAIL2,
        b.HP,
        SUM( BIAYA ) AS total 
    FROM
        biayakomponen_tagihan a
        JOIN mahasiswa b ON a.IDPRODI = b.IDPRODI 
        AND a.GELOMBANG = b.GELOMBANG 
        AND a.ANGKATAN = b.ANGKATAN
        JOIN komponenpembayaran c ON a.IDKOMPONEN = c.ID 
    WHERE
        b.ID = '$users' 
        AND YEAR ( a.TANGGAL )>= YEAR (
        NOW()) 
        AND a.STATUS = 'PENDING'
    GROUP BY
        b.NAMA,
        b.EMAIL2,
        b.HP
    ";

    $mahasiswa = doquery($koneksi,$dataMahasiswa);	
    $datas=mysqli_fetch_array($mahasiswa);

    $data_asli = array(
        'type' => 'createbilling',
        'client_id' => $client_id,
        'trx_id' => mt_rand(),
        'trx_amount' => $datas['total'],
        'billing_type' => 'c',
        'customer_name' => $datas['NAMA'],
        'customer_email' => $datas['EMAIL2'],
        'customer_phone' => $datas['HP'],
        'virtual_account' => '',
        'datetime_expired' => date('c', time() + 2 * 3600),
        'description' => 'Payment'
    );

    $hashed_string = BniEnc::encrypt(
        $data_asli,
        $client_id,
        $secret_key
    );

    $data = array(
        'client_id' => $client_id,
        'data' => $hashed_string,
    );

    $response = get_content($url, json_encode($data));
    $response_json = json_decode($response, true);

    if ($response_json['status'] !== '000') {
        // handling jika gagal
        var_dump($response_json);
    } else {
        $data_response = BniEnc::decrypt($response_json['data'], $client_id, $secret_key);
        $nova = $data_response['virtual_account'];
            $trx_id = $data_response['trx_id'];
            $datetime_payment = date('c', time() + 2 * 3600);
    }

    $item = $_POST['pilih'];

    $items = count($pilih);

    for ($i = 0; $i < $items; $i++) {
 
        // Gunakan parameterisasi query untuk mencegah SQL injection
        $noref = mysqli_real_escape_string($koneksi, $pilih[$a]);
        
        // Gunakan prepared statement jika memungkinkan
        $q = "UPDATE biayakomponen_tagihan SET STATUS='PENDING', NOVA=?, trx_id=?, datetime_payment=? WHERE NOREC=?";
       
        $stmt = mysqli_prepare($koneksi, $q);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "ssss", $nova, $trx_id, $datetime_payment, $noref);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            echo "Error dalam prepared statement: " . mysqli_error($koneksi);
        }
    }

    function get_content($url, $post = '') {
        $usecookie = __DIR__ . "/cookie.txt";
        $header[] = 'Content-Type: application/json';
        $header[] = "Accept-Encoding: gzip, deflate";
        $header[] = "Cache-Control: max-age=0";
        $header[] = "Connection: keep-alive";
        $header[] = "Accept-Language: en-US,en;q=0.8,id;q=0.6";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_HEADER, false);
        curl_setopt($ch, CURLOPT_VERBOSE, false);
        // curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_ENCODING, true);
        curl_setopt($ch, CURLOPT_AUTOREFERER, true);
        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36");

        if ($post)
        {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post);
        }

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $rs = curl_exec($ch);

        if(empty($rs)){
            var_dump($rs, curl_error($ch));
            curl_close($ch);
            return false;
        }
        curl_close($ch);
        return $rs;
    }