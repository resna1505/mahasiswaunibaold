<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

if ( $aksi2 == "formupdate" )
{
    $q = "SELECT * FROM msphs WHERE NIMHSMSPHS='{$idupdate}' AND NORUTMSPHS='{$urutan}'";
    $h2 = mysqli_query($koneksi,$q);
    if ( 0 < sqlnumrows( $h2 ) )
    {
        $d2 = sqlfetcharray( $h2 );
    }
    $tmp = explode( "-", $d2[TGIJAMSPHS] );
    $dtk[thn] = $tmp[0];
    $dtk[tgl] = $tmp[2];
    $dtk[bln] = $tmp[1];
}
echo "\r\n  \r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td width=100>Jenjang Studi</td>\r\n\t\t\t\t<td>".createinputselect( "strata", $arraypendidikantertinggi, "{$d2['JENJAMSPHS']}", " class=masukan  " )."</td>\r\n\t\t\t</tr>  \t\t\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >Gelar Akademik</td>\r\n\t\t\t\t<td>".createinputtext( "gelar", $d2[GELARMSPHS], " class=masukan  size=10" )."</td>\r\n\t\t\t</tr>  \t\t\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >Kode PT</td>\r\n\t\t\t\t<td>".createinputtext( "kodept", $d2[ASPTIMSPHS], " class=masukan  size=10" )."\r\n\r\n\t\t\t<a \r\n\t\t\thref=\"javascript:daftarpt('form,wewenang,kodept',\r\n\t\t\tdocument.form.kodept.value)\" >\r\n\t\t\tdaftar PT\r\n\t\t\t</a>\r\n \t\t\t\t</td>\r\n\t\t\t</tr>  \t\t\r\n\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >Nama PT</td>\r\n\t\t\t\t<td>".createinputtext( "namapt", $d2[NMPTIMSPHS], " class=masukan  size=50" )."</td>\r\n\t\t\t</tr>  \t\t\r\n\t\t\t\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >Bidang Ilmu</td>\r\n\t\t\t\t<td>".createinputtext( "bidangilmu", $d2[BIDILMSPHS], " class=masukan  size=40" )."</td>\r\n\t\t\t</tr>  \t\t\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >Kota Asal</td>\r\n\t\t\t\t<td>".createinputtext( "kotaasal", $d2[KOTAAMSPHS], " class=masukan  size=20" )."</td>\r\n\t\t\t</tr>  \t\t\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >Kode Negara</td>\r\n\t\t\t\t<td>".createinputtext( "kodenegara", $d2[KDNEGMSPHS], " class=masukan  size=4" )."\r\n \t\t\t<a \r\n\t\t\thref=\"javascript:daftarprop('form,wewenang,kodenegara',\r\n\t\t\tdocument.form.kodenegara.value)\" >\r\n\t\t\tdaftar Propinsi/Negara\r\n\t\t\t</a>        \r\n        </td>\r\n\t\t\t</tr>  \t\t\r\n\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >Tanggal Ijazah</td>\r\n\t\t\t\t<td>".createinputtanggal( "data", $dtk, " class=masukan" )."</td>\r\n\t\t\t</tr>  \t\t\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >Total SKS Lulus</td>\r\n\t\t\t\t<td>".createinputtext( "sks", $d2[SKSTTMSPHS], " class=masukan  size=3" )."</td>\r\n\t\t\t</tr>  \t\t\r\n\t\t\t<tr class=judulform>\r\n\t\t\t\t<td  >IPK Lulus</td>\r\n\t\t\t\t<td>".createinputtext( "ipk", $d2[NLIPKMSPHS], " class=masukan  size=3" )."</td>\r\n\t\t\t</tr>  \t\t\r\n    \t\r\n \t\t<tr class=judulform>\r\n\t\t\t<td colspan=2><hr></td>\r\n\t\t</tr>\r\n \r\n \r\n\t\t";
?>
