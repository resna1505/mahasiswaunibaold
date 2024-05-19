<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi == "" )
{
    #printjudulmenu( "Data Mahasiswa" );
    $arraymenutab[9] = "Ringkasan";
    $arraymenutab[0] = "Biodata";
    #$arraymenutab[9] = "Biodata (2)";
    #$arraymenutab[5] = "Aktivitas<br>Kuliah*";
    $arraymenutab[6] = "Nilai<br>Semester*";
	$arraymenutab[7] = "Pembayaran";
    $arraymenutab[8] = "Konversi<br>Nilai";
    $arraymenutab[1] = "Kelulusan/Cuti/<br>Non-Aktif/DO";
    $arraymenutab[3] = "Skripsi";
    $arraymenutab[11] = "Beasiswa";
    $arraymenutab[4] = "Pindahan";
    $arraymenutab[10] = "Mhs Asing";
    $arraymenutab[2] = "Riwayat Pendidikan<br> u/ S-3";
    #echo "\t\t\t\r\n\t\t<table width=95% class=menutab>\r\n\t\t\t<tr>\r\n\t";
	echo "<div class=\"page-content\">
        <div class=\"container-fluid\">
<div class=\"row\">
                <div class=\"col-md-12\">
                
                    <!-- BEGIN SAMPLE FORM PORTLET-->
                    <div class=\"portlet light\">";
						printmesg( $errmesg );
                        echo "<div class=\"portlet-body form\">
								<div class='tab-pane' id='tab_1'>
									<div class='portlet box blue'>
										<div class='portlet-title'>
											<div class='caption'>";
												printmesg("Data Mahasiswa");
	echo "				</div>
										</div>
										<div class='portlet-body form'>
											<div class=\"portlet-body\">											
												<div class=\"m-portlet__body\">
													<ul class=\"nav nav-tabs\" role=\"tablist\">";
    if ( $tab == "" )
    {
        $tab = 9;
    }
    foreach ( $arraymenutab as $k => $v )
    {
        $bgtab = "";
        /*if ( $tab == $k )
        {
            $bgtab = " style='color:#004488' ";
        }*/
		if ( $tab == $k )
        {
            $bgtab = "class='nav-link active' style='color:#004488' ";
        
		}else{
			$bgtab = "class='nav-link active' ";
		}
        #echo "\r\n\t\t\t\t\t<td align=center ><a {$bgtab} href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$k}&idupdate={$idupdate}'>{$v}</td>\r\n\t\t";
		echo "<li class=\"nav-item\">
					<a {$bgtab} href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$k}&idupdate={$idupdate}'>{$v}</a>";
		echo "</li>";
    }
    #echo "\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t";
	echo "</ul>";
	echo "<div class=\"tab-content\">";
	if($tab == "" || $tab == 9){
		include( "akademik.php" );
	}
    elseif ( $tab == 0 )
    {
        include( "biodata.php" );
    }
    else
    {
        if ( $tab == 1 )
        {
            include( "kelulusan.php" );
        }
        else
        {
            if ( $tab == 2 )
            {
                include( "riwayatpendidikan.php" );
            }
            else
            {
                if ( $tab == 3 )
                {
                    include( "skripsi.php" );
                }
                else
                {
                    if ( $tab == 4 )
                    {
                        include( "pindahan.php" );
                    }
                    else
                    {
                        if ( $tab == 5 )
                        {
                            include( "aktivitas.php" );
                        }
                        else
                        {
                            if ( $tab == 6 )
                            {
                                include( "semester.php" );
                            }
                            else
                            {
                                if ( $tab == 8 )
                                {
                                    include( "konversi.php" );
                                }
                                else
                                {
                                    if ( $tab == 9 )
                                    {
                                        include( "biodata2.php" );
                                    }
                                    else
                                    {
                                        if ( $tab == 10 )
                                        {
                                            include( "asing.php" );
                                        }
                                        else
                                        {
                                            if ( $tab == 11 )
                                            {
                                                include( "beasiswa.php" );
                                            }
                                            else
                                            {
												#echo "ll";
                                                #include( "../mahasiswa/biodata2lengkap.php" );
												include("payment.php" );
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
    }
	echo "</div>
	<!--end::tab-content-->";
	echo "</div>
	<!--end::m-portlet__body-->
	</div>
	<!--end::portlet-body-->	
	</div>
	<!--end::portlet-body form-->
	</div>
	<!--end::portlet box blue-->
	</div>
	<!--end::tab-pane-->
	</div>
	<!--end::portlet-body form-->
	</div>
	<!--end::portlet light-->
	</div>
		<!--end::md-12-->	
	</div>
	<!--end::row-->	
</div>
<!--end::container-fluid-->";
}
?>
