<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n\t\r\ntr.datagenapcetak td, tr.dataganjilcetak td, tr.juduldatacetak td {\r\n\tborder:none;\r\n\t}\r\n\r\ntr.juduldatacetak, td {\r\n\tborder:none;\r\n\t}\r\n\t\r\n.borderline {\r\n\tborder-top:1px solid black;\r\n\tborder-right:1px solid black;\r\n\t}\r\n\t\r\n.borderline td {\r\n\tborder-bottom:1px solid black;\r\n\tborder-left:1px solid black;\r\n\tpadding:5px;\r\n\tfont-size:13px;\r\n\t}\r\n\t\r\n.bottomcontent td{\r\n\t\tborder:";
echo "none;\r\n\t\tfont-size:12px;\r\n\t\tfont-weight:normal;\r\n\t}\r\n\r\n</style>\r\n";
periksaroot( );
if ( $jenisusers == 3 )
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
$arraysort[10] = "mahasiswa.IDPRODI";
$arraysort[11] = "bayarkomponen.TGLUPDATE";
$arraysort[12] = "bayarkomponen.DISKON";
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
if ( $kelas != "" )
{
    $qfield .= " AND msmhs.SHIFTMSMHS = '{$kelas}'";
    $qjudul .= " Kelas '".$arraykelasmhs[$kelas]."' <br>";
    $qinput .= " <input type=hidden name=kelas value='{$kelas}'>";
    $href .= "kelas={$kelas}&";
}
if ( $carabayar != "" )
{
    $qfield .= " AND bayarkomponen.CARABAYAR = '{$carabayar}'";
    $qjudul .= " Cara Bayar : ".$arraycarabayar[$carabayar]." <br>";
    $qinput .= " <input type=hidden name=carabayar value='{$carabayar}'>";
    $href .= "carabayar={$carabayar}&";
}
if ( $operator != "" )
{
    $qfield .= " AND bayarkomponen.USER = '{$operator}'";
    $qjudul .= " Operator '{$operator}' <br>";
    $qinput .= " <input type=hidden name=operator value='{$operator}'>";
    $href .= "operator={$operator}&";
}
$qinput .= " <input type=hidden name=jenistanggal value='{$jenistanggal}'> \r\n \t\t\t\t<input type=hidden name='tgl1[tgl]' value='{$tgl1['tgl']}'>\r\n  \t\t\t<input type=hidden name='tgl1[bln]' value='{$tgl1['bln']}'>\r\n  \t\t\t<input type=hidden name='tgl1[thn]' value='{$tgl1['thn']}'>\r\n  \t\t\t<input type=hidden name='tgl2[tgl]' value='{$tgl2['tgl']}'>\r\n  \t\t\t<input type=hidden name='tgl2[bln]' value='{$tgl2['bln']}'>\r\n  \t\t\t<input type=hidden name='tgl2[thn]' value='{$tgl2['thn']}'>\r\n\r\n  ";
$href .= "jenistanggal={$jenistanggal}&tgl1[tgl]={$tgl1['tgl']}&tgl1[bln]={$tgl1['bln']}&tgl1[thn]={$tgl1['thn']}&tgl2[tgl]={$tgl2['tgl']}&tgl2[bln]={$tgl2['bln']}&tgl2[thn]={$tgl2['thn']}&";
if ( $jenistanggal == "bayar" )
{
    $qjudul .= " Jenis Tanggal : Tanggal Bayar<br>";
    $qfield .= "\r\n \t\t\tAND \r\n \t\t\t(\r\n \t\t\t\tbayarkomponen.TANGGALBAYAR >= DATE_FORMAT('{$tgl1['thn']}-{$tgl1['bln']}-{$tgl1['tgl']}','%Y-%m-%d')\r\n \t\t\t\tAND\r\n \t\t\t\tbayarkomponen.TANGGALBAYAR <= DATE_FORMAT('{$tgl2['thn']}-{$tgl2['bln']}-{$tgl2['tgl']}','%Y-%m-%d')\r\n \t\t\t)      \r\n      \r\n      ";
}
else
{
    $qjudul .= " Jenis Tanggal : Tanggal Entri<br>";
    $qfield .= "\r\n \t\t\tAND \r\n \t\t\t(\r\n \t\t\t\tbayarkomponen.TANGGAL >= DATE_FORMAT('{$tgl1['thn']}-{$tgl1['bln']}-{$tgl1['tgl']}','%Y-%m-%d')\r\n \t\t\t\tAND\r\n \t\t\t\tbayarkomponen.TANGGAL <= DATE_FORMAT('{$tgl2['thn']}-{$tgl2['bln']}-{$tgl2['tgl']}','%Y-%m-%d')\r\n \t\t\t)      \r\n      \r\n      ";
}
$qjudul .= "Antara {$tgl1['tgl']} ".$arraybulan[$tgl1[bln] - 1]." {$tgl1['thn']} s.d \r\n {$tgl2['tgl']} ".$arraybulan[$tgl2[bln] - 1]." {$tgl2['thn']}<br>";
if ( is_array( $jeniskomponen ) )
{
    $qkomponen = " AND (  ";
    $qjudul .= "Komponen pembayaran : <br>";
    foreach ( $jeniskomponen as $k => $v )
    {
        $idkomponen = $k;
        $qinput .= "<input type=hidden name='jeniskomponen[{$idkomponen}]' value=1>";
        $qkomponen .= "  bayarkomponen.IDKOMPONEN = '{$idkomponen}'  ";
        $qjudul .= " - {$arraykomponenpembayaran[$idkomponen]}<br>";
        $href .= "jeniskomponen[{$idkomponen}]=1&";
        if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
        {
            if ( $tahunajaran != "" )
            {
                $qkomponen .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunajaran}' ";
                $adatahunajaran = 1;
            }
        }
        else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
        {
            if ( $semesterbayar != "" )
            {
                $qkomponen .= " AND bayarkomponen.SEMESTER = '{$semesterbayar}' ";
                $adasemesterbayar = 1;
            }
            if ( $tahunbayar != "" )
            {
                $qkomponen .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunbayar}' ";
                $adatahunbayar = 1;
            }
        }
        else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 6 )
        {
            if ( $semesterbayarc != "" )
            {
                $qkomponen .= " AND bayarkomponen.SEMESTER = '{$semesterbayarc}' ";
                $adasemesterbayarc = 1;
            }
            if ( $tahunbayarc != "" )
            {
                $qkomponen .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunbayarc}' ";
                $adatahunbayarc = 1;
            }
        }
        else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
        {
            if ( $semesterbayar2 != "" )
            {
                $qkomponen .= " AND bayarkomponen.SEMESTER = '{$semesterbayar2}' ";
                $adasemesterbayar2 = 1;
            }
            if ( $tahunajaran2 != "" )
            {
                $adatahunajaran2 = 1;
                $qkomponen .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunajaran2}'";
            }
        }
        $qkomponen .= "  OR";
    }
    $qkomponen .= ")";
    $qkomponen = str_replace( "OR)", ")", $qkomponen );
    $qfield .= $qkomponen;
    if ( $adatahunajaran == 1 )
    {
        $qjudul .= " Tahun Akademik '".( $tahunajaran - 1 )."/{$tahunajaran}' <br>";
        $qinput .= " <input type=hidden name=tahunajaran value='{$tahunajaran}'>";
        $href .= "tahunajaran={$tahunajaran}&";
    }
    if ( $adatahunbayar == 1 || $adasemesterbayar == 1 )
    {
        $qjudul .= " Tahun Akademik dan Semester '".( $tahunbayar - 1 )."/{$tahunbayar} / ".$arraysemester[$semesterbayar]."' <br>";
        $qinput .= " <input type=hidden name=tahunbayar value='{$tahunbayar}'>";
        $href .= "tahunbayar={$tahunbayar}&";
        $qinput .= " <input type=hidden name=semesterbayar value='{$semesterbayar}'>";
        $href .= "semesterbayar={$semesterbayar}&";
    }
    if ( $adatahunbayarc == 1 || $adasemesterbayarc == 1 )
    {
        $qjudul .= " Tahun Akademik dan Semester Cuti '".( $tahunbayarc - 1 )."/{$tahunbayarc} / ".$arraysemester[$semesterbayarc]."' <br>";
        $qinput .= " <input type=hidden name=tahunbayarc value='{$tahunbayarc}'>";
        $href .= "tahunbayarc={$tahunbayarc}&";
        $qinput .= " <input type=hidden name=semesterbayarc value='{$semesterbayarc}'>";
        $href .= "semesterbayarc={$semesterbayarc}&";
    }
    if ( $adasemesterbayar2 == 1 || $adatahunajaran2 == 1 )
    {
        $qjudul .= " Bulan  ".$arraybulan[$semesterbayar2 - 1]."  ";
        $qinput .= " <input type=hidden name=semesterbayar2 value='{$semesterbayar2}'>";
        $href .= "semesterbayar2={$semesterbayar2}&";
        $qjudul .= " Tahun : {$tahunajaran2} <br>";
        $qinput .= " <input type=hidden name=tahunajaran2 value='{$tahunajaran2}'>";
        $href .= "tahunajaran2={$tahunajaran2}&";
    }
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML \r\n  FROM komponenpembayaran,bayarkomponen , mahasiswa,msmhs,prodi\r\n\tWHERE \r\n\tmahasiswa.ID=msmhs.NIMHSMSMHS AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tbayarkomponen.IDMAHASISWA=mahasiswa.ID AND \r\n  bayarkomponen.IDKOMPONEN=komponenpembayaran.ID\r\n \r\n\t{$qfield}\r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
if($_SESSION['users']=='arizona01' || $_SESSION['users']=='admin'){

$q = "SELECT bayarkomponen.*,DATE_FORMAT(bayarkomponen.TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR,\r\n\t mahasiswa.NAMA {$field99} , \r\n\t mahasiswa.IDPRODI,\r\n\tkomponenpembayaran.JENIS,\r\n\tprodi.TINGKAT\r\n\tFROM komponenpembayaran,bayarkomponen , mahasiswa,msmhs,prodi\r\n\tWHERE \r\n\tmahasiswa.ID=msmhs.NIMHSMSMHS AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tbayarkomponen.IDMAHASISWA=mahasiswa.ID AND \r\n  bayarkomponen.IDKOMPONEN=komponenpembayaran.ID AND bayarkomponen.KET NOT like '%Impor Via%' {$qfield}\r\n\tORDER BY ".$arraysort[$sort]."\r\n  {$qlimit}\r\n  ";

}else{

$q = "SELECT bayarkomponen.*,DATE_FORMAT(bayarkomponen.TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR,\r\n\t mahasiswa.NAMA {$field99} , \r\n\t mahasiswa.IDPRODI,\r\n\tkomponenpembayaran.JENIS,\r\n\tprodi.TINGKAT\r\n\tFROM komponenpembayaran,bayarkomponen , mahasiswa,msmhs,prodi\r\n\tWHERE \r\n\tmahasiswa.ID=msmhs.NIMHSMSMHS AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tbayarkomponen.IDMAHASISWA=mahasiswa.ID AND \r\n  bayarkomponen.IDKOMPONEN=komponenpembayaran.ID\r\n\t {$qfield}\r\n\tORDER BY ".$arraysort[$sort]."\r\n  {$qlimit}\r\n  ";

}
#echo $q;
$h = mysqli_query($koneksi,$q);
echo mysqli_error($koneksi);
if ( 0 < sqlnumrows( $h ) )
{
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Laporan Harian Pembayaran Keuangan Mahasiswa" );
        printmesg( $qjudul );
        printmesg( $errmesg );
    }
    else
    {
        printjudulmenucetak( "Laporan Harian  Pembayaran Keuangan Mahasiswa" );
        printmesgcetak( $qjudul );
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaklaporan6.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n \t\t\t\t\r\n   \t\t\t\t{$qinput}\r\n   \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    echo "\r\n\t\t{$tpage} {$tpage2}\r\n \t\t\t<table class=borderline cellpadding=0 cellspacing=0>\r\n\t\t\t<tr align=center style='background:#b0e2ff;'>\r\n\t\t\t\t<td>No</td>\r\n \t\t\t\t<td><a style='font-size:12px; text-decoration:none; color:#000;' href='{$href}"."&sort=0'>NPM</td>\r\n\t\t\t\t<td><a style='font-size:12px; text-decoration:none; color:#000;' href='{$href}"."&sort=1'>Nama </td>\r\n\t\t\t\t<td><a style='font-size:12px; text-decoration:none; color:#000;' href='{$href}"."&sort=10'>Program Studi</td>\r\n\t\t\t\t<td><a style='font-size:12px; text-decoration:none; color:#000;' href='{$href}"."&sort=11'>Tanggal Input</td>\r\n\t\t\t\t<td><a style='font-size:12px; text-decoration:none; color:#000;' href='{$href}"."&sort=2'>Pembayaran</td>\r\n\t\t\t\t<td><a style='font-size:12px; text-decoration:none; color:#000;' href='{$href}"."&sort=3'>Tanggal Bayar</td>\r\n\t\t\t\t<td><a style='font-size:12px; text-decoration:none; color:#000;' href='{$href}"."&sort=5'>Diskon Rp.</td>\r\n\t\t\t\t<td><a style='font-size:12px; text-decoration:none; color:#000;' href='{$href}"."&sort=4'>Jumlah Bayar Rp.</td>\r\n\t\t\t\t<td><a style='font-size:12px; text-decoration:none; color:#000;' href='{$href}"."&sort=12'>Denda Rp.</td>\r\n\t\t\t\t<td><a style='font-size:12px; text-decoration:none; color:#000;' href='{$href}"."&sort=6'>Total Bayar<br>Rp.</td>\r\n\t\t\t\t<!--<td><a style='font-size:12px; text-decoration:none; color:#000;' href='{$href}"."&sort=7'>Bulan/Sem/<br>Tahun<br>Ajaran</td>-->\r\n\t\t\t\t<td><a style='font-size:12px; text-decoration:none; color:#000;' href='{$href}"."&sort=8'>Bayar Di</td><td><a style='font-size:12px; text-decoration:none; color:#000;'  href='{$href}"."&sort=9'>Keterangan</td><!--<td><a style='font-size:12px; text-decoration:none; color:#000;'  href='{$href}"."&sort=10'>Sisa</td>--></tr>\r\n\t\t";
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
	$biaya=$d['BIAYA'];	
	$qtotalbayar = "SELECT SUM(bayarkomponen.JUMLAH) TOTALBAYAR, SUM(bayarkomponen.DISKON) AS TOTALDISKON \r\n            FROM bayarkomponen\r\n             WHERE\r\n              bayarkomponen.IDKOMPONEN='{$idkomponen}' AND \r\n             bayarkomponen.IDMAHASISWA='{$d['IDMAHASISWA']}'  AND\r\n             bayarkomponen.TAHUNAJARAN='{$d['TAHUNAJARAN']}' AND\r\n             bayarkomponen.SEMESTER='{$d['SEMESTER']}'\r\n             \r\n             ";
        #echo $qtotalbayar.'<br>';
	$htotalbayar = doquery( $qtotalbayar, $koneksi );
	if ( 0 < sqlnumrows( $htotalbayar ) )
		{
			$dtotalbayar = sqlfetcharray( $htotalbayar );
			$totalbayar = $dtotalbayar[TOTALBAYAR];
			$totaldiskon = $dtotalbayar[TOTALDISKON];
		}       
	$sisa = $biaya - ( $totalbayar + $totaldiskon );
        $kelas = kelas( $i );
        $tmp = explode( "-", $d[TANGGALBAYAR] );
        $tglbayar[tgl] = $tmp[2];
        $tglbayar[bln] = $tmp[1];
        $tglbayar[thn] = $tmp[0];
        echo "\r\n\t\t\t\t<tr align=center valign=top>\r\n\t\t\t\t\t<td>{$i}</td>\r\n  \t\t\t\t\t<td align=left>{$d['IDMAHASISWA']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['NAMA']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left nowrap>".$arrayprodi[$d[IDPRODI]]." ".$arrayjenjang[$d[TINGKAT]]."&nbsp;</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['TGLUPDATE']}&nbsp;</td>\r\n \t\t\t\t\t<td align=left>{$d['NAMAKOMPONEN']}&nbsp;</td>\r\n \t\t\t\t\t<td align=center nowrap>{$d['TGLBAYAR']}&nbsp;</td>\r\n \t\t\t\t\t<td align=right>".cetakuang( $d[DISKON] )."&nbsp;</td>\r\n \t\t\t\t\t<td align=right>".cetakuang( $d[JUMLAH] )."&nbsp;</td>\r\n \t\t\t\t\t<td align=right>".cetakuang( $d[DENDA] )."&nbsp;</td>\r\n \t\t\t\t\t<td align=right>".cetakuang( $d[JUMLAH] + $d[DENDA] )."&nbsp;</td>\r\n \t\t\t\t\t<!-- <td align=center nowrap>";
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
        echo "&nbsp;</td> -->\r\n \t\t\t\t\t<td align=center nowrap>".$arraycarabayar[$d[CARABAYAR]]."&nbsp;</td>\r\n \t\t\t\t\t<td align=right>".nl2br( $d[KET] )."&nbsp;</td><!--<td align=right>".cetakuang( $sisa )."&nbsp;</td>--></tr>\r\n\t\t\t";
        $totalbayar += $d[JUMLAH];
        $totaldiskon += $d[DISKON];
        $totaldenda += $d[DENDA];
        $totalbayar2 += $d[DISKON];
        if ( $d[CARABAYAR] == 0 )
        {
            $totalbayarcash += $d[JUMLAH] + $d[DENDA];
        }
        else
        {
            $totalbayarbank += $d[JUMLAH] + $d[DENDA];
        }
        ++$i;
    }
    #echo "\r\n\t\t</table>\r\n\t\r\n\t\t<table class=bottomcontent width=90% cellpadding=0 cellspacing=0>\r\n\t\t\t<tr>\r\n\t\t\t\t<td align=left width=300 >Total Jumlah Bayar Cash :</td>\r\n\t\t\t\t<td align=left >".cetakuang( $totalbayarcash )."</td>\r\n\t\t\t\t<td align=right width=140>Total Jumlah Bayar</td>\r\n\t\t\t\t<td align=right >".cetakuang( $totalbayar )."</td>\r\n\t\t\t\t<td width=250>&nbsp;</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t{$lokasikantor}, {$w['mday']} ".$arraybulan[$w[mon] - 1]." {$w['year']}\r\n\t\t\t\t\t<br>Bagian keuangan\r\n\t\t\t\t\t\r\n       \t\t\t </td>\r\n \t\t\t</tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td align=left >Total Jumlah Bayar Bank :</td>\r\n\t\t\t\t<td align=left  width=100>".cetakuang( $totalbayarbank )."</td>\r\n\t\t\t\t<td align=right style='border-bottom:3px double #000;'>Total Jumlah Denda</td>\r\n\t\t\t\t<td align=right style='border-bottom:3px double #000;' width=200>".cetakuang( $totaldenda )."</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n \t\t\t</tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td align=right >&nbsp; </td>\r\n \t\t\t\t<td align=right >&nbsp; </td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td align=right>".cetakuang( $totalbayar + $totaldenda )."</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n \t\t\t</tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td>{$users}</td>\r\n \t\t\t</tr>\r\n       \r\n      </table>";
    echo "\r\n\t\t</table>\r\n\t\r\n\t\t<table class=bottomcontent width=90% cellpadding=0 cellspacing=0>\r\n\t\t\t<tr>\r\n\t\t\t\t<td align=left width=300 >Total Jumlah Bayar Cash :</td>\r\n\t\t\t\t<td align=left >".cetakuang( $totalbayarcash )."</td>\r\n\t\t\t\t<td align=right width=140>Total Jumlah Bayar</td>\r\n\t\t\t\t<td align=right >".cetakuang( ($totalbayarcash + $totalbayarbank) - $totaldenda )."</td>\r\n\t\t\t\t<td width=250>&nbsp;</td>\r\n\t\t\t\t<td>\r\n\t\t\t\t\t{$lokasikantor}, {$w['mday']} ".$arraybulan[$w[mon] - 1]." {$w['year']}\r\n\t\t\t\t\t<br>Bagian keuangan\r\n\t\t\t\t\t\r\n       \t\t\t </td>\r\n \t\t\t</tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td align=left >Total Jumlah Bayar Bank :</td>\r\n\t\t\t\t<td align=left  width=100>".cetakuang( $totalbayarbank )."</td>\r\n\t\t\t\t<td align=right style='border-bottom:3px double #000;'>Total Jumlah Denda</td>\r\n\t\t\t\t<td align=right style='border-bottom:3px double #000;' width=200>".cetakuang( $totaldenda )."</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n \t\t\t</tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td align=right >&nbsp; </td>\r\n \t\t\t\t<td align=right >&nbsp; </td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td align=right>".cetakuang( (($totalbayarbank+$totalbayarcash)-$totaldenda) + $totaldenda )."</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n \t\t\t</tr>\r\n\t\t\t<tr>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td>&nbsp;</td>\r\n\t\t\t\t<td>{$users}</td>\r\n \t\t\t</tr>\r\n       \r\n      </table>";
    
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Laporan Harian Pembayaran Keuangan Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
