<?php

if($aksi == ''){
    $pilih = $_POST['pilih'];

    $jum = count($pilih);

    for ($a = 0; $a < $jum; $a++) {
        // Gunakan parameterisasi query untuk mencegah SQL injection
        $noref = mysqli_real_escape_string($koneksi, $pilih[$a]);
        
        // Gunakan prepared statement jika memungkinkan
        $q = "UPDATE biayakomponen_tagihan SET STATUS='PENDING' WHERE NOREC=?";
        
        $stmt = mysqli_prepare($koneksi, $q);
        
        if ($stmt) {
            mysqli_stmt_bind_param($stmt, "s", $noref);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
        } else {
            echo "Error dalam prepared statement: " . mysqli_error($koneksi);
        }
    }

    // $aksi = 'tagihanvamahasiswa';
}



?>