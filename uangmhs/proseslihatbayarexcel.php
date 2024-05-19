<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

require_once( "../dbfparser/Column.class.php" );
require_once( "../dbfparser/Record.class.php" );
require_once( "../dbfparser/Table.class.php" );
require_once( "../dbfparser/WritableTable.class.php" );
periksaroot( );
if ( $jenisusers == 3 )
{
    $idmahasiswa = $users;
}
unset( $arraysort );
$arraysort[0] = "bayarkomponen.IDMAHASISWA";
$arraysort[1] = "mahasiswa.NAMA";
$arraysort[2] = "bayarkomponen.IDKOMPONEN";
$arraysort[3] = "bayarkomponen.TANGGALBAYAR";
$arraysort[4] = "bayarkomponen.JUMLAH";
$arraysort[5] = "bayarkomponen.DISKON";
$arraysort[6] = "bayarkomponen.JUMLAH-DISKON";
$arraysort[7] = "bayarkomponen.TAHUNAJARAN";
$arraysort[8] = "bayarkomponen.CARABAYAR";
$arraysort[9] = "bayarkomponen.KET";
$href = "index.php?pilihan={$pilihan}&aksi=Tampilkan&";
if ( $idmahasiswa != "" )
{
    $qfield .= " AND IDMAHASISWA LIKE '%{$idmahasiswa}%'";
    $qjudul .= " NIM  '{$idmahasiswa}' <br>";
    $qinput .= " <input type=hidden name=idmahasiswa value='{$idmahasiswa}'>";
    $href .= "idmahasiswa={$idmahasiswa}&";
}
if ( $angkatan != "" )
{
    $qfield .= " AND mahasiswa.ANGKATAN = '{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
if ( $idprodi != "" )
{
    $qfield .= " AND mahasiswa.IDPRODI = '{$idprodi}'";
    $qjudul .= " Prodi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $istglbayar == 1 )
{
    $qfield .= "\r\n \t\t\tAND \r\n \t\t\t(\r\n \t\t\t\tTANGGALBAYAR >= DATE_FORMAT('{$tglbayar['thn']}-{$tglbayar['bln']}-{$tglbayar['tgl']}','%Y-%m-%d')\r\n \t\t\t\tAND\r\n \t\t\t\tTANGGALBAYAR <= DATE_FORMAT('{$tglbayar2['thn']}-{$tglbayar2['bln']}-{$tglbayar2['tgl']}','%Y-%m-%d')\r\n \t\t\t)\r\n \t\t";
    $qjudul .= " Tanggal bayar antara  {$tglbayar['tgl']}-{$tglbayar['bln']}-{$tglbayar['thn']} s.d\r\n\t\t {$tglbayar2['tgl']}-{$tglbayar2['bln']}-{$tglbayar2['thn']} \r\n\t\t <br>";
    $qinput .= " \r\n\t\t\t<input type=hidden name=istglbayar value='{$istglbayar}'>\r\n\t\t\t<input type=hidden name=tglbayar[thn] value='{$tglbayar['thn']}'>\r\n\t\t\t<input type=hidden name=tglbayar[bln] value='{$tglbayar['bln']}'>\r\n\t\t\t<input type=hidden name=tglbayar[tgl] value='{$tglbayar['tgl']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[thn] value='{$tglbayar2['thn']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[bln] value='{$tglbayar2['bln']}'>\r\n\t\t\t<input type=hidden name=tglbayar2[tgl] value='{$tglbayar2['tgl']}'>\r\n\t\t";
    $href .= "istglbayar={$istglbayar}&tglbayar[tgl]={$tglbayar['tgl']}&tglbayar[bln]={$tglbayar['bln']}&tglbayar[thn]={$tglbayar['thn']}&\r\n\t\ttglbayar2[tgl]={$tglbayar2['tgl']}&tglbayar2[bln]={$tglbayar2['bln']}&tglbayar2[thn]={$tglbayar2['thn']}&";
}
if ( $istglentri == 1 )
{
    $qfield .= "\r\n \t\t\tAND \r\n \t\t\t(\r\n \t\t\t\tbayarkomponen.TANGGAL >= DATE_FORMAT('{$tglentri['thn']}-{$tglentri['bln']}-{$tglentri['tgl']}','%Y-%m-%d')\r\n \t\t\t\tAND\r\n \t\t\t\tbayarkomponen.TANGGAL <= DATE_FORMAT('{$tglentri2['thn']}-{$tglentri2['bln']}-{$tglentri2['tgl']}','%Y-%m-%d')\r\n \t\t\t)\r\n \t\t";
    $qjudul .= " Tanggal entri antara  {$tglentri['tgl']}-{$tglentri['bln']}-{$tglentri['thn']} s.d\r\n\t\t {$tglentri2['tgl']}-{$tglentri2['bln']}-{$tglentri2['thn']} \r\n\t\t <br>";
    $qinput .= " \r\n\t\t\t<input type=hidden name=istglentri value='{$istglentri}'>\r\n\t\t\t<input type=hidden name=tglentri[thn] value='{$tglentri['thn']}'>\r\n\t\t\t<input type=hidden name=tglentri[bln] value='{$tglentri['bln']}'>\r\n\t\t\t<input type=hidden name=tglentri[tgl] value='{$tglentri['tgl']}'>\r\n\t\t\t<input type=hidden name=tglentri2[thn] value='{$tglentri2['thn']}'>\r\n\t\t\t<input type=hidden name=tglentri2[bln] value='{$tglentri2['bln']}'>\r\n\t\t\t<input type=hidden name=tglentri2[tgl] value='{$tglentri2['tgl']}'>\r\n\t\t";
    $href .= "istglentri={$istglentri}&tglentri[tgl]={$tglentri['tgl']}&tglentri[bln]={$tglentri['bln']}&tglentri[thn]={$tglentri['thn']}&\r\n\t\ttglentri2[tgl]={$tglentri2['tgl']}&tglentri2[bln]={$tglentri2['bln']}&tglentri2[thn]={$tglentri2['thn']}&";
}
if ( $carabayar != "" )
{
    $qfield .= " AND CARABAYAR = '{$carabayar}'";
    $qjudul .= " Cara Bayar : ".$arraycarabayar[$carabayar]." <br>";
    $qinput .= " <input type=hidden name=carabayar value='{$carabayar}'>";
    $href .= "carabayar={$carabayar}&";
}
if ( $idkomponen != "" )
{
    $qfield .= " AND bayarkomponen.IDKOMPONEN = '{$idkomponen}'";
    $qjudul .= " Komponen '".$arraykomponenpembayaran[$idkomponen]."' <br>";
    $qinput .= " <input type=hidden name=idkomponen value='{$idkomponen}'>";
    $href .= "idkomponen={$idkomponen}&";
    if ( $arrayjeniskomponenpembayaran[$idkomponen] == 2 )
    {
        if ( $tahunajaran != "" )
        {
            $qfield .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunajaran}'";
            $qjudul .= " Tahun Akademik '".( $tahunajaran - 1 )."/{$tahunajaran}' <br>";
            $qinput .= " <input type=hidden name=tahunajaran value='{$tahunajaran}'>";
            $href .= "tahunajaran={$tahunajaran}&";
        }
    }
    else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 3 )
    {
        if ( $semesterbayar != "" )
        {
            $qfield .= " AND bayarkomponen.SEMESTER = '{$semesterbayar}'";
            $qjudul .= " Semester '".$arraysemester[$semesterbayar]."' <br>";
            $qinput .= " <input type=hidden name=semesterbayar value='{$semesterbayar}'>";
            $href .= "semesterbayar={$semesterbayar}&";
        }
        if ( $tahunajaran != "" )
        {
            $qfield .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunajaran}'";
            $qjudul .= " Tahun Akademik '".( $tahunajaran - 1 )."/{$tahunajaran}' <br>";
            $qinput .= " <input type=hidden name=tahunajaran value='{$tahunajaran}'>";
            $href .= "tahunajaran={$tahunajaran}&";
        }
    }
    else if ( $arrayjeniskomponenpembayaran[$idkomponen] == 5 )
    {
        if ( $semesterbayar2 != "" )
        {
            $qfield .= " AND bayarkomponen.SEMESTER = '{$semesterbayar2}'";
            $qjudul .= " Bulan/Tahun ".$arraybulan[$semesterbayar2 - 1]."  ";
            $qinput .= " <input type=hidden name=semesterbayar2 value='{$semesterbayar2}'>";
            $href .= "semesterbayar2={$semesterbayar2}&";
        }
        if ( $tahunajaran2 != "" )
        {
            $qfield .= " AND bayarkomponen.TAHUNAJARAN = '{$tahunajaran2}'";
            $qjudul .= " Tahun : {$tahunajaran2} <br>";
            $qinput .= " <input type=hidden name=tahunajaran2 value='{$tahunajaran2}'>";
            $href .= "tahunajaran2={$tahunajaran2}&";
        }
    }
}
if ( $arraysort[$sort] == "" )
{
    $sort = 0;
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT bayarkomponen.*,DATE_FORMAT(bayarkomponen.TANGGALBAYAR,'%d-%m-%Y') AS TGLBAYAR,\r\n\t mahasiswa.NAMA {$field99} , \r\n\tkomponenpembayaran.JENIS\r\n\tFROM bayarkomponen , mahasiswa,komponenpembayaran\r\n\tWHERE \r\n\tbayarkomponen.IDMAHASISWA=mahasiswa.ID\r\n\tAND bayarkomponen.IDKOMPONEN=komponenpembayaran.ID\r\n\t {$qfield}\r\n\tORDER BY ".$arraysort[$sort]."";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $token = md5( uniqid( rand(), TRUE ) );
    $tableParent = new dbfTable("SHEET1.dbf");
    $tableParent->open();
    $tableNew = ($tableParent);
    $tableNew->openWrite( "../dbfparser/test/{$token}.DBF", true );
    $tableNew->startwriteRecordX( );
    $tableParent->close( );
    $i = 1;
    while ( $d = sqlfetcharray( $h ) )
    {
        $kelas = kelas( $i );
        ++$i;
        $r =& $tableNew->appendRecord( );
        $r->setObjectByName( "IDMHS", $d[IDMAHASISWA] );
        $r->setObjectByName( "IDKOMPONEN", $d[IDKOMPONEN] );
        $r->setObjectByName( "TGLBAYAR", strtotime( $d[TANGGALBAYAR] ) );
        $r->setObjectByName( "JENIS", $d[JENIS] );
        $r->setObjectByName( "JUMLAH", $d[JUMLAH] );
        $r->setObjectByName( "KET", $d[KET] );
        $r->setObjectByName( "TAHUN", $d[TAHUNAJARAN] );
        $r->setObjectByName( "SEMESTER", $d[SEMESTER] );
        $r->setObjectByName( "CARABAYAR", $d[CARABAYAR] );
        $r->setObjectByName( "DISKON", $d[DISKON] );
        $r->setObjectByName( "DENDA", $d[DENDA] );
        $r->setObjectByName( "BIAYA", $d[BIAYA] );
        $r->setObjectByName( "BULANSPP", $d[BULANSPP] );
        $r->setObjectByName( "TGLENTRI", strtotime( $d[TANGGAL] ) );
        $tableNew->writeRecordX( );
    }
    $tableNew->writeHeader( );
    $aksi = "tampilkan";
    $f = fopen( "../dbfparser/test/{$token}.DBF", "rb" );
    $fsize = @filesize( @"../dbfparser/test/{$token}.DBF" );
    $data = @fread( @$f, @$fsize );
    fclose( $f );
    @unlink( @"../dbfparser/test/{$token}.DBF" );
    header( "Cache-Control: no-store, no-cache, must-revalidate" );
    header( "Cache-Control: post-check=0, pre-check=0", false );
    header( "Expires: Mon, 26 Jul 1997 05:00:00 GMT" );
    header( "Last-Modified: ".gmdate( "D, d M Y H:i:s" )." GMT" );
    header( "Pragma: no-cache" );
    header( "Content-Type: application/octet-stream" );
    header( "Content-Type: application/force-download\n" );
    header( "Content-Disposition: attachment; filename=\"datapembayaranya.dbf\"" );
    echo $data;
}
else
{
    $errmesg = "Data Pembayaran Tidak Ada";
    $aksi = "";
}
?>
