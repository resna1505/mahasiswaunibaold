<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
$jumlahjawaban = 50;
if ( $aksi == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Tabel Hasil Isian Kuesioner", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan Data", $tahun, $semester );
        $vld[] = cekvaliditaskodeprodi( "Kode Prodi", $kodeps );
        $vld[] = cekvaliditaskode( "Kode Tes", $kodetest, 32 );
        $vld[] = cekvaliditaskode( "NIDN", $nidn, 32, false );
        $i = 1;
        while ( $i <= $jumlahjawaban )
        {
            $tmp = "jawaban".$i;
            $vld[] = cekvaliditaskode( "Isian Jawaban No. ".$i, $$tmp, 2 );
            ++$i;
        }
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
                    $qfield .= ", JW0".$urut."TRTES ";
                    $qjawaban .= ",  '{$value}' ";
                    ++$i;
                }
                $q = "INSERT INTO trtes \r\n    (THSMSTRTES ,KDPTITRTES ,KDJENTRTES ,KDPSTTRTES  , KDTESTRTES,NOKPSTRTES {$qfield} )\r\n    VALUES\r\n    ('{$tahun}{$semester}','{$kodept}','{$kodejenjang}','{$kodeps}','{$kodetes}','{$nidn}'  {$qjawaban}\r\n     )";
                mysqli_query($koneksi,$q);
                $idupdate = $kodetes;
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
                    $qjawaban .= ", JW0".$urut."TRTES = '{$value}'";
                    ++$i;
                }
                $q = "\r\n      UPDATE trtes SET\r\n      KDTESTRTES=  '{$kodetes}',\r\n      NOKPSTRTES=  '{$nidn}' \r\n      {$qjawaban}\r\n      WHERE\r\n       KDPTITRTES='{$kodept}' AND\r\n        KDPSTTRTES='{$kodeps}' AND\r\n        KDJENTRTES='{$kodejenjang}' AND\r\n        THSMSTRTES='{$tahun}{$semester}' AND\r\n        KDTESTRTES=  '{$idupdate}' \r\n    ";
                mysqli_query($koneksi,$q);
            }
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $idupdate = $kodetes;
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
$q = "SELECT * FROM trtes  \r\nWHERE\r\n       KDPTITRTES='{$kodept}' AND\r\n        KDPSTTRTES='{$kodeps}' AND\r\n        KDJENTRTES='{$kodejenjang}' AND\r\n        THSMSTRTES='{$tahun}{$semester}' AND\r\n        KDTESTRTES=  '{$idupdate}'  \r\n";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $ada = 1;
    $d = sqlfetcharray( $h );
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
echo "\r\n<form action=index.php method=post>\r\n<input type=hidden name=pilihan value='{$pilihan}'>\r\n<input type=hidden name=idprodi value='{$idprodi}'>\r\n<input type=hidden name=kodept value='{$kodept}'>\r\n<input type=hidden name=kodeps value='{$kodeps}'>\r\n<input type=hidden name=kodejenjang value='{$kodejenjang}'>\r\n<input type=hidden name=tahun value='{$tahun}'>\r\n<input type=hidden name=semester value='{$semester}'>\r\n<input type=hidden name=idupdate value='{$idupdate}'>\r\n<input type=hidden name=urutan value='{$urutan}'>\r\n<input type=hidden name=sessid value='{$token}'>\r\n\r\n<table class=form>\r\n  <tr>\r\n    <td width=200>Tahun Semester Pelaporan Data   </td>\r\n    <td>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n  </tr>\r\n  <tr>\r\n    <td >Jurusan/Prodi    </td>\r\n    <td>".$arrayprodidep[$idprodi]."</td>\r\n  </tr>\r\n \r\n  <tr>\r\n    <td >Kode Tes</td>\r\n    <td>\r\n    <input type=text size=2 name=kodetes value='{$d['KDTESTRTES']}'> \r\n    </td>\r\n  </tr>\r\n   <tr>\r\n    <td >NIDN Ketua Program Studi </td>\r\n    <td> <input type=text size=10 name=nidn value='{$d['NOKPSTRTES']}'> </td>\r\n  </tr>\r\n  ";
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
    echo "\r\n   <tr>\r\n    <td >Isian Jawaban No. {$i} </td>\r\n    <td> <input type=text size=1 name=jawaban{$i} value='".$d["JW0".$urut."TRTES"]."' ></td>\r\n  </tr>\r\n    ";
    ++$i;
}
echo "\r\n \r\n \r\n  <tr>\r\n    <td ></td>\r\n    <td>\r\n    ".IKONCETAK32."\r\n    <input type=submit value=Simpan name=aksi>\r\n     <input type=reset value=Reset  >\r\n     </form>\r\n    </td> \r\n  </tr>\r\n</table>";
?>
