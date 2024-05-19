<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "tampilkan" )
{
    $aksi = " ";
    include( "proseslog.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Lihat Data Log" );
    #printmesg( $errmesg );
    $arraylog2 = $arraylog;
    asort( $arraylog2 );
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printtitle("Lihat Data Log");
				echo "	</div>";
	echo "			<div class=\"m-portlet\">
					<!--begin::Form-->
						<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" form name=form action=index.php method=post>
						<input type=hidden name=pilihan value='{$pilihan}'><input type=hidden name=aksi value='tampilkan'>
							<div class=\"m-portlet__body\">";
	
	echo "							<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Periode Awal</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtanggal( "tglbayar", $tglbayar, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">Periode Akhir</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtanggal( "tglbayar2", $tglbayar2, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
									<label class=\"col-lg-2 col-form-label\">Kata Kunci Keterangan</label>\r\n    
									<label class=\"col-form-label\">
										".createinputtext( "kunci", $kunci, " class=form-control m-input size=50" )."
									</label>
								</div>
								<div class=\"form-group m-form__group row\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
									<div class=\"col-lg-6\">
										<input type=submit value='Tampilkan' class=\"btn btn-brand\"></input>
										<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
									</div>
								</div>";
	echo "						</div>
						</form>
					</div>
			<!--end::Portlet-->
				</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->
<script>form.id.focus();\r\n\t\t\t</script>";



    /*echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'>\r\n    ".IKONCARI48."\r\n\t\t<table  >\r\n   \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJenis Log\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t<select class=masukan name=jenislog>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arraylog2 as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t<tr >\r\n\t\t\t<td>Periode</td>\r\n\t\t\t<td>\r\n\t\t\t<input type=checkbox name=istglbayar value=1>\r\n\t\t\t".createinputtanggal( "tglbayar", $tglbayar, " class=masukan" )."\r\n\t\t\ts.d \r\n\t\t\t".createinputtanggal( "tglbayar2", $tglbayar2, " class=masukan" )."\r\n\t\t\t</td>\r\n\t\t\t</tr>\t\t\t\t\r\n \t\t\t<tr>\r\n \t\t<tr class=judulform>\r\n\t\t\t<td>Kata kunci keterangan</td>\r\n\t\t\t<td>".createinputtext( "kunci", $kunci, " class=masukan  size=20" )."\r\n\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t\t\t<td colspan=2>\r\n\t\t\t\t\t<input type=submit value='Tampilkan' class=masukan>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t</table>\r\n\t\t</form>\r\n\t\t\t<script>\r\n \t\t\t\tform.id.focus();\r\n\t\t\t</script>\r\n\t";
	*/
}
?>
