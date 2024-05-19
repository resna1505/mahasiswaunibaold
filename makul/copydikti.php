<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenu( "Salin Data Pelaporan Mata Kuliah Per Semester" );
if ( $aksi == "Salin Data!" )
{
    $q = "SELECT * FROM tbkmk WHERE THSMSTBKMK='{$tahun}{$semester}'";
    $h = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h ) )
    {
        $tmp = "\r\n        <table class=data>\r\n          <tr class=juduldata align=center >\r\n            <td>Kode Mata Kuliah</td>\r\n            <td>Nama Mata Kuliah</td>\r\n            <td>Kode Prodi</td>\r\n            <td>Jenjang</td>\r\n            <td>Semester Asal</td>\r\n            <td>Semester Tujuan</td>\r\n            <td>Status Penyalinan</td>\r\n          </tr>\r\n      ";
        while ( $d = sqlfetcharray( $h ) )
        {
            $q = "\r\n          INSERT INTO tbkmk \r\n          (THSMSTBKMK ,KDPTITBKMK ,KDPSTTBKMK ,KDJENTBKMK,KDKMKTBKMK ,NAKMKTBKMK ,\r\n        SKSMKTBKMK ,SKSTMTBKMK ,SKSPRTBKMK ,SKSLPTBKMK ,SEMESTBKMK ,\r\n        KDKELTBKMK ,KDKURTBKMK ,KDWPLTBKMK ,NODOSTBKMK ,JENJATBKMK ,\r\n        PRODITBKMK ,STKMKTBKMK ,SLBUSTBKMK ,SAPPPTBKMK ,BHNAJTBKMK ,\r\n        DIKTTTBKMK)\r\n          VALUES\r\n          ('{$tahun2}{$semester2}' ,'{$d['KDPTITBKMK']}'  ,'{$d['KDPSTTBKMK']}'  ,'{$d['KDJENTBKMK']}' ,\r\n          '{$d['KDKMKTBKMK']}' ,'{$d['NAKMKTBKMK']}' ,'{$d['SKSMKTBKMK']}'  ,'{$d['SKSTMTBKMK']}'  ,\r\n          '{$d['SKSPRTBKMK']}','{$d['SKSLPTBKMK']}', '{$d['SEMESTBKMK']}','{$d['KDKELTBKMK']}',\r\n          '{$d['KDKURTBKMK']}'  ,'{$d['KDWPLTBKMK']}'  ,'{$d['NODOSTBKMK']}'  ,'{$d['JENJATBKMK']}'  ,\r\n        '{$d['PRODITBKMK']}'  ,'{$d['STKMKTBKMK']}'  ,'{$d['SLBUSTBKMK']}'  ,'{$d['SAPPPTBKMK']}'  ,\r\n        '{$d['BHNAJTBKMK']}'  , '{$d['DIKTTTBKMK']}' )\r\n        ";
            mysqli_query($koneksi,$q);
            $ok = "Gagal";
            if ( 0 < sqlaffectedrows( $koneksi ) )
            {
                $ok = "OK";
            }
            $tmp .= "\r\n        <tr align=center>\r\n            <td>{$d['KDKMKTBKMK']}</td>\r\n            <td align=left>{$d['NAKMKTBKMK']}</td>\r\n            <td>{$d['KDPSTTBKMK']}</td>\r\n            <td>".$arrayjenjang[$d[KDJENTBKMK]]."</td>\r\n            <td>".$arraysemester[$semester]." {$tahun}</td>\r\n            <td>".$arraysemester[$semester2]." {$tahun2}</td>\r\n            <td>{$ok}</td>\r\n        </tr>";
        }
        $tmp .= "</table>";
        printmesg( "Daftar Mata Kuliah yang disalin" );
        echo $tmp;
    }
    else
    {
        $errmesg = "Tidak ada data mata kuliah yang disalin";
        $aksi = "";
    }
}
printmesg( $errmesg );
if ( $aksi == "" )
{
    echo "\r\n  <form action=index.php method=post\r\n  onSubmit='return confirm(\"Salin data?\")'\r\n  >\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n    <table>\r\n      <tr>\r\n        <td>Salin data Mata Kuliah dari Semester</td>\r\n        <td>\r\n\t\t\t\t\t\t<select name=semester class=masukan> \r\n\t\t\t\t\t\t ";
    unset( $arraysemester[3] );
    foreach ( $arraysemester as $k => $v )
    {
        if ( $k == $semester )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
    }
    echo "\r\n\t\t\t\t\t\t</select>";
    $waktu = getdate( );
    if ( $tahun == "" )
    {
        $tahun = $waktu[year];
    }
    echo "\r\n\t\t\t\t\t\t<select name=tahun class=masukan> \r\n\t\t\t\t\t\t ";
    $selected = "";
    $i = 1901;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $i == $tahun )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select> \r\n\r\n            \r\n        </td>\r\n      </tr>\r\n      <tr>\r\n        <td>ke Semester</td>\r\n        <td>\r\n\t\t\t\t\t\t<select name=semester2 class=masukan> \r\n\t\t\t\t\t\t ";
    unset( $arraysemester[3] );
    foreach ( $arraysemester as $k => $v )
    {
        if ( $k == $semester2 )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$k}' {$selected}>{$v}</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
    }
    echo "\r\n\t\t\t\t\t\t</select>";
    $waktu = getdate( );
    if ( $tahun2 == "" )
    {
        $tahun2 = $waktu[year];
    }
    echo "\r\n\t\t\t\t\t\t<select name=tahun2 class=masukan> \r\n\t\t\t\t\t\t ";
    $selected = "";
    $i = 1901;
    while ( $i <= $waktu[year] + 5 )
    {
        if ( $i == $tahun2 )
        {
            $selected = "selected";
        }
        echo "\r\n\t\t\t\t\t\t\t<option value='{$i}'  {$selected}>".$i."/".( $i + 1 )."</option>\r\n\t\t\t\t\t\t\t";
        $selected = "";
        ++$i;
    }
    echo "\r\n\t\t\t\t\t\t</select> \r\n\r\n            \r\n        </td>\r\n      </tr>      \r\n      <tr>\r\n        <td></td>\r\n         <td>\r\n         <input type=submit name=aksi value='Salin Data!'> \r\n        </td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n";
}
?>
