<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi2 == "formupdate" )
{
    $q = "SELECT * FROM trpud WHERE NODOSTRPUD='{$idupdate}' AND NORUTTRPUD='{$urutan}' \r\n   AND   THSMSTRPUD='{$tahunsemester}'";
    $h2 = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h2 ) )
    {
        $d2 = sqlfetcharray( $h2 );
        $tmp = $d2[THSMSTRPUD];
        $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
        $semester = $tmp[4];
        $tmp = $d2[THNBLTRPUD];
        $tahunp = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
        $bulanp = $tmp[4].$tmp[5];
        $judulp = $d2[JUDU1TRPUD].$d2[JUDU2TRPUD].$d2[JUDU3TRPUD].$d2[JUDU4TRPUD].$d2[JUDU5TRPUD];
    }
}
#echo "\r\n \t\t\t<tr class=judulform>\r\n\t\t\t\t<td width=200>Tahun/Semester Pelaporan Data</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t\t<select name=semester class=masukan> \r\n\t\t\t\t\t\t ";
echo "<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Tahun/Semester Pelaporan Data</label>\r\n    
			<div class=\"col-lg-6\">
				<select name=semester class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";

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
echo "\r\n\t\t\t\t\t\t</select>        ";
$waktu = getdate( );
if ( $tahun == "" )
{
    $tahun = $waktu[year];
}
echo "<select name=tahun class=form-control m-input style=\"width:auto;display:inline-block;\">";
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
echo "</select>
	</div>
	</div>
	<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
		<label class=\"col-lg-2 col-form-label\">Jenis Penelitian</label>\r\n    
		<div class=\"col-lg-6\">".createinputselect( "jenis", $arrayjenispenelitian, "{$d2['KDLITTRPUD']}", " class=form-control m-input  " )."</div>
	</div>
	<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">Media Publikasi</label>\r\n    
		<div class=\"col-lg-6\">".createinputselect( "media", $arraymediapublikasi, "{$d2['KDPUBTRPUD']}", " class=form-control m-input  " )."</div>
	</div>
	<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
		<label class=\"col-lg-2 col-form-label\">Jenis Pengarang</label>\r\n    
		<div class=\"col-lg-6\">".createinputselect( "pengarang", $arrayperanpenulisan, "{$d2['KDATHTRPUD']}", " class=form-control m-input  " )."</div>
	</div>
	<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">Kegiatan Mandiri/Kelompok</label>\r\n    
		<div class=\"col-lg-6\">".createinputselect( "mandiri", $arraykegiatanmandiri, "{$d2['KDKELTRPUD']}", " class=form-control m-input  " )."</div>
	</div>
	<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
		<label class=\"col-lg-2 col-form-label\">Tahun/Bulan Publikasi</label>\r\n    
		<div class=\"col-lg-6\"><select name=bulanp class=form-control m-input style=\"width:auto;display:inline-block;\">";
foreach ( $arraybulan as $k => $v )
{
    if ( $k + 1 == $bulanp )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='".( $k + 1 )."' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
}
echo "</select>";
$waktu = getdate( );
echo "<select name=tahunp class=form-control m-input style=\"width:auto;display:inline-block;\">";
$selected = "";
if ( $tahunp == "" )
{
    $tahunp = $w[year];
}
$i = 1901;
while ( $i <= $waktu[year] + 5 )
{
    if ( $i == $tahunp )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
    ++$i;
}
echo "</select>
		</div>
	</div>
	<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">Jumlah SKS</label>\r\n    
		<div class=\"col-lg-6\">".createinputtext( "sks", "{$d2['SKS']}", " class=form-control m-input size=2 " )."</div>
	</div>
	<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
		<label class=\"col-lg-2 col-form-label\">Pembiayaan</label>\r\n    
		<div class=\"col-lg-6\">".createinputselect( "biaya", $arraypembiayaan, "{$d2['KDBIYTRPUD']}", " class=form-control m-input  " )."</div>
	</div>
	<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">Jumlah Biaya Rp.</label>\r\n    
		<div class=\"col-lg-6\">".createinputtext( "biaya2", "{$d2['JMBIYTRPUD']}", " class=form-control m-input size=20 " )."</div>
	</div>
	<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
		<label class=\"col-lg-2 col-form-label\">Judul Publikasi</label>\r\n    
		<div class=\"col-lg-6\">".createinputtextarea( "judulp", $judulp, " cols=40 rows=6 class=form-control m-input  " )."</div>
	</div>";
?>
