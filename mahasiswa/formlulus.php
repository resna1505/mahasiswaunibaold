<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

cekhaktulis( $kodemenu );
$q = "SELECT * FROM trlsm WHERE NIMHSTRLSM='{$idupdate}' AND THSMSTRLSM='{$tahunsemester}'";
$h2 = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h2 ) )
{
    $d2 = sqlfetcharray( $h2 );
    $tmp = explode( "-", $d2[TGLLSTRLSM] );
    $dtk[thn] = $tmp[0];
    $dtk[tgl] = $tmp[2];
    $dtk[bln] = $tmp[1];
    $tmp = explode( "-", $d2[TGLRETRLSM] );
    $tglsk[thn] = $tmp[0];
    $tglsk[tgl] = $tmp[2];
    $tglsk[bln] = $tmp[1];
    $tmp = $d2[THSMSTRLSM];
    $tahun2 = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
    $semester2 = $tmp[4];
    $tmp = $d2[BLAWLTRLSM];
    $bulanawal = $tmp[0].$tmp[1];
    $tahunawal = $tmp[2].$tmp[3].$tmp[4].$tmp[5];
    $tmp = $d2[BLAKHTRLSM];
    $bulanakhir = $tmp[0].$tmp[1];
    $tahunakhir = $tmp[2].$tmp[3].$tmp[4].$tmp[5];
}
echo "		<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">Tahun/Semester Data</label>\r\n    
								<label class=\"col-form-label\">";
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
echo "\r\n\t\t\t\t\t\t</select>
			</label>
		</div>".( "
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Status Aktifitas Mahasiswa</label>\r\n    
			<label class=\"col-form-label\"> " )
				.createinputselect( "status", $arraystatusmahasiswa, $d2[STMHSTRLSM], "", " class=form-control m-input " )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Tanggal Keluar/Lulus/Mulai Cuti</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtanggalblank( "dtk", $dtk, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."</label>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">SKS Lulus</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "data[sks]", $d2[SKSTTTRLSM], " class=form-control m-input  size=3" )."</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">IPK Akhir</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "data[ipk]", $d2[NLIPKTRLSM], " class=form-control m-input  size=3" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Nilai Ujian Konfrehensif</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "data[simbol]", $d2[SIMBOL], " class=form-control m-input  size=3" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Nilai Rata-rata Ujian Tertulis (UJIAN AKHIR PROGRAM)</label>\r\n    
			<label class=\"col-form-label\" >
				Angka : ".createinputtext( "data[nilaiuaptulis]", $d2[NILAIUAPTULIS], " class=form-control m-input  size=3" )."
				Simbol : ".createinputtext( "data[simboluaptulis]", $d2[SIMBOLUAPTULIS], " class=form-control m-input  size=3" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Nilai Rata-rata Ujian Praktek (UJIAN AKHIR PROGRAM)</label>\r\n    
			<label class=\"col-form-label\">
				Angka : ".createinputtext( "data[nilaiuappraktek]", $d2[NILAIUAPPRAKTEK], " class=form-control m-input  size=3" )."
				Simbol : ".createinputtext( "data[simboluappraktek]", $d2[SIMBOLUAPPRAKTEK], " class=form-control m-input  size=3" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">No. SK Yudisium</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "data[sk]", $d2[NOSKRTRLSM], " class=form-control m-input  size=40" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Tanggal SK</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtanggalblank( "tglsk", $tglsk, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">No. Seri Ijazah</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "data[ijazah]", $d2[NOIJATRLSM], " class=form-control m-input  size=40" )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">No. Seri Transkrip</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "data[notranskrip]", $d2[NOTRANSKRIP], " class=form-control m-input  size=40" )." </b>
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Peminatan</label>\r\n    
			<label class=\"col-form-label\">
				".createinputselect( "data[peminatan]", $arraypeminatan, $d2[PEMINATAN], "", " class=form-control m-input " )."
			</label>
		</div>";
$q = "SELECT MAX(NOBLANKO) AS NOBLANKO FROM trlsm WHERE STMHSTRLSM='L'  ";
$hl = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $hl ) )
{
    $dl = sqlfetcharray( $hl );
    $noblanko = $dl[NOBLANKO];
}
echo "	<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">No. Blanko</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "data[noblanko]", $d2[NOBLANKO], " class=form-control m-input  size=40" )." No. Blanko terakhir : <b>{$noblanko}</b>
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Jalur Skripsi/Non</label>\r\n    
			<label class=\"col-form-label\">
				".createinputselect( "jalur", $arrayjalurskripsi, $d2[STLLSTRLSM], "", " class=form-control m-input " )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Skripsi Individu/Kelompok</label>\r\n    
			<label class=\"col-form-label\">
				".createinputselect( "individu", $arrayskripsiindividu, $d2[JNLLSTRLSM], "", " class=form-control m-input " )."
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Bulan/Tahun Awal Bimbingan</label>\r\n    
			<label class=\"col-form-label\">
				<select name=bulanawal class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
					$selected = "";
					foreach ( $arraybulan as $k => $v )
					{
						if ( $k + 1 == $bulanawal )
						{
							$selected = "selected";
						}
						echo "\r\n\t\t\t\t\t\t\t<option value='".( $k + 1 )."' {$cek} {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
						$selected = "";
					}
echo "			</select>";
$waktu = getdate( );
echo "			<select name=tahunawal class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
					$selected = "";
					$i = 1901;
					while ( $i <= $waktu[year] + 5 )
					{
						if ( $i == $tahunawal )
						{
							$selected = "selected";
						}
						echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>{$i}</option>\r\n\t\t\t\t\t\t\t";
						$selected = "";
						++$i;
					}
echo "			</select>
			</label>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">Bulan/Tahun Akhir Bimbingan</label>\r\n    
			<label class=\"col-form-label\">
				<select name=bulanakhir class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
					$selected = "";
					foreach ( $arraybulan as $k => $v )
					{
						if ( $k + 1 == $bulanakhir )
						{
							$selected = "selected";
						}
						echo "\r\n\t\t\t\t\t\t\t<option value='".( $k + 1 )."' {$cek} {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
						$selected = "";
					}
echo "			</select>";
$waktu = getdate( );
echo "			<select name=tahunakhir class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
					$selected = "";
					$i = 1901;
					while ( $i <= $waktu[year] + 5 )
					{
						if ( $i == $tahunakhir )
						{
							$selected = "selected";
						}
						echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>{$i}</option>\r\n\t\t\t\t\t\t\t";
						$selected = "";
						++$i;
					}
echo "			</select>
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">NIDN Dosen Pembimbing 1</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "dosen1", $d2[NODS1TRLSM], " class=form-control m-input  size=10" )."
				<a href=\"javascript:daftardos('form,wewenang,dosen1',document.form.dosen1.value)\" >daftar NIDN Dosen DIKTI</a>::
				<a href=\"javascript:daftardosen('form,wewenang,dosen1',document.form.dosen1.value)\" >daftar Dosen Lokal</a>
			</label>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">NIDN Dosen Pembimbing 2</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "dosen2", $d2[NODS2TRLSM], " class=form-control m-input  size=10" )."
				<a href=\"javascript:daftardos('form,wewenang,dosen2',document.form.dosen2.value)\" >daftar NIDN Dosen DIKTI</a>::
				<a href=\"javascript:daftardosen('form,wewenang,dosen2',document.form.dosen2.value)\" >daftar Dosen Lokal</a>
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">NIDN Dosen Pembimbing 3</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "dosen3", $d2[NODS3TRLSM], " class=form-control m-input  size=10" )."
				<a href=\"javascript:daftardos('form,wewenang,dosen3',document.form.dosen3.value)\" >daftar NIDN Dosen DIKTI</a>::
				<a href=\"javascript:daftardosen('form,wewenang,dosen3',document.form.dosen3.value)\" >daftar Dosen Lokal</a>
			</label>
		</div>
		<div class=\"form-group m-form__group row\"  style=\"background-color:#d8e2f7;\">
			<label class=\"col-lg-2 col-form-label\">NIDN Dosen Pembimbing 4</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "dosen4", $d2[NODS4TRLSM], " class=form-control m-input  size=10" )."
				<a href=\"javascript:daftardos('form,wewenang,dosen4',document.form.dosen4.value)\" >daftar NIDN Dosen DIKTI</a>::
				<a href=\"javascript:daftardosen('form,wewenang,dosen4',document.form.dosen4.value)\" >daftar Dosen Lokal</a>
			</label>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\" >NIDN Dosen Pembimbing 5</label>\r\n    
			<label class=\"col-form-label\">
				".createinputtext( "dosen5", $d2[NODS5TRLSM], " class=form-control m-input  size=10" )."
				<a href=\"javascript:daftardos('form,wewenang,dosen5',document.form.dosen5.value)\" >daftar NIDN Dosen DIKTI</a>::
				<a href=\"javascript:daftardosen('form,wewenang,dosen5',document.form.dosen5.value)\" >daftar Dosen Lokal</a>
			</label>
		</div>";
?>
