<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
#$idprodi = getfield( "IDPRODI", "mahasiswa", " WHERE ID='{$idupdate}'" );
if ( $aksi == "update" )
{
    if ( $aksi2 == "Hapus" && $REQUEST_METHOD == POST )
    {
        if ( $_POST['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Beasiswa", HAPUS_DATA );
            unset( $_SESSION['token'] );
        }
        else if ( is_array( $dataupdate ) )
        {
            foreach ( $dataupdate as $k => $v )
            {
                $q = "\r\n\t  \t\t\t\t\tDELETE FROM trmbw\r\n\t  \t\t\t\t\tWHERE\r\n\t  \t\t\t\t\tNIMHSTRMBW='{$idupdate}'\r\n\t  \t\t\t\t\tAND  \r\n\t  \t\t\t\t\tTHSMSTRMBW='{$k}'\r\n\t  \t\t\t\t";
                doquery($koneksi,$q);
            }
            $errmesg = "Data Beasiswa Mahasiswa berhasil dihapus";
        }
    }
    if ( $aksi2 == "Simpan" && $REQUEST_METHOD == POST )
    {
        if ( $_POST['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Beasiswa Mahasiswa", SIMPAN_DATA );
            unset( $_SESSION['token'] );
        }
        else if ( is_array( $dataupdate ) )
        {
            foreach ( $dataupdate as $k => $v )
            {
                $vld[] = cekvaliditasthnajaran( "Tahun ajaran ", $datarp[$k]['tahun'], $datarp[$k]['semester'], false );
                $vld = array_unique( array_filter( $vld, "filter_not_empty" ) );
                if ( isset( $vld ) && 0 < count( $vld ) )
                {
                    $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
                }
                else
                {
                    $q = "SELECT IDPRODI FROM mahasiswa WHERE ID='{$idupdate}'";
                    $h = doquery($koneksi,$q);
                    $d = sqlfetcharray( $h );
                    $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$d['IDPRODI']}'";
                    $h = doquery($koneksi,$q);
                    if ( 0 < sqlnumrows( $h ) )
                    {
                        $d = sqlfetcharray( $h );
                        $idpt = $d[KDPTIMSPST];
                        $kodejenjang = $d[KDJENMSPST];
                        $kodeps = $d[KDPSTMSPST];
                    }
                    $q = " UPDATE trmbw SET\r\n\t\t\t\t\t\tKDPTITRMBW='{$idpt}',\r\n\t\t\t\t\t\tKDPSTTRMBW='{$kodeps}',\r\n\t\t\t\t\t\tKDJENTRMBW ='{$kodejenjang}', \r\n\t\t\t\t\t\tKDBSWTRMBW ='".$datarp[$k][kodebeasiswa]."'    ,\r\n\t\t\t\t\t\tTHSMSTRMBW='".$datarp[$k][tahun]."".$datarp[$k][semester]."'\r\n\t\t\t\t\t\tWHERE NIMHSTRMBW ='{$idupdate}' AND  \r\n\t  \t\t\t\t\tTHSMSTRMBW='{$k}'\r\n\t\t\t\t\t\t";
                    doquery($koneksi,$q);
                }
                $errmesg = "Data Beasiswa Mahasiswa berhasil disimpan";
            }
        }
    }
    if ( $aksi2 == "Tambah" && $REQUEST_METHOD == POST )
    {
        if ( $_POST['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Beasiswa Mahasiswa", TAMBAH_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $vld[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan data", $tahun, $semester, false );
            $vld = array_filter( $vld, "filter_not_empty" );
            if ( isset( $vld ) && 0 < count( $vld ) )
            {
                $errmesg = val_err_mesg( $vld, 2, TAMBAH_DATA );
            }
            else if ( trim( $kodebeasiswa ) == "" )
            {
                $errmesg = "Kode Beasiswa harus diisi";
            }
            else
            {
                $q = "SELECT IDPRODI FROM mahasiswa WHERE ID='{$idupdate}'";
                $h = doquery($koneksi,$q);
                $d = sqlfetcharray( $h );
                $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$d['IDPRODI']}'";
                $h = doquery($koneksi,$q);
                if ( 0 < sqlnumrows( $h ) )
                {
                    $d = sqlfetcharray( $h );
                    $idpt = $d[KDPTIMSPST];
                    $kodejenjang = $d[KDJENMSPST];
                    $kodeps = $d[KDPSTMSPST];
                }
                $q = " INSERT INTO trmbw \r\n\t\t\t   (THSMSTRMBW,KDPTITRMBW,KDJENTRMBW,KDPSTTRMBW,\r\n\t\t\t   NIMHSTRMBW , KDBSWTRMBW)\r\n\t\t\t   VALUES\r\n         ('{$tahun}{$semester}','{$idpt}','{$kodejenjang}','{$kodeps}','{$idupdate}',\r\n           '{$kodebeasiswa}' )\r\n         ";
                doquery($koneksi,$q);
                $errmesg = "Data Beasiswa Mahasiswa berhasil disimpan";
                $data = "";
                $strata = $gelar = $bidangilmu = $kodept = $namapt = $kotaasal = $kodenegara = "";
                $errmesg = "Data Beasiswa Mahasiswa tidak disimpan";
            }
        }
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
if ( $aksi == "formupdate" )
{
    $q = "SELECT ID,NAMA,IDPRODI FROM mahasiswa WHERE ID='{$idupdate}'";
    $h = doquery($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        /*echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "sessid", $_SESSION['token'], "" ).createinputhidden( "tab", "{$tab}", "" )." <tr class=judulform>\r\n\t\t\t<td width=100><b>NIM Mahasiswa </td>\r\n\t\t\t<td><b>{$d['ID']}</td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td><b>Nama Mahasiswa </td>\r\n\t\t\t<td><b>{$d['NAMA']}</td>\r\n\t\t\t</tr> \r\n\t\t</table></div></div>\r\n \t\t\r\n \t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">\r\n<tr>\r\n  <td >Tahun/Semester Pelaporan Data</td>\r\n  <td >\r\n";
        */
		echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=index.php method=post>
				".createinputhidden( "pilihan", $pilihan, "" ).
				createinputhidden( "aksi", "update", "" ).
				createinputhidden( "idupdate", "{$idupdate}", "" ).
				createinputhidden( "sessid", $_SESSION['token'], "" ).
				createinputhidden( "tab", "{$tab}", "" )."
				<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$d[IDPRODI]]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$d['ID']}</b></label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$d['NAMA']}</b></label>
						</div>";
		echo "			<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">Tahun/Semester Pelaporan Data</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">";		
									$waktu = getdate( );
		echo "					<select name=tahun class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
									$selected = "";
									$i = 1901;
									while ( $i <= $waktu[year] + 5 )
									{
										if ( $i == $waktu[year] )
										{
											$selected = "selected";
										}
										echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
										$selected = "";
										++$i;
									}
        echo "					</select>/
								<select name=semester class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
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
        echo "					</select>
							</label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#d8e2f7;\">
							<label class=\"col-lg-2 col-form-label\">Kode Beasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">
								".createinputselect( "kodebeasiswa", $arraykodebeasiswa, "{$kodebeasiswa}", "", " class=form-control m-input" )."
							</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
							<div class=\"col-lg-6\">
								<input type=submit name=aksi2 value='Tambah' class=\"btn btn-brand\">
								<input type=reset value='Reset' class=\"btn btn-secondary\">
							</div>
						</div>
					</div>					
				</div>";
        $q = "SELECT * FROM trmbw WHERE NIMHSTRMBW='{$idupdate}' \r\n        ORDER BY THSMSTRMBW DESC ";
        $h = doquery($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            /*echo "\r\n\t\t\t<br>\r\n\t\t\t\t<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\" {$border}>\r\n\t\t\t\t\t<tr  >\r\n \t\t\t\t\t\t<td align=right colspan=4>\r\n \t\t\t\t\t\t<input type=submit name=aksi2 value='Simpan' class=\"btn blue\">\r\n \t\t\t\t\t\t<input type=submit name=aksi2 value='Hapus' class=\"btn red\">\r\n \t\t\t\t\t\t</td>\r\n\t\t\t\t\t</tr>\t\t\t\t\t\r\n\t\t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Tahun/Semester Pelaporan</td>\r\n\t\t\t\t\t\t<td>Kode Beasiswa</td>\r\n \r\n\t\t\t\t\t\t<td>Pilih</td>\r\n\t\t\t\t\t</tr>";
            */
			echo "															
										<div class=\"tools\">
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi2 value='Simpan' class=\"btn btn-brand\">
														<input type=submit name=aksi2 value='Hapus' class=\"btn btn-brand\">
													</td>
												</tr>
											</table>
									</div>";
			echo "					<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Tahun/Semester Pelaporan</td>\r\n\t\t\t\t\t\t<td>Kode Beasiswa</td>\r\n \r\n\t\t\t\t\t\t<td>Pilih</td>\r\n\t\t\t\t\t</tr>
													</thead>
													<tbody>";
			$i = 1;
            while ( $d = sqlfetcharray( $h ) )
            {
                $kelas = kelas( $i );
                $tmp = $d[THSMSTRMBW];
                $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
                $semester = $tmp[4];
                echo "\r\n\t\t\t\t\t<tr {$kelas} >\r\n\t\t\t\t\t\t<td align=center>{$i} </td>\r\n \t\t\t\t\t\t<td align=center>".createinputselect( "datarp[{$d['THSMSTRMBW']}][semester]", $arraysemester, $semester, "", " class=form-control m-input style=\"width:auto;display:inline-block;\"  " )."\r\n             ".createinputtahun( "datarp[{$d['THSMSTRMBW']}][tahun]", $tahun, " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."\r\n             </td><td>".createinputselect( "datarp[{$d['THSMSTRMBW']}][kodebeasiswa]", $arraykodebeasiswa, "{$d['KDBSWTRMBW']}", "", " class=form-control m-input style=\"width:auto;display:inline-block;\"" )."</td><td align=center><input type=checkbox name='dataupdate[{$d['THSMSTRMBW']}]' value=1></td></tr>";
                ++$i;
            }
            #echo "\r\n\t\t\t\t</table></div></div></div></div></div>\r\n\t\t\t";
			echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->";
        }
        else
        {
            echo "<p>";
            printmesg( "Data Beasiswa tidak ada" );
            echo "</p>";
        }
        echo "\r\n\t\t</form>\r\n\t\t\r\n\t\t";
    }
    else
    {
        $errmesg = "Data Mahasiswa dengan ID = '{$idupdate}' tidak ada";
        $aksi = "";
    }
}
?>
