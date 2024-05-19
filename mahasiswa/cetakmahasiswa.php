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
$cetak = $aksi = "cetak";
$border = " border=1 width=600 ";
if ( $aksi2 == "Cetak" )
{
    printhtmlcetak( );
    include( "prosestampilmahasiswa.php" );
}
else if ( $aksi2 == "Cetak Lengkap" )
{
    $border = " border=1 width=900 ";
    printhtmlcetak();
    include( "prosestampilmahasiswalengkap.php" );
}
else if ( $aksi2 == "Cetak Data Dikti" )
{
    printhtmlcetak( );
    $border = " border=1 width=900 ";
    include( "prosestampilmahasiswadikti.php" );
}
else if ( $aksi2 == "Kartu" )
{
    if ( $STEIINDONESIA == 1 )
    {
        include( "proseskartustei.php" );
    }
    else
    {
        if ( $UNIVERSITAS == "UNIVERSITAS BOROBUDUR" )
        {
            include( "proseskartuuniversitasborobudur.php" );
        }
        else
        {
            include( "proseskartu.php" );
        }
    }
}
else if ( $aksi2 == "Kartu Baru" )
{
    include( "proseskartubaru.php" );
}
else if ( $aksi2 == "Permohonan NIMAN" )
{
    include( "prosesniman.php" );
}
else if ( $aksi2 == "Ekspor ke Pusaka" )
{
    printhtmlcetak( );
    include( "proseseksporpusaka.php" );
}
else
{
    printhtmlcetak( );
    include( "prosestampilkehadiran.php" );
}
?>
