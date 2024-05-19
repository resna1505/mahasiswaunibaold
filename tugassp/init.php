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
    $qfield = " AND dosenpengajarsp.IDDOSEN = '{$users}'";
    $href .= "iddosen={$users}&";
}
else if ( $jenisusers == 2 )
{
    $qfieldbahankuliah = " \r\n\tAND dosenpengajarsp.TAHUN=pengambilanmksp.TAHUN\r\n\tAND dosenpengajarsp.SEMESTER=pengambilanmksp.SEMESTER\r\n\tAND dosenpengajarsp.KELAS=pengambilanmksp.KELAS\r\n\tAND dosenpengajarsp.IDMAKUL=pengambilanmksp.IDMAKUL\r\n\tAND dosenpengajarsp.IDPRODI=mahasiswa.IDPRODI\r\n\tAND pengambilanmksp.IDMAHASISWA=mahasiswa.ID\t \r\n\t AND pengambilanmksp.IDMAHASISWA = '{$users}'";
    $tabeltambahan = ",pengambilanmksp,mahasiswa";
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
