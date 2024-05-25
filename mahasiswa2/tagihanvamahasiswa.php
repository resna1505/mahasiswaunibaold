<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$waktu = getdate( time( ) );
$ok = false;
#print_r($_POST);
if ($aksi2 == 'SELESAI'){

    $dataMhsVA = "
    SELECT
        mhs.NAMA,
        mhs.EMAIL2,
        mhs.HP,
        ba.VANUMB AS NOVA,
        ba.datetime_payment,
	ba.JUMLAH,
	ba.DENDA,
	ba.DISKON,
	ba.IDKOMPONEN,
	ba.JENIS,
	ba.TAHUN,
	ba.SEMESTER,
	DATE_FORMAT( ba.TANGGALTAGIHAN, '%M' ) AS BATASBAYAR,
	bk.BIAYA AS TOTALBIAYA 
    FROM
        buattagihanva AS ba
        INNER JOIN mahasiswa AS mhs ON mhs.ID = ba.IDMAHASISWA
        INNER JOIN komponenpembayaran AS kp ON ba.IDKOMPONEN = kp.ID 
	INNER JOIN biayakomponen AS bk ON bk.IDKOMPONEN = ba.IDKOMPONEN 
	AND mhs.IDPRODI = bk.IDPRODI 
	AND mhs.ANGKATAN = bk.ANGKATAN 
	AND bk.IDPRODI = mhs.IDPRODI 
	AND bk.GELOMBANG = mhs.GELOMBANG 
    WHERE
        mhs.ID = '$users' 
        AND ba.STATUS = 1";

    $mhsVA = doquery($koneksi, $dataMhsVA);
    $mhs = mysqli_fetch_array($mhsVA);

    $noref = mysqli_real_escape_string($koneksi, $mhs['NOVA']);

    $q = "UPDATE buattagihanva SET STATUS=2 WHERE VANUMB=? AND IDMAHASISWA=$users";

    $stmt = mysqli_prepare($koneksi, $q);
        
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $noref);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Error dalam prepared statement: " . mysqli_error($koneksi);
    }

    foreach($mhsVA as $items){
	$idkomponen=$items['IDKOMPONEN'];
	$diskon=$items['DISKON'];
	$denda=$items['DENDA'];
	$jumlah=$items['JUMLAH'];
	$semester=$items['SEMESTER'];
	$tahun=$items['TAHUN'];
	$jenis=$items['JENIS'];
	$totalbiaya=$items['TOTALBIAYA'];
	$batasbayar='';
    	if($items['IDKOMPONEN'] == '032'){
           $batasbayar=$items['BATASBAYAR'];
    	}

        $j = "INSERT INTO bayarkomponen 
        (IDMAHASISWA, IDKOMPONEN, TANGGALBAYAR, JENIS, TAHUNAJARAN, SEMESTER, CARABAYAR, DISKON, TANGGAL, USER, TGLUPDATE,  DENDA, BIAYA, JUMLAH, KET, BEASISWA) 
        VALUES ('$users', '$idkomponen', '" . date('Y-m-d') . "', '$jenis', '$tahun', '$semester', 4, '$diskon', '" . date('Y-m-d') . "', 'bniva', '" . date('Y-m-d H:i:s') . "', $denda, $totalbiaya, $jumlah, '$batasbayar', 0)";

        mysqli_query($koneksi, $j);
    }
}
if ($aksi2 == 'CEK'){

    $dataMhsVA = "
    SELECT
        mhs.NAMA,
        mhs.EMAIL2,
        mhs.HP,
        ba.VANUMB AS NOVA,
        ba.datetime_payment
    FROM
        buattagihanva AS ba
        INNER JOIN mahasiswa AS mhs ON mhs.ID = ba.IDMAHASISWA
        INNER JOIN komponenpembayaran AS kp ON ba.IDKOMPONEN = kp.ID 
    WHERE
        mhs.ID = '$users' 
        AND ba.STATUS = 0";

    $mhsVA = doquery($koneksi, $dataMhsVA);
    $mhs = mysqli_fetch_array($mhsVA);

    $noref = mysqli_real_escape_string($koneksi, $mhs['NOVA']);

    $q = "UPDATE buattagihanva SET STATUS='1' WHERE VANUMB=? AND IDMAHASISWA = $users";

    $stmt = mysqli_prepare($koneksi, $q);
        
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, "s", $noref);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
    } else {
        echo "Error dalam prepared statement: " . mysqli_error($koneksi);
    }
}
if ($aksi2 == 'BATAL'){
    
    $dataMhsVA = "
    SELECT
	    TRXID,
        SUM( (JUMLAH - DISKON) + DENDA ) AS JUMLAH,
        VANUMB 
    FROM
        buattagihanva 
    WHERE
        IDMAHASISWA = '$users' 
        AND `STATUS` = 0
    GROUP BY
        TRXID,
        VANUMB ";

    $mhsVA = doquery($koneksi, $dataMhsVA);
    $mhs = mysqli_fetch_array($mhsVA);

	// CEK BAYAR
	$vanumb = $mhs['VANUMB'];
	$cekBayar = "
	SELECT
		bp.* 
	FROM
		buattagihanva as bv
		INNER JOIN bniva_paid as bp on bp.virtual_account = bv.VANUMB
	WHERE
		VANUMB = '$vanumb'";
	$cekVA = doquery($koneksi, $cekBayar);

   if (mysqli_num_rows($cekVA) > 0) {
        $dataMhsVA = "
        SELECT
            mhs.NAMA,
            mhs.EMAIL2,
            mhs.HP,
            ba.VANUMB AS NOVA,
            ba.datetime_payment
        FROM
            buattagihanva AS ba
            INNER JOIN mahasiswa AS mhs ON mhs.ID = ba.IDMAHASISWA
            INNER JOIN komponenpembayaran AS kp ON ba.IDKOMPONEN = kp.ID 
        WHERE
            mhs.ID = '$users' 
            AND ba.STATUS = 0";
        $mhsVA = doquery($koneksi, $dataMhsVA);
        $mhs = mysqli_fetch_array($mhsVA);

        $noref = mysqli_real_escape_string($koneksi, $mhs['NOVA']);
        $q = "UPDATE buattagihanva SET STATUS='1' WHERE VANUMB=? AND IDMAHASISWA = $users";
        $stmt = mysqli_prepare($koneksi, $q);
            
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $noref);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            echo "Error dalam prepared statement: " . mysqli_error($koneksi);
        }
    } else {
	 // FROM BNI
	    include_once __DIR__ . "/BniEnc.php";
	    $client_id = '12213';
	    $secret_key = '89ceb0584beb03c6faf0d88ead0ca9f9';
	    $url = 'https://apibeta.bni-ecollection.com/';

            $dataMahasiswa="SELECT NAMA,HP,EMAIL2 FROM mahasiswa WHERE ID = '$users'";

            $mahasiswa = doquery($koneksi,$dataMahasiswa);	
            $datas=mysqli_fetch_array($mahasiswa);

            $data_asli = array(
                'client_id' => $client_id,
                'trx_id' => $mhs['TRXID'],
                'trx_amount' => $mhs['JUMLAH'],
                'customer_name' => $datas['NAMA'],
                'customer_email' => $datas['EMAIL2'],
                'customer_phone' => $datas['HP'],
                'datetime_expired' => date('c', time() + 5),
                'description' => 'Payment',                
                'type' => 'updateBilling',
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
                // Handling jika gagal
                var_dump($response_json);
            } else {
                $data_response = BniEnc::decrypt($response_json['data'], $client_id, $secret_key);
            }

        $noref = mysqli_real_escape_string($koneksi, $mhs['TRXID']);
        $del = "DELETE FROM buattagihanva WHERE TRXID= ? AND IDMAHASISWA=$users";
        $stmtDel = mysqli_prepare($koneksi, $del);

        if ($stmtDel) {
            mysqli_stmt_bind_param($stmtDel, "s", $noref);
            mysqli_stmt_execute($stmtDel);
            mysqli_stmt_close($stmtDel);
            $stmtUpdate = mysqli_prepare($koneksi, $q);
	   
        } else {
            echo "Error dalam prepared statement DELETE: " . mysqli_error($koneksi);
        }    
    }
}
if ($aksi2 == 'SIMPAN'){
    // Validate Get VA
    $dateVA="
    SELECT
        ba.TRXID,
        ba.VANUMB,
        ba.datetime_payment,
        pa.virtual_account 
    FROM
        buattagihanva AS ba
        LEFT JOIN bniva_paid AS pa ON pa.virtual_account = ba.VANUMB
    WHERE
        ba.IDMAHASISWA = '$users'
        AND ba.status = 0
    ";

    $cekGetVA = doquery($koneksi,$dateVA);
    $cekVA=mysqli_fetch_array($cekGetVA);

	if (count($_POST['pilih']) == 0) {
		$errmesg = "Tidak Ada data yang di pilih";
	} else {
		if ($cekVA['TRXID'] == NULL && $cekVA['virtual_account'] == NULL){
			include_once __DIR__ . "/BniEnc.php";

			// FROM BNI
			$client_id = '12213';
			$secret_key = '89ceb0584beb03c6faf0d88ead0ca9f9';
			$url = 'https://apibeta.bni-ecollection.com/';

            $total=0;
	    $diskon=0;
	    $denda=0;

            foreach ($_POST['pilih'] as $value) {
                parse_str($value, $data);
                if (isset($data['norec']) && isset($data['biaya'])) {
                    $norec = $data['norec'];
                    $biaya = $data['biaya'];
                    $idkomponen = $data['idkomponen'];
		    $diskon= $data['diskon'];
                    $denda= $data['denda'];		    	

                    $total += ($biaya)+$denda;
                }
            }

            $dataMahasiswa="SELECT NAMA,HP,EMAIL2 FROM mahasiswa WHERE ID = '$users'";

            $mahasiswa = doquery($koneksi,$dataMahasiswa);	
            $datas=mysqli_fetch_array($mahasiswa);

            $data_asli = array(
                'type' => 'createbilling',
                'client_id' => $client_id,
                'trx_id' => mt_rand(),
                'trx_amount' => $total,
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
                // Handling jika gagal
                var_dump($response_json);
            } else {
                $data_response = BniEnc::decrypt($response_json['data'], $client_id, $secret_key);
                $nova = $data_response['virtual_account'];
                $trx_id = $data_response['trx_id'];
                $datetime_payment = date('Y-m-d H:i:s', strtotime('+2 hours'));
            }

	    foreach ($_POST['pilih'] as $value) {
                parse_str($value, $data);
                if (isset($data['norec']) && isset($data['biaya'])) {
                    $norec = $data['norec'];
                    $biaya = $data['biaya'] + $data['diskon'];
                    $idkomponen = $data['idkomponen'];
                    $diskon= $data['diskon'];
                    $denda= $data['denda'];
                    $tahun= $data['tahun'];
                    $jenis= $data['jenis'];
                    $semester= $data['semester'];
		    $batasbayar = date('Y-m-d', strtotime($data['batasbayar']));

                    $q = "INSERT INTO buattagihanva 
                    (IDMAHASISWA, IDKOMPONEN, JUMLAH, DENDA, DISKON, TANGGAL, TANGGALTAGIHAN, JENISKOLOM, TAHUN, SEMESTER, BEASISWA, STATUS, TRXID, VANUMB, NOREC, JENIS, datetime_payment) 
                    VALUES ($users, '$idkomponen', '$biaya', '$denda', '$diskon', '".date('Y-m-d H:i:s')."', '$batasbayar', 'C', '$tahun', '$semester', 0.00, 0, $trx_id, $nova, '$norec', '$jenis', '".date('Y-m-d H:i:s', strtotime('+2 hours'))."')";

                    mysqli_query($koneksi, $q);

                    if (mysqli_affected_rows($koneksi) > 0) {
                        $errmesg = "Data pembayaran sudah disimpan";
                        $idupdate = mysqli_insert_id($koneksi);
                    } else {
                        echo "Error dalam mengeksekusi query: " . mysqli_error($koneksi);
                    }
                }
            }
    	}
        $aksi="tagihanvamahasiswa";
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

if ( $aksi == "tagihanvamahasiswa" )
{
    ini_set('max_execution_time', 60);
    // cek Status Date Payment
    $datePayment="
    SELECT
        ba.TRXID,
        VANUMB,
        ba.datetime_payment,
        pa.virtual_account 
    FROM
        buattagihanva AS ba
        LEFT JOIN bniva_paid AS pa ON pa.virtual_account = ba.VANUMB 
    WHERE
        ba.IDMAHASISWA = '$users'
    ";
    $cekDate = doquery($koneksi,$datePayment);
    $dateMhs=mysqli_fetch_array($cekDate);

    if(date('Y-m-d H:i:s') >= $dateMhs['datetime_payment'] && $dateMhs['virtual_account'] == NULL){
        $noref = mysqli_real_escape_string($koneksi, $dateMhs['VANUMB']);
        $del = "DELETE FROM buattagihanva WHERE VANUMB = ? AND IDMAHASISWA = $users";
        $stmtDel = mysqli_prepare($koneksi, $del);

        if ($stmtDel) {
            mysqli_stmt_bind_param($stmtDel, "s", $noref);
            mysqli_stmt_execute($stmtDel);
            mysqli_stmt_close($stmtDel);
        } else {
            echo "Error dalam prepared statement DELETE: " . mysqli_error($koneksi);
        }

    }

    $dataMahasiswa="
    SELECT
        mhs.NAMA,
        mhs.ID,
        pr.NAMA as NAMAPRODI,
        mhs.HP
    FROM
        mahasiswa AS mhs
        INNER JOIN prodi as pr on pr.id = mhs.IDPRODI
    WHERE mhs.id = '$users'";

    $dataMhs = doquery($koneksi,$dataMahasiswa);
    $bioMhs=mysqli_fetch_array($dataMhs);

    /*$dataBelumBayar="
    SELECT
	c.NAMA AS NAMAKOMPONEN,
	c.ID AS IDKOMPONEN,
	a.IDPRODI,
	b.GELOMBANG,
	a.SEMESTER,
	b.ID,
	b.NAMA,
	a.ANGKATAN,
	a.TAHUN,
	CASE WHEN a.TAHUN = '0000' THEN '-' ELSE CONCAT( CAST( a.TAHUN AS UNSIGNED ) - 1, '/', a.TAHUN ) END AS TAHUNAJARAN,
	c.JENIS,
	bk.BIAYA,
	CASE WHEN btd.NOREC IS NULL THEN 0 ELSE 1 END AS DISABLED	
	FROM
		biayakomponen_tagihan a
		JOIN mahasiswa b ON a.IDPRODI = b.IDPRODI 
		AND a.GELOMBANG = b.GELOMBANG 
		AND a.ANGKATAN = b.ANGKATAN
		LEFT JOIN biayakomponen_tagihan_mahasiswa AS bta ON bta.NOREC = a.NOREC
		JOIN komponenpembayaran c ON a.IDKOMPONEN = c.ID
		LEFT JOIN biayakomponen_tagihan_disabled AS btd ON btd.NOREC = a.NOREC 
		AND btd.IDMAHASISWA = b.ID
		JOIN biayakomponen AS bk ON bk.IDKOMPONEN = a.IDKOMPONEN 
		AND a.IDPRODI = bk.IDPRODI 
		AND b.ANGKATAN = bk.ANGKATAN 
		AND bk.IDPRODI = b.IDPRODI 
		AND bk.GELOMBANG = b.GELOMBANG 
	WHERE
		b.ID = '61119027' 
		AND bta.NOREC IS NULL 
		AND c.ID = 032 
 		AND a.TAHUN = 2023 
 		AND a.SEMESTER = 2
	GROUP BY
	c.NAMA,
	c.ID,
	a.IDPRODI,
	b.GELOMBANG,
	a.SEMESTER,
	b.ID,
	b.NAMA,
	a.ANGKATAN,
	a.TAHUN,
	c.JENIS,
	bk.BIAYA,
	DISABLED
	ORDER BY
	a.TAHUN,
	a.SEMESTER";*/
	 
	$dataBelumBayar="
    SELECT * FROM (SELECT
        c.NAMA AS NAMAKOMPONEN,
        c.ID AS IDKOMPONEN,
        a.IDPRODI,
        b.GELOMBANG,
        a.SEMESTER,
        b.ID,
        b.NAMA,
        a.ANGKATAN,
        a.TAHUN,
        CASE WHEN a.TAHUN = '0000' THEN '-' ELSE CONCAT( CAST( a.TAHUN AS UNSIGNED ) - 1, '/', a.TAHUN ) END AS TAHUNAJARAN,
        c.JENIS,
        bk.BIAYA,
        CASE WHEN btd.NOREC IS NULL THEN 0 ELSE 1 END AS DISABLED	
	FROM
		biayakomponen_tagihan a
		JOIN mahasiswa b ON a.IDPRODI = b.IDPRODI 
		AND a.GELOMBANG = b.GELOMBANG 
		AND a.ANGKATAN = b.ANGKATAN
		LEFT JOIN biayakomponen_tagihan_mahasiswa AS bta ON bta.NOREC = a.NOREC
		JOIN komponenpembayaran c ON a.IDKOMPONEN = c.ID
		LEFT JOIN biayakomponen_tagihan_disabled AS btd ON btd.NOREC = a.NOREC 
		AND btd.IDMAHASISWA = b.ID
		JOIN biayakomponen AS bk ON bk.IDKOMPONEN = a.IDKOMPONEN 
		AND a.IDPRODI = bk.IDPRODI 
		AND b.ANGKATAN = bk.ANGKATAN 
		AND bk.IDPRODI = b.IDPRODI 
		AND bk.GELOMBANG = b.GELOMBANG 
	WHERE
		b.ID = '$users'
		AND bta.NOREC IS NULL

    UNION ALL

    SELECT
        c.NAMA AS NAMAKOMPONEN,
        c.ID AS IDKOMPONEN,
        a.IDPRODI,
        b.GELOMBANG,
        a.SEMESTER,
        b.ID,
        b.NAMA,
        a.ANGKATAN,
        a.TAHUN,
        CASE WHEN a.TAHUN = '0000' THEN '-' ELSE CONCAT( CAST( a.TAHUN AS UNSIGNED ) - 1, '/', a.TAHUN ) END AS TAHUNAJARAN,
        c.JENIS,
        bk.BIAYA,
        CASE WHEN btd.NOREC IS NULL THEN 0 ELSE 1 END AS DISABLED 
    FROM
        biayakomponen_tagihan a
        JOIN mahasiswa b ON a.IDPRODI = b.IDPRODI 
        AND a.GELOMBANG = b.GELOMBANG 
        AND a.ANGKATAN = b.ANGKATAN
        JOIN biayakomponen_tagihan_mahasiswa AS bta ON bta.NOREC = a.NOREC 
        AND bta.IDMAHASISWA = b.ID
        JOIN komponenpembayaran c ON a.IDKOMPONEN = c.ID
        LEFT JOIN buattagihanva AS ba ON ba.NOREC = a.NOREC 
        AND ba.IDMAHASISWA = b.ID
        LEFT JOIN biayakomponen_tagihan_disabled AS btd ON btd.NOREC = a.NOREC 
        AND btd.IDMAHASISWA = b.ID 
        JOIN biayakomponen AS bk ON bk.IDKOMPONEN = a.IDKOMPONEN 
            AND a.IDPRODI = bk.IDPRODI 
            AND b.ANGKATAN = bk.ANGKATAN 
            AND bk.IDPRODI = b.IDPRODI 
            AND bk.GELOMBANG = b.GELOMBANG 
    WHERE
        b.ID = '$users' 
        AND ba.STATUS IS NULL 
        AND bta.NOREC IS NOT NULL ) AS x
    GROUP BY
        x.NAMA,
        x.ID,
        x.IDPRODI,
        x.GELOMBANG,
        x.SEMESTER,
        x.ID,
        x.NAMA,
        x.ANGKATAN,
        x.TAHUN,
        x.JENIS,
        x.BIAYA,
        x.DISABLED
    ORDER BY
        x.TAHUN,
        x.SEMESTER";
	// echo $dataBelumBayar.'<br>';
    $itemBelumBayar = doquery($koneksi,$dataBelumBayar);

    /*$dataUdahBayar = "
    SELECT
        SUM(JUMLAH) AS TOTAL,
        IDMAHASISWA,
        IDKOMPONEN,
        TAHUNAJARAN,
        SEMESTER 
    FROM
        bayarkomponen 
    WHERE
        IDMAHASISWA = '$users'
    GROUP BY
        IDMAHASISWA,
        IDKOMPONEN,
        TAHUNAJARAN,
        SEMESTER 
    ORDER BY
        IDKOMPONEN ASC,
        TAHUNAJARAN
    ";*/
	$dataUdahBayar = "
    SELECT
        SUM(JUMLAH+DISKON) AS TOTAL,
        IDMAHASISWA,
        IDKOMPONEN,
        TAHUNAJARAN,
        SEMESTER 
    FROM
        bayarkomponen 
    WHERE
        IDMAHASISWA = '$users'
		AND IDKOMPONEN = 032
    GROUP BY
        IDMAHASISWA,
        IDKOMPONEN,
        TAHUNAJARAN,
        SEMESTER 
    ORDER BY
        IDKOMPONEN ASC,
        TAHUNAJARAN
    ";
    $itemUdahBayar = doquery($koneksi, $dataUdahBayar);

    $results =array();
	$i=0;
    foreach($itemBelumBayar as $item){		
        $idKomponen = $item['IDKOMPONEN'];
        $tahun = $item['TAHUN'];
        $semester = $item['SEMESTER'];
        $idProdi = $item['IDPRODI'];
        $angkatan = $item['ANGKATAN'];
        $gelombang = $item['GELOMBANG'];

        $dataBeasiswa = "select DISKON from diskonbeasiswa where IDMAHASISWA = '$users' AND IDKOMPONEN = $idKomponen AND TAHUN = $tahun AND SEMESTER = $semester AND KATEGORI = 1 ";
        $itemBeasiswa = doquery($koneksi, $dataBeasiswa);

        $dscB=mysqli_fetch_array($itemBeasiswa);
        // print_r( $asdft['DISKON']);
        $dscbeasiswa = 0;
        if($dscB['DISKON'] > 100){
            $dscbeasiswa = $dscB['DISKON'];
        }else{
            $dscbeasiswa = ($dscB['DISKON'] / 100) * $item['BIAYA'];
        }

        $totaldscB = $item['BIAYA'] - $dscbeasiswa;            

        $dataDiskon = "select DISKON from diskonbeasiswa where IDMAHASISWA = '$users' AND IDKOMPONEN = $idKomponen AND TAHUN = $tahun AND SEMESTER = $semester AND KATEGORI = 2 ";
        $itemDiskon = doquery($koneksi, $dataDiskon);

        $dscD=mysqli_fetch_array($itemDiskon);
        $dscdiskon = 0;
        // print_r( $asdft['DISKON']);
        if($dscD['DISKON'] > 100){
            $dscdiskon = $dscD['DISKON'];
        }else{
            $dscdiskon = ($dscD['DISKON'] / 100) * $totaldscB;
        }

        $totaltagihan = $totaldscB - $dscdiskon;
        //  echo "a".$dscbeasiswa.'<br>';
        //  echo "b".$total.'<br>';
        //  echo "c".$totaldscB.'<br>';
        //  echo "d".$dscdiskon.'<br>';
        foreach($itemUdahBayar as $items){
			if ($item['ID'] == $items['IDMAHASISWA'] && $item['IDKOMPONEN'] == $items['IDKOMPONEN'] && $item['TAHUN'] == $items['TAHUNAJARAN'] && $item['SEMESTER'] == $items['SEMESTER']) {
                // echo "ITERASI=".$i.'<br>';
				// echo "TOTAL PERTAMA NILAINYA=".$total.'<br>';
				$total -= $items['TOTAL'];
				// echo "TOTAL KEDUA NILAINYA=".$total.'<br>';
				#$totalbayar=$items['TOTAL']+($dscbeasiswa+$dscdiskon);
				$totalbayar=$items['TOTAL'];
				// echo "TOTAL TAGIHAN =".$totaltagihan.'<br>';
                // echo "TOTAL BAYAR =".$totalbayar.'<br>';
				$tagharusbayar=$totaltagihan-$totalbayar;
				// echo "TAGIHAN YANG HARUS DIBAYAR=".($tagharusbayar).'<br>';
                if($tagharusbayar>0){
					$bktagihanmhs="select BIAYA,IDKOMPONEN,ANGKATAN,GELOMBANG,TAHUN, SEMESTER,TANGGALBAYAR2 from biayakomponen_tagihan where ".
					"IDPRODI = $idProdi and ANGKATAN = $angkatan and GELOMBANG = $gelombang and TAHUN = $tahun and SEMESTER = $semester ORDER BY
					TANGGALBAYAR2";
					// echo $bktagihanmhs.'<br>';
					$bkt= doquery($koneksi, $bktagihanmhs);
					#echo $asdf.'<br>';
					foreach($bkt as $ds){
						#echo $ds['BIAYA'].'<br>';
						// echo "TOTAL BAYAR LOOPING AWAL=".$totalbayar.'<br>';
						// echo "CICILAN=".$ds['BIAYA'].'<br>';
						// echo "JTH TEMPO=".$ds['TANGGALBAYAR2'].'<br>';
						#$totalbayar -= $ds['BIAYA'];
						if($totalbayar==0){
							$sisatagihan=$tagharusbayar;	
						}else{
							$sisatagihan=$ds['BIAYA']-$totalbayar;	                    
							
						}
						// echo "SISA TAGIHAN=".$sisatagihan.'<br>';	
						#if($totalbayar < 1){
						if($sisatagihan>0){	
							$detail[]=array(
								'IDKOMPONEN' => $ds['IDKOMPONEN'],
								'TANGGAL' => $ds['TANGGALBAYAR2'],
								#'BIAYA' => $ds['BIAYA']-abs($totalbayar),
								'BIAYA' => $tagharusbayar,
							);							
						}
						
						$totalbayar =$totalbayar-$ds['BIAYA'];	
						// echo "TOTAL BAYAR LOOPING KEDUA=".$totalbayar.'<br>';
								
					}
					// print_r($detail);
					// echo '<br>';
					$dataDenda = "select JENISDENDA,KATEGORIDENDA,DENDA from biayakomponen where IDKOMPONEN='$idKomponen' AND IDPRODI=$idProdi AND ANGKATAN=$angkatan AND GELOMBANG=$gelombang";
					$itemDenda = doquery($koneksi, $dataDenda);

					$dateNow = new DateTime();
					$targetDate = new DateTime($detail[$i]['TANGGAL']);
					$interval = $dateNow->diff($targetDate);
					$selisihHari = $interval->days;

					$denda=mysqli_fetch_array($itemDenda);
					$totalDenda=0;
					// echo $selisihHari;
					if($targetDate < $dateNow){
						if ( $denda['JENISDENDA'] == 0 ){
							if($denda['KATEGORIDENDA']==0){
								$totalDenda= ($denda['DENDA']/100)*$detail[$i]['BIAYA'];
							}else{
								$totalDenda= ($denda['DENDA']);
							}
						} else {
							if($denda['KATEGORIDENDA']==0){
								$totalDenda= ($detail[$i]['BIAYA']*( $denda['DENDA']/100))*$selisihHari;
							}else{
								$totalDenda= $denda['DENDA'] * $selisihHari;
							}
						}
					} 
					// echo $detail[0]['BIAYA'].' '.($denda['DENDA']/100). ' '. $selisihHari;exit();     
					#if($total > 0){
					#if($tagharusbayar > 0){	
						$results[] = array(
							'NAMAKOMPONEN' => $item['NAMAKOMPONEN'],
							'IDKOMPONEN' => $item['IDKOMPONEN'],
							'SEMESTER' => $item['SEMESTER'],
							'TANGGAL' => $item['TANGGAL'],
							'TANGGALTAGIHAN' => $item['TANGGALTAGIHAN'],
							'ID' => $item['ID'],
							'NAMA' => $item['NAMA'],
							'BIAYA' => $detail[$i]['BIAYA'],
							'BATASBAYAR' => $detail[$i]['TANGGAL'],
							'NOREC' => $item['NOREC'],
							'ANGKATAN' => $item['ANGKATAN'],
							'TAHUN' => $item['TAHUN'],
							'TAHUNAJARAN' => $item['TAHUNAJARAN'],
							'DENDA' => $totalDenda,
							'JENIS' => $item['JENIS'],
							'DISKON' => $total - $totaldscD,
							'TANGGALBAYAR2' => $detail[$i]['TANGGAL'],
							'DISABLED' => $item['DISABLED'],
							);
						#$total=0;
					#}
					$i++;
				}	
            }
        }
    }

    foreach ($itemBelumBayar as $data){
        $idKomponen = $data['IDKOMPONEN'];
        $tahun = $data['TAHUN'];
        $semester = $data['SEMESTER'];
        $idProdi = $data['IDPRODI'];
        $angkatan = $data['ANGKATAN'];
        $gelombang = $data['GELOMBANG'];

        $belumLunas = "SELECT * FROM bayarkomponen WHERE IDMAHASISWA = $users AND IDKOMPONEN = $idKomponen AND TAHUNAJARAN = $tahun AND SEMESTER = $semester";
        $dataBelumLunas = doquery($koneksi, $belumLunas);
        
        $dataBeasiswa = "select DISKON from diskonbeasiswa where IDMAHASISWA = '$users' AND IDKOMPONEN = $idKomponen AND TAHUN = $tahun AND SEMESTER = $semester AND KATEGORI = 1 ";
        $itemBeasiswa = doquery($koneksi, $dataBeasiswa);

        $dscB=mysqli_fetch_array($itemBeasiswa);
        // print_r( $asdft['DISKON']);
        $dscbeasiswa = 0;
        if($dscB['DISKON'] > 100){
            $dscbeasiswa = $dscB['DISKON'];
        }else{
            $dscbeasiswa = ($dscB['DISKON'] / 100) * $item['BIAYA'];
        }

        $totaldscB = $item['BIAYA'] - $dscbeasiswa;            

        $dataDiskon = "select DISKON from diskonbeasiswa where IDMAHASISWA = '$users' AND IDKOMPONEN = $idKomponen AND TAHUN = $tahun AND SEMESTER = $semester AND KATEGORI = 2 ";
        $itemDiskon = doquery($koneksi, $dataDiskon);

        $dscD=mysqli_fetch_array($itemDiskon);
        $dscdiskon = 0;
        // print_r( $asdft['DISKON']);
        if($dscD['DISKON'] > 100){
            $dscdiskon = $dscD['DISKON'];
        }else{
            $dscdiskon = ($dscD['DISKON'] / 100) * $totaldscB;
        }

        $bktagihanmhs="select BIAYA,IDKOMPONEN,ANGKATAN,GELOMBANG,TAHUN, SEMESTER,TANGGALBAYAR2 from biayakomponen_tagihan where ".
        "IDPRODI = $idProdi and ANGKATAN = $angkatan and GELOMBANG = $gelombang and TAHUN = $tahun and SEMESTER = $semester ORDER BY
        TANGGALBAYAR2";
        // echo $bktagihanmhs.'<br>';
        $bkt= doquery($koneksi, $bktagihanmhs);
        #echo $asdf.'<br>';

        foreach($bkt as $ds){
            #echo $ds['BIAYA'].'<br>';
            // echo "TOTAL BAYAR LOOPING AWAL=".$totalbayar.'<br>';
            // echo "CICILAN=".$ds['BIAYA'].'<br>';
            // echo "JTH TEMPO=".$ds['TANGGALBAYAR2'].'<br>';
            #$totalbayar -= $ds['BIAYA'];
            if($totalbayar==0){
                $sisatagihan=$tagharusbayar;	
            }else{
                $sisatagihan=$ds['BIAYA']-$totalbayar;
            }
            // echo "SISA TAGIHAN=".$sisatagihan.'<br>';
            if($sisatagihan>0){	
                $detail[]=array(
                    'IDKOMPONEN' => $ds['IDKOMPONEN'],
                    'TANGGAL' => $ds['TANGGALBAYAR2'],
                    #'BIAYA' => $ds['BIAYA']-abs($totalbayar),
                    'BIAYA' => $tagharusbayar,
                );							
            }
            
            $totalbayar =$totalbayar-$ds['BIAYA'];	
            // echo "TOTAL BAYAR LOOPING KEDUA=".$totalbayar.'<br>';
        }

        if(mysqli_fetch_array($dataBelumLunas) == NULL) {
            $results[] = array(
                'NAMAKOMPONEN' => $data['NAMAKOMPONEN'],
                'IDKOMPONEN' => $data['IDKOMPONEN'],
                'SEMESTER' => $data['SEMESTER'],
                'TANGGAL' => $data['TANGGAL'],
                'TANGGALTAGIHAN' => $data['TANGGALTAGIHAN'],
                'ID' => $data['ID'],
                'NAMA' => $data['NAMA'],
                'BIAYA' => $data['BIAYA'],
                'BATASBAYAR' => $detail[$i]['TANGGAL'],
                'NOREC' => $data['NOREC'],
                'ANGKATAN' => $data['ANGKATAN'],
                'TAHUN' => $data['TAHUN'],
                'TAHUNAJARAN' => $data['TAHUNAJARAN'],
                'DENDA' => $totalDenda,
                'JENIS' => $data['JENIS'],
                'DISKON' => $data['BIAYA'] - $totaldscD,
                'TANGGALBAYAR2' => $detail[$i]['TANGGAL'],
                'DISABLED' => $data['DISABLED'],
            );
        }
     }

    $dataKelebihanSKS = "
    SELECT
        SUM( SKSMAKUL ) as SKS,
        THNSM,
        SEMESTER,
        TAHUN
    FROM
        pengambilanmk 
    WHERE
        IDMAHASISWA = $users
    GROUP BY
        THNSM,
        SEMESTER,
        TAHUN";
    $kelebihanSKS = doquery($koneksi, $dataKelebihanSKS);

    foreach ($kelebihanSKS as $data){
        $sks = $data['SKS'];
        $tahun = $data['THNSM'];
        $semester = $data['SEMESTER'];
        $thn = $data['TAHUN'];

        $cekKelebihan = "
        SELECT
            SUM(tbk.SKSMKTBKMK) AS SKSLebih
        FROM
            mspst as spt
            INNER JOIN tbkmk as tbk ON spt.KDJENMSPST = tbk.KDJENTBKMK AND spt.KDPSTMSPST = tbk.KDPSTTBKMK AND spt.KDPTIMSPST = tbk.KDPTITBKMK 
            INNER JOIN mahasiswa as mhs ON mhs.IDPRODI = spt.IDX
        WHERE
            tbk.STKMKTBKMK = 'A'
            AND mhs.ID = '$users' 
            AND tbk.SEMESTBKMK=$semester
            AND tbk.THSMSTBKMK = $tahun";
        $dataCekKelebihan = doquery($koneksi, $cekKelebihan);
        $datas=mysqli_fetch_array($dataCekKelebihan);
        
        if($sks > $datas['SKSLebih'] && $datas['SKSLebih'] != NULL) {
            $SKSLebih="
            SELECT
                c.NAMA as NAMAKOMPONEN,
                bk.IDKOMPONEN,
                bk.BIAYA,
                mhs.NAMA,
                mhs.ANGKATAN,
                bk.DENDA
            FROM
                biayakomponen as bk
                INNER JOIN mahasiswa as mhs on mhs.IDPRODI = bk.IDPRODI AND mhs.ANGKATAN = bk.ANGKATAN AND mhs.GELOMBANG = bk.GELOMBANG
                INNER JOIN komponenpembayaran c ON bk.IDKOMPONEN = c.ID 
            WHERE
                bk.IDKOMPONEN = 99
                AND mhs.ID = $users";
            $nameSKSLebih = doquery($koneksi, $SKSLebih);
            $nameSKS=mysqli_fetch_array($nameSKSLebih);

            $cekBayarSKSLebih = "SELECT SUM(JUMLAH) as TOTAL FROM bayarkomponen WHERE IDMAHASISWA = $users AND IDKOMPONEN = 99 AND TAHUNAJARAN = $thn AND SEMESTER = $semester";
            $datacekBayarSKSLebih = doquery($koneksi, $cekBayarSKSLebih);
            $kelebihanSKS = mysqli_fetch_array($datacekBayarSKSLebih);

            if($kelebihanSKS == NULL || ($sks - $datas['SKSLebih'])*$nameSKS['BIAYA'] > $kelebihanSKS['TOTAL']) {
                $cekDiskon = "select * from diskonbeasiswa where IDMAHASISWA = $users and TAHUN = $thn and SEMESTER = $semester AND IDKOMPONEN = 99";
                $diskon = doquery($koneksi, $cekDiskon);
                $totalDiskon = mysqli_fetch_array($diskon);

            if($totalDiskon == NULL){
                $biaya=$nameSKS['BIAYA'];
            } else if ($totalDiskon['DISKON'] > 100) {
                $biaya=$nameSKS['BIAYA']-$totalDiskon['DISKON'];
            } else {
                $biaya=( 100 - $totalDiskon['DISKON'] ) / 100 * $nameSKS['BIAYA'];
            }

            $results[] = array(
                'NAMAKOMPONEN' => $nameSKS['NAMAKOMPONEN'],
                'IDKOMPONEN' => 99,
                'SEMESTER' => $data['SEMESTER'],
                'TANGGAL' => date('Y-m-d'),
                'TANGGALTAGIHAN' => date('Y-m-d'),
                'ID' => $sks - $datas['SKSLebih'],
                'NAMA' => $nameSKS['NAMA'],
                'BIAYA' => ($sks - $datas['SKSLebih'])*$nameSKS['BIAYA'],
                'BATASBAYAR' => date('Y-m-d'),
                'NOREC' => '99-SL',
                'ANGKATAN' => $nameSKS['ANGKATAN'],
                'TAHUN' => $thn,
                'TAHUNAJARAN' => $thn,
                'DENDA' => $nameSKS['DENDA'],
                'JENIS' => 3,
                'DISKON' => ($sks - $datas['SKSLebih'])*($nameSKS['BIAYA']-$biaya),
                'TANGGALBAYAR2' => date('d-m-Y'),
                'DISABLED' => 0,
                );
            }            
        }
    }

    $dataSemesterPendek = "
    SELECT
        SUM( SKSMAKUL ) as SKS,
        THNSM,
        SEMESTER,
        TAHUN
    FROM
        pengambilanmksp
    WHERE
        IDMAHASISWA = $users
    GROUP BY
        THNSM,
        SEMESTER,
        TAHUN";
    $semesterPendek = doquery($koneksi, $dataSemesterPendek);

    foreach ($semesterPendek as $data){
        $sks = $data['SKS'];
        $tahun = $data['THNSM'];
        $semester = $data['SEMESTER'];
        $thn = $data['TAHUN'];

        $cekSemesterPendek = "
        SELECT
            SUM( tbk.SKSMKTBKMK ) AS SKSLebih 
        FROM
            mspst as spt
            INNER JOIN tbkmk as tbk ON spt.KDJENMSPST = tbk.KDJENTBKMK AND spt.KDPSTMSPST = tbk.KDPSTTBKMK AND spt.KDPTIMSPST = tbk.KDPTITBKMK 
            INNER JOIN mahasiswa as mhs ON mhs.IDPRODI = spt.IDX
        WHERE
            tbk.STKMKTBKMK = 'A'
            AND mhs.ID = '$users' 
            AND tbk.SEMESTBKMK=$semester
            AND tbk.THSMSTBKMK = $tahun";
        $datacekSemesterPendek = doquery($koneksi, $cekSemesterPendek);
        $datasSP=mysqli_fetch_array($datacekSemesterPendek);
        
        if($sks > $datasSP['SKSLebih'] && $datasSP['SKSLebih'] != NULL) {
            $dataSemesterPendek="
            SELECT
                c.NAMA as NAMAKOMPONEN,
                bk.IDKOMPONEN,
                bk.BIAYA,
                mhs.NAMA,
                mhs.ANGKATAN,
                bk.DENDA
            FROM
                biayakomponen as bk
                INNER JOIN mahasiswa as mhs on mhs.IDPRODI = bk.IDPRODI AND mhs.ANGKATAN = bk.ANGKATAN AND mhs.GELOMBANG = bk.GELOMBANG
                INNER JOIN komponenpembayaran c ON bk.IDKOMPONEN = c.ID 
            WHERE
                bk.IDKOMPONEN = 98
                AND mhs.ID = $users";
            $nameSemesterPendek = doquery($koneksi, $dataSemesterPendek);
            $nameSKS=mysqli_fetch_array($nameSemesterPendek);

            $cekBayarSP = "SELECT SUM(JUMLAH) as TOTAL FROM bayarkomponen WHERE IDMAHASISWA = $users AND IDKOMPONEN = 98 AND TAHUNAJARAN = $thn AND SEMESTER = $semester";
            $datacekBayarSP = doquery($koneksi, $cekBayarSP);
            $SP = mysqli_fetch_array($datacekBayarSP);

            if($SP == NULL || ($sks - $datas['SKSLebih'])*$nameSKS['BIAYA'] > $SP['TOTAL']) {
            $cekDiskon = "select * from diskonbeasiswa where IDMAHASISWA = $users and TAHUN = $thn and SEMESTER = $semester AND IDKOMPONEN = 98";
            $diskon = doquery($koneksi, $cekDiskon);
            $totalDiskon = mysqli_fetch_array($diskon);

            if($totalDiskon == NULL){
                $biaya=$nameSKS['BIAYA'];
            } else if ($totalDiskon['DISKON'] > 100) {
                $biaya=$nameSKS['BIAYA']-$totalDiskon['DISKON'];
            } else{
                $biaya=( 100 - $totalDiskon['DISKON'] ) / 100 * $nameSKS['BIAYA'];
            }

            $results[] = array(
                'NAMAKOMPONEN' => $nameSKS['NAMAKOMPONEN'],
                'IDKOMPONEN' => 98,
                'SEMESTER' => $data['SEMESTER'],
                'TANGGAL' => date('Y-m-d'),
                'TANGGALTAGIHAN' => date('Y-m-d'),
                'ID' => $sks - $datas['SKSLebih'],
                'NAMA' => $nameSKS['NAMA'],
                'BIAYA' => ($sks - $datas['SKSLebih'])*$nameSKS['BIAYA'],
                'BATASBAYAR' => date('Y-m-d'),
                'NOREC' => '98-SP',
                'ANGKATAN' => $nameSKS['ANGKATAN'],
                'TAHUN' => $thn,
                'TAHUNAJARAN' => $thn,
                'DENDA' => $nameSKS['DENDA'],
                'JENIS' => 3,
                'DISKON' => ($sks - $datas['SKSLebih'])*($nameSKS['BIAYA']-$biaya),
                'TANGGALBAYAR2' => date('d-m-Y'),
                'DISABLED' => 0,
                );
            }            
        }
    }

    $ListPembayaran="
       SELECT
        mhs.NAMA,
        mhs.EMAIL2,
        mhs.HP,
        ba.VANUMB as NOVA,
        ba.datetime_payment,
        kp.NAMA as komponenpembayaran,
        ((ba.JUMLAH-ba.DISKON)+ba.DENDA) as BIAYA
    FROM
        buattagihanva as ba
        INNER JOIN mahasiswa as mhs on mhs.ID = ba.IDMAHASISWA
        INNER JOIN komponenpembayaran as kp ON ba.IDKOMPONEN = kp.ID 
    WHERE
        mhs.ID = '$users'
        AND (ba.STATUS = 0 OR ba.STATUS = 1)";
    $listBayar = doquery($koneksi,$ListPembayaran);

    $konfirmasiPembayaran="
    SELECT
        mhs.NAMA,
        mhs.EMAIL2,
        mhs.HP,
        ba.VANUMB AS NOVA,
        ba.datetime_payment,
        ((ba.JUMLAH-ba.DISKON)+ba.DENDA) AS total 
    FROM
        buattagihanva AS ba
        INNER JOIN mahasiswa AS mhs ON mhs.ID = ba.IDMAHASISWA
        INNER JOIN komponenpembayaran AS kp ON ba.IDKOMPONEN = kp.ID 
    WHERE
        mhs.ID = '$users' 
        AND ba.STATUS = 0
    GROUP BY
        mhs.NAMA,
        mhs.EMAIL2,
        mhs.HP,
        ba.VANUMB,
        ba.datetime_payment";

    $pembayaran = doquery($koneksi,$konfirmasiPembayaran);	
    $bayar=mysqli_fetch_array($pembayaran);
    $totalBayar=$bayar['total'];
    $NOVA=$bayar['NOVA'];
    $datetime_payment=$bayar['datetime_payment'];

    $prosesPembayaran="
    SELECT
        mhs.NAMA,
        mhs.EMAIL2,
        mhs.HP,
        ba.VANUMB AS NOVA,
        ba.datetime_payment,
        pa.trx_amount,
        ((ba.JUMLAH-ba.DISKON)+ba.DENDA) AS total
    FROM
        buattagihanva AS ba
        INNER JOIN mahasiswa AS mhs ON mhs.ID = ba.IDMAHASISWA
        LEFT JOIN bniva_paid AS pa ON pa.virtual_account = ba.VANUMB 
    WHERE
        mhs.ID = '$users' 
        AND ba.STATUS = 1
    GROUP BY
        mhs.NAMA,
        mhs.EMAIL2,
        mhs.HP,
        ba.VANUMB,
        ba.datetime_payment,
        pa.trx_amount";

    $prosesBayar = doquery($koneksi,$prosesPembayaran);	
    $bayarProses=mysqli_fetch_array($prosesBayar);
    $totalProses=$bayarProses['trx_amount'];
    $dateProses=$bayarProses['datetime_payment'];

    $statusTagihan = 'active';
    $actTagihan = '';
    $actPembayaran = 'disabled';
    $actBerhasil = 'disabled';
    if ($totalBayar > 0) {
        $statusPembayaran = 'active';
        $actPembayaran = '';
        $actTagihan = 'disabled';
        $actBerhasil = 'disabled';

        $statusTagihan = '';
        $statusProses = '';
    } else if (isset($bayarProses)){
        $judul = 'Kami, masih memproses transaksimu.';
        $subJudul = 'Lakukan refresh secara berkala';
        $statusTrx = 'Pending';
        if($totalProses > 0){
            $judul = 'Selamat, Tagihan Berhasil Dibayarkan';
            $subJudul = 'Terima kasih telah memenuhi kewajiban anda';
            $statusTrx = 'Berhasil';
        }
        $statusPembayaran = '';
        $statusTagihan = '';
        $statusProses = 'active';

        $actPembayaran = 'disabled';
        $actTagihan = 'disabled';
        $actBerhasil = '';
    }

	echo '
    <form name="form" action="index.php?aksi=tagihanvamahasiswa" method="post">
    <input type="text" name="aksi" value="tagihanvamahasiswa"/>	
    <div class="dashboard mt-5">
        <div class="container">
            <div class="row">
                <div class="col lg-12">';
                if($errmesg == 'Tidak Ada data yang di pilih'){
                    printmesg( $errmesg );
                }						
                    echo ' <div class="card">
                        <ul class="nav nav-tabs p-3" id="myTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link '.$statusTagihan.' border-0 '.$actTagihan.'" id="bayartagihan-tab" data-bs-toggle="tab" data-bs-target="#bayartagihan" type="button" role="tab" aria-controls="bayartagihan" aria-selected="true">
                                    <font style="font-size: 14px;">1. Bayar Tagihan</font>
                                </button>
                            </li>
                            <li class="nav-icon pt-2">
                                <i class="bi bi-chevron-right"></i>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link '.$statusPembayaran.' border-0 '.$actPembayaran.'" id="konfirmasipembayaran-tab" data-bs-toggle="tab" data-bs-target="#konfirmasipembayaran" type="button" role="tab" aria-controls="konfirmasipembayaran" aria-selected="false">
                                    <font style="font-size: 14px;">2. Konfirmasi Pembayaran</font>
                                </button>
                            </li>
                            <li class="nav-icon pt-2">
                                <i class="bi bi-chevron-right"></i>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link '.$statusProses.' border-0 '.$actBerhasil.'" id="pembayaranberhasil-tab" data-bs-toggle="tab" data-bs-target="#pembayaranberhasil" type="button" role="tab" aria-controls="pembayaranberhasil" aria-selected="false">
                                    <font style="font-size: 14px;">3. Pembayaran Berhasil</font>
                                </button>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show '.$statusTagihan.'" id="bayartagihan" role="tabpanel" aria-labelledby="bayartagihan-tab">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="row">
                                            <div class="col-lg-12"> ';
                                                $i = 1;
                                                $jumlahBaris = mysqli_num_rows($itemBelumBayar);
                                                if ($jumlahBaris > 0) {
                                                    foreach($results as $dresult)
                                                {
                                                    echo '<div class="card p-3 m-4">
                                                        <div class="d-flex justify-content-between">
                                                            <div class="form-check">
								<input class="form-check-input" type="checkbox" name="pilih[]" value="'."norec=".$dresult['NOREC']."&biaya=".$dresult['BIAYA']."&idkomponen=".$dresult['IDKOMPONEN']."&denda=".$dresult['DENDA']."&diskon=".$dresult['DISKON']."&tahun=".$dresult['TAHUN']."&semester=".$dresult['SEMESTER']."&jenis=".$dresult['JENIS']."&batasbayar=".$dresult['BATASBAYAR'].'" id="nilai_checkbox_'.$i.'"
                                                                ';
                                                                if ($dresult['DISABLED'] == 1) {
                                                                    echo 'disabled';
                                                                }
                                                                    echo ' >
                                                                <label class="form-check-label" for="nilai_checkbox_'.$i.'">
                                                                    <font style="font-size: 13px;">'.$dresult['NAMAKOMPONEN'].'</font>
                                                                </label>
                                                            </div>
                                                            <label class="form-check-label" for="nilai_checkbox_'.$i.'">
                                                                <font style="font-size: 13px;">'.$dresult['IDKOMPONEN'].'</font>
                                                            </label>
                                                        </div>
                                                        <hr style="margin: 3px;">
                                                        <div class="row mt-2">
                                                            <div class="col-6 col-sm-3 col-lg-3">
                                                                <p class="mb-1" style="color: #a9a9a9;font-size: 12px;">Jatuh Tempo</p>
                                                                <p style="font-size: 12px;">'.$dresult['BATASBAYAR'].'</p>
                                                            </div>
                                                            <div class="col-6 col-sm-3 col-lg-3">
                                                                <p class="mb-1" style="color: #a9a9a9;font-size: 12px;">Periode Waktu</p>
                                                                <p style="font-size: 12px;">';
                                                                if($dresult['JENIS'] == 2){
                                                                    echo ($dresult['TAHUN']-1).'/'.$dresult['TAHUN'];
                                                                } else if ($dresult['JENIS'] == 3) {
                                                                    if($dresult['SEMESTER'] == 1){
                                                                        $statusSmst=' Ganjil';
                                                                    }else{
                                                                        $statusSmst=' Genap';
                                                                    }
                                                                    echo ($dresult['TAHUN']-1).'/'.$dresult['TAHUN'] . $statusSmst;
                                                                } else {
                                                                    echo '--';
                                                                }
                                                                echo '</p>
                                                            </div>
                                                            <div class="col-6 col-sm-3 col-lg-3">
                                                                <p class="mb-1" style="color: #a9a9a9;font-size: 12px;">Denda</p>
                                                                <p style="font-size: 12px;">'.cetakuang($dresult['DENDA']).'</p>
                                                            </div>
                                                            <div class="col-6 col-sm-3 col-lg-3">
                                                                <p class="mb-1" style="color: #a9a9a9;font-size: 12px;">Tagihan</p>
                                                                <p style="font-size: 12px;">'.cetakuang($dresult['BIAYA']).'</p>
                                                            </div>
                                                        </div>
                                                    </div>';
                                                    ++$i;
                                                    }
                                                } else {
                                                    // Tidak ada baris dalam hasil kueri
                                                    echo '<div class="tab-content">
                                                        <div class="col-12 d-flex align-items-center justify-content-center pt-5 pe-5 ps-5">
                                                            <img src="foto/nodata.jpg" height="200" alt="">
                                                        </div>
                                                        <p class="text-center">Tidak ada tagihan perkuliahan</p>
                                                        <p class="text-center" style="color: #a9a9a9;font-size: 14px;padding-left: 5rem;padding-right: 5rem;">Yeay, saat ini Anda belum memiliki tagihan perkuliahan <br>yang harus dibayarkan. </p>
                                                    </div>';
                                                }
                                                
                                                echo'
                                            </div>
                                        </div>                                        
                                    </div>
                                    <div class="col-lg-4 pt-4 pe-5">
                                        <div class="card p-3">
                                            <p>Metode Pembayaran</p>
                                            <span>
                                                <div class="img-container">
                                                    <img src="foto/bank_bni.png" class="img-bank"> <font class="ps-2">Bank BNI</font>
                                                </div>
                                            </span>
                                        </div> 
                                        <div class="card p-3 mt-4 mb-4">
                                            <!-- <p>
                                                <span class="float-start">Total Bayar</span>
                                                <span class="float-end fw-bold">Rp. 1.185.000</span>
                                            </p> -->
                                            <div class="card p-2 mb-2" style="background-color: #FFFF99;">
                                                <p style="font-size: 12px;">
                                                    <i class="bi bi-exclamation-circle-fill" style="color: #FFD700;"></i>
                                                Total Bayar telah diakumulasi dengan biaya potongan dan denda yang dimiliki</p>
                                            </div>
                                            <button type="submit" value="SIMPAN" name="aksi2" class="btn btn-primary">
                                                <font style="font-size: 14px;">Bayar Tagihan</font>
                                            </button>
                                        </div>                                
                                    </div>
                                </div>                                                                
                            </div>

                            <div class="tab-pane fade show '.$statusPembayaran.'" id="konfirmasipembayaran" role="tabpanel" aria-labelledby="konfirmasipembayaran-tab">
                                <div class="row">
                                    <div class="col-12 col-sm-12 col-lg-8">
                                        <div class="row">
                                            <div class="col-6 col-lg-4 col-sm-5 d-flex align-items-center justify-content-center">
                                                <div class="tab-content">
                                                    <img src="foto/payment2.jpg" height="200" alt="">
                                                </div>
                                            </div>
                                            <div class="col-6 col-lg-8 col-sm-7 pt-2">
                                                <div>
                                                    <p class="fs-6 fw-bolder m-1">Segera Selesaikan Pembayaran Anda <br> Sebelum</p>
                                                    <p class="fs-6 fw-bolder text-danger">'.$datetime_payment.'</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-8 col-sm-8 col-lg-4 px-5 py-2">
                                        <div class="accordion" id="accordionExample">
                                            <div class="accordion-item">
                                                <h2 class="accordion-header" id="headingOne">
                                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne" style="padding: 10px;">
                                                        <img src="foto/bank_bni.png" height="15px" class="img-bank">
                                                    </button>
                                                </h2>
                                                <div id="collapseOne" class="accordion-collapse collapse" aria-labelledby="headingOne" data-bs-parent="#accordionExample">
                                                    <div class="accordion-body">
                                                        <p style="font-size: 12px;margin-bottom: 2px;">1. Akses BNI Mobile Banking dari handphone kemudian masukkan user ID dan password.</p>
                                                        <p style="font-size: 12px;margin-bottom: 2px;">2. Pilih menu "Transfer".</p>
                                                        <p style="font-size: 12px;margin-bottom: 2px;">3. Pilih menu "Virtual Account Billing" kemudian pilih rekening debet.</p>
                                                        <p style="font-size: 12px;margin-bottom: 2px;">4. Masukkan nomor Virtual Account Anda (contoh: 8241002201150001) pada menu "input baru".</p>
                                                        <p style="font-size: 12px;margin-bottom: 2px;">5. Tagihan yang harus dibayarkan akan muncul pada layar konfirmasi</p>
                                                        <p style="font-size: 12px;margin-bottom: 2px;">6. Konfirmasi transaksi dan masukkan Password Transaksi.</p>
                                                        <p style="font-size: 12px;margin-bottom: 2px;">7. Pembayaran Anda Telah Berhasil.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>                         
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="d-flex justify-content-between px-5 pb-2 pt-3">
                                        <div class="col-lg-6">
                                            <p class="fs-6 fw-bolder mb-0">Virtual Account</p>
                                            <p class="mb-1" style="color: #a9a9a9;font-size: 14px;">Bank BNI</p>
                                        </div>
                                        <div class="col-lg-6 text-end">
                                            <img src="foto/bank_bni.png" class="img-bank" height="30">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between px-5 py-2">
                                        <div class="col-lg-6">
                                            <p class="fs-6 fw-bolder mb-0">Nomor Virtual Account</p>
                                            <p class="mb-1" style="color: #a9a9a9;font-size: 14px;">'.$NOVA.'</p>
                                        </div>
                                        <!-- <div class="col-lg-6 text-end">
                                            <p class="mb-1" style="color: #a9a9a9;font-size: 14px;"> <i class="bi bi-files" style="color: #a9a9a9;"></i> Salin Nomor</p>
                                        </div> -->
                                    </div>
                                    <div class="d-flex justify-content-between px-5 py-2">
                                        <div class="col-lg-6">
                                            <p class="fs-6 fw-bolder mb-0">Total Pembayaran</p>
                                            <p class="mb-1 text-primary fw-bolder" style="font-size: 14px;">Rp. '.cetakuang($totalBayar).'</p>
                                        </div>                                        
                                    </div>
                                    <div class="col-12 px-5 py-3">
                                        <div class="row">
                                            <div class="d-grid gap-2 col-12 col-sm-12 col-lg-6 mx-auto mb-2">
                                                <button type="submit" value="BATAL" name="aksi2" class="btn btn-outline-primary">
                                                    <font style="font-size: 14px;">Batalkan Transaksi</font>
                                                </button>
                                            </div>
                                            <div class="d-grid gap-2 col-12 col-sm-12 col-lg-6 mx-auto mb-2">
                                                <button type="submit" value="CEK" name="aksi2" class="btn btn-primary">
                                                    <font style="font-size: 14px;">Cek Status Pembayaran</font>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div> 
                            </div>

                            <div class="tab-pane fade show '.$statusProses.'" id="pembayaranberhasil" role="tabpanel" aria-labelledby="pembayaranberhasil-tab">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">
                                            <div class="col-6 col-lg-4 col-sm-5 d-flex align-items-center justify-content-center">
                                                <div class="tab-content">
                                                    <img src="foto/payment2.jpg" height="200" alt="">
                                                </div>                                                
                                            </div>
                                            <div class="col-6 col-lg-8 col-sm-7 pt-2">
                                                <div>
                                                    <p class="fs-6 fw-bolder mb-2">'.$judul.'</p>
                                                    <p class="fs-6" style="color: #a9a9a9;">'.$subJudul.'</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>                                    
                                </div>
                                <div class="row">
                                    <div class="d-flex justify-content-between px-5 pt-3 pb-1">
                                        <div class="col-lg-6">
                                            <p class="fs-6 fw-bolder mb-1">Metode Pembayaran</p>
                                            <p class="mb-1" style="color: #a9a9a9;font-size: 14px;">Bank BNI</p>
                                        </div>
                                        <div class="col-lg-6 text-end">
                                            <img src="foto/bank_bni.png" class="img-bank" height="30">
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between px-5 py-1">
                                        <div class="col-lg-6">
                                            <p class="fs-6 fw-bolder mb-1">No. Invoice</p>
                                            <p class="mb-1" style="color: #a9a9a9;font-size: 14px;">'.$bayarProses['NOVA'].'</p>
                                        </div>
                                        <!-- <div class="col-lg-6 text-end">
                                            <p class="mb-1" style="color: #a9a9a9;font-size: 14px;"> <i class="bi bi-files" style="color: #a9a9a9;"></i> Salin Nomor</p>
                                        </div> -->
                                    </div>
                                    <div class="d-flex justify-content-between px-5 py-1">
                                        <div class="col-lg-6">
                                            <p class="fs-6 fw-bolder mb-1">Waktu Pembayaran</p>
                                            <p class="mb-1 fw-bolder" style="font-size: 14px;">'.$dateProses.'</p>
                                        </div>
                                        <div class="col-lg-6 text-end">
                                            <p class="mb-1 fw-bolder mb-1" style="color: #28a745;font-size: 14px;">'.$statusTrx.' 
                                                <i class="bi bi-check2-circle" style="color: #28a745;"></i>
                                            </p>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 px-5 pt-2">
                                        <p class="fs-6 fw-bolder mb-1">Pemilik Tagihan</p>
                                        <div class="row">
                                            <div class="d-flex justify-content-between px-5">
                                                <div class="col-lg-3">
                                                    <p class="mb-1" style="color: #a9a9a9;font-size: 14px;">Mahasiswa</p>
                                                </div>
                                                <div class="col-lg-9">
                                                    <p class="mb-1" style="color: #a9a9a9;font-size: 14px;">: '.$bioMhs[0].' ('.$bioMhs[1].')</p>
                                                </div>                                                
                                            </div>
                                            <div class="d-flex justify-content-between px-5">
                                                <div class="col-lg-3">
                                                    <p class="mb-1" style="color: #a9a9a9;font-size: 14px;">Perguruan Tinggi</p>
                                                </div>
                                                <div class="col-lg-9">
                                                    <p class="mb-1" style="color: #a9a9a9;font-size: 14px;">: Universitas Batam</p>
                                                </div>                                                
                                            </div>
                                            <div class="d-flex justify-content-between px-5">
                                                <div class="col-lg-3">
                                                    <p class="mb-1" style="color: #a9a9a9;font-size: 14px;">Program Studi</p>
                                                </div>
                                                <div class="col-lg-9">
                                                    <p class="mb-1" style="color: #a9a9a9;font-size: 14px;">: '.$bioMhs[2].'</p>
                                                </div>                                                
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-12 px-5 pt-2">
                                        <p class="fs-6 fw-bolder mb-0">Detail Pembayaran</p>
                                        <div class="row">
                                        ';
                                        $i = 1;
                                        while ( $ListPembayaran=mysqli_fetch_array($listBayar))
                                        {
                                        echo '<div class="d-flex justify-content-between px-5">
                                            <div class="col-lg-3">
                                                <p class="mb-1" style="color: #a9a9a9;font-size: 14px;">'.$ListPembayaran['komponenpembayaran'].'</p>
                                            </div>
                                            <div class="col-lg-9">
                                                <p class="mb-1 text-end" style="color: #a9a9a9;font-size: 14px;">Rp. '.cetakuang($ListPembayaran['BIAYA']).'</p>
                                            </div>                                                
                                        </div>';
                                            ++$i;
                                            }
                                                echo'
                                            <!-- <div class="d-flex justify-content-between px-5">
                                                <div class="col-lg-3">
                                                    <p class="mb-1" style="color: #a9a9a9;font-size: 14px;">Remedial (Sekali Bayar)</p>
                                                </div>
                                                <div class="col-lg-9">
                                                    <p class="mb-1 text-end" style="color: #a9a9a9;font-size: 14px;">Rp. '.cetakuang($bayarProses['total']).'</p>
                                                </div>                                                
                                            </div> -->                                           
                                        </div>
                                    </div>
                                    <div class="d-flex justify-content-between px-5 pt-2">
                                        <div class="col-lg-3">
                                            <p class="mb-1 fs-6">Total Pembayaran</p>
                                        </div>
                                        <div class="col-lg-9">
                                            <p class="mb-1 text-end fs-6">Rp. '.cetakuang($bayarProses['total']).'</p>
                                        </div>                                                
                                    </div>';
                                    if($totalProses > 0){
                                        echo '<div class="d-flex justify-content-between px-5 py-2">
                                            <button type="submit" value="SELESAI" name="aksi2" class="btn btn-outline-primary" style="width: 250px;"><font style="font-size: 14px;">Kembali ke Daftar Tagihan</font></button>
                                        </div>';
                                    }                                    
                                echo '</div> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </form>
';
}
?>
