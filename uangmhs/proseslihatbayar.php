<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $jenisusers == 2 || $jenisusers == 3 )
{
    $idmahasiswa = $users;
}
unset( $arraysort );
$arraysort[0] = "bayarkomponen.IDMAHASISWA";
$arraysort[1] = "mahasiswa.NAMA";
$arraysort[2] = "bayarkomponen.IDKOMPONEN";
$arraysort[3] = "bayarkomponen.TANGGALBAYAR";
$arraysort[4] = "bayarkomponen.JUMLAH";
$arraysort[5] = "bayarkomponen.DISKON";
$arraysort[6] = "bayarkomponen.JUMLAH-DISKON";
$arraysort[7] = "bayarkomponen.TAHUNAJARAN";
$arraysort[8] = "bayarkomponen.CARABAYAR";
$arraysort[9] = "bayarkomponen.KET";
if ( $aksi2 == hapus && ( getaturan( "KEUANGAN" ) == 0 || getaturan( "KEUANGAN" ) == 1 && issupervisor( $users ) ) )
{
    $q = "DELETE FROM bayarkomponen\r\n\tWHERE \r\n\tIDMAHASISWA='{$idmahasiswahapus}' AND\r\n\tIDKOMPONEN='{$idkomponenhapus}' AND\r\n\tTANGGALBAYAR='{$tanggalhapus}'\r\n\t";
    mysqli_query($koneksi,$q);
    $ketlog = "Hapus Pembayaran dengan \r\n\t\t\t\tID Komponen={$idkomponenhapus},ID Mahasiswa={$idmahasiswahapus},\r\n\t\t\t\tTanggal bayar={$tanggalhapus}\r\n\t\t\t\t";
    buatlog( 56 );
    $errmesg = "Data Pembayaran telah dihapus";
}
$href = "index.php?pilihan={$pilihan}&aksi=Tampilkan&";
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
    $href .= "istglbayar={$istglbayar}&tglbayar[tgl]={$tglbayar['tgl']}&tglbayar[bln]={$tglbayar['bln']}&tglbayar[thn]={$tglbayar['thn']}&\r\n\t\ttglbayar2[tgl]={$tglbayar2['tgl']}&tglbayar2[bln]={$tglbayar2['bln']}&tglbayar2[thn]={$tglbayar2['thn']}&";
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
    $qjudul .= " Komponen '".$arraykomponenpembayaran[$idkomponen]."' <br>";
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
        if ( $tahunajaran != "" )
        {
            $qfield .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunajaran}'";
            $qjudul .= " Tahun Akademik '".( $tahunajaran - 1 )."/{$tahunajaran}' <br>";
            $qinput .= " <input type=hidden name=tahunajaran value='{$tahunajaran}'>";
            $href .= "tahunajaran={$tahunajaran}&";
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
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML \r\n  FROM bayarkomponen , mahasiswa,komponenpembayaran\r\n\tWHERE \r\n\tbayarkomponen.IDMAHASISWA=mahasiswa.ID\r\n\tAND bayarkomponen.IDKOMPONEN=komponenpembayaran.ID\r\n \r\n\t{$qfield}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT bayarkomponen.*,DATE_FORMAT(bayarkomponen.TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR,\r\n\t mahasiswa.NAMA {$field99} , \r\n\tkomponenpembayaran.JENIS\r\n\tFROM bayarkomponen , mahasiswa,komponenpembayaran\r\n\tWHERE \r\n\tbayarkomponen.IDMAHASISWA=mahasiswa.ID\r\n\tAND bayarkomponen.IDKOMPONEN=komponenpembayaran.ID\r\n\t {$qfield}\r\n\tORDER BY ".$arraysort[$sort]."\r\n  {$qlimit}\r\n  ";
#echo $q;
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    /*if ( $aksi != "cetak" )
    {
        #printjudulmenu( "Data  Pembayaran Keuangan Mahasiswa" );
        printmesg( $qjudul );
        printmesg( $errmesg );
        echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br><br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Data  Pembayaran Keuangan Mahasiswa </span>
                            </div>";
    }
    else
    {
        #printjudulmenucetak( "Data  Pembayaran Keuangan Mahasiswa" );
        printmesgcetak( $qjudul );
    }*/
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
								printmesg("Data Pembayaran Keuangan Mahasiswa");
    if ( $aksi != "cetak" )
    {
        
        /*echo "<div class=\"actions\">
                                <form target=_blank action='cetaklihatbayar.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn blue\" value='Cetak'>\r\n \t\t\t\t\r\n \t\t\t\t<input type=submit name=aksi2 class=\"btn blue\" value='Ekspor ke DBF'>\r\n  \t\t\t\t{$qinput}\r\n  \t\t\t\t{$input}\r\n\t\t\t</form>
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";
		*/
		printmesg( $qjudul );
            #printmesg( $qjudul );
            #printmesg( $errmesg );
			echo "					<div class=\"tools\">
										<form target=_blank action='cetaklihatbayar.php'>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak'>
														{$qinput}{$input}
													</td>
												</tr>
											</table>
										</form>
									</div>{$tpage} {$tpage2}";
        #echo "\r\n\t\t\t\t<table>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaklihatbayar.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n \t\t\t\t\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Ekspor ke DBF'>\r\n  \t\t\t\t{$qinput}\r\n  \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
	#echo "\r\n\t\t\r\n \t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<thead><tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>Nama<br>Mahasiswa</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=2'>Komponen</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=3'>Tanggal<br>Bayar</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=4'>Jumlah Bayar<br>Rp.</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=5'>Diskon<br>Rp.</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=6'>Total Bayar<br>Rp.</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=7'>Bulan/Sem/<br>Tahun<br>Ajaran</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=8'>Cara<br>Bayar</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=9'>Ket</td>\r\n \t\t\t\t ";
    echo "							<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=0'>NIM</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=1'>Nama<br>Mahasiswa</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=2'>Komponen</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=3'>Tanggal<br>Bayar</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=4'>Jumlah Bayar<br>Rp.</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=5'>Diskon<br>Rp.</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=6'>Total Bayar<br>Rp.</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=7'>Bulan/Sem/<br>Tahun<br>Ajaran</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=8'>Cara<br>Bayar</td>\r\n\t\t\t\t<td><a class='{$cetak}' href='{$href}"."sort=9'>Ket</td>";
	if ( $tingkataksesusers[$kodemenu] == "T" )
    {
        echo "\r\n\t\t\t\t\t\t\t<td nowrap colspan=2  >Aksi</td>\r\n\t\t\t\t\t\t\t";
    }
    #echo "\r\n\t\t\t</tr></thead>\r\n\t\t";
	echo "			</tr> 
				</thead>
					<tbody>";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        $tmp = explode( "-", $d[TANGGALBAYAR] );
        $tglbayar[tgl] = $tmp[2];
        $tglbayar[bln] = $tmp[1];
        $tglbayar[thn] = $tmp[0];
        echo "\r\n\t\t\t\t<tr align=center {$kelas}{$aksi} valign=top>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['IDMAHASISWA']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMA']}</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMAKOMPONEN']}</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['TGLBAYAR']}</td>\r\n \t\t\t\t\t<td align=right>".cetakuang( $d[JUMLAH] )."</td>\r\n \t\t\t\t\t<td align=right>".cetakuang( $d[DISKON] )."</td>\r\n \t\t\t\t\t<td align=right>".cetakuang( $d[JUMLAH] + $d[DISKON] )."</td>\r\n \t\t\t\t\t<td align=center nowrap>";
        #echo $d[JENIS]."CC".$d[SEMESTER];
		if ( $d[JENIS] == 2 )
        {
            echo ( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
        }
        else if ( $d[JENIS] == 3 )
        {
            echo $arraysemester[$d[SEMESTER]]." ".( $d[TAHUNAJARAN] - 1 )."/{$d['TAHUNAJARAN']}";
        }
        else if ( $d[JENIS] == 5 )
        {
            echo $arraybulan[$d[SEMESTER] - 1]." {$d['TAHUNAJARAN']}";
        }
        else
        {
            echo "-";
        }
        echo "</td>\r\n \t\t\t\t\t<td align=center nowrap>".$arraycarabayar[$d[CARABAYAR]]."</td>\r\n \t\t\t\t\t<td align=right>".nl2br( $d[KET] )."</td>\r\n \t\t\t\t\t ";
        if ( $tingkataksesusers[$kodemenu] == "T" )
        {
            if ( getaturan( "KEUANGAN" ) == 0 || getaturan( "KEUANGAN" ) == 1 && issupervisor( $users ) )
            {
                echo "\r\n  \t\t\t\t\t\t\t\t<td   align=center><a class=\"btn green\" href='index.php?pilihan=bayar&aksi=Lanjut&idmahasiswa={$d['IDMAHASISWA']}&tglbayar[tgl]={$tglbayar['tgl']}&tglbayar[bln]={$tglbayar['bln']}&tglbayar[thn]={$tglbayar['thn']}&carabayar={$d['CARABAYAR']}&aksilanjut=edit&count=1&jeniskomponen_0={$d['IDKOMPONEN']}'><i class=\"fa fa-edit\"></i></td>\r\n  \t\t\t\t\t\t\t\t<td   align=center ><a class=\"btn red\" \r\n  \t\t\t\t\t\t\t\tonclick=\"return confirm('Hapus Data  Pembayaran? ');\"\r\n  \t\t\t\t\t\t\t\thref='{$href}&aksi2=hapus&idmahasiswahapus={$d['IDMAHASISWA']}&tanggalhapus={$d['TANGGALBAYAR']}&idkomponenhapus={$d['IDKOMPONEN']}'><i class=\"fa fa-trash\"></i></td>\r\n  \t\t\t\t\t\t\t\t";
            }
            else
            {
                echo "\r\n                  <td>-</td>\r\n                  <td>-</td>\r\n                ";
            }
        }
        echo "\r\n\t\t\t\t</tr>";
        $totalbayar += $d[JUMLAH];
        $totaldiskon += $d[DISKON];
        $totalbayar2 += $d[DISKON];
        ++$i;
    }
    echo "			<tr>
						<td align=right colspan=5><b>Total</td>
						<td align=right><b>".cetakuang( $totalbayar )."</td>
						<td align=right><b>".cetakuang( $totaldiskon )."</td>
						<td align=right><b>".cetakuang( $totalbayar + $totaldiskon )."</td>
					</tr>
				</tbody>
								</table>
							</div>
						</div>
					</div>
					<!--end::Section-->
				</div>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Pembayaran Tidak Ada";
    $aksi = "";
}
?>
