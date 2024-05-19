<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

include( "judulfakultas.php" );
if ( $aksi == "tambah" )
{
    $hasil = prosestambah( $tabel, $id, $datahasil );
    $errmesg = $hasil[1];
    $datatabel = $hasil[2];
}
include( "descfakultas.php" );
printjudulmenu( "Tambah Data {$JUDULFAKULTAS}" );
printmesg( $errmesg );
echo createformtambah( $dataform, $datatabel, "class=form", "class=masukan" );
?>
