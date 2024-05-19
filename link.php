<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function printlink( )
{
    global $koneksi;
    $q = "SELECT   JUDUL AS JUDULA,URL FROM link ORDER BY JUDUL";
    $hasil = mysqli_query($koneksi, $q);
    if ( 0 < mysqli_num_rows( $hasil ) )
    {
        echo "\r\n<div class=\"relatedLinks\">\r\n\t\t<h3 class=\"submenutitle\" >Link Menarik</h3>\r\n\t\r\n\t";
        $i = 0;
        while ( $data = mysqli_fetch_array( $hasil ) )
        {
            if ( $i % 2 == 0 )
            {
                $kelas = "datasubmenuganjil";
            }
            else
            {
                $kelas = "datasubmenugenap";
            }
            echo "\r\n\t\t\t\t\t\t<a  class={$kelas} target=_blank href='{$data['URL']}'>{$data['JUDULA']}</a>\r\n\t\t\t\t\r\n\t\t\t";
            ++$i;
        }
        echo "\r\n</div><!--relatedLinks -->\r\n";
    }
}

?>
