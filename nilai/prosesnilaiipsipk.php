<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo "lll";exit();
periksaroot( );
$batasstudi = 14;
include( "fungsinilai.php" );
if ( 0 )
{
    $errmesg = token_err_mesg( "Nilai IPS/IPK", CARI_DATA );
    $aksi = "";
}
else
{
    unset( $_SESSION['token'] );
    $vld[] = cekvaliditaskodeprodi( "Jurusan/Program Studi", $idprodi );
    $vld[] = cekvaliditaskode( "Dosen Wali", $iddosen );
    $vld[] = cekvaliditastahun( "Angkatan", $angkatan );
    $vld[] = cekvaliditaskode( "NIM", $id );
    $vld[] = cekvaliditasnama( "Nama", $nama );
    $vld[] = cekvaliditaskode( "Status", $status );
    $vld[] = cekvaliditasthnajaran( "Tahun/Semester", $tahun, $semester );
    $vld[] = cekvaliditaskode( "Nilai M-K yang diambil", $nilaidiambil, 1 );
    $vld[] = cekvaliditaskode( "Perlakuan terhadap nilai kosong", $nilaikosong, 1 );
    $vld[] = cekvaliditasinteger( "Data perhalaman", $dataperhalaman, 4 );
    $vld = array_filter( $vld, "filter_not_empty" );
    if ( isset( $vld ) && 0 < count( $vld ) )
    {
        $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
        $aksi = "";
    }
    else
    {
        $href .= "index.php?dataperhalaman={$dataperhalaman}&pilihan={$pilihan}&aksi={$aksi}&tgllap[tgl]={$tgllap['tgl']}&tgllap[bln]={$tgllap['bln']}&tgllap[thn]={$tgllap['thn']}&nilaidiambil={$nilaidiambil}&nilaikosong={$nilaikosong}&sp={$sp}&simpanipk={$simpanipk}&";
        if ( $idprodi != "" )
        {
            $qfield .= " AND IDPRODI='{$idprodi}'";
            $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
            $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
            $href .= "idprodi={$idprodi}&";
        }
        if ( $iddosen != "" )
        {
            $qfield .= " AND IDDOSEN='{$iddosen}'";
            $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
            $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
            $href .= "iddosen={$iddosen}&";
        }
        if ( $angkatan != "" )
        {
            $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
            $qjudul .= " Angkatan '{$angkatan}' <br>";
            $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
            $href .= "angkatan={$angkatan}&";
        }
        if ( $id != "" )
        {
            $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
            $qjudul .= " NIM mengandung kata '{$id}' <br>";
            $qinput .= " <input type=hidden name=id value='{$id}'>";
            $href .= "id={$id}&";
        }
        if ( $nama != "" )
        {
            $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
            $qjudul .= " Nama mengandung kata '{$nama}' <br>";
            $qinput .= " <input type=hidden name=nama value='{$nama}'>";
            $href .= "nama={$nama}&";
        }
        if ( $status != "" )
        {
            $qfield .= " AND mahasiswa.STATUS='{$status}'";
            $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
            $qinput .= " <input type=hidden name=status value='{$status}'>";
            $href .= "status={$status}&";
        }
        $qjudul .= "Tahun ajaran: ".( $tahun - 1 )."/{$tahun} ".$arraysemester[$semester]."<br>";
        if ( $sort == "" )
        {
            $sort = " mahasiswa.ID";
        }
        if ( $tahun != "" )
        {
            $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
            $href .= "tahun={$tahun}&";
        }
        $qinput .= " <input type=hidden name=semester value='{$semester}'>";
        if ( $semester == "" )
        {
            $semester = 1;
        }
        $href .= "semester={$semester}&";
        $qinput .= " <input type=hidden name=sort value='{$sort}'>";
        $q = "SELECT COUNT(*) AS JML FROM mahasiswa,prodi,departemen  \r\n\tWHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n \t{$qfieldx1} \r\n\t";
        $h = doquery($koneksi,$q );
        $d = sqlfetcharray( $h );
        $total = $d[JML];
        $first = 0;
        if ( 0 + $dataperhalaman <= 0 )
        {
            $dataperhalaman = 1;
        }
        $maxdata = $dataperhalaman;
        include( "../paginating.php" );
        $q = "SELECT mahasiswa.*,prodi.SKSMIN , \r\n\tprodi.IDDEPARTEMEN, \tprodi.TINGKAT,\r\n\tdepartemen.IDFAKULTAS \r\n\tFROM mahasiswa,prodi,departemen  \r\n\tWHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n\t{$qfieldx1}\r\n\tORDER BY {$sort} {$qlimit}";
        $h = doquery($koneksi,$q );
        if ( 0 < sqlnumrows( $h ) )
        {
            #printjudulmenu( "Proses Nilai IPS/IPK untuk disimpan di TRAKM" );
            #printmesg( $qjudul );
            #echo "{$tpage} {$tpage2}";
            $totalsemua = 0;
            $bobotsemua = 0;
            $totals = "";
            $bobots = "";
            /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Proses Nilai IPS/IPK untuk disimpan di TRAKM </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
		echo "	<div class=\"page-content\">
					<div class=\"container-fluid\">
						<div class=\"row\">
							<div class=\"col-md-12\">
								<!-- BEGIN SAMPLE FORM PORTLET-->
								";
										printmesg( $errmesg );
										 printmesg( $qjudul );
		echo "						<div class='portlet-title'>";
										printmesg("Proses Nilai IPS/IPK untuk disimpan di TRAKM");
		echo "						</div>
								<div class=\"m-portlet\">
				
									<div class=\"m-section__content\">
                                        <div class=\"table-responsive\">";
            
            echo "{$tpage} {$tpage2}";
            echo "            
											<table class=\"table table-bordered table-hover\">
												<thead>";
            echo "									<tr class=juduldata align=center>\r\n        <td rowspan=2>No</td>\r\n        <td rowspan=2>ID/NIM</td>\r\n        <td rowspan=2>Nama</td>\r\n        <td rowspan=2>Angkatan</td>\r\n        <td rowspan=2>Semester</td>\r\n        <td colspan=4>Data TRAKM</td>\r\n        <td colspan=4>Hasil dari KRS</td>\r\n        <td rowspan=2>Status</td>\r\n        <td rowspan=2>Ket</td>\r\n      </tr>\r\n      <tr class=juduldata align=center>\r\n         <td >IPS</td>\r\n        <td >SKS Semester</td>\r\n        <td >IPK</td>\r\n        <td >SKS Total</td>\r\n         <td >IPS</td>\r\n        <td >SKS Semester</td>\r\n        <td >IPK</td>\r\n        <td >SKS Total</td>\r\n       </tr>\r\n      ";
            echo "								</thead>
												<tbody>";
			$i = 0;
            while ( $d = sqlfetcharray( $h ) )
            {
                $totalsemua = 0;
                $bobotsemua = 0;
                $totals = "";
                $bobots = "";
                $batasstudimhs = $batasstudi;
                $semesterhitung = $kurawal = $kurakhir = "";
                if ( $semester != 3 )
                {
                    $semesterhitung = ( $tahun - 1 - $d[ANGKATAN] ) * 2 + $semester;
                    $kurawal = "(";
                    $kurakhir = ")";
                }
                $idmahasiswa = $d[ID];
                $sem = $semester;
                $tahunlama = $tahun;
                $angkatanmhs = $d[ANGKATAN];
                $idmahasiswa = $d[ID];
                $batasstudimhs += get_jumlah_cuti_mahasiswa( $idmahasiswa, $tahun - 1, $semester );
                $ipkmhs = "";
                $sksmhs = "";
                $ipsemmhs = "";
                $skssemmhs = "";
                $ket = "";
                $status = "Tidak tersimpan";
                $stylewarna = "style='background-color:#FFFF00;'";
                $q = "SELECT NLIPSTRAKM,NLIPKTRAKM,SKSTTTRAKM,SKSEMTRAKM FROM trakm WHERE NIMHSTRAKM='{$idmahasiswa}'   AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'";
                unset( $d2 );
                $h2 = doquery($koneksi,$q );
                if ( 0 < sqlnumrows( $h2 ) )
                {
                    $d2 = sqlfetcharray( $h2 );
                }
                if ( 0 < $semesterhitung && $semesterhitung <= $batasstudimhs )
                {
                    $arrayipsmhs = getips( $d[ID], $tahun, $semester, $nilaidiambil, $nilaikosong );
                    $ipsemmhs = $arrayipsmhs[0];
                    $skssemmhs = $arrayipsmhs[1];
                    $arrayipkmhs = getipk( $d[ID], $tahun, $semester, $nilaidiambil, $nilaikosong );
                    $ipkmhs = $arrayipkmhs[0];
                    $sksmhs = $arrayipkmhs[1];
                    if ( 0 < $skssemmhs )
                    {
                        if ( $simpanipk == 1 )
                        {
                            include( "../makul/edittrakm.php" );
                            $q = "UPDATE trakm SET NLIPSTRAKM='".number_format_sikad( $ipsemmhs, 2 )."', NLIPKTRAKM='".number_format_sikad( $ipkmhs, 2 )."', SKSTTTRAKM='{$sksmhs}',SKSEMTRAKM='{$skssemmhs}' WHERE  NIMHSTRAKM='{$idmahasiswa}' AND THSMSTRAKM='".( $tahunlama - 1 )."{$sem}'";
                            #echo "UPDATE IPS / IPK=".$q.'<br>';
			    doquery($koneksi,$q );
                            $ketlog = "Edit IPS/IPK, Mahasiswa {$idmahasiswa}, TAHUN=".( $tahunlama - 1 )."/{$tahunlama}, SEM={$sem}, IPS={$ipsemmhs}, IPK={$ipkmhs}, SKSSEM={$skssemmhs}, SKSTOT={$sksmhs}";
                            buatlog( 59 );
                            $status = "Tersimpan";
                            $stylewarna = "";
                        }
                        else
                        {
                            $ket = "Hanya dilihat";
                        }
                    }
                    else
                    {
                        $ket = "SKS semester = 0";
                    }
                }
                else
                {
                    $ket = "Semester < 0 atau Semester > {$batasstudimhs}";
                }
                ++$i;
                echo "<tr {$stylewarna}>\r\n        <td align=center>{$i}</td>\r\n        <td >{$d['ID']}</td>\r\n        <td >{$d['NAMA']}</td>\r\n        <td align=center>{$d['ANGKATAN']}</td>\r\n        <td align=center>{$semesterhitung}</td>\r\n\r\n        <td align=center>".number_format_sikad( $d2[NLIPSTRAKM], 2 )."</td>\r\n        <td align=center>{$d2['SKSEMTRAKM']}</td>\r\n        <td align=center>".number_format_sikad( $d2[NLIPKTRAKM], 2 )."</td>\r\n        <td align=center >{$d2['SKSTTTRAKM']}</td>\r\n\r\n\r\n        <td align=center>".number_format_sikad( $ipsemmhs, 2 )."</td>\r\n        <td align=center>{$skssemmhs}</td>\r\n        <td align=center>".number_format_sikad( $ipkmhs, 2 )."</td>\r\n        <td align=center >{$sksmhs}</td>\r\n        <td align=center >{$status}</td>\r\n        <td  >{$ket}</td>\r\n      </tr>";
            }
            #echo "</table></div></div>{$tpage} {$tpage2}</div></div></div>";
			 echo "								</tbody>
											</table>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>";
        }
        else
        {
            $errmesg = "Data mahasiswa tidak ada";
            $aksi = "";
        }
    }
}
?>
