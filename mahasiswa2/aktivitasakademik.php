<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

    $q = "SELECT * FROM trakm WHERE NIMHSTRAKM='{$idupdate}' ORDER BY THSMSTRAKM DESC";
	#echo $q.'<br>';
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
		 echo "<div class=\"m-portlet\">			
					<div class=\"m-section__content\">
						<div class=\"table-responsive\">
							<table class=\"table table-bordered table-hover\">
								<thead>
									<tr class=juduldata{$cetak} align=center>\r\n          <td>No.</td>\r\n          <td>Tahun / Semester Lapor</td>\r\n          <td>IP Semester</td>\r\n          <td>SKS Semester</td>\r\n          <td>IP Kumulatif</td>\r\n          <td>SKS Total</td>\r\n \r\n        </tr>";
		echo "					</thead>
								<tbody>";
		$i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            $tmp = $d['THSMSTRAKM'];
            $tahun = $tmp[0].$tmp[1].$tmp[2].$tmp[3];
            $semester = $tmp[4];
            echo "\r\n            <tr valign=top align=center {$kelas}{$cetak}>\r\n          <td>{$i}</td>\r\n          <td nowrap align=left>{$tahun} ".$arraysemester[$semester]." </td>\r\n          <td>{$d['NLIPSTRAKM']}</td>\r\n          <td >{$d['SKSEMTRAKM']}</td>\r\n          <td>{$d['NLIPKTRAKM']}</td>\r\n          <td>{$d['SKSTTTRAKM']}</td>\r\n             \r\n           </tr>\r\n          ";
            ++$i;
        }
        #echo "\r\n      </table>\r\n    ";
		echo "						</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::m-portlet-->";
    }
    else
    {
        printmesg("Data Aktifitas Kuliah Mahasiswa tidak ada" );
    }
    echo "\r\n   \r\n  ";

?>
