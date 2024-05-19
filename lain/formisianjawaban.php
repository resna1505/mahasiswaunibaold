<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$jumlahjawaban = 12;
if ( $aksi == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Tabel Isian Jawaban Pertanyaan", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan Data", $tahun, $semester );
        $vld[] = cekvaliditaskodeprodi( "Kode Prodi", $kodeps );
        $vld[] = cekvaliditaskode( "Kode Tes", $kodetest, 32 );
        $vld[] = cekvaliditaskode( "No Urut", $nourut, 32, false );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
        }
        else
        {
            if ( $idupdate == "" && $urutan == "" )
            {
                $qjawaban = $qfield = "";
                $i = 1;
                while ( $i <= $jumlahjawaban )
                {
                    if ( $i < 10 )
                    {
                        $urut = "0{$i}";
                    }
                    else
                    {
                        $urut = "{$i}";
                    }
                    $var = "jawaban{$i}";
                    $value = $$var;
                    $qfield .= ", JWB".$urut."TRPPG ";
                    $qjawaban .= ",  '{$value}' ";
                    ++$i;
                }
                $q = "INSERT INTO trppg \r\n    (THSMSTRPPG ,KDPTITRPPG ,KDJENTRPPG ,KDPSTTRPPG  , KDTESTRPPG,NORUTTRPPG {$qfield} )\r\n    VALUES\r\n    ('{$tahun}{$semester}','{$kodept}','{$kodejenjang}','{$kodeps}','{$kodetes}','{$nourut}'  {$qjawaban}\r\n     )";
                mysqli_query($koneksi,$q);
                $idupdate = $kodetes;
                $urutan = $nourut;
            }
            else
            {
                $qjawaban = "";
                $i = 1;
                while ( $i <= $jumlahjawaban )
                {
                    if ( $i < 10 )
                    {
                        $urut = "0{$i}";
                    }
                    else
                    {
                        $urut = "{$i}";
                    }
                    $var = "jawaban{$i}";
                    $value = $$var;
                    $qjawaban .= ", JWB".$urut."TRPPG = '{$value}'";
                    ++$i;
                }
                $q = "\r\n      UPDATE trppg SET\r\n      KDTESTRPPG=  '{$kodetes}',\r\n      NORUTTRPPG=  '{$nourut}' \r\n      {$qjawaban}\r\n      WHERE\r\n       KDPTITRPPG='{$kodept}' AND\r\n        KDPSTTRPPG='{$kodeps}' AND\r\n        KDJENTRPPG='{$kodejenjang}' AND\r\n        THSMSTRPPG='{$tahun}{$semester}' AND\r\n        KDTESTRPPG=  '{$idupdate}' AND\r\n        NORUTTRPPG=  '{$urutan}' \r\n    ";
                mysqli_query($koneksi,$q);
            }
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $idupdate = $kodetes;
                $urutan = $nourut;
                $errmesg = "Data Isian Jawaban pertanyaan berhasil disimpan";
            }
        }
    }
}
$q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $kodept = $d[KDPTIMSPST];
    $kodejenjang = $d[KDJENMSPST];
    $kodeps = $d[KDPSTMSPST];
}
$q = "SELECT * FROM trppg  \r\nWHERE\r\n       KDPTITRPPG='{$kodept}' AND\r\n        KDPSTTRPPG='{$kodeps}' AND\r\n        KDJENTRPPG='{$kodejenjang}' AND\r\n        THSMSTRPPG='{$tahun}{$semester}' AND\r\n        KDTESTRPPG=  '{$idupdate}' AND\r\n        NORUTTRPPG=  '{$urutan}' \r\n";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $ada = 1;
    $d = sqlfetcharray( $h );
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
echo "\r\n<form action=index.php method=post>\r\n<input type=hidden name=pilihan value='{$pilihan}'>\r\n<input type=hidden name=idprodi value='{$idprodi}'>\r\n<input type=hidden name=kodept value='{$kodept}'>\r\n<input type=hidden name=kodeps value='{$kodeps}'>\r\n<input type=hidden name=kodejenjang value='{$kodejenjang}'>\r\n<input type=hidden name=tahun value='{$tahun}'>\r\n<input type=hidden name=semester value='{$semester}'>\r\n<input type=hidden name=idupdate value='{$idupdate}'>\r\n<input type=hidden name=urutan value='{$urutan}'>\r\n<input type=hidden name=sessid value='{$_SESSION['token']}'>\r\n\r\n<table class=form>\r\n  <tr>\r\n    <td width=200>Tahun Semester Pelaporan Data   </td>\r\n    <td>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jurusan/Prodi    </td>\r\n    <td>".$arrayprodidep[$idprodi]."</td>\r\n  </tr>\r\n \r\n  <tr>\r\n    <td >Kode Tes</td>\r\n    <td>\r\n    <input type=text size=2 name=kodetes value='{$d['KDTESTRPPG']}'> \r\n    </td>\r\n  </tr>\r\n   <tr>\r\n    <td >Urutan </td>\r\n    <td> <input type=text size=2 name=nourut value='{$d['NORUTTRPPG']}'> </td>\r\n  </tr>\r\n  ";
$i = 1;
while ( $i <= $jumlahjawaban )
{
    if ( $i < 10 )
    {
        $urut = "0{$i}";
    }
    else
    {
        $urut = "{$i}";
    }
    echo "\r\n   <tr>\r\n    <td >Isian Jawaban No. {$i} </td>\r\n    <td> <textarea type=text cols=50 rows=3 name=jawaban{$i} >".$d["JWB".$urut."TRPPG"]."</textarea></td>\r\n  </tr>\r\n    ";
    ++$i;
}
echo "\r\n \r\n \r\n  <tr>\r\n    <td ></td>\r\n    <td>\r\n    ".IKONUPDATE48."\r\n    <input type=submit value=Simpan name=aksi>\r\n     <input type=reset value=Reset  >\r\n     </form>\r\n    </td> \r\n  </tr>\r\n</table>";
?>
