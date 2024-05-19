<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$q = "SELECT * FROM setingijazah";
$h = mysqli_query($koneksi,$q);
$d2 = sqlfetcharray( $h );
if ( $idprodi != "" )
{
    $qfield .= " AND IDPRODI='{$idprodi}'";
    $qjudul .= " Jurusan/Program Studi '".$arrayprodidep[$idprodi]."' <br>";
    $qinput .= " <input type=hidden name=idprodi value='{$idprodi}'>";
    $href .= "idprodi={$idprodi}&";
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
    $qjudul .= " NIM = '{$id}' <br>";
    $qinput .= " <input type=hidden name=id value='{$id}'>";
    $href .= "id={$id}&";
}
if ( $status != "" )
{
    $qfield .= " AND STATUS='{$status}'";
    $qjudul .= " Status Mahasiswa '".$arraystatusmahasiswa["{$status}"]."' <br>";
    $qinput .= " <input type=hidden name=status value='{$status}'>";
    $href .= "status={$status}&";
}
$q = "SELECT mahasiswa.*,\r\n prodi.NAMA as NAMAP ,prodi.GELAR,\r\n mspst.NOMBAMSPST ,\r\n fakultas.NAMA as NAMAF, \r\n fakultas.NAMAPIMPINAN as DEKAN \r\n FROM mahasiswa,prodi,departemen,fakultas,mspst\r\nWHERE 1=1 \r\nAND\r\nmahasiswa.IDPRODI=prodi.ID\r\nAND\r\ndepartemen.ID=prodi.IDDEPARTEMEN\r\nAND\r\ndepartemen.IDFAKULTAS=fakultas.ID\r\nAND\r\nmspst.IDX=prodi.ID\r\n{$qfield}\r\nORDER BY ID\r\nLIMIT 0,{$maxdata}";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    while ( $d = sqlfetcharray( $h ) )
    {
        $tmp = explode( "-", $d[TANGGALKELUAR] );
        $tgllulus = $tmp[2];
        $blnlulus = $tmp[1];
        $thnlulus = $tmp[0];
        $tmp = explode( "-", $d[TANGGAL] );
        echo "\r\n    <center   style='page-break-after:always;'> \r\n    <table width=1000  >\r\n    <tr>\r\n    <td align=center style='font-family:  Monotype Corsiva;font-size:16pt;'>\r\n      <b>dengan ini menyatakan bahwa : </b>\r\n      <br><br>\r\n    </td>\r\n    </tr>\r\n    <tr>\r\n    <td align=center style=' font-size:12pt;'>\r\n      <font style='font-family: Monotype Corsiva  ;font-size:28pt;'>\r\n      {$d['NAMA']}</font><br><br>\r\n      <b>NPM : <i>{$d['ID']}</i></b> <br><br>\r\n        <font style='font-family: Monotype Corsiva  ;font-size:18pt;'>\r\n      lahir di {$d['TEMPAT']} tanggal {$tmp['2']} ".$arraybulan[$tmp[1] - 1]." {$tmp['0']} \r\n      telah menyelesaikan dengan baik dan memenuhi segala syarat<br>\r\n      pendidikan pada Program Studi {$d['NAMAP']} <br>\r\n      Fakultas {$d['NAMAF']} <br>\r\n      Status terakreditasi nomor {$d['NOMBAMSPST']} <br>\r\n      Oleh sebab itu kepadanya diberikan gelar <br><br>\r\n      </b>\r\n      <font style='font-family: Monotype Corsiva  ;font-size:24pt;'>\r\n      {$d['GELAR']}\r\n      </font>\r\n       <font style='font-family: Monotype Corsiva  ;font-size:18pt;'>\r\n      <br><br>\r\n      beserta segala hak dan kewajiban yang melekat pada gelar tersebut.\r\n      <br>\r\n      Tanggal kelulusan  {$tgllulus} ".$arraybulan[$blnlulus - 1]." {$thnlulus}\r\n    </td>\r\n    </tr>\r\n    </table>\r\n    <br><br>\r\n    <table width=800>\r\n      <tr valign=top>\r\n        <td width=30%>\r\n        <i>\r\n          <br>Dekan,\r\n          <br><br><br><br><br><br>\r\n          {$d['DEKAN']}\r\n        </td>\r\n        <td  >\r\n        -\r\n        </td>\r\n        <td width=30%>\r\n          ".$lokasikantor.", {$tgllap['tgl']} ".$arraybulan[$tgllap[bln] - 1]." {$tgllap['thn']}, <br>\r\n          <i>\r\n          Rektor,\r\n          <br><br><br><br><br><br>\r\n          {$d2['REKTOR']}\r\n        </td>\r\n      </tr>\r\n    </table>\r\n    </center>\r\n    \r\n    ";
    }
}
echo "Data Mahasiswa tidak ada";
?>
