<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "Tampilkan" )
{
    $aksi = " ";
    include( "proseslaporan5.php" );
}
if ( $aksi == "" )
{
    echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Rekapitulasi Laporan Harian");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->
							<form name=form action=index.php method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
							<input type=hidden name=pilihan value='{$pilihan}'>
							<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Dari Tanggal</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtanggal( "tgl1", $tgl1, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Sampai Tanggal</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtanggal( "tgl2", $tgl2, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Jenis Tanggal</label>
										<div class=\"col-lg-6\">
											<div class=\"m-radio-list\">
												<label class=\"m-radio\">
													<input type=radio name='jenistanggal' value='bayar' checked> Tanggal Bayar
													<span></span>
												</label>
												<label class=\"m-radio\">
													<input type=radio name='jenistanggal' value='entri'> Tanggal Entri
													<span></span>
												</label>
											</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Cara Pembayaran</label>
										<label class=\"col-form-label\">
											<select name=carabayar class=form-control m-input><option value=''>Semua</option>";
												foreach ( $arraycarabayar as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Komponen Pembayaran</label>
										<div class=\"col-lg-6\">
											<div class=\"m-checkbox-list\">";
												$i = 0;
												foreach ( $arraykomponenpembayaran as $k => $v )
												{
													echo "	<label class=\"m-checkbox\">";
													echo "		<input checked id=jeniskomponen{$i}  type=checkbox name='jeniskomponen[{$k}]' value=1>{$v}<br>";
													echo "		<span></span>
															</label>";
													++$i;
												}
    echo "\r\n              					 [<a href='#' onClick='cekall();return false;'>pilih semua</a>] \r\n              [<a href='#' onClick='uncekall();return false;'>batal pilih semua</a>]\r\n              <input type=hidden name=count value='{$i}'>\r\n        \t\t\t<script>\r\n         \t\t\t\tvar count={$i};\r\n        \t\t\t\tfunction cekall() {\r\n        \t\t\t\t\tvar i=0;\r\n        \t\t\t\t\tfor (i=0;i<count ;i++) {\r\n         \r\n        \t\t\t\t\t\tdocument.getElementById('jeniskomponen'+i).checked=true;\r\n        \t\t\t\t\t\t \r\n         \t\t\t\t\t}\r\n         \r\n         \t\t\t\t}\r\n        \t\t\t\tfunction uncekall() {\r\n        \t\t\t\t\tvar i=0;\r\n        \t\t\t\t\tfor (i=0;i<count ;i++) {\r\n         \r\n        \t\t\t\t\t\tdocument.getElementById('jeniskomponen'+i).checked=false;\r\n         \t\t\t\t\t}\r\n         \r\n         \t\t\t\t}\r\n         \t\t\t</script>
											</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
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
