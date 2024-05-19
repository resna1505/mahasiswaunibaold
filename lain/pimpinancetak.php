<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SELECT  KDPTIMSPTI FROM mspti  LIMIT 0,1";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $kodept = $d[KDPTIMSPTI];
}
$q = "SELECT * FROM trpim  \r\nWHERE\r\n KDPTITRPIM='{$kodept}'  AND\r\n      THSMSTRPIM='{$tahun}{$semester}'\r\n";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $ada = 1;
    $d = sqlfetcharray( $h );
    $tmp = explode( "-", $d[TGYS1TRPIM] );
    $thn1 = $tmp[0];
    $bln1 = $tmp[1];
    $tgl1 = $tmp[2];
    $tmp = explode( "-", $d[TGYS2TRPIM] );
    $thn2 = $tmp[0];
    $bln2 = $tmp[1];
    $tgl2 = $tmp[2];
    $tmp = explode( "-", $d[TGPT1TRPIM] );
    $thn3 = $tmp[0];
    $bln3 = $tmp[1];
    $tgl3 = $tmp[2];
    $tmp = explode( "-", $d[TGPT2TRPIM] );
    $thn4 = $tmp[0];
    $bln4 = $tmp[1];
    $tgl4 = $tmp[2];
}
printmesg( $errmesg );
echo "\r\n \r\n<table class=form>\r\n  <tr>\r\n    <td >Tahun Semester Pelaporan Data   </td>\r\n    <td>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n  </tr>\r\n \r\n  <tr>\r\n    <td >Ketua Yayasan</td>\r\n    <td>{$d['NMKTYTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Sekretaris Yayasan</td>\r\n    <td>{$d['NMSEYTRPIM']}</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Bendahara Yayasan</td>\r\n    <td> {$d['NMBHYTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >NIDN Rektor/Direktur/Ketua</td>\r\n    <td> {$d['NORETTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >NIDN Pembantu/Wakil I</td>\r\n    <td>  {$d['NOR1TTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >NIDN Pembantu/Wakil II</td>\r\n    <td> {$d['NOR2TTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >NIDN Pembantu/Wakil III</td>\r\n    <td> {$d['NOR3TTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >NIDN Pembantu/Wakil IV</td>\r\n    <td> {$d['NOR4TTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >NIDN Pembantu/Wakil V</td>\r\n    <td> {$d['NOR5TTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Nomor S.K. Pengurus Harian Yayasan</td>\r\n    <td> {$d['NOMYSTRPIM']} </td>\r\n  </tr>\r\n   <tr>\r\n    <td nowrap>Tanggal S.K.</td>\r\n    <td>{$tgl1}-{$bln1}-{$thn1}\r\n    </td>\r\n  </tr>\r\n   <tr>\r\n    <td nowrap>Tanggal Akhir Berlaku S.K.</td>\r\n    <td>{$tgl2}-{$bln2}-{$thn2}\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Nomor S.K. Rektor/Ketua/Direktur</td>\r\n    <td> {$d['NOMPTTRPIM']} </td>\r\n  </tr>\r\n\r\n   <tr>\r\n    <td nowrap>Tanggal S.K.</td>\r\n    <td>{$tgl3}-{$bln3}-{$thn3}\r\n    </td>\r\n  </tr>\r\n   <tr>\r\n    <td nowrap>Akhir Berlaku S.K.</td>\r\n    <td>{$tgl4}-{$bln4}-{$thn4}\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Administrasi Pria Pendidikan <= D-3</td>\r\n    <td>{$d['ADMLATRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Administrasi Wanita Pendidikan <= D-3</td>\r\n    <td>{$d['ADMPATRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Administrasi Pria Pendidikan = S-1</td>\r\n    <td>{$d['ADMLBTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Administrasi Wanita Pendidikan = S-1</td>\r\n    <td>{$d['ADMPBTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Administrasi Pria Pendidikan > S-1</td>\r\n    <td>{$d['ADMLCTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Administrasi Wanita Pendidikan > S-1</td>\r\n    <td>{$d['ADMPCTRPIM']} </td>\r\n  </tr>\r\n \r\n  <tr>\r\n    <td >Tenaga Pustakawan Pria Pendidikan <= D-3</td>\r\n    <td>{$d['PUSLATRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Pustakawan Wanita Pendidikan <= D-3</td>\r\n    <td>{$d['PUSPATRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Pustakawan Pria Pendidikan = S-1</td>\r\n    <td>{$d['PUSLBTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Pustakawan Wanita Pendidikan = S-1</td>\r\n    <td>{$d['PUSPBTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Pustakawan Pria Pendidikan > S-1</td>\r\n    <td> {$d['PUSLCTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Pustakawan Wanita Pendidikan > S-1</td>\r\n    <td>{$d['PUSPCTRPIM']} </td>\r\n  </tr>\r\n\r\n  <tr>\r\n    <td >Tenaga Laboran Pria Pendidikan <= D-3</td>\r\n    <td> {$d['LABLATRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Laboran Wanita Pendidikan <= D-3</td>\r\n    <td> {$d['LABPATRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Laboran Pria Pendidikan = S-1</td>\r\n    <td>{$d['LABLBTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Laboran Wanita Pendidikan = S-1</td>\r\n    <td>{$d['LABPBTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Laboran Pria Pendidikan > S-1</td>\r\n    <td> {$d['LABLCTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Laboran Wanita Pendidikan > S-1</td>\r\n    <td>{$d['LABPCTRPIM']} </td>\r\n  </tr>\r\n \r\n\r\n  <tr>\r\n    <td >Tenaga Teknisi Pria Pendidikan <= D-3</td>\r\n    <td>{$d['TEKLATRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Teknisi Wanita Pendidikan <= D-3</td>\r\n    <td>{$d['TEKPATRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Teknisi Pria Pendidikan = S-1</td>\r\n    <td>{$d['TEKLBTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Teknisi Wanita Pendidikan = S-1</td>\r\n    <td>{$d['TEKPBTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Teknisi Pria Pendidikan > S-1</td>\r\n    <td> {$d['TEKLCTRPIM']} </td>\r\n  </tr>\r\n  <tr>\r\n    <td width=300>Tenaga Teknisi Wanita Pendidikan > S-1</td>\r\n    <td> {$d['TEKPCTRPIM']} </td>\r\n  </tr>\r\n\r\n\r\n \r\n \r\n</table>";
?>
