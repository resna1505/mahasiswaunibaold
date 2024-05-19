<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

#do
#{
    if ( $jenisusers == 2 )
    {
        $q = "SELECT DISTINCT TAHUN,SEMESTER FROM pengambilanmk WHERE IDMAHASISWA='{$users}' ORDER BY TAHUN DESC,SEMESTER DESC ";
        $h = mysqli_query($koneksi,$q);
        if ( !( 0 < sqlnumrows( $h ) ))
        {
            while( $d = sqlfetcharray( $h ) )
            {
                $arraytahunsem["{$d['TAHUN']}-{$d['SEMESTER']}"] = "".( $d[TAHUN] - 1 )."/{$d['TAHUN']}-".$arraysemester[$d[SEMESTER]]."";
            }
        }
		#while ( 1 );
    }
    $q = "SELECT DISTINCT TAHUN,SEMESTER FROM dosenpengajar WHERE IDDOSEN='{$users}' ORDER BY TAHUN DESC,SEMESTER DESC ";
	
    $h = mysqli_query($koneksi,$q);
#} while ( 0 );
#do
if (0 < sqlnumrows( $h ))
{
    while( $d = sqlfetcharray($h))
    {
        $arraytahunsem["{$d['TAHUN']}-{$d['SEMESTER']}"] = "".( $d[TAHUN] - 1 )."/{$d['TAHUN']}-".$arraysemester[$d[SEMESTER]]."";
        break;
    }
} 
#while ( 1 );
?>