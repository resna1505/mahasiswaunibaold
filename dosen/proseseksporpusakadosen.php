<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

unset( $arraysort );
$arraysort[0] = "dosen.IDDEPARTEMEN";
$arraysort[1] = "dosen.ID";
$arraysort[2] = "dosen.NAMA";
$arraysort[3] = "dosen.STATUS";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $iddepartemen != "" )
{
    $qfield .= " AND dosen.IDDEPARTEMEN='{$iddepartemen}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$iddepartemen]."' <br>";
    $qinput .= " <input type=hidden name=iddepartemen value='{$iddepartemen}'>";
    $href .= "iddepartemen={$iddepartemen}&";
}
if ( $id != "" )
{
    $qfield .= " AND dosen.ID LIKE '{$id}'";
    $qjudul .= " NIDN '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $nama != "" )
{
    $qfield .= " AND dosen.NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $status != "" )
{
    $qfield .= " AND dosen.STATUS='{$status}'";
    $qjudul .= " Status Dosen '".$arraystatusdosen["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
}
include( "../mahasiswa/prosescari2.php" );
if ( $arraysort[$sort] == "" )
{
    $sort = 1;
}
$tipe = 1;
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM dosen LEFT JOIN dosen2 ON dosen.ID=dosen2.ID\r\n\t\tWHERE 1=1 {$qprodidep3}\r\n\t\t{$qfield}\r\n\t\t";
$h = doquery($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT dosen.*,YEAR(NOW())-YEAR(msdos.TGLHRMSDOS) AS UMUR \r\n    FROM dosen  LEFT JOIN dosen2 ON dosen.ID=dosen2.ID,msdos\r\n\tWHERE dosen.ID=msdos.NODOSMSDOS \r\n\t{$qprodidep3}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
$h = doquery($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    printjudulmenucetak( "**PROSES EKSPOR KE PUSAKA**" );
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $ds[NAMA] = $d[NAMA];
        if ( $d[KELAMIN] == "L" )
        {
            $ds[JKELAMIN] = 0;
        }
        else
        {
            $ds[JKELAMIN] = 1;
        }
        $tmp = explode( "-", $d[TANGGAL] );
        $ds[TTL] = $d[TEMPAT].","."{$tmp['2']}-{$tmp['1']}-{$tmp['0']}";
        $ds[ALAMAT] = $d[ALAMAT];
        $ds[TELEPON] = $d[TELEPON];
        $ds[HP] = $d[HP];
        $ds[EMAIL] = $d[EMAIL];
        $ds[STATUS] = "normal";
        $ds[TIPEANGGOTA] = 0;
        if ( $tipe == 2 )
        {
            $ds[JENIS] = "Mahasiswa";
            $ds[NPM] = $idmahasiswa;
            $ds[ALAMATORTU] = $d[ALAMATAYAH];
            $ds[TELEPONORTU] = $d[NOAYAH];
            $ds[ANGKATAN] = $d[ANGKATAN];
            $ds[IDPRODI] = $d[IDPRODI];
        }
        else
        {
            $ds[JENIS] = "Dosen";
            $ds[IDPRODI] = $d[IDDEPARTEMEN];
        }
        $data[$d[ID]] = $ds;
        ++$i;
    }
    $urlpusaka = getaturan( "URLPUSAKA" );
    $postdata[data] = $data;
    $postdata[KEY] = ID_PROGRAM;
    http_build_query_for_curl( $postdata, $post );
    $ch = curl_init( );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
    curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 2 );
    curl_setopt( $ch, CURLOPT_POST, true );
    curl_setopt( $ch, CURLOPT_POSTFIELDS, $post );
    curl_setopt( $ch, CURLOPT_URL, $urlpusaka."/sinkronisasi_sikad2.php" );
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
    $hasil = curl_exec( $ch );
    if ( curl_errno( $ch ) )
    {
        $errorcurl = curl_error( $ch );
    }
    curl_close( $ch );
    echo "{$hasil} data berhasil diekspor.";
    $aksi = "tampilkan";
}
else
{
    $errmesg = "Data Mahasiswa Tidak Ada";
    $aksi = "";
}
?>
