<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$href .= "index.php?pilihan={$pilihan}&aksi={$aksi}&tgllap[tgl]={$tgllap['tgl']}&tgllap[bln]={$tgllap['bln']}&tgllap[thn]={$tgllap['thn']}&";
$q = "\r\n\t\t\t\tSELECT NAMA,SYARAT,SYARATW FROM konversipredikat\r\n\t\t\t\tORDER BY SYARAT DESC,SYARATW\r\n\t\t\t";
$hkonversi = mysqli_query($koneksi,$q);
while ( !( 0 < sqlnumrows( $hkonversi ) ) || !( $dkonversi = sqlfetcharray( $hkonversi ) ) )
{
    $konpredikat[] = $dkonversi;
}
if ( $idprodi != "" )
{
    $qfield .= " AND IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
}
if ( $iddosen != "" )
{
    $qfield .= " AND IDDOSEN='{$iddosen}'";
    $qjudul .= " Dosen Wali '".$arraydosen[$iddosen]."' <br>";
    $qinput .= " <input type=hidden name=iddosen value='{$iddosen}'>";
    $href .= "iddosen={$iddosen}&";
}
if ( $angkatan != "" )
{
    $qfield .= " AND ANGKATAN='{$angkatan}'";
    $qjudul .= " Angkatan '{$angkatan}' <br>";
    $qinput .= " <input type=hidden name=angkatan value='{$angkatan}'>";
    $href .= "angkatan={$angkatan}&";
}
if ( $id != "" )
{
    $qfield .= " AND mahasiswa.ID LIKE '%{$id}%'";
    $qjudul .= " NIM '{$id}' <br>";
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
if ( $status != "" )
{
    $qfield .= " AND mahasiswa.STATUS='{$status}'";
    $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
}
if ( $sort == "" )
{
    $sort = " mahasiswa.ID";
}
$qinput .= " <input type=hidden name=sort value='{$sort}'>";
$q = "SELECT COUNT(*) AS JML FROM mahasiswa,prodi,departemen \r\n\tWHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n \t{$qfieldx1} \r\n\t";
$h = mysqli_query($koneksi,$q);
$d = sqlfetcharray( $h );
$total = $d[JML];
$first = 0;
if ( 0 + $dataperhalaman <= 0 )
{
    $dataperhalaman = 1;
}
$maxdata = $dataperhalaman;
include( "../paginating.php" );
$q = "SELECT mahasiswa.*,\r\n\tIF(TANGGALKELUAR > TANGGALMASUK,\r\n\t(TO_DAYS(TANGGALKELUAR)-TO_DAYS(TANGGALMASUK))/365,0) \r\n\tAS MASABELAJAR,\r\n\tprodi.SKSMIN,\r\n\tprodi.JENIS, \r\n\tprodi.TINGKAT, \r\n\tprodi.IDDEPARTEMEN, \r\n\tdepartemen.IDFAKULTAS \r\n\tFROM mahasiswa,prodi,departemen \r\n\tWHERE 1=1 {$qprodidep5} AND\r\n\tmahasiswa.IDPRODI=prodi.ID AND\r\n\tprodi.IDDEPARTEMEN=departemen.ID\r\n\t{$qfieldtambahan2}\r\n\t{$qfield}\r\n\t{$qfieldx1} \r\n\tORDER BY {$sort} {$qlimit}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    echo "<center>\r\n     \r\n      \r\n      ";
    if ( $aksi != "cetak" )
    {
        printjudulmenu( "Transkrip Nilai  " );
        echo "{$tpage} {$tpage2}";
    }
    else
    {
        echo "\r\n\t\t\t<b><u>TRANSKRIP NILAI</u></b><br>\r\n\t\t\t<table><tr><td>No. Seri Ijazah : ..................... </td></tr></table>\r\n\t\t\t<br><br>\r\n\t\t\t";
    }
    if ( $aksi != "cetak" )
    {
        echo "\r\n\t\t\t\t<table class=form>\r\n\t\t\t\t<tr><td>\r\n\t\t\t<form target=_blank action='cetaktranskrip.php'>\r\n \t\t\t\t<input type=submit name=aksi class=tombol value='Cetak'>\r\n   \t\t\t\t".createinputhidden( "tgllap[tgl]", "{$tgllap['tgl']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[bln]", "{$tgllap['bln']}", "" )."\r\n\t\t\t".createinputhidden( "tgllap[thn]", "{$tgllap['thn']}", "" )."\r\n\t\t\t".createinputhidden( "diagram", "{$diagram}", "" )."\r\n\t\t\t".createinputhidden( "nilaidiambil", "{$nilaidiambil}", "" )."\r\n\t\t\t".createinputhidden( "jenistampilan", "{$jenistampilan}", "" )."\r\n \t\t\t".createinputhidden( "dataperhalaman", "{$dataperhalaman}", "" )."\r\n \t\t\t\t{$qinput} {$input}\r\n\t\t\t</form>\r\n\t\t\t\t</td></tr></table>";
    }
    $totalsemua = 0;
    $bobotsemua = 0;
    $totals = "";
    $bobots = "";
    if ( $d = sqlfetcharray( $h ) )
    {
        $ketlog = "Cetak Transkrip {$d['ID']} / {$d['NAMA']}";
        buatlog( 57 );
        $totalsemua = 0;
        $bobotsemua = 0;
        $totals = "";
        $bobots = "";
        $tmp = explode( "-", $d[TANGGAL] );
        echo " \r\n\t\t\t<center>\r\n\t\t\t<table  width=600  >\r\n\t\t\t\t<tr valign=top>\r\n\t\t\t\t<td width=50%>\r\n\t\t\t\t<table    >\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Nama</td>\r\n\t\t\t\t\t\t<td>: {$d['NAMA']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td class=judulform>NIM</td>\r\n\t\t\t\t\t\t<td>: {$d['ID']}</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td nowrap>Tempat/Tgl Lahir</td>\r\n\t\t\t\t\t\t<td nowrap>: {$d['TEMPAT']},  {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']}</td>\r\n\t\t\t\t\t</tr>\r\n \t\t\t\t</table>\r\n\t\t\t</td>\r\n\t\t\t<td  width=50%>\r\n\r\n\t\t\t\t<table   >";
        if ( $POLTITEKNIK == 0 )
        {
            echo "\r\n \t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Fakultas</td>\r\n\t\t\t\t\t\t<td>: ".$arrayfakultas[$d[IDFAKULTAS]]."</td>\r\n\t\t\t\t\t</tr>";
        }
        echo "\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Jurusan</td>\r\n\t\t\t\t\t\t<td>: ".$arraydepartemen[$d[IDDEPARTEMEN]]."</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t\t<tr align=left>\r\n\t\t\t\t\t\t<td>Program Studi</td>\r\n\t\t\t\t\t\t<td>: ".$arrayprodi[$d[IDPRODI]]." (".$arrayjenjang[$d[TINGKAT]].")</td>\r\n\t\t\t\t\t</tr>\r\n\t\t\t\t</table>\t\t\t\t\r\n\t\t\t\t\r\n\t\t\t</td>\r\n\t\t</tr>\r\n\t\t</table>\r\n\t \r\n\t\t\t";
        $angkatanmhs = $d[ANGKATAN];
        $idmahasiswa = $d[ID];
        if ( $jenistampilan == 1 )
        {
            include( "prosestranskripasli.php" );
        }
        if ( $jenistampilan == 0 )
        {
            include( "prosestranskrip.php" );
        }
        else if ( $jenistampilan == 2 )
        {
            include( "prosestranskripkolom.php" );
        }
        else if ( $jenistampilan == 3 )
        {
            include( "prosestranskripduakolom.php" );
        }
        if ( $aksi != "cetak" )
        {
            echo "<hr>";
        }
        else
        {
            echo "<br style='page-break-after:always'>";
        }
    }
}
$errmesg = "Data mahasiswa tidak ada";
$aksi = "";
?>
