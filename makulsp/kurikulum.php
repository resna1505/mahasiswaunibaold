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
        $errmesg = token_err_mesg( "Kurikulum SP", HAPUS_DATA );
    }
    else
    {
        $total = 0;
        $q = "SELECT COUNT(*) AS JML FROM trnlmsp WHERE KDKMKTRNLM='{$idhapus}' AND THSMSTRNLM='".( $tahunk - 1 )."{$semesterk}'\r\n     AND KDPSTTRNLM='{$prodiupdate}' \r\n     AND KDJENTRNLM='{$jenjangupdate}'\r\n    ";
        $h = mysqli_query($koneksi,$q);
        $d = sqlfetcharray( $h );
        $total += $d[JML] + 0;
        if ( $total <= 0 )
        {
            $q = "DELETE FROM tbkmksp WHERE KDKMKTBKMK='{$idhapus}' AND THSMSTBKMK = '".( $tahunk - 1 )."{$semesterk}' AND KDPSTTBKMK='{$prodiupdate}' AND\r\n         KDJENTBKMK='{$jenjangupdate}'";
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
    $aksi = " ";
    include( "prosestampilmakul2.php" );
}
if ( $aksi == "" )
{
    $arraykelompokmk[''] = "Semua";
    printmesg( $errmesg );
     echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Lihat Kurikulum Mata Kuliah SP");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
		echo "				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
							<input type=hidden name=pilihan value='{$pilihan}'><input type=hidden name=aksi value='tampilkan'>
							<div class=\"m-portlet__body\">		
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Semester Tahun Akademik</label>\r\n    
									<label class=\"col-form-label\">";
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\r\n            <select name=semesterk class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
    foreach ( $arraysemester as $k => $v )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t</select>\t\t\t\t\t\r\n\t\t\t\t\t\r\n\t\t\t\t\t\t<select name=tahunk class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
    $i = 1900;
    while ( $i <= $waktu[year] + 5 )
    {
        $selected = "";
        if ( $i == $waktu[year] )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option {$selected} value='{$i}' {$cek}>".( $i - 1 )."/{$i}</option>\r\n\t\t\t\t\t\t\t";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Jurusan / Program Studi</label>\r\n    
									<label class=\"col-form-label\">
										<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
											foreach ( $arrayprodidep as $k => $v )
											{
												echo "<option value='{$k}'>{$v}</option>";
											}
    echo "								</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Kode MK</label>\r\n    
									<div class=\"col-lg-6\">
										".createinputtext( "id", $id, " class=form-control m-input  size=20 id='inputStringKurikulum' onkeyup=\"lookupKurikulumSP(this.value,form.idprodi.value,form.tahunk.value,form.semesterk.value);\" placeholder=\"Ketik Kode / Nama Makul...\"" )."
										<!--<a href=\"javascript:daftarmakul('form,wewenang,id',document.form.id.value)\" >daftar mata kuliah</a>-->
										<div class=\"suggestionsBoxKurikulum\" id=\"suggestionsKurikulum\" style=\"display: none;\">
											<div class=\"suggestionListKurikulum\" id=\"autoSuggestionsListKurikulum\"></div>
										</div>
									</div>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Nama MK</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "nama", $nama, " class=form-control m-input  size=50" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Semester Makul</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "semester", $semester, " class=form-control m-input  size=2" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">SKS</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "sks", $sks, " class=form-control m-input  size=2" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Jenis</label>\r\n    
									<label class=\"col-form-label\">
										<select class=form-control m-input name=jenismakul>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
											foreach ( $arrayjenismakul as $k => $v )
											{
												echo "<option value='{$k}'>{$v}</option>";
											}
    echo "								</select>
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">KELOMPOK KURIKULUM</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "kelompokkurikulum", $arraykelompokkurikulum, "{$kelompokkurikulum}", "", " class=form-control m-input " )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">KELOMPOK MATA KULIAH</label>\r\n    
									<label class=\"col-form-label\">
										".createinputselect( "kelompok", $arraykelompokmk, "{$kelompok}", "", " class=form-control m-input " )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
									<div class=\"col-lg-6\">
										<input type=submit value='Tampilkan' class=\"btn btn-brand\">
									</div>
								</div>
							</div>
							</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->
					</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->
<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t";
}
?>
