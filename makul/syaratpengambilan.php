<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$idprodimakul = getfield( "IDX", "mspst", " WHERE KDPSTMSPST='{$prodiupdate}' AND KDJENMSPST='{$jenjangupdate}'" );
printjudulmenukecil( "<b>Syarat Pengambilan Mata Kuliah</b>" );
$thnsyarat = substr( $tahunsemester, 0, 4 );
$semsyarat = substr( $tahunsemester, 4, 1 );
if ( $aksi3 == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Syarat Pengambilan MK", SIMPAN_DATA );
    }
    else
    {
        $vld[] = cekvaliditaskodemakul( "Kode Makul", $idmakul );
        $vld[] = cekvaliditasnilaihuruf( "Nilai Minimum Mata Kuliah", $nilaimakul );
        $vld[] = cekvaliditasnilaibobot( "Bobot Minimum Mata Kuliah", $bobotmakul );
        $vld[] = cekvaliditaskode( "Logic", $logic, 3 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $_SESSION['token'] );
        }
        else if ( trim( $idmakul ) == "" )
        {
            $errmesg = "ID Makul harus diisi!";
        }
        else if ( getfieldfromtabel( $idmakul, "ID", "makul" ) == "" )
        {
            $errmesg = "ID Makul {$idmakul} tidak ada di daftar Makul!";
        }
        else
        {
            $q = "INSERT INTO syaratpengambilanmk\r\n    (IDMAKUL,IDSYARAT,TAHUN,SEMESTER,NILAI,BOBOT,LOGIC)\r\n    VALUES\r\n    ('{$idupdate}','{$idmakul}','".( $thnsyarat + 1 )."','{$semsyarat}','{$nilaimakul}','{$bobotmakul}','{$logic}')";
            mysqli_query($koneksi,$q);
            if ( sqlaffectedrows( $koneksi ) <= 0 )
            {
                $q = "UPDATE syaratpengambilanmk\r\n      SET\r\n      NILAI='{$nilaimakul}' ,\r\n      BOBOT='{$bobotmakul}',\r\n       LOGIC='{$logic}'\r\n       WHERE\r\n      IDMAKUL='{$idupdate}' AND\r\n      IDSYARAT='{$idmakul}' AND\r\n      TAHUN='".( $thnsyarat + 1 )."' AND\r\n      SEMESTER='{$semsyarat}'\r\n      ";
                mysqli_query($koneksi,$q);
                $q = "\r\n        UPDATE syaratpengambilanmk\r\n        SET      \r\n        LOGIC='{$logic}'\r\n        WHERE\r\n        IDMAKUL='{$idupdate}' AND\r\n         TAHUN='".( $thnsyarat + 1 )."' AND\r\n        SEMESTER='{$semsyarat}'\r\n      ";
                mysqli_query($koneksi,$q);
            }
            else
            {
                printmesg( "Data syarat berhasil disimpan" );
                $q = "\r\n        UPDATE syaratpengambilanmk\r\n        SET      \r\n        LOGIC='{$logic}'\r\n        WHERE\r\n        IDMAKUL='{$idupdate}' AND\r\n         TAHUN='".( $thnsyarat + 1 )."' AND\r\n        SEMESTER='{$semsyarat}'\r\n      ";
                mysqli_query($koneksi,$q);
            }
        }
    }
}
if ( $aksi3 == "hapus" )
{
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Syarat Pengambilan Makul", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $q = "DELETE FROM  syaratpengambilanmk\r\n      WHERE\r\n      IDMAKUL='{$idupdate}' AND\r\n      IDSYARAT='{$idsyarat}' AND\r\n      TAHUN='".( $thnsyarat + 1 )."' AND\r\n      SEMESTER='{$semsyarat}'\r\n      ";
        mysqli_query($koneksi,$q);
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
echo "\r\n  \r\n    Prodi Penyelenggara : <b>".$arrayprodidep[$idprodimakul]."</b> <br>\r\n    Tahun Akademik : ".$arraysemester[$semsyarat]." <b>{$thnsyarat}/".( $thnsyarat + 1 )."</b>\r\n  <br><br>\r\n  <form name=form method=post action=index.php>\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n    <input type=hidden name=aksi value='{$aksi}'>\r\n    <input type=hidden name=tab value='{$tab}'>\r\n    <input type=hidden name=aksi2 value='{$aksi2}'>\r\n    <input type=hidden name=idupdate value='{$idupdate}'>\r\n    <input type=hidden name=tahunsemester value='{$tahunsemester}'>\r\n    <input type=hidden name=prodiupdate value='{$prodiupdate}'>\r\n    <input type=hidden name=jenjangupdate value='{$jenjangupdate}'>\r\n\t<input type=hidden name=sessid value='{$token}'>
		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">ID Mata Kuliah yg harus diambil</label>\r\n    
			<div class=\"col-lg-6\">
				<input type=text name=idmakul size=20 class=form-control m-input id='inputStringMakul' onkeyup=\"lookupMakul(this.value,'');\" placeholder=\"Ketik Kode / Nama Makul...\"> 
				<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\" >daftar mata kuliah</a>-->
				<div class=\"suggestions\" id=\"suggestionsMakul\" style=\"display: none;\">
					<div class=\"suggestionListMakul\" id=\"autoSuggestionsListMakul\"></div>
				</div>
			</div>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Nilai Minimum Mata Kuliah</label> 
			<div class=\"col-lg-6\"><input type=text name=nilaimakul size=2 value='C' class=form-control m-input></div>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">Bobot Minimum Mata Kuliah</label> 
			<div class=\"col-lg-6\"><input type=text name=bobotmakul size=2 value='2' class=form-control m-input></div>
		</div>
		<div class=\"form-group m-form__group row\">
			<label class=\"col-lg-2 col-form-label\">Logic</label> 
			<div class=\"col-lg-6\"><input type=radio name=logic value='AND' checked> AND <input type=radio name=logic value='OR' > OR <br> Catatan: Logika yang dipakai (AND atau OR) berlaku hanya salah satu untuk SEMUA mata kuliah syarat yg hendak dipakai.</div>
		</div>
		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
										<input type=\"submit\" class=\"btn btn-brand\" name=aksi3 value=Simpan></input>
										
								</div>
							</div>
		</div>						
				</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->		";

$q = "SELECT syaratpengambilanmk.* ,makul.NAMA,\r\nsyaratpengambilanmk.NILAI,\r\nsyaratpengambilanmk.BOBOT\r\nFROM syaratpengambilanmk LEFT JOIN makul ON makul.ID=syaratpengambilanmk.IDSYARAT \r\n\r\nWHERE\r\n IDMAKUL='{$idupdate}'\r\nAND syaratpengambilanmk.TAHUN='".( $thnsyarat + 1 )."'\r\nAND syaratpengambilanmk.SEMESTER='{$semsyarat}'\r\n";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    #echo "\r\n  <br>\r\n  <table class=\"table table-striped table-bordered table-hover\">\r\n    <tr class=juduldata align=center>\r\n      <td>ID Mata Kuliah</td>\r\n      <td>Nama Mata Kuliah</td>\r\n      <td>Nilai Minimum</td>\r\n      <td>Bobot Minimum</td>\r\n      <td>Logic</td>\r\n      <td>Hapus</td>    \r\n    </tr>\r\n  ";
    echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								<tr class=juduldata align=center>\r\n      <td>ID Mata Kuliah</td>\r\n      <td>Nama Mata Kuliah</td>\r\n      <td>Nilai Minimum</td>\r\n      <td>Bobot Minimum</td>\r\n      <td>Logic</td>\r\n      <td>Hapus</td>    \r\n    </tr>";
	echo "					</thead>
							<tbody>";	
	$i = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        ++$i;
        $kelas = kelas( $i );
        echo "\r\n    <tr {$kelas}>\r\n      <td>{$d['IDSYARAT']}</td>\r\n      <td>{$d['NAMA']}</td>\r\n      <td align=center>{$d['NILAI']}</td>\r\n      <td align=center>{$d['BOBOT']}</td>\r\n      <td align=center>{$d['LOGIC']}</td>\r\n      <td align=center><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&aksi2={$aksi2}&prodiupdate={$prodiupdate}&jenjangupdate={$jenjangupdate}&idupdate={$idupdate}&idsyarat={$d['IDSYARAT']}&tahunsemester={$tahunsemester}&aksi3=hapus&sessid={$token}'\r\n      onClick=\"return confirm('Hapus Syarat Mata Kuliah?')\">hapus</a></td>\r\n    </tr>\r\n     ";
    }
    echo "					</tbody>
						</table>
					</div>
				</div>
			</div>";
}
else
{
    printmesg( "Tidak ada syarat untuk pengambilan mata kuliah ini." );
}
?>
