<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$gambarbackground = "";
include( "../fungsibarcode128.php" );
$logo = file( "{$dirgambar}/logo.txt" );
$size = imgsizeproph( "{$dirgambar}/{$logo['0']}", 80 );
$stylecetak = " style='font-family:Arial;font-size:7pt;' ";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodi[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $iddosen != "" )
{
    $qfield .= " AND IDDOSEN='{$iddosen}'";
    $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
    $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
    $href .= "iddosen={$iddosen}&";
}
if ( $angkatan != "" )
{
    $qfield .= " AND ANGKATAN='{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
if ( $id != "" )
{
    $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
    $qjudul .= " NIM mengandung kata '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $nama != "" )
{
    $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $status != "" )
{
    $qfield .= " AND mahasiswa.STATUS='{$status}'";
    $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
}
if ( $sort == "" )
{
    $sort = " ID";
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM mahasiswa \r\n\tWHERE 1=1 {$qprodidep2}\r\n\t{$qfield}\r\n\t";
$h = doquery($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT mahasiswa.NAMA,mahasiswa.ID ,\r\n\tprodi.NAMA AS NAMAP,fakultas.NAMA AS NAMAF\r\n  FROM mahasiswa,prodi,departemen,fakultas\r\n\tWHERE 1=1 AND\r\n  mahasiswa.IDPRODI=prodi.ID AND\r\n  prodi.IDDEPARTEMEN=departemen.ID AND\r\n  departemen.IDFAKULTAS=fakultas.ID\r\n  {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY {$sort} {$qlimit}";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $baris = 0;
    $kolom = 0;
    #do
	while( $d = sqlfetcharray( $h ))
    {
        if ( !( $d = sqlfetcharray( $h ) ) )
        {
            break;
        }
        else
        {
            ++$baris;
            $l = 1;
            createbarcode128( "{$d['ID']}", "barcode/{$d['ID']}", "B", 0 );
            echo "\t\t<table width=319 height=200 border=1 cellspacing=0 cellpadding=0\r\n\t\tstyle='border:yes;border-width:1;border-collapse:collapse;'\r\n    style='background:url(";
            echo $gambarbackground;
            echo ");'>\r\n\t\t<tr><td>\r\n\t\t<table width=319 height=200 border=0 cellspacing=4 cellpadding=0 \r\n\t\t style='border:yes;border-width:1;border-collapse:collapse;'>\r\n\t\t<tr valign=middle >\r\n\t\t<td colspan=3  align=center valign=middle   \r\n    >\r\n\t \r\n\t\t\r\n\t\t";
            echo "\r\n\t\t<img valign=middle align=left src='{$dirgambar}/{$logo['0']}' style='font-size:6pt;'  height=60 border=0> \r\n \r\n\t\t<b>\r\n\t\t<font style='font-size:6pt;'>\r\n\t\t<br></font>\r\n\t\t\r\n\t\t<font style='font-size:10pt;'>\r\n\t\t{$namakantor}</b></font> \r\n\t\t<font style='font-size:6pt;'><br>{$alamat}</font>\r\n\t\t \r\n\t\t</td><td>\r\n\t\t </td>\r\n\t\t</tr>\r\n\t\t<tr valign=top>\r\n \t\t\t<td>\r\n\t\t<table  width=95% border=0 cellpadding=0 cellspacing=0>\r\n\t\t  <tr  valign=top>\r\n\t\t   <td Nowrap {$stylecetak}\r\n\t\t     valign=top width=80>Nama Lengkap</td>\r\n\t\t   <td width=1%  {$stylecetak}>:</td>\r\n\t\t   <td {$stylecetak}><strong>{$d['NAMA']}</strong></td>\r\n\t\t  </tr>\r\n\t\t  <tr    valign=top>\r\n\t\t   <td nowrap {$stylecetak}\r\n\t\t     valign=top>NPM</td>\r\n\t\t   <td  {$stylecetak} >:</td>\r\n\t\t   <td {$stylecetak}  >".nl2br( $d[ID] )."</td>\r\n\t\t  </tr>\r\n\t\t  <tr    valign=top>\r\n\t\t   <td nowrap {$stylecetak}\r\n\t\t     valign=top>Fakultas</td>\r\n\t\t   <td  {$stylecetak} >:</td>\r\n\t\t   <td {$stylecetak}  >".nl2br( $d[NAMAF] )."</td>\r\n\t\t  </tr>\r\n\t\t  <tr    valign=top>\r\n\t\t   <td nowrap {$stylecetak}\r\n\t\t     valign=top>Prodi</td>\r\n\t\t   <td  {$stylecetak} >:</td>\r\n\t\t   <td {$stylecetak}  >".nl2br( $d[NAMAP] )."</td>\r\n\t\t  </tr>\r\n\t\t  <tr    valign=top>\r\n\t\t   <td nowrap {$stylecetak}\r\n\t\t     valign=top>Berlaku Sampai</td>\r\n\t\t   <td  {$stylecetak} >:</td>\r\n\t\t   <td {$stylecetak}  ></td>\r\n\t\t  </tr>\r\n \r\n  \r\n   \t\t  </table>\r\n\r\n      </td><td>\r\n \t\t\t<table width=100% border=1>\r\n \t\t\t<tr valign=top>\r\n\t\t <td align=center  > \r\n\t\t ";
        }
        if ( file_exists( "foto/{$d['ID']}" ) )
        {
            echo "\r\n\t\t\t  \r\n\t\t\t   <img src='foto/{$d['ID']}' height=100  >";
        }
        else
        {
            echo " ";
        }
        echo "\r\n\t\t </td>\r\n\r\n\t</tr>\r\n</table>\r\n\r\n  \r\n\t\t </td>\r\n\t\t </tr>\r\n <tr>\r\n <td colspan=2 >\r\n";
        if ( file_exists( "barcode/{$d['ID']}.png" ) )
        {
            echo "\r\n\t\t\t  \r\n\t\t\t   <img src='barcode/{$d['ID']}.png'  >";
        }
        else
        {
            echo " ";
        }
        echo " \r\n </td>\r\n </tr>\r\n\t\t \r\n\t\t </table>\r\n\t\t  </td>\r\n \t\t \r\n\t\t </tr>\r\n\t\t \r\n\t\t </table>\t\t  \r\n\t\t  \r\n\t\t  </td>\r\n\t\t </tr>\r\n\t\t \r\n\t\t </table>\r\n\t\t \r\n\t\t ";
        if ( $baris % 5 == 0 )
        {
            echo "  \r\n\t\t  \t\t\t\t<br style='page-break-after:always'>";
        }
    } #while ( 1 );
}
?>