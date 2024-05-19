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

echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">
									<div class=\"caption\">";
										printmesg("Data Operator");
	echo "							</div>";
								
$arraysort[0] = "user.ID";
$arraysort[1] = "user.NAMA";
$arraysort[2] = "user.IDPRODI";
if ( $tingkataksesusers[$kodemenu] == "T" && issupervisor( $users ) && $aksi != "cetak" )
{
    #$menulihat = "\t\r\n\t\t\t\t\t\t<input class=\"btn red\" type=submit value=Hapus name=aksitambahan\r\n\t\t\t\t\t\tonclick=\"return confirm('Hapus data Operator yang dipilih? Data yang dihapus tidak dapat dikembalikan lagi.')\">\r\n\r\n\t\t";
	$menulihat="						<div class=\"tools\">
											<div class=\"table-scrollable\">
												<table class=\"table table-striped table-bordered table-hover\">
													<tr>
														<td>
															<input class=\"btn btn-brand\" type=submit value=Hapus name=aksitambahan\r\n\t\t\t\t\t\tonclick=\"return confirm('Hapus data Operator yang dipilih? Data yang dihapus tidak dapat dikembalikan lagi.')\">\r\n\r\n\t\t
														</td>
													</tr>
												</table>
											</div>
										</div>";
}
include( "hasilfilteruser.php" );
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
    $qsort = "ORDER BY ".$arraysort[$sort]." ";
}
else
{
    $qsort = "ORDER BY ".$arraysort[$sort]." ";
}
#$query = "SELECT ID,  NAMA ,IDPRODI,STATUSLOGIN,LASTLOGIN,LASTAKSI,STATUS\r\n\t\tFROM user WHERE ID!='superadmin' \r\n\t\t{$queryfilteruser}\t\r\n\t\t{$qsort} ";
$query = "SELECT ID,  NAMA ,IDPRODI,STATUSLOGIN,LASTLOGIN,LASTAKSI,STATUS FROM user WHERE ID!='superadmin' {$queryfilteruser} {$qsort} ";
$hasil =mysqli_query($koneksi,$query);
if ( 0 < sqlnumrows( $hasil ) )
{
    $judulmenu = "Data Operator";
    $judulmenu2 = $judulfilteruser;
    /*if ( $aksi == "cetak" )
    {
        #printjudulmenucetak( $judulmenu );
        printmesgcetak( $judulmenu2 );
    }
    else
    {
        #printjudulmenu( $judulmenu );
        printmesg( $judulmenu2 );
    }*/
	echo "							<div class=\"caption\">";
										printmesg($judulmenu2);
	echo "							</div>";
    $i = 1;
    settype( $i, "integer" );
    $href = "index.php?pilihan=lihat&aksi=tampilkan&{$hreffilteruser}\r\n\t\t";
    if ( $aksi != "cetak" )
    {
        
        echo "			<form action=index.php?pilihan=lihat&aksi=tampilkan method=post>
							<input type=hidden name=sort value='{$sort}'>
							<input type=hidden name=namadicari value='{$namadicari}'>
							<input type=hidden name=usia1 value='{$usia1}'>
							<input type=hidden name=usia2 value='{$usia2}'>
							<input type=hidden name=agama value='{$agama}'>
							<input type=hidden name='tgld' value='{$tgld}'>
							<input type=hidden name='blnd' value='{$blnd}'>
							<input type=hidden name='thnd' value='{$thnd}'>
							<input type=hidden name='tgls' value='{$tgls}'>
							<input type=hidden name='blns' value='{$blns}'>
							<input type=hidden name='thns' value='{$thns}'>
							<input type=hidden name='isthn' value='{$isthn}'>
							<input type=hidden name=jk value='{$jk}'>
							<input type=hidden name=pendidikan value='{$pendidikan}'>
							<input type=hidden name=statusnikah value='{$statusnikah}'>
							<input type=hidden name=goldarah value='{$goldarah}'>
							<input type=hidden name=bidang value='{$bidang}'>
							<input type=hidden name=lokasi value='{$lokasi}'>
							<input type=hidden name=jabatan value='{$jabatan}'>
							<input type=hidden name=statuspegawai value='{$statuspegawai}'>
							<input type=hidden name=waktukerja value='{$waktukerja}'>
							{$menulihat}{$inputfilteruser}";
    }
    
	echo "	             	<div class=\"m-portlet\">			
								<div class=\"m-section__content\">
									<div class=\"table-responsive\">";
    #echo "\r\n\r\n\t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<thead><tr class=juduldata{$cetak}  align=center valign=middle>\r\n\t\t\t\t<td >No</td>\r\n\t\t\t\t<td  ><a class='{$cetak}' href='{$href}"."sort=0"."'>ID</a></td>\r\n  \t\t\t\t<td  ><a class='{$cetak}' href='{$href}"."sort=1"."'>Nama</a></td>\r\n  \t\t\t\t<td  ><a class='{$cetak}' href='{$href}"."sort=2"."'>Operator Program Studi</a></td>\r\n  \t\t\t\t<td  >Status</td>\r\n  \t\t\t\t<td  >Status Login</td>\r\n  \t\t\t\t<td  >Waktu Login Terakhir</td>\r\n  \t\t\t\t<td  >Waktu Aktifitas Terakhir</td>\r\n \t\t\t\t ";
    echo "								<table class=\"table table-bordered table-hover\">
											<thead>
												<tr class=juduldata{$cetak}  align=center valign=middle>\r\n\t\t\t\t<td >No</td>\r\n\t\t\t\t<td  ><a class='{$cetak}' href='{$href}"."sort=0"."'>ID</a></td>\r\n  \t\t\t\t<td  ><a class='{$cetak}' href='{$href}"."sort=1"."'>Nama</a></td>\r\n  \t\t\t\t<td  ><a class='{$cetak}' href='{$href}"."sort=2"."'>Operator Program Studi</a></td>\r\n  \t\t\t\t<td  >Status</td>\r\n  \t\t\t\t<td  >Status Login</td>\r\n  \t\t\t\t<td  >Waktu Login Terakhir</td>\r\n  \t\t\t\t<td  >Waktu Aktifitas Terakhir</td>\r\n \t\t\t\t ";
	if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t<td  >Update</td>\r\n\t\t\t\t\t<td  >Hapus</td>";
    }
    #echo "\r\n\t\t\t</tr>\r\n\t\t\t</thead>";
	echo "										</tr>
											</thead>
											<tbody>";
    while ( $data = sqlfetcharray( $hasil ) )
    {
        if ( $data['ID'] != $admin )
        {
            $hps = "<input type=checkbox name=hapususer[] value='{$data['ID']}'>";
        }
        else
        {
            $hps = "";
        }
        if ( $i % 2 == 0 )
        {
            $kelas = "class=datagenap{$cetak}";
        }
        else
        {
            $kelas = "class=dataganjil{$cetak}";
        }
        if ( $data['IDPRODI'] != "" )
        {
            $opprodi = $arrayprodidep[$data['IDPRODI']];
        }
        else
        {
            $opprodi = "Semua Program Studi";
        }
        echo "\r\n\t\t\t\t<tr {$kelas} valign=top>\r\n\t\t\t\t\t<td align=center>{$i}</td>\r\n\t\t\t\t\t<td align=center>\r\n          {$data['ID']}</td>\r\n \r\n\t\t\t\t\t<td >{$data['NAMA']}</td>\r\n\t\t\t\t\t<td >{$opprodi}</td>\r\n\t\t\t\t\t<td align=center>".$arraystatususer[$data['STATUS']]."</td>\r\n\t\t\t\t\t<td align=center>".$arraystatuslogin[$data['STATUSLOGIN']]."</td>\r\n\t\t\t\t\t<td align=center >{$data['LASTLOGIN']}</td>\r\n\t\t\t\t\t<td  align=center>{$data['LASTAKSI']}</td>\r\n \r\n \t\t\t\t\t ";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            echo "\r\n\t\t\t\t\t<td align=center><a class=\"btn green\" href=index.php?pilihan=tambah&aksi=updateuser&iduser=".rawurlencode($data['ID'])."> <i class=\"fa fa-edit\"></i> </a></td>\r\n\t\t\t\t\t<td align=center>{$hps}</td>\r\n\t\t\t\t\t";
        }
        echo "</tr>";
        ++$i;
    }
    /*echo "</table>\r\n \r\n\t\t</div></div></div>
                    </div>
                        </div>
                            </div>";*/
	echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</form>
					<!--end::Form-->
				</div>				
			</div>
		</div>
	</div>
	</div>
	</div>
	</div>
	";
}
else
{
    $errmesg = "Data Operator yang dicari tidak ada".$jid.$jnama.$jagama.$jtanggal.$jusia.$jkelamin.$jbidang.$jstatuspegawai.$jstatuspegawai2.$jstatuskerja.$jjabatan.$jjabatan2.$jgol.$jsubgol.$jpendidikan.$jstatusnikah.$jgoldarah.$jlokasi.$jlokasigaji.$jshift.$jstatusl.$jdivisi.$jpangkat.$jfungsional;
    $aksi = "";
}
?>
