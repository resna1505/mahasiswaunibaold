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
$h = mysqli_query($koneksi,$q);
if ( 1 < sqlnumrows( $h ) )
{
    $q = "SELECT {$NAMATABEL}.NAMA,{$NAMATABELBEBAS}.*,{$NAMATABEL}.ID \r\n      FROM {$qtabel2} {$NAMATABEL} LEFT JOIN {$NAMATABELBEBAS} ON {$NAMATABEL}.ID={$NAMATABELBEBAS}.ID {$tabeltambahan}\r\n  \t\tWHERE 1=1\r\n      {$qfield}\r\n      ORDER BY {$arraysort[$sort]}      \r\n  \t    {$qlimit} ";
    $h2 = mysqli_query($koneksi,$q);
    echo mysqli_error($koneksi);
    if ( 0 < sqlnumrows( $h2 ) )
    {
        echo "\r\n        <br><br>\r\n   \t\t\t<table {$border} class=data{$aksi}>\r\n  \t\t\t<tr class=juduldata{$aksi} align=center>\r\n  \t\t\t   <td>NIM</td>\r\n  \t\t\t   <td>Nama</td>";
        while ( $d = sqlfetcharray( $h ) )
        {
            $hasil = getmetadata( $d );
            if ( $d[0] != "ID" && $hasil[tipe] != 99 && $hasil[tipe] != 6 & $hasil[tipe] != 7 )
            {
                $arrayfield[] = $d;
                echo "\r\n                <td>".ucfirst( strtolower( str_replace( "_", " ", $d[0] ) ) )."</td>\r\n                ";
            }
        }
        echo "\r\n  \t\t\t  </tr>\r\n         ";
        $i = 0;
        while ( $d2 = sqlfetcharray( $h2 ) )
        {
            $kelas = kelas( $i );
            echo "\r\n  \t\t\t\t<tr valign=top align=center {$kelas}{$aksi}>\r\n  \t\t\t\t  <td>{$d2['ID']}</td>\r\n  \t\t\t\t  <td align=left nowrap>{$d2['NAMA']}</td>";
            if ( is_array( $arrayfield ) )
            {
                foreach ( $arrayfield as $k => $d )
                {
                    $hasil = getmetadata( $d );
                    $align = "left";
                    if ( $d[0] != "ID" && $hasil[tipe] != 99 && $hasil[tipe] != 6 & $hasil[tipe] != 7 )
                    {
                        if ( $hasil[tipe] == 8 || $hasil[tipe] == 9 || $hasil[tipe] == 4 || $hasil[tipe] == 5 )
                        {
                            $align = "center";
                        }
                        echo "\r\n                <td nowrap align={$align}>".nl2br( $d2[$d[0]] )." </td>\r\n                ";
                    }
                }
            }
            echo "\r\n          </tr>\r\n          ";
        }
        echo "</table>";
    }
}
?>
