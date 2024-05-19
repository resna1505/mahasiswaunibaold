<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
$q = "SELECT * FROM trlsm WHERE NIMHSTRLSM='{$idupdate}' AND THSMSTRLSM='{$tahunsemester}'";
$h2 = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $d2 = sqlfetcharray( $h2 );
    $tmp = explode( "-", $d2[TGLLSTRLSM] );
    $dtk[thn] = $tmp[0];
    $dtk[tgl] = $tmp[2];
    $dtk[bln] = $tmp[1];
    $tmp = explode( "-", $d2[TGLRETRLSM] );
    $tglsk[thn] = $tmp[0];
    $tglsk[tgl] = $tmp[2];
    $tglsk[bln] = $tmp[1];
    $tmp = $d2[THSMSTRLSM];
    $tahun2 = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
    $semester2 = $tmp[4];
    $tmp = $d2[BLAWLTRLSM];
    $bulanawal = $tmp[0].$tmp[1];
    $tahunawal = $tmp[2].$tmp[3].$tmp[4].$tmp[5];
    $tmp = $d2[BLAKHTRLSM];
    $bulanakhir = $tmp[0].$tmp[1];
    $tahunakhir = $tmp[2].$tmp[3].$tmp[4].$tmp[5];
}
echo "\r\n     <tr class=judulform>\r\n\t\t\t<td>Tahun/Semester Data</td>\r\n\t\t\t<td>";
$waktu = getdate( );
if ( $tahun2 == "" )
{
    $tahun2 = $waktu[year];
}
echo "\r\n\t\t\t\t\t\t<select name=tahun2 class=masukan> \r\n\t\t\t\t\t\t ";
$selected = "";
$i = 1901;
while ( $i <= $waktu[year] + 5 )
{
    if ( $i == $tahun2 )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
    ++$i;
}
echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=semester2 class=masukan> \r\n\t\t\t\t\t\t ";
unset( $arraysemester[3] );
foreach ( $arraysemester as $k => $v )
{
    if ( $k == $semester2 )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
}
echo "\r\n\t\t\t\t\t\t</select>\r\n\r\n\t\t\t\r\n  </td>\r\n\t\t</tr>".( "<tr >\r\n\t\t\t<td>Status Aktifitas Mahasiswa</td>\r\n\t\t\t<td> " ).createinputselect( "status", $arraystatusmahasiswa, $d2[STMHSTRLSM], "", " class=masukan " )."</td>\r\n\t\t</tr>"."\r\n      <tr >\r\n\t\t\t<td>Tanggal Keluar/Lulus</td>\r\n\t\t\t<td>".createinputtanggalblank( "dtk", $dtk, " class=masukan" )."</td>\r\n\t\t</tr>     \r\n    <tr class=judulform>\r\n\t\t\t<td>SKS Lulus</td>\r\n\t\t\t<td>".createinputtext( "data[sks]", $d2[SKSTTTRLSM], " class=masukan  size=3" )."</td>\r\n\t\t</tr>"."<tr class=judulform>\r\n\t\t\t<td>IPK Akhir</td>\r\n\t\t\t<td>".createinputtext( "data[ipk]", $d2[NLIPKTRLSM], " class=masukan  size=3" )."</td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>No. SK Yudisium</td>\r\n\t\t\t<td>".createinputtext( "data[sk]", $d2[NOSKRTRLSM], " class=masukan  size=40" )."</td>\r\n\t\t</tr>\r\n     <tr >\r\n\t\t\t<td>Tanggal SK</td>\r\n\t\t\t<td>".createinputtanggalblank( "tglsk", $tglsk, " class=masukan" )."</td>\r\n\t\t</tr> \t\t\r\n    <tr class=judulform>\r\n\t\t\t<td>No. Seri Ijazah</td>\r\n\t\t\t<td>".createinputtext( "data[ijazah]", $d2[NOIJATRLSM], " class=masukan  size=40" )."</td>\r\n\t\t</tr>\r\n      <tr >\r\n\t\t\t<td>Jalur Skripsi/Non</td>\r\n\t\t\t<td> ".createinputselect( "jalur", $arrayjalurskripsi, $d2[STLLSTRLSM], "", " class=masukan " )."</td>\r\n\t\t</tr>\t\t\r\n      <tr >\r\n\t\t\t<td> Skripsi Individu/Kelompok</td>\r\n\t\t\t<td> ".createinputselect( "individu", $arrayskripsiindividu, $d2[JNLLSTRLSM], "", " class=masukan " )."</td>\r\n\t\t</tr>\t\t\r\n\t\t\r\n    <tr class=judulform>\r\n\t\t\t<td>Bulan/Tahun Awal Bimbingan</td>\r\n\t\t\t<td>\r\n\t\t\t\t\t\t<select name=bulanawal class=masukan> \r\n\t\t\t\t\t\t ";
$selected = "";
foreach ( $arraybulan as $k => $v )
{
    if ( $k + 1 == $bulanawal )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='".( $k + 1 )."' {$cek} {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
}
echo "\r\n\t\t\t\t\t\t</select>\r\n      ";
$waktu = getdate( );
echo "\r\n\t\t\t\t\t\t<select name=tahunawal class=masukan> \r\n\t\t\t\t\t\t ";
$selected = "";
$i = 1901;
while ( $i <= $waktu[year] + 5 )
{
    if ( $i == $tahunawal )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>{$i}</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
    ++$i;
}
echo "\r\n\t\t\t\t\t\t</select> \r\n   </td>\r\n\t\t</tr>\t\t\r\n    <tr class=judulform>\r\n\t\t\t<td>Bulan/Tahun Akhir Bimbingan</td>\r\n\t\t\t<td>\r\n\t\t\t\t\t\t<select name=bulanakhir class=masukan> \r\n\t\t\t\t\t\t ";
$selected = "";
foreach ( $arraybulan as $k => $v )
{
    if ( $k + 1 == $bulanakhir )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='".( $k + 1 )."' {$cek} {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
}
echo "\r\n\t\t\t\t\t\t</select>\r\n      ";
$waktu = getdate( );
echo "\r\n\t\t\t\t\t\t<select name=tahunakhir class=masukan> \r\n\t\t\t\t\t\t ";
$selected = "";
$i = 1901;
while ( $i <= $waktu[year] + 5 )
{
    if ( $i == $tahunakhir )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>{$i}</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
    ++$i;
}
echo "\r\n\t\t\t\t\t\t</select> \r\n   </td>\r\n\t\t</tr>\t\t\t\r\n \r\n    <tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Pembimbing 1</td>\r\n\t\t\t<td>".createinputtext( "dosen1", $d2[NODS1TRLSM], " class=masukan  size=10" )."\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftardos('form,wewenang,dosen1',\r\n\t\t\tdocument.form.dosen1.value)\" >\r\n\t\t\tdaftar NIDN Dosen DIKTI\r\n\t\t\t</a>::\r\n\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,dosen1',\r\n\t\t\tdocument.form.dosen1.value)\" >\r\n\t\t\tdaftar Dosen Lokal\r\n\t\t\t</a>\r\n \r\n      </td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Pembimbing 2</td>\r\n\t\t\t<td>".createinputtext( "dosen2", $d2[NODS2TRLSM], " class=masukan  size=10" )."\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftardos('form,wewenang,dosen2',\r\n\t\t\tdocument.form.dosen2.value)\" >\r\n\t\t\tdaftar NIDN Dosen DIKTI\r\n\t\t\t</a>::\r\n\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,dosen2',\r\n\t\t\tdocument.form.dosen2.value)\" >\r\n\t\t\tdaftar Dosen Lokal\r\n\t\t\t</a>\r\n\r\n      </td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Pembimbing 3</td>\r\n\t\t\t<td>".createinputtext( "dosen3", $d2[NODS3TRLSM], " class=masukan  size=10" )."\r\n   \t\t\t<a \r\n\t\t\thref=\"javascript:daftardos('form,wewenang,dosen3',\r\n\t\t\tdocument.form.dosen3.value)\" >\r\n\t\t\tdaftar NIDN Dosen DIKTI\r\n\t\t\t</a>::\r\n\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,dosen3',\r\n\t\t\tdocument.form.dosen3.value)\" >\r\n\t\t\tdaftar Dosen Lokal\r\n\t\t\t</a>\r\n     \r\n      </td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Pembimbing 4</td>\r\n\t\t\t<td>".createinputtext( "dosen4", $d2[NODS4TRLSM], " class=masukan  size=10" )."\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftardos('form,wewenang,dosen4',\r\n\t\t\tdocument.form.dosen4.value)\" >\r\n\t\tdaftar NIDN Dosen DIKTI\r\n\t\t\t</a>::\r\n\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,dosen4',\r\n\t\t\tdocument.form.dosen4.value)\" >\r\n\t\t\tdaftar Dosen Lokal\r\n\t\t\t</a>\r\n      \r\n      </td>\r\n\t\t</tr>\r\n    <tr class=judulform>\r\n\t\t\t<td>NIDN Dosen Pembimbing 5</td>\r\n\t\t\t<td>".createinputtext( "dosen5", $d2[NODS5TRLSM], " class=masukan  size=10" )."\r\n   \t\t\t<a \r\n\t\t\thref=\"javascript:daftardos('form,wewenang,dosen5',\r\n\t\t\tdocument.form.dosen5.value)\" >\r\n\t\t\tdaftar NIDN Dosen DIKTI\r\n\t\t\t</a>::\r\n\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,dosen5',\r\n\t\t\tdocument.form.dosen5.value)\" >\r\n\t\t\tdaftar Dosen Lokal\r\n\t\t\t</a>\r\n     \r\n      </td>\r\n\t\t</tr>\r\n \r\n    \t\r\n \t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n \r\n \r\n \r\n\t\t";
?>
