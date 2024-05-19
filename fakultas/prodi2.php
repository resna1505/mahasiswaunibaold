<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SELECT KDPTIMSPTI FROM mspti LIMIT 0,1";
$h = doquery($koneksi, $q );
$d = sqlfetcharray( $h );
$idpt = $d['KDPTIMSPTI'];
if ( $aksi == "formupdate" )
{
    $q = "SELECT * FROM mspst WHERE IDX='{$idupdate}'";
    $h = doquery($koneksi, $q );
    if ( sqlnumrows( $h ) <= 0 )
    {
        $q = "INSERT INTO mspst (IDX) VALUES ('{$idupdate}') ";
        doquery($koneksi, $q );
        $q = "SELECT * FROM mspst WHERE IDX='{$idupdate}'";
        $h = doquery($koneksi, $q );
    }
    $d2 = sqlfetcharray( $h );
    $tmp = explode( "-", $d2['TGAWLMSPST'] );
    $thna = $tmp[0];
    $blna = $tmp[1];
    $tgla = $tmp[2];
    $tmp = explode( "-", $d2['TGLSKMSPST'] );
    $thn1 = $tmp[0];
    $bln1 = $tmp[1];
    $tgl1 = $tmp[2];
    $tmp = explode( "-", $d2['TGLAKMSPST'] );
    $thn2 = $tmp[0];
    $bln2 = $tmp[1];
    $tgl2 = $tmp[2];
    $tmp = explode( "-", $d2['TGLBAMSPST'] );
    $thnak1 = $tmp[0];
    $blnak1 = $tmp[1];
    $tglak1 = $tmp[2];
    $tmp = explode( "-", $d2['TGLABMSPST'] );
    $thnak2 = $tmp[0];
    $blnak2 = $tmp[1];
    $tglak2 = $tmp[2];
    $tmp = $d2[SMAWLMSPST];
    $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
    $semester = $tmp[4];
    $tmp = $d2[MLSEMMSPST];
    $tahun2 = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
    $semester2 = $tmp[4];
}
if ( $d2['KDPSTMSPST'] == "" )
{
    $d2['KDPSTMSPST'] = $id;
}
if ( $d2['EMAILMSPST'] == "" )
{
    $d2['EMAILMSPST'] = $email;
}
if ( $d2['NOMSKMSPST'] == "" )
{
    $d2['NOMSKMSPST'] = $nosk;
}
if ( $d2['NOMBAMSPST'] == "" )
{
    $d2['NOMBAMSPST'] = $noak;
}
if ( $d2['KDSTAMSPST'] == "" )
{
    $d2['KDSTAMSPST'] = $statusak;
}
if ( $d2['KDFREMSPST'] == "" )
{
    $d2['KDFREMSPST'] = $frek;
}
if ( $d2['KDPELMSPST'] == "" )
{
    $d2['KDPELMSPST'] = $pel;
}
if ( $d2['TELPSMSPST'] == "" )
{
    $d2['TELPSMSPST'] = $teleponk;
}
if ( $d2['TELPOMSPST'] == "" )
{
    $d2['TELPOMSPST'] = $telepon;
}
if ( $d2['FAKSIMSPST'] == "" )
{
    $d2['FAKSIMSPST'] = $faks;
}
if ( $d2['NMOPRMSPST'] == "" )
{
    $d2['NMOPRMSPST'] = $namaopr;
}
if ( $d2['TELPRMSPST'] == "" )
{
    $d2['TELPRMSPST'] = $teleponopr;
}
echo createinputhidden( "idlama", "{$d2['KDPSTMSPST']}", "" )."
<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
	<label class=\"col-lg-2 col-form-label\">Kode PT</label>
	<div class=\"col-lg-6\"><input readonly type=text size=6 name=idpt class=form-control m-input value='{$idpt}'></div>
</div>
<div class=\"form-group m-form__group row\">
	<label class=\"col-lg-2 col-form-label\">Kode Program Studi</label>
	<div class=\"col-lg-6\">
		<input  type=text size=5 name=id class=form-control m-input value='{$d2['KDPSTMSPST']}' id='inputStringListProdi' onkeyup=\"lookupListProdi(this.value);\">
		<!--<a href=\"javascript:daftarprodi('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >\r\n\t\t\tdaftar Prodi\r\n\t\t\t</a>\r\n \r\n-->
		<div class=\"suggestionsBox\" id=\"suggestionsListProdi\" style=\"display: none;\">
			<div class=\"suggestionListProdi\" id=\"autoSuggestionsListProdi\"></div>
		</div>	
	</div>
</div>
<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
	<label class=\"col-lg-2 col-form-label\">Tanggal Awal Berdiri</label>
	<div class=\"col-lg-6\">
		<input type=text size=2 name=tgla class=form-control m-input style=\"width:auto;display:inline-block;\" value='{$tgla}'><input type=text size=2 name=blna class=form-control m-input style=\"width:auto;display:inline-block;\" value='{$blna}'><input type=text size=4 name=thna class=form-control m-input style=\"width:auto;display:inline-block;\" value='{$thna}'>
	</div>
</div>
<div class=\"form-group m-form__group row\">
	<label class=\"col-lg-2 col-form-label\">Semester Awal Mulai Lapor</label>
	<div class=\"col-lg-6\">";
		$waktu = getdate( );
		echo "\r\n\t\t\t\t\t\t<select name=tahun class=form-control m-input style=\"width:auto;display:inline-block;\" > \r\n\t\t\t\t\t\t ";
		$selected = "";
		$i = 1901;
		while ( $i <= $waktu['year'] + 5 )
		{
			if ( $i == $tahun )
			{
				$selected = "selected";
			}
			echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
			$selected = "";
			++$i;
		}
		echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=semester class=form-control m-input style=\"width:auto;display:inline-block;\" > \r\n\t\t\t\t\t\t ";
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
		echo "\r\n\t\t\t\t\t\t</select> 
	</div>
</div>
<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
	<label class=\"col-lg-2 col-form-label\">Status</label>
	<div class=\"col-lg-6\">".createinputselect( "status", $arraystatuspt, $d2['STATUMSPST'], "", " class=form-control m-input" )."\r\n  </div>
</div>
<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
	<label class=\"col-lg-2 col-form-label\">Mulai Semester</label>
	<div class=\"col-lg-6\">";
		$waktu = getdate();
		echo "\r\n\t\t\t\t\t\t<select name=tahun2 class=form-control m-input style=\"width:auto;display:inline-block;\" > \r\n\t\t\t\t\t\t ";
		$selected = "";
		$i = 1901;
		while ( $i <= $waktu['year'] + 5 )
		{
			if ( $i == $tahun2 )
			{
				$selected = "selected";
			}
			echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
			$selected = "";
			++$i;
		}
		echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=semester2 class=form-control m-input style=\"width:auto;display:inline-block;\" > \r\n\t\t\t\t\t\t ";
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
		echo "</select>
	</div>
</div>
<div class=\"form-group m-form__group row\">
	<label class=\"col-lg-2 col-form-label\">Email</label>
	<div class=\"col-lg-6\"><input  type=text size=40 name=email class=form-control m-input value='{$d2['EMAILMSPST']}'></div>
</div>
<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
	<label class=\"col-lg-2 col-form-label\">No. SK Terakhir</label>
	<div class=\"col-lg-6\"><input  type=text size=40 name=nosk class=form-control m-input value='{$d2['NOMSKMSPST']}'></div>
</div>
<div class=\"form-group m-form__group row\">
	<label class=\"col-lg-2 col-form-label\">Tanggal SK Terakhir Dikti</label>
	<div class=\"col-lg-6\">
		<input type=text size=2 name=tgl1 class=form-control m-input style=\"width:auto;display:inline-block;\" value='{$tgl1}'><input type=text size=2 name=bln1 class=form-control m-input style=\"width:auto;display:inline-block;\" value='{$bln1}'><input type=text size=4 name=thn1 class=form-control m-input style=\"width:auto;display:inline-block;\" value='{$thn1}'>
	</div>
</div>
<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
	<label class=\"col-lg-2 col-form-label\">Tanggal Berakhir SK</label>
	<div class=\"col-lg-6\">
		<input type=text size=2 name=tgl2 class=form-control m-input style=\"width:auto;display:inline-block;\" value='{$tgl2}'><input type=text size=2 name=bln2 class=form-control m-input style=\"width:auto;display:inline-block;\" value='{$bln2}'><input type=text size=4 name=thn2 class=form-control m-input style=\"width:auto;display:inline-block;\" value='{$thn2}'>
	</div>
</div>
<div class=\"form-group m-form__group row\">
	<label class=\"col-lg-2 col-form-label\">No. SK Akreditasi BAN-PT Terakhir</label>
	<div class=\"col-lg-6\"><input  type=text size=40 name=noak class=form-control m-input value='{$d2['NOMBAMSPST']}'></div>
</div>
<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
	<label class=\"col-lg-2 col-form-label\">Tanggal SK Akreditasi</label>
	<div class=\"col-lg-6\">
		<input type=text size=2 name=tglak1 class=form-control m-input style=\"width:auto;display:inline-block;\" value='{$tglak1}'><input type=text size=2 name=blnak1 class=form-control m-input style=\"width:auto;display:inline-block;\" value='{$blnak1}'><input type=text size=4 name=thnak1 class=form-control m-input  style=\"width:auto;display:inline-block;\" value='{$thnak1}'>
	</div>
</div>
<div class=\"form-group m-form__group row\">
	<label class=\"col-lg-2 col-form-label\">Tanggal Berakhir SK Akreditasi</label>
	<div class=\"col-lg-6\">
		<input type=text size=2 name=tglak2 class=form-control m-input style=\"width:auto;display:inline-block;\" value='{$tglak2}'><input type=text size=2 class=form-control m-input style=\"width:auto;display:inline-block;\" name=blnak2 value='{$blnak2}'><input type=text size=4 name=thnak2 class=form-control m-input style=\"width:auto;display:inline-block;\" value='{$thnak2}'>
	</div>
</div>
<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
	<label class=\"col-lg-2 col-form-label\">Status Akreditasi</label>
	<div class=\"col-lg-6\">".createinputselect( "statusak", $arrayakreditasipt, $d2['KDSTAMSPST'], "", " class=form-control m-input" )."</div>
</div>
<div class=\"form-group m-form__group row\">
	<label class=\"col-lg-2 col-form-label\">Frekuensi Pemutakhiran Kurikulum</label>
	<div class=\"col-lg-6\">".createinputselect( "frek", $arrayfpk, $d2['KDFREMSPST'], "", " class=form-control m-input" )."</div>
</div>
<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
	<label class=\"col-lg-2 col-form-label\">Pelaksanaan Pemutakhiran Kurikulum</label>
	<div class=\"col-lg-6\">".createinputselect( "pel", $arrayppk, $d2['KDPELMSPST'], "", " class=form-control m-input" )."</div>
</div>
<div class=\"form-group m-form__group row\">
	<label class=\"col-lg-2 col-form-label\">Telepon Ketua Program Studi</label>
	<div class=\"col-lg-6\"><input type=text size=20 name=teleponk class=form-control m-input value='{$d2['TELPSMSPST']}'></div>
</div>
<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
	<label class=\"col-lg-2 col-form-label\">Telepon Program Studi</label>
	<div class=\"col-lg-6\"><input type=text size=20 name=telepon class=form-control m-input value='{$d2['TELPOMSPST']}'></div>
</div>
<div class=\"form-group m-form__group row\">
	<label class=\"col-lg-2 col-form-label\">Faks Program Studi</label>
	<div class=\"col-lg-6\"><input type=text size=20 name=faks class=form-control m-input value='{$d2['FAKSIMSPST']}'></div>
</div>
<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
	<label class=\"col-lg-2 col-form-label\">Nama Operator</label>
	<div class=\"col-lg-6\"><input type=text size=40 name=namaopr class=form-control m-input value='{$d2['NMOPRMSPST']}'></div>
</div>
<div class=\"form-group m-form__group row\">
	<label class=\"col-lg-2 col-form-label\">Telepon Operator</label>
	<div class=\"col-lg-6\"><input type=text size=20 name=teleponopr class=form-control m-input value='{$d2['TELPRMSPST']}'></div>
</div>";
if ( $UNIVERSITAS == "UNIVERSITAS BATAM" && $aksi == "formupdate" )
{
	echo "			<div class='portlet-title'>";
												printtitle("Setting Transkrip");
						echo "			</div>";
	echo "<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Label Judul Skripsi Bahasa Indonesia</label>
			<div class=\"col-lg-6\"><input type=text size=50 name=labelskripsi class=form-control m-input value='{$labelskripsi}'></div>
		</div>";
	echo "<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Label Judul Skripsi Bahasa Inggris</label>
			<div class=\"col-lg-6\"><input type=text size=50 name=labelskripsi2 class=form-control m-input value='{$labelskripsi2}'></div>
		</div>";
    #echo "\r\n<tr>\r\n  <td colspan=2><b>SETTING TRANSKRIP<hr></td>\r\n</tr>\r\n<tr>\r\n  <td >LABEL JUDUL SKRIPSI</td>\r\n  <td >\r\n  Indonesia: <input type=text size=50 name=labelskripsi value='{$labelskripsi}'> <br>\r\n  Inggris: <input type=text size=50 name=labelskripsi2 value='{$labelskripsi2}'> <br>\r\n  </td>\r\n</tr>\r\n";
}
?>