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
include( "init.php" );
//printhtmlcetak( );
$cetak = $aksi = "cetak";
$border = " border=1 width=600 ";
if ( $pilihcetak == "" )
{
	if($aksi2 == "Cetak Excel"){
	
		#echo "lll";exit();
		include( "export_excel.php" );
		
	}else{
		#echo "vvv";exit();
		printhtmlcetak();
		include( "prosestampildosen.php" );
	}
}
else
{
	if($aksi2 == "Cetak Excel"){
	
	}
    elseif ( $pilihcetak == 1 )
    {
		printhtmlcetak();
        include( "prosestampiljadwal2.php" );
    }
}
?>
