<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SELECT * FROM jadwalkuliah WHERE IDMAKUL='{$idmakul}' AND TAHUN='{$tahun}' AND SEMESTER='{$semester}' AND IDPRODI='{$idprodi}' ORDER BY KELAS";
$h = mysqli_query($koneksi,$q);
if ( $from != "mobile" )
{
    printjudulmenu( "Mata Kuliah  - ".str_replace( "_", " ", $namamakul )." ".( $tahun - 1 )."/{$tahun} ".$arraysemester[$semester]."" );
}
else
{
    $tmpcetak .= "<h1>Mata Kuliah - ".str_replace( "_", " ", $namamakul )." ".( $tahun - 1 )."/{$tahun} ".$arraysemester[$semester]."</h1>";
}
if ( 0 < sqlnumrows( $h ) )
{
    do
    {
        if ( $d = sqlfetcharray( $h ) )
        {
            $tmpcetak .= "\r\n    <table class=form>\r\n      <tr align=left class=juduldata>\r\n        <td colspan=2><b>KELAS {$d['KELAS']}</td>\r\n      </tr>\r\n      <tr class=genap>\r\n        <td width=150>Ruangan</td>\r\n        <td>".$arrayruangan[$d[IDRUANGAN]]." </td>\r\n      </tr>\r\n      <tr class=ganjil>\r\n        <td>Hari/Jam</td>\r\n        <td>".$arrayhari[$d[HARI]]." / {$d['MULAI']} - {$d['SELESAI']}</td>\r\n      </tr>";
            $tmp = explode( "\n", $d[TIM] );
            $timpengajar = "";
            if ( 0 < count( $tmp ) )
            {
                foreach ( $tmp as $k => $v )
                {
                    if ( $v != "" )
                    {
                        $timpengajar .= "{$v} / ".getfield( "NAMA", "dosen", "WHERE ID='".trim( $v )."'" )."<br>";
                    }
                }
                $timpengajar = trim( $timpengajar, "/" );
            }
            $tmpcetak .= "\r\n      <tr class=genap>\r\n        <td >Tim Pengajar</td>\r\n        <td>{$timpengajar}</td>\r\n      </tr>\r\n    </table>\r\n    ";
            if ( $from != "mobile" )
            {
                echo $tmpcetak;
            }
        }
    } while ( 1 );
}
if ( $from != "mobile" )
{
    printmesg( "Maaf, jadwal kuliah untuk Mata Kuliah ini belum ada. " );
}
else
{
    $tmpcetak .= "Maaf, jadwal kuliah untuk Mata Kuliah ini belum ada. ";
}
?>
