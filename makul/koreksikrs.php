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
$arraystatuskoreksi[0] = "NIM Mahasiswa tidak ada di MSMHS";
$arraystatuskoreksi[1] = "Kode Mata Kuliah tidak ada di TBKMK";
$arraystatuskoreksi[2] = "Program Studi KRS Mahasiswa tidak ada di TBPST";
if ( $aksi == "tampilkan" )
{
    if ( $tahunk == "" )
    {
        $qfield = " AND THSMSTRNLM = '{$semesterk}'";
    }
    else
    {
        $qfield = " AND THSMSTRNLM = '".( $tahunk - 1 )."{$semesterk}'";
    }
    $qjudul .= " Semester/Tahun Akademik ".$arraysemester[$semesterk]." ".( $tahunk - 1 )."/{$tahunk} <br>";
    $qinput .= " <input type=hidden name=semesterk value='{$semesterk}'>";
    $qinput .= " <input type=hidden name=tahunk value='{$tahunk}'>";
    $href .= "semesterk={$semesterk}&tahunk={$tahunk}&";
    $q = "\r\n  SELECT trnlm.NIMHSTRNLM,trnlm.THSMSTRNLM,msmhs.NIMHSMSMHS AS NAMA,msmhs.KDPSTMSMHS,msmhs.KDJENMSMHS,\r\n  0 AS STATUS\r\n  FROM trnlm \r\n  LEFT JOIN msmhs\r\n  ON msmhs.NIMHSMSMHS=trnlm.NIMHSTRNLM\r\n  WHERE msmhs.NIMHSMSMHS IS NULL\r\n  {$qfield}\r\n\r\n  UNION\r\n\r\n  SELECT trnlm.NIMHSTRNLM,trnlm.THSMSTRNLM,msmhs.NIMHSMSMHS AS NAMA,msmhs.KDPSTMSMHS,msmhs.KDJENMSMHS,\r\n  1 AS STATUS\r\n  FROM   msmhs,trnlm\r\n  LEFT JOIN tbkmk\r\n  ON \r\n  tbkmk.KDKMKTBKMK=trnlm.KDKMKTRNLM AND\r\n  tbkmk.THSMSTBKMK=trnlm.THSMSTRNLM AND\r\n  tbkmk.KDPSTTBKMK=trnlm.KDPSTTRNLM AND\r\n  tbkmk.KDJENTBKMK=trnlm.KDJENTRNLM \r\n \r\n  WHERE \r\n  msmhs.NIMHSMSMHS=trnlm.NIMHSTRNLM AND\r\n   \r\n  (tbkmk.KDKMKTBKMK IS NULL)\r\n  \r\n{$qfield}\r\n  \r\n  UNION\r\n\r\n  SELECT trnlm.NIMHSTRNLM,trnlm.THSMSTRNLM,msmhs.NIMHSMSMHS AS NAMA,msmhs.KDPSTMSMHS,msmhs.KDJENMSMHS,\r\n  2 AS STATUS\r\n  FROM trnlm, msmhs\r\n  LEFT JOIN tbpst\r\n  ON \r\n  tbpst.KDPSTTBPST=msmhs.KDPSTMSMHS AND\r\n  tbpst.KDJENTBPST=msmhs.KDJENMSMHS\r\n \r\n  WHERE \r\n  msmhs.NIMHSMSMHS=trnlm.NIMHSTRNLM AND\r\n   \r\n  (tbpst.KDJENTBPST IS NULL OR tbpst.KDPSTTBPST IS NULL)\r\n{$qfield}\r\n\r\n  ORDER BY NIMHSTRNLM\r\n  ";
    $h = mysqli_query($koneksi,$q);
    echo mysqli_error($koneksi);
    if ( 0 < sqlnumrows( $h ) )
    {
        if ( $cetak != "cetak" )
        {
            #printjudulmenu( "KOREKSI DATA KRS MAHASISWA", "bantuan" );
            printhelp( "{$help_koreksikrs}", "bantuan" );
            echo "\r\n\t\t<div class=\"page-content\">
        <div class=\"container\">
<div class=\"row\">
                <div class=\"col-md-12\">
                <br><br>
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-title\">
                            <div class=\"caption font-green-haze\">
                                <i class=\"icon-settings font-green-haze\"></i>
                                <span class=\"caption-subject bold uppercase\"> KOREKSI DATA KRS MAHASISWA </span>
                            </div>
                            <div class=\"actions\">
                                <form target=_blank action='cetakkoreksikrs.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=\"btn green\" value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";

            #echo "\t{$tpage} {$tpage2}\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetakkoreksikrs.php'>\r\n\t\t\t".IKONCETAK32."\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n \t\t\t\t{$qinput}\r\n \t\t\t\t{$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
        }
        else
        {
            printjudulmenucetak( "KOREKSI DATA KRS MAHASISWA" );
        }
        

        echo "\r\n    <table class=\"table table-striped table-bordered table-hover\">\r\n      <tr class=juduldata valign=top align=center>\r\n        <td>No</td>\r\n        <td>Tahun-Semester</td>\r\n        <td>Kode PST</td>\r\n        <td>Kode Jenjang</td>\r\n        <td>NIM</td>\r\n        <td>Nama Mahasiswa</td>\r\n        <td>Keterangan</td>\r\n      </tr>\r\n    ";
        $i = 0;
        while ( $d = sqlfetcharray( $h ) )
        {
            ++$i;
            $kelas = kelas( $i );
            echo "\r\n       <tr {$kelas} valign=top align=center>\r\n        <td>{$i}</td>\r\n        <td>{$d['THSMSTRNLM']}</td>\r\n        <td>{$d['KDPSTMSMHS']}</td>\r\n        <td>{$d['KDJENMSMHS']}-".$arrayjenjang[$d[KDJENMSMHS]]."</td>\r\n        <td>{$d['NIMHSTRNLM']}</td>\r\n        <td align=left>{$d['NAMA']}</td>\r\n        <td align=left>".IKONWARNING." {$statustambahan}".$arraystatuskoreksi[$d[STATUS]]."</td>\r\n      </tr>\r\n    ";
        }
        echo "\r\n    </table>\r\n    </div></div>{$tpage} {$tpage2}</div></div></div>";
    }
    else
    {
        printjudulmenu( "KOREKSI DATA KRS MAHASISWA", "bantuan" );
        printhelp( "{$help_koreksikrs}", "bantuan" );
        printmesg( "Tidak ada data KRS Mahasiswa yang berpotensi tidak valid berdasarkan tabel referensi." );
        $aksi = "";
    }
}
if ( $aksi == "" )
{
    #printjudulmenu( "KOREKSI DATA KRS MAHASISWA", "bantuan" );
    #printmesg( $errmesg );
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
                                <span class=\"caption-subject bold uppercase\"> KOREKSI DATA KRS MAHASISWA </span>
                            </div>
                            <div class=\"actions\">
                                
                            </div>
                        </div>
                        <div class=\"portlet-body form\">
                        <div class=\"table-scrollable\">";*/
	/*echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">
                        <div class=\"portlet-body form\"><div class='tab-pane' id='tab_1'>
								<div class='portlet box blue'>
									<div class='portlet-title'>
										<div class='caption'>";
											printmesg("Koreksi Data KRS Mahasiswa");
								echo	"</div>
										</div>
									<div class='portlet-body form'>";*/
	 echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
			<div class=\"row\">
                <div class=\"col-md-12\">
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    ";
						printmesg( $errmesg );
		echo "			<div class='portlet-title'>";
								printmesg("Koreksi Data KRS Mahasiswa");
				echo "	</div>";
										
		echo "			<div class=\"m-portlet\">
				
							<!--begin::Form-->";
    echo "				<form name=form class=\"m-form m-form--fit m-form--label-align-right m-form--group-seperator\" action=index.php method=post>
						<input type=hidden name=pilihan value='{$pilihan}'>
						<input type=hidden name=aksi value='tampilkan'>
						<div class=\"m-portlet__body\">		
							<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">Semester Tahun Akademik</label>\r\n    
								<div class=\"col-lg-6\">";
	echo "							<select name=tahunk class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t ";
										$arrayangkatan = getarrayangkatan( "R" );
										foreach ( $arrayangkatan as $k => $v )
										{
											$selected = "";
											if ( $k == $waktu[year] )
											{
												$selected = "selected";
											}
											echo "\r\n\t\t\t\t\t\t\t<option value='".$k."' {$selected}>".( $v - 1 )."/{$v}</option>\r\n\t\t\t\t\t\t\t";
										}
	echo "								<option value='' >-</option>
									</select>";
    $waktu = getdate( );
    echo "							<select name=semesterk class=form-control m-input style=\"width:auto;display:inline-block;\"> \r\n\t\t\t\t\t\t ";
										$arraysemester[''] = "-";
										foreach ( $arraysemester as $k => $v )
										{
											echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$cek}>{$v}</option>\r\n\t\t\t\t\t\t\t";
										}
	echo "							</select>
								</div>
							</div>
							<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">&nbsp;</label>\r\n    
								<div class=\"col-lg-6\">
									<input type=submit value='Tampilkan' class=\"btn btn-brand\">
								</div>
							</div>
					</div>
			</form>
				<!--end::Form-->
			</div>
			<!--end::Portlet-->
					</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->
            <script>
                form.id.focus();
            </script>";
}
?>
