<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
periksaroot( );
if ( $jenisusers == 0 )
{
    mysqli_query($koneksi,"LOCK TABLE buattagihan");
    $q = "SELECT buattagihan.*,mahasiswa.NAMA,mahasiswa.IDPRODI,mahasiswa.ANGKATAN FROM mahasiswa,buattagihan WHERE \r\n mahasiswa.ID=buattagihan.IDMAHASISWA AND \r\n IDUSER='{$users}' AND\r\n buattagihan.TANGGALTAGIHAN='{$tanggal}'\r\n ORDER BY mahasiswa.IDPRODI,mahasiswa.ANGKATAN,IDMAHASISWA,IDKOMPONEN";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        while ( $d = sqlfetcharray( $h ) )
        {
            $arraydatamahasiswa[$d[IDMAHASISWA]] = $d;
            $arraydatatagihan[$d[IDMAHASISWA]][$d[IDKOMPONEN]] = $d;
            $arraydatakomponen[$d[IDKOMPONEN]] = $d[IDKOMPONEN];
            $arrayjumlahtagihan += $d[IDMAHASISWA];
        }
        $strtmp .= "\r\n    <table border=1>\r\n      \r\n      <tr align=center>\r\n        <td><b>No</td>\r\n        <td><b>NIM</td>\r\n        <td><b>Nama</td>\r\n        <td><b>Angkatan</td>\r\n        <td><b>Program Studi</td>\r\n        <td><b>Jumlah Tagihan</td>\r\n\r\n        ";
        foreach ( $arraydatakomponen as $idkomponen => $d )
        {
            $strtmp .= "\r\n          <td><b>".$arraykomponenpembayaran[$idkomponen]."</td>\r\n       ";
        }
        $strtmp .= "\r\n \r\n      </tr>\r\n    ";
        $i = 0;
        foreach ( $arraydatamahasiswa as $idmahasiswa => $d )
        {
            ++$i;
            $strtmp .= "\r\n      <tr >\r\n        <td nowrap>{$i}</td>\r\n        <td nowrap>{$d['IDMAHASISWA']}</td>\r\n        <td nowrap>{$d['NAMA']}</td>\r\n            <td nowrap align=center>{$d['ANGKATAN']}</td>\r\n            <td nowrap>".$arrayprodidep[$d[IDPRODI]]."</td>\r\n            <td nowrap align=right>".intval( $arrayjumlahtagihan[$idmahasiswa] )."</td>\r\n\r\n        ";
            foreach ( $arraydatakomponen as $idkomponen => $d2 )
            {
                $strtmp .= "\r\n          <td  nowrap align=right>".$arraydatatagihan[$idmahasiswa][$idkomponen][JUMLAH]."</td>\r\n       ";
            }
            $strtmp .= "\r\n       </tr>\r\n       ";
        }
        $strtmp .= "</table>";
        echo $strtmp;
    }
}
mysqli_query($koneksi,"UNLOCK TABLE buattagihan");
?>
