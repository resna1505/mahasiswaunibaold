<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
include( $root."sesiuser.php" );
include( $root."db.php" );
include( $root."header.php" );
include( "../libchart/libchart.php" );
periksaroot( );
$db = mysql_connect( $hostsql, $loginsql, $passwordsql );
mysql_select_db( $basisdatasql, $db );
$punit = $_REQUEST['$pfltr'];
echo "<html>\n";
echo "<head>\r\n<style>";
include( $root."css/list_prodi.css" );
echo "\r\n</style><title>Daftar Dosen</title>\n";
echo "<link rel=stylesheet type='text/css' href='{$css}'>\n";
echo "<meta http-equiv='Content-Style-Type' content='text/css'>\n";
echo "<script src='".$root."tampilan/lib/jquery-1.4.min.js' type='text/javascript' charset='utf-8'></script>";
echo "<script src='".$root."css/script.js' type='text/javascript'></script>";
echo "\r\n\r\n<div id=\"wrap\">\r\n\t\r\n    <h2 id=\"title\">Grafik IPK</h2>\r\n    \r\n    <div id=\"link_alpha\">\r\n    \t<ul class=\"mainlink\">\r\n     ";
echo "<br><table width='100%' {$borderdata} class=data>\n";
$i = 0;
$q = "SELECT NLIPSTRAKM,THSMSTRAKM FROM trakm WHERE NIMHSTRAKM='{$idmahasiswa}' ORDER BY THSMSTRAKM  ";
        $hg = doquery( $q, $koneksi );
        if ( 0 < sqlnumrows( $h ) )
        {
            delgambartemp();
            $xx1 = mt_rand();
            $q = "INSERT INTO gambartemp VALUES('gambardiagram/"."{$xx1}.png',NOW())";
            doquery( $q, $koneksi );
            $chart = new VerticalChart( );
            while ( $dg = sqlfetcharray( $hg ) )
            {
                $thnd = substr( $dg[THSMSTRAKM], 0, 4 );
                $semd = substr( $dg[THSMSTRAKM], 4, 1 );
                $semd = $arraysemester[$semd];
                $chart->addPoint( new Point( "{$semd} {$thnd}/".( $thnd + 1 )."", $dg[NLIPSTRAKM] ) );
            }
            $chart->setTitle( "Grafik IP Mahasiswa ({$idmahasiswa}) per Semester" );
            $chart->render( "../nilai/gambardiagram/{$xx1}.png" );
            echo "<tr><td><img  src='../nilai/gambardiagram/{$xx1}.png' style='border: 1px solid gray;'/></td></td>";
        }
/*while ( $row = sqlfetcharray( $pengguna ) )
{
    $kelas = kelas( $i );
    $pval = $row['kode_pengguna'].",".$row['username'];
    echo "<tr {$kelas}>\n";
    echo "<td><a href=\"javascript:pick('".$pfld."','".$pval."')\">".$row['username']."</td>\n";
    echo "<td>".$row['nama_pengguna']."</td>\n";
    echo "<td>".$arrayprodidep[$row[IDPRODI]]."</td>\n";
    echo "</tr>\n";
}*/
echo "</table>\n";
echo "</div>";
echo "</body>\n";
echo "</html>\n";
?>
