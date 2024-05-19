<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "SHOW FULL COLUMNS FROM {$NAMATABELBEBAS}";
#echo $q;
$h = doquery($koneksi,$q);
if ( 1 < sqlnumrows( $h ) )
{
    #echo "<table class=form>";
    while ( $d = sqlfetcharray( $h ) )
    {
        $hasil = getmetadata( $d );
        if ( $hasil['cari'] == 1 )
        {
            #echo "\r\n        \t\t\t<tr>\t\r\n        \t\t\t\t<td width=150>\r\n        \t\t\t\t\t".ucfirst( strtolower( str_replace( "_", " ", $d[0] ) ) )."\r\n        \t\t\t\t</td>\r\n        \t\t\t\t<td>{$hasil['contohpencarian']} </td>\r\n        \t\t\t</tr>\r\n            ";
		    echo "			<div class=\"form-group m-form__group row\">
								<label class=\"col-lg-2 col-form-label\">".ucfirst( strtolower( str_replace( "_", " ", $d[0] ) ) )."</label>\r\n    
								<div class=\"col-lg-6\">{$hasil['contohpencarian']} </div>
							</div>";
      
		}
    }
    #echo "</table>";
}
?>
