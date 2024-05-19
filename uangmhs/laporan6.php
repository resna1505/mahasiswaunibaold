<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
echo $_SESSION['users'];
periksaroot( );
if ( $aksi == "Tampilkan" )
{
    $aksi = " ";
    include( "proseslaporan6.php" );
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
								printmesg("Laporan Harian");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->
							<form name=form action=index.php method=post>
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
											<div class=\"m-radio-list\">";
											if($_SESSION['users']=='fariz02' || $_SESSION['users']=='admin'){
echo "											<label class=\"m-radio\">
													<input type=radio name='jenistanggal' value='bayar' checked> Tanggal Bayar
													<span></span>
												</label>
												<label class=\"m-radio\">
													<input type=radio name='jenistanggal' value='entri' checked> Tanggal Entri
													<span></span>
												</label>";
											}else{
echo "												<label class=\"m-radio\">
													<input type=radio name='jenistanggal' value='entri' checked> Tanggal Entri
													<span></span>
												</label>";
											}
echo "										</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Cara Pembayaran</label>
										<label class=\"col-form-label\">
											<select name=carabayar class=form-control m-input><option value=''>Semua</option>";
												/*foreach ( $arraycarabayar as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}*/
    echo "									</select>
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Kelas</label>
										<div class=\"col-lg-6\">
											<select name=kelas>\r\n            <option value=''>Semua</option>\r\n            ";
												foreach ( $arraykelasmhs as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}
	echo "									</select>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Program Studi</label>
										<div class=\"col-lg-6\">
											<select name=idprodi>\r\n            <option value=''>Semua</option>\r\n            ";
												/*foreach ( $arrayprodidep as $k => $v )
												{
													echo "<option value='{$k}'>{$v}</option>";
												}*/
	echo "									</select>
										</div>
									</div>	
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Komponen Pembayaran</label>
										<div class=\"col-lg-6\">
											<div class=\"m-checkbox-list\">";
												$i = 0;
												foreach ( $arraykomponenpembayaran as $k => $v )
												{
													echo "	<label class=\"m-checkbox\" style='display:none;'>";
													echo "		<input checked id=jeniskomponen{$i}  type=checkbox name='jeniskomponen[{$k}]' value=1>{$v}<br>";
													echo "		<span></span>
															</label>";
													++$i;
												}
    echo "\r\n              					 <!--[<a href='#' onClick='cekall();return false;'>pilih semua</a>] \r\n              [<a href='#' onClick='uncekall();return false;'>batal pilih semua</a>]-->      <input type=hidden name=count value='{$i}'>\r\n        \t\t\t<script>\r\n         \t\t\t\tvar count={$i};\r\n        \t\t\t\tfunction cekall() {\r\n        \t\t\t\t\tvar i=0;\r\n        \t\t\t\t\tfor (i=0;i<count ;i++) {\r\n         \r\n        \t\t\t\t\t\tdocument.getElementById('jeniskomponen'+i).checked=true;\r\n        \t\t\t\t\t\t \r\n         \t\t\t\t\t}\r\n         \r\n         \t\t\t\t}\r\n        \t\t\t\tfunction uncekall() {\r\n        \t\t\t\t\tvar i=0;\r\n        \t\t\t\t\tfor (i=0;i<count ;i++) {\r\n         \r\n        \t\t\t\t\t\tdocument.getElementById('jeniskomponen'+i).checked=false;\r\n         \t\t\t\t\t}\r\n         \r\n         \t\t\t\t}\r\n         \t\t\t</script>
											</div>
										</div>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Tahun Akademik :</label>
										<label class=\"col-form-label\">
											<select name=tahunajaran class=masukan> \r\n\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
												/*$arrayangkatan = getarrayangkatan( "R" );
												foreach ( $arrayangkatan as $k => $v )
												{
													$selected = "";
													if ( $k == $waktu[year] )
													{
														$selected = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected} >".( $v - 1 )."/{$v}</option>\r\n\t\t\t\t\t\t\t";
												}
												++$k;*/
    echo "										<!--<option value='".$k."' {$selected} >".( $k - 1 )."/{$k}</option>-->";
    echo "									</select>
											( Khusus pilihan Per Tahun Akademik )
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tahun Akademik dan Semester : </label>
										<label class=\"col-form-label\">
											<select name=tahunbayar class=masukan><option value=''>Semua</option>";
												/*$arrayangkatan = getarrayangkatan( "R" );
												foreach ( $arrayangkatan as $k => $v )
												{
													$selected = "";
													if ( $k == $waktu[year] )
													{
														$selected = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected} >".( $v - 1 )."/{$v}</option>\r\n\t\t\t\t\t\t\t";
												}
												++$k;*/
    echo "										<!--<option value='".$k."' {$selected} >".( $k - 1 )."/{$k}</option>-->";
    echo "									</select>
											<select name=semesterbayar class=masukan> \r\n\t\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
												/*foreach ( $arraysemester as $k => $v )
												{
													$cek = "";
													if ( $k == $d2[SEMESTER] )
													{
														$cek = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
												}*/
    echo "									</select> 
											(Khusus pilihan Semester ) 
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Tahun Akademik dan Semester Cuti : </label>
										<label class=\"col-form-label\">
											<select name=tahunbayarc class=masukan> \r\n\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
												/*$arrayangkatan = getarrayangkatan( "R" );
												foreach ( $arrayangkatan as $k => $v )
												{
													$selected = "";
													if ( $k == $waktu[year] )
													{
														$selected = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected} >".( $v - 1 )."/{$v}</option>\r\n\t\t\t\t\t\t\t";
												}
												++$k;*/
    echo "										<!--<option value='".$k."' {$selected} >".( $k - 1 )."/{$k}</option>-->";
    echo "									</select>
											<select name=semesterbayarc class=masukan><option value=''>Semua</option>";
												/*foreach ( $arraysemester as $k => $v )
												{
													$cek = "";
													if ( $k == $d2[SEMESTER] )
													{
														$cek = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
												}*/
    echo "									</select>(Khusus pilihan Cuti ) 
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Bulan/Tahun :</label>
										<label class=\"col-form-label\">
											<select name=semesterbayar2 class=masukan><option value=''>Semua</option>";
												/*foreach ( $arraybulan as $k => $v )
												{
													$cek = "";
													if ( $k == $d2[SEMESTER] )
													{
														$cek = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t\t\t\t\t<option value='".( $k + 1 )."' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t\t\t\t\t";
												}*/
    echo "									</select>
											<select name=tahunajaran2 class=masukan> \r\n\t\t\t\t\t\t\t\t\t <option value=''>Semua</option>";
												/*$ii = 1901;
												while ( $ii <= $waktu[year] + 5 )
												{
													$cek = "";
													if ( $ii == $d2[TAHUNAJARAN] )
													{
														$cek = "selected";
													}
													else if ( $ii == $waktu[year] && $d2[TAHUNAJARAN] == "" )
													{
														$cek = "selected";
													}
													echo "\r\n\t\t\t\t\t\t\t\t\t\t<option value='{$ii}' {$cek}>{$ii}</option>\r\n\t\t\t\t\t\t\t\t\t\t";
													++$ii;
												}*/
    echo "									</select>
											(Khusus pilihan Per Bulan )
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Operator Keuangan</label>
										<label class=\"col-form-label\">
											<select name=operator>\r\n            <option value=''>Semua</option>\r\n            ";
												if($_SESSION['users']=='arizona01' || $_SESSION['users']=='admin'){
													$arrayoperatorkeuangan2 = getoperatorkeuangan2();
													if ( is_array( $arrayoperatorkeuangan2 ) )
													{
														foreach ( $arrayoperatorkeuangan2 as $k => $v )
														{
														echo "<option value='{$k}'>{$v}</option>";
														}
													}
												}
    echo "									</select>
										</label>
									</div>
									<!-- \t\r\n\t\t\t\t\t<tr >\r\n\t\t\t\t\t\t<td>Tampilan</td>\r\n\t\t\t\t\t\t<td><input  type=checkbox name='tampilan' value=1>Dikelompokkan per jenis pembayaran\r\n              \r\n            </td>\r\n\t\t\t\t\t\t</tr>\t\t  \t\t\t\r\n            -->\r\n\t\t\t
									<div class=\"form-group m-form__group row\"  style=\"background-color:#f7f8fa;\">
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
