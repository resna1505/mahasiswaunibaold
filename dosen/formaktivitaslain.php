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
$q = "SELECT * FROM trakd_lain WHERE NODOSTRAKD='{$idupdate}' \r\n     AND THSMSTRAKD='{$tahunsemester}'\r\n     AND NAMA='{$makulupdate}' ";
$h2 = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $d2 = sqlfetcharray( $h2 );
    $tmp = $d2[THSMSTRAKD];
    $tahun2 = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
    $semester2 = $tmp[4];
}
#echo "\r\n     <tr class=judulform>\r\n\t\t\t<td>Tahun/Semester Data</td>\r\n\t\t\t<td>";
echo "<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Tahun/Semester Data</label>\r\n    
								<div class=\"col-lg-6\">";
$waktu = getdate( );
if ( $tahun2 == "" )
{
    $tahun2 = $waktu[year];
}
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
#echo "\r\n\t\t\t\t\t\t</select>\r\n\r\n\t\t\t\r\n  </td>\r\n\t\t</tr>\r\n<tr class=judulform>\r\n\t\t\t\t<td  >Kode PT</td>\r\n\t\t\t\t<td>".createinputtext( "kodept", $d2[KODEPT], " class=masukan  size=10" )."\r\n\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarpt('form,wewenang,kodept',\r\n\t\t\tdocument.form.kodept.value)\" >\r\n\t\t\tdaftar PT\r\n\t\t\t</a>\r\n \t\t\t\t</td>\r\n\t\t\t</tr>  \t    \r\n    <tr >\r\n\t\t\t<td width=200>Nama Mata Kuliah</td>\r\n\t\t\t<td> ".createinputtext( "namamakulbaru", $d2[NAMA], " class=masukan size=50" )."\r\n  \t\t \r\n      </td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Jumlah SKS</td>\r\n\t\t\t<td>".createinputtext( "sks", $d2[SKS], " class=masukan  size=2" )."</td>\r\n\t\t</tr> \r\n    \r\n    \t\r\n \t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n \r\n \r\n \r\n\t\t";
echo "</select>
	</div>
	</div>
	<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
		<label class=\"col-lg-2 col-form-label\">Kode PT</label>\r\n    
		<div class=\"col-lg-6\"> ".createinputtext( "kodept", $d2[KODEPT], " class=form-control m-input  size=10 id='inputStringListPT' onkeyup=\"lookupListPT(this.value);\" placeholder=\"Ketik Instansi Perguruan Tinggi...\"" )."
			<!--<a href=\"javascript:daftarpt('form,wewenang,kodept',\r\n\t\t\tdocument.form.kodept.value)\" >daftar PT</a>-->
			<div class=\"suggestionsBox\" id=\"suggestionsListPT\" style=\"display: none;\">
				<div class=\"suggestionsListPT\" id=\"autoSuggestionsListPT\"></div>
			</div>	
		</div>
	</div>
	<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">Nama Mata Kuliah</label>\r\n    
		<div class=\"col-lg-6\">".createinputtext( "namamakulbaru", $d2[NAMA], " class=form-control m-input size=50" )."</div>
	</div>
	<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
		<label class=\"col-lg-2 col-form-label\">Jumlah SKS</label>\r\n    
		<div class=\"col-lg-6\">".createinputtext( "sks", $d2[SKS], " class=form-control m-input  size=2" )."</div>
	</div>
	";

?>
