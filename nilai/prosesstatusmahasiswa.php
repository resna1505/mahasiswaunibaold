<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
periksaroot( );
cekhaktulis( $kodemenu );
$seed = mt_srand( make_seed( ) );
$konversisemua = 0;
@$konf = @file( "konfig" );
if ( is_array( $konf ) )
{
    if ( trim( $konf[0] ) == "0" )
    {
        $konversisemua = 0;
    }
    else
    {
        $konversisemua = 1;
    }
}
if ( $aksi == "Tampilkan" )
{
	#echo "aaa";exit();
    include( "prosesstatusmahasiswa2.php" );
}
if ( $aksi == "" )
{
	#echo "jjj";
    $token = md5( uniqid( rand( ), true ) );
    $_SESSION['token'] = $token;
    #printjudulmenu( "Proses Nilai IPS/IPK Mahasiswa untuk Semester Tertentu (Disimpan di TRAKM)" );
    
    /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Proses Nilai IPS/IPK Mahasiswa untuk Semester Tertentu (Disimpan di TRAKM) </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
	 echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->";
		echo "					<div class='portlet-title'>";
									printmesg( $errmesg );
									printmesg("Proses Status Mahasiswa");										
		echo "					</div>	
							<div class=\"m-portlet\">
								<!--begin::Form-->";
		echo "					<form name=form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
									<input type=hidden name=pilihan value='{$pilihan}'>
									<input type=hidden name=aksi value='tampilkan'>
									<input type=hidden name=sessid value='{$token}'>
									<div class=\"m-portlet__body\">";
    if ( $jenisusers != 2 )
    {
        echo "							<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
											<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
											<div class=\"col-lg-6\">
												<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Pilih Prodi</option>";
													foreach ( $arrayprodidep as $k => $v )
													{
														echo "<option value='{$k}'>{$v}</option>";
													}
        echo "									</select>
											</div>
										</div>";
    }
    
    if ( $jenisusers != 2 )
    {
        echo "							<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
											<div class=\"col-lg-6\">";
        $waktu = getdate( );
        echo "									<select name=angkatan class=form-control m-input><option value=''>Pilih Angkatan</option>";
													$i = 1900;
													while ( $i <= $waktu[year] + 5 )
													{
														echo "<option value='{$i}' {$cek}>{$i}</option>";
														++$i;
													}
        echo "									</select>
											</div>
										</div>
										
										
										<div class=\"form-group m-form__group row\"  style=\"background-color:#b0c6f1;\">
											<label class=\"col-lg-2 col-form-label\">Status</label>\r\n    
											<div class=\"col-lg-6\">
												<select class=form-control m-input name=status>
													<option value='A'>Aktif</option>";
        echo "									</select>
											</div>
										</div>";
    }
    echo "								<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Tahun Akademik / Semester</label>\r\n    
											<div class=\"col-lg-6\">".createinputtahunajaransemester( 0 )." </div>
										</div>
										<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
											<label class=\"col-lg-2 col-form-label\">Tanggal Proses</label>\r\n    
											<label class=\"col-form-label\">".createinputtanggal("tgl_proses","","class=form-control m-input style=\"width:auto;display:inline-block;\"")."</label>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Status Simpan</label>\r\n    
											<div class=\"col-lg-6\">
												<div class=\"m-checkbox-list\">
													<label class=\"m-checkbox\">
														<input type=checkbox class=form-control m-input name=simpanstatus value='1'  >Simpan Status Mahasiswa langsung (jangan dipilih jika Anda hanya ingin cek data terlebih dahulu)
														<span></span>
													</label>
												</div>
											</div>
										</div>
										";
    /*if ( $jenisusers != 2 )
    {
    echo "								<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
											<label class=\"col-lg-2 col-form-label\">Data Per Halaman</label>  
											<div class=\"col-lg-6\">
												<input type=text class=form-control m-input name=dataperhalaman value='{$maxdata}' size=2> Sebaiknya nilainya diperkecil karena pemrosesan akan memakan waktu relatif lama
											</div>
										</div>";
    }*/
    echo "								<div class=\"form-group m-form__group row\" style=\"background-color:#b0c6f1;\">
											<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
											<div class=\"col-lg-6\">
												<input type=submit name=aksi value='Tampilkan' class=\"btn btn-brand\">
											</div>
										</div>
										</form>
									</div>
								</div>
							</div>
						</div>
					</div>";
}
?>
