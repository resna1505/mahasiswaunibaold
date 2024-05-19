<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( defined( "FOLDER_DB" ) )
{
    $FOLDERFILE = FOLDER_DB."/tugas/file";
    $FOLDERFILEHASIL = FOLDER_DB."/tugas/hasil";
}
else
{
    $FOLDERFILE = "../tugas/file";
    $FOLDERFILEHASIL = "../tugas/hasil";
}
include( "array.php" );
if ( $jenisusers == 1 )
{
    $qfield = " AND dosenpengajar.IDDOSEN = '{$users}'";
    $href .= "iddosen={$users}&";
}
else if ( $jenisusers == 2 )
{
    $qfieldbahankuliah = " \r\n\tAND dosenpengajar.TAHUN=pengambilanmk.TAHUN\r\n\tAND dosenpengajar.SEMESTER=pengambilanmk.SEMESTER\r\n\tAND dosenpengajar.KELAS=pengambilanmk.KELAS\r\n\tAND dosenpengajar.IDMAKUL=pengambilanmk.IDMAKUL\r\n\tAND dosenpengajar.IDPRODI=mahasiswa.IDPRODI\r\n\tAND pengambilanmk.IDMAHASISWA=mahasiswa.ID\t \r\n\t AND pengambilanmk.IDMAHASISWA = '{$users}'";
    $tabeltambahan = ",pengambilanmk,mahasiswa";
    $href .= "idmahasiswa={$users}&";
}
$TIPE_INTEGER = 0;
$TIPE_INTEGER0 = 1;
$TIPE_INTEGER1 = 2;
$TIPE_REAL = 3;
$TIPE_REAL0 = 4;
$TIPE_REAL1 = 5;
$TIPE_STRING = 6;
$arrayjenistugas[0] = "Upload File Tunggal";
$arrayjenistugas[1] = "Kegiatan Offline";
?>
