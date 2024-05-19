<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
$q = "SELECT * FROM trlsd WHERE NODOSTRLSD='{$idupdate}' AND \r\n    ASPTITRLSD='{$kode_pt_lama}' AND\r\n    JENJATRLSD='{$jenjang_lama}' ";
$h2 = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $d2 = sqlfetcharray( $h2 );
    $tmp = $d2[SMAWLTRLSD];
    $tahun2 = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
    $semester2 = $tmp[4];
}
#echo "\r\n \r\n     <tr class=judulform>\r\n\t\t\t<td width=200>Semester Awal</td>\r\n\t\t\t<td>";
echo "<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Tahun/Semester Data</label>\r\n    
								<div class=\"col-lg-6\">";
$waktu = getdate( );
if ( $tahun2 == "" )
{
    $tahun2 = $waktu[year];
}
#echo "\r\n\t\t\t\t\t\t<select name=tahun2 class=form-control m-input> \r\n\t\t\t\t\t\t ";
echo "\r\n\t\t\t\t\t\t<select name=tahun2 class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
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
#echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=semester2 class=form-control m-input> \r\n\t\t\t\t\t\t ";
echo "</select>/<select name=semester2 class=form-control m-input style=\"width:auto;display:inline-block;\">";
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
echo "</select></div>
	</div>
	<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
		<label class=\"col-lg-2 col-form-label\">Kode PT</label>\r\n    
		<div class=\"col-lg-6\"><input type=text size=6 value='{$d2['ASPTITRLSD']}' name=kode_pt class=form-control m-input  size=10 id='inputStringListPT' onkeyup=\"lookupListPT(this.value);\" placeholder=\"Ketik Instansi Perguruan Tinggi...\">
			<!--<a href=\"javascript:daftarpt('form,wewenang,kode_pt',document.form.kode_pt.value)\" >daftar PT</a>-->
			<div class=\"suggestionsBox\" id=\"suggestionsListPT\" style=\"display: none;\">
				<div class=\"suggestionsListPT\" id=\"autoSuggestionsListPT\"></div>
			</div>	
		";
if ( $d2[ASPTITRLSD] != "" )
{
    $namapt = getfield( "NMPTITBPTI", "tbpti", "WHERE KDPTITBPTI='{$d2['ASPTITRLSD']}'" );
    if ( $namapt != "" )
    {
        echo "<br><b>{$namapt}</b>";
    }
}
echo "	</div>
	</div>
	<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">Jenjang</label>\r\n    
		<div class=\"col-lg-6\">".createinputselect( "jenjang", $arrayjenjang, $d2[JENJATRLSD], "", " class=form-control m-input " )."</div>
	</div><div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
		<label class=\"col-lg-2 col-form-label\">Bidang Ilmu</label>\r\n    
		<div class=\"col-lg-6\"><input type=text name=bidangilmu size=20 value='{$d2['BIDILTRLSD']}' class=form-control m-input> </div>
	</div>
	<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">Biaya Studi</label>\r\n    
		<div class=\"col-lg-6\">".createinputselect( "biayastudi", $arraybiayastudilanjut, $d2[BISTUTRLSD], "", " class=form-control m-input " )."</div>
	</div>
	";
?>
