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
if ( $prodis == "" && $jenisusers == 0 )
{
    cekhaktulis( $kodemenu );
    #printjudulmenu( "Edit Waktu Entri Nilai untuk Dosen -  UMUM" );
    if ( $aksi == "hapus" )
    {
        if ( $_GET['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Batas Waktu Entri Nilai Dosen", HAPUS_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $q = "DELETE FROm waktunilai WHERE TAHUN='{$tahunhapus}' AND SEMESTER='{$semesterhapus}'";
            mysqli_query($koneksi,$q);
        }
        $aksi = "";
    }
    if ( $aksi == "Simpan" )
    {
        if ( $_POST['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Batas Waktu Entri Nilai Dosen", SIMPAN_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $vld[] = cekvaliditasthnajaran( "Tahun/Semester", $tahun, $semester );
            $vld[] = cekvaliditastanggal( "Tanggal Mulai", $mulai['tgl'], $mulai['bln'], $mulai['thn'] );
            $vld[] = cekvaliditastanggal( "Tanggal Selesai", $selesai['tgl'], $selesai['bln'], $selesai['thn'] );
            $vld = array_filter( $vld, "filter_not_empty" );
            if ( isset( $vld ) && 0 < count( $vld ) )
            {
                $errmesg = val_err_mesg( $vld, 1 );
            }
            else
            {
                unset( $_SESSION['token'] );
                $q = "INSERT INTO waktunilai \r\n  (TAHUN,SEMESTER,TANGGALMULAI,TANGGALSELESAI,LASTUPDATE,UPDATER)\r\n  VALUES \r\n  ('{$tahun}','{$semester}',\r\n  '{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n  '{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n  NOW(),'{$users}'\r\n  )\r\n  ";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Data Batas Waktu Entri Nilai Dosen berhasil disimpan";
                }
                else
                {
                    $q = "UPDATE waktunilai \r\n        SET\r\n        TANGGALMULAI='{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n        TANGGALSELESAI='{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n        LASTUPDATE=NOW(),\r\n        UPDATER='{$users}'\r\n        WHERE\r\n        TAHUN='{$tahun}' AND\r\n         SEMESTER='{$semester}'\r\n        ";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data Batas Waktu Entri Nilai Dosen berhasil disimpan";
                    }
                    else
                    {
                        $errmesg = "Data Batas Waktu Entri Nilai Dosen tidak disimpan";
                    }
                }
            }
        }
        $aksi = "";
    }
    if ( $aksi == "" )
    {
        $token = md5( uniqid( rand( ), TRUE ) );
        $_SESSION['token'] = $token;
        #printmesg( $errmesg );

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
                                <span class=\"caption-subject bold uppercase\"> Edit Waktu Entri Nilai untuk Dosen -  UMUM </span>
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
		
				
				echo "	<div class='portlet-title'>";
								printmesg("Edit Waktu Entri Nilai untuk Dosen -  UMUM");										
		echo "			</div>	
						<div class=\"m-portlet\">
				
							<!--begin::Form-->";
        echo "				<form action='index.php' class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" method=post>
								<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t  <input type=hidden name=sessid value='{$token}'>
								<div class=\"m-portlet__body\">		
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">Tahun/Semester</label>\r\n    
									<div class=\"col-lg-6\">
										<select name=tahun class=form-control m-input style=\"width:auto;display:inline-block;\">";
											$i = 1901;
											while ( $i <= $waktu[year] + 5 )
											{
												if ( $i == $waktu[year] )
												{
													$selected = "selected";
												}
												echo "<option {$selected} value='{$i}'>".( $i - 1 )."/{$i}</option>";
												$selected = "";
												++$i;
											}
        echo "							</select>/
										<select name=semester class=form-control m-input style=\"width:auto;display:inline-block;\">\r\n            ";
											foreach ( $arraysemester as $k => $v )
											{
												echo "<option value='{$k}'>{$v}</option>";
											}
        echo "							</select>
									</div>
								</div>
								<div class=\"form-group m-form__group row\" >
									<label class=\"col-lg-2 col-form-label\">Batas Akhir Entri Nilai s.d Tanggal</label>\r\n    
									<div class=\"col-lg-6\">".createinputtanggal( "selesai", "", "class=form-control m-input style=\"width:auto;display:inline-block;\"" )."</div>
								</div>
								<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
									<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
									<div class=\"col-lg-6\">
										<input type=submit name=aksi value='Simpan' class=\"btn btn-brand\">
									</div>
								</div>
							</div>
						</form>
					</div>";
        $q = "SELECT * FROM waktunilai ORDER BY TAHUN,SEMESTER";
        $h = mysqli_query($koneksi,$q);
        echo mysqli_error($koneksi);
        if ( 0 < sqlnumrows( $h ) )
        {
            #printjudulmenukecil( "<b>Data Batas Waktu Entri Nilai</b>" );
            /*echo "<div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Data Batas Waktu Entri Nilai</span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>";*/
			echo "	<div class=\"portlet light\">
                        <div class=\"portlet-body form\">
							<div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Data Batas Waktu Entri Nilai");
			echo "						</div>
									</div>";
			echo "				 	<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>";
            echo "										<tr class=juduldata align=center>\r\n        <td>Tahun/Semester</td>\r\n         <td>Batas Akhir Entri Nilai s.d Tanggal</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>\r\n    ";
            echo "									</thead>
													<tbody>";
	
			$i = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                ++$i;
                $kelas = kelas( $i );
                $tmp = explode( "-", $d[TANGGALSELESAI] );
                $tglselesai = $tmp[2];
                $blnselesai = $tmp[1];
                $thnselesai = $tmp[0];
                echo "\r\n      <tr {$kelas}>\r\n        <td>".( $d[TAHUN] - 1 )."/{$d['TAHUN']} ".$arraysemester[$d[SEMESTER]]."</td>\r\n         <td  align=center><b>{$tglselesai} ".$arraybulan[$blnselesai - 1]." {$thnselesai} </td>\r\n        <td  align=center>{$d['LASTUPDATE']}</td>\r\n        <td align=center>{$d['UPDATER']}</td>\r\n       <td align=center><a class=\"btn red\" href='index.php?pilihan={$pilihan}&tahunhapus={$d['TAHUN']}&semesterhapus={$d['SEMESTER']}&aksi=hapus&sessid={$token}'\r\n       onClick=\"return confirm('Hapus Batas Waktu Entri Nilai Dosen?');\"><i class=\"fa fa-trash\"</a></td>      \r\n       </tr>\r\n      ";
            }
            #echo "</table></div></div></div></div></div>";
			echo "									</tbody>
												</table>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--- end-col-md-12-->
			</div>
			</div>
			</div>";
        }
        else
        {
            printmesg( "Data Batas Waktu Entri Nilai Dosen Tidak Ada" );
        }
    }
}
else
{
    printmesg( "Operator Prodi tidak boleh mengakses fasilitas ini" );
}
?>
