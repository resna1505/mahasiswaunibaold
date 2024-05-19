<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

unset( $arraysort );
$arraysort[0] = "mahasiswa.IDPRODI";
$arraysort[1] = "mahasiswa.ANGKATAN";
$arraysort[2] = "mahasiswa.ID";
$arraysort[3] = "mahasiswa.NAMA";
$arraysort[4] = "mahasiswa.STATUS";
$arraysort[5] = "mahasiswa.IDDOSEN";
$href = "index.php?pilihan={$pilihan}&aksi=tampilkan&";
if ( $idprodi != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodi[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $iddosen != "" )
{
    $qfield .= " AND mahasiswa.IDDOSEN='{$iddosen}'";
    $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
    $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
    $href .= "iddosen={$iddosen}&";
}
if ( $angkatan != "" )
{
    $qfield .= " AND mahasiswa.ANGKATAN='{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
if ( $id != "" )
{
    $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
    $qjudul .= " NIM mengandung kata  '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $nama != "" )
{
    $qfield .= " AND mahasiswa.NAMA LIKE '%{$nama}%'";
    $qjudul .= " Nama mengandung kata '{$nama}' <br>";
    $qinput .= " <input type=hidden name=nama value='{$nama}'>";
    $href .= "nama={$nama}&";
}
if ( $statusawal != "" )
{
    $qjudul .= " Status Awal '".$arraystatusmhsbaru["{$statusawal}"]."' <br>";
    $qinput .= " <input type=hidden name=statusawal value='{$statusawal}'>";
    $href .= "statusawal={$statusawal}&";
    $qfield .= " AND msmhs.STPIDMSMHS='{$statusawal}'";
}
if ( $status != "" )
{
    $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
    if ( $iftahunakademik == 1 )
    {
        $qtabel = ", trlsm ";
        $qtabel2 = " trlsm, ";
        $qfield .= "\r\n        AND mahasiswa.ID=trlsm.NIMHSTRLSM\r\n        AND trlsm.THSMSTRLSM='{$tahun2}{$semester2}' AND trlsm.STMHSTRLSM='{$status}'\r\n      ";
        $qjudul .= " Periode Tahun Akademik : {$tahun2}/".( $tahun2 + 1 )." ".$arraysemester[$semester2]." <br>";
        $qinput .= " \r\n      <input type=hidden name=iftahunakademik value='{$iftahunakademik}'>\r\n      <input type=hidden name=tahun2 value='{$tahun2}'>\r\n      <input type=hidden name=semester2 value='{$semester2}'>\r\n      ";
    }
    else
    {
        $qfield .= " AND mahasiswa.STATUS='{$status}'";
    }
}
if ( $jeniskelas != "" )
{
    $qfield .= " AND mahasiswa.JENISKELAS='{$jeniskelas}'";
    $qjudul .= " Jenis Kelas '".$arraykelasstei["{$jeniskelas}"]."' <br>";
    $qinput .= " <input type=hidden name=jeniskelas value='{$jeniskelas}'>";
    $href .= "jeniskelas={$jeniskelas}&";
}
if ( $tahuna != "" && $semestera != "" )
{
    $qfield .= " AND msmhs.SMAWLMSMHS='".$tahuna."{$semestera}'";
    $qjudul .= " Semester Awal '".$arraysemester["{$semestera}"]."  {$tahuna}' <br>";
    $qinput .= " <input type=hidden name=tahuna value='{$tahuna}'>";
    $qinput .= " <input type=hidden name=semestera value='{$semestera}'>";
    $href .= "semestera={$semestera}&tahuna={$tahuna}&";
}
if ( $arraysort[$sort] == "" )
{
    $sort = 2;
}
$tipe = 2;
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM mahasiswa  \r\n\tWHERE \r\n\t1=1\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\t";
$h = doquery($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
include( "../paginating.php" );
$q = "SELECT mahasiswa.*\r\n\t\r\n  FROM mahasiswa  \r\n\tWHERE 1=1\r\n   {$qprodidep2}\r\n\t{$qfield}\r\n\tORDER BY ".$arraysort[$sort]." {$qlimit}";
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
