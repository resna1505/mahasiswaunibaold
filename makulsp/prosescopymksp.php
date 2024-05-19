<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $_POST['sessid'] != $_SESSION['token'] )
{
    $errmesg = token_err_mesg( "Kurikulum SP", SIMPAN_DATA );
}
else
{
    $vld[] = cekvaliditasthnajaran( "Dari Semester", $tahun, $semester );
    $vld[] = cekvaliditasthnajaran( "Semester Tujuan", $tahun2, $semester2 );
    $vld = array_filter( $vld, "filter_not_empty" );
    if ( isset( $vld ) && 0 < count( $vld ) )
    {
        $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
    }
    else
    {
	$tahun=$tahun-1;
	$tahun2=$tahun2-1;
        $q = "SELECT * FROM tbkmksp WHERE THSMSTBKMK='{$tahun}{$semester}'";
        #echo $q;
		$h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $tmp = "\r\n            <table class=form>\r\n              <tr class=juduldata align=center >\r\n                <td>Kode Mata Kuliah</td>\r\n                <td>Nama Mata Kuliah</td>\r\n                <td>Kode Prodi</td>\r\n                <td>Jenjang</td>\r\n                <td>Semester Asal</td>\r\n                <td>Semester Tujuan</td>\r\n                <td>Status Penyalinan</td>\r\n              </tr>\r\n          ";
            while ( $d = sqlfetcharray( $h ) )
            {
                $q = "\r\n              INSERT INTO tbkmksp \r\n              (THSMSTBKMK ,KDPTITBKMK ,KDPSTTBKMK ,KDJENTBKMK,KDKMKTBKMK ,NAKMKTBKMK ,\r\n            SKSMKTBKMK ,SKSTMTBKMK ,SKSPRTBKMK ,SKSLPTBKMK ,SEMESTBKMK ,\r\n            KDKELTBKMK ,KDKURTBKMK ,KDWPLTBKMK ,NODOSTBKMK ,JENJATBKMK ,\r\n            PRODITBKMK ,STKMKTBKMK ,SLBUSTBKMK ,SAPPPTBKMK ,BHNAJTBKMK ,\r\n            DIKTTTBKMK,KELOMPOKKURIKULUM,NAMA2)\r\n              VALUES\r\n              ('{$tahun2}{$semester2}' ,'{$d['KDPTITBKMK']}'  ,'{$d['KDPSTTBKMK']}'  ,'{$d['KDJENTBKMK']}' ,\r\n              '{$d['KDKMKTBKMK']}' ,'{$d['NAKMKTBKMK']}' ,'{$d['SKSMKTBKMK']}'  ,'{$d['SKSTMTBKMK']}'  ,\r\n              '{$d['SKSPRTBKMK']}','{$d['SKSLPTBKMK']}', '{$d['SEMESTBKMK']}','{$d['KDKELTBKMK']}',\r\n              '{$d['KDKURTBKMK']}'  ,'{$d['KDWPLTBKMK']}'  ,'{$d['NODOSTBKMK']}'  ,'{$d['JENJATBKMK']}'  ,\r\n            '{$d['PRODITBKMK']}'  ,'{$d['STKMKTBKMK']}'  ,'{$d['SLBUSTBKMK']}'  ,'{$d['SAPPPTBKMK']}'  ,\r\n            '{$d['BHNAJTBKMK']}'  , '{$d['DIKTTTBKMK']}','{$d['KELOMPOKKURIKULUM']}','{$d['NAMA2']}' )\r\n            ";
                mysqli_query($koneksi,$q);
                $ok = "Gagal";
                if ( 0 < sqlaffectedrows( $koneksi ) )
                {
                    $ok = "OK";
                }
                $tmp .= "\r\n            <tr align=center>\r\n                <td>{$d['KDKMKTBKMK']}</td>\r\n                <td align=left>{$d['NAKMKTBKMK']}</td>\r\n                <td>{$d['KDPSTTBKMK']}</td>\r\n                <td>".$arrayjenjang[$d[KDJENTBKMK]]."</td>\r\n                <td>".$arraysemester[$semester]." {$tahun}</td>\r\n                <td>".$arraysemester[$semester2]." {$tahun2}</td>\r\n                <td>{$ok}</td>\r\n            </tr>";
            }
            $tmp .= "</table>";
            printjudulmenukecil( "<b>Daftar Mata Kuliah Semester Pendek yang disalin" );
            echo $tmp;
	    $tahun = $tahun + 1;
            $tahun2 = $tahun2 + 1;
	
        }
        else
        {
            printjudulmenukecil( "<b>Tidak ada data mata kuliah yang disalin" );
        }
    }
}
?>
