<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
set_time_limit(0);
periksaroot( );
if ( $aksi == "Tampilkan" )
{
    $aksi = " ";
    include( "proseslaporan4.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Rekapitulasi Pembayaran Mahasiswa" );
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Rekapitulasi Pembayaran Mahasiswa");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
		echo "				<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
								<input type=hidden name=pilihan value='{$pilihan}'>
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Angkatan</label>\r\n    
										<label class=\"col-form-label\">";
											$waktu = getdate( );
	echo "									<select name=angkatan class=form-control m-input> \r\n\t\t\t\t\t\t \r\n\t\t\t\t\t\t ";
												$cek = "";
												$i = 1900;
												while ( $i <= $waktu[year] + 5 )
												{
													$cek = "";
													if ( $i == $waktu[year] )
													{
														$cek = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t<option value='{$i}' {$cek}>{$i}</option>\r\n\t\t\t\t\t\t\t";
													$cek = "";
													++$i;
												}
echo "										</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Gelombang Masuk</label>\r\n    
										<label class=\"col-form-label\">
												<input type=text size=2 name=gelombang value='1' class=form-control m-input>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Program Studi / Program Pendidikan</label>\r\n    
										<label class=\"col-form-label\">
											<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t \r\n\t\t\t\t\t\t ";
												foreach ( $arrayprodidep as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</label>
									</div>";
    if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
    {
        echo "						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Jenis Kelas Default</label>\r\n    
										<label class=\"col-form-label\">
											<select name='jeniskelas' >\r\n         \r\n      ";
												foreach ( $arraykelasstei as $k => $v )
												{
													$selected = "";
													if ( $k == $d[JENISKELAS] )
													{
														$selected = "selected";
													}
													echo "<option value='{$k}' {$selected}>{$v}</option>";
												}
        echo "								</select>
										</label>
									</div>";
    }
    echo "							<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Kelas</label>\r\n    
										<label class=\"col-form-label\">
											<input type=text class=form-control m-input name=kelas value='01' size=2>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
												<input type=submit name=aksi value='Tampilkan' class=\"btn btn-brand\">
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
