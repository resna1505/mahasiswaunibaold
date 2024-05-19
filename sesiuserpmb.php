<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( !( $root == "../" ) )
{
    $root = "./";
}
session_start( );
include( $root."db.php" );
$koneksi = mysqli_connect($hostsql, $loginsql, $passwordsql, $basisdatasql,$portsql );
if ( !$koneksi )
{
    echo "Error koneksi ke basis data. Periksa apakah server basis data telah dihidupkan.  Hubungi Administrator Anda";
    exit( );
}
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
#$iddle_time = 1 * 15;
$d = status_login( $users_pmb, $jenisusers_pmb, "pmb" );
$statuslogin = $d[STATUSLOGIN];
$tokenlogin = $d[TOKEN];
if ( 0 < $iddle_time && $iddle_time < $d[LAMADIAM] )
{
    $aksi = "logout";
}
if ( !( session_is_registered_sikad( "users_pmb" ) && session_is_registered_sikad( "namausers_pmb" ) && session_is_registered_sikad( "URLS_pmb" ) && ereg_sikad( $URLS_pmb, $SCRIPT_FILENAME ) && session_id( ) == $PHPSESSID && $tokenlogin == $tokenusers_pmb && $statuslogin == 1 ) )
{
    session_destroy();
    mysqli_close($koneksi);
    Header( "Location:".$root."loginpmb.php" );
    set_status_login( $users, $jenisusers, 0, "", "pmb" );
}
if ( $aksi == "logout" )
{
    $users = $users_pmb;
    $ketlog = "Logout PMB sukses. ID={$users} ";
    buatlog( 67 );
    session_destroy();
    //@mysqli_close();
	mysqli_close($koneksi);
    Header( "Location:".$root."loginpmb.php" );
    set_status_login( $users, $jenisusers, 0, "", "pmb" );
}
#session_regenerate_id( );
?>
