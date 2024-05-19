<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function createbar( &$im, $i, $x, $y, $l, $t, $hitam, $putih )
{
    if ( $i % 2 == 0 )
    {
        imagefilledrectangle( $im, $x, $y, $x + $l, $y + $t, $hitam );
    }
    else
    {
        imagefilledrectangle( $im, $x, $y, $x + $l, $y + $t, $putih );
    }
}

function createbarcode128( $str, $file, $kode, $tulis )
{
    global $bar128;
    global $l;
    if ( $kode == "A" )
    {
        $string = strtoupper( $str );
        trim( $string );
    }
    if ( $kode == "B" )
    {
        $string = $str;
    }
    else if ( $kode == "C" )
    {
        $string = $str;
        if ( strlen( $string ) % 2 != 0 )
        {
            $string = "0".$string;
        }
    }
    $count = strlen( $string );
    $ja = 4;
    $pt = 20;
    if ( $kode != "C" )
    {
        $lebar = ( 11 * $count + 35 ) * $l + 20 * $l;
    }
    else
    {
        $lebar = ( 5.5 * $count + 35 ) * $l + 20 * $l;
    }
    $im = @ImageCreate( @$lebar, @$l * @$pt + @4 * @$l );
    $putih = ImageColorAllocate( $im, 255, 255, 255 );
    $hitam = ImageColorAllocate( $im, 0, 0, 0 );
    $x0 = 10 * $l;
    $akhir = $x = 10 * $l;
    $y = 2 * $l;
    $awal = 0;
    if ( $kode == "A" )
    {
        $S = str_replace( " ", "", $bar128[103]['S'] );
        $total = 103;
    }
    else if ( $kode == "B" )
    {
        $S = str_replace( " ", "", $bar128[104]['S'] );
        $total = 104;
    }
    else
    {
        $S = str_replace( " ", "", $bar128[105]['S'] );
        $total = 105;
    }
    $count2 = strlen( $S );
    $awal = $akhir;
    $j = 0;
    while ( $j < $count2 )
    {
        createbar( &$im, $j, $x, $y, $l * $S[$j] - 1, $l * $pt, $hitam, $putih );
        $x += $l * $S[$j];
        ++$j;
    }
    $akhir = $x;
    $i = 0;
    while ( $i < $count )
    {
        $S = "";
        foreach ( $bar128 as $k => $v )
        {
            if ( $kode != "C" )
            {
                if ( $v["{$kode}"] == $string[$i] )
                {
                    $S = str_replace( " ", "", $v['S'] );
                    $char = $v["{$kode}"];
                    $total += $k * ( $i + 1 );
                    break;
                }
            }
            if ( $v["{$kode}"] == "".$string[$i].$string[$i + 1]."" )
            {
                $S = str_replace( " ", "", $v['S'] );
                $char = $v["{$kode}"];
                $total += $k * ( $i / 2 + 1 );
                break;
            }
            if ( $S != "" )
            {
                break;
                break;
            }
        }
        if ( $S == "" )
        {
            $S = str_replace( " ", "", $bar128[0]['S'] );
        }
        $count2 = strlen( $S );
        $awal = $akhir;
        $j = 0;
        do
        {
            createbar( &$im, $j, $x, $y, $l * $S[$j] - 1, $l * $pt, $hitam, $putih );
            $x += $l * $S[$j];
            ++$j;
        } while ( 1 );
        $akhir = $x;
        $stringt .= $char;
        if ( $kode == "C" )
        {
            ++$i;
        }
        ++$i;
    }
    $modtotal = $total % 103;
    $S = str_replace( " ", "", $bar128[$modtotal]['S'] );
    $count2 = strlen( $S );
    $awal = $akhir;
    $j = 0;
    while ( $j < $count2 )
    {
        createbar( &$im, $j, $x, $y, $l * $S[$j] - 1, $l * $pt, $hitam, $putih );
        $x += $l * $S[$j];
        ++$j;
    }
    $akhir = $x;
    $S = str_replace( " ", "", $bar128[106]['S'] );
    $count2 = strlen( $S );
    $awal = $akhir;
    $j = 0;
    while ( $j < $count2 )
    {
        createbar( &$im, $j, $x, $y, $l * $S[$j] - 1, $l * $pt, $hitam, $putih );
        $x += $l * $S[$j];
        ++$j;
    }
    $akhir = $x;
    if ( $tulis != 0 )
    {
        imagestring( $im, $l, 10 * $l, $y + $l * $pt + 5, $stringt, $hitam );
    }
    imagecolortransparent( $im, $putih );
    imagePNG( $im, $file.".png" );
}

$bar128[0] = array( "A" => " ", "B" => " ", "C" => "00", "S" => "2 1 2 2 2 2" );
$bar128[1] = array( "A" => "!", "B" => "!", "C" => "01", "S" => "2 2 2 1 2 2" );
$bar128[2] = array( "A" => "\"", "B" => "\"", "C" => "02", "S" => "2 2 2 2 2 1" );
$bar128[3] = array( "A" => "#", "B" => "#", "C" => "03", "S" => "1 2 1 2 2 3 " );
$bar128[4] = array( "A" => "\$", "B" => "\$", "C" => "04", "S" => "1 2 1 3 2 2 " );
$bar128[5] = array( "A" => "%", "B" => "%", "C" => "05", "S" => "1 3 1 2 2 2 " );
$bar128[6] = array( "A" => "&", "B" => "&", "C" => "06", "S" => "1 2 2 2 1 3 " );
$bar128[7] = array( "A" => "'", "B" => "'", "C" => "07", "S" => "1 2 2 3 1 2 " );
$bar128[8] = array( "A" => "(", "B" => "(", "C" => "08", "S" => "1 3 2 2 1 2 " );
$bar128[9] = array( "A" => ")", "B" => ")", "C" => "09", "S" => "2 2 1 2 1 3 " );
$bar128[10] = array( "A" => "*", "B" => "*", "C" => "10", "S" => "2 2 1 3 1 2 " );
$bar128[11] = array( "A" => "+", "B" => "+", "C" => "11", "S" => "2 3 1 2 1 2 " );
$bar128[12] = array( "A" => ",", "B" => ",", "C" => "12", "S" => "1 1 2 2 3 2 " );
$bar128[13] = array( "A" => "-", "B" => "-", "C" => "13", "S" => "1 2 2 1 3 2 " );
$bar128[14] = array( "A" => ".", "B" => ".", "C" => "14", "S" => "1 2 2 2 3 1 " );
$bar128[15] = array( "A" => "/", "B" => "/", "C" => "15", "S" => "1 1 3 2 2 2 " );
$bar128[16] = array( "A" => "0", "B" => "0", "C" => "16", "S" => "1 2 3 1 2 2 " );
$bar128[17] = array( "A" => "1", "B" => "1", "C" => "17", "S" => "1 2 3 2 2 1 " );
$bar128[18] = array( "A" => "2", "B" => "2", "C" => "18", "S" => "2 2 3 2 1 1 " );
$bar128[19] = array( "A" => "3", "B" => "3", "C" => "19", "S" => "2 2 1 1 3 2 " );
$bar128[20] = array( "A" => "4", "B" => "4", "C" => "20", "S" => "2 2 1 2 3 1 " );
$bar128[21] = array( "A" => "5", "B" => "5", "C" => "21", "S" => "2 1 3 2 1 2 " );
$bar128[22] = array( "A" => "6", "B" => "6", "C" => "22", "S" => "2 2 3 1 1 2 " );
$bar128[23] = array( "A" => "7", "B" => "7", "C" => "23", "S" => "3 1 2 1 3 1 " );
$bar128[24] = array( "A" => "8", "B" => "8", "C" => "24", "S" => "3 1 1 2 2 2 " );
$bar128[25] = array( "A" => "9", "B" => "9", "C" => "25", "S" => "3 2 1 1 2 2 " );
$bar128[26] = array( "A" => ":", "B" => ":", "C" => "26", "S" => "3 2 1 2 2 1 " );
$bar128[27] = array( "A" => ";", "B" => ";", "C" => "27", "S" => "3 1 2 2 1 2 " );
$bar128[28] = array( "A" => "<", "B" => "<", "C" => "28", "S" => "3 2 2 1 1 2 " );
$bar128[29] = array( "A" => "=", "B" => "=", "C" => "29", "S" => "3 2 2 2 1 1 " );
$bar128[30] = array( "A" => ">", "B" => ">", "C" => "30", "S" => "2 1 2 1 2 3 " );
$bar128[31] = array( "A" => "?", "B" => "?", "C" => "31", "S" => "2 1 2 3 2 1 " );
$bar128[32] = array( "A" => "@", "B" => "@", "C" => "32", "S" => "2 3 2 1 2 1 " );
$bar128[33] = array( "A" => "A", "B" => "A", "C" => "33", "S" => "1 1 1 3 2 3 " );
$bar128[34] = array( "A" => "B", "B" => "B", "C" => "34", "S" => "1 3 1 1 2 3 " );
$bar128[35] = array( "A" => "C", "B" => "C", "C" => "35", "S" => "1 3 1 3 2 1 " );
$bar128[36] = array( "A" => "D", "B" => "D", "C" => "36", "S" => "1 1 2 3 1 3 " );
$bar128[37] = array( "A" => "E", "B" => "E", "C" => "37", "S" => "1 3 2 1 1 3 " );
$bar128[38] = array( "A" => "F", "B" => "F", "C" => "38", "S" => "1 3 2 3 1 1 " );
$bar128[39] = array( "A" => "G", "B" => "G", "C" => "39", "S" => "2 1 1 3 1 3 " );
$bar128[40] = array( "A" => "H", "B" => "H", "C" => "40", "S" => "2 3 1 1 1 3 " );
$bar128[41] = array( "A" => "I", "B" => "I", "C" => "41", "S" => "2 3 1 3 1 1 " );
$bar128[42] = array( "A" => "J", "B" => "J", "C" => "42", "S" => "1 1 2 1 3 3 " );
$bar128[43] = array( "A" => "K", "B" => "K", "C" => "43", "S" => "1 1 2 3 3 1 " );
$bar128[44] = array( "A" => "L", "B" => "L", "C" => "44", "S" => "1 3 2 1 3 1 " );
$bar128[45] = array( "A" => "M", "B" => "M", "C" => "45", "S" => "1 1 3 1 2 3 " );
$bar128[46] = array( "A" => "N", "B" => "N", "C" => "46", "S" => "1 1 3 3 2 1 " );
$bar128[47] = array( "A" => "O", "B" => "O", "C" => "47", "S" => "1 3 3 1 2 1 " );
$bar128[48] = array( "A" => "P", "B" => "P", "C" => "48", "S" => "3 1 3 1 2 1 " );
$bar128[49] = array( "A" => "Q", "B" => "Q", "C" => "49", "S" => "2 1 1 3 3 1 " );
$bar128[50] = array( "A" => "R", "B" => "R", "C" => "50", "S" => "2 3 1 1 3 1 " );
$bar128[51] = array( "A" => "S", "B" => "S", "C" => "51", "S" => "2 1 3 1 1 3 " );
$bar128[52] = array( "A" => "T", "B" => "T", "C" => "52", "S" => "2 1 3 3 1 1 " );
$bar128[53] = array( "A" => "U", "B" => "U", "C" => "53", "S" => "2 1 3 1 3 1 " );
$bar128[54] = array( "A" => "V", "B" => "V", "C" => "54", "S" => "3 1 1 1 2 3 " );
$bar128[55] = array( "A" => "W", "B" => "W", "C" => "55", "S" => "3 1 1 3 2 1 " );
$bar128[56] = array( "A" => "X", "B" => "X", "C" => "56", "S" => "3 3 1 1 2 1 " );
$bar128[57] = array( "A" => "Y", "B" => "Y", "C" => "57", "S" => "3 1 2 1 1 3 " );
$bar128[58] = array( "A" => "Z", "B" => "Z", "C" => "58", "S" => "3 1 2 3 1 1 " );
$bar128[59] = array( "A" => "[", "B" => "[", "C" => "59", "S" => "3 3 2 1 1 1 " );
$bar128[60] = array( "A" => "\\", "B" => "\\", "C" => "60", "S" => "3 1 4 1 1 1 " );
$bar128[61] = array( "A" => "]", "B" => "]", "C" => "61", "S" => "2 2 1 4 1 1 " );
$bar128[62] = array( "A" => "^", "B" => "^", "C" => "62", "S" => "4 3 1 1 1 1 " );
$bar128[63] = array( "A" => "_", "B" => "_", "C" => "63", "S" => "1 1 1 2 2 4 " );
$bar128[64] = array( "A" => "\x00", "B" => "'", "C" => "64", "S" => "1 1 1 4 2 2 " );
$bar128[65] = array( "A" => "SOH", "B" => "a", "C" => "65", "S" => "1 2 1 1 2 4 " );
$bar128[66] = array( "A" => "STX", "B" => "b", "C" => "66", "S" => "1 2 1 4 2 1 " );
$bar128[67] = array( "A" => "ETX", "B" => "c", "C" => "67", "S" => "1 4 1 1 2 2 " );
$bar128[68] = array( "A" => "EOT", "B" => "d", "C" => "68", "S" => "1 4 1 2 2 1 " );
$bar128[69] = array( "A" => "ENQ", "B" => "e", "C" => "69", "S" => "1 1 2 2 1 4 " );
$bar128[70] = array( "A" => "ACK", "B" => "f", "C" => "70", "S" => "1 1 2 4 1 2 " );
$bar128[71] = array( "A" => "BEL", "B" => "g", "C" => "71", "S" => "1 2 2 1 1 4 " );
$bar128[72] = array( "A" => "BS", "B" => "h", "C" => "72", "S" => "1 2 2 4 1 1 " );
$bar128[73] = array( "A" => "HT", "B" => "i", "C" => "73", "S" => "1 4 2 1 1 2 " );
$bar128[74] = array( "A" => "LF", "B" => "j", "C" => "74", "S" => "1 4 2 2 1 1 " );
$bar128[75] = array( "A" => "VT", "B" => "k", "C" => "75", "S" => "2 4 1 2 1 1 " );
$bar128[76] = array( "A" => "FF", "B" => "l", "C" => "76", "S" => "2 2 1 1 1 4 " );
$bar128[77] = array( "A" => "CR", "B" => "m", "C" => "77", "S" => "4 1 3 1 1 1 " );
$bar128[78] = array( "A" => "SO", "B" => "n", "C" => "78", "S" => "2 4 1 1 1 2 " );
$bar128[79] = array( "A" => "SI", "B" => "o", "C" => "79", "S" => "1 3 4 1 1 1 " );
$bar128[80] = array( "A" => "DLE", "B" => "p", "C" => "80", "S" => "1 1 1 2 4 2 " );
$bar128[81] = array( "A" => "DC1", "B" => "q", "C" => "81", "S" => "1 2 1 1 4 2 " );
$bar128[82] = array( "A" => "DC2", "B" => "r", "C" => "82", "S" => "1 2 1 2 4 1 " );
$bar128[83] = array( "A" => "DC3", "B" => "s", "C" => "83", "S" => "1 1 4 2 1 2 " );
$bar128[84] = array( "A" => "DC4", "B" => "t", "C" => "84", "S" => "1 2 4 1 1 2 " );
$bar128[85] = array( "A" => "NAK", "B" => "u", "C" => "85", "S" => "1 2 4 2 1 1 " );
$bar128[86] = array( "A" => "SYN", "B" => "v", "C" => "86", "S" => "4 1 1 2 1 2 " );
$bar128[87] = array( "A" => "ETB", "B" => "w", "C" => "87", "S" => "4 2 1 1 1 2 " );
$bar128[88] = array( "A" => "CAN", "B" => "x", "C" => "88", "S" => "4 2 1 2 1 1 " );
$bar128[89] = array( "A" => "EM", "B" => "y", "C" => "89", "S" => "2 1 2 1 4 1 " );
$bar128[90] = array( "A" => "SUB", "B" => "z", "C" => "90", "S" => "2 1 4 1 2 1 " );
$bar128[91] = array( "A" => "ESC", "B" => "{", "C" => "91", "S" => "4 1 2 1 2 1 " );
$bar128[92] = array( "A" => "FS", "B" => "|", "C" => "92", "S" => "1 1 1 1 4 3 " );
$bar128[93] = array( "A" => "GS", "B" => "}", "C" => "93", "S" => "1 1 1 3 4 1 " );
$bar128[94] = array( "A" => "RS", "B" => "~", "C" => "94", "S" => "1 3 1 1 4 1 " );
$bar128[95] = array( "hex" => "7F", "A" => "US", "B" => "DEL", "C" => "95", "S" => "1 1 4 1 1 3" );
$bar128[96] = array( "hex" => 80, "A" => "FNC 3", "B" => "FNC 3", "C" => "96", "S" => "1 1 4 3 1 1" );
$bar128[97] = array( "hex" => 81, "A" => "FNC 2", "B" => "FNC 2", "C" => "97", "S" => "4 1 1 1 1 3 " );
$bar128[98] = array( "hex" => 82, "A" => "SHIFT", "B" => "SHIFT", "C" => "98", "S" => "4 1 1 3 1 1 " );
$bar128[99] = array( "hex" => 83, "A" => "CODE C", "B" => "CODE C", "C" => "99", "S" => "1 1 3 1 4 1 " );
$bar128[100] = array( "hex" => 84, "A" => "CODE B", "B" => "FNC 4", "C" => "CODE B", "S" => "1 1 4 1 3 1 " );
$bar128[101] = array( "hex" => 85, "A" => "FNC 4", "B" => "CODE A", "C" => "CODE A", "S" => "3 1 1 1 4 1 " );
$bar128[102] = array( "hex" => 86, "A" => "FNC 1", "B" => "FNC 1", "C" => "FNC 1", "S" => "4 1 1 1 3 1 " );
$bar128[103] = array( "hex" => 87, "A" => "START (Code A)", "B" => "START (Code A)", "C" => "START (Code A)", "S" => "2 1 1 4 1 2" );
$bar128[104] = array( "hex" => 88, "A" => "START (Code B)", "B" => "START (Code B)", "C" => "START (Code B)", "S" => "2 1 1 2 1 4 " );
$bar128[105] = array( "hex" => 89, "A" => "START (Code C)", "B" => "START (Code C)", "C" => "START (Code C)", "S" => "2 1 1 2 3 2 " );
$bar128[106] = array( "A" => "STOP", "B" => "STOP", "C" => "STOP", "S" => "2 3 3 1 1 1 2 " );
?>
