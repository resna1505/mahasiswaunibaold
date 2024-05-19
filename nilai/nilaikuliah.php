<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/
/*print_r($judulsubmenu);
echo '<br>';
print_r($kodemenu);
echo '<br>';
print_r($arraysubmenu);
echo '<br>';*/
#echo $jenisusers.$pilihan;
if ( $aksi != "" || $aksi == "" )
{
    printjudulmenu( "Nilai Kuliah" );
    #$arraymenutab[0] = "Kartu Hasil Studi";
	#$arraymenutab[1] = "Daftar Nilai Ujian";
	$arraymenutab = array( array( "judul" => 'Kartu Hasil Studi',
						 "k" => 0,
                        "pilihan" => "khs"),
                 array( "judul" => "Daftar Nilai Ujian",
						 "k" => 1,
                        "pilihan" => "daftarnilai"));  
				
    echo "\t\t\t\r\n\t\t<table width=95% class=menutab>\r\n\t\t\t<tr>\r\n\t";
    if ( $tab == "" )
    {
        $tab = 0;
    }

    foreach ( $arraymenutab as $k => $v )
    {
        $bgtab = "";
        if ( $tab == $k )
        {
            $bgtab = " style='color:#004488' ";
        }
		
			echo "\r\n\t\t\t\t\t<td align=center ><a {$bgtab} href='index.php?pilihan={$v['pilihan']}&tab={$v['k']}&idupdate={$users}'>{$v['judul']}</td>\r\n\t\t";
		
	}
    echo "\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t";
	if(($tab == "" || $tab == 0) && ($pilihan == "khs" || $pilihan == "")){
	
		if ( isoperator( ) || ismahasiswa( ) || iswali( ) )
		{
			include( "khs.php" );
		}
	}
    #elseif ((($jenisusers==2 || $jenisusers==3) && ($pilihan=="daftarnilai" || $pilihan=="" ) ) || ($pilihan=="" && ($jenisusers==0  )) && $tab == 1) 
    #elseif ($jenisusers==2)    
	elseif ((($jenisusers==2 || $jenisusers==3) && ($pilihan=="daftarnilai" || $pilihan=="" ) ) || ($pilihan=="" && ($jenisusers==0  )) && $tab == 1) 
    {
		#echo "mmm";exit();
        include( "daftarnilai.php" );
		
    }
    /*else
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
    }*/
}
?>
