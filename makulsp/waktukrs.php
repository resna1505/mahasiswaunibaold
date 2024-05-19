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
    #printjudulmenu( "Edit Waktu KRS SP Online" );
    if ( $aksi == "hapus" )
    {
        if ( $_GET['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Waktu KRS Online", HAPUS_DATA );
        }
        else
        {
            unset( $_SESSION['token'] );
            $q = "DELETE FROM waktukrssp WHERE TAHUN='{$tahunhapus}' AND SEMESTER='{$semesterhapus}'";
            mysqli_query($koneksi,$q);
        }
        $aksi = "";
    }
    if ( $aksi == "Simpan" )
    {
        if ( $_POST['sessid'] != $_SESSION['token'] )
        {
            $errmesg = token_err_mesg( "Waktu KRS Online", SIMPAN_DATA );
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
                $q = "INSERT INTO waktukrssp \r\n  (TAHUN,SEMESTER,TANGGALMULAI,TANGGALSELESAI,LASTUPDATE,UPDATER)\r\n  VALUES \r\n  ('{$tahun}','{$semester}',\r\n  '{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n  '{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n  NOW(),'{$users}'\r\n  )\r\n  ";
                mysqli_query($koneksi,$q);
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $errmesg = "Data waktu KRS online berhasil disimpan";
                }
                else
                {
                    $q = "UPDATE waktukrssp \r\n        SET\r\n        TANGGALMULAI='{$mulai['thn']}-{$mulai['bln']}-{$mulai['tgl']}',\r\n        TANGGALSELESAI='{$selesai['thn']}-{$selesai['bln']}-{$selesai['tgl']}',\r\n        LASTUPDATE=NOW(),\r\n        UPDATER='{$users}'\r\n        WHERE\r\n        TAHUN='{$tahun}' AND\r\n         SEMESTER='{$semester}'\r\n        ";
                    mysqli_query($koneksi,$q);
                    if ( 0 < sqlaffectedrows( $koneksi ) )
                    {
                        $errmesg = "Data waktu KRS online berhasil disimpan";
                    }
                    else
                    {
                        $errmesg = "Data waktu KRS online tidak disimpan";
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
        printmesg( $errmesg );
		echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Edit Waktu KRS Semester Pendek Online -  UMUM");
								echo	"</div>
									</div>
									<div class='portlet-body form'>";
        echo "							<form action='index.php' method=post>
											<input type=hidden name=pilihan value='{$pilihan}'>
											<input type=hidden name=sessid value='{$token}'>
		<table class=\"table table-striped table-bordered table-hover\">
			<tr>
				<td>Tahun/Semester</td>
				<td>".createinputtahunajaransemester( 0,"tahun","semester",1 )."</td>
			</tr>
			<tr>
				<td>Tanggal Mulai</td>
				<td>".createinputtanggal( "mulai", "", "" )."</td>
			</tr>
			<tr>
				<td>Tanggal Selesai</td>
				<td>".createinputtanggal( "selesai", "", "" )."</td>
			</tr>
			<tr>
				<td></td>
				<td><input type=submit name=aksi value='Simpan' class=\"btn btn-brand\"></td>
			</tr>
		</table>\r\n    </form>\r\n  </div>";
        $q = "SELECT * FROM waktukrssp ORDER BY TAHUN,SEMESTER";
        $h = mysqli_query($koneksi,$q);
		#printjudulmenukecil( "<b>Data Waktu KRS Online</b>" );
        
		if ( 0 < sqlnumrows( $h ) )
        {
				 echo "<div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">";
                                printmesg("Data Waktu KRS Semester Pendek Online");
				echo "           </div>
							</div>";
				echo "		<div class=\"m-portlet\">			
								<div class=\"m-section__content\">
									<div class=\"table-responsive\">
										<table class=\"table table-bordered table-hover\">
											<thead>
												<tr class=juduldata align=center>\r\n        <td>Tahun/Semester</td>\r\n        <td>Mulai</td>\r\n        <td>Selesai</td>\r\n        <td>Tgl Update</td>\r\n        <td>Pengubah</td>\r\n        <td>Hapus</td>\r\n      </tr>\r\n    ";
				echo "					</thead>
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
					echo "\r\n      <tr {$kelas}>\r\n        <td>".( $d[TAHUN] - 1 )."/{$d['TAHUN']} ".$arraysemester[$d[SEMESTER]]."</td>\r\n        <td  align=center><b>{$tglmulai} ".$arraybulan[$blnmulai - 1]." {$thnmulai} </td>\r\n        <td  align=center><b>{$tglselesai} ".$arraybulan[$blnselesai - 1]." {$thnselesai} </td>\r\n        <td  align=center>{$d['LASTUPDATE']}</td>\r\n        <td align=center>{$d['UPDATER']}</td>\r\n       <td align=center><a href='index.php?pilihan={$pilihan}&tahunhapus={$d['TAHUN']}&semesterhapus={$d['SEMESTER']}&aksi=hapus&sessid={$token}'\r\n       onClick=\"return confirm('Hapus waktu KRS Online?');\"><i class=\"fa fa-trash\"></i></a></td>      \r\n       </tr>\r\n      ";
				}
				#echo "</table>";
				echo "										</tbody>
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>";
		}else{        
			printmesg( "Data Waktu KRS Semester Pendek Online Tidak Ada" );
		}
    }
}
else
{
    printmesg( "Operator Prodi tidak boleh mengakses fasilitas ini" );
}
?>
