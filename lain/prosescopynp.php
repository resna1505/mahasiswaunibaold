<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SELECT * FROM trpim WHERE THSMSTRPIM='{$tahun}{$semester}'";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $tmp = "\r\n            <table class=form>\r\n              <tr class=juduldata align=center >\r\n                <td>Kode PT</td>\r\n  \r\n                  <td>Semester Asal</td>\r\n                <td>Semester Tujuan</td>\r\n                <td>Status Penyalinan</td>\r\n              </tr>\r\n          ";
    while ( $d = sqlfetcharray( $h ) )
    {
        $q = "INSERT INTO trpim \r\n              (THSMSTRPIM,KDPTITRPIM ,\r\n              NMKTYTRPIM,NMSEYTRPIM,  NMBHYTRPIM, \r\n              NORETTRPIM, NOR1TTRPIM,NOR2TTRPIM,NOR3TTRPIM,NOR4TTRPIM,NOR5TTRPIM,\r\n              NOMYSTRPIM,\r\n               TGYS1TRPIM,TGYS2TRPIM,\r\n               NOMPTTRPIM, TGPT1TRPIM,  TGPT2TRPIM,  \r\n                  \r\n                  ADMLATRPIM ,ADMPATRPIM ,ADMLBTRPIM ,ADMPBTRPIM , ADMLCTRPIM ,ADMPCTRPIM ,\r\n                  PUSLATRPIM ,PUSPATRPIM ,PUSLBTRPIM ,PUSPBTRPIM ,PUSLCTRPIM , PUSPCTRPIM ,\r\n                  LABLATRPIM ,LABPATRPIM ,LABLBTRPIM, LABPBTRPIM ,LABLCTRPIM ,LABPCTRPIM ,\r\n                  TEKLATRPIM , TEKPATRPIM ,TEKLBTRPIM ,TEKPBTRPIM ,TEKLCTRPIM ,TEKPCTRPIM     \r\n                )\r\n              VALUES\r\n              ('{$tahun2}{$semester2}','{$d['KDPTITRPIM']}' ,\r\n              '{$d['NMKTYTRPIM']}','{$d['NMSEYTRPIM']}',  '{$d['NMBHYTRPIM']}', \r\n              '{$d['NORETTRPIM']}', '{$d['NOR1TTRPIM']}','{$d['NOR2TTRPIM']}','{$d['NOR3TTRPIM']}',\r\n              '{$d['NOR4TTRPIM']}','{$d['NOR5TTRPIM']}',\r\n              '{$d['NOMYSTRPIM']}',\r\n               '{$d['TGYS1TRPIM']}','{$d['TGYS2TRPIM']}',\r\n               '{$d['NOMPTTRPIM']}', '{$d['TGPT1TRPIM']}',  '{$d['TGPT2TRPIM']}',  \r\n                  \r\n                  '{$d['ADMLATRPIM']}' ,'{$d['ADMPATRPIM']}' ,'{$d['ADMLBTRPIM']}' ,\r\n                  '{$d['ADMPBTRPIM']}' , '{$d['ADMLCTRPIM']}' ,'{$d['ADMPCTRPIM']}' ,\r\n                  '{$d['PUSLATRPIM']}' ,'{$d['PUSPATRPIM']}' ,'{$d['PUSLBTRPIM']}' ,\r\n                  '{$d['PUSPBTRPIM']}' ,'{$d['PUSLCTRPIM']}' , '{$d['PUSPCTRPIM']}' ,\r\n                  '{$d['LABLATRPIM']}' ,'{$d['LABPATRPIM']}' ,'{$d['LABLBTRPIM']}', \r\n                  '{$d['LABPBTRPIM']}' ,'{$d['LABLCTRPIM']}' ,'{$d['LABPCTRPIM']}' ,\r\n                  '{$d['TEKLATRPIM']}' , '{$d['TEKPATRPIM']}' ,'{$d['TEKLBTRPIM']}' ,\r\n                  '{$d['TEKPBTRPIM']}' ,'{$d['TEKLCTRPIM']}' ,'{$d['TEKPCTRPIM']}' \r\n              )";
        mysqli_query($koneksi,$q);
        $ok = "Gagal";
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $ok = "OK";
        }
        $tmp .= "\r\n            <tr align=center>\r\n                <td>{$d['KDPTITRPIM']}</td>\r\n \r\n                  <td>".$arraysemester[$semester]." {$tahun}</td>\r\n                <td>".$arraysemester[$semester2]." {$tahun2}</td>\r\n                <td>{$ok}</td>\r\n            </tr>";
    }
    $tmp .= "</table>";
    printjudulmenukecil( "<b>Daftar Nama Pimpinan dan Tenaga Non-akademik yang disalin" );
    echo $tmp;
}
else
{
    printjudulmenukecil( "<b>Tidak ada data Nama Pimpinan dan Tenaga Non-akademik yang disalin" );
}
?>
