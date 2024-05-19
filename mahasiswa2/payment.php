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

#$q="SELECT SUM(bayarkomponen.JUMLAH+bayarkomponen.DISKON) AS JUMLAH , (biayakomponen.BIAYA*(100-bayarkomponen.BEASISWA)/100) AS BIAYA, bayarkomponen.IDMAHASISWA, bayarkomponen.SEMESTER, bayarkomponen.TAHUNAJARAN, bayarkomponen.BEASISWA, DATE_FORMAT(bayarkomponen.TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR, mahasiswa.NAMA ,komponenpembayaran.NAMA NAMAKOMPONEN , komponenpembayaran.JENIS, komponenpembayaran.ID AS IDKOMPONEN FROM bayarkomponen , mahasiswa,komponenpembayaran,biayakomponen WHERE bayarkomponen.IDMAHASISWA=mahasiswa.ID AND komponenpembayaran.ID=biayakomponen.IDKOMPONEN AND mahasiswa.IDPRODI=biayakomponen.IDPRODI AND mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND bayarkomponen.IDKOMPONEN=komponenpembayaran.ID AND biayakomponen.JENISKELAS='' AND IDMAHASISWA LIKE '%{$idupdate}%' GROUP BY bayarkomponen.IDMAHASISWA,bayarkomponen.IDKOMPONEN, bayarkomponen.TAHUNAJARAN,bayarkomponen.SEMESTER ORDER BY bayarkomponen.IDMAHASISWA"; 
$q = "SELECT bayarkomponen.*,biayakomponen.BIAYA AS BIAYA2,IF(DATE(bayarkomponen.TANGGAL)=CURDATE(),1,0) AS STATUSTANGGAL,
DATE_FORMAT(TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR,biayakomponen.ANGKATAN,biayakomponen.IDPRODI,biayakomponen.GELOMBANG FROM bayarkomponen,biayakomponen ,mahasiswa WHERE bayarkomponen.STATUSBAYAR=0 
AND mahasiswa.ID=bayarkomponen.IDMAHASISWA AND mahasiswa.ANGKATAN=biayakomponen.ANGKATAN 
AND mahasiswa.IDPRODI=biayakomponen.IDPRODI AND mahasiswa.GELOMBANG=biayakomponen.GELOMBANG 
AND bayarkomponen.IDKOMPONEN=biayakomponen.IDKOMPONEN AND IDMAHASISWA='{$users}' ORDER BY bayarkomponen.JENIS,bayarkomponen.IDKOMPONEN,bayarkomponen.TAHUNAJARAN,bayarkomponen.SEMESTER,TANGGALBAYAR";

echo $q;
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    echo "<div class=\"m-portlet\">			
		<div class=\"m-section__content\">
			<div class=\"table-responsive\">
				<table class=\"table table-bordered table-hover\">
					<thead>";
    echo "					<tr class=juduldata{$aksi} align=center>
							<td>Komponen</td>
							<td>Jenis</td>
							<td>Waktu</td>
							<td>Tanggal Bayar</td>
							<td>Biaya</td>
							<td>Bayar</td>
							<td>Diskon</td>
							<td>Sisa</td>
							<td>Denda</td>
							<td>Ket</td>";
    echo "					</tr>";   
	echo "				</thead>
					<tbody>";	
	$idkomponenlama = $tahunlama = $semlama = 0 - 1;
            		$sisa = 0;
		   	$i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $waktu = "-";
                if ( $d['BIAYA'] == 0 )
                {
                    $d['BIAYA'] = $d['BIAYA2'];
                }
				if($d['BEASISWA']>100){
	
						$biaya = $d['BIAYA'] - $d['BEASISWA'];
					}else{
					
						$biaya = $d['BIAYA'] * ( 100 - $d['BEASISWA'] ) / 100;
					}
                #$biaya = $d[BIAYA] * ( 100 - $d[BEASISWA] ) / 100;
                if ( $d['JENIS'] == 2 )
                {
                    $waktu = ( $d['TAHUNAJARAN'] - 1 )."/{$d['TAHUNAJARAN']}";
                }
                else if ( $d['JENIS'] == 3 || $d['JENIS'] == 6 )
                {
                    $waktu = "".$arraysemester[$d['SEMESTER']]." ".( $d['TAHUNAJARAN'] - 1 )."/{$d['TAHUNAJARAN']}";
                }
                else if ( $d['JENIS'] == 5 )
                {
                    $waktu = "".$arraybulan[$d['SEMESTER'] - 1]." {$d['TAHUNAJARAN']}";
                }
				
				
		/*if (
                
                  ($d[JENIS]==0 && ($idkomponenlama!=$d[IDKOMPONEN]  ) ) ||
                  ($d[JENIS]==1 && ($idkomponenlama!=$d[IDKOMPONEN]  ) ) ||
                  ($d[JENIS]==2 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN]  ) ) ||
                  ($d[JENIS]==3 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN] || $semlama!=$d[SEMESTER]) )  || 
                  ($d[JENIS]==4 && ($idkomponenlama!=$d[IDKOMPONEN]  ) ) ||
                  ($d[JENIS]==5 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN] || $semlama!=$d[SEMESTER]) ) ||
                  ($d[JENIS]==6 && ($idkomponenlama!=$d[IDKOMPONEN] || $tahunlama!=$d[TAHUNAJARAN] || $semlama!=$d[SEMESTER]) ) 
                    
                
                
                )*/
				if (
                
                  ($d['JENIS']==0 && ($idkomponenlama!=$d['IDKOMPONEN']  ) ) ||
                  ($d['JENIS']==1 && ($idkomponenlama!=$d['IDKOMPONEN']  ) ) ||
                  ($d['JENIS']==2 && ($idkomponenlama!=$d['IDKOMPONEN'] || $tahunlama!=$d['TAHUNAJARAN']  ) ) ||
                  ($d['JENIS']==3 && ($idkomponenlama!=$d['IDKOMPONEN'] || $tahunlama!=$d['TAHUNAJARAN'] || $semlama!=$d['SEMESTER']) )  || 
                  ($d['JENIS']==4 && ($idkomponenlama!=$d['IDKOMPONEN']  ) ) ||
                  ($d['JENIS']==5 && ($idkomponenlama!=$d['IDKOMPONEN'] || $tahunlama!=$d['TAHUNAJARAN'])) ||
                  ($d['JENIS']==6 && ($idkomponenlama!=$d['IDKOMPONEN'] || $tahunlama!=$d['TAHUNAJARAN'] || $semlama!=$d['SEMESTER']) ) 
                    
                
                
                ) {
                  //$sisa=$d[BIAYA];
                  $sisa=$biaya;
                    $idkomponenlama=$d['IDKOMPONEN'];
                  $tahunlama=$d['TAHUNAJARAN'];
                  $semlama=$d['SEMESTER'];
                  //$tr="class=juduldata";
                  
                  echo "
                  <tr class=juduldata><td colspan=12>&nbsp;</td></tr>
                  ";
                  
               }


              #$sisa-=($d[JUMLAH]+$d[DISKON]);
			  $sisa-=($d['JUMLAH']+$d['DISKON']);
			  
              
              if ($sisa<0) {
                $sisa=0;
              }
              
              $trtgl="";
              $cek="";
              if ($d['STATUSTANGGAL']==1) {
                $trtgl="style='background-color:#ffff00;'";
                $cek="checked";
              }
			  
        echo "
            <tr valign=top $tr $trtgl>
              <td nowrap> ".$arraykomponenpembayaran2[$d['IDKOMPONEN']]." </td>
              <td nowrap> ".$arrayjenispembayaran[$d['JENIS']]." </td>
               <td align=center nowrap>$waktu </td>
               <td align=center nowrap>{$d['TGLBAYAR']}</td>
              <td align=right>".cetakuang($biaya)." </td>
              <td align=right>".cetakuang($d['JUMLAH'])."</td>
              <td align=right>".cetakuang($d['DISKON'])."</td>
              <td align=right> ".cetakuang($sisa)."</td>
              <td align=right>".cetakuang($d['DENDA'])."</td>
              <td align=left>$d[KET]</td>
              
            </tr>";
        $totalbayar += $d['JUMLAH'];
        $totalsisa += $sisa;
        ++$i;
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
