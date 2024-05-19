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
    /*printjudulmenu( "Rekap Data Mahasiswa" );
    printmesg( $errmesg );
    echo "<div class=\"page-content\">
            <div class=\"container\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> REKAP DATA MAHASISWA</span>
                            </div>
                            <div class=\"actions\">
                                <form action=cetakbh.php target=_blank method=post ENCTYPE='MULTIPART/FORM-DATA'>
                                    <input type=submit name=aksi value=Cetak class=\"btn green\"></input>
                                </form>
                            </div>
                        </div>
                        <div class=\"portlet-body form\">";
    echo "<form action=index.php  method=post class=\"form-horizontal\">\r\n<input type=hidden name=pilihan value=\"mrekap\">\r\n<input type=hidden name=aksi value=\"tampilkan\">\r\n<input type=hidden name=sort value=\"ID\">\r\n<input type=hidden name=sessid value=\"";
    echo $_SESSION['token'];
    echo "\">\r\n";
    echo IKONLAPORAN48;
    echo "<div class=\"form-body\">
            <div class=\"form-group form-md-line-input\">
                <label class=\"col-md-2 control-label\" for=\"form_control_1\">Pengelompokan Baris</label>
                <div class=\"col-md-10\">";*/
    #echo "<table  >\r\n\r\n\t<tr>\r\n\t\t<td width=150>\r\n\t\t\tPengelompokan Baris\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t";
	 echo "<div class=\"page-content\">
			<div class=\"container-fluid\">
				<div class=\"row\">
					<div class=\"col-md-12\">
                
						<!-- BEGIN SAMPLE FORM PORTLET-->
						<div class=\"portlet light\">";
							printmesg( $errmesg );
							echo "
								<div class=\"portlet-body form\">
									<div class='tab-pane' id='tab_1'>
										<div class='portlet box blue'>
											<div class='portlet-title'>
												<div class='caption'>";
													printtitle("Rekap Data Mahasiswa");
							echo "				</div>
											</div>
											<div class='portlet-body form'>";
												
												
									echo "		<div class=\"portlet-body\">
													<form action=index.php  method=post>
															<input type=hidden name=pilihan value=\"mrekap\">
															<input type=hidden name=aksi value=\"tampilkan\">
															<input type=hidden name=sort value=\"ID\">
															<input type=hidden name=sessid value=\"";
    echo $_SESSION['token'];
    echo "\">
														<div class=\"table-scrollable\">
															<table class=\"table table-striped2 table-bordered table-hover\">\r\n\r\n\t<tr>\r\n\t\t<td width=150>\r\n\t\t\tPengelompokan Baris\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t";
    echo "<s";
    echo "elect name=klpb class=form-control>\r\n\t\t\t";
    foreach ( $arraynamagrup as $k => $v )
    {
        echo "<option value='{$k}'>{$v}";
    }
    echo "\t\t\t</select>";
	/*echo "<div class=\"form-control-focus\">
                                            </div>
                                        </div>
                                    </div>";
    echo "<div class=\"form-body\">
            <div class=\"form-group form-md-line-input\">
                <label class=\"col-md-2 control-label\" for=\"form_control_1\">Pengelompokan Kolom</label>
                <div class=\"col-md-10\">";*/
	
    echo "\r\n\t\t</td>\r\n\t</tr>\r\n\t<tr>\r\n\t\t<td>\r\n\t\t\tPengelompokan Kolom\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t\t";
    echo "<s";
    echo "elect name=klpk class=form-control>\r\n\t\t\t";
    foreach ( $arraynamagrup as $k => $v )
    {
        echo "<option value='{$k}'>{$v}";
    }
    echo "\t\t\t</select>";
	/*echo "<div class=\"form-control-focus\">
                                            </div>
                                        </div>
                                    </div>";*/
    echo "\r\n\t\t</td>\r\n\t</tr>\r\n\t<!--<tr>\r\n\t\t<td>\r\n\t\t\tGrafik Terhadap Total\r\n\t\t</td>\r\n\t\t<td>\r\n\t\t  <input type=checkbox name=grafik value=1> Ya\r\n \t\t</td>\r\n\t</tr>\r\n\r\n\r\n\t--><tr>\r\n\t\t<td colspan=2>\r\n\t\t\t<b>FILTER<hr>\r\n\t\t</td>\r\n\t</tr>\r\n";

    /*echo "<div class=\"caption font-green-haze\">
                                <i></i>
                                <span class=\"caption-subject bold uppercase\"> FILTER</span>
                            </div>";
    echo "<div class=\"form-body\">
            <div class=\"form-group form-md-line-input\">
                <label class=\"col-md-2 control-label\" for=\"form_control_1\">Jurusan/Program Studi</label>
                <div class=\"col-md-10\">";*/

    echo "\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";
    echo "\r\n\t\t\t\t\t<select class=form-control name=idprodi>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>";
	/*echo "<div class=\"form-control-focus\">
                                            </div>
                                        </div>
                                    </div>
                                </div>";*/

    echo "\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tAngkatan\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>";

    /*echo "<div class=\"form-body\">
            <div class=\"form-group form-md-line-input\">
                <label class=\"col-md-2 control-label\" for=\"form_control_1\">Angkatan</label>
                <div class=\"col-md-10\">";*/
    $waktu = getdate( );
    echo "\r\n\t\t\t\t\t\t<select name=angkatan class=form-control> \r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    $arrayangkatan = getarrayangkatan( );
    foreach ( $arrayangkatan as $k => $v )
    {
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
    }
    echo "\r\n\t\t\t\t\t\t</select>";
	/*echo "<div class=\"form-control-focus\">
                                            </div>
                                        </div>
                                    </div>
                                </div>";*/

    echo "\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n  \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tStatus\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t";

    /*echo "<div class=\"form-body\">
            <div class=\"form-group form-md-line-input\">
                <label class=\"col-md-2 control-label\" for=\"form_control_1\">Angkatan</label>
                <div class=\"col-md-10\">";*/

    echo "<select class=form-control name=status>\r\n\t\t\t\t\t\t<option value=''>Semua</option>";
    foreach ( $arraystatusmahasiswa as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>";
	/*echo "<div class=\"form-control-focus\">
                                            </div>
                                        </div>
                                    </div>
                                </div>";*/

    echo"\r\n\t\t\t\t</td>\r\n\t\t\t</tr> \r\n \r\n ";
    	echo "<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tPeriode Tahun Akademik \r\n\t\t\t\t</td>\r\n\t\t\t\t<td>\r\n          <input type=checkbox name=thnakademik value=1>\r\n        ";
    $waktu = getdate( );
    if ( $tahun2 == "" )
    {
        $tahun2 = $waktu[year];
    }
    echo "\r\n\t\t\t\t\t\t<select name=tahun2 class=masukan> \r\n\t\t\t\t\t\t ";
    $selected = "";
    $i = 1901;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $i == $tahun2 )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select>/\r\n\t\t\t\t\t\t<select name=semester2 class=masukan> \r\n\t\t\t\t\t\t ";
    unset( $arraysemester[3] );
    foreach ( $arraysemester as $k => $v )
    {
        if ( $k == $semester2 )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
    }
    echo "\r\n\t\t\t\t\t\t</select>\r\n\t\t\t\t\t(Khusus untuk Status Mahasiswa)\r\n\t\t\t\t</td>\r\n\t\t\t</tr>      \r\n      \r\n      ";
	
    echo "<tr valign=top><td colspan='2'><br>\r\n\t\t\t<input class=\"btn btn-brand\" type=submit value='Tampilkan' >\r\n\t\t\t<input class=\"btn btn-secondary\" type=reset value=Reset>\r\n\t\t</td>\r\n\t</tr>";
	echo "</table>";
							echo "						</div> <!-- end div table-scrollable-->
													</form>
												</div> <!-- end div portlet-body-->												
											</div> <!-- end div portlet-body-->
										</div> <!-- end div portlet-body form-->
									</div> <!-- end div portlet box blue-->
								</div> <!-- end div tab-pane-->
							</div> <!-- end div portlet-body form-->	
						</div> <!-- end div portlet light-->	
					</div> <!-- end div col-md-12-->	
				</div> <!-- end div row-->	
			</div> <!-- end div container-fluid-->	
		</div> <!-- end div content-->
	</div> <!-- end m-content-->	
	";
    /*echo "<div class=\"form-actions\">
            <div class=\"row\">
                <div class=\"col-md-offset-2 col-md-10\">
                    <input type=\"submit\" class=\"btn blue\" value=OK></input>
                    <input type=\"reset\" class=\"btn default\" value=Reset></input>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- END SAMPLE FORM PORTLET-->
                </div>
            </div>
        </div>
    </div>";*/
}
?>
