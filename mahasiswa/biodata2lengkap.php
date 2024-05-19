<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$q = "SELECT  {$NAMATABELBEBAS}.* FROM {$NAMATABEL},{$NAMATABELBEBAS}  WHERE \r\n\t{$NAMATABELBEBAS}.ID='{$idupdate}' AND {$NAMATABEL}.ID={$NAMATABELBEBAS}.ID\r\n \t";
$h = doquery($koneksi,$q);
if ( sqlnumrows( $h ) <= 0 )
{
    $q = "INSERT INTO {$NAMATABELBEBAS} (ID) VALUES ('{$idupdate}')";
    doquery($koneksi,$q);
    $q = "SELECT  {$NAMATABELBEBAS}.* FROM {$NAMATABEL},{$NAMATABELBEBAS}  WHERE \r\n  \t{$NAMATABELBEBAS}.ID='{$idupdate}' AND {$NAMATABEL}.ID={$NAMATABELBEBAS}.ID\r\n   \t";
    $h = doquery($koneksi,$q);
}
$dm = sqlfetcharray( $h );
#echo "\r\n\t\t<br>\r\n \t\t<table class=form>";
/*echo "<div class=\"portlet-body\">
						<div class=\"table-scrollable\">
                            <table class=\"table table-striped table-bordered table-hover\">";

*/
/*echo "<div class=\"form-group m-form__group row\">
		<label class=\"col-lg-2 col-form-label\">";*/
echo "<table class=\"table table-striped2 table-bordered table-hover\">";
$q = "SHOW FULL COLUMNS FROM {$NAMATABELBEBAS}";
#echo $q;
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
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
                #echo "\r\n            <tr valign=top {$kelas} >\r\n               <td width=150> ".ucfirst( strtolower( str_replace( "_", " ", $d[0] ) ) )." </td>\r\n              <td>";
                echo "".ucfirst( strtolower( str_replace( "_", " ", $d[0] ) ) )." </label><div class=\"col-lg-6\">";
                
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
                #echo "\r\n              \r\n              ".$dm["{$d['0']}"]."  </td>\r\n            </tr>\r\n            ";
				echo "\r\n              \r\n              ".$dm["{$d['0']}"]."  </div>\r\n            </div>";
            }
            else
            {
                #echo "\r\n            <tr valign=top {$kelas} >\r\n                <td colspan=2 nowrap>{$contohtampilan}</td>\r\n            </tr>\r\n            ";
		        echo "<div class=\"form-group m-form__group row\" style=\"background-color:#f7f8fa;\">
								<label class=\"col-lg-2 col-form-label\">{$contohtampilan}</label>\r\n            </div>\r\n            ";
        
			}
        }
    }
   # echo "\r\n   \t\t\t</table>";
  # echo "</table></div></div>";
}
echo "\r\n\t\t\t</form>\r\n \t\t";
?>
