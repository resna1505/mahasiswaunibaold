<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
periksaroot( );
include( "array.php" );
echo "\r\n<style type=\"text/css\">\r\n\r\n.borderblack td{\r\n\tborder:none;\r\n\t}\r\n\t\r\ntr.juduldatacetak, td {\r\n\tborder:none;\r\n\t}\r\n\t\r\n#borderline {\r\n\tborder-top:1px solid black;\r\n\tborder-right:1px solid black;\r\n\t}\r\n\t\r\n#borderline td {\r\n\tborder-bottom:1px solid black;\r\n\tborder-left:1px solid black;\r\n\t}\r\n\r\n</style>\r\n";
printhtmlcetak( );
$cetak = $aksi = "cetak";
$border = " border=1 width=600 style='border-collapse:collapse;'";
if ( trim( $idmahasiswa ) == "" )
{
    $errmesg = "NIM harus diisi";
    $aksi = "";
}
else
{
    printmesg( $errmesg );
    $q = "SELECT NAMA,ANGKATAN,IDPRODI FROM mahasiswa WHERE ID='{$idmahasiswa}'";
    $h = mysqli_query($koneksi,$q);
    if ( sqlnumrows( $h ) <= 0 )
    {
        $errmesg = "Tidak ada mahasiswa dengan NIM '{$idmahasiswa}'";
        $aksi = "";
    }
    else
    {
		$sql_kwitansi="select max(cast(NOKWITANSI as signed)) as NOKWITANSI FROM bayarkomponen_kwitansi WHERE TAHUN='2019'";
		$query_kwitansi = mysqli_query($koneksi,$sql_kwitansi);
		$data_kwitansi=sqlfetcharray($query_kwitansi);
		if ( sqlnumrows($query_kwitansi) <= 0 ){
			$no_kwitansi=$data_kwitansi['NOKWITANSI']+1;
							
			$no_kwitansi = str_pad($no_kwitansi, 7, "0", STR_PAD_LEFT);
		}else{
			$no_kwitansi=$data_kwitansi['NOKWITANSI']+1;
							
			$no_kwitansi = str_pad($no_kwitansi, 7, "0", STR_PAD_LEFT);	
		}
		
		//insert ke database
		$sql_insert_kwitansi="INSERT INTO bayarkomponen_kwitansi (NOKWITANSI,TAHUN) VALUES('$no_kwitansi','{$w['year']}')";
		$query_insert_kwitansi=mysqli_query($koneksi,$sql_insert_kwitansi);
		#echo $sql_insert_kwitansi;exit();
		
        $data = sqlfetcharray( $h );
        /*echo "\r\n\t\t\t<center>\r\n\t\t\t<b style='font-size:22px; text-decoration:underline;'>KWITANSI PEMBAYARAN</b>\r\n\t\t\t<table width=96%>\r\n\t\t\t<tr>\r\n\t\t\t<td width=60% class=loseborder>\r\n\t\t \t\t<table width=100% class=form>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td width=60  class=loseborder>NPM</td>\r\n\t\t\t\t\t\t<td  class=loseborder>: {$idmahasiswa}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td class=loseborder>Nama</td>\r\n\t\t\t\t\t\t<td  class=loseborder>: {$data['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n \r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t </td>\r\n\t\t\t<td width=40%  class=loseborder>\r\n\t\t \t\t<table width=100% class=form>\r\n \t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td  class=loseborder>Jurusan/Prodi</td>\r\n\t\t\t\t\t\t<td  class=loseborder>: ".$arrayprodidep[$data[IDPRODI]]."</td>\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td width=120  class=loseborder>Angkatan</td>\r\n\t\t\t\t\t\t<td  class=loseborder>: {$data['ANGKATAN']}</td>\r\n\t\t\t\t\t</tr>\r\n \r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t </td>\r\n\t\t\t\t\t</tr>\r\n       </table>   \r\n          ";
        */
		echo "<center>
					<table width=96%>
						<tr>
							<td width=65% class=loseborder>
								<table width=100% class=form>
									<tr class=judulform>
										<td width=15% class=loseborder rowspan='2'>
											<img src=\"../gambar/uniba.png\" width=\"120\" height=\"109\">
										</td>
										<td  class=loseborder><b style='font-size:22px;'>YAYASAN GRIYA HUSADA</b></td>
									</tr>
									<tr class=judulform>
										<td class=loseborder><b style='font-size:22px;'>UNIVERSITAS BATAM</b></td>
										<td class=loseborder>
											&nbsp;
										</td>
									</tr>
								</table>
								<table width=100% class=form>
									<tr class=judulform>
										<td class=loseborder width='50%'>&nbsp;</td>
										<td class=loseborder align='center'>
											<b style='font-size:20px; text-decoration:underline;'>KWITANSI PEMBAYARAN</b>
										</td>
									</tr>
								</table>
							</td>
							<td width=40% class=loseborder>
								<table width=100% class=form>
									<tr class=judulform>
										<td>&nbsp;</td>
										<td  class=loseborder>No. Kwitansi</td>
										<td  class=loseborder>: {$no_kwitansi}</td>
									</tr>
									<tr>
										<td width=120  class=loseborder>&nbsp;</td>
										<td  class=loseborder>&nbsp;</td>
									</tr>
								</table>
							</td>
						</tr>
					</table>
					<table width=96%><tr><td width=60% class=loseborder>\r\n\t\t \t\t<table width=100% class=form><tr class=judulform>\r\n\t\t\t\t\t\t<td width=60  class=loseborder>NPM</td>\r\n\t\t\t\t\t\t<td  class=loseborder>: {$idmahasiswa}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td class=loseborder>Nama</td>\r\n\t\t\t\t\t\t<td  class=loseborder>: {$data['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n \r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t </td>\r\n\t\t\t<td width=40%  class=loseborder>\r\n\t\t \t\t<table width=100% class=form>\r\n \t\t\t\t\t<tr class=judulform>\r\n\t\t\t\t\t\t<td  class=loseborder>Jurusan/Prodi</td>\r\n\t\t\t\t\t\t<td  class=loseborder>: ".$arrayprodidep[$data[IDPRODI]]."</td>\r\n\t\t\t\t\t\t\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t\t<tr>\r\n\t\t\t\t\t\t<td width=120  class=loseborder>Angkatan</td>\r\n\t\t\t\t\t\t<td  class=loseborder>: {$data['ANGKATAN']}</td>\r\n\t\t\t\t\t</tr>\r\n \r\n\t\t\t\t\t</table>\r\n\t\t\t\t\t </td>\r\n\t\t\t\t\t</tr>\r\n       </table>   \r\n          ";
        
		if ( is_array( $pilihcetak ) )
        {
            $qpilih = " AND (";
            foreach ( $pilihcetak as $k => $v )
            {
                $qpilih .= " bayarkomponen.ID='{$k}' OR ";
            }
            $qpilih .= ")";
            $qpilih = str_replace( "OR )", ")", $qpilih );
            $tgltrans[tgl] = $w[mday];
            $tgltrans[bln] = $w[mon];
            $tgltrans[thn] = $w[year];
            if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
            {
                $qfieldjeniskelas = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS='{$jeniskelas}' ";
                $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS=mahasiswa.JENISKELAS ";
            }
            else
            {
                $qfieldjeniskelas = " AND biayakomponen.JENISKELAS='' ";
                $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS='' ";
            }
            $q = "SELECT bayarkomponen.*,biayakomponen.BIAYA AS BIAYA2,\r\n\t\t\t IF(DATE(bayarkomponen.TANGGAL)=CURDATE(),1,0) AS STATUSTANGGAL,\r\n\t\t\t DATE_FORMAT(TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR\r\n       FROM bayarkomponen,biayakomponen ,mahasiswa\r\n       WHERE \r\n       mahasiswa.ID=bayarkomponen.IDMAHASISWA AND\r\n       mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND\r\n       mahasiswa.IDPRODI=biayakomponen.IDPRODI AND\r\n       mahasiswa.GELOMBANG=biayakomponen.GELOMBANG AND\r\n       bayarkomponen.IDKOMPONEN=biayakomponen.IDKOMPONEN AND\r\n        \r\n      IDMAHASISWA='{$idmahasiswa}'  {$qfieldjeniskelasm}\r\n      {$qpilih}\r\n      ORDER BY bayarkomponen.JENIS,bayarkomponen.IDKOMPONEN,bayarkomponen.TAHUNAJARAN,bayarkomponen.SEMESTER,TANGGALBAYAR";
           # echo $q;
			$h = mysqli_query($koneksi,$q);
            echo mysqli_error($koneksi);
            if ( 0 < sqlnumrows( $h ) )
            {
                echo "\r\n           <table  width=95% class=borderblack id=borderline cellpading=0 cellspacing=0>\r\n            <tr align=center style='font-weight:bold;'>\r\n              <td>No</td>\r\n              <td>Item Bayar</td>\r\n               <td>Periode</td>\r\n               <td>Tanggal Bayar</td>\r\n              <td>HP - Disc</td>\r\n\r\n              <td>Sudah dibayar</td>\r\n\r\n              <td>Bayar</td> \r\n              <td>Denda</td> \r\n\r\n              <td>Sisa</td>\r\n\r\n              <td>Ket</td>\r\n \r\n            </tr>";
                $idkomponenlama = $tahunlama = $semlama = 0 - 1;
                $sisa = 0;
                $i = 0;
                while ( $d = sqlfetcharray( $h ) )
                {
                    ++$i;
                    $waktu = "-";
                    $sudahdibayar = $biaya = $sisa = 0;
					if($d[BEASISWA]>100){
	
						$biaya = $d[BIAYA] - $d[BEASISWA] ;
					}else{
					
						$biaya = $d[BIAYA] * ( 100 - $d[BEASISWA] ) / 100;
					}
                    #$biaya = $d[BIAYA] * ( 100 - $d[BEASISWA] ) / 100;
                    if ( $d[JENIS] == 0 || $d[JENIS] == 1 || $d[JENIS] == 4 )
                    {
                        $waktu = "";
                        $q = "SELECT SUM(JUMLAH) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}'   AND\r\n                  IDKOMPONEN='{$d['IDKOMPONEN']}' AND TANGGALBAYAR < '{$d['TANGGALBAYAR']}'";
                    }
                    else if ( $d[JENIS] == 2 )
                    {
                        $waktu = ( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                        $q = "SELECT SUM(JUMLAH) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND \r\n                  TAHUNAJARAN='{$d['TAHUNAJARAN']}'   AND\r\n                  IDKOMPONEN='{$d['IDKOMPONEN']}' AND TANGGALBAYAR < '{$d['TANGGALBAYAR']}'";
                    }
                    else if ( $d[JENIS] == 3 )
                    {
                        $waktu = "".$arraysemester[$d[SEMESTER]]." ".( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                        $q = "SELECT SUM(JUMLAH) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND \r\n                  TAHUNAJARAN='{$d['TAHUNAJARAN']}'   AND SEMESTER='{$d['SEMESTER']}' AND\r\n                  IDKOMPONEN='{$d['IDKOMPONEN']}' AND TANGGALBAYAR < '{$d['TANGGALBAYAR']}'";
                    }
                    else if ( $d[JENIS] == 6 )
                    {
                        $waktu = "".$arraysemester[$d[SEMESTER]]." ".( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
                        $q = "SELECT SUM(JUMLAH) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND \r\n                  TAHUNAJARAN='{$d['TAHUNAJARAN']}'   AND SEMESTER='{$d['SEMESTER']}' AND\r\n                  IDKOMPONEN='{$d['IDKOMPONEN']}' AND TANGGALBAYAR < '{$d['TANGGALBAYAR']}'";
                    }
                    else if ( $d[JENIS] == 5 )
                    {
                        $waktu = "".$arraybulan[$d[SEMESTER] - 1]." {$d['TAHUNAJARAN']}";
                        $q = "SELECT SUM(JUMLAH) AS TOTAL FROM bayarkomponen WHERE IDMAHASISWA='{$idmahasiswa}' AND \r\n                  TAHUNAJARAN='{$d['TAHUNAJARAN']}'   AND SEMESTER='{$d['SEMESTER']}' AND\r\n                  IDKOMPONEN='{$d['IDKOMPONEN']}' AND TANGGALBAYAR < '{$d['TANGGALBAYAR']}'";
                    }
                    $hx = mysqli_query($koneksi,$q);
                    echo mysqli_error($koneksi);
                    $dx = sqlfetcharray( $hx );
                    $sudahdibayar = $dx[TOTAL];
                    $sisa = $biaya - $sudahdibayar - $d[JUMLAH] - $d[DISKON];
                    if ( $sisa < 0 )
                    {
                        $sisa = 0;
                    }
                    if ( $idkomponenlama != $d[IDKOMPONEN] || $tahunlama != $d[TAHUNAJARAN] || $semlama != $d[SEMESTER] )
                    {
                        $idkomponenlama = $d[IDKOMPONEN];
                        $tahunlama = $d[TAHUNAJARAN];
                        $semlama = $d[SEMESTER];
                    }
                    echo "\r\n            <tr valign=top {$tr} {$trtgl}>\r\n              <td align=center>{$i}</td>\r\n              <td> ".$arraykomponenpembayaran2[$d[IDKOMPONEN]]." </td>\r\n             \r\n               <td align=center>{$waktu} &nbsp;</td>\r\n               <td align=center>{$d['TGLBAYAR']}</td>\r\n              <!-- <td align=right>".cetakuang( $biaya )."</td> -->\r\n              <td align=right>".cetakuang( $biaya )."</td>\r\n\r\n              <td align=right>".cetakuang( $sudahdibayar )."</td>\r\n\r\n\r\n              <td align=right>".cetakuang( $d[JUMLAH] )."</td> \r\n              <td align=right>".cetakuang( $d[DENDA] )."</td>\r\n \r\n              <td align=right>".cetakuang( $sisa )." </td>\r\n\r\n\r\n              <td align=left>{$d['KET']}&nbsp; </td>\r\n             </tr>";
                    $totalbayar += $d[JUMLAH];
                    $totaldenda += $d[DENDA];
                }
                echo "\r\n            <tr valign=top {$tr} {$trtgl}>\r\n               <td align=right colspan=6 style='font-weight:bold; border:none;'>TOTAL BAYAR</td>\r\n              <td align=right style='font-weight:bold; '>".cetakuang( $totalbayar + $totaldenda )."</td> \r\n              <td align=right colspan=3 >&nbsp;</td>\r\n              </tr>";
                echo "\r\n          </table>\r\n\r\n         <table width=95%>\r\n          <tr>\r\n            <td class=loseborder>\r\n\t\t\t<div style='position:relative;'>\r\n\t\t\t  Terbilang : <br><i>( ".angkatoteks( $totalbayar + $totaldenda )." Rupiah )</i>\r\n\t\t\t  <br><br><Br>\r\n\t\t\t  Dicetak jam ".addnol( $w[hours], 2 ).":".addnol( $w[minutes], 2 )."\r\n\t\t\t</div>\r\n            </td>\r\n          </tr>\r\n         </table>";
				echo "<br>\r\n\t\t <table width=90%>\r\n\t\t \t<tr>\r\n\t\t\t\t<td align=center  class=loseborder width=30%>\r\n\t\t\t\t\tTanda Tangan Teller\r\n\t\t\t\t\t<br><br><br><br><br>\r\n\t\t\t\t\t(&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;\r\n\t\t\t\t\t&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;)\r\n\t\t\t\t</td>\r\n\t\t\t\t<td width=40%  class=loseborder>\r\n\t\t\t\t\t&nbsp;\r\n\t\t\t\t</td>\r\n\t\t\t\t<td nowrap align=center class=loseborder width=30%>\r\n\t\t\t\t   ".$lokasikantor.", {$w['mday']} ".$arraybulan[$w[mon] - 1]." {$w['year']}\r\n\t\t\t\t  <br>Petugas\r\n\t\t\t\t  <br><br><br>\r\n\t\t\t\t  <br>\r\n\t\t\t\t  ( ".getnama( $users )." )\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n\t\t </table>\r\n          \r\n         ";
				echo "<br><br><br><center>\r\n\t\t\t<b style='font-size:15px; text-decoration:none;'>Catatan : Uang yang telah dibayarkan tidak dapat dikembalikan/dipindahkan</b>\r\n\t\t\t ";
            }
        }
    }
}
?>
