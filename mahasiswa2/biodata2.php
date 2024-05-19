<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SELECT  {$NAMATABELBEBAS}.* FROM {$NAMATABEL},{$NAMATABELBEBAS}  WHERE \r\n\t{$NAMATABELBEBAS}.ID='{$idupdate}' AND {$NAMATABEL}.ID={$NAMATABELBEBAS}.ID\r\n \t";
$h = mysqli_query($koneksi,$q);
if ( sqlnumrows( $h ) <= 0 )
{
    $q = "INSERT INTO {$NAMATABELBEBAS} (ID) VALUES ('{$idupdate}')";
    mysqli_query($koneksi,$q);
    $q = "SELECT  {$NAMATABELBEBAS}.* FROM {$NAMATABEL},{$NAMATABELBEBAS}  WHERE \r\n  \t{$NAMATABELBEBAS}.ID='{$idupdate}' AND {$NAMATABEL}.ID={$NAMATABELBEBAS}.ID\r\n   \t";
    $h = mysqli_query($koneksi,$q);
}
$dm = sqlfetcharray( $h );
echo "\r\n\t\t<br>\r\n \t\t<table class=form>";
$q = "SHOW FULL COLUMNS FROM {$NAMATABELBEBAS}";
$h = mysqli_query($koneksi,$q);
if ( 1 < sqlnumrows( $h ) )
{
    while ( $d = sqlfetcharray( $h ) )
    {
        if ( $d[0] != "ID" )
        {
            $kelas = kelas( $i );
            ++$i;
            $atribut = $contohtampilan = "";
            $hasil = getmetadata( $d );
            $tipe = $hasil[tipe];
            $hasil = getmetadata( $d, "{$d['0']}", $dm["{$d['0']}"] );
            $atribut = $hasil[atribut];
            $contohtampilan = $hasil[contohtampilan];
            if ( $hasil[tipe] != 99 )
            {
                echo "\r\n            <tr valign=top {$kelas} >\r\n               <td width=150> ".ucfirst( strtolower( str_replace( "_", " ", $d[0] ) ) )." </td>\r\n              <td>";
                if ( $hasil[tipe] == 6 )
                {
                    $nilai = $dm["{$d['0']}"];
                    if ( $nilai != "" && file_exists( $FOLDERFILE."/{$nilai}" ) )
                    {
                        echo "<img src='../{$NAMATABEL}/lihat.php?id={$idupdate}&field={$d['0']}' width=200> <br>";
                    }
                }
                else if ( $hasil[tipe] == 7 )
                {
                    $nilai = $dm["{$d['0']}"];
                    if ( $nilai != "" && file_exists( $FOLDERFILE."/{$nilai}" ) )
                    {
                        echo "<a target=_blank href='../{$NAMATABEL}/lihat.php?id={$idupdate}&field={$d['0']}&jenis=1'  >download</a> <br>";
                    }
                }
                echo "\r\n              \r\n              ".$dm["{$d['0']}"]."  </td>\r\n            </tr>\r\n            ";
            }
            else
            {
                echo "\r\n            <tr valign=top {$kelas} >\r\n                <td colspan=2 nowrap>{$contohtampilan}</td>\r\n            </tr>\r\n            ";
            }
        }
    }
    echo "\r\n   \t\t\t</table>";
}
echo "\r\n\t\t\t</form>\r\n \t\t";
?>
