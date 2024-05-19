<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
#echo $tglbayar['thn'].$tglbayar['bln'];exit();
$vld[] = cekvaliditastanggal( "Periode : Awal", $tglbayar['tgl'], $tglbayar['bln'], $tglbayar['thn'] );
$vld[] = cekvaliditastanggal( "Periode : Akhir", $tglbayar2['tgl'], $tglbayar2['bln'], $tglbayar2['thn'] );
$vld[] = cekvaliditasnama( "Kata Kunci", $kunci );
$vld = array_filter( $vld, "filter_not_empty" );
if ( isset( $vld ) && 0 < count( $vld ) )
{
    $errmesg = val_err_mesg( $vld, 2, CARI_DATA );
    $aksi = "";
}
else if(!isset($kunci)){
    $errmesg = "Kata Kunci Keterangan harus diisi";
    $aksi = "";

}

else if($tglbayar['thn'].$tglbayar['bln']!=$tglbayar2['thn'].$tglbayar2['bln']){
    $errmesg = "Tahun dan Bulan Periode Tidak Sama";
    $aksi = "";

}
else
{
    $href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
    if ( $jenislog != "" )
    {
        $qfield .= " AND JENIS='{$jenislog}'";
        $qjudul .= " Jenis Log '".$arraylog[$jenislog]."' <br>";
        $qinput .= " <input type=hidden name=jenislog value='{$jenislog}'>";
        $href .= "jenislog={$jenislog}&";
    }
    if ( trim( $kunci ) != "" )
    {
        $kunci = trim( $kunci );
        $qfield .= " AND (KET  LIKE '%{$kunci}%' OR ASAL LIKE '%{$kunci}%' OR IDUSER LIKE '%{$kunci}%') ";
        $qjudul .= " Kata kunci keterangan '{$kunci}' <br>";
        $qinput .= " <input type=hidden name=kunci value='{$kunci}'>";
        $href .= "kunci={$kunci}&";
    }
    	
    #if ( $istglbayar == 1 )
    #{
        $qfield .= "\r\n \t\t\tAND \r\n \t\t\t(\r\n \t\t\t\tDATE_FORMAT(TANGGAL,'%Y-%m-%d') >= DATE_FORMAT('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','%Y-%m-%d')\r\n \t\t\t\tAND\r\n \t\t\t\tDATE_FORMAT(TANGGAL,'%Y-%m-%d') <= DATE_FORMAT('{$tglbayar2['thn']}-{$tglbayar2['bln']}-{$tglbayar2['tgl']}','%Y-%m-%d')\r\n \t\t\t)\r\n \t\t";
        $qjudul .= " Periode  {$tglbayar['tgl']}-{$tglbayar['bln']}-{$tglbayar['thn']} s.d\r\n\t\t {$tglbayar2['tgl']}-{$tglbayar2['bln']}-{$tglbayar2['thn']} \r\n\t\t <br>";
        $qinput .= " \r\n\t\t\t<input type=hidden name=istglbayar value='{$istglbayar}'>\r\n\t\t\t<input type=hidden name=tglbayar[thn] value='{$tglbayar['thn']}'>\r\n\t\t\t<input type=hidden name=tglbayar[bln] value='{$tglbayar['bln']}'>\r\n\t\t\t<input type=hidden name=tglbayar[tgl] value='{$tglbayar['tgl']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[thn] value='{$tglbayar2['thn']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[bln] value='{$tglbayar2['bln']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[tgl] value='{$tglbayar2['tgl']}'>\r\n\t\t";
        $href .= "tglbayar[tgl]={$tglbayar['tgl']}&tglbayar[bln]={$tglbayar['bln']}&tglbayar[thn]={$tglbayar['thn']}&\r\n\t\ttglbayar2[tgl]={$tglbayar2['tgl']}&tglbayar2[bln]={$tglbayar2['bln']}&tglbayar2[thn]={$tglbayar2['thn']}&istglbayar={$istglbayar}&";
    #}
    if ( $sort == "" )
    {
        $sort = " ID";
    }
    $qinput .= " <input type=hidden name=sort value='{$sort}'>";
    $q = "SELECT COUNT(*) AS JML FROM log\r\n\t\tWHERE 1=1 {$qprodidep3}\r\n\t\t{$qfield}\r\n\t\t";
    $h = mysqli_query($koneksi,$q);
    $d = sqlfetcharray( $h );
    $total = $d[JML];
    include( "../paginating.php" );
    $q = "SELECT * FROM log WHERE 1=1 {$qfield} ORDER BY {$sort} {$qlimit}";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
	echo "<div class=\"page-content\">
            <div class=\"container-fluid\">
                <div class=\"row\">
                    <div class=\"col-md-12\">
                        <div class=\"portlet light\">
							<div class='portlet box blue'>
								<div class=\"portlet-title\">";
									printmesg( $errmesg );
									printtitle("Data Log");

        if ( $aksi != "cetak" )
        {
            #printjudulmenu( "Data Log" );
            #printmesg( $qjudul );
		printtitle( $qjudul );
        }
        #else
        #{
        #    printjudulmenucetak( "Data Log" );
        #    printmesgcetak( $qjudul );
        #}
        if ( $aksi != "cetak" )
        {
		echo " {$tpage} {$tpage2}";
		echo "	<form target=_blank action='cetaklog.php'>
				<div class=\"table-scrollable\">
					<table class=\"table table-striped table-bordered table-hover\">
						<tr>
							<td>
								<input type=submit name=aksi2 class=\"btn btn-brand\" value='Cetak'>";
		echo "{$qinput}{$input}</td></tr></table></div></form>";


            #echo "\r\n\t\t\t<form target=_blank action='cetaklog.php'>\r\n      {$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n \t\t\t\t<input type=submit name=aksi2 class=tombol value='Cetak'>\r\n  \t\t\t\t{$qinput}\r\n  \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
        }
        	echo "	<div class=\"m-portlet\">			
				<div class=\"m-section__content\">
					<div class=\"table-responsive\">
						<table class=\"table table-bordered table-hover table-striped2\">
							<thead>
								<tr>
									<th scope=\"col\">No</th>
									<th><a class='{$cetak}' href='{$href}"."sort=TANGGAL'>Tanggal</th>
									<th><a class='{$cetak}' href='{$href}"."sort=JENIS'>Jenis</th>
									<th><a class='{$cetak}' href='{$href}"."sort=IDUSER'>User</th>
									<th><a class='{$cetak}' href='{$href}"."sort=KET'>Keterangan</th>
									<th><a class='{$cetak}' href='{$href}"."sort=ASAL'>Asal</th>
								</tr>
							</thead>
							<tbody>";
        $i = 1;
        while ( $d = sqlfetcharray( $h ) )
        {
            $kelas = kelas( $i );
            echo "\r\n\t\t\t\t<tr valign=top align=center {$kelas}{$aksi}>\r\n\t\t\t\t\t<td>{$i}</td>\r\n \t\t\t\t\t<td align=left nowrap>{$d['TANGGAL']}</td>\r\n\t\t\t\t\t<td align=left   >".$arraylog[$d[JENIS]]."</td>\r\n \t\t\t\t\t<td align=left>{$d['IDUSER']}</td>\r\n \t\t\t\t\t<td align=left>{$d['KET']}</td> \r\n \t\t\t\t\t<td align=center>{$d['ASAL']}</td> \r\n \t\t\t\t</tr>\r\n\t\t\t";
            ++$i;
        }
        echo "								</tbody>
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
        $errmesg = "Data Log Tidak Ada";
        $aksi = "";
    }
}
?>
