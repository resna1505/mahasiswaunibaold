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
    include( "prosesrekap.php" );
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
								printmesg("Rekap Data Dosen");
				echo "	</div>";
		echo "			<div class=\"m-portlet\">
				
						<!--begin::Form-->
						<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" form name=form action=index.php method=post>
							<input type=hidden name=pilihan value=\"mrekap\">
							<input type=hidden name=aksi value=\"tampilkan\">
							<input type=hidden name=sort value=\"ID\">
								<div class=\"m-portlet__body\">
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Pengelompokan Baris</label>\r\n    
										<div class=\"col-lg-6\">";
											echo "<select name=klpb class=form-control m-input>\r\n\t\t\t";
											foreach ( $arraynamagrup as $k => $v )
											{
												echo "<option value='{$k}'>{$v}";
											}
											echo "\t\t\t</select>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Pengelompokan Kolom</label>\r\n    
										<div class=\"col-lg-6\">";
											echo "	<select name=klpk class=form-control m-input>\r\n\t\t\t";
													foreach ( $arraynamagrup as $k => $v )
													{
														echo "<option value='{$k}'>{$v}";
													}
											echo "	</select>
										</div>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Grafik Terhadap Total</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=checkbox name=grafik value=1> Ya
										</div>
									</div>";
					echo "			<div class='portlet-title'>";
										printmesg("Filter");
					echo "			</div>";
					echo "			<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
										<div class=\"col-lg-6\">
											<select class=form-control m-input name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												foreach ( $arrayprodidep as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
					echo "					</select>
										</div>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Status Aktifitas</label>\r\n    
										<div class=\"col-lg-6\">
											<select class=form-control m-input name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												foreach ( $arraystatuskerjadosen as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
					echo "					</select>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Status Ikatan Kerja</label>\r\n    
										<div class=\"col-lg-6\">
											<select class=form-control m-input name=statuskerja>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
												foreach ( $arraystatusdosen as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
					echo "					</select>
										</div>
									</div>";
					#echo "\r\n\r\n\t<tr valign=top>\r\n\t\t<td></td><td><br>\r\n\t\t\t<input type=\"submit\" class=\"btn btn-brand\" value=Tampilkan></input>\r\n\t\t\t<input type=\"reset\" class=\"btn btn-secondary\" value=reset></input>\r\n\t\t</td>\r\n\t</tr>\r\n
					echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=\"submit\" class=\"btn btn-brand\" name=aksi2 value=Tambah></input>
											<input type=\"reset\" class=\"btn btn-secondary\" value=Reset></input>  
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
	";
}
?>
