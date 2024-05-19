<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi2 == "hapus" )
{
    cekhaktulis( $kodemenu );
    if ( $_GET['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Kurikulum", HAPUS_DATA );
    }
    else
    {
        $total = 0;
        $q = "SELECT COUNT(*) AS JML FROM trnlm WHERE KDKMKTRNLM='{$idhapus}' AND THSMSTRNLM='".( $tahunk - 1 )."{$semesterk}'\r\n     AND KDPSTTRNLM='{$prodiupdate}' \r\n     AND KDJENTRNLM='{$jenjangupdate}'\r\n    ";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $total += $d['JML'] + 0;
        $q = "SELECT COUNT(*) AS JML FROM trakd WHERE KDKMKTRAKD='{$idhapus}' AND THSMSTRAKD='".( $tahunk - 1 )."{$semesterk}'\r\n     AND KDPSTTRAKD='{$prodiupdate}' \r\n     AND KDJENTRAKD='{$jenjangupdate}'\r\n    ";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $total += $d['JML'] + 0;
        if ( $total <= 0 )
        {
            $q = "DELETE FROM tbkmk WHERE KDKMKTBKMK='{$idhapus}' AND THSMSTBKMK = '".( $tahunk - 1 )."{$semesterk}' AND KDPSTTBKMK='{$prodiupdate}' AND\r\n       KDJENTBKMK='{$jenjangupdate}'";
            mysqli_query($koneksi,$q);
            $ketlog = "Hapus Kurikulum  Mata Kuliah dengan ID={$idhapus}";
            buatlog( 20 );
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Kurikulum Mata Kuliah dengan ID = '{$idhapus}' berhasil dihapus";
            }
            else
            {
                $errmesg = "Data Kurikulum  Mata Kuliah dengan ID = '{$idhapus}' tidak berhasil dihapus";
            }
        }
        else
        {
            $errmesg = "Data Kurikulum tidak dapat dihapus. Ada data KRS dan Dosen Pengajar Mata Kuliah yg masih berkaitan.";
        }
        $aksi = "tampilkan";
    }
}
if ( $aksi == "tampilkan" )
{
	#echo "ll";exit();
    #include( "../strip_input_error.php" );
    $aksi = "";
	#echo "kkk";exit();
    include( "prosestampilmakul2.php" );
}
if ( $aksi == "" )
{
    $arraykelompokmk[''] = "Semua";
    #printjudulmenu( "Lihat Kurikulum Mata Kuliah" );
    printmesg( $errmesg );
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
                                <span class=\"caption-subject bold uppercase\"> Lihat Kurikulum Mata Kuliah </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
	 echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Lihat Kurikulum");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
							<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>";
	echo "					<div class=\"m-portlet__body\">		
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Tahun Akademik / Semester</label>\r\n    
								<div class=\"col-lg-6\">".createinputtahunajaransemester( 0, "tahunk", "semesterk",1 )."</div>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi</label>\r\n    
									<div class=\"col-lg-6\">
										<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
											foreach ( $arrayprodidep as $k => $v )
											{
												echo "<option value='{$k}'>{$v}</option>";
											}
    echo "								</select>
									</div>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Kode MK</label>\r\n    
									<div class=\"col-lg-6\">
										".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputStringKurikulum' onkeyup=\"lookupKurikulum(this.value,form.idprodi.value,form.tahunk.value,form.semesterk.value);\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
										<!--<a href=\"javascript:daftarmakul('form,wewenang,id',\r\n\t\t\tdocument.form.id.value)\" >daftar mata kuliah</a>-->
										<div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">
											<div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\"></div>
										</div>
									</div>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Nama MK</label>\r\n    
									<div class=\"col-lg-6\">".createinputtext( "nama", $nama, " class=form-control m-input  size=40" )."</div>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Semester Makul</label>\r\n    
									<div class=\"col-lg-6\">".createinputtext( "semester", $semester, " class=form-control m-input  size=2" )."</div>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">SKS</label>\r\n    
									<div class=\"col-lg-6\">".createinputtext( "sks", $sks, " class=form-control m-input  size=2" )."</div>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Jenis</label>\r\n    
									<div class=\"col-lg-6\">
										<select class=form-control m-input name=jenismakul>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
											foreach ( $arrayjenismakul as $k => $v )
											{
												echo "<option value='{$k}'>{$v}</option>";
											}
    echo "								</select>
									</div>
								</div>";
	echo "						<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">KELOMPOK KURIKULUM</label>\r\n    
									<div class=\"col-lg-6\">".createinputselect( "kelompokkurikulum", $arraykelompokkurikulum, "{$kelompokkurikulum}", "", " class=form-control m-input " )."</div>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">KELOMPOK MATA KULIAH</label>\r\n    
									<div class=\"col-lg-6\">".createinputselect( "kelompok", $arraykelompokmk, "{$kelompok}", "", " class=form-control m-input " )."</div>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
									<div class=\"col-lg-6\">
										<input type=submit value='Tampilkan' class=\"btn btn-brand\">
									</div>
								</div </form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->
					</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->
<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>";
}
?>
