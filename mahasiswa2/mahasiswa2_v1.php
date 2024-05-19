<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SELECT * FROM msmhs WHERE NIMHSMSMHS='{$idupdate}'";
$h = mysqli_query($koneksi,$q);
if ( sqlnumrows( $h ) <= 0 )
{
    $q = "INSERT INTO msmhs (NIMHSMSMHS) VALUES ('{$idupdate}') ";
    mysqli_query($koneksi,$q);
    $q = "SELECT * FROM msmhs WHERE NIMHSMSMHS='{$idupdate}'";
    $h = mysqli_query($koneksi,$q);
}
$d2 = sqlfetcharray( $h );
$tmp = $d2[SMAWLMSMHS];
$tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
$semester = $tmp[4];
$tmp = $d2[BTSTUMSMHS];
$tahun2 = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
$semester2 = $tmp[4];
echo "\r\n<tr>\r\n  <td  colspan=2><hr></td>\r\n</tr>\r\n<tr>\r\n  <td >Kelas </td>\r\n  <td >\r\n  ".$arraykelasmhs[$d2[SHIFTMSMHS]]."\r\n  </td>\r\n</tr> \r\n<tr>\r\n  <td>Semester Awal Terdaftar Sebagai Mahasiswa</td>\r\n  <td>{$tahun}/".( $tahun + 1 )." ".$arraysemester[$semester]." \r\n  \r\n   </td>\r\n</tr>\r\n<tr>\r\n  <td>Batas Studi</td>\r\n  <td>{$tahun2}/".( $tahun2 + 1 )." ".$arraysemester[$semester2]."  \r\n   \r\n  \r\n   </td>\r\n</tr>\r\n<tr>\r\n  <td>Kode Propinsi Asal Pendidikan Terakhir</td>\r\n  <td>{$d2['ASSMAMSMHS']}\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td >Status Awal Mahasiswa Baru</td>\r\n  <td >\r\n  ".$arraystatusmhsbaru[$d2[STPIDMSMHS]]."\r\n  </td>\r\n</tr> \r\n<tr>\r\n  <td>Jumlah SKS Diakui u/ Mhs Baru/Pindahan</td>\r\n  <td>{$d2['SKSDIMSMHS']}</td>\r\n</tr>\r\n<tr>\r\n  <td>NIM Asal dari PT Sebelumnya (Pindahan)</td>\r\n  <td>{$d2['ASNIMMSMHS']}</td>\r\n</tr>\r\n<tr>\r\n  <td>Kode PT Sebelumnya (Pindahan)</td>\r\n  <td>{$d2['ASPTIMSMHS']}\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>Jenjang PT Sebelumnya (Pindahan)</td>\r\n  <td>".$arrayjenjang[$d2[ASJENMSMHS]]."</td>\r\n</tr>\r\n<tr>\r\n  <td>Kode Program Studi Sebelumnya (Pindahan)</td>\r\n  <td>{$d2['ASPSTMSMHS']}\r\n  </td>\r\n</tr>\r\n\r\n<tr>\r\n  <td  colspan=2><hr></td>\r\n</tr>\r\n<tr>\r\n  <td  colspan=2><b> Khusus S3</td>\r\n</tr>\r\n\r\n<tr>\r\n  <td>Kode Biaya Studi</td>\r\n  <td>{$d2['BISTUMSMHS']}</td>\r\n</tr>\r\n<tr>\r\n  <td>Kode Pekerjaan</td>\r\n  <td>{$d2['BISTUMSMHS']}</td>\r\n</tr>\r\n\r\n<tr>\r\n  <td>Nama Tempat Bekerja, bila bukan Dosen</td>\r\n  <td>{$d2['PEKSBMSMHS']}</td>\r\n</tr>\r\n\r\n<tr>\r\n  <td>Kode PT Tempat Bekerja, bila Dosen</td>\r\n  <td>{$d2['PTPEKMSMHS']}</td>\r\n</tr>\r\n<tr>\r\n  <td>Kode PS Tempat Bekerja, bila Dosen</td>\r\n  <td>{$d2['PSPEKMSMHS']}</td>\r\n</tr>\r\n\r\n\r\n<tr>\r\n  <td>NIDN Promotor</td>\r\n  <td>{$d2['NOPRMMSMHS']}\r\n  \r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>NIDN Ko-Promotor #1</td>\r\n  <td>{$d2['NOKP1MSMHS']}\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>NIDN Ko-Promotor #2</td>\r\n  <td>{$d2['NOKP2MSMHS']}\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>NIDN Ko-Promotor #3</td>\r\n  <td>{$d2['NOKP3MSMHS']}\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>NIDN Ko-Promotor #4</td>\r\n  <td>{$d2['NOKP4MSMHS']}\r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td  colspan=2><hr></td>\r\n</tr>\r\n\r\n";
?>
