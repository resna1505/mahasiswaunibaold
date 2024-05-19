<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
$idprodi = getfield( "IDPRODI", "mahasiswa", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "mahasiswa", " WHERE ID='{$idupdate}'" );
if ( $aksi == "" )
{
    $q = "SELECT ID,NAMA FROM mahasiswa WHERE ID='{$idupdate}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        printmesg( $errmesg );
        $d = sqlfetcharray( $h );
        #echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t<table class=form>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "update", "" ).createinputhidden( "idupdate", "{$idupdate}", "" ).createinputhidden( "tab", "{$tab}", "" )." <tr class=judulform>\r\n\t\t\t<td width=100><b>NIM Mahasiswa </td>\r\n\t\t\t<td><b>{$d['ID']}</td>\r\n\t\t</tr> \r\n \t\t<tr class=judulform>\r\n\t\t\t<td><b>Nama Mahasiswa </td>\r\n\t\t\t<td><b>{$d['NAMA']}</td>\r\n\t\t\t</tr> \r\n\t\t</table>\r\n \t\t\r\n  ";
        echo "		<div class=\"m-portlet\">
				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=index.php method=post>
					".createinputhidden( "pilihan", $pilihan, "" ).
					createinputhidden( "aksi", "update", "" ).
					createinputhidden( "idupdate", "{$idupdate}", "" ).
					createinputhidden( "tab", "{$tab}", "" )."
					<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$idprodi]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIM Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$d['ID']}</b></label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$d['NAMA']}</b></label>
						</div>";
		$q = "SELECT * FROM trskr WHERE NIMHSTRSKR='{$idupdate}' \r\n        ORDER BY THSMSTRSKR DESC, NORUTTRSKR";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            #echo "\r\n\t\t\t<br>\r\n\t\t\t\t<table {$border} class=data >\r\n \t\t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Tahun/Semester Pelaporan</td>\r\n\t\t\t\t\t\t<td>Judul Skripsi</td>\r\n \r\n\t\t\t\t \r\n\t\t\t\t\t</tr>";
            echo "					<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Tahun/Semester Pelaporan</td>\r\n\t\t\t\t\t\t<td>Judul Skripsi</td>\r\n \r\n\t\t\t\t \r\n\t\t\t\t\t</tr>
													</thead>
													<tbody>";	
			$i = 1;
            while ( $d = sqlfetcharray( $h ) )
            {
                $kelas = kelas( $i );
                $tmp = $d[THSMSTRSKR];
                $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
                $semester = $tmp[4];
                echo "\r\n\t\t\t\t\t<tr {$kelas} >\r\n\t\t\t\t\t\t<td>{$i} </td>\r\n \t\t\t\t\t\t<td align=center>\r\n             ".$arraysemester[$semester]."\r\n             ".$tahun."/".( $tahun + 1 )."\r\n             </td>\r\n\t\t\t\t\t\t<td>{$d['JUDULTRSKR']}</td>\r\n \r\n\t\t\t\t\t</tr>";
                ++$i;
            }
            #echo "\r\n\t\t\t\t</table>\r\n\t\t\t";
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
            printmesg( "Data Skripsi tidak ada" );
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
