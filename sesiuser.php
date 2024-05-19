<?php
#echo "rootnya".$root;
if ( !( $root == "../" ) )
{
    $root = "./";
}
session_start();
include( $root."db.php" );
#echo $root."MMM";
$koneksi = mysqli_connect($hostsql, $loginsql, $passwordsql, $basisdatasql,$portsql );
if ( !$koneksi )
{
    echo "Error koneksi ke basis data. Periksa apakah server basis data telah dihidupkan.  Hubungi Administrator Anda";
    exit( );
}
#mysql_select_db( $basisdatasql, $koneksi );
#print_r($_SESSION);
if ( is_array( $_SESSION ) )
{
    foreach ( $_SESSION as $k => $v )
    {
        $$k = $v;
    }
}
include( $root."globaloff.php" );
include_once( $root."header.php" );
$iddle_time = getaturan( "BATASDIAM" ) * 60;
$d = status_login( $users, $jenisusers );
#print_r($d);
$statuslogin = $d['STATUSLOGIN'];
$tokenlogin = $d['TOKEN'];
#echo "TOKENLOGIN=".$tokenlogin;
if ( 0 < $iddle_time && $iddle_time < $d['LAMADIAM'] )
{
	#echo "LOGOUT";
    $aksi = "logout";
}

if ( !( session_is_registered_sikad( "users" ) && session_is_registered_sikad( "namausers" ) && session_is_registered_sikad( "URLS" ) && ereg_sikad( $URLS, $SCRIPT_FILENAME ) && session_id( ) == $PHPSESSID && $tokenlogin == $tokenusers && $statuslogin == 1 ) )
{
    #echo "DESTROY";exit();
	unset($_SESSION['token']);
	#unset($_SESSION['userData']);

	// Reset OAuth access token
	$google_client->revokeToken();
	session_destroy();
    mysqli_close($koneksi);
    Header( "Location:".$root."index.php");
    set_status_login( $users, $jenisusers, 0 );
}
else if ( isoperator( ) )
{
	#echo "OPERATOR";
    $q = "SELECT NAMA,TINGKAT,JENIS, IDPRODI,SETTINGTAMPILAN,CSS,LOGINWAKTU,\r\n        IF(CURTIME()>=JAM1 AND CURTIME()<= JAM2,1,0) AS STATUSWAKTU,JAM1,JAM2 FROM user WHERE ID='{$users}'";
    #echo $q;
	$h = doquery( $koneksi, $q );
    $datass = sqlfetcharray( $h );
    $css = $datass['CSS'];
    $namausers = $datass['NAMA'];
    $prodis = $datass['IDPRODI'];
    $tingkats = $datass['TINGKAT'];
    $jeniss = $datass['JENIS'];
    $_SESSION['namausers'] = $namausers;
    $_SESSION['prodis'] = $prodis;
    $_SESSION['tingkats'] = $tingkats;
    $_SESSION['css'] = $css;
    $_SESSION['jeniss'] = $jeniss;
}

if ( $aksi == "logout" )
{
	#echo "LOGOUT LAGI";exit();
    $ketlog = "Logout sukses. ID={$users}, Jenis={$jenisusers}";
    buatlog( 1 );
	unset($_SESSION['token']);
	#unset($_SESSION['userData']);

	// Reset OAuth access token
	$google_client->revokeToken();
    session_destroy();
    //@mysqli_close();
	
    Header( "Location:".$root."index.php" );
    set_status_login( $users, $jenisusers, 0 );
	session_regenerate_id();
	mysqli_close($koneksi);
}
#session_regenerate_id();
#
?>
