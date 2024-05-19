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
    include( "proseskosong.php" );
}
if ( $aksi == "" )
{
    #printjudulmenu( "Cari Ruang Kosong" );
    #printmesg( $errmesg );
    /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br><br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Cari Ruang Kosong </span>
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
												printmesg("Cari Ruang Kosong");
								echo "	</div>";
						echo "
			<div class=\"m-portlet\">
				
				<!--begin::Form-->";					
    echo "		<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=form action=index.php method=post>
					<input type=hidden name=pilihan value='{$pilihan}'>
					<input type=hidden name=aksi value='tampilkan'>
					<div class=\"m-portlet__body\">		
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Semester/Tahun Akademik</label>\r\n    
								<label class=\"col-form-label\">
									<select class=form-control m-input style=\"width:auto;display:inline-block;\" name=semester>\r\n\t\t\t\t\t ";
										foreach ( $arraysemester as $k => $v )
										{
											echo "<option value='{$k}'>{$v}</option>";
											break;
										}
    echo "							</select>/
									<select class=form-control m-input style=\"width:auto;display:inline-block;\" name=tahun>\r\n\t\t\t\t\t\t ";
										$selected = "";
										$i = 1901;
										while ( $i <= $w[year] + 10 )
										{
											$selected = "";
											if ( $i == $w[year] )
											{
												$selected = "selected";
											}
											echo "<option {$selected} value='{$i}'>".( $i - 1 )."/{$i}</option>";
											++$i;
										}
    echo "							</select>
								</label>
							</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Hari</label>\r\n    
							<label class=\"col-form-label\">
								<select class=form-control m-input name=hari>\r\n\t\t\t\t\t\t ";
									foreach ( $arrayhari as $k => $v )
									{
										echo "<option value='{$k}'>{$v}</option>";
									}
    echo "						</select>
							</label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Rentang Waktu</label>\r\n    
							<label class=\"col-form-label\">";
								if ( $jamawal == "" )
								{
									$jamawal = "07:00:00";
								}
								if ( $jamakhir == "" )
								{
									$jamakhir = "22:00:00";
								}
    echo "						<input type=text size=8 class=form-control m-input style=\"width:auto;display:inline-block;\" name=jamawal value='{$jamawal}'>s.d<input type=text size=8 class=form-control m-input style=\"width:auto;display:inline-block;\" name=jamakhir value='{$jamakhir}'> (jj:mm:dd)
							</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
							<div class=\"col-lg-6\">
								<input type=\"submit\" class=\"btn btn-brand\" value='Tampilkan'></input>
							</div>
						</div>						
                    </div>
				</form>
			</div>
		</div>
        </div>
		</div>
        ";
}
?>
