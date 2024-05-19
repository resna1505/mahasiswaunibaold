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
if ( $aksi == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Setting Ijazah", TAMBAH_DATA );
    }
    else
    {
        $vld[] = cekvaliditasnama( "Nama Rektor", $rektor );
        $vld[] = cekvaliditaskode( "NIP Rektor", $niprektor );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 1, SIMPAN_DATA );
        }
        else
        {
            $q = "UPDATE setingijazah SET REKTOR='{$rektor}',NIPREKTOR='{$niprektor}'";
            mysqli_query($koneksi,$q);
        }
    }
}
#printjudulmenu( "Setting Cetak Ijazah" );
#printmesg( $errmesg );
$q = "SELECT * FROM setingijazah ";
$h = mysqli_query($koneksi,$q);
if ( sqlnumrows( $h ) <= 0 )
{
    $q = "INSERT INTO setingijazah (ID) VALUES (0)";
    mysqli_query($koneksi,$q);
    $q = "SELECT * FROM setingijazah ";
    $h = mysqli_query($koneksi,$q);
}
if ( 0 < sqlnumrows( $h ) )
{
    $token = md5( uniqid( rand( ), TRUE ) );
    $_SESSION['token'] = $token;
    $d = sqlfetcharray( $h );
	echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";	
										
	echo "						<div class='portlet-title'>";
											printmesg("Setting Cetak Ijazah");
											printmesg( $errmesg );
	echo "						</div>
								<div class=\"m-portlet\">
										<!--begin::Form-->";
    echo "							<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
										<input type=hidden name=pilihan value='{$pilihan}'>
										<input type=hidden name=sessid value='{$token}'>
										<div class=\"m-portlet__body\">
											<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
												<label class=\"col-lg-2 col-form-label\">Nama Rektor/Direktur</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
													<input name=rektor value='{$d['REKTOR']}' size=30>
												</label>
											</div>
											<div class=\"form-group m-form__group row\">
												<label class=\"col-lg-2 col-form-label\">NIP Rektor/Direktur</label>\r\n    
												<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
													<input name=niprektor value='{$d['NIPREKTOR']}' size=30>
												</label>
											</div>
											<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
												<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
												<div class=\"col-lg-6\">
													<input type=submit name=aksi value='Simpan' class=\"btn btn-brand\">
													<input type=reset  value='Reset' class=\"btn btn-secondary\">
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
