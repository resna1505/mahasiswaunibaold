<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
unset( $arraysort );
$arraysort[0] = "komponenpembayaran.ID";
$arraysort[1] = "komponenpembayaran.NAMA";
$arraysort[2] = "komponenpembayaran.JENIS";
$arraysort[3] = "komponenpembayaran.LABELSPC";
$arraysort[4] = "komponenpembayaran.KODEBANK";
$arraysort[5] = "komponenpembayaran.KODEREKENING";
$arraysort[6] = "komponenpembayaran.KODEBANK2";
$arraysort[7] = "komponenpembayaran.KODEREKENING2";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $id != "" )
{
    $qfield .= " AND ID LIKE '{$id}'";
    $qjudul .= " KODE mengandung kata '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $nama != "" )
{
    $qfield .= " AND NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT * FROM komponenpembayaran \r\n\tWHERE 1=1 \r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]."";
#echo $q;
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    /*if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Data Komponen Pembayaran" );
        printmesg( $qjudul );
    }
    else
    {
        #printjudulmenucetak( "Data Komponen Pembayaran" );
        printmesgcetak( $qjudul );
    }*/
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
    if ( $aksi != "cetak" )
    {
        
		printmesg( $errmesg );
		printmesg( $qjudul );
		echo "		<div class=\"tools\">
						<form target=_blank action='cetakmahasiswa.php' method=post>
							<div class=\"table-scrollable\">
							<table class=\"table table-striped table-bordered table-hover\">
								<tr>
									<td>
										<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak'>\r\n \t\t\t\t \r\n \t\t\t\t{$qinput} \t\t\t\t{$input}\r\n\t\t\t
									</td>
								</tr>
							</table>
						</form>
					</div>{$tpage} {$tpage2}";
    }
    #echo "\r\n \t\t\t<table {$border} class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'>Kode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=2'>Jenis</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=3'>Label SPC</td>\r\n\t\t\t\t ";
    echo "						<div class=\"caption\">";
												printtitle("Data Komponen Pembayaran");
	echo "						</div>
								<div class=\"m-portlet\">			
									<div class=\"m-section__content\">
										<div class=\"table-responsive\">
											<table class=\"table table-bordered table-hover\">
												<thead>
													<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'>Kode</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>Nama</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=2'>Jenis</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=3'>Label SPC</td><td><a class='{$cetak}' href='{$href}"."sort=4'>Kode Bank Mandiri</td><td><a class='{$cetak}' href='{$href}"."sort=5'>Kode Rekening Mandiri</td><td><a class='{$cetak}' href='{$href}"."sort=6'>Kode Bank BNI</td><td><a class='{$cetak}' href='{$href}"."sort=7'>Kode Rekening BNI</td>";
	if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2  >Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    #echo "\r\n\t\t\t</tr>\r\n\t\t";
	echo "											</tr> 
												</thead>
												<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['ID']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left>".$arrayjenispembayaran[$d[JENIS]]."</td><td align=left>{$d['LABELSPC']}</td><td align=left>{$d['KODEBANK']}</td><td align=left>{$d['KODEREKENING']}</td><td align=left>{$d['KODEBANK2']}</td><td align=left>{$d['KODEREKENING2']}</td>";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t\t\t\t<td   align=center><a class=\"btn green\" href='index.php?pilihan={$pilihan}&aksi=formupdate&idupdate={$d['ID']}'><i class=\"fa fa-edit\"></i></td>\r\n\t\t\t\t\t\t\t";
            if ( $d[ID] != 98 && $d[ID] != 99 )
            {
                echo "\t<td   align=center ><a class=\"btn red\" \r\n  \t\t\t\t\t\t\t\tonclick=\"return confirm('Hapus Data Komponen Pembayaran Dengan Kode = {$d['ID']} ?');\"\r\n  \t\t\t\t\t\t\t\thref='{$href}&aksi=hapus&idhapus={$d['ID']}'><i class=\"fa fa-trash\"></i></td>\r\n  \t\t\t\t\t\t\t\t";
            }
            else
            {
                echo "<td>-</td>";
            }
        }
        echo "\r\n\t\t\t\t</tr>\r\n\t\t\t";
        ++$i;
    }
    #echo "</table>\r\n    {$tmpkomponen}\r\n   </div></div><br><br><br></div></div></div><br><br><br> ";
	echo "								</tbody>
								</table>
								 
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
			</div>
		</div>
		</div>
		</div>
		</div>
		</div>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Komponen Pembayaran Tidak Ada";
    $aksi = "";
}
?>
