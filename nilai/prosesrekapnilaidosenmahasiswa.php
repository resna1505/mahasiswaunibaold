<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

unset( $arraysort );
$arraysort[0] = "mahasiswa.ID";
$arraysort[1] = "mahasiswa.NAMA";
$vld[] = cekvaliditaskodeprodi( "Jurusan/Program Studi", $idprodi );
$vld[] = cekvaliditaskode( "Dosen Wali", $iddosen );
$vld[] = cekvaliditastahun( "Angkatan", $angkatan );
$vld[] = cekvaliditaskode( "NIM", $id );
$vld[] = cekvaliditasnama( "Nama", $nama );
$vld[] = cekvaliditaskode( "Status", $status );
$vld[] = cekvaliditasthnajaran( "Tahun/Semester", $tahun, $semester );
$vld[] = cekvaliditaskode( "Nilai M-K yang diambil", $nilaidiambil, 1 );
$vld[] = cekvaliditastanggal( "Tanggal Laporan", $tgllap['tgl'], $tgllap['bln'], $tgllap['thn'] );
$vld = array_filter( $vld, "filter_not_empty" );
if ( isset( $vld ) && 0 < count( $vld ) )
{
    $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
    $aksi = "";
}
else
{
    if ( $idprodi == "" )
    {
        $idprodi = $idprodi2;
		#$qfield .= " AND TAHUN = '{$tahun}'";
        
    }
	if ( $tahun != "" )
    {
        $qfield .= " AND TAHUN = '{$tahun}'";
        #$qjudul .= " Tahun Akademik '".( $tahun - 1 )."/{$tahun}' <br>";
        #$qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
        $href .= "tahun={$tahun}&";
    }
    if ( $iddosen != "" )
    {
        $qfield .= " AND dosenpengajar.iddosen = '{$iddosen}'";
        #$qjudul .= " Tahun Akademik '".( $tahun - 1 )."/{$tahun}' <br>";
        #$qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
        $href .= "iddosen={$iddosen}&";
    }
	
    if ( $semester != "" )
    {
        $qfield .= " AND dosenpengajar.SEMESTER = '{$semester}'";
        #$qjudul .= " Semester ".$arraysemester[$semester]." <br>";
        #$qinput .= " <input type=hidden name=semester value='{$semester}'>";
        $href .= "semester={$semester}&";
    }

    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT dosenpengajar.*,makul.NAMA AS NAMAMAKUL,dosen.NAMA AS NAMADOSEN FROM dosenpengajar,makul,dosen WHERE 1=1 ".
	"AND dosen.ID=dosenpengajar.IDDOSEN AND makul.ID=dosenpengajar.IDMAKUL AND dosenpengajar.IDPRODI='{$idprodi}' {$qfield} ORDER BY dosen.NAMA ASC";
	#echo $q.'<br>';
    $hp = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $hp ) )
    {
	#echo "aaa";exit();	
        echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\" {$border}>
							<thead>";
		echo "					<tr align=center class=juduldata>\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t\t<td>Dosen Pengajar</td><td>Total Mahasiswa</td><td>Total Nilai Mahasiswa</td></tr>
							</thead>
							<tbody>";
        
		$i = 1;
        	$semlama = "";
		while ( $dp = sqlfetcharray( $hp ) )
        {
            /*if ( $semlama != $dp[SEMESTER] )
            {
                $semlama = $dp[SEMESTER];
                echo "\r\n \t\t\t\t\t\t{$tmp}\r\n\t\t\t\t\t\t\t<tr class=juduldata>\r\n\t\t\t\t\t\t\t\t<td colspan=6>Semester {$dp['SEMESTER']}</td>\r\n\t\t\t\t\t\t\t</tr>";
            }*/
			//cek total mahasiswa
			$sqltotalmhs = "SELECT COUNT(mahasiswa.ID) AS total_mhs
			FROM mahasiswa,pengambilanmk
			WHERE 
			mahasiswa.ID=pengambilanmk.IDMAHASISWA 
			AND pengambilanmk.IDMAKUL='{$dp['IDMAKUL']}'
			AND pengambilanmk.TAHUN='{$dp['TAHUN']}'
			AND pengambilanmk.SEMESTER='{$dp['SEMESTER']}'
			AND pengambilanmk.KELAS='{$dp['KELAS']}'";
			#echo $sqltotalmhs.'<br>';
			$qtotalmhs = doquery($koneksi,$sqltotalmhs);
			$datatotalmhs=sqlfetcharray($qtotalmhs);
			$totalmhs=$datatotalmhs['total_mhs'];
			
			//cek total nilai mahasiswa
			$sqltotalnilaimhs = "SELECT COUNT(pengambilanmk.SIMBOL) AS total_nilai_mhs
			FROM mahasiswa,pengambilanmk
			WHERE 
			mahasiswa.ID=pengambilanmk.IDMAHASISWA
			AND pengambilanmk.IDMAKUL='{$dp['IDMAKUL']}'
			AND pengambilanmk.TAHUN='{$dp['TAHUN']}'
			AND pengambilanmk.SEMESTER='{$dp['SEMESTER']}' 
			AND pengambilanmk.KELAS='{$dp['KELAS']}'
			AND SIMBOL!=''";
			#echo $sqltotalnilaimhs.'<br>';
			$qtotalnilaimhs = doquery($koneksi,$sqltotalnilaimhs);
			$datatotalnilaimhs=sqlfetcharray($qtotalnilaimhs);
			$totalnilaimhs=$datatotalnilaimhs['total_nilai_mhs'];
			#$totalnilaimhs=sqlnumrows($qtotalnilaimhs);
			#echo "TOTAL MHS=".$totalmhs.'<br>';
			#echo "TOTAL NILAI MHS=".$totalnilaimhs.'<br>';
			if($totalmhs>$totalnilaimhs){
				
				$styleerror = "style='background-color:#ffaaaa'";
			
			}else{
			
				$styleerror = "";
			}
            $kelas = kelas( $i );
            echo "\r\n\t\t\t\t\t<tr class=dataganjilcetak align=center {$kelas} {$styleerror}>\r\n\t\t\t\t\t\t<td>{$i}\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td>{$dp['IDMAKUL']}</td>\r\n\t\t\t\t\t\t<td align=left>{$dp['NAMAMAKUL']}</td>\r\n\t\t\t\t\t\t<td>{$dp['NAMADOSEN']}</td><td>{$totalmhs}</td><td>{$totalnilaimhs}</td></tr>\r\n\t\t\t\t";
            ++$i;
        }
        echo "				</tbody>
						</table>
					</div>
				</div>
			</div>
		</form>";

    }
    else
    {
        $errmesg = "Data Mahasiswa Tidak Ada";
        $aksi = "";
    }
}
?>
