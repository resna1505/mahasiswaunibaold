<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "formupdate" )
{
    $q = "SELECT *,YEAR(NOW())-YEAR(msdos.TGLHRMSDOS) AS UMUR FROM msdos WHERE NODOSMSDOS='{$idupdate}'";
    $h = doquery($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $q = "INSERT INTO msdos (NODOSMSDOS) VALUES ('{$idupdate}') ";
        doquery($koneksi,$q);
        $q = "SELECT *,YEAR(NOW())-YEAR(msdos.TGLHRMSDOS) AS UMUR FROM msdos WHERE NODOSMSDOS='{$idupdate}'";
        $h = doquery($koneksi,$q);
    }
    $d2 = sqlfetcharray( $h );
    $tmp = $d2[MLSEMMSDOS];
    $tahun2 = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
    $semester2 = $d2[MLSEMMSDOS];
    $tmp = explode( "-", $d2[TGLHRMSDOS] );
    $dt[thn] = $tmp[0];
    $dt[bln] = $tmp[1];
    $dt[tgl] = $tmp[2];
}
if ( $d2[MLSEMMSDOS] == "" )
{
    $d2[MLSEMMSDOS] = $semester2;
}
if ( $d2[SMAWLMSDOS] == "" )
{
    $d2[SMAWLMSDOS] = $semesterawal;
}
if ( $d2[NOKTPMSDOS] == "" )
{
    $d2[NOKTPMSDOS] = $ktp;
}
if ( $d2[GELARMSDOS] == "" )
{
    $d2[GELARMSDOS] = $gelar;
}
if ( $d2[TPLHRMSDOS] == "" )
{
    $d2[TPLHRMSDOS] = $data[tempat];
}
if ( $d2[KDJEKMSDOS] == "" )
{
    $d2[KDJEKMSDOS] = $data[kelamin];
}
if ( $d2[KDJANMSDOS] == "" )
{
    $d2[KDJANMSDOS] = $jabatan;
}
if ( $d2[KDPDAMSDOS] == "" )
{
    $d2[KDPDAMSDOS] = $pendidikan;
}
if ( $d2[KDSTAMSDOS] == "" )
{
    $d2[KDSTAMSDOS] = $data[status];
}
if ( $d[NIPPNS] == "" )
{
    $d[NIPPNS] = $data[nippns];
}
if ( $d[INSTANSI] == "" )
{
    $d[INSTANSI] = $instansidosen;
}
echo "<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
	<label class=\"col-lg-2 col-form-label\">Mulai Semester</label>
	<label class=\"col-form-label\">
		<input type=text size=5 name=semester2 class=form-control m-input value='{$d2['MLSEMMSDOS']}'> (TAHUN/SEMESTER)
	</label>
</div>
<div class=\"form-group m-form__group row\">
	<label class=\"col-lg-2 col-form-label\">Semester Awal Mengajar</label>
	<label class=\"col-form-label\">
		<input type=text size=5 name=semesterawal class=form-control m-input value='{$d2['SMAWLMSDOS']}'> (TAHUN/SEMESTER)
	</label>
</div>";
$styletr = "";
if ( $d2[NOKTPMSDOS] != $dtbdos[NOKTPTBDOS] )
{
    $styletr = "style='background-color:#FFFF00;'";
}else{
	$styletr = "style='background-color:#f7f8fa;'";
}
#echo "\r\n<tr {$styletr}>\r\n  <td>KTP Dosen</td>\r\n  <td><input type=text size=25 name=ktp value='{$d2['NOKTPMSDOS']}'> TBDOS : <b>{$dtbdos['NOKTPTBDOS']}</b> </td>\r\n</tr>";
echo "<div class=\"form-group m-form__group row\"  {$styletr}>
	<label class=\"col-lg-2 col-form-label\">KTP Dosen</label>
	<label class=\"col-form-label\">
		<input type=text size=25 name=ktp class=form-control m-input value='{$d2['NOKTPMSDOS']}'> TBDOS : <b>{$dtbdos['NOKTPTBDOS']}</b>
	</label>
</div>";

$styletr = "";
if ( $d2[GELARMSDOS] != $dtbdos[GELARTBDOS] )
{
    $styletr = "style='background-color:#FFFF00;'";
}

#echo "\r\n<tr {$styletr}>\r\n  <td>Singkatan Gelar Tertinggi</td>\r\n  <td><input type=text size=10 name=gelar value='{$d2['GELARMSDOS']}'> </td>\r\n</tr>";
echo "<div class=\"form-group m-form__group row\"  {$styletr}>
	<label class=\"col-lg-2 col-form-label\">Singkatan Gelar Tertinggi</label>
	<label class=\"col-form-label\">
		<input type=text size=10 name=gelar class=form-control m-input value='{$d2['GELARMSDOS']}'>
	</label>
</div>";

$styletr = "";
if ( $d2[TPLHRMSDOS] != $dtbdos[TPLHRTBDOS] )
{
    $styletr = "style='background-color:#FFFF00;'";
}else{
	$styletr = "style='background-color:#f7f8fa;'";
}
if ( "{$dt['thn']}-{$dt['bln']}-{$dt['tgl']}" != $dtbdos[TGLHRTBDOS] )
{
    $styletr = "style='background-color:#FFFF00;'";
}else{
	$styletr = "style='background-color:#f7f8fa;'";
}
if ( $d2[UMUR] <= 15 )
{
    $kelas = "style='background-color:#ffff00' ";
}else{
	$styletr = "style='background-color:#f7f8fa;'";
}
#echo "\r\n    <tr {$styletr} {$kelas}>\r\n\t\t\t<td>Tempat/Tanggal Lahir</td>\r\n\t\t\t<td>".createinputtext( "data[tempat]", $d2[TPLHRMSDOS], " class=masukan  size=10" )." / ".createinputtanggalblank( "data", $dt, " class=masukan" )."\r\nTBDOS : <b>{$dtbdos['TPLHRTBDOS']}, {$dtbdos['TGLHRTBDOS']}</b>      \r\n      </td>\r\n\t\t</tr>";
echo "<div class=\"form-group m-form__group row\"  {$styletr} {$kelas}>
	<label class=\"col-lg-2 col-form-label\">Tempat/Tanggal Lahir</label>
	<label class=\"col-form-label\">
		".createinputtext( "data[tempat]", $d2[TPLHRMSDOS], " class=form-control m-input style=\"width:auto;display:inline-block;\" size=10" )." / ".createinputtanggalblank( "data", $dt, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."\r\nTBDOS : <b>{$dtbdos['TPLHRTBDOS']}, {$dtbdos['TGLHRTBDOS']}</b> 
	</label>
</div>";

$styletr = "";
if ( $d2[KDJEKMSDOS] != $dtbdos[KDJEKTBDOS] )
{
    $styletr = "style='background-color:#FFFF00;'";
}
$arraykelamin[''] = "-";
#echo "\r\n<tr {$styletr} class=judulform>\r\n\t\t\t<td>Jenis Kelamin</td>\r\n\t\t\t<td>".createinputselect( "data[kelamin]", $arraykelamin, $d2[KDJEKMSDOS], "", " class=masukan " )."\r\n      TBDOS : <b>{$dtbdos['KDJEKTBDOS']} </b>\r\n      </td>\r\n\t\t</tr>\t\t";
echo "<div class=\"form-group m-form__group row\"  {$styletr} {$kelas}>
	<label class=\"col-lg-2 col-form-label\">Jenis Kelamin</label>
	<label class=\"col-form-label\">
		".createinputselect( "data[kelamin]", $arraykelamin, $d2[KDJEKMSDOS], "", " class=form-control m-input " )." TBDOS : <b>{$dtbdos['KDJEKTBDOS']} </b>
	</label>
</div>";

$styletr = "";
if ( $d2[KDJANMSDOS] != $dtbdos[KDJANTBDOS] )
{
    $styletr = "style='background-color:#FFFF00;'";
}else{
	$styletr = "style='background-color:#f7f8fa;'";
}
$arrayjabatanakademik[''] = "-";
#echo "\r\n<tr {$styletr} class=judulform>\r\n\t\t\t<td>Jabatan Akademik</td>\r\n\t\t\t<td>".createinputselect( "jabatan", $arrayjabatanakademik, "{$d2['KDJANMSDOS']}", "", " class=masukan " )."\r\n       TBDOS : <b>{$dtbdos['KDJANTBDOS']}-".$arrayjabatanakademik[$dtbdos[KDJANTBDOS]]." </b>\r\n      </td>\r\n\t\t</tr>\t\t";
echo "<div class=\"form-group m-form__group row\"  {$styletr}>
	<label class=\"col-lg-2 col-form-label\">Jabatan Akademik</label>
	<label class=\"col-form-label\">
		".createinputselect( "jabatan", $arrayjabatanakademik, "{$d2['KDJANMSDOS']}", "", " class=form-control m-input " )."\r\n       TBDOS : <b>{$dtbdos['KDJANTBDOS']}-".$arrayjabatanakademik[$dtbdos[KDJANTBDOS]]." </b>
	</label>
</div>";

$styletr = "";
if ( $d2[KDPDAMSDOS] != $dtbdos[KDPDATBDOS] )
{
    $styletr = "style='background-color:#FFFF00;'";
}
$arraypendidikantertinggi[''] = "-";
#echo "\r\n<tr {$styletr} class=judulform>\r\n\t\t\t<td>Pendidikan Tertinggi</td>\r\n\t\t\t<td>".createinputselect( "pendidikan", $arraypendidikantertinggi, "{$d2['KDPDAMSDOS']}", "", " class=masukan " )."\r\n       TBDOS : <b>{$dtbdos['KDPDATBDOS']}-".$arraypendidikantertinggi[$dtbdos[KDPDATBDOS]]." </b>\r\n      </td>\r\n\t\t</tr>\t\t";
echo "<div class=\"form-group m-form__group row\"  {$styletr}>
	<label class=\"col-lg-2 col-form-label\">Pendidikan Tertinggi</label>
	<label class=\"col-form-label\">
		".createinputselect( "pendidikan", $arraypendidikantertinggi, "{$d2['KDPDAMSDOS']}", "", " class=form-control m-input " )."TBDOS : <b>{$dtbdos['KDPDATBDOS']}-".$arraypendidikantertinggi[$dtbdos[KDPDATBDOS]]." </b>
	</label>
</div>";

$styletr = "";
if ( $d2[KDSTAMSDOS] != $dtbdos[KDSTATBDOS] )
{
    $styletr = "style='background-color:#FFFF00;'";
}else{
	$styletr = "style='background-color:#f7f8fa;'";
}
$arraystatusid[''] = "-";
#echo "\r\n <tr {$styletr}>\r\n  <td >Status Ikatan Kerja</td>\r\n  <td >\r\n  ".createinputselect( "data[status]", $arraystatusid, "{$d2['KDSTAMSDOS']}", "", " class=masukan" )."\r\n       TBDOS : <b>{$dtbdos['KDSTATBDOS']}-".$arraystatusid[$dtbdos[KDSTATBDOS]]." </b>\r\n  </td>\r\n</tr>";
echo "<div class=\"form-group m-form__group row\"  {$styletr}>
	<label class=\"col-lg-2 col-form-label\">Status Ikatan Kerja</label>
	<label class=\"col-form-label\">
		".createinputselect( "data[status]", $arraystatusid, "{$d2['KDSTAMSDOS']}", "", " class=form-control m-input" )."TBDOS : <b>{$dtbdos['KDSTATBDOS']}-".$arraystatusid[$dtbdos[KDSTATBDOS]]." </b>
	</label>
</div>";

$styletr = "";
if ( $d[NIPPNS] != $dtbdos[NIPPPTBDOS] )
{
    $styletr = "style='background-color:#FFFF00;'";
}
#echo "\r\n <tr {$styletr}>\r\n  <td >NIP PNS</td>\r\n  <td >\r\n \r\n\t\t\t".createinputtext( "data[nippns]", $d[NIPPNS], " class=masukan  size=15" )."\r\n       TBDOS : <b>{$dtbdos['NIPPPTBDOS']} </b>\r\n  </td>\r\n</tr>";
echo "<div class=\"form-group m-form__group row\"  {$styletr}>
	<label class=\"col-lg-2 col-form-label\">NIP PNS</label>
	<label class=\"col-form-label\">
		".createinputtext( "data[nippns]", $d[NIPPNS], " class=form-control m-input  size=15" )."\r\n       TBDOS : <b>{$dtbdos['NIPPPTBDOS']} </b>
	</label>
</div>";

$styletr = "";
if ( $d[INSTANSI] != $dtbdos[PTINDTBDOS] )
{
    $styletr = "style='background-color:#FFFF00;'";
}else{
	$styletr = "style='background-color:#f7f8fa;'";
}
echo "<div class=\"form-group m-form__group row\"  {$styletr}>
	<label class=\"col-lg-2 col-form-label\">Instansi</label>
	<div class=\"col-lg-6\">
		".createinputtext( "instansidosen", $d[INSTANSI], " class=form-control m-input  size=6 id='inputStringListPT' onkeyup=\"lookupListPT(this.value);\" placeholder=\"Ketik Instansi Perguruan Tinggi...\" " )."
		<!--<a href=\"javascript:daftardos('form,wewenang,id',document.form.id.value)\" >daftar NIDN Dosen DIKTI</a>-->
		<div class=\"suggestionsBox\" id=\"suggestionsListPT\" style=\"display: none;\">
			<div class=\"suggestionsListPT\" id=\"autoSuggestionsListPT\"></div>
		</div>	
		
	</div>
</div>";
echo " <div class=\"form-group m-form__group row\">
	<label class=\"col-lg-2 col-form-label\">Jabatan Akademik</label>
	<label class=\"col-form-label\">
		".createinputtext( "data[jabatan]", $jabatanakademik, " class=form-control m-input  size=15" )."
	</label>
</div>"; 
#echo "<tr>\r\n  <td  colspan=2><hr></td>\r\n</tr>\r\n\r\n";
?>
