<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function prosestambah( $tabel, $id, $datahasil )
{
    global $koneksi;
    global $datatabel;
    $berhasil = true;
    $q = "\r\n\t\tINSERT INTO {$tabel} \r\n\t";
    $qfield = "(";
    $qisi = "(";
    if ( $id == "autonumber" )
    {
        $qfield = "(ID,";
        $qisi = "('{$idbaru}',";
    }
    foreach ( $datahasil as $k => $v )
    {
        $tmp = explode( "_", $k );
        $qfield .= strtoupper( $tmp[1] ).",";
        if ( $tmp[0] == "tanggal" )
        {
            if ( $tmp[4] == 1 && istanggal( $v[tgl], $v[bln], $v[thn], "" ) != 1 )
            {
                $berhasil = false;
                $errmesg = "Tanggal ".$datatabel[$tmp[2]][judul]." tidak diisi dengan benar ({$v['tgl']}-{$v['bln']}-{$v['thn']})";
            }
            $datatabel[$tmp[2]][value] = $v;
            $qisi .= "'{$v['thn']}-{$v['bln']}-{$v['tgl']}',";
        }
        else if ( $tmp[0] == "jam" )
        {
            $datatabelx[$tmp[2]][value] = $v;
            $qisi .= "'{$v['jam']}:{$v['mnt']}:{$v['dtk']}',";
        }
        else if ( $tmp[0] == "cekarray" )
        {
            $datatabelx[$tmp[2]][key] = $v;
            $tmp2 = "'";
            foreach ( $v as $kk => $vv )
            {
                $tmp2 .= "{$kk},";
            }
            $tmp2 .= "'";
            $tmp2 = str_replace( ",'", "'", $tmp2 );
            $qisi .= "{$tmp2},";
            $tmp2 = "";
        }
        else
        {
            $datatabelx[$tmp[2]][value] = $v;
            if ( $tmp[4] == 1 )
            {
                if ( $tmp[3] == 0 )
                {
                    if ( isangka( $v ) == 0 || trim( $v ) == "" )
                    {
                        $berhasil = false;
                        echo $errmesg = "Data ".$datatabel[$tmp[2]][judul]." harus diisi dengan nilai bilangan bulat";
                    }
                }
                else if ( $tmp[3] == 1 )
                {
                    if ( isintegerpositif( $v ) == 0 || trim( $v ) == "" )
                    {
                        $berhasil = false;
                        $errmesg = "Data ".$datatabel[$tmp[2]][judul]." harus diisi dengan nilai bilangan bulat >= 0";
                    }
                }
                else if ( $tmp[3] == 2 )
                {
                    if ( !( isintegerpositif( $v ) && 0 < $v ) || trim( $v ) == "" )
                    {
                        $berhasil = false;
                        $errmesg = "Data ".$datatabel[$tmp[2]][judul]." harus diisi dengan nilai bilangan bulat > 0";
                    }
                }
                else if ( $tmp[3] == 3 )
                {
                    if ( trim( $v ) == "" )
                    {
                        $berhasil = false;
                        $errmesg = "Data ".$datatabel[$tmp[2]][judul]." harus diisi dengan nilai bilangan real";
                    }
                }
                else if ( $tmp[3] == 4 )
                {
                    if ( $v < 0 || trim( $v ) == "" )
                    {
                        $berhasil = false;
                        $errmesg = "Data ".$datatabel[$tmp[2]][judul]." harus diisi dengan nilai bilangan real >= 0";
                    }
                }
                else if ( $tmp[3] == 5 )
                {
                    if ( $v <= 0 || trim( $v ) == "" )
                    {
                        $berhasil = false;
                        $errmesg = "Data ".$datatabel[$tmp[2]][judul]." harus diisi dengan nilai bilangan real > 0";
                    }
                }
                else if ( $tmp[3] == 6 && trim( $v ) == "" )
                {
                    $berhasil = false;
                    $errmesg = "Data ".$datatabel[$tmp[2]][judul]." ( bertanda * )  harus diisi";
                }
            }
            $qisi .= "'{$v}',";
        }
    }
    if ( $berhasil == true )
    {
        $qfield .= ")";
        $qisi .= ")";
        $qfield = str_replace( ",)", ")", $qfield );
        $qisi = str_replace( ",)", ")", $qisi );
        $q .= $qfield."  VALUES ".$qisi;
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            $hasil[0] = 1;
            $hasil[1] = "Data berhasil dimasukkan";
            return $hasil;
        }
        $hasil[0] = 0;
        $hasil[1] = "Data tidak berhasil dimasukkan";
        $hasil[2] = $datatabelx;
        return $hasil;
    }
    $hasil[0] = 0 - 1;
    $hasil[1] = $errmesg;
    $hasil[2] = $datatabelx;
    return $hasil;
}

function getidbaru( $tabel )
{
    global $koneksi;
    $idbaru = 0;
    $q = "SELECT MAX(ID)+1 AS IDBARU FROM {$tabel}";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $d = sqlfetcharray( $h );
        $idbaru = $d[IDBARU];
    }
    return $idbaru;
}

periksaroot( );
include( "array.php" );
$q = "SELECT EDITNILAIDOSEN FROM aturan ";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$aturaneditnilaidosen = $d[EDITNILAIDOSEN];
if ( $jenisusers == 1 )
{
    $qfieldx1 = " AND mahasiswa.IDDOSEN = '{$users}'";
    $qfieldx2 = " AND dosenpengajarsp.IDDOSEN = '{$users}'";
    $href .= "iddosen={$users}&";
}
else if ( $jenisusers == 2 )
{
    $qfieldtambahan = " \r\n\tAND dosenpengajar.TAHUN=pengambilanmk.TAHUN\r\n\tAND dosenpengajar.SEMESTER=pengambilanmk.SEMESTER\r\n\tAND dosenpengajar.KELAS=pengambilanmk.KELAS\r\n\tAND dosenpengajar.IDMAKUL=pengambilanmk.IDMAKUL\r\n\t AND pengambilanmk.IDMAHASISWA = '{$users}'";
    $qfieldtambahan2 = " \r\n\t AND mahasiswa.ID = '{$users}'";
    $tabeltambahan = ",pengambilanmk";
    $href .= "idmahasiswa={$users}&";
}
$TIPE_INTEGER = 0;
$TIPE_INTEGER0 = 1;
$TIPE_INTEGER1 = 2;
$TIPE_REAL = 3;
$TIPE_REAL0 = 4;
$TIPE_REAL1 = 5;
$TIPE_STRING = 6;
?>
