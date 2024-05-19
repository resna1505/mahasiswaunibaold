<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "formupdate" )
{
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
}
echo "\r\n<tr>\r\n  <td  colspan=2><hr></td>\r\n</tr>\r\n<tr>\r\n  <td >Kelas</td>\r\n  <td >\r\n  ".createinputselect( "kodekelas", $arraykelasmhs, $d2[SHIFTMSMHS], "", " class=masukan" )."\r\n  </td>\r\n</tr> \r\n<tr>\r\n  <td>Semester Awal Terdaftar Sebagai Mahasiswa</td>\r\n  <td>\r\n";
$waktu = getdate( );
echo "\r\n\t\t\t\t\t\t<select name=tahun class=masukan> \r\n\t\t\t\t\t\t ";
$selected = "";
$i = 1901;
while ( $i <= $waktu[year] + 5 )
{
    if ( $i == $tahun )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
    ++$i;
}
echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=semester class=masukan> \r\n\t\t\t\t\t\t ";
unset( $arraysemester[3] );
foreach ( $arraysemester as $k => $v )
{
    if ( $k == $semester )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
}
echo "\r\n\t\t\t\t\t\t</select>\r\n  \r\n   </td>\r\n</tr>\r\n<tr>\r\n  <td>Batas Studi</td>\r\n  <td>\r\n";
$waktu = getdate( );
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
echo "\r\n\t\t\t\t\t\t</select>\r\n   \r\n  \r\n   </td>\r\n</tr>\r\n<tr>\r\n  <td>Kode Propinsi Asal Pendidikan Terakhir</td>\r\n  <td><input type=text size=2 name=kodeprop value='{$d2['ASSMAMSMHS']}'>\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftarprop('form,wewenang,kodeprop',\r\n\t\t\tdocument.form.kodeprop.value)\" >\r\n\t\t\tdaftar Propinsi/Negara\r\n\t\t\t</a>     \r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td >Status Awal Mahasiswa Baru</td>\r\n  <td >\r\n  ".createinputselect( "statusbaru", $arraystatusmhsbaru, $d2[STPIDMSMHS], "", " class=masukan" )."\r\n  </td>\r\n</tr> \r\n<tr>\r\n  <td>Jumlah SKS Diakui u/ Mhs Baru/Pindahan</td>\r\n  <td><input type=text size=3 name=sksbaru value='{$d2['SKSDIMSMHS']}'></td>\r\n</tr>\r\n<tr>\r\n  <td>NIM Asal dari PT Sebelumnya (Pindahan)</td>\r\n  <td><input type=text size=15 name=nimasal value='{$d2['ASNIMMSMHS']}'></td>\r\n</tr>\r\n<tr>\r\n  <td>Kode PT Sebelumnya (Pindahan)</td>\r\n  <td><input type=text size=6 name=ptasal value='{$d2['ASPTIMSMHS']}'>\r\n \t\t\t<a \r\n\t\t\thref=\"javascript:daftarpt('form,wewenang,ptasal',\r\n\t\t\tdocument.form.ptasal.value)\" >\r\n\t\t\tdaftar PT\r\n\t\t\t</a>\r\n  \r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>Jenjang PT Sebelumnya (Pindahan)</td>\r\n  <td>".createinputselect( "jasal", $arrayjenjang, $d2[ASJENMSMHS], "", " class=masukan" )."</td>\r\n</tr>\r\n<tr>\r\n  <td>Kode Program Studi Sebelumnya (Pindahan)</td>\r\n  <td><input type=text size=5 name=psasal value='{$d2['ASPSTMSMHS']}'>\r\n \t\t\t<a \r\n\t\t\thref=\"javascript:daftarprodi('form,wewenang,psasal',\r\n\t\t\tdocument.form.psasal.value)\" >\r\n\t\t\tdaftar Prodi\r\n\t\t\t</a>  \r\n  </td>\r\n</tr>\r\n\r\n<tr>\r\n  <td  colspan=2><hr></td>\r\n</tr>\r\n<tr>\r\n  <td  colspan=2><b> Khusus S3</td>\r\n</tr>\r\n\r\n<tr>\r\n  <td>Kode Biaya Studi</td>\r\n  <td><input type=text size=1 name=kodebiaya value='{$d2['BISTUMSMHS']}'></td>\r\n</tr>\r\n<tr>\r\n  <td>Kode Pekerjaan</td>\r\n  <td><input type=text size=1 name=kodekerja value='{$d2['BISTUMSMHS']}'></td>\r\n</tr>\r\n\r\n<tr>\r\n  <td>Nama Tempat Bekerja, bila bukan Dosen</td>\r\n  <td><input type=text size=40 name=tempatkerja value='{$d2['PEKSBMSMHS']}'></td>\r\n</tr>\r\n\r\n<tr>\r\n  <td>Kode PT Tempat Bekerja, bila Dosen</td>\r\n  <td><input type=text size=6 name=ptkerja value='{$d2['PTPEKMSMHS']}'></td>\r\n</tr>\r\n<tr>\r\n  <td>Kode PS Tempat Bekerja, bila Dosen</td>\r\n  <td><input type=text size=5 name=pskerja value='{$d2['PSPEKMSMHS']}'></td>\r\n</tr>\r\n\r\n\r\n<tr>\r\n  <td>NIDN Promotor</td>\r\n  <td><input type=text size=5 name=nidnpro value='{$d2['NOPRMMSMHS']}'>\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftardos('form,wewenang,nidnpro',\r\n\t\t\tdocument.form.nidnpro.value)\" >\r\n\t\t\tdaftar NIDN Dosen DIKTI\r\n\t\t\t</a>\r\n  \r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>NIDN Ko-Promotor #1</td>\r\n  <td><input type=text size=5 name=nidnpro1 value='{$d2['NOKP1MSMHS']}'>\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftardos('form,wewenang,nidnpro1',\r\n\t\t\tdocument.form.nidnpro1.value)\" >\r\n\t\t\tdaftar NIDN Dosen DIKTI\r\n\t\t\t</a>\r\n  \r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>NIDN Ko-Promotor #2</td>\r\n  <td><input type=text size=5 name=nidnpro2 value='{$d2['NOKP2MSMHS']}'>\r\n   \t\t\t<a \r\n\t\t\thref=\"javascript:daftardos('form,wewenang,nidnpro2',\r\n\t\t\tdocument.form.nidnpro2.value)\" >\r\n\t\t\tdaftar NIDN Dosen DIKTI\r\n\t\t\t</a>\r\n \r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>NIDN Ko-Promotor #3</td>\r\n  <td><input type=text size=5 name=nidnpro3 value='{$d2['NOKP3MSMHS']}'>\r\n   \t\t\t<a \r\n\t\t\thref=\"javascript:daftardos('form,wewenang,nidnpro3',\r\n\t\t\tdocument.form.nidnpro3.value)\" >\r\n\t\t\tdaftar NIDN Dosen DIKTI\r\n\t\t\t</a>\r\n \r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>NIDN Ko-Promotor #4</td>\r\n  <td><input type=text size=5 name=nidnpro4 value='{$d2['NOKP4MSMHS']}'>\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftardos('form,wewenang,nidnpro4',\r\n\t\t\tdocument.form.nidnpro4.value)\" >\r\n\t\t\tdaftar NIDN Dosen DIKTI\r\n\t\t\t</a>\r\n  \r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td  colspan=2><hr></td>\r\n</tr>\r\n\r\n";
?>
