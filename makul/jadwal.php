<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$idprodimakul = getfield( "IDX", "mspst", " WHERE KDPSTMSPST='{$prodiupdate}' AND KDJENMSPST='{$jenjangupdate}'" );
printjudulmenukecil( "<b>Jadwal Kuliah</b>" );
$thnsyarat = substr( $tahunsemester, 0, 4 );
$semsyarat = substr( $tahunsemester, 4, 1 );
if ( $aksi3 == "Simpan" )
{
    $q = "INSERT INTO jadwalkuliahkurikulum\r\n    (IDPRODI,IDMAKUL,KELAS,JAM,JAMSELESAI,TAHUN,SEMESTER,KUOTA,TERISI,UPDATER,LASTUPDATE,JENISKELAS,HARI,RUANGAN,DOSEN)\r\n    VALUES\r\n    ('{$idprodimakul}','{$idupdate}','{$kelas}','{$jammulai}','{$jamselesai}','".( $thnsyarat + 1 )."','{$semsyarat}','{$kuota}','{$terisi}','{$users}',NOW(),'{$jeniskelas}','{$hari}','{$ruangan}','{$dosen}')";
    mysqli_query($koneksi,$q);
    if ( sqlaffectedrows( $koneksi ) <= 0 )
    {
        if ( $jammulaiupdate == "" )
        {
            $jammulaiupdate = $jammulai;
        }
        if ( $kelasupdate == "" )
        {
            $kelasupdate = $kelas;
        }
        $q = "UPDATE jadwalkuliahkurikulum\r\n      SET\r\n      JENISKELAS='{$jeniskelas}',\r\n      KELAS='{$kelas}',\r\n      JAM='{$jammulai}' ,\r\n      JAMSELESAI='{$jamselesai}' ,\r\n      KUOTA='{$kuota}' ,\r\n      HARI='{$hari}' ,\r\n      RUANGAN='{$ruangan}' ,\r\n      DOSEN='{$dosen}' ,\r\n       UPDATER='{$updater}',\r\n      LASTUPDATE=NOW()\r\n      \r\n      WHERE\r\n      \r\n      IDMAKUL='{$idupdate}' AND\r\n      IDPRODI='{$idprodimakul}' AND\r\n      JAM='{$jammulai}' AND\r\n      KELAS='{$kelas}' AND\r\n      TAHUN='".( $thnsyarat + 1 )."' AND\r\n      SEMESTER='{$semsyarat}'\r\n      ";
        mysqli_query($koneksi,$q);
        if ( 0 < sqlaffectedrows( $koneksi ) )
        {
            printmesg( "Data Jadwal Kuliah berhasil disimpan" );
        }
    }
    else
    {
        printmesg( "Data Jadwal Kuliah berhasil disimpan" );
        $jamselesai = "";
        $kuota = "";
    }
}
if ( $aksi3 == "hapus" )
{
    $q = "DELETE FROM  jadwalkuliahkurikulum\r\n      WHERE\r\n      IDMAKUL='{$idupdate}' AND\r\n      IDPRODI='{$idprodimakul}' AND\r\n      JAM='{$jammulai}' AND\r\n      KELAS='{$kelas}' AND\r\n      TAHUN='".( $thnsyarat + 1 )."' AND\r\n      SEMESTER='{$semsyarat}'\r\n      ";
    mysqli_query($koneksi,$q);
}
echo "\r\n  \r\n    Prodi Penyelenggara : <b>".$arrayprodidep[$idprodimakul]."</b> <br>\r\n    Tahun Akademik : ".$arraysemester[$semsyarat]." <b>{$thnsyarat}/".( $thnsyarat + 1 )."</b>\r\n  <br><br>\r\n  <form name=form method=post action=index.php>\r\n    <input type=hidden name=pilihan value='{$pilihan}'>\r\n    <input type=hidden name=aksi value='{$aksi}'>\r\n    <input type=hidden name=tab value='{$tab}'>\r\n    <input type=hidden name=aksi2 value='{$aksi2}'>\r\n    <input type=hidden name=idupdate value='{$idupdate}'>\r\n    <input type=hidden name=prodiupdate value='{$prodiupdate}'>\r\n    <input type=hidden name=jenjangupdate value='{$jenjangupdate}'>\r\n    <input type=hidden name=tahunsemester value='{$tahunsemester}'>";
if ( $aksi3 == "update" )
{
    echo "\r\n        <input type=hidden name=kelasupdate value='{$kelasupdate}'>\r\n        <input type=hidden name=jammulaisupdate value='{$jammulaiupdate}'>\r\n      \r\n      ";
}
echo "\r\n \r\n\r\n  <table class=\"table table-striped table-bordered table-hover\">\r\n    <tr>\r\n      <td>Kode Kelas*\r\n      </td>\r\n      <td>\r\n              <select name='kelas' >\r\n             ";
$ik = 1;
while ( $ik < 100 )
{
    if ( $ik < 10 )
    {
        $idkelas = "0{$ik}";
    }
    else
    {
        $idkelas = "{$ik}";
    }
    $selected = "";
    if ( $idkelas == $kelasupdate )
    {
        $selected = "selected";
    }
    echo "<option value='{$idkelas}' {$selected} >{$idkelas}</option>";
    ++$ik;
}
echo "\r\n            </select>\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td width=150>Jenis Kelas</td>\r\n      <td> \r\n\t\t\t\t\t<select class=masukan name=jeniskelas>\r\n\t\t\t\t\t\t ";
$cek = "";
foreach ( $arraykelasstei as $k => $v )
{
    if ( $k == $jeniskelasupdate )
    {
        $cek = "selected";
    }
    echo "<option value='{$k}' {$cek}>{$v}</option>";
    $cek = "";
}
echo "\r\n\t\t\t\t\t</select>\r\n\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td >Jam Mulai*</td>\r\n      <td><input type=text name=jammulai size=8 value='{$jammulaiupdate}'> jj:mm:dd\r\n      \t\t\t\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td >Jam Selesai</td>\r\n      <td><input type=text name=jamselesai size=8 value='{$jamselesai}'> jj:mm:dd\r\n      \t\t\t\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td >Kuota</td>\r\n      <td><input type=text name=kuota size=2 value='{$kuota}'>\r\n      \t\t\t\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td >Dosen</td>\r\n      <td><textarea name=dosen cols=32 rows=3>{$dosen}</textarea>\r\n      \t\t\t\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td >Ruangan</td>\r\n      <td><input type=text name=ruangan size=40 value='{$ruangan}'>\r\n      \t\t\t\r\n      </td>\r\n    </tr>\r\n    <tr>\r\n      <td >Hari</td>\r\n      <td><textarea name=hari cols=32 rows=3>{$hari}</textarea>\r\n      \t\t\t\r\n      </td>\r\n    </tr>\r\n\r\n\r\n    <tr>\r\n      <td ></td>\r\n      <td><input type=submit   value='Simpan' name=aksi3>\r\n      \t\t\t\r\n      </td>\r\n    </tr>  </table>\r\n  </form>\r\n\r\n";
$q = "SELECT jadwalkuliahkurikulum.* ,makul.NAMA\r\nFROM jadwalkuliahkurikulum , makul\r\nWHERE\r\nmakul.ID=jadwalkuliahkurikulum.IDMAKUL \r\nAND\r\nIDMAKUL='{$idupdate}'\r\nAND jadwalkuliahkurikulum.TAHUN='".( $thnsyarat + 1 )."'\r\nAND jadwalkuliahkurikulum.SEMESTER='{$semsyarat}'\r\nAND jadwalkuliahkurikulum.IDPRODI='{$idprodimakul}'\r\nORDER BY KELAS,JAM\r\n\r\n";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    echo "\r\n  <br>\r\n  <table class=form>\r\n    <tr class=juduldata align=center>\r\n      <!--\r\n      <td>ID Mata Kuliah</td>\r\n      <td>Nama Mata Kuliah</td>\r\n      -->\r\n      <td>Kelas</td>\r\n      <td>Jenis Kelas</td>\r\n      <td>Jam Mulai</td>\r\n      <td>Jam Selesai</td>\r\n      <td>Hari</td>\r\n      <td>Dosen</td>\r\n      <td>Ruangan</td>\r\n      <td>Kuota</td>\r\n      <td>Update</td>    \r\n      <td>Hapus</td>    \r\n    </tr>\r\n  ";
    $i = 0;
    while ( $d = sqlfetcharray( $h ) )
    {
        ++$i;
        $kelas = kelas( $i );
        echo "\r\n    <tr {$kelas}>\r\n      <!--\r\n      <td>{$d['IDMAKUL']}</td>\r\n      <td>{$d['NAMA']}</td>\r\n      -->\r\n      <td align=center>{$d['KELAS']}</td>\r\n      <td align=center>".$arraykelasstei[$d[JENISKELAS]]."</td>\r\n      <td align=center>{$d['JAM']}</td>\r\n      <td align=center>{$d['JAMSELESAI']}</td>\r\n      <td align=center>{$d['HARI']}</td>\r\n      <td align=center>{$d['DOSEN']}</td>\r\n      <td align=center>{$d['RUANGAN']}</td>\r\n      <td align=center>{$d['KUOTA']}</td>\r\n      <td align=center>\r\n      <a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&aksi2={$aksi2}&idupdate={$idupdate}&prodiupdate={$prodiupdate}&jenjangupdate={$jenjangupdate}&idmakul={$d['IDSYARAT']}&tahunsemester={$tahunsemester}&aksi3=update&kelasupdate={$d['KELAS']}&jeniskelasupdate={$d['JENISKELAS']}&jammulaiupdate={$d['JAM']}&jamselesai={$d['JAMSELESAI']}&kuota={$d['KUOTA']}&hari={$d['HARI']}&ruangan={$d['RUANGAN']}&dosen={$d['DOSEN']}'>update</a>\r\n      \r\n      </td>\r\n\r\n      <td align=center>\r\n      <a href='index.php?pilihan={$pilihan}&aksi={$aksi}&tab={$tab}&aksi2={$aksi2}&idupdate={$idupdate}&prodiupdate={$prodiupdate}&jenjangupdate={$jenjangupdate}&idmakul={$d['IDSYARAT']}&tahunsemester={$tahunsemester}&aksi3=hapus&kelas={$d['KELAS']}&jammulai={$d['JAM']}'\r\n      onClick=\"return confirm('Hapus Jadwal Kuliah?')\">hapus</a>\r\n      \r\n      </td>\r\n    </tr>\r\n     ";
    }
    echo "</table></div></div></div>";
}
else
{
    printmesg( "Tidak ada jadwal dan kuota untuk mata kuliah ini." );
}
?>
