<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "\t\t\t\t\t\t\t\t";
echo $pilihan;exit();
if ( $pilihan == "lihat" )
{
    if ( $aksi == "" )
    {
        $aksi = "tampilkan";
    }
    include( "pesan.php" );
}
else if ( $pilihan == "kirim" )
{
    if ( $aksi == "" )
    {
        $aksi = "kirim";
    }
    include( "pesan.php" );
}
else if ( $pilihan == "klihat" )
{
    if ( $aksi == "" )
    {
        $aksi = "tampilkan";
    }
    include( "pesant.php" );
}
else if ( $pilihan == "isipesan" )
{
    if ( $aksi == "" )
    {
        $aksi = "isipesan";
    }
    include( "pesan.php" );
}
else
{
    if ( $pilihan == "konfig" )
    {
        include( "konfig.php" );
    }
    else
    {
        if ( $pilihan == "" )
        {
            if ( $aksi == "" )
            {
                $aksi = "tampilkan";
            }
            include( "pesan.php" );
        }
    }
}
?>
