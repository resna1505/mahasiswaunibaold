<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $aksi == "Simpan" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Pimpinan dan Tenaga Non-Akademik", SIMPAN_DATA );
    }
    else
    {
        unset( $_SESSION['token'] );
        $vld[] = cekvaliditasthnajaran( "Tahun/Semester Pelaporan Data", $tahun, $semester );
        $vld[] = cekvaliditaskodeprodi( "Kode Prodi", $kodeps );
        $vld[] = cekvaliditasnama( "Ketua Yayasan", $nama1 );
        $vld[] = cekvaliditasnama( "Sekretaris Yayasan", $nama2 );
        $vld[] = cekvaliditasnama( "Bendahara Yayasan", $nama3 );
        $vld[] = cekvaliditasnidn( "NIDN Rektor/Direktur/Ketua", $nidn1 );
        $vld[] = cekvaliditasnidn( "NIDN Pembantu Rektor I", $nidn2 );
        $vld[] = cekvaliditasnidn( "NIDN Pembantu Rektor II", $nidn3 );
        $vld[] = cekvaliditasnidn( "NIDN Pembantu Rektor III", $nidn4 );
        $vld[] = cekvaliditasnidn( "NIDN Pembantu Rektor IV", $nidn5 );
        $vld[] = cekvaliditasnidn( "NIDN Pembantu Rektor V", $nidn6 );
        $vld[] = cekvaliditastanggal( "Tanggal S.K", $tgl1, $bln1, $thn1 );
        $vld[] = cekvaliditastanggal( "Tanggal Akhir Berlaku S.K", $tgl2, $bln2, $thn2 );
        $vld[] = cekvaliditastanggal( "Tanggal S.K", $tgl2, $bln2, $thn2 );
        $vld[] = cekvaliditastanggal( "Tanggal Akhir Berlaku S.K", $tgl3, $bln3, $thn3 );
        $vld[] = cekvaliditasinteger( "Tenaga Administrasi Pria Pendidikan", $tenagap1 );
        $vld[] = cekvaliditasinteger( "Tenaga Administrasi Wanita Pendidikan <= D-3", $tenagap2 );
        $vld[] = cekvaliditasinteger( "Tenaga Administrasi Pria Pendidikan = S-1", $tenagap3 );
        $vld[] = cekvaliditasinteger( "Tenaga Administrasi Wanita Pendidikan = S-1", $tenagap4 );
        $vld[] = cekvaliditasinteger( "Tenaga Administrasi Pria Pendidikan > S-1", $tenagap5 );
        $vld[] = cekvaliditasinteger( "Tenaga Administrasi Wanita Pendidikan = S-1", $tenagap6 );
        $vld[] = cekvaliditasinteger( "Tenaga Pustakawan Pria Pendidikan <= D-3", $tenagau1 );
        $vld[] = cekvaliditasinteger( "Tenaga Pustakawan Wanita Pendidikan <= D-3", $tenagau2 );
        $vld[] = cekvaliditasinteger( "Tenaga Pustakawan Pria Pendidikan = S-1", $tenagau3 );
        $vld[] = cekvaliditasinteger( "Tenaga Pustakawan Wanita Pendidikan = S-1", $tenagau4 );
        $vld[] = cekvaliditasinteger( "Tenaga Pustakawan Pria Pendidikan = S-1", $tenagau5 );
        $vld[] = cekvaliditasinteger( "Tenaga Pustakawan Wanita Pendidikan = S-1", $tenagau6 );
        $vld[] = cekvaliditasinteger( "Tenaga Laboran Pria Pendidikan <= D-3", $tenagal1 );
        $vld[] = cekvaliditasinteger( "Tenaga Laboran Wanita Pendidikan <= D-3", $tenagal2 );
        $vld[] = cekvaliditasinteger( "Tenaga Laboran Pria Pendidikan = S-1", $tenagal3 );
        $vld[] = cekvaliditasinteger( "Tenaga Laboran Wanita Pendidikan = S-1", $tenagal4 );
        $vld[] = cekvaliditasinteger( "Tenaga Laboran Pria Pendidikan > S-1", $tenagal5 );
        $vld[] = cekvaliditasinteger( "Tenaga Laboran Wanita Pendidikan > S-1", $tenagal6 );
        $vld[] = cekvaliditasinteger( "Tenaga Teknisi Pria Pendidikan <= D-3", $tenagat1 );
        $vld[] = cekvaliditasinteger( "Tenaga Teknisi Wanita Pendidikan <= D-3", $tenagat2 );
        $vld[] = cekvaliditasinteger( "Tenaga Teknisi Pria Pendidikan = S-1", $tenagat3 );
        $vld[] = cekvaliditasinteger( "Tenaga Teknisi Wanita Pendidikan = S-1", $tenagat4 );
        $vld[] = cekvaliditasinteger( "Tenaga Teknisi Pria Pendidikan > S-1", $tenagat5 );
        $vld[] = cekvaliditasinteger( "Tenaga Teknisi Wanita Pendidikan > S-1", $tenagat6 );
        $vld = array_filter( $vld, "filter_not_empty" );
        if ( isset( $vld ) && 0 < count( $vld ) )
        {
            $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
            unset( $vld );
        }
        else
        {
            $q = "INSERT INTO trpim \r\n  (THSMSTRPIM,KDPTITRPIM ,\r\n  NMKTYTRPIM,NMSEYTRPIM,  NMBHYTRPIM, \r\n  NORETTRPIM, NOR1TTRPIM,NOR2TTRPIM,NOR3TTRPIM,NOR4TTRPIM,NOR5TTRPIM,\r\n  NOMYSTRPIM,\r\n   TGYS1TRPIM,TGYS2TRPIM,\r\n   NOMPTTRPIM, TGPT1TRPIM,  TGPT2TRPIM,  \r\n      \r\n      ADMLATRPIM ,ADMPATRPIM ,ADMLBTRPIM ,ADMPBTRPIM , ADMLCTRPIM ,ADMPCTRPIM ,\r\n      PUSLATRPIM ,PUSPATRPIM ,PUSLBTRPIM ,PUSPBTRPIM ,PUSLCTRPIM , PUSPCTRPIM ,\r\n      LABLATRPIM ,LABPATRPIM ,LABLBTRPIM, LABPBTRPIM ,LABLCTRPIM ,LABPCTRPIM ,\r\n      TEKLATRPIM , TEKPATRPIM ,TEKLBTRPIM ,TEKPBTRPIM ,TEKLCTRPIM ,TEKPCTRPIM     \r\n    )\r\n  VALUES\r\n  ('{$tahun}{$semester}','{$kodept}', \r\n  '{$nama1}','{$nama2}','{$nama3}','{$nidn1}','{$nidn2}','{$nidn3}','{$nidn4}','{$nidn5}','{$nidn6}',\r\n  '{$sk}',\r\n  \r\n  '{$thn1}-{$bln1}-{$tgl1}',\r\n  '{$thn2}-{$bln2}-{$tgl2}','{$sk2}',\r\n  '{$thn3}-{$bln3}-{$tgl3}','{$thn4}-{$bln4}-{$tgl4}',\r\n  '{$tenagap1}','{$tenagap2}','{$tenagap3}','{$tenagap4}','{$tenagap5}','{$tenagap6}',\r\n  '{$tenagau1}','{$tenagau2}','{$tenagau3}','{$tenagau4}','{$tenagau5}','{$tenagau6}',\r\n  '{$tenagal1}', '{$tenagal2}','{$tenagal3}' ,'{$tenagal4}','{$tenagal5}','{$tenagal6}',\r\n  '{$tenagat1}','{$tenagat2}','{$tenagat3}','{$tenagat4}','{$tenagat5}','{$tenagat6}'\r\n  )";
            mysqli_query($koneksi,$q);
            if ( sqlaffectedrows( $koneksi ) <= 0 )
            {
                $q = "\r\n      UPDATE trpim SET\r\n      NMKTYTRPIM='{$nama1}',\r\n      NMSEYTRPIM='{$nama2}',\r\n      NMBHYTRPIM='{$nama3}',\r\n      NORETTRPIM='{$nidn1}',\r\n      NOR1TTRPIM='{$nidn2}',\r\n      NOR2TTRPIM='{$nidn3}',\r\n      NOR3TTRPIM='{$nidn4}',\r\n      NOR4TTRPIM='{$nidn5}',\r\n      NOR5TTRPIM='{$nidn6}',\r\n      NOMYSTRPIM='{$sk}',\r\n      \r\n      TGYS1TRPIM='{$thn1}-{$bln1}-{$tgl1}',\r\n      TGYS2TRPIM='{$thn2}-{$bln2}-{$tgl2}',\r\n      NOMPTTRPIM='{$sk2}',\r\n      TGPT1TRPIM='{$thn3}-{$bln3}-{$tgl3}',\r\n      TGPT2TRPIM='{$thn4}-{$bln4}-{$tgl4}',\r\n      \r\n      ADMLATRPIM='{$tenagap1}' ,\r\n      ADMPATRPIM='{$tenagap2}' ,\r\n      ADMLBTRPIM='{$tenagap3}' ,\r\n      ADMPBTRPIM='{$tenagap4}' ,\r\n      ADMLCTRPIM='{$tenagap5}' ,\r\n      ADMPCTRPIM='{$tenagap6}' ,\r\n      PUSLATRPIM='{$tenagau1}' ,\r\n      PUSPATRPIM='{$tenagau2}' ,\r\n      PUSLBTRPIM='{$tenagau3}' ,\r\n      PUSPBTRPIM='{$tenagau4}' ,\r\n      PUSLCTRPIM='{$tenagau5}' ,\r\n      PUSPCTRPIM='{$tenagau6}' ,\r\n      LABLATRPIM='{$tenagal1}' ,\r\n      LABPATRPIM='{$tenagal2}' ,\r\n      LABLBTRPIM='{$tenagal3}' ,\r\n      LABPBTRPIM='{$tenagal4}' ,\r\n      LABLCTRPIM='{$tenagal5}' ,\r\n      LABPCTRPIM='{$tenagal6}' ,\r\n      TEKLATRPIM='{$tenagat1}' ,\r\n      TEKPATRPIM='{$tenagat2}' ,\r\n      TEKLBTRPIM='{$tenagat3}' ,\r\n      TEKPBTRPIM='{$tenagat4}' ,\r\n      TEKLCTRPIM='{$tenagat5}' ,\r\n      TEKPCTRPIM='{$tenagat6}'  \r\n\r\n      WHERE\r\n       KDPTITRPIM='{$kodept}' AND \r\n        THSMSTRPIM='{$tahun}{$semester}'\r\n    ";
                mysqli_query($koneksi,$q);
            }
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $errmesg = "Data Pimpinan dan Tenaga Non-Akademik berhasil disimpan";
            }
        }
    }
}
$q = "SELECT  KDPTIMSPTI FROM mspti  LIMIT 0,1";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $kodept = $d[KDPTIMSPTI];
}
$q = "SELECT * FROM trpim  \r\nWHERE\r\n KDPTITRPIM='{$kodept}'  AND\r\n      THSMSTRPIM='{$tahun}{$semester}'\r\n";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $ada = 1;
}
if ( sqlnumrows( $h ) <= 0 && $copy == 1 )
{
    $q = "SELECT * FROM trpim  \r\n    WHERE\r\n     KDPTITRPIM='{$kodept}'  ORDER BY THSMSTRPIM DESC LIMIT 0,1\r\n    ";
    $h = mysqli_query($koneksi,$q);
}
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $tmp = explode( "-", $d[TGYS1TRPIM] );
    $thn1 = $tmp[0];
    $bln1 = $tmp[1];
    $tgl1 = $tmp[2];
    $tmp = explode( "-", $d[TGYS2TRPIM] );
    $thn2 = $tmp[0];
    $bln2 = $tmp[1];
    $tgl2 = $tmp[2];
    $tmp = explode( "-", $d[TGPT1TRPIM] );
    $thn3 = $tmp[0];
    $bln3 = $tmp[1];
    $tgl3 = $tmp[2];
    $tmp = explode( "-", $d[TGPT2TRPIM] );
    $thn4 = $tmp[0];
    $bln4 = $tmp[1];
    $tgl4 = $tmp[2];
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
echo "\r\n<form action=index.php method=post>\r\n<input type=hidden name=pilihan value='{$pilihan}'>\r\n<input type=hidden name=idprodi value='{$idprodi}'>\r\n<input type=hidden name=kodept value='{$kodept}'>\r\n<input type=hidden name=tahun value='{$tahun}'>\r\n<input type=hidden name=semester value='{$semester}'>\r\n<input type=hidden name=sessid value='{$_SESSION['token']}'>\r\n\r\n<table class=form>\r\n  <tr>\r\n    <td >Tahun Semester Pelaporan Data   </td>\r\n    <td>".$arraysemester[$semester]." {$tahun}/".( $tahun + 1 )."</td>\r\n  </tr>\r\n \r\n  <tr>\r\n    <td >Ketua Yayasan</td>\r\n    <td>\r\n    <input type=text size=40 name=nama1 value='{$d['NMKTYTRPIM']}'> \r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Sekretaris Yayasan</td>\r\n    <td> <input type=text size=40 name=nama2 value='{$d['NMSEYTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Bendahara Yayasan</td>\r\n    <td> <input type=text size=40 name=nama3 value='{$d['NMBHYTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >NIDN Rektor/Direktur/Ketua</td>\r\n    <td> <input type=text size=10 name=nidn1 value='{$d['NORETTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >NIDN Pembantu/Wakil I</td>\r\n    <td> <input type=text size=10 name=nidn2 value='{$d['NOR1TTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >NIDN Pembantu/Wakil II</td>\r\n    <td> <input type=text size=10 name=nidn3 value='{$d['NOR2TTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >NIDN Pembantu/Wakil III</td>\r\n    <td> <input type=text size=10 name=nidn4 value='{$d['NOR3TTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >NIDN Pembantu/Wakil IV</td>\r\n    <td> <input type=text size=10 name=nidn5 value='{$d['NOR4TTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >NIDN Pembantu/Wakil V</td>\r\n    <td> <input type=text size=10 name=nidn6 value='{$d['NOR5TTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Nomor S.K. Pengurus Harian Yayasan</td>\r\n    <td> <input type=text size=30 name=sk value='{$d['NOMYSTRPIM']}'> </td>\r\n  </tr>\r\n   <tr>\r\n    <td nowrap>Tanggal S.K.</td>\r\n    <td>\r\n    <input type=text size=2 name=tgl1 value='{$tgl1}'>-\r\n    <input type=text size=2 name=bln1 value='{$bln1}'>-\r\n    <input type=text size=4 name=thn1 value='{$thn1}'>\r\n    </td>\r\n  </tr>\r\n   <tr>\r\n    <td nowrap>Tanggal Akhir Berlaku S.K.</td>\r\n    <td>\r\n    <input type=text size=2 name=tgl2 value='{$tgl2}'>-\r\n    <input type=text size=2 name=bln2 value='{$bln2}'>-\r\n    <input type=text size=4 name=thn2 value='{$thn2}'>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Nomor S.K. Rektor/Ketua/Direktur</td>\r\n    <td> <input type=text size=30 name=sk2 value='{$d['NOMPTTRPIM']}'> </td>\r\n  </tr>\r\n\r\n   <tr>\r\n    <td nowrap>Tanggal S.K.</td>\r\n    <td>\r\n    <input type=text size=2 name=tgl3 value='{$tgl3}'>-\r\n    <input type=text size=2 name=bln3 value='{$bln3}'>-\r\n    <input type=text size=4 name=thn3 value='{$thn3}'>\r\n    </td>\r\n  </tr>\r\n   <tr>\r\n    <td nowrap>Akhir Berlaku S.K.</td>\r\n    <td>\r\n    <input type=text size=2 name=tgl4 value='{$tgl4}'>-\r\n    <input type=text size=2 name=bln4 value='{$bln4}'>-\r\n    <input type=text size=4 name=thn4 value='{$thn4}'>\r\n    </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Administrasi Pria Pendidikan <= D-3</td>\r\n    <td> <input type=text size=10 name=tenagap1 value='{$d['ADMLATRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Administrasi Wanita Pendidikan <= D-3</td>\r\n    <td> <input type=text size=10 name=tenagap2 value='{$d['ADMPATRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Administrasi Pria Pendidikan = S-1</td>\r\n    <td> <input type=text size=10 name=tenagap3 value='{$d['ADMLBTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Administrasi Wanita Pendidikan = S-1</td>\r\n    <td> <input type=text size=10 name=tenagap4 value='{$d['ADMPBTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Administrasi Pria Pendidikan > S-1</td>\r\n    <td> <input type=text size=10 name=tenagap5 value='{$d['ADMLCTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Administrasi Wanita Pendidikan > S-1</td>\r\n    <td> <input type=text size=10 name=tenagap6 value='{$d['ADMPCTRPIM']}'> </td>\r\n  </tr>\r\n \r\n  <tr>\r\n    <td >Tenaga Pustakawan Pria Pendidikan <= D-3</td>\r\n    <td> <input type=text size=10 name=tenagau1 value='{$d['PUSLATRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Pustakawan Wanita Pendidikan <= D-3</td>\r\n    <td> <input type=text size=10 name=tenagau2 value='{$d['PUSPATRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Pustakawan Pria Pendidikan = S-1</td>\r\n    <td> <input type=text size=10 name=tenagau3 value='{$d['PUSLBTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Pustakawan Wanita Pendidikan = S-1</td>\r\n    <td> <input type=text size=10 name=tenagau4 value='{$d['PUSPBTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Pustakawan Pria Pendidikan > S-1</td>\r\n    <td> <input type=text size=10 name=tenagau5 value='{$d['PUSLCTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Pustakawan Wanita Pendidikan > S-1</td>\r\n    <td> <input type=text size=10 name=tenagau6 value='{$d['PUSPCTRPIM']}'> </td>\r\n  </tr>\r\n\r\n  <tr>\r\n    <td >Tenaga Laboran Pria Pendidikan <= D-3</td>\r\n    <td> <input type=text size=10 name=tenagal1 value='{$d['LABLATRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Laboran Wanita Pendidikan <= D-3</td>\r\n    <td> <input type=text size=10 name=tenagal2 value='{$d['LABPATRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Laboran Pria Pendidikan = S-1</td>\r\n    <td> <input type=text size=10 name=tenagal3 value='{$d['LABLBTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Laboran Wanita Pendidikan = S-1</td>\r\n    <td> <input type=text size=10 name=tenagal4 value='{$d['LABPBTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Laboran Pria Pendidikan > S-1</td>\r\n    <td> <input type=text size=10 name=tenagal5 value='{$d['LABLCTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Laboran Wanita Pendidikan > S-1</td>\r\n    <td> <input type=text size=10 name=tenagal6 value='{$d['LABPCTRPIM']}'> </td>\r\n  </tr>\r\n \r\n\r\n  <tr>\r\n    <td >Tenaga Teknisi Pria Pendidikan <= D-3</td>\r\n    <td> <input type=text size=10 name=tenagat1 value='{$d['TEKLATRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Teknisi Wanita Pendidikan <= D-3</td>\r\n    <td> <input type=text size=10 name=tenagat2 value='{$d['TEKPATRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Teknisi Pria Pendidikan = S-1</td>\r\n    <td> <input type=text size=10 name=tenagat3 value='{$d['TEKLBTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Teknisi Wanita Pendidikan = S-1</td>\r\n    <td> <input type=text size=10 name=tenagat4 value='{$d['TEKPBTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Teknisi Pria Pendidikan > S-1</td>\r\n    <td> <input type=text size=10 name=tenagat5 value='{$d['TEKLCTRPIM']}'> </td>\r\n  </tr>\r\n  <tr>\r\n    <td >Tenaga Teknisi Wanita Pendidikan > S-1</td>\r\n    <td> <input type=text size=10 name=tenagat6 value='{$d['TEKPCTRPIM']}'> </td>\r\n  </tr>\r\n\r\n\r\n \r\n  <tr>\r\n    <td ></td>\r\n    <td>\r\n    ".IKONUPDATE48."\r\n    <input type=submit value=Simpan name=aksi>\r\n     <input type=reset value=Reset  >\r\n     </form>\r\n    </td> \r\n  </tr>\r\n</table>";
if ( $ada == 1 )
{
    echo "\r\n  <form action=cetakpimpinan.php target=_blank method=post>\r\n    ".IKONCETAK32."\r\n    <input type=submit name=aksi value=Cetak>\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n    <input type=hidden name=idprodi value='{$idprodi}'>\r\n    <input type=hidden name=kodept value='{$kodept}'>\r\n    <input type=hidden name=kodeps value='{$kodeps}'>\r\n    <input type=hidden name=kodejenjang value='{$kodejenjang}'>\r\n    <input type=hidden name=tahun value='{$tahun}'>\r\n    <input type=hidden name=semester value='{$semester}'>\r\n  </form>\r\n  ";
}
?>
