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
    $h = doquery($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $q = "INSERT INTO msmhs (NIMHSMSMHS,KDPTIMSMHS,KDJENMSMHS,KDPSTMSMHS) \r\n    VALUES ('{$idupdate}','{$kodept}','{$kodejenjang}','{$kodeps}') ";
        doquery($koneksi,$q);
        $q = "SELECT * FROM msmhs WHERE NIMHSMSMHS='{$idupdate}'";
        $h = doquery($koneksi,$q);
    }
    $d2 = sqlfetcharray( $h );
    $tmp = $d2[SMAWLMSMHS];
    $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
    $semester = $tmp[4];
    $tmp = $d2[BTSTUMSMHS];
    $tahun2 = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
    $semester2 = $tmp[4];
}
if ( $tahun == "" )
{
    $tahun = substr( $arraydefaultmhs[tahunsemesterawal], 0, 4 );
}
if ( $semester == "" )
{
    $semester = substr( $arraydefaultmhs[tahunsemesterawal], 4, 1 );
}
if ( $tahun2 == "" )
{
    $tahun2 = substr( $arraydefaultmhs[tahunsemesterbatas], 0, 4 );
}
if ( $semester2 == "" )
{
    $semester2 = substr( $arraydefaultmhs[tahunsemesterbatas], 4, 1 );
}
if ( $kodeprop == "" && $d2[ASSMAMSMHS] == "" )
{
    $d2[ASSMAMSMHS] = $kodeprop = $arraydefaultmhs[propinsi];
}
echo "	<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Kelas</label>\r\n    
			<label class=\"col-form-label\">".createinputselect( "kodekelas", $arraykelasmhs, $d2[SHIFTMSMHS], "", " class=form-control m-input" )."</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Semester Awal Terdaftar Sebagai Mahasiswa</label>
			<label class=\"col-form-label\">";
$waktu = getdate( );
echo "\r\n\t\t\t\t\t\t<select name=tahun class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
$selected = "";
$i = 1901;
while ( $i <= $waktu[year] + 20 )
{
    if ( $i == $tahun )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
    ++$i;
}
echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=semester class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
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
echo "		</select>
		</label>
	</div>
	<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
		<label class=\"col-lg-2 col-form-label\">Batas Studi</label>\r\n    
		<label class=\"col-form-label\">";
$waktu = getdate( );
echo "\r\n\t\t\t\t\t\t<select name=tahun2 class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
$selected = "";
$i = 1901;
while ( $i <= $waktu[year] + 20 )
{
    if ( $i == $tahun2 )
    {
        $selected = "selected";
    }
    echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
    $selected = "";
    ++$i;
}
echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=semester2 class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
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
echo "		</select>
		</label>
	</div>
	<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">Kode Propinsi Asal Pendidikan Terakhir</label>\r\n    
		<div class=\"col-lg-6\">
			<input type=text class=form-control m-input name=kodeprop value='{$d2['ASSMAMSMHS']}' id='inputStringPropinsi' onkeyup=\"lookupPropinsi(this.value);\" placeholder=\"Ketik Kode / Nama Propinsi...\">
			<!--<a href=\"javascript:daftarprop('form,wewenang,kodeprop',document.form.kodeprop.value)\" >daftar Propinsi/Negara</a>-->
			<div class=\"suggestionsBoxDosen\" id=\"suggestionsPropinsi\" style=\"display: none;\">
			   <div class=\"suggestionListPropinsi\" id=\"autoSuggestionsListPropinsi\"></div>
			</div>	
			".getnegara( $d2[ASSMAMSMHS] )." 
		</div>
	</div>
	<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
		<label class=\"col-lg-2 col-form-label\">Status Awal Mahasiswa Baru</label>
		<label class=\"col-form-label\">".createinputselect( "statusbaru", $arraystatusmhsbaru, $d2[STPIDMSMHS], "", " class=form-control m-input" )."</label>
	</div>
	<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">Khusus Mahasiswa Pindahan</label>\r\n    
		<label class=\"col-form-label\">
			SK Rektor <input type=text size=40 name=skpindahan class=form-control m-input value='{$d['SKPINDAHAN']}'>Tanggal ".createinputtanggal( "tanggalskpindahan", $tanggalskpindahan, "class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
		</label>
	</div>";
		if ( $d2[STPIDMSMHS] == "P" && $d2[SKSDIMSMHS] <= 0 )
		{
		$statussks = "Status Mahasiswa Pindahan tetapi SKS yg diakui bernilai Nol ";
		$stylesks = "style='background-color:#ffff00'";
		}
		if ( $d2[STPIDMSMHS] == "B" && 0 < $d2[SKSDIMSMHS] )
		{
		$statussks = "Status Mahasiswa baru tetapi SKS yg diakui lebih dari Nol ";
		$stylesks = "style='background-color:#ffff00'";
		}else{
			$stylesks = "style='background-color:#d8e2f7'";
		}
echo "	<div class=\"form-group m-form__group row\" {$stylesks}>
			<label class=\"col-lg-2 col-form-label\">Jumlah SKS Diakui u/ Mhs Baru/Pindahan</label>
			<label class=\"col-form-label\">
				<input type=text size=3 class=form-control m-input style=\"width:auto;display:inline-block;\" name=sksbaru value='{$d2['SKSDIMSMHS']}'>  {$statussks}
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">NIM Asal dari PT Sebelumnya (Pindahan)</label>\r\n    
			<label class=\"col-form-label\">
				<input type=text size=15 class=form-control m-input style=\"width:auto;display:inline-block;\" name=nimasal value='{$d2['ASNIMMSMHS']}'>
			</label>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Kode PT Sebelumnya (Pindahan)</label>\r\n    
			<div class=\"col-lg-6\">
				<input type=text size=6 class=form-control m-input name=ptasal value='{$d2['ASPTIMSMHS']}' id='inputStringListPT' onkeyup=\"lookupListPT(this.value);\" placeholder=\"Ketik Instansi Perguruan Tinggi...\">
				<!--<a href=\"javascript:daftarpt('form,wewenang,ptasal',document.form.ptasal.value)\" >daftar PT</a>-->
				<div class=\"suggestionsBox\" id=\"suggestionsListPT\" style=\"display: none;\">
					<div class=\"suggestionsListPT\" id=\"autoSuggestionsListPT\"></div>
				</div>	
			</div>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Jenjang PT Sebelumnya (Pindahan)</label>\r\n    
			<label class=\"col-form-label\">
				".createinputselect( "jasal", $arrayjenjang, $d2[ASJENMSMHS], "", " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Kode Program Studi Sebelumnya (Pindahan)</label>\r\n    
			<div class=\"col-lg-6\">
				<input type=text size=5 class=form-control m-input name=psasal value='{$d2['ASPSTMSMHS']}' id='inputStringProdiPT2' onkeyup=\"lookupProdiPT2(this.value,'');\" placeholder=\"Ketik Prodi Perguruan Tinggi...\">
					<!--<a href=\"javascript:daftarprodi('form,wewenang,psasal',document.form.psasal.value)\" >daftar Prodi</a>-->
					<div class=\"suggestionsBox\" id=\"suggestionsProdiPT2\" style=\"display: none;\">
						<div class=\"suggestionsProdiPT2\" id=\"autoSuggestionsProdiPT2\"></div>
					</div>
			</div>
		</div>";
echo "	<div class='portlet-title'>";
			printtitle("{$JUDULKHUSUSS3}");
echo "	</div>";
echo "	<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Kode Biaya Studi</label>\r\n    
			<label class=\"col-form-label\">
				".createinputselect( "kodebiaya", $arraybiayastudi, $d2[BISTUMSMHS], "", " class=form-control m-input" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Kode Pekerjaan</label>\r\n    
			<label class=\"col-form-label\">
				".createinputselect( "kodekerja", $arraykodepekerjaan, $d2[PEKSBMSMHS], "", " class=form-control m-input" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Nama Tempat Bekerja, bila bukan Dosen</label>\r\n    
			<label class=\"col-form-label\">
				<input type=text size=40 name=tempatkerja class=form-control m-input style=\"width:auto;display:inline-block;\" value='{$d2['NMPEKMSMHS']}'>
			</label>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Kode PT Tempat Bekerja, bila Dosen</label>\r\n    
			<label class=\"col-form-label\">
				<input type=text size=6 name=ptkerja class=form-control m-input style=\"width:auto;display:inline-block;\" value='{$d2['PTPEKMSMHS']}'>
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Kode PS Tempat Bekerja, bila Dosen</label>\r\n    
			<label class=\"col-form-label\">
				<input type=text size=5 class=form-control m-input style=\"width:auto;display:inline-block;\" name=pskerja value='{$d2['PSPEKMSMHS']}'>
			</label>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">NIDN Promotor</label>\r\n    
			<div class=\"col-lg-6\">
				<input type=text size=5 class=form-control m-input name=nidnpro value='{$d2['NOPRMMSMHS']}' id='inputStringListDosenNidn' onkeyup=\"lookupListDosenNidn(this.value);\" placeholder=\"Ketik NIDN / Nama Dosen DIKTI...\">
				<!--<a href=\"javascript:daftardos('form,wewenang,nidnpro',document.form.nidnpro.value)\" >daftar NIDN Dosen DIKTI</a>-->
				<div class=\"suggestionsBox\" id=\"suggestionsListDosenNidn\" style=\"display: none;\">
					<div class=\"suggestionsListDosenNidn\" id=\"autoSuggestionsListDosenNidn\"></div>
				</div>	
			</div>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">NIDN Ko-Promotor #1</label>\r\n    
			<div class=\"col-lg-6\">
				<input type=text size=5 class=form-control m-input name=nidnpro1 value='{$d2['NOKP1MSMHS']}' id='inputStringListDosenNidn2' onkeyup=\"lookupListDosenNidn2(this.value);\" placeholder=\"Ketik NIDN / Nama Dosen DIKTI...\">
					<!--<a href=\"javascript:daftardos('form,wewenang,nidnpro1',document.form.nidnpro1.value)\" >daftar NIDN Dosen DIKTI</a>-->
				<div class=\"suggestionsBox\" id=\"suggestionsListDosenNidn2\" style=\"display: none;\">
					<div class=\"suggestionsListDosenNidn2\" id=\"autoSuggestionsListDosenNidn2\"></div>
				</div>	
			</div>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">NIDN Ko-Promotor #2</label>\r\n    
			<div class=\"col-lg-6\">
				<input type=text size=5 class=form-control m-input name=nidnpro2 value='{$d2['NOKP2MSMHS']}' id='inputStringListDosenNidn3' onkeyup=\"lookupListDosenNidn3(this.value);\" placeholder=\"Ketik NIDN / Nama Dosen DIKTI...\">
				<!--<a href=\"javascript:daftardos('form,wewenang,nidnpro2',document.form.nidnpro2.value)\" >daftar NIDN Dosen DIKTI</a>-->
				<div class=\"suggestionsBox\" id=\"suggestionsListDosenNidn3\" style=\"display: none;\">
					<div class=\"suggestionsListDosenNidn3\" id=\"autoSuggestionsListDosenNidn3\"></div>
				</div>
			</div>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">NIDN Ko-Promotor #3</label>\r\n    
			<div class=\"col-lg-6\">
				<input type=text size=5 class=form-control m-input name=nidnpro3 value='{$d2['NOKP3MSMHS']}' id='inputStringListDosenNidn4' onkeyup=\"lookupListDosenNidn4(this.value);\" placeholder=\"Ketik NIDN / Nama Dosen DIKTI...\">
				<!--<a href=\"javascript:daftardos('form,wewenang,nidnpro3',document.form.nidnpro3.value)\" >daftar NIDN Dosen DIKTI</a>-->
				<div class=\"suggestionsBox\" id=\"suggestionsListDosenNidn4\" style=\"display: none;\">
					<div class=\"suggestionsListDosenNidn4\" id=\"autoSuggestionsListDosenNidn4\"></div>
				</div>
			</div>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">NIDN Ko-Promotor #4</label>\r\n    
			<div class=\"col-lg-6\">
				<input type=text size=5 class=form-control m-input name=nidnpro4 value='{$d2['NOKP4MSMHS']}' id='inputStringListDosenNidn5' onkeyup=\"lookupListDosenNidn5(this.value);\" placeholder=\"Ketik NIDN / Nama Dosen DIKTI...\">
				<!--<a href=\"javascript:daftardos('form,wewenang,nidnpro4',document.form.nidnpro4.value)\" >daftar NIDN Dosen DIKTI</a>-->
				<div class=\"suggestionsBox\" id=\"suggestionsListDosenNidn5\" style=\"display: none;\">
					<div class=\"suggestionsListDosenNidn5\" id=\"autoSuggestionsListDosenNidn5\"></div>
				</div>
			</div>
		</div>";
?>
