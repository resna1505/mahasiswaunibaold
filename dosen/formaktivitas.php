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
$q = "SELECT * FROM trakd WHERE NODOSTRAKD='{$idupdate}' \r\n     AND THSMSTRAKD='{$tahunsemester}'\r\n     AND KDKMKTRAKD='{$makulupdate}' ";
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
#echo "\r\n\t\t\t\t\t\t</select>\r\n\r\n\t\t\t\r\n  </td>\r\n\t\t</tr>".( "<tr >\r\n\t\t\t<td width=150>Kode Makul</td>\r\n\t\t\t<td> " ).createinputtext( "kodemakul", $d2[KDKMKTRAKD], " class=form-control m-input size=10" )."\r\n  \t\t\t<a \r\n\t\t\thref=\"javascript:daftarmakul('form,wewenang,kodemakul',\r\n\t\t\tdocument.form.kodemakul.value)\" >\r\n\t\t\tdaftar Mata Kuliah\r\n\t\t\t</a>      \r\n      <br>\r\n      <b>".getfield( "NAMA", "makul", " WHERE ID='{$d2['KDKMKTRAKD']}'" )."\r\n      </td>\r\n\t\t</tr> \r\n    <tr class=judulform>\r\n\t\t\t<td>Kelas</td>\r\n\t\t\t<td>".createinputtext( "kelas", $d2[KELASTRAKD], " class=form-control m-input  size=3" )."</td>\r\n\t\t</tr>"."\r\n     <tr class=judulform>\r\n\t\t\t<td>Jumlah Tatap Muka</td>\r\n\t\t\t<td>".createinputtext( "jumlah1", $d2[TMRENTRAKD], " class=form-control m-input  size=3" )."</td>\r\n\t\t</tr> \r\n     <tr class=judulform>\r\n\t\t\t<td>Jumlah Realisasi Tatap Muka</td>\r\n\t\t\t<td>".createinputtext( "jumlah2", $d2[TMRELTRAKD], " class=form-control m-input  size=3" )."</td>\r\n\t\t</tr> \r\n   \r\n    \t\r\n \t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n \r\n \r\n \r\n\t\t";
echo "</select>
	</div>
	</div>
	<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
		<label class=\"col-lg-2 col-form-label\">Kode Makul</label>\r\n    
		<div class=\"col-lg-6\"> ".createinputtext( "kodemakul", $d2[KDKMKTRAKD], " class=form-control m-input size=10 id='inputStringMakul' onkeyup=\"lookupMakul(this.value,'' );\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
			<!--<a href=\"javascript:daftarmakul('form,wewenang,kodemakul',\r\n\t\t\tdocument.form.kodemakul.value)\" >daftar Mata Kuliah </a>-->
			<div class=\"suggestionsBoxMakul\" id=\"suggestionsMakul\" style=\"display: none;\">
				<div class=\"suggestionListMakul\" id=\"autoSuggestionsListMakul\"></div>
			</div>
			<br>
			<b>".getfield( "NAMA", "makul", " WHERE ID='{$d2['KDKMKTRAKD']}'" )."</b></div>
	</div> 
	<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">Kelas</label>\r\n    
		<div class=\"col-lg-6\">".createinputtext( "kelas", $d2[KELASTRAKD], " class=form-control m-input  size=3" )."</div>
	</div>
	<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">Jumlah Tatap Muka</label>\r\n    
		<div class=\"col-lg-6\">".createinputtext( "jumlah1", $d2[TMRENTRAKD], " class=form-control m-input  size=3" )."</div>
	</div>
	<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">Jumlah Realisasi Tatap Muka</label>\r\n    
		<div class=\"col-lg-6\">".createinputtext( "jumlah2", $d2[TMRELTRAKD], " class=form-control m-input  size=3" )."</div>
	</div>";

?>
