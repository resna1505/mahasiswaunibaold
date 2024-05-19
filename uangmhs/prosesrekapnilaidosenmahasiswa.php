<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
periksaroot();
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
$q = "SELECT dosenpengajar.*,makul.NAMA AS NAMAMAKUL,dosen.NAMA AS NAMADOSEN FROM dosenpengajar,makul,dosen WHERE 1=1 ".
	"AND dosen.ID=dosenpengajar.IDDOSEN AND makul.ID=dosenpengajar.IDMAKUL AND dosenpengajar.IDPRODI='{$idprodi}' {$qfield} ORDER BY dosen.NAMA ASC";
	#echo $q.'<br>';
    $hp = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $hp ) <= 0 )
    {
        printmesg( "Data Mata Kuliah Jurusan/Program Studi  '".$arrayprodidep[$idprodi]."' Tidak Ada" );
    }
    else
    {        
        #echo "\r\n\t\t\t\r\n\t\t\t\t<table class=data>\r\n\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t<td colspan=6 align=right>\r\n\t\t\t\t\t<input type=submit name=aksi2 class=masukan value='Tampilkan'>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t\t<tr align=center class=juduldata>\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t\t<td>SKS</td>\r\n \t\t\t\t\t<td>Pilih</td>\r\n\t\t\t\t</tr>\r\n\t\t\t";
        
		echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\" {$border}>
							<thead>";
		if($aksi2=='Cetak'){					
		echo "					<tr align=center class=juduldata><td colspan=7 align=left><input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak'>\r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>";
		}
		echo "<tr align=center class=dataganjilcetak>\r\n\t\t\t\t\t<td>No</td>\r\n\t\t\t\t\t<td>Kode</td>\r\n\t\t\t\t\t<td>Nama Mata Kuliah</td>\r\n\t\t\t\t\t<td>Dosen Pengajar</td><td>Total Mahasiswa</td><td>Total Nilai Mahasiswa</td></tr>
							</thead>
							<tbody>";
        
		$i = 1;
        $semlama = "";
        while ( $dp = sqlfetcharray( $hp ) )
        {
           
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
			$qtotalmhs = mysqli_query($koneksi,$sqltotalmhs);
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
			$qtotalnilaimhs = mysqli_query($koneksi,$sqltotalnilaimhs);
			$datatotalnilaimhs=sqlfetcharray($qtotalnilaimhs);
			$totalnilaimhs=$datatotalnilaimhs['total_nilai_mhs'];
			#$totalnilaimhs=sqlnumrows($qtotalnilaimhs);
			if($totalmhs>$totalnilaimhs){
				
				$styleerror = "style='background-color:#ffaaaa'";
			
			}else{
				$styleerror = "";
			
			}
            $kelas = kelas( $i );
            echo "<tr class=dataganjilcetak align=center {$kelas} {$styleerror}>\r\n\t\t\t\t\t\t<td>{$i}\r\n\t\t\t\t\t\t</td>\r\n\t\t\t\t\t\t<td>{$dp['IDMAKUL']}</td>\r\n\t\t\t\t\t\t<td align=left>{$dp['NAMAMAKUL']}</td>\r\n\t\t\t\t\t\t<td>{$dp['NAMADOSEN']}</td><td>{$totalmhs}</td><td>{$totalnilaimhs}</td></tr>";
            ++$i;
        }
        echo "				</tbody>
						</table>
					</div>
				</div>
			</div>
		";
    }
?>
