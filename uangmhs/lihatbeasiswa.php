<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "hapus" )
{
    if ( $_GET['sessid'] == $_SESSION['token'] )
    {
        cekhaktulis( $kodemenu );
        $q = "DELETE FROM diskonbeasiswa WHERE IDMAHASISWA='{$idmahasiswahapus}' AND IDKOMPONEN='{$idkomponenhapus}' AND\r\n  TAHUN='{$tahunhapus}' AND SEMESTER='{$semesterhapus}'\r\n  \r\n  ";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $errmesg = "Data beasiswa dengan ID Mahasiswa {$idmahasiswahapus} dan ID Komponen {$idkomponenhapus} berhasil dihapus";
            $ketlog = "Hapus Beasiswa Mahasiswa NIM {$idmahasiswahapus} dengan \r\n  \t\t\t\tID Komponen={$idkomponenhapus}  , Tahun={$tahunhapus}, Sem/Bulan={$semesterhapus} \r\n  \t\t\t\t";
            buatlog( 94 );
        }
        else
        {
            $errmesg = "Data beasiswa dengan ID Mahasiswa {$idmahasiswahapus} dan ID Komponen {$idkomponenhapus} tidak  berhasil dihapus ";
        }
        $aksi = "Tampilkan";
    }
    else
    {
        $errmesg = token_err_mesg( "Beasiswa", HAPUS_DATA );
        $aksi = "Tampilkan";
    }
}
if ( $aksi == "Tampilkan" )
{
    include( "prosestampilbeasiswa.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Cari Data Beasiswa" );
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
                                <span class=\"caption-subject bold uppercase\"> Cari Data Beasiswa </span>
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
								printtitle("Cari Data Beasiswa");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "					<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								".createinputhidden( "pilihan", $pilihan, "" )."
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">NIM</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtext( "idmahasiswa", "", " class=form-control m-input  size=20 id='inputString' onkeyup=\"lookup(this.value,'','');\" " )."
											<div class=\"suggestionsBox\" id=\"suggestions\" style=\"display: none;\">
												<div class=\"suggestionList\" id=\"autoSuggestionsList\"></div>
											</div>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Komponen Pembayaran</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idkomponen>\r\n        <option  value=''>Semua</option>\r\n\t\t\t";
												foreach ( $arraykomponenpembayaran as $k => $v )
												{
													echo "<option value={$k}>{$v}</option>";
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi value='Tampilkan' class=\"btn btn-brand\">
											<input type=reset value='Reset' class=\"btn btn-secondary\">
										</div>
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
