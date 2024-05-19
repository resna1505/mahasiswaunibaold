<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
cekhaktulis( $kodemenu );
printjudulmenu( "Salin Data Semester" );
if ( $aksi == "Salin Data!" )
{
    if ( $_POST['sessid'] != $_SESSION['token'] )
    {
        $errmesg = token_err_mesg( "Salin Data Semester", SIMPAN_DATA );
        unset( $_SESSION['token'] );
    }
    else if ( isset( $vld ) && 0 < count( $vld ) )
    {
        $errmesg = val_err_mesg( $vld, 2, SIMPAN_DATA );
        unset( $vld );
    }
    else
    {
        $q = "SELECT KDYYSMSYYS ,NMYYSMSYYS  FROM msyys LIMIT 0,1";
        $h = mysqli_query($koneksi,$q);
        if ( 0 < sqlnumrows( $h ) )
        {
            $d = sqlfetcharray( $h );
            $kodebh = $d[KDYYSMSYYS];
            $namabh = $d[NMYYSMSYYS];
        }
        if ( $idprodi != "" )
        {
            $q = "SELECT KDPTIMSPST ,KDJENMSPST,KDPSTMSPST FROM mspst WHERE IDX='{$idprodi}'";
            $h = mysqli_query($koneksi,$q);
            if ( 0 < sqlnumrows( $h ) )
            {
                $d = sqlfetcharray( $h );
                $kodept = $d[KDPTIMSPST];
                $kodejenjang = $d[KDJENMSPST];
                $kodeps = $d[KDPSTMSPST];
            }
        }
        if ( $mk == 1 )
        {
            include( "prosescopymk.php" );
        }
        if ( !( $ds == 1 ) || $ms == 1 )
        {
            include( "prosescopyms.php" );
        }
        if ( $bb == 1 )
        {
            include( "prosescopybb.php" );
        }
        if ( $mb == 1 )
        {
            include( "prosescopymb.php" );
        }
        if ( $np == 1 )
        {
            include( "prosescopynp.php" );
        }
        if ( $fa == 1 )
        {
            include( "prosescopyfa.php" );
        }
        if ( $fp == 1 )
        {
            include( "prosescopyfp.php" );
        }
        $aksi = "";
        echo "<hr>";
    }
}
$token = md5( uniqid( rand( ), TRUE ) );
$_SESSION['token'] = $token;
printmesg( $errmesg );
if ( $aksi == "" )
{
    echo "\r\n  <form action=index.php method=post\r\n  onSubmit='return confirm(\"Salin data?\")'\r\n  >\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n\t<input type=hidden name=sessid value='{$_SESSION['token']}'>\r\n\t".IKONTOOLS48."\r\n    <table>\r\n      <tr>\r\n        <td>Salin data dari Semester</td>\r\n        <td>\r\n\t\t\t\t\t\t<select name=semester class=masukan> \r\n\t\t\t\t\t\t ";
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
    echo "\r\n\t\t\t\t\t\t</select> \r\n\r\n            \r\n        </td>\r\n      </tr>    \r\n  \t\t\t<tr>\t\r\n\t\t\t\t<td>\r\n\t\t\t\t\tJurusan/Program Studi\r\n\t\t\t\t</td>\r\n\t\t\t\t<td> \r\n\t\t\t\t\t<select class=masukan name=idprodi>\r\n\t\t\t\t\t\t ";
    if ( $_SESSION[prodis] == "" )
    {
        echo "<option value=''>Semua</option>";
    }
    foreach ( $arrayprodidep as $k => $v )
    {
        echo "<option value='{$k}'>{$v}</option>";
    }
    echo "\r\n\t\t\t\t\t</select>\r\n\t\t\t\t</td>\r\n\t\t\t</tr>\r\n      <tr>\r\n        <td colspan=2>\r\n          <hr>\r\n        </td>\r\n      </tr>  \r\n      <tr valign=top>\r\n        <td width=200>Data yang disalin</td>\r\n        <td>\r\n        <input type=checkbox name=mk value=1  > Mata Kuliah / Kurikulum <br>\r\n<!--        <input type=checkbox name=ds value=1  > Dosen Keluar/Cuti/Studi Lanjut <br> -->\r\n        <input type=checkbox name=ms value=1  > Mahasiswa Lulus/Cuti/Non-aktif/Keluar/DO<br>\r\n        <input type=checkbox name=bb value=1  > Bobot Nilai  <br>\r\n        <input type=checkbox name=mb value=1  > Kapasitas Mahasiswa Baru  <br>\r\n        <input type=checkbox name=np value=1  > Nama Pimpinan dan Tenaga Non-akademik <br>\r\n        <input type=checkbox name=fa value=1  > Fasilitas perguruan Tinggi <br>\r\n        <input type=checkbox name=fp value=1  > Sarana dan Prasarana <br>\r\n  \r\n\r\n  <br>\r\n        </td>\r\n      </tr>\r\n      <tr>\r\n        <td colspan=2>\r\n          <hr>\r\n        </td>\r\n      </tr>  \r\n      <tr>\r\n        <td></td>\r\n         <td>\r\n         <input type=submit name=aksi value='Salin Data!'> \r\n        </td>\r\n      </tr>\r\n    </table>\r\n  </form>\r\n";
}
?>
