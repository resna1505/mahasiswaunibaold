<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot();
print_r($_SESSION)."<br>";
include( $root."menu.php" );
include( $root."pooling.php" );
include( $root."link.php" );
print_r($_SESSION).'<br>';

include( "submenu.php" );
include( "init.php" );
set_last_aksi( $users, $jenisusers );
printheader_dlm();
#print_r($arraysubmenu);
#echo $jenisusers."".$_SESSION[TAMPILAN][MENUUTAMA];
if ( $jenisusers == 2 ) //mahasiswa
{
    
    session_register_sikad( "alertkeuangan" );
	#echo $aaa;exit();
    if ( $JENISKELAS == 1 && getaturan( "BIAYAKEUANGAN" ) == 1 )
    {
        $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS!='' AND biayakomponen.JENISKELAS=mahasiswa.JENISKELAS ";
    }
    else
    {
        $qfieldjeniskelasm = " AND biayakomponen.JENISKELAS='' ";
    }
    /*$q = "SELECT komponenpembayaran.NAMA ,komponenpembayaran.JENIS,biayakomponen.IDKOMPONEN,biayakomponen.BIAYA FROM ".
	"biayakomponen,komponenpembayaran,mahasiswa WHERE biayakomponen.IDKOMPONEN=komponenpembayaran.ID AND komponenpembayaran.JENIS=5 AND ".
	"komponenpembayaran.ID='002' AND mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND mahasiswa.IDPRODI=biayakomponen.IDPRODI AND ".
	"mahasiswa.ID='{$users}' {$qfieldjeniskelasm}";*/
	//query buat batam
	
	$q = "SELECT komponenpembayaran.NAMA ,komponenpembayaran.JENIS,biayakomponen.IDKOMPONEN,biayakomponen.BIAYA FROM ".
	"biayakomponen,komponenpembayaran,mahasiswa WHERE biayakomponen.IDKOMPONEN=komponenpembayaran.ID AND komponenpembayaran.JENIS=3 AND ".
	"komponenpembayaran.ID='032' AND mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND mahasiswa.IDPRODI=biayakomponen.IDPRODI AND ".
	"mahasiswa.ID='{$users}' {$qfieldjeniskelasm}";
    
	//end query buat batam
	
	// query buat lampung
	
	/*$q = "SELECT komponenpembayaran.NAMA ,komponenpembayaran.JENIS,biayakomponen.IDKOMPONEN,biayakomponen.BIAYA FROM ".
	"biayakomponen,komponenpembayaran,mahasiswa WHERE biayakomponen.IDKOMPONEN=komponenpembayaran.ID AND (komponenpembayaran.JENIS=3 OR komponenpembayaran.JENIS=5)  AND ".
	"komponenpembayaran.ID='002' AND mahasiswa.ANGKATAN=biayakomponen.ANGKATAN AND mahasiswa.IDPRODI=biayakomponen.IDPRODI AND ".
	"mahasiswa.ID='{$users}' {$qfieldjeniskelasm}";
	*/
	//end query buat lampung
	
    #echo $q;
	#echo $q;
    //exit();
    $h = mysqli_query($koneksi, $q);
    #print_r($h);
	if ( 0 < mysqli_num_rows( $h ) )
    {
        $mesgalertuang = "";
        #do
		$d=mysqli_fetch_array($h);
		#while($d=mysqli_fetch_array($h))
        #{
			#$bln_jalan=date('m');
			#echo $bln_jalan;
            $q = "SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE TAHUNAJARAN='{$w['year']}' AND SEMESTER='{$w['mon']}' AND IDKOMPONEN='{$d['IDKOMPONEN']}' AND IDMAHASISWA='{$users}'";
            #$q = "SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE YEAR(TANGGALBAYAR)='{$w['year']}' AND MONTH(TANGGALBAYAR)='{$bln_jalan}' AND IDKOMPONEN='{$d['IDKOMPONEN']}' AND IDMAHASISWA='{$users}'";
            #echo $q.'<br>';
			#$q = "SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE YEAR(TANGGALBAYAR)='{$w['year']}' AND MONTH(TANGGALBAYAR)='{$bln_jalan}' AND IDKOMPONEN='{$d['IDKOMPONEN']}' AND IDMAHASISWA='{$users}'";
        
			//query buat lampung
			
			//ambil waktu pembayaran untuk tiap jenis (KRS,UTS,UAS)
			/*$sqlgetwaktubayar="SELECT TANGGALMULAI,TANGGALSELESAI FROM waktukeuangan WHERE JENIS='KRS' ORDER BY TAHUN DESC LIMIT 1";
			$querygetwaktubayar=mysql_query($sqlgetwaktubayar,$koneksi);
			$datagetwaktubayar=mysqli_fetch_array($querygetwaktubayar);
		
			#$q = "SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE YEAR(TANGGALBAYAR)='{$w['year']}' AND IDKOMPONEN='{$d['IDKOMPONEN']}' ".
			#"AND IDMAHASISWA='{$users}'";
            $q = "SELECT SUM(JUMLAH+DISKON) AS TOTAL FROM bayarkomponen WHERE TANGGALBAYAR>='$datagetwaktubayar[TANGGALMULAI]' ".
			"AND TANGGALBAYAR<='$datagetwaktubayar[TANGGALSELESAI]' AND IDKOMPONEN='{$d['IDKOMPONEN']}' ".
			"AND IDMAHASISWA='{$users}'";*/
			//end query	
			#echo $q;
			$h2 = mysqli_query($koneksi, $q);
            $d2 = mysqli_fetch_array( $h2 );
            $biaya = $d[BIAYA];
            #$q = "SELECT DISKON FROM diskonbeasiswa WHERE IDMAHASISWA='{$users}' AND IDKOMPONEN='{$d['IDKOMPONEN']}' AND TAHUN='{$w['year']}' AND SEMESTER='{$w['mon']}' ";
            #$q = "SELECT DISKON FROM diskonbeasiswa WHERE IDMAHASISWA='{$users}' AND IDKOMPONEN='{$d['IDKOMPONEN']}' AND YEAR(TANGGALUPDATE)='{$w['year']}'";
            #echo $q.'<br>';
			$q = "SELECT DISKON FROM diskonbeasiswa WHERE IDMAHASISWA='{$users}' AND IDKOMPONEN='{$d['IDKOMPONEN']}' ORDER BY TANGGALUPDATE DESC LIMIT 1";
			$h = mysqli_query($koneksi, $q);
            if ( 0 < mysqli_num_rows( $h ) )
            {
                $d = mysqli_fetch_array( $h );
				$beasiswa = $d[DISKON];
				if($beasiswa>100){
	
						$biaya = $biaya - $beasiswa;
					}else{
					
						$biaya = $biaya * ( 100 - $beasiswa ) / 100;
					}
                #$beasiswa = $d[DISKON];
                #$biaya = $biaya * ( 100 - $beasiswa ) / 100;
            }
			#echo $biaya."bbbb".$d2[TOTAL];
            $sisa = $biaya - $d2[TOTAL];
			#echo $d2[TOTAL]."XXX".$biaya;
            if ( $d2[TOTAL] < $biaya * 2 )
			#if ( $d2[TOTAL] < $biaya)
            {
                $mesgalertuang .= " biaya {$d['NAMA']} sebesar Rp. ".cetakuang( $sisa ).", ";
            }
        #} #while ( 1 );
    }
    //echo $mesgalertuang;
    //exit();
    if ( $mesgalertuang != "" && $alertkeuangan == "" )
    {
        #$mesgalertuang = "Anda belum membayar {$mesgalertuang} silakan lunasi pembayaran Anda.";
		$mesgalertuang = "Anda belum membayar administrasi keuangan, silakan hubungi bagian keuangan";
        //echo "<script>alert('{$mesgalertuang}');</script>";
        $alertkeuangan = 1;
    }
}
$ret = pengingatpassword( $users, $jenisusers );

if ( $jenisusers == 0 && $ret == 0 )
{
    pengingatbackup($users);
}
if ($_SESSION[TAMPILAN][MENUUTAMA] == 0 || $_SESSION[TAMPILAN][MENUUTAMA] == "" )
{
	print_r($_SESSION);exit();
    printmenudropdown($arraymenu);
    echo "</header> <!--- END HEADER -->";
	
	include( "aksi.php" );
    #echo "\r\n    </div>\r\n    </div>\r\n    </div><!-- end contentwrapper -->\r\n    ";
	echo "\r\n    </div>\r\n    </div>\r\n    </div>   ";
    if ( $_SESSION[TAMPILAN][SUBMENU] == 1 )
    {
		#echo "hhh";
		#echo $judulsubmenu."aaa".$kodemenu."vvv".$arraysubmenu;
		#print_r($arraysubmenu);
		#echo "<div class='leftcontent'>  <!-- left content -->";
        #createsubmenu( $judulsubmenu, $kodemenu, $arraysubmenu );
    }
    if ( $jenisusers == 2 && file_exists( "../mahasiswa/foto/{$users}" ) )
    {
		 
        if ( $_SESSION[TAMPILAN][SUBMENU] != 1 )
        {
            #echo "<div class='leftcontent'>  <!-- left content -->";
        }
        #echo "<center><img src='../mahasiswa/foto/{$users}' width=100></center>";
        if ( $_SESSION[TAMPILAN][SUBMENU] != 1 )
        {
            #echo "</div><!-- leftcontent -->";
        }
    }
    #echo "</div><!-- end content --></div><!-- end content wrapper--></div><!-- end container--></div></div>";
	#echo "</div><!-- end Horizontal Menu -->";
	#echo "</div><!-- end content wrapper--></div><!-- end container--></div>";
}
else if ( $_SESSION[TAMPILAN][MENUUTAMA] == 1 )
{
    printmenudropdown( $arraymenu );
    echo "</div> <!--- END HEADER --> <!-- content -->\r\n    <div id='content'>\r\n    <div class='contentwrapper'> <!-- main content -->\r\n    <div class='contentcolumn'>\r\n    \r\n    ";
    include( "aksi.php" );
    echo "\r\n    </div>\r\n    </div>\r\n    </div><!-- end contentwrapper -->\r\n    ";
    if ( $_SESSION[TAMPILAN][SUBMENU] == 1 )
    {
        #echo "<div class='leftcontent'>  <!-- left content -->";
        #createsubmenu( $judulsubmenu, $kodemenu, $arraysubmenu );
    }
    if ( $jenisusers == 2 && file_exists( "../mahasiswa/foto/{$users}" ) )
    {
        if ( $_SESSION[TAMPILAN][SUBMENU] != 1 )
        {
            #echo "<div class='leftcontent'>  <!-- left content -->";
        }
        #echo "<center><img src='../mahasiswa/foto/{$users}' width=100></center>";
        if ( $_SESSION[TAMPILAN][SUBMENU] != 1 )
        {
            #echo "</div><!-- leftcontent -->";
        }
    }
    echo "</div><!-- end content -->";
}
printfooter_dlm();
echo "</div> <!-- end wrap --> ";
?>
