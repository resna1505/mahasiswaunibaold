<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $pilihan == "1" )
{
    include( "mahasiswabaru.php" );
}
else if ( $pilihan == "2" )
{
    include( "fasilitas.php" );
}
else if ( $pilihan == "3" )
{
    include( "pimpinan.php" );
}
else if ( $pilihan == "4" )
{
    include( "lab.php" );
}
else if ( $pilihan == "5" )
{
    include( "bobot.php" );
}
else if ( $pilihan == "6" )
{
    include( "copydikti.php" );
}
else if ( $pilihan == "7" || $pilihan == "" )
{
    include( "validasidikti.php" );
}
else if ( $pilihan == "8" )
{
    include( "isianjawaban.php" );
}
else
{
    if ( $pilihan == "9" )
    {
        include( "isiankuesioner.php" );
    }
    else
    {
        if ( $pilihan == "10" )
        {
            include( "sarana.php" );
        }
    }
}
?>
