<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "SELECT * FROM msdos WHERE NODOSMSDOS='{$idupdate}'";
$h = doquery($koneksi,$q);
if ( sqlnumrows( $h ) <= 0 )
{
    $q = "INSERT INTO msdos (NODOSMSDOS) VALUES ('{$idupdate}') ";
    doquery($koneksi,$q);
    $q = "SELECT * FROM msdos WHERE NODOSMSDOS='{$idupdate}'";
    $h = doquery($koneksi,$q);
}
$d2 = sqlfetcharray( $h );
$tmp = explode( "-", $d2[TGLHRMSDOS] );
$dt[thn] = $tmp[0];
$dt[bln] = $tmp[1];
$dt[tgl] = $tmp[2];
echo "\r\n<tr>\r\n  <td  colspan=2><hr></td>\r\n</tr>\r\n<tr>\r\n  <td>KTP Dosen</td>\r\n  <td>{$d2['NOKTPMSDOS']}</td>\r\n</tr>\r\n<tr>\r\n  <td>Singkatan Gelar Tertinggi</td>\r\n  <td>{$d2['GELARMSDOS']}</td>\r\n</tr>\r\n<tr >\r\n\t\t\t<td>Tempat/Tanggal Lahir</td>\r\n\t\t\t<td>{$d2['TPLHRMSDOS']} / {$dt['tgl']}-{$dt['bln']}-{$dt['thn']} </td>\r\n\t\t</tr>\r\n<tr class=judulform>\r\n\t\t\t<td>Jenis Kelamin</td>\r\n\t\t\t<td>".$arraykelamin[$d2[KDJEKMSDOS]]."</td>\r\n\t\t</tr>\t\t\r\n<tr class=judulform>\r\n\t\t\t<td>Jabatan Akademik</td>\r\n\t\t\t<td>".$arrayjabatanakademik[$d2[KDJANMSDOS]]."</td>\r\n\t\t</tr>\t\t\r\n<tr class=judulform>\r\n\t\t\t<td>Pendidikan Tertinggi</td>\r\n\t\t\t<td>".$arraypendidikantertinggi[$d2[KDPDAMSDOS]]."</td>\r\n\t\t</tr>\t\t\r\n <tr>\r\n  <td >Status Ikatan Kerja</td>\r\n  <td >".$arraystatusid[$d2[KDSTAMSDOS]]."\r\n  </td>\r\n</tr>\r\n <tr>\r\n  <td >NIDN PNS</td>\r\n  <td > {$d['NIPPNS']}  </td>\r\n</tr>\r\n <tr>\r\n  <td >Instansi</td>\r\n  <td >{$d['INSTANSI']}</td>\r\n\t\t</tr> \r\n \r\n<tr>\r\n  <td>Mulai Semester</td>\r\n  <td>{$d2['MLSEMMSDOS']}</td>\r\n</tr>\r\n<tr>\r\n  <td>Semester Awal Mengajar</td>\r\n  <td>{$d2['SMAWLMSDOS']}</td>\r\n</tr>\r\n \r\n<tr>\r\n  <td  colspan=2><hr></td>\r\n</tr>\r\n\r\n";
?>
