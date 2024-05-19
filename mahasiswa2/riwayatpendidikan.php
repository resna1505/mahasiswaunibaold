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
#echo "\r\n<br>\r\n  <table class=form>\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIM Mahasiswa</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Mahasiswa</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table>\r\n";
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
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>{$idupdate}</b></label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama Mahasiswa</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\"><b>".$namamakul."</b></label>
						</div>";
if ( $aksi2 == "" || $aksi2 == "tampilkan" )
{
    $q = "SELECT * FROM msphs WHERE NIMHSMSPHS='{$idupdate}' ORDER BY NORUTMSPHS";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        #echo "\r\n\t\t\t<br>\r\n\t\t\t\t<table {$border} class=data >\r\n \r\n\t\t\t\t\t<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Jenjang Studi</td>\r\n\t\t\t\t\t\t<td>Gelar</td>\r\n\t\t\t\t\t\t<td>Kode PT</td>\r\n\t\t\t\t\t\t<td>Nama PT</td>\r\n\t\t\t\t\t\t<td>Bidang Ilmu</td>\r\n\t\t\t\t\t\t<td>Kota Asal</td>\r\n\t\t\t\t\t\t<td>Kode Negara</td>\r\n\t\t\t\t\t\t<td>Tanggal<br>Ijazah</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>IPK</td>\r\n \r\n\t\t\t\t\t</tr>";
         echo "					<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata  align=center>\r\n\t\t\t\t\t\t<td>No</td>\r\n \t\t\t\t\t\t<td>Jenjang Studi</td>\r\n\t\t\t\t\t\t<td>Gelar</td>\r\n\t\t\t\t\t\t<td>Kode PT</td>\r\n\t\t\t\t\t\t<td>Nama PT</td>\r\n\t\t\t\t\t\t<td>Bidang Ilmu</td>\r\n\t\t\t\t\t\t<td>Kota Asal</td>\r\n\t\t\t\t\t\t<td>Kode Negara</td>\r\n\t\t\t\t\t\t<td>Tanggal<br>Ijazah</td>\r\n\t\t\t\t\t\t<td>SKS</td>\r\n\t\t\t\t\t\t<td>IPK</td>\r\n \r\n\t\t\t\t\t</tr>";
		echo "										</thead>
													<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = explode( "-", $d[TGIJAMSPHS] );
            $tmp2[tgl] = $tmp[2];
            $tmp2[bln] = $tmp[1];
            $tmp2[thn] = $tmp[0];
            echo "\r\n\t\t\t\t\t<tr {$kelas} >\r\n\t\t\t\t\t\t<td>{$i} </td>\r\n \t\t\t\t\t\t<td align=center>".$arraypendidikantertinggi[$d[JENJAMSPHS]]."</td>\r\n\t\t\t\t\t\t<td>{$d['GELARMSPHS']}</td>\r\n\t\t\t\t\t\t<td>{$d['ASPTIMSPHS']}</td>\r\n\t\t\t\t\t\t<td>{$d['NMPTIMSPHS']}</td>\r\n \r\n\t\t\t\t\t\t<td>{$d['BIDILMSPHS']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['KOTAAMSPHS']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['KDNEGMSPHS']}</td>\r\n\t\t\t\t\t\t<td align=center nowrap>{$tmp2['tgl']}-{$tmp2['bln']}-{$tmp2['thn']}</td>\r\n          <td align=center>{$d['SKSTTMSPHS']}</td>\r\n\t\t\t\t\t\t<td align=center>{$d['NLIPKMSPHS']}</td>\r\n\t\t\t\t\t\t\r\n \t\t\t\t\t</tr>";
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
        printmesg( "Data Riwayat Pendidikan tidak ada" );
        echo "</p>";
    }
    echo "\r\n\t\t</form>\r\n\t\t\r\n\t\t";
}
?>
