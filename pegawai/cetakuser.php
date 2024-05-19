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
$ok = true;
$query = "SELECT NAMA,ALAMAT,TELPON,TINGKAT,PASSWORD,DAYOFMONTH(TGLLAHIR) AS TGL, \r\n\t\t\tMONTH(TGLLAHIR) AS BLN, YEAR(TGLLAHIR) AS THN, BIDANG, LOKASI, STATUSPEGAWAI,JABATAN,JABATANS,STATUSNIKAH,JMLANAK,\r\n\t\t\tDATE_FORMAT(LASTUPDATE,'%d-%m-%Y %H:%i:%s') AS LASTUP, KELAMIN , PASSWORD,SHIFT,STATUSLOGIN\r\n\t\t\tFROM user WHERE ID='{$iduser}' AND ID!='superadmin'";
$hasil =mysqli_query($koneksi,$query);
if ( 1 <= sqlnumrows( $hasil ) )
{
    $datauser = sqlfetcharray( $hasil );
    $nama = $datauser[NAMA];
    $alamatuser = $datauser[ALAMAT];
    $telepon = $datauser[TELPON];
    $tgl = $datauser[TGL];
    $bln = $datauser[BLN];
    $thn = $datauser[THN];
    $tingkat = $datauser[TINGKAT];
    $kelamin = $datauser[KELAMIN];
    $pwduser = $datauser[PASSWORD];
    $bidang = $datauser[BIDANG];
    $lokasi = $datauser[LOKASI];
    $statuspegawai = $datauser[STATUSPEGAWAI];
    $jabatan = $datauser[JABATAN];
    $jabatans = $datauser[JABATANS];
    $shift = $datauser[SHIFT];
    $statuslogin = $datauser[STATUSLOGIN];
    $statusnikah = $datauser[STATUSNIKAH];
    $jmlanak = $datauser[JMLANAK];
}
echo "\r\n<table width=500 >\r\n<tr\tvalign=middle>\r\n<td align=center>\t\r\n\r\n\r\n\r\n<table width=100% ";
echo $tabelisian;
echo ">\r\n\t<tr>\r\n\t\t<td  width=30%>ID</td>\r\n\t\t<td>";
echo $iduser;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Nama</td>\r\n\t\t<td>";
echo $nama;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Bidang</td>\r\n\t\t<td>\r\n\t\t";
echo $bidanguser[$bidang];
echo "\t\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Status Operator</td>\r\n\t\t<td>\r\n\t\t";
echo $arraystatuspegawai[$statuspegawai];
echo "\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Jabatan Fungsional</td>\r\n\t\t<td>\r\n\t\t";
echo $arrayjabatan[$jabatan];
echo "\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Jabatan Struktural</td>\r\n\t\t<td>\r\n\t\t";
echo $arrayjabatans[$jabatans];
echo "\t\t</td>\r\n\t</tr>\r\n\r\n\t<tr>\r\n\t\t<td  >Jenis kelamin</td>\r\n\t\t<td>\r\n\t\t\t";
if ( $kelamin == "L" )
{
    echo "Laki-laki";
}
echo "\t\t\t ";
if ( $kelamin != "L" )
{
    echo "Perempuan";
}
echo "\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Tgl Lahir</td>\r\n\t\t<td>\r\n\t\t\t";
echo "{$tgl}-{$bln}-{$thn}";
echo "\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Alamat</td>\r\n\t\t<td>";
echo $alamatuser;
echo "</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Telepon</td>\r\n\t\t<td>";
echo $telepon;
echo "</td>\r\n\t</tr>\r\n\r\n\t<tr>\r\n\t\t<td  >Status Pernikahan</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraystatusnikah[$statusnikah];
echo "\t\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td>Jumlah Anak</td>\r\n\t\t<td>\r\n\t\t\t";
echo $jmlanak;
echo "\t\t</td>\r\n\t</tr>\r\n\r\n\t\t<td  >Lokasi</td>\r\n\t\t<td>\r\n\t\t\t";
echo $arraylokasi[$lokasi];
echo "\t\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td  >Tingkat</td>\r\n\t\t<td>\r\n\t\t\t";
echo $tingkatuser[$tingkat];
echo "\t\t</td>\r\n\t</tr>\r\n\r\n</table>\r\n\r\n</td>\r\n</tr>\r\n</table>\r\n\r\n";
?>
