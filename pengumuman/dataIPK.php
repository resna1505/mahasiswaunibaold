<?php
$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
header('Content-Type: application/json');
 
$sql="SELECT NLIPKTRAKM AS nilaiipk FROM trakm WHERE NIMHSTRAKM='{$users}' ORDER BY THSMSTRAKM DESC";
$qnow = mysqli_query($koneksi, $sql);

$rows = array();
$seriesNow = array();

if (0 < mysqli_num_rows($qnow )) {
    $rows['showInLegend'] = false;

    // Inisialisasi array data dengan nilai default 0
    $seriesNow = array_fill(0, 8, null);

    $index = 0; // Indeks untuk menyimpan data dari database

    while ($row = mysqli_fetch_array($qnow )) {
        // Simpan nilai sesuai indeks, dan ubah ke indeks berikutnya
        $seriesNow[$index++] = floatval($row['nilaiipk']);
    }

    // Ambil 8 data pertama untuk memastikan total 8 data
    $seriesNow = array_slice($seriesNow, 0, 8);

    $rows['color'] = '#797EF6';
    $rows['series'][] = array(
        'name' => 'IPS',
        'data' => $seriesNow,
        'color' => '#797EF6',
        'showInLegend' => false
    );
}

echo json_encode($rows);
mysqli_close($koneksi);
?>
