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
$arraysort[0] = "bayarkomponen.IDMAHASISWA";
$arraysort[1] = "mahasiswa.NAMA";
$arraysort[2] = "bayarkomponen.IDKOMPONEN";
$arraysort[3] = "bayarkomponen.BIAYA";
$arraysort[4] = "bayarkomponen.JUMLAH";
$arraysort[5] = "bayarkomponen.TAHUNAJARAN";
$href = "index.php?pilihan={$pilihan}&aksi=Tampilkan&";
$jenisbayar=1;
if ( $jenisusers == 3 || $jenisusers == 2 )
{
    $idmahasiswa = $users;
}
if ( $idmahasiswa != "" )
{
    $qfield .= " AND IDMAHASISWA LIKE '%{$idmahasiswa}%'";
    $qjudul .= " NIM  '{$idmahasiswa}' <br>";
    $qinput .= " <input type=hidden name=idmahasiswa value='{$idmahasiswa}'>";
    $href .= "idmahasiswa={$idmahasiswa}&";
}
if ( $angkatan != "" )
{
    $qfield .= " AND mahasiswa.ANGKATAN = '{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
if ( $idprodi != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI = '{$idprodi}'";
    $qjudul .= " Prodi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $istglbayar == 1 )
{
    $qfield .= "\r\n \t\t\tAND \r\n \t\t\t(\r\n \t\t\t\tTANGGALBAYAR >= DATE_FORMAT('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','%Y-%m-%d')\r\n \t\t\t\tAND\r\n \t\t\t\tTANGGALBAYAR <= DATE_FORMAT('{$tglbayar2['thn']}-{$tglbayar2['bln']}-{$tglbayar2['tgl']}','%Y-%m-%d')\r\n \t\t\t)\r\n \t\t";
    $qjudul .= " Tanggal bayar antara  {$tglbayar['tgl']}-{$tglbayar['bln']}-{$tglbayar['thn']} s.d\r\n\t\t {$tglbayar2['tgl']}-{$tglbayar2['bln']}-{$tglbayar2['thn']} \r\n\t\t <br>";
    $qinput .= " \r\n\t\t\t<input type=hidden name=istglbayar value='{$istglbayar}'>\r\n\t\t\t<input type=hidden name=tglbayar[thn] value='{$tglbayar['thn']}'>\r\n\t\t\t<input type=hidden name=tglbayar[bln] value='{$tglbayar['bln']}'>\r\n\t\t\t<input type=hidden name=tglbayar[tgl] value='{$tglbayar['tgl']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[thn] value='{$tglbayar2['thn']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[bln] value='{$tglbayar2['bln']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[tgl] value='{$tglbayar2['tgl']}'>\r\n\t\t";
    $href .= "istglbayar={$istglbayar}&tglbayar[tgl]={$tglbayar['tgl']}&tglbayar[bln]={$tglbayar['bln']}&tglbayar[thn]={$tglbayar['thn']}&\r\n\t\ttglbayar2[tgl]={$tglbayar2['tgl']}&tglbayar2[bln]={$tglbayar2['bln']}&tglbayar2[thn]={$tglbayar2['thn']}&istglbayar={$istglbayar}&";
}
if ( $istglentri == 1 )
{
    $qfield .= "\r\n \t\t\tAND \r\n \t\t\t(\r\n \t\t\t\tbayarkomponen.TANGGAL >= DATE_FORMAT('{$tglentri['thn']}-{$tglentri['bln']}-{$tglentri['tgl']}','%Y-%m-%d')\r\n \t\t\t\tAND\r\n \t\t\t\tbayarkomponen.TANGGAL <= DATE_FORMAT('{$tglentri2['thn']}-{$tglentri2['bln']}-{$tglentri2['tgl']}','%Y-%m-%d')\r\n \t\t\t)\r\n \t\t";
    $qjudul .= " Tanggal entri antara  {$tglentri['tgl']}-{$tglentri['bln']}-{$tglentri['thn']} s.d\r\n\t\t {$tglentri2['tgl']}-{$tglentri2['bln']}-{$tglentri2['thn']} \r\n\t\t <br>";
    $qinput .= " \r\n\t\t\t<input type=hidden name=istglentri value='{$istglentri}'>\r\n\t\t\t<input type=hidden name=tglentri[thn] value='{$tglentri['thn']}'>\r\n\t\t\t<input type=hidden name=tglentri[bln] value='{$tglentri['bln']}'>\r\n\t\t\t<input type=hidden name=tglentri[tgl] value='{$tglentri['tgl']}'>\r\n\t\t\t<input type=hidden name=tglentri2[thn] value='{$tglentri2['thn']}'>\r\n\t\t\t<input type=hidden name=tglentri2[bln] value='{$tglentri2['bln']}'>\r\n\t\t\t<input type=hidden name=tglentri2[tgl] value='{$tglentri2['tgl']}'>\r\n\t\t";
    $href .= "istglentri={$istglentri}&tglentri[tgl]={$tglentri['tgl']}&tglentri[bln]={$tglentri['bln']}&tglentri[thn]={$tglentri['thn']}&\r\n\t\ttglentri2[tgl]={$tglentri2['tgl']}&tglentri2[bln]={$tglentri2['bln']}&tglentri2[thn]={$tglentri2['thn']}&";
}
if ( $carabayar != "" )
{
    $qfield .= " AND CARABAYAR = '{$carabayar}'";
    $qjudul .= " Cara Bayar : ".$arraycarabayar[$carabayar]." <br>";
    $qinput .= " <input type=hidden name=carabayar value='{$carabayar}'>";
    $href .= "carabayar={$carabayar}&";
}
if ( $idkomponen != "" )
{
    $qfield .= " AND bayarkomponen.IDKOMPONEN = '{$idkomponen}'";
    $qjudul .= " Komponen Pembayaran : '".$arraykomponenpembayaran2[$idkomponen]."' <br>";
    $qinput .= " <input type=hidden name=idkomponen value='{$idkomponen}'>";
    $href .= "idkomponen={$idkomponen}&";
    if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
    {
        if ( $tahunajaran != "" )
        {
            $qfield .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunajaran}'";
            $qjudul .= " Tahun Akademik '".( $tahunajaran - 1 )."/{$tahunajaran}' <br>";
            $qinput .= " <input type=hidden name=tahunajaran value='{$tahunajaran}'>";
            $href .= "tahunajaran={$tahunajaran}&";
        }
    }
    else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
    {
        if ( $semesterbayar != "" )
        {
            $qfield .= " AND bayarkomponen.SEMESTER = '{$semesterbayar}'";
            $qjudul .= " Semester '".$arraysemester[$semesterbayar]."' <br>";
            $qinput .= " <input type=hidden name=semesterbayar value='{$semesterbayar}'>";
            $href .= "semesterbayar={$semesterbayar}&";
        }
        if ( $tahunajaran2 != "" )
        {
            $qfield .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunajaran2}'";
            $qjudul .= " Tahun Akademik '".( $tahunajaran2 - 1 )."/{$tahunajaran2}' <br>";
            $qinput .= " <input type=hidden name=tahunajaran2 value='{$tahunajaran2}'>";
            $href .= "tahunajaran2={$tahunajaran2}&";
        }
    }
    else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
    {
        if ( $semesterbayarc != "" )
        {
            $qfield .= " AND bayarkomponen.SEMESTER = '{$semesterbayarc}'";
            $qjudul .= " Semester '".$arraysemester[$semesterbayarc]."' <br>";
            $qinput .= " <input type=hidden name=semesterbayarc value='{$semesterbayarc}'>";
            $href .= "semesterbayarc={$semesterbayarc}&";
        }
        if ( $tahunajaran2c != "" )
        {
            $qfield .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunajaran2c}'";
            $qjudul .= " Tahun Akademik '".( $tahunajaran2c - 1 )."/{$tahunajaran2c}' <br>";
            $qinput .= " <input type=hidden name=tahunajaran2c value='{$tahunajaran2c}'>";
            $href .= "tahunajaran2c={$tahunajaran2c}&";
        }
    }
    else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
    {
        if ( $semesterbayar2 != "" )
        {
            $qfield .= " AND bayarkomponen.SEMESTER = '{$semesterbayar2}'";
            $qjudul .= " Bulan/Tahun ".$arraybulan[$semesterbayar2 - 1]."  ";
            $qinput .= " <input type=hidden name=semesterbayar2 value='{$semesterbayar2}'>";
            $href .= "semesterbayar2={$semesterbayar2}&";
        }
        if ( $tahunajaran2 != "" )
        {
            $qfield .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunajaran2}'";
            $qjudul .= " Tahun : {$tahunajaran2} <br>";
            $qinput .= " <input type=hidden name=tahunajaran2 value='{$tahunajaran2}'>";
            $href .= "tahunajaran2={$tahunajaran2}&";
        }
    }
}
if ( $jenisbayar == 1 )
{
    $qjudul .= " Status:  Lunas ";
    $jcicil = "<=";
}
else
{
    $qjudul .= " Status: Belum Lunas ";
    $jcicil = ">";
}
$qinput .= " <input type=hidden name=jenisbayar value='{$jenisbayar}'>";
$href .= "jenisbayar={$jenisbayar}&";
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
{
    $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS=mahasiswa.JENISKELAS ";
}
else
{
    $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS='' ";
}
#$q = "SELECT SUM(bayarkomponen.JUMLAH+bayarkomponen.DISKON) AS JUMLAH ,\r\n\t  (biayakomponen.BIAYA*(100-bayarkomponen.BEASISWA)/100) AS BIAYA,\r\n\t  bayarkomponen.IDMAHASISWA,\r\n\t  bayarkomponen.SEMESTER,\r\n\t  bayarkomponen.TAHUNAJARAN,\r\n\t  bayarkomponen.BEASISWA,\r\n\t  DATE_FORMAT(bayarkomponen.TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR,\r\n\t mahasiswa.NAMA\r\n\t{$field99} , \r\n\tkomponenpembayaran.JENIS,\r\n\tkomponenpembayaran.ID AS IDKOMPONEN\r\n\tFROM bayarkomponen , mahasiswa,komponenpembayaran,biayakomponen \r\n\tWHERE \r\n\tbayarkomponen.IDMAHASISWA=mahasiswa.ID AND\r\n\tkomponenpembayaran.ID=biayakomponen.IDKOMPONEN AND \r\n\tmahasiswa.IDPRODI=biayakomponen.IDPRODI AND \r\n\tmahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND \r\n\tmahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND \r\n\tbayarkomponen.IDKOMPONEN=komponenpembayaran.ID   {$qfieldjeniskelasm}\r\n\t\r\n\t {$qfield}\r\n\t {$where992}\r\n\t GROUP BY bayarkomponen.IDMAHASISWA,bayarkomponen.IDKOMPONEN,\r\n\t bayarkomponen.TAHUNAJARAN,bayarkomponen.SEMESTER   \r\n\t HAVING ( BIAYA {$jcicil} JUMLAH AND IDKOMPONEN!='99' AND IDKOMPONEN!='98')\r\n\t OR ( IDKOMPONEN='99' OR IDKOMPONEN='98'  )\r\n\tORDER BY ".$arraysort[$sort]."";
#echo $q;
#$q="SELECT SUM(bayarkomponen.JUMLAH+bayarkomponen.DISKON) AS JUMLAH , (biayakomponen.BIAYA*(100-bayarkomponen.BEASISWA)/100) AS BIAYA, bayarkomponen.IDMAHASISWA, bayarkomponen.SEMESTER, bayarkomponen.TAHUNAJARAN, bayarkomponen.BEASISWA, DATE_FORMAT(bayarkomponen.TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR, mahasiswa.NAMA ,komponenpembayaran.NAMA NAMAKOMPONEN , komponenpembayaran.JENIS, komponenpembayaran.ID AS IDKOMPONEN FROM bayarkomponen , mahasiswa,komponenpembayaran,biayakomponen WHERE bayarkomponen.IDMAHASISWA=mahasiswa.ID AND komponenpembayaran.ID=biayakomponen.IDKOMPONEN AND mahasiswa.IDPRODI=biayakomponen.IDPRODI AND mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND bayarkomponen.IDKOMPONEN=komponenpembayaran.ID AND biayakomponen.JENISKELAS='' AND IDMAHASISWA LIKE '%{$idupdate}%' GROUP BY bayarkomponen.IDMAHASISWA,bayarkomponen.IDKOMPONEN, bayarkomponen.TAHUNAJARAN,bayarkomponen.SEMESTER HAVING ( BIAYA <= JUMLAH AND IDKOMPONEN!='99' AND IDKOMPONEN!='98') OR ( IDKOMPONEN='99' OR IDKOMPONEN='98' ) ORDER BY bayarkomponen.IDMAHASISWA"; 
$q="SELECT SUM(bayarkomponen.JUMLAH+bayarkomponen.DISKON) AS JUMLAH , (biayakomponen.BIAYA*(100-bayarkomponen.BEASISWA)/100) AS BIAYA, bayarkomponen.IDMAHASISWA, bayarkomponen.SEMESTER, bayarkomponen.TAHUNAJARAN, bayarkomponen.BEASISWA, DATE_FORMAT(bayarkomponen.TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR, mahasiswa.NAMA ,komponenpembayaran.NAMA NAMAKOMPONEN , komponenpembayaran.JENIS, komponenpembayaran.ID AS IDKOMPONEN FROM bayarkomponen , mahasiswa,komponenpembayaran,biayakomponen WHERE bayarkomponen.IDMAHASISWA=mahasiswa.ID AND komponenpembayaran.ID=biayakomponen.IDKOMPONEN AND mahasiswa.IDPRODI=biayakomponen.IDPRODI AND mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND bayarkomponen.IDKOMPONEN=komponenpembayaran.ID AND biayakomponen.JENISKELAS='' AND IDMAHASISWA LIKE '%{$idupdate}%' GROUP BY bayarkomponen.IDMAHASISWA,bayarkomponen.IDKOMPONEN, bayarkomponen.TAHUNAJARAN,bayarkomponen.SEMESTER ORDER BY bayarkomponen.IDMAHASISWA"; 

#echo $q;
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    /*if ( $aksi != "cetak" )
    {
        printjudulmenu( "Laporan Keuangan : Mahasiswa yg Sudah Membayar" );
        printmesg( $qjudul );
        printmesg( $errmesg );
    }
    else
    {
        printjudulmenucetak( "Laporan Keuangan : Mahasiswa yg Sudah Membayar" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaklaporan1.php'>\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }*/
	echo "<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover\">
							<thead>";
    echo "						<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td>NIM</td>\r\n\t\t\t\t<td>Nama<br>Mahasiswa</td>";
    echo "\r\n\t\t\t\t<td>Bulan/Sem/<br>Tahun<br>Ajaran</td>";
    if ( $idkomponen == "" )
    {
        echo "\r\n\t\t\t\t\t<td>Komponen</td>";
    }
    #echo "\r\n \t\t\t\t<td>Biaya<br>Rp.</td>\r\n \t\t\t\t<td>Jumlah<br>Bayar Rp.</td>";
    echo "<td>Jumlah<br>Bayar Rp.</td>";	
    if ( $jenisbayar != 1 )
    {
        echo "\r\n \t\t\t\t\t\t<td>Sisa<br>Rp.</td>\r\n \t\t\t\t\t";
    }
    echo "						</tr>";   
	echo "					</thead>
							<tbody>";	
	$i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $tmp = explode( "-", $d['TANGGALBAYAR'] );
        $tglbayar['tgl'] = $tmp[2];
        $tglbayar['bln'] = $tmp[1];
        $tglbayar['thn'] = $tmp[0];
        if ( $d['IDKOMPONEN'] == "99" )
        {
			#echo "IDKOMPONEN=".$d['IDKOMPONEN'].'<br>';
            $jumlahsks = getjumlahsks( $d['IDMAHASISWA'], $d['TAHUNAJARAN'], $d['SEMESTER'] );
            $jumlahskswajib = getjumlahskswajib( $d['IDMAHASISWA'], $d['TAHUNAJARAN'], $d['SEMESTER'] );
            $skslebih = 0;
            if ( $jumlahskswajib < $jumlahsks )
            {
                $skslebih = $jumlahsks - $jumlahskswajib;
            }
            $biayakomponen = $d['BIAYA'] + 0;
            $biaya = $skslebih * $biayakomponen;
            $d['BIAYA'] = $biaya;
            if ( $d['JUMLAH'] < $d['BIAYA'] )
            {
                if ( $jenisbayar == 1 )
                {
                    continue;
                }
            }
        }
        #if ( !( $jenisbayar != 1 ) || $d['IDKOMPONEN'] == "98" )
		if ($d['IDKOMPONEN'] == "98" )	
        {
			#echo "IDKOMPONEN=".$d['IDKOMPONEN'].'<br>';
            $jumlahsks = getjumlahskssp( $d['IDMAHASISWA'], $d['TAHUNAJARAN'], $d['SEMESTER'] );
            $jumlahskswajib = 0;
            $skslebih = 0;
            if ( $jumlahskswajib < $jumlahsks )
            {
                $skslebih = $jumlahsks - $jumlahskswajib;
            }
            $biayakomponen = $d['BIAYA'] + 0;
            $biaya = $skslebih * $biayakomponen;
            $d['BIAYA'] = $biaya;
            if ( $d['JUMLAH'] < $d['BIAYA'] )
            {
                if ( $jenisbayar == 1 )
                {
                    continue;
                }
            }
        }
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} valign=top>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['IDMAHASISWA']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>";
        echo "\r\n \t\t\t\t\t<td align=center nowrap>";
        if ( $d['JENIS'] == 2 )
        {
            echo ( $d['TAHUNAJARAN'] - 1 )."/{$d['TAHUNAJARAN']}";
        }
        else if ( $d['JENIS'] == 3 )
        {
            echo $arraysemester[$d['SEMESTER']]." ".( $d['TAHUNAJARAN'] - 1 )."/{$d['TAHUNAJARAN']}";
        }
        else if ( $d['JENIS'] == 6 )
        {
            echo $arraysemester[$d['SEMESTER']]." ".( $d['TAHUNAJARAN'] - 1 )."/{$d['TAHUNAJARAN']}";
        }
        else if ( $d['JENIS'] == 5 )
        {
            echo $arraybulan[$d['SEMESTER'] - 1]." {$d['TAHUNAJARAN']}";
        }
        else
        {
            echo "-";
        }
        echo "</td>\r\n   \t\t\t\t";
		if ( !( $jenisbayar != 1 ) || $idkomponen == "" )
        {
            echo "\r\n\t\t\t\t\t<td align=left>{$d['NAMAKOMPONEN']}</td>";
        }
        #echo "\r\n  \t\t\t\t\t<td align=right>".cetakuang( $d['BIAYA'] )." </td>\r\n  \t\t\t\t\t<td align=right>".cetakuang( $d['JUMLAH'] )."</td>";
	echo "<td align=right>".cetakuang( $d['JUMLAH'] )."</td>";
        if ( $jenisbayar != 1 )
        {
            echo "\r\n\t \t\t\t\t\t\t<td align=right>".cetakuang( $d['BIAYA'] - $d['JUMLAH'] )."</td>\r\n\t \t\t\t\t\t";
        }
        
        echo "</tr>";
        $totalbayar += $d['JUMLAH'];
        $totalsisa += $d['BIAYA'] - $d['JUMLAH'];
        ++$i;
    }
    echo "\r\n\t\t\t<tr>\r\n\t\t\t\t<td align=right colspan=5><b>Total</td>\r\n\t\t\t\t<td align=right><b>".cetakuang( $totalbayar )."</td>";
    if ( $jenisbayar != 1 )
    {
        echo "\r\n\t \t\t\t\t\t\t<td align=right><b>".cetakuang( $totalsisa )."</td>\r\n\t \t\t\t\t\t";
    }
    #echo "\r\n\t\t\t</tr>\r\n\t\t</table>";
	echo "								</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::m-portlet-->
				</div>
				<!--end::portlet-body-->
			</div>
			<!--end::m-portlet__body-->
		</form>
	</div>";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Laporan Keuangan Tidak Ada";
    $aksi = "";
}
?>
