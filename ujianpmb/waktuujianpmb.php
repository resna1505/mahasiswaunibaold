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
if ( $prodis == "" )
{
    cekhaktulis( $kodemenu );
    #printjudulmenu( "Jadwal Ujian PMB" );
    if ( $aksi == "hapus" )
    {
        if ( $_GET['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Jadwal Ujian PMB", HAPUS_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $q = "DELETE FROM waktuujianpmb WHERE TAHUN='{$tahunhapus}' AND GELOMBANG='{$gelombanghapus}'";
            mysqli_query($koneksi,$q);
        }
        $aksi = "";
    }
    if ( $aksi == "Simpan" )
    {
        if ( $_POST['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Jadwal Ujian PMB", SIMPAN_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $vld[] = cekvaliditastahun( "Tahun", $tahun );
            $vld[] = cekvaliditasinteger( "Gelombang", $gelombang );
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
                $q = "INSERT INTO waktuujianpmb \r\n  (TAHUN,GELOMBANG,TANGGALMULAI,TANGGALSELESAI,LASTUPDATE,UPDATER)\r\n  VALUES \r\n  ('{$tahun}','{$gelombang}',\r\n  '{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n  '{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n  NOW(),'{$users}'\r\n  )\r\n  ";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Data Jadwal Ujian PMB berhasil disimpan";
                }
                else
                {
                    $q = "UPDATE waktuujianpmb \r\n        SET\r\n        TANGGALMULAI='{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n        TANGGALSELESAI='{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n        LASTUPDATE=NOW(),\r\n        UPDATER='{$users}'\r\n        WHERE\r\n        TAHUN='{$tahun}' AND\r\n         GELOMBANG='{$gelombang}'\r\n        ";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data Jadwal Ujian PMB berhasil disimpan";
                    }
                    else
                    {
                        $errmesg = "Data Jadwal Ujian PMB tidak disimpan";
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
        if ( $gelombang == "" )
        {
            $gelombang = 1;
        }
        echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Jadwal Ujian PMB");
		echo "			</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->
								<form action='index.php' method=post class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\">
									<input type=hidden name=pilihan value='{$pilihan}'>
									<input type=hidden name=sessid value='{$token}'>
									<div class=\"m-portlet__body\">		
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
											<label class=\"col-lg-2 col-form-label\">Tahun Masuk</label>\r\n    
											<label class=\"col-form-label\">
												<select name=tahun>";
													$i = 1901;
													while ( $i <= $waktu[year] + 5 )
													{
														if ( $i == $waktu[year] )
														{
															$selected = "selected";
														}
														echo "<option {$selected} value='{$i}'>{$i}</option>";
														$selected = "";
														++$i;
													}
        echo "									</select>
											</label>
										</div>
										<div class=\"form-group m-form__group row\">
											<label class=\"col-lg-2 col-form-label\">Gelombang</label>\r\n    
											<label class=\"col-form-label\">
												<input type=text size=2 value='{$gelombang}' name=gelombang class=form-control m-input>
											</label>
										</div> 
										<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">Tanggal Mulai</label>\r\n    
										<label class=\"col-form-label\">
											".createinputtanggal( "mulai", "", "class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\">
										<label class=\"col-lg-2 col-form-label\">Tanggal Selesai</label>\r\n
										<label class=\"col-form-label\">
											".createinputtanggal( "selesai", "", "class=form-control m-input style=\"width:auto;display:inline-block;\"" )."
										</label>
									</div>
									<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
										<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
										<div class=\"col-lg-6\">
											<input type=submit name=aksi value='Simpan' class=\"btn btn-brand\">
										</div>
									</div>
								</div>";
        $q = "SELECT * FROM waktuujianpmb ORDER BY TAHUN,GELOMBANG";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            /*printjudulmenukecil( "<b>Data Jadwal Ujian PMB</b>" );
            echo "<div class=portlet-body>
							<div class=table-responsive><table class=\"table table-striped table-bordered table-hover\">     <tr class=juduldata align=center>\r\n        <td>Tahun Masuk</td>\r\n        <td>Gelombang</td>\r\n        <td>Mulai</td>\r\n        <td>Selesai</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>\r\n    ";
            */
			echo "<div class='portlet-title'>";
								printmesg("Data Jadwal Ujian PMB");
			echo "			</div>";
			echo "					<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata align=center>\r\n        <td>Tahun Masuk</td>\r\n        <td>Gelombang</td>\r\n        <td>Mulai</td>\r\n        <td>Selesai</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>\r\n 
													</thead>
													<tbody>";
			$i = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                ++$i;
                $kelas = kelas( $i );
                $tmp = explode( "-", $d[TANGGALMULAI] );
                $tglmulai = $tmp[2];
                $blnmulai = $tmp[1];
                $thnmulai = $tmp[0];
                $tmp = explode( "-", $d[TANGGALSELESAI] );
                $tglselesai = $tmp[2];
                $blnselesai = $tmp[1];
                $thnselesai = $tmp[0];
                echo "\r\n      <tr {$kelas}>\r\n        <td align=center>{$d['TAHUN']} </td>\r\n        <td align=center> {$d['GELOMBANG']} </td>\r\n        <td  align=center><b>{$tglmulai} ".$arraybulan[$blnmulai - 1]." {$thnmulai} </td>\r\n        <td  align=center><b>{$tglselesai} ".$arraybulan[$blnselesai - 1]." {$thnselesai} </td>\r\n        <td  align=center>{$d['LASTUPDATE']}</td>\r\n        <td align=center>{$d['UPDATER']}</td>\r\n       <td align=center><a class=\"btn red\" href='index.php?pilihan={$pilihan}&tahunhapus={$d['TAHUN']}&gelombanghapus={$d['GELOMBANG']}&aksi=hapus&sessid={$token}'\r\n       onClick=\"return confirm('Hapus Waktu jadwal Ujian?');\"><i class=\"fa fa-trash\"></i></a></td>      \r\n       </tr>\r\n      ";
            }
            #echo "</table></div></div></div></div></div>";
			echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</form>
		</div>
		<!--end::Portlet-->";
        }
        else
        {
            printmesg( "Data Jadwal Ujian PMB Tidak Ada" );
        }
    }
}
else
{
    printmesg( "Operator Prodi tidak boleh mengakses fasilitas ini" );
}
?>
