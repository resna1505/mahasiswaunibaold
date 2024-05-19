<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$idprodi = getfield( "IDDEPARTEMEN", "dosen", " WHERE ID='{$idupdate}'" );
$namamakul = getfield( "NAMA", "dosen", " WHERE ID='{$idupdate}'" );
#echo "\r\n<br>\r\n  <table class=form>\r\n     <tr class=judulform>\r\n\t\t\t<td width=150>Jurusan/Program Studi</td>\r\n\t\t\t<td>".$arrayprodidep[$idprodi]."\r\n      </td>\r\n\t\t</tr> \r\n    <tr>\r\n      <td>NIDN Dosen</td>\r\n      <td><b>{$idupdate}</td>\r\n    </tr>\r\n    <tr>\r\n      <td>Nama Dosen</td>\r\n      <td><b>".$namamakul."</td>\r\n    </tr>\r\n    </table>\r\n";
echo "		<div class=\"m-portlet\">				
				<!--begin::Form-->
				<form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" name=\"form\" action=\"index.php\" method=\"post\">
					<div class=\"m-portlet__body\">	";
		echo "			<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Jurusan/Program Studi</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$arrayprodidep[$idprodi]."</label>
						</div>
						<div class=\"form-group m-form__group row\">
							<label class=\"col-lg-2 col-form-label\">NIDN Dosen</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">{$idupdate}</label>
						</div>
						<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
							<label class=\"col-lg-2 col-form-label\">Nama Dosen</label>\r\n    
							<label class=\"col-form-label\" style=\"padding-left:0;width:auto;\">".$namamakul."</label>
						</div>";
if ( $aksi2 == "" || $aksi2 == "tampilkan" )
{
    $q = "SELECT * FROM trlsd WHERE NODOSTRLSD='{$idupdate}'";
    $h = mysqli_query($koneksi,$q);
    echo mysqli_error($koneksi);
    if ( 0 < sqlnumrows( $h ) )
    {
        #echo "\r\n    <br>\r\n      <table class=data{$cetak}>\r\n        <tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Status Aktivitas</td>\r\n  \r\n \r\n        </tr>";
        echo "	<div class=\"m-portlet\">			
					<div class=\"m-section__content\">
						<div class=\"table-responsive\">
							<table class=\"table table-bordered table-hover\">
								<thead>
									<tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>Status Aktivitas</td>\r\n  \r\n \r\n        </tr>";
		echo "					</thead>
								<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = $d[THSMSTRLSD];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            echo "\r\n            <tr valign=top align=center {$kelas}{$cetak}>\r\n          <td>{$i}</td>\r\n          <td nowrap align=left>{$tahun} ".$arraysemester[$semester]." </td>\r\n          <td>".$arraystatuskerjadosen[$d[STDOSTRLSD]]."</td>\r\n             \r\n            </tr>\r\n          ";
            ++$i;
        }
        #echo "\r\n      </table>\r\n    ";
		echo "						</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->";
    }
    else
    {
        printmesg( "Data  Dosen Keluar tidak ada" );
    }
    echo "\r\n   \r\n  ";
}
?>
