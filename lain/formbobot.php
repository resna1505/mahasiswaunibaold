<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Bobot Nilai", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan Data", $tahun, $semester );
        $vld[] = cekvaliditaskodeprodi( "Kode Prodi", $kodeps );
        $vld[] = cekvaliditasnilaihuruf( "Nilai Huruf", $huruf, false );
        $vld[] = cekvaliditasnilaibobot( "Bobot Nilai", $bobot, false );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
        }
        else
        {
            if ( $idupdate == "" )
            {
                $q = "INSERT INTO tbbnl \r\n    (THSMSTBBNL ,KDPTITBBNL ,KDJENTBBNL ,KDPSTTBBNL  , NLAKHTBBNL,BOBOTTBBNL,SYARAT)\r\n    VALUES\r\n    ('{$tahun}{$semester}','{$kodept}','{$kodejenjang}','{$kodeps}','{$huruf}','{$bobot}' ,'{$syarat}'\r\n     )";
                mysqli_query($koneksi,$q);
                $idupdate = $huruf;
            }
            else
            {
                $q = "\r\n      UPDATE tbbnl SET\r\n \r\n\r\n      NLAKHTBBNL=  '{$huruf}',\r\n      BOBOTTBBNL=  '{$bobot}' ,\r\n      SYARAT=  '{$syarat}' \r\n      \r\n      WHERE\r\n       KDPTITBBNL='{$kodept}' AND\r\n        KDPSTTBBNL='{$kodeps}' AND\r\n        KDJENTBBNL='{$kodejenjang}' AND\r\n        THSMSTBBNL='{$tahun}{$semester}' AND\r\n        NLAKHTBBNL=  '{$idupdate}' \r\n    ";
                mysqli_query($koneksi,$q);
            }
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $idupdate = $huruf;
                $errmesg = "Data Bobot Nilai berhasil disimpan";
            }
        }
    }
}
$q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $kodept = $d[KDPTIMSPST];
    $kodejenjang = $d[KDJENMSPST];
    $kodeps = $d[KDPSTMSPST];
}
if ( $aksix == 1 )
{
    $idupdate = "";
}
$q = "SELECT * FROM tbbnl  \r\nWHERE\r\n       KDPTITBBNL='{$kodept}' AND\r\n        KDPSTTBBNL='{$kodeps}' AND\r\n        KDJENTBBNL='{$kodejenjang}' AND\r\n        THSMSTBBNL='{$tahun}{$semester}' AND\r\n        NLAKHTBBNL=  '{$idupdate}' \r\n";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $ada = 1;
    $d = sqlfetcharray( $h );
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
#printmesg( $errmesg );
echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Edit Konversi Nilai Umum Per Semester Per Prodi");
				echo "	</div>";
				
				echo "	<div class='portlet-title'>";
								printmesg("Entri Data Baru");										
		echo "			</div>	
						<div class=\"m-portlet\">										
										<div class=\"portlet-body form\">";
echo "										<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
											<input type=hidden name=pilihan value='{$pilihan}'>
											<input type=hidden name=tab value='{$tab}'>
											<input type=hidden name=idprodi value='{$idprodi}'>
											<input type=hidden name=kodept value='{$kodept}'>
											<input type=hidden name=kodeps value='{$kodeps}'>
											<input type=hidden name=kodejenjang value='{$kodejenjang}'>
											<input type=hidden name=tahun value='{$tahun}'>
											<input type=hidden name=semester value='{$semester}'>
											<input type=hidden name=idupdate value='{$idupdate}'>
											<input type=hidden name=sessid value='{$_SESSION['token']}'>
											<div class=\"m-portlet__body\">		
												<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Tahun Semester Pelaporan Data</label>\r\n    
													<div class=\"col-lg-6\">".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</div>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Jurusan/Prodi</label>\r\n    
													<div class=\"col-lg-6\">".$arrayprodidep[$idprodi]."</div>
												</div>
												<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Nilai Huruf</label>\r\n    
													<div class=\"col-lg-6\"><input type=text size=2 name=huruf value='{$d['NLAKHTBBNL']}'></div>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Bobot Nilai</label>\r\n    
													<div class=\"col-lg-6\"><input type=text size=4 name=bobot value='{$d['BOBOTTBBNL']}'> </div>
												</div>
												<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">Syarat Angka</label>\r\n    
													<div class=\"col-lg-6\">>= <input type=text size=4 name=syarat value='{$d['SYARAT']}'> </div>
												</div>
												<div class=\"form-group m-form__group row\">
													<label class=\"col-lg-2 col-form-label\">Setelah disimpan</label>\r\n    
													<div class=\"col-lg-6\"><input type=checkbox  name=aksix value='1' checked>kembali ke form Tambah </div>
												</div>
												<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
													<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
													<div class=\"col-lg-6\">
														<input type=submit value=Simpan name=aksi class=\"btn btn-brand\">
														<input type=reset value=Reset  class=\"btn btn-secondary\">
													</div>
												</div>
											</div>
											</form>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
					";
?>
