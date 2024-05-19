<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenukecil( "<b>Syarat Pengambilan Mata Kuliah</b>" );
$thnsyarat = substr( $tahunsemester, 0, 4 );
$semsyarat = substr( $tahunsemester, 4, 1 );
if ( $aksi3 == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Syarat Pengambilan MK SP", SIMPAN_DATA );
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
        }
        else
        {
            unset( $_SESSION['token'] );
            $q = "INSERT INTO syaratpengambilanmksp\r\n    (IDMAKUL,IDSYARAT,TAHUN,SEMESTER,NILAI,BOBOT,LOGIC)\r\n    VALUES\r\n    ('{$idupdate}','{$idmakul}','".( $thnsyarat + 1 )."','{$semsyarat}','{$nilaimakul}','{$bobotmakul}','{$logic}')";
            mysqli_query($koneksi,$q);
            if ( sqlaffectedrows( $koneksi ) <= 0 )
            {
                $q = "UPDATE syaratpengambilanmksp\r\n      SET\r\n      NILAI='{$nilaimakul}' ,\r\n      BOBOT='{$bobotmakul}',\r\n       LOGIC='{$logic}'\r\n      WHERE\r\n      IDMAKUL='{$idupdate}' AND\r\n      IDSYARAT='{$idmakul}' AND\r\n      TAHUN='".( $thnsyarat + 1 )."' AND\r\n      SEMESTER='{$semsyarat}'\r\n      ";
                mysqli_query($koneksi,$q);
                $q = "\r\n        UPDATE syaratpengambilanmksp\r\n        SET      \r\n        LOGIC='{$logic}'\r\n        WHERE\r\n        IDMAKUL='{$idupdate}' AND\r\n         TAHUN='".( $thnsyarat + 1 )."' AND\r\n        SEMESTER='{$semsyarat}'\r\n      ";
                mysqli_query($koneksi,$q);
            }
            else
            {
                printmesg( "Data syarat berhasil disimpan" );
                $q = "\r\n        UPDATE syaratpengambilanmksp\r\n        SET      \r\n        LOGIC='{$logic}'\r\n        WHERE\r\n        IDMAKUL='{$idupdate}' AND\r\n         TAHUN='".( $thnsyarat + 1 )."' AND\r\n        SEMESTER='{$semsyarat}'\r\n      ";
                mysqli_query($koneksi,$q);
            }
        }
    }
}
if ( $aksi3 == "hapus" )
{
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Data Syarat Pengambilanmk MK SP", HAPUS_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $q = "DELETE FROM  syaratpengambilanmksp\r\n      WHERE\r\n      IDMAKUL='{$idupdate}' AND\r\n      IDSYARAT='{$idsyarat}' AND\r\n      TAHUN='".( $thnsyarat + 1 )."' AND\r\n      SEMESTER='{$semsyarat}'\r\n      ";
        mysqli_query($koneksi,$q);
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
#echo "\r\n  Tahun Akademik : ".$arraysemester[$semsyarat]." {$thnsyarat}/".( $thnsyarat + 1 )."\r\n  <br><br>\r\n  <form name=form method=post action=index.php>\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n    <input type=hidden name=aksi value='{$aksi}'>\r\n\t<input type=hidden name=sessid value='{$token}'>\r\n    <input type=hidden name=tab value='{$tab}'>\r\n    <input type=hidden name=aksi2 value='{$aksi2}'>\r\n    <input type=hidden name=idupdate value='{$idupdate}'>\r\n    <input type=hidden name=tahunsemester value='{$tahunsemester}'>\r\n    <input type=hidden name=prodiupdate value='{$prodiupdate}'>\r\n    <input type=hidden name=jenjangupdate value='{$jenjangupdate}'>\r\n \r\n\r\n  <table class=form>\r\n    <tr>\r\n      <td width=150>ID Mata Kuliah yg harus diambil</td>\r\n      <td><input type=text name=idmakul size=20>\r\n      <a \r\n\t\t\thref=\"javascript:daftarmakul('form,wewenang,idmakul',\r\n\t\t\tdocument.form.idmakul.value)\" >\r\n\t\t\tdaftar mata kuliah\r\n\t\t\t</a>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td >Nilai Minimum Mata Kuliah</td>\r\n      <td><input type=text name=nilaimakul size=2 value='C'>\r\n      \t\t\t\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td >Bobot Minimum Mata Kuliah</td>\r\n      <td><input type=text name=bobotmakul size=2 value='2'>\r\n      \t\t\t\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td >Logic</td>\r\n      <td>\r\n      <input type=radio name=logic value='AND' checked> AND\r\n      <input type=radio name=logic value='OR' > OR\r\n      <br>\r\n      Catatan: Logika yang dipakai (AND atau OR) berlaku hanya salah satu untuk SEMUA mata kuliah syarat yg hendak dipakai.\t\t\t\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td ></td>\r\n      <td><input type=submit   value='Simpan' name=aksi3>\r\n      \t\t\t\r\n      </td>\r\n    </tr>  </table>\r\n  </form>\r\n\r\n";
echo " Tahun Akademik : ".$arraysemester[$semsyarat]." <b>{$thnsyarat}/".( $thnsyarat + 1 )."</b>\r\n  <br><br>\r\n  <form name=form method=post action=index.php>\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n    <input type=hidden name=aksi value='{$aksi}'>\r\n    <input type=hidden name=tab value='{$tab}'>\r\n    <input type=hidden name=aksi2 value='{$aksi2}'>\r\n    <input type=hidden name=idupdate value='{$idupdate}'>\r\n    <input type=hidden name=tahunsemester value='{$tahunsemester}'>\r\n    <input type=hidden name=prodiupdate value='{$prodiupdate}'>\r\n    <input type=hidden name=jenjangupdate value='{$jenjangupdate}'>\r\n\t<input type=hidden name=sessid value='{$token}'>
		<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
			<label class=\"col-lg-2 col-form-label\">ID Mata Kuliah yg harus diambil</label>\r\n    
			<div class=\"col-lg-6\">
				<input type=text name=idmakul size=20 class=form-control m-input id='inputStringMakul' onkeyup=\"lookupMakul(this.value,'');\" placeholder=\"Ketik Kode / Nama Makul...\" value='{$idupdate}'> 
				<!--<a href=\"javascript:daftarmakul('form,wewenang,idmakul',document.form.idmakul.value)\" >daftar mata kuliah</a></div>-->
				<div class=\"suggestionsBoxMakul\" id=\"suggestionsMakul\" style=\"display: none;\">
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
$q = "SELECT syaratpengambilanmksp.* ,makul.NAMA,\r\nsyaratpengambilanmksp.NILAI,\r\nsyaratpengambilanmksp.BOBOT\r\nFROM syaratpengambilanmksp LEFT JOIN makul ON makul.ID=syaratpengambilanmksp.IDSYARAT \r\nWHERE\r\nIDMAKUL='{$idupdate}'\r\nAND syaratpengambilanmksp.TAHUN='".( $thnsyarat + 1 )."'\r\nAND syaratpengambilanmksp.SEMESTER='{$semsyarat}'\r\n";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    #echo "\r\n  <br>\r\n  <table class=form>\r\n    <tr class=juduldata align=center>\r\n      <td>ID Mata Kuliah</td>\r\n      <td>Nama Mata Kuliah</td>\r\n      <td>Nilai Minimum</td>\r\n      <td>Bobot Minimum</td>\r\n      <td>Hapus</td>    \r\n    </tr>\r\n  ";
    echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>
								<tr class=juduldata align=center>\r\n      <td>ID Mata Kuliah</td>\r\n      <td>Nama Mata Kuliah</td>\r\n      <td>Nilai Minimum</td>\r\n      <td>Bobot Minimum</td>\r\n      <td>Hapus</td>    \r\n    </tr>\r\n  ";
	echo "					</thead>
							<tbody>";
	$i = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        ++$i;
        $kelas = kelas( $i );
        echo "\r\n    <tr {$kelas}>\r\n      <td>{$d['IDSYARAT']}</td>\r\n      <td>{$d['NAMA']}</td>\r\n      <td align=center>{$d['NILAI']}</td>\r\n      <td align=center>{$d['BOBOT']}</td>\r\n      <td align=center><a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&aksi2={$aksi2}&prodiupdate={$prodiupdate}&jenjangupdate={$jenjangupdate}&idupdate={$idupdate}&idsyarat={$d['IDSYARAT']}&tahunsemester={$tahunsemester}&aksi3=hapus&sessid={$token}'\r\n      onClick=\"return confirm('Hapus Syarat Mata Kuliah?')\">hapus</a></td>\r\n    </tr>\r\n     ";
    }
	echo "					</tbody>
						</table>
					</div>
				</div>
			</div>";
    #echo "</table>";
}
else
{
    printmesg( "Tidak ada syarat untuk pengambilan mata kuliah ini." );
}
?>
