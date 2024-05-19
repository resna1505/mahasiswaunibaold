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
    $q = "SELECT * FROM dosen_pengabdian WHERE IDDOSEN='{$idupdate}' AND NAMA='{$namakegiatan}' \r\n   AND   TAHUNSEMESTER='{$tahunsemester}'";
    $h2 = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h2 ) )
    {
        $d2 = sqlfetcharray( $h2 );
        $tmp = $d2[TAHUNSEMESTER];
        $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
        $semester = $tmp[4];
        $tmp = $d2[THNBLTRPUD];
        $tahunp = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
        $bulanp = $tmp[4].$tmp[5];
        $tmp = explode( "-", $d2[TANGGAL1] );
        $tgl1[tgl] = $tmp[2];
        $tgl1[bln] = $tmp[1];
        $tgl1[thn] = $tmp[0];
        $tmp = explode( "-", $d2[TANGGAL2] );
        $tgl2[tgl] = $tmp[2];
        $tgl2[bln] = $tmp[1];
        $tgl2[thn] = $tmp[0];
    }
}
#echo "\r\n \t\t\t<tr class=judulform>\r\n\t\t\t\t<td width=200>Tahun/Semester Pelaporan Data</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t\t<select name=semester class=form-control m-input> \r\n\t\t\t\t\t\t ";
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
echo "\r\n\t\t\t\t\t\t<select name=tahun class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
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
		<label class=\"col-lg-2 col-form-label\">Periode Tanggal</label>\r\n    
		<div class=\"col-lg-6\" style=\"max-width:52%;flex:auto;\">".createinputtanggal( "tgl1", $tgl1, "class=form-control m-input style=\"width:auto;display:inline-block;\"", " " )." s.d. ".createinputtanggal( "tgl2", $tgl2, "class=form-control m-input style=\"width:auto;display:inline-block;\"", " " )." </div>
	</div>
	<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">Nama Kegiatan Pengabdian</label>\r\n    
		<div class=\"col-lg-6\">".createinputtext( "namakegiatanbaru", $d2[NAMA], "size=50 class=form-control m-input", "" )."</div>
	</div>
	<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
		<label class=\"col-lg-2 col-form-label\">Jenis Kegiatan Pengabdian</label>\r\n    
		<div class=\"col-lg-6\">".createinputselect( "jenis", $arrayjenispengabdian, "{$d2['JENIS']}", " class=form-control m-input  " )."</div>
	</div>
	<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">Tempat/Instansi</label>\r\n    
		<div class=\"col-lg-6\">".createinputtext( "tempat", $d2[TEMPAT], "size=50 class=form-control m-input" , "" )."</div>
	</div>
	<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
		<label class=\"col-lg-2 col-form-label\">Jumlah SKS</label>\r\n    
		<div class=\"col-lg-6\">".createinputtext( "sks", "{$d2['SKS']}", " class=form-control m-input size=2 " )."</div>
	</div>";
?>
