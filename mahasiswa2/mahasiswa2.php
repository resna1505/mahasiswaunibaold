<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "" )
{
    $q = "SELECT * FROM msmhs WHERE NIMHSMSMHS='{$idupdate}'";
    $h = mysqli_query($koneksi,$q);
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
echo "	
		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">Semester Awal Terdaftar Sebagai Mahasiswa</label>
			<label class=\"col-form-label\">
				{$tahun}/".( $tahun + 1 )." ".$arraysemester[$semester]."
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Batas Studi</label>\r\n    
			<label class=\"col-form-label\">
				{$tahun2}/".( $tahun2 + 1 )." ".$arraysemester[$semester2]."
			</label>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">Kode Propinsi Asal Pendidikan Terakhir</label>\r\n    
			<div class=\"col-lg-6\">
				{$d2['ASSMAMSMHS']}
			</div>
		</div>
	<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">Status Awal Mahasiswa Baru</label>
		<label class=\"col-form-label\">
			".$arraystatusmhsbaru[$d2[STPIDMSMHS]]."
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
			$stylesks = "style='background-color:#f7f8fa'";
		}
echo "	<div class=\"form-group m-form__group row\" {$stylesks}>
			<label class=\"col-lg-2 col-form-label\">Jumlah SKS Diakui u/ Mhs Baru/Pindahan</label>
			<label class=\"col-form-label\">
				{$d2['SKSDIMSMHS']}  {$statussks}
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">NIM Asal dari PT Sebelumnya (Pindahan)</label>\r\n    
			<label class=\"col-form-label\">
				{$d2['ASNIMMSMHS']}
			</label>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">Kode PT Sebelumnya (Pindahan)</label>\r\n    
			<div class=\"col-lg-6\">
				{$d2['ASPTIMSMHS']}
			</div>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Jenjang PT Sebelumnya (Pindahan)</label>\r\n    
			<label class=\"col-form-label\">
				".$arrayjenjang[$d2[ASJENMSMHS]]."
			</label>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">Kode Program Studi Sebelumnya (Pindahan)</label>\r\n    
			<div class=\"col-lg-6\">
				{$d2['ASPSTMSMHS']}
			</div>
		</div>";
echo "	<div class='portlet-title'>";
			printmesg("{$JUDULKHUSUSS3}");
echo "	</div>";
echo "	<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Kode Biaya Studi</label>\r\n    
			<label class=\"col-form-label\">
				{$d2['BISTUMSMHS']}
			</label>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">Kode Pekerjaan</label>\r\n    
			<label class=\"col-form-label\">
				{$d2['BISTUMSMHS']}
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Nama Tempat Bekerja, bila bukan Dosen</label>\r\n    
			<label class=\"col-form-label\">
				{$d2['PEKSBMSMHS']}
			</label>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">Kode PT Tempat Bekerja, bila Dosen</label>\r\n    
			<label class=\"col-form-label\">
				{$d2['PTPEKMSMHS']}
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Kode PS Tempat Bekerja, bila Dosen</label>\r\n    
			<label class=\"col-form-label\">
				{$d2['PSPEKMSMHS']}
			</label>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">NIDN Promotor</label>\r\n    
			<div class=\"col-lg-6\">
				{$d2['NOPRMMSMHS']}
			</div>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">NIDN Ko-Promotor #1</label>\r\n    
			<div class=\"col-lg-6\">
				{$d2['NOKP1MSMHS']}
			</div>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">NIDN Ko-Promotor #2</label>\r\n    
			<div class=\"col-lg-6\">
				{$d2['NOKP2MSMHS']}
			</div>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">NIDN Ko-Promotor #3</label>\r\n    
			<div class=\"col-lg-6\">
				{$d2['NOKP3MSMHS']}
			</div>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">NIDN Ko-Promotor #4</label>\r\n    
			<div class=\"col-lg-6\">
				{$d2['NOKP4MSMHS']}
			</div>
		</div>";
?>
