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
    $q = "SELECT * FROM tbkmksp WHERE KDKMKTBKMK='{$idupdate}' AND THSMSTBKMK='{$tahunsemester}'\r\n    AND KDJENTBKMK='{$jenjangupdate}'\r\n    AND KDPSTTBKMK='{$prodiupdate}'";
    $h = mysqli_query($koneksi,$q);
    $d2 = sqlfetcharray( $h );
    $tmp = $d2[THSMSTBKMK];
    $tahun2 = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
    $semester2 = $tmp[4];
}
else
{
    $q = "SELECT SEMESTER,SKS,KDJENMSPST,KDPSTMSPST \r\n    FROM makul,mspst\r\n    WHERE \r\n    mspst.IDX=makul.IDPRODI AND\r\n    makul.ID='{$idupdate}'\r\n    \r\n    ";
    $h = mysqli_query($koneksi,$q);
    $d3 = sqlfetcharray( $h );
    $d2[JENJATBKMK] = $d2[KDJENTBKMK] = $jenjang1 = $d3[KDJENMSPST];
    $d2[PRODITBKMK] = $d2[KDPSTTBKMK] = $prodi1 = $d3[KDPSTMSPST];
    $d2[SKSMKTBKMK] = $d3[SKS];
    $d2[SEMESTBKMK] = $d3[SEMESTER];
    if ( $statusoperatormakul == 1 )
    {
        $d2[KDJENTBKMK] = $kodejenjangmakul;
        $d2[KDPSTTBKMK] = $kodeprodimakul;
        $readonlymakul = "readonly";
    }
}
#echo "\r\n<tr class=judulform>\r\n\t\t\t<td>KELOMPOK KURIKULUM</td>\r\n\t\t\t<td>".createinputselect( "kelompokkurikulum", $arraykelompokkurikulum, "{$d2['KELOMPOKKURIKULUM']}", "", " class=form-control m-input " )."</td>\r\n\t\t</tr>\t\r\n<tr>\r\n  <td>Nama Makul di Kurikulum *</td>\r\n  <td><input type=text size=40 name=namamakul2 value='{$d2['NAKMKTBKMK']}'> <br>\r\n    <input type=checkbox name=ifnama value=1 checked>Ubah Nama Mata Kuliah di KRS Mahasiswa \r\n  \r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>Nama Makul dalam Bahasa Inggris</td>\r\n  <td><input type=text size=40 name=nama2 value='{$d2['NAMA2']}'><br>\r\n  \r\n  \r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td  colspan=2><hr></td>\r\n</tr>\r\n<tr>\r\n  <td>Tahun Semester Pelaporan Data</td>\r\n  <td>\r\n";
echo " 		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">KELOMPOK KURIKULUM</label>\r\n    
				<div class=\"col-lg-6\">".createinputselect( "kelompokkurikulum", $arraykelompokkurikulum, "{$d2['KELOMPOKKURIKULUM']}", "", " class=form-control m-input " )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Nama Makul di Kurikulum *</label>\r\n    
				<div class=\"col-lg-6\">
					<input type=text size=40 name=namamakul2 value='{$d2['NAKMKTBKMK']}' class=form-control m-input><br>\r\n    <input type=checkbox name=ifnama value=1 checked>Ubah Nama Mata Kuliah di KRS Mahasiswa 
				</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Nama Makul dalam Bahasa Inggris</label>
				<div class=\"col-lg-6\"><input type=text size=40 name=nama2 value='{$d2['NAMA2']}' class=form-control m-input><br></div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Tahun Semester Pelaporan Data</label>
				<div class=\"col-lg-6\">";
if ( $aksi2 == "formtambah" )
{
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
    echo "\r\n\t\t\t\t\t\t</select>";
}
else
{
    echo "<b>{$tahun2}/".( $tahun2 + 1 )." ".$arraysemester[$semester2];
    echo "<input type=hidden name=tahun2 value='{$tahun2}'>";
    echo "<input type=hidden name=semester2 value='{$semester2}'>";
}
#echo "\r\n    \r\n  \r\n   </td>\r\n</tr>\r\n\r\n<tr class=judulform>\r\n\t\t\t<td>Jenjang Program Studi </td>\r\n\t\t\t<td>";
echo "			</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Jenjang Program Studi *</label>\r\n    
				<div class=\"col-lg-6\">";
if ( $aksi2 == "formtambah" )
{
    echo createinputselect( "jenjang1", $arrayjenjang, "{$d2['KDJENTBKMK']}", " ", " class=form-control m-input  " );
}
else
{
    echo "<b>".$arrayjenjang[$d2[KDJENTBKMK]]."</b>";
    echo "<input type=hidden name=jenjang1 value='{$d2['KDJENTBKMK']}'>";
}
#echo "</td>\r\n\t\t</tr>\t\t\r\n\r\n <tr>\r\n  <td >Program Studi </td>\r\n  <td >\r\n\r\n  \t\t\t";
echo "			</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Program Studi Penyelenggara</label>\r\n    
				<div class=\"col-lg-6\">";
if ( $aksi2 == "formtambah" )
{
    echo createinputtext( "prodi1", $d2[KDPSTTBKMK], "{$readonlymakul} class=form-control m-input  size=5 id='inputStringProdiPT' onkeyup=\"lookupProdiPT(this.value);\" placeholder=\"Ketik Prodi Perguruan Tinggi...\"  " )."
		<!--<a href=\"javascript:daftarprodipt('form,wewenang,prodi1',\r\n  \t\t\tdocument.form.prodi1.value)\" >
		daftar Referensi Program Studi di P.T.</a>-->
		<div class=\"suggestionsBox\" id=\"suggestionsProdiPT\" style=\"display: none;\">
										<div class=\"suggestionsProdiPT\" id=\"autoSuggestionsProdiPT\"></div>
							</div>";
    echo "<b>".$d2[KDPSTTBKMK]."</b>";
}
else if ( $d2[KDJENTBKMK] != "" )
{
    $q = "SELECT NMPSTMSPST FROM mspst WHERE \r\n            KDPSTMSPST='{$d2['KDPSTTBKMK']}' AND\r\n                 KDJENMSPST='{$d2['KDJENTBKMK']}' LIMIT 0,1";
    $hpt = mysqli_query($koneksi,$q);
    $dpt = sqlfetcharray( $hpt );
    echo " ( {$dpt['NMPSTMSPST']} )";
    echo "<input type=hidden name=prodi1 value='{$d2['KDPSTTBKMK']}'>";
}
#echo "\t\t\t\r\n\t\t\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n<tr>\r\n  <td>SKS Kurikulum</td>\r\n  <td><input type=text size=2 name=sks value='{$d2['SKSMKTBKMK']}'>\r\n  <input type=checkbox name=ifsks value=1 checked> Ubah nilai SKS di KRS Mahasiswa \r\n  </td>\r\n</tr>\r\n<tr>\r\n  <td>SKS Tatap Muka</td>\r\n  <td><input type=text size=2 name=sks2 value='{$d2['SKSTMTBKMK']}'></td>\r\n</tr>\r\n<tr>\r\n  <td>SKS Praktikum</td>\r\n  <td><input type=text size=2 name=sks3 value='{$d2['SKSPRTBKMK']}'></td>\r\n</tr>\r\n<tr>\r\n  <td>SKS Praktek Lapangan</td>\r\n  <td><input type=text size=2 name=sks4 value='{$d2['SKSLPTBKMK']}'></td>\r\n</tr>\r\n<tr>\r\n  <td>Penempatan di Semester</td>\r\n  <td><input type=text size=2 name=sem value='{$d2['SEMESTBKMK']}'></td>\r\n</tr>\r\n <tr class=judulform>\r\n\t\t\t<td>Kelompok Mata Kuliah</td>\r\n\t\t\t<td>".createinputselect( "kelompok", $arraykelompokmk, $d2[KDKELTBKMK], "", " class=form-control m-input " )."</td>\r\n\t\t</tr>\t\t\r\n<tr class=judulform>\r\n\t\t\t<td>Kurikulum Inti/Institusi</td>\r\n\t\t\t<td>".createinputselect( "kurikulum", $arrayjeniskurikulum, "{$d2['KDKURTBKMK']}", "", " class=form-control m-input " )."</td>\r\n\t\t</tr>\t\t\r\n<tr class=judulform>\r\n\t\t\t<td>Mata Kuliah Wajib/Pilihan</td>\r\n\t\t\t<td>".createinputselect( "wajib", $arrayjenismk, "{$d2['KDWPLTBKMK']}", "", " class=form-control m-input " )."</td>\r\n\t\t</tr>\t\t\r\n \r\n <tr>\r\n  <td >No. Dosen Pengampu</td>\r\n  <td >\r\n \r\n\t\t\t".createinputtext( "dosen", $d2[NODOSTBKMK], " class=form-control m-input  size=10" )."\r\n \t\t\t<a \r\n\t\t\thref=\"javascript:daftardosen('form,wewenang,dosen',\r\n\t\t\tdocument.form.dosen.value)\" >\r\n\t\t\tdaftar Referensi Dosen\r\n\t\t\t</a>\t\t\t\r\n  </td>\r\n</tr>\r\n<tr class=judulform>\r\n\t\t\t<td>Jenjang Program Studi Pengampu</td>\r\n\t\t\t<td>".createinputselect( "jenjang", $arrayjenjang, "{$d2['JENJATBKMK']}", "", " class=form-control m-input " )."</td>\r\n\t\t</tr>\t\t\r\n\r\n <tr>\r\n  <td >Program Studi Pengampu</td>\r\n  <td >\r\n  \t\t\t".createinputtext( "prodi", $d2[PRODITBKMK], " class=form-control m-input  size=5" )."\r\n \t\t\t<a \r\n\t\t\thref=\"javascript:daftarprodipt('form,wewenang,prodi',\r\n\t\t\tdocument.form.prodi.value)\" >\r\n\t\t\tdaftar Referensi Program Studi di P.T.\r\n\t\t\t</a>\t\t\t\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr> \r\n \r\n<tr class=judulform>\r\n\t\t\t<td>Status Mata Kuliah</td>\r\n\t\t\t<td>".createinputselect( "status", $arraystatuspt, "{$d2['STKMKTBKMK']}", "", " class=form-control m-input " )."</td>\r\n\t\t</tr>\t\r\n\r\n<tr class=judulform>\r\n\t\t\t<td>Silabus</td>\r\n\t\t\t<td>".createinputselect( "silabus", $arrayya2, "{$d2['SLBUSTBKMK']}", "", " class=form-control m-input " )."</td>\r\n\t\t</tr>\t\r\n<tr class=judulform>\r\n\t\t\t<td>Satuan Acara Perkuliahan</td>\r\n\t\t\t<td>".createinputselect( "satuan", $arrayya2, "{$d2['SAPPPTBKMK']}", "", " class=form-control m-input " )."</td>\r\n\t\t</tr>\t\r\n<tr class=judulform>\r\n\t\t\t<td>Bahan Ajar</td>\r\n\t\t\t<td>".createinputselect( "bahan", $arrayya2, "{$d2['BHNAJTBKMK']}", "", " class=form-control m-input " )."</td>\r\n\t\t</tr>\t\r\n<tr class=judulform>\r\n\t\t\t<td>Diktat</td>\r\n\t\t\t<td>".createinputselect( "diktat", $arrayya2, "{$d2['DIKTTTBKMK']}", "", " class=form-control m-input " )."</td>\r\n\t\t</tr>\t\r\n \r\n<tr>\r\n  <td  colspan=2><hr></td>\r\n</tr>\r\n\r\n";
echo "			</div>
			</div> 
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">SKS Kurikulum *</label>\r\n    
				<div class=\"col-lg-6\"><input type=text size=2 name=sks maxlength=2 value='{$d2['SKSMKTBKMK']}' class=form-control m-input>\r\n    
				<input type=checkbox name=ifsks value=1 checked>  Ubah nilai SKS di KRS Mahasiswa\r\n  </div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">SKS Tatap Muka</label>\r\n    
				<div class=\"col-lg-6\"><input type=text size=2 maxlength=2 name=sks2 value='{$d2['SKSTMTBKMK']}' class=form-control m-input></div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">SKS Praktikum</label>\r\n    
				<div class=\"col-lg-6\"><input type=text size=2 name=sks3 maxlength=2 value='{$d2['SKSPRTBKMK']}' class=form-control m-input></div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">SKS Praktek Lapangan</label>\r\n    
				<div class=\"col-lg-6\"><input type=text size=2 name=sks4 maxlength=2 value='{$d2['SKSLPTBKMK']}' class=form-control m-input></div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Penempatan di Semester</label>\r\n    
				<div class=\"col-lg-6\"><input type=text size=2 name=sem value='{$d2['SEMESTBKMK']}' class=form-control m-input></div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Kelompok Mata Kuliah</label>\r\n    
				<div class=\"col-lg-6\">".createinputselect( "kelompok", $arraykelompokmk, $d2[KDKELTBKMK], "", " class=form-control m-input " )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Kurikulum Inti/Institusi</label>
				<div class=\"col-lg-6\">".createinputselect( "kurikulum", $arrayjeniskurikulum, "{$d2['KDKURTBKMK']}", "", " class=form-control m-input " )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Mata Kuliah Wajib/Pilihan</label>
				<div class=\"col-lg-6\">".createinputselect( "wajib", $arrayjenismk, "{$d2['KDWPLTBKMK']}", "", " class=form-control m-input " )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">No. Dosen Pengampu</label>
				<div class=\"col-lg-6\">
					".createinputtext( "dosen", $d2[NODOSTBKMK], " class=form-control m-input  size=10 id='inputStringDosen' onkeyup=\"lookupDosen(this.value,'');\" placeholder=\"Ketik NIDN / Nama Dosen...\"" )."
					<!--<a href=\"javascript:daftardosen('form,wewenang,dosen',document.form.dosen.value)\" >daftar Referensi Dosen</a>-->
					<div class=\"suggestionsBoxDosen\" id=\"suggestionsDosen\" style=\"display: none;\">
					   <div class=\"suggestionListDosen\" id=\"autoSuggestionsListDosen\"></div>
					</div>
				</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Jenjang Program Studi Pengampu</label>
				<div class=\"col-lg-6\">".createinputselect( "jenjang", $arrayjenjang, "{$d2['JENJATBKMK']}", "", " class=form-control m-input " )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Program Studi Pengampu</label>
				<div class=\"col-lg-6\">
					".createinputtext( "prodi", $d2[PRODITBKMK], " class=form-control m-input  size=5 id='inputStringProdiPT2' onkeyup=\"lookupProdiPT2(this.value);\" placeholder=\"Ketik Prodi Perguruan Tinggi...\"" )."
					<!--<a href=\"javascript:daftarprodipt('form,wewenang,prodi',\r\n\t\t\tdocument.form.prodi.value)\" >daftar Referensi Program Studi di P.T.</a>-->
					<div class=\"suggestionsBox\" id=\"suggestionsProdiPT2\" style=\"display: none;\">
								<div class=\"suggestionsProdiPT2\" id=\"autoSuggestionsProdiPT2\"></div>
					</div>
				</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Status Mata Kuliah</label>
				<div class=\"col-lg-6\">".createinputselect( "status", $arraystatuspt, "{$d2['STKMKTBKMK']}", "", " class=form-control m-input " )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Silabus</label>
				<div class=\"col-lg-6\">".createinputselect( "silabus", $arrayya2, "{$d2['SLBUSTBKMK']}", "", " class=form-control m-input " )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Satuan Acara Perkuliahan</label>
				<div class=\"col-lg-6\">".createinputselect( "satuan", $arrayya2, "{$d2['SAPPPTBKMK']}", "", " class=form-control m-input " )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Bahan Ajar</label>
				<div class=\"col-lg-6\">".createinputselect( "bahan", $arrayya2, "{$d2['BHNAJTBKMK']}", "", " class=form-control m-input " )."</div>
			</div>
			<div class=\"form-group m-form__group row\">
				<label class=\"col-lg-2 col-form-label\">Diktat</label>
				<div class=\"col-lg-6\">".createinputselect( "diktat", $arrayya2, "{$d2['DIKTTTBKMK']}", "", " class=form-control m-input " )."</div>
			</div>
			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
				<label class=\"col-lg-2 col-form-label\">Deskripsi</label>
				<div class=\"col-lg-6\">".createinputselect( "statusdeskripsi", $arrayya2, "{$d2['STATUSDESKRIPSI']}", "", " class=form-control m-input " )."</div>
			</div>";
?>
