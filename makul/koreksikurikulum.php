<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
$arraystatuskoreksi[0] = "Kode Kurikulum tidak ada di MSMHS";
$arraystatuskoreksi[1] = "Program Studi Kurikulum tidak ada di TBPST";
if ( $aksi == "tampilkan" )
{
    if ( $tahunk == "" )
    {
        $qfield = " AND THSMSTBKMK = '{$semesterk}'";
    }
    else
    {
        $qfield = " AND THSMSTBKMK = '".( $tahunk - 1 )."{$semesterk}'";
    }
    $qjudul .= " Semester/Tahun Akademik ".$arraysemester[$semesterk]." ".( $tahunk - 1 )."/{$tahunk} <br>";
    $qinput .= " <input type=hidden name=semesterk value='{$semesterk}'>";
    $qinput .= " <input type=hidden name=tahunk value='{$tahunk}'>";
    $href .= "semesterk={$semesterk}&tahunk={$tahunk}&";
    $q = "\r\n \r\n  SELECT tbkmk.KDPSTTBKMK,tbkmk.KDJENTBKMK,KDKMKTBKMK,NAKMKTBKMK,THSMSTBKMK,\r\n  1 AS STATUS\r\n  FROM  tbkmk\r\n  LEFT JOIN tbpst\r\n  ON \r\n  tbpst.KDPSTTBPST=tbkmk.KDPSTTBKMK AND\r\n  tbpst.KDJENTBPST=tbkmk.KDJENTBKMK\r\n \r\n  WHERE \r\n    \r\n  (tbpst.KDJENTBPST IS NULL OR tbpst.KDPSTTBPST IS NULL)\r\n  {$qfield}\r\n\r\n  ORDER BY KDKMKTBKMK\r\n  ";
    $h = mysqli_query($koneksi,$q);
    echo mysqli_error($koneksi);
    if ( 0 < sqlnumrows( $h ) )
    {
        if ( $cetak != "cetak" )
        {
            printjudulmenu( "KOREKSI DATA KURIKULUM", "bantuan" );
            printhelp( "{$help_koreksikurikulum}", "bantuan" );
            echo "\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakkoreksikurikulum.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
        }
        else
        {
            printjudulmenucetak( "KOREKSI DATA KURIKULUM" );
        }
        echo "\r\n    <table class=form>\r\n      <tr class=juduldata valign=top align=center>\r\n        <td>No</td>\r\n         <td>Kode PST</td>\r\n        <td>Kode Jenjang</td>\r\n         <td>Tahun-Semester</td>\r\n        <td>Nama Kurikulum</td>\r\n        <td>Keterangan</td>\r\n      </tr>\r\n    ";
        $i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$i;
            $kelas = kelas( $i );
            echo "\r\n       <tr {$kelas} valign=top align=center>\r\n        <td>{$i}</td>\r\n         <td>{$d['KDPSTTBKMK']}</td>\r\n        <td>{$d['KDJENTBKMK']}-".$arrayjenjang[$d[KDJENTBKMK]]."</td>\r\n        <td align=left>{$d['THSMSTBKMK']}</td>\r\n        <td align=left>{$d['NAKMKTBKMK']}</td>\r\n        <td>".IKONWARNING." {$statustambahan}".$arraystatuskoreksi[$d[STATUS]]."</td>\r\n      </tr>\r\n    ";
        }
        echo "\r\n    </table>\r\n    ";
    }
    else
    {
        $aksi = "";
        #printjudulmenu( "KOREKSI DATA KURIKULUM", "bantuan" );
        printhelp( "{$help_koreksikurikulum}", "bantuan" );
        printmesg( "Tidak ada data Kurikulum yang berpotensi tidak valid berdasarkan tabel referensi." );
    }
}
if ( $aksi == "" )
{
    if ( !isset( $_POST['aksi'] ) )
    {
        echo " <div class='postcontent'>";
    }
    printmesg( $errmesg );
    /*echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> Koreksi Data Kurikulum </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Koreksi Data Kurikulum");
								echo	"</div>
										</div>
									<div class='portlet-body form'>";
    echo "\r\n\t\t<form name=form action=index.php method=post>\r\n\t\t\t<input type=hidden name=pilihan value='{$pilihan}'>\r\n\t\t\t<input type=hidden name=aksi value='tampilkan'><table class=\"table table-striped table-bordered table-hover\">\r\n \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tTahun Akademik / Semester\r\n\t\t\t\t</td>\r\n\t\t\t\t<td>".createinputtahunajaransemester( 0, "tahunk", "semesterk" )." \r\n\t\t\t\t</td>\r\n\t\t\t</tr>
        </table>\r\n\t\t\r\n \t</div></div><input type=submit value='Tampilkan' class=\"btn btn-brand\"></form><br><br><br><br><br><br></div></div></div><br><br><br><br><br><br>";
}
?>
