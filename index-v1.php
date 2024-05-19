<?php
session_start();
include("header.php" );
periksaroot( );
include( "link.php" );
#echo "aaaa".$root;
$errdh = "id";
$jenisuser=2;
if ( trim( $_POST['aksi'] ) == "Login" && $REQUEST_METHOD == "POST" )
{
	$iduser=$_POST['iduser'];
	$password=$_POST['password'];
	$randlogin=$_POST['randlogin'];
	
	$ketlog = "Login ID={$iduser}, Jenis={$jenisuser}";
    buatlog( 0 );
    if ( $_SESSION['tokenlogin'] != md5( $randlogin ) )
    {
        $errmesg = "Kode anti-spam yang Anda masukkan salah.";
    }
    else if ( !( anti_sql_injection( $iduser ) && anti_sql_injection( $password ) ) )
    {
        $errmesg = "Jangan macam-macam please...";
    }
    else if ( trim( $iduser == "" ) )
    {
        $errmesg = "ID User harus diisi";
        $errlogin = "id";
    }
    else if ( trim( $password == "" ) )
    {
        $errmesg = "Password harus diisi";
        $errlogin = "password";
    }
    else
    {
        $ok = 1;
        $d = status_login( $iduser, $jenisuser );
        $iddle_time = getaturan( "BATASDIAM" ) * 60;
		#print_r($d);
		#echo'<br>';
		#echo $iddle_time.'<br>';
        if ( $iddle_time < $d['LAMADIAM'] )
        {
			#echo "mmm";
            #set_status_login( $iduser, $jenisuser, 0 );
			set_status_login( $iduser, $jenisuser, 0 );
        }
		
        if ( 0 < $iddle_time && is_sedang_login( $iduser, $jenisuser ) )
        {
			#echo "kkk";
			#echo '<br>';exit();
            $ok = 0;
            $errmesg = "Maaf, ID Anda sedang login di tempat lain. Sementara ini Anda tidak dapat login sebelum ID Anda di tempat lain tersebut logout. Apabila Anda merasa hal ini adalah kesalahan, silakan hubungi administrator Anda.";
        }
        if ( $ok == 1 )
        {
			#echo $jenisuser;exit();
			
            $tokenlogin = md5( uniqid( rand( ), TRUE ) );
            
			#echo "lll";exit();
			$wali = "";
			if ( $jenisuser == 1 ) //dosen
			{
				$tabeluser = "dosen";
				$qstatus = "AND STATUSKERJA='A'";
				$qpwd = "AND (PASSWORD=PASSWORD('{$password}') OR(PASSWORD=md5('{$password}')))";
				#$qpwd = "AND (FLAGPASSWORD=0 OR FLAGPASSWORD=1)                  \r\n          \r\n          ";
		   
			}
			else { //mahasiswa
				#echo "lll";exit();
				$tabeluser = "mahasiswa";
				$ftambahan = "ANGKATAN,IDPRODI,";
				$qstatus = "AND STATUS='A'";
				$qpwd = " AND (PASSWORD=PASSWORD('{$password}') OR(PASSWORD=md5('{$password}')))  ";
				#$qpwd = " AND PASSWORD=MD5('{$password}') ";
				#$qpwd = " AND (FLAGPASSWORD=0 OR FLAGPASSWORD=1)                   \r\n          \r\n          ";
				#$qpwd = " AND PASSWORD=MD5('{$password}') ";
				
				$wali = "WALI MAHASISWA : ";
			}
			
			$query = "SELECT NAMA,ID,{$ftambahan}  CSS,SETTINGTAMPILAN FROM {$tabeluser} WHERE ID='{$iduser}' {$qpwd} {$qstatus}";
			#echo $query.'<br>';
			#exit();
		   $hasil = mysqli_query($koneksi, $query);
			if ( mysqli_num_rows( $hasil )>0 )
			{
							
				$data = mysqli_fetch_array( $hasil );
				session_start( );
				session_register_sikad( "users" );
				session_register_sikad( "namausers" );
				session_register_sikad( "bidangs" );
				session_register_sikad( "tingkats" );
				session_register_sikad( "jabatans" );
				session_register_sikad( "jenisusers" );
				session_register_sikad( "css" );
				session_register_sikad( "URLS" );
				session_register_sikad( "tokenusers" );
				$URLS = str_replace( "index.php", "", $SCRIPT_FILENAME );
				$css = $data['CSS'];
				$users = $iduser;
				$namausers = $data['NAMA'];
				$bidangs = $data['BIDANG'];
				$tokenusers = $tokenlogin;
				if ( $jenisuser == 1 )
				{
					$tingkats = "F5:T,F6:T";
					$jenisusers = 1;
				}
				else
				{
					$tingkats = "F5:B,F6:B";
					$jenisusers = $jenisuser;
					session_register_sikad( "angkatanusers" );
					session_register_sikad( "prodiusers" );
					$angkatanusers = $data['ANGKATAN'];
					$prodiusers = $data['IDPRODI'];
				}
				$jabatans = $data['JABATAN'];
				$_SESSION['users'] = $users;
				$_SESSION['namausers'] = $wali.$namausers;
				$_SESSION['prodis'] = $prodis;
				$_SESSION['bidangs'] = $bidangs;
				$_SESSION['jabatans'] = $jabatans;
				$_SESSION['tingkats'] = $tingkats;
				$_SESSION['css'] = $css;
				$_SESSION['URLS'] = $URLS;
				$_SESSION['jenisusers'] = $jenisusers;
				$_SESSION['statusoperatormakul'] = $statusoperatormakul;
				$_SESSION['angkatanusers'] = $angkatanusers;
				$_SESSION['prodiusers'] = $prodiusers;
				$_SESSION['tokenusers'] = $tokenlogin;
				
				if ( $data['SETTINGTAMPILAN'] == "" )
				{
					$data['SETTINGTAMPILAN'] = "MENUUTAMA=0;SUBMENU=1";
				}
				$tmp = explode( ";", trim( $data['SETTINGTAMPILAN'] ) );
				if ( is_array( $tmp ) )
				{
					foreach ( $tmp as $k => $v )
					{
						$tmp2 = explode( "=", $v );
						$_SESSION['TAMPILAN'][trim( $tmp2[0] )] = trim( $tmp2[1] );
					}
				}
				#Header( "Location:nilai/index.php" );
				Header( "Location:pengumuman/index.php" );
				$ketlog = "Login sukses. ID={$iduser}, Jenis={$jenisuser}";
				buatlog( 0 );
				set_status_login( $iduser, $jenisuser, 1, $tokenlogin );
				mysqli_close($koneksi);
				exit();
			}
			else
			{
			   $errmesg = "Maaf, ID dan Password Anda tidak sesuai. \r\n  \t\t\t\tSilakan mengisi kembali ID dan Password Anda.";
			   $errlogin = "id";
			}
            
        }
    }
}else{

	if(isset($_GET["code"])){
			 $token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);
			 #print_r($token);
			 #echo "<br>";
			 if(!isset($token['error'])){
				  $google_client->setAccessToken($token['access_token']);
				  $_SESSION['access_token'] = $token['access_token'];
				  $google_service = new Google_Service_Oauth2($google_client);
				  $data = $google_service->userinfo->get();
				  #print_r($data);
				  #echo "<br>";
				  $tokenlogin = md5( uniqid( rand( ), TRUE ) );
				  $tabeluser = "mahasiswa";
				  $ftambahan = "ANGKATAN,IDPRODI,";
				  #$qpwd = " AND (PASSWORD=PASSWORD('{$password}') OR(PASSWORD=md5('{$password}')))  ";
				  $qstatus = "AND STATUS='A'";
				  $emailuser=$data['email'];
				  #echo "EMAIL USER=".$emailuser.'<br>';
				  #echo "<br>";
				  list($iduser,$domain)=explode('@',$emailuser);
				  #echo "ID USER=".$iduser.'<br>';				  
				  #echo "<br>";	
				  $query = "SELECT NAMA,ID,{$ftambahan}  CSS,SETTINGTAMPILAN FROM {$tabeluser} WHERE ID='{$iduser}' {$qstatus}";
				  #echo $query.'<br>';
					#exit();
				   $hasil = mysqli_query($koneksi, $query);
					if ( mysqli_num_rows( $hasil )>0 )
					{
						#echo "lll";exit();
						#$query_update_password="UPDATE {$tabeluser} SET PASSWORD=PASSWORD('{$password}') WHERE ID='{$iduser}' {$qpwd} {$qstatus}";
						#mysql_query( $query_update_password, $koneksi );
						
						$data = mysqli_fetch_array( $hasil );
						session_start();
						session_register_sikad( "users" );
						session_register_sikad( "namausers" );
						session_register_sikad( "bidangs" );
						session_register_sikad( "tingkats" );
						session_register_sikad( "jabatans" );
						session_register_sikad( "jenisusers" );
						session_register_sikad( "css" );
						session_register_sikad( "URLS" );
						session_register_sikad( "tokenusers" );
						$URLS = str_replace( "index.php", "", $SCRIPT_FILENAME );
						$css = $data['CSS'];
						$users = $iduser;
						$namausers = $data['NAMA'];
						$bidangs = $data['BIDANG'];
						$tokenusers = $tokenlogin;
						#$tokenusers = $_SESSION['access_token'];
						
							$tingkats = "F5:B,F6:B";
							$jenisuser = 2;
							$jenisusers = 2;
							session_register_sikad( "angkatanusers" );
							session_register_sikad( "prodiusers" );
							$angkatanusers = $data['ANGKATAN'];
							$prodiusers = $data['IDPRODI'];
						
						$jabatans = $data['JABATAN'];
						$_SESSION['users'] = $users;
						$_SESSION['namausers'] = $wali.$namausers;
						$_SESSION['prodis'] = $prodis;
						$_SESSION['bidangs'] = $bidangs;
						$_SESSION['jabatans'] = $jabatans;
						$_SESSION['tingkats'] = $tingkats;
						$_SESSION['css'] = $css;
						$_SESSION['URLS'] = $URLS;
						$_SESSION['jenisusers'] = $jenisusers;
						$_SESSION['statusoperatormakul'] = $statusoperatormakul;
						$_SESSION['angkatanusers'] = $angkatanusers;
						$_SESSION['prodiusers'] = $prodiusers;
						$_SESSION['tokenusers'] = $tokenlogin;
						#$_SESSION['tokenusers'] = $_SESSION['access_token'];
						
						if ( $data['SETTINGTAMPILAN'] == "" )
						{
							$data['SETTINGTAMPILAN'] = "MENUUTAMA=0;SUBMENU=1";
						}
						$tmp = explode( ";", trim( $data['SETTINGTAMPILAN'] ) );
						if ( is_array( $tmp ) )
						{
							foreach ( $tmp as $k => $v )
							{
								$tmp2 = explode( "=", $v );
								$_SESSION['TAMPILAN'][trim( $tmp2[0] )] = trim( $tmp2[1] );
							}
						}
						#Header( "Location:nilai/index.php" );
						Header( "Location:pengumuman/index.php" );
						$ketlog = "Login sukses. ID={$iduser}, Jenis={$jenisuser}";
						buatlog( 0 );
						set_status_login( $iduser, $jenisuser, 1, $tokenlogin );
						mysqli_close($koneksi);
						exit();
					}
				 
			 }else{
				 $errmesg = "Maaf, Akun Gmail Anda belum terdaftar. Silahkan Hubungi Administrator";
			 }
		}	
}

$waktu = getdate(time());
printheader();
include( "welcomemenu.php" );
printmesg( $errmesg );
echo "<div class=\"col-md-6\">";
include( "loginuser.php" );
echo " </div>";
echo "<div class=\"col-md-6\">";
include( "pengumumanlogin.php" );
echo "</div>";
echo "<!-- end maincontent --></div><!-- end content --></div><!--end wrap--></div>";
echo "<div id=\"popup\" class=\"popup panel panel-primary\">
       <div class=\"popup-container\"> 
	<div align=\"center\">
        	<img align=\"center\" class=\"img-front-responsive\" src=\"http://akademik2.univbatam.ac.id/images/pengumuman-uniba.jpg\" alt=\"popup\">           
        </div>
	<div class=\"panel-footer\" align=\"center\">
            <button id=\"close\" class=\"btn btn-lg btn-primary\">Tutup</button>
        </div>
            
        </div>
    </div>";
#printfooter( );
echo "</body></html>";
?>
