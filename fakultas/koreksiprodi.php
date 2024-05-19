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
$arraystatuskoreksi[0] = "Program Studi tidak ada di MSPST";
$arraystatuskoreksi[1] = "Program Studi tidak ada di TBPST";

#printhelp( "{$help_koleksiprodi}", "bantuan" );
if ( $aksi == "" )
{
    $q = "\r\n  SELECT prodi.ID,prodi.NAMA AS NAMA,mspst.KDPSTMSPST,mspst.KDJENMSPST,0 AS STATUS\r\n  FROM prodi \r\n  LEFT JOIN mspst\r\n  ON mspst.IDX=prodi.ID\r\n  WHERE mspst.IDX IS NULL\r\n  \r\n  \r\n  UNION\r\n\r\n  SELECT prodi.ID,prodi.NAMA AS NAMA,mspst.KDPSTMSPST,mspst.KDJENMSPST, 1 AS STATUS\r\n  FROM prodi, mspst\r\n  LEFT JOIN tbpst\r\n  ON \r\n  tbpst.KDPSTTBPST=mspst.KDPSTMSPST AND\r\n  tbpst.KDJENTBPST=mspst.KDJENMSPST\r\n\r\n  WHERE \r\n  mspst.IDX=prodi.ID AND\r\n   \r\n  (tbpst.KDJENTBPST IS NULL OR tbpst.KDPSTTBPST IS NULL)\r\n  \r\n  ORDER BY NAMA\r\n  ";
    $h = doquery($koneksi, $q );
    if ( 0 < sqlnumrows( $h ) )
    {
        
		echo "<div class=\"m-portlet m-portlet--mobile\">
				<div class=\"m-portlet__head\">
				
					<div class=\"m-portlet__head-caption\">
						<div class=\"m-portlet__head-title\">
							<h3 class=\"m-portlet__head-text\">
								Koreksi Data Program Studi
							</h3>
						</div>
						
					</div>
				</div>";
	echo "<div class=\"m-portlet__body\">
			<!--begin: Datatable -->
			<table class=\"table table-striped- table-bordered table-hover table-checkable\" id=\"m_table_2\">
				<thead>
					<tr>
						    <th>No</th>
                                <th>ID</th>
                                <th>Kode PST</th>
                                <th>Kode Jenjang</th>
                                <th>Nam Progdi</th>
                                <th>Keterangan</th>
                            ";
		echo "			</tr> 
				</thead>
					<tbody>";
        $i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$i;
            $kelas = kelas( $i );
            $statustambahan = "";
            if ( 9000 <= $d['ID'] && $d['ID'] <= 9999 )
            {
                $statustambahan = "Program Studi DUMMY<br>";
            }
            echo "<tr {$kelas} valign=top align=center>\r\n        
						<td>{$i}</td>\r\n       
						<td>{$d['ID']}</td>
						<td>{$d['KDPSTMSPST']}</td>
						<td>{$d['KDJENMSPST']}-".$arrayjenjang[$d['KDJENMSPST']]."</td>
						<td align=left>{$d['NAMA']}</td>
						<td align=left>{$statustambahan}".$arraystatuskoreksi[$d['STATUS']]."</td>
					</tr>\r\n    ";


        }
       
		echo "			</tbody>
					</table>
				</div>
				<!--end::Portlet Body-->	
			</div>
			<!--end::Portlet Mobile-->	
		";
    }
    else
    {
		
		echo "<p>";	
       		printtitle( "Tidak ada data Program Studi yang berpotensi tidak valid berdasarkan tabel referensi." );
		echo "</p>
		";	
        #printmesg( "Tidak ada data Program Studi yang berpotensi tidak valid berdasarkan tabel referensi." );
    }
}
?>
