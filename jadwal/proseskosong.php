<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

echo "<s";
echo "tyle type=\"text/css\">\r\n\r\n.borderline {\r\n\tborder-bottom:1px solid black;\r\n\t}\r\n\t\r\n.makeborder {\r\n\tborder-right:1px solid black;\r\n\t}\r\n\t\r\n</style>\r\n\r\n";
periksaroot( );
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&jamawal={$jamawal}&jamakhir={$jamakhir}&";
if ( $jenisusers == 1 && $caridosen == 1 )
{
    $qfield .= " AND jadwalkuliah.TIM LIKE '%{$users}%'";
    $qjudul .= " NIDN Dosen  {$users} <br>";
    $qinput .= " <input type=hidden name=caridosen value='{$caridosen}'>";
    $href .= "caridosen={$caridosen}&";
}
if ( $semester != "" )
{
    $qfield .= " AND jadwalkuliah.SEMESTER='{$semester}'";
    $qjudul .= " Semester  ".$arraysemester[$semester]."  <br>";
    $qinput .= " <input type=hidden name=semester value='{$semester}'>";
    $href .= "semester={$semester}&";
}
if ( $tahun != "" )
{
    $qfield .= " AND jadwalkuliah.TAHUN='{$tahun}'";
    $qjudul .= " Tahun Akademik  ".( $tahun - 1 )."/{$tahun}  <br>";
    $qinput .= " <input type=hidden name=tahun value='{$tahun}'>";
    $href .= "tahun={$tahun}&";
}
if ( $iddepartemen != "" )
{
    $qfield .= " AND jadwalkuliah.IDPRODI='{$iddepartemen}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$iddepartemen]."' <br>";
    $qinput .= " <input type=hidden name=iddepartemen value='{$iddepartemen}'>";
    $href .= "iddepartemen={$iddepartemen}&";
}
if ( $makul != "" )
{
    $qfield .= " AND IDMAKUL = '{$makul}'";
    $qjudul .= " ID MAKUL = {$makul} (".getnamafromtabel( $makul, "makul" ).") <br>";
    $qinput .= " <input type=hidden name=makul value='{$makul}'>";
    $href .= "makul={$makul}&";
}
if ( $kelasjadwal != "" )
{
    $qfield .= " AND KELAS = '{$kelasjadwal}'";
    $qjudul .= " Kelas = '{$kelasjadwal}' <br>";
    $qinput .= " <input type=hidden name=kelasjadwal value='{$kelasjadwal}'>";
    $href .= "kelasjadwal={$kelasjadwal}&";
}
if ( $hari != "" )
{
    $qfield .= " AND HARI='{$hari}'";
    $qjudul .= " Hari '".$arrayhari[$hari]."' <br>";
    $qinput .= " <input type=hidden name=hari value='{$hari}'>";
    $href .= "hari={$hari}&";
}
$qjudul .= "Antara jam {$jamawal} s.d {$jamakhir} <br>";
$qinput .= " <input type=hidden name=jamawal value='{$jamawal}'>";
$qinput .= " <input type=hidden name=jamakhir value='{$jamakhir}'>";
if ( $sort == "" )
{
    $sort = " ID";
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$tmp = explode( ":", $jamawal );
$detikawal = $tmp[0] * 3600 + $tmp[1] * 60 + $tmp[2];
$tmp = explode( ":", $jamakhir );
$detikakhir = $tmp[0] * 3600 + $tmp[1] * 60 + $tmp[2];
$i = 0;
unset( $arrayruangkosong );
foreach ( $arrayruangan as $k => $v )
{
    $q = "SELECT  IDPRODI,\r\n    TIME_TO_SEC(MULAI) AS M,\r\n    TIME_TO_SEC(SELESAI) AS S,\r\n  TIME_TO_SEC(MULAI)-1 AS AKHIR2,\r\n  TIME_TO_SEC(SELESAI)+1 AS AWAL2\r\n   FROM jadwalkuliah  \r\n\t WHERE   \r\n   HARI='{$hari}'\r\n\t  \r\n\t AND IDRUANGAN='{$k}'\r\n\t {$qfield}\r\n\tORDER BY MULAI";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $detikawal2 = $detikawal;
        $detikakhir2 = $detikakhir;
        while ( $d = sqlfetcharray( $h ) )
        {
            if ( $detikawal2 < $d[M] )
            {
                $arrayruangkosong[$i][R] = $k;
                $arrayruangkosong[$i][H] = $hari;
                $arrayruangkosong[$i][1] = $detikawal2;
                $arrayruangkosong[$i][2] = $d[AKHIR2];
                $detikawal2 = $d[AWAL2];
                ++$i;
            }
            else
            {
                $detikawal2 = $d[AWAL2];
            }
        }
        if ( $detikawal2 < $detikakhir )
        {
            $arrayruangkosong[$i][R] = $k;
            $arrayruangkosong[$i][H] = $hari;
            $arrayruangkosong[$i][1] = $detikawal2;
            $arrayruangkosong[$i][2] = $detikakhir;
            $detikawal2 = $d[AWAL2];
            ++$i;
        }
    }
    else
    {
        $arrayruangkosong[$i][R] = $k;
        $arrayruangkosong[$i][H] = $hari;
        $arrayruangkosong[$i][1] = $detikawal;
        $arrayruangkosong[$i][2] = $detikakhir;
        ++$i;
    }
}
if ( is_array( $arrayruangkosong ) )
{
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        ";
    #if ( $aksi != "cetak" )
    #{
    #    printjudulmenu( "Data Ruangan Kosong" );
    #    printmesg( $qjudul );
    #}
    #else
    #{
    #    printjudulmenu( "Data Ruangan Kosong" );
    #    printmesgcetak( $qjudul );
    #}
    if ( $aksi != "cetak" && $asal != "depan" )
    {
     #   echo "\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakkosong.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t \r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n \t\t\t \r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
		printmesg( "Data Ruangan Kosong" );
        printmesg( $qjudul ); 
		echo "						<div class=\"tools\">
										<form action=index.php method=post target=_blank action='cetakkosong.php'>
											<div class=\"table-scrollable\">
											<table class=\"table table-striped table-bordered table-hover\">
												<tr>
													<td>
														<input type=submit name=aksi class=\"btn btn-brand\" value='Cetak'>\r\n \t\t\t\t \r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n \t\t\t \r\n\t\t\t
													</td>
												</tr>
											</table>
										</form>
									</div>{$tpage} {$tpage2}";
	}
    /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br><br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Tambah Data Ruangan </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
    #echo "\r\n\t\t<br>\r\n \t\t\t<table class=\"table table-striped table-bordered table-hover\">\r\n\t\t\t<thead><tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<th scope=col>No</th>\r\n \r\n \t\t\t\t<th scope=col> Ruangan</th>\r\n\t\t\t\t \r\n\t\t\t\t<th scope=col> Jam Kosong  </th>\r\n \r\n \r\n\t\t\t</tr></thead>\r\n\r\n  ";
    echo "							<div class=\"m-portlet\">			
										<div class=\"m-section__content\">
											<div class=\"table-responsive\">
												<table class=\"table table-bordered table-hover\">
													<thead>
														<tr class=juduldata{$aksi} align=center>\r\n\t\t\t\t<th scope=col>No</th>\r\n \r\n \t\t\t\t<th scope=col> Ruangan</th>\r\n\t\t\t\t \r\n\t\t\t\t<th scope=col> Jam Kosong  </th>\r\n \r\n \r\n\t\t\t</tr>
													</thead>
													<tbody>";
    
	$i = 0;
    foreach ( $arrayruangkosong as $k => $d )
    {
        $jam1 = floor( $d[1] / 3600 );
        if ( $jam1 < 10 )
        {
            $jam1 = "0{$jam1}";
        }
        $sisadetik = $d[1] % 3600;
        $menit1 = floor( $sisadetik / 60 );
        if ( $menit1 < 10 )
        {
            $menit1 = "0{$menit1}";
        }
        $detik1 = $sisadetik % 60;
        if ( $detik1 < 10 )
        {
            $detik1 = "0{$detik1}";
        }
        $jam2 = floor( $d[2] / 3600 );
        if ( $jam2 < 10 )
        {
            $jam2 = "0{$jam2}";
        }
        $sisadetik = $d[2] % 3600;
        $menit2 = floor( $sisadetik / 60 );
        if ( $menit2 < 10 )
        {
            $menit2 = "0{$menit2}";
        }
        $detik2 = $sisadetik % 60;
        if ( $detik2 < 10 )
        {
            $detik2 = "0{$detik2}";
        }
        ++$i;
        $kelas = kelas( $i );
        echo "\r\n\t\t\t\t<tr valign=top align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td class='makeborder'>{$i}&nbsp;</td>\r\n \t\t\t\t \r\n   \t\t\t\t\t<td nowrap class='makeborder'>".$arrayruangan[$d[R]]."&nbsp;</td>\r\n \t\t\t\t\t \r\n  \t\t\t\t\t<td  class='makeborder'> {$jam1}:{$menit1}:{$detik1}  - {$jam2}:{$menit2}:{$detik2}&nbsp;</td>\r\n \r\n\t\t\t\t</tr>\r\n\t\t\t";
    }
    echo "											</tbody>
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
    printjudulmenu( "Data Ruang Kosong" );
    printmesg( "Data Ruangan Kosong Tidak Ada" );
}
?>