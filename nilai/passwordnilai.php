<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

printjudulmenu( "Edit Data Nilai" );
printmesg( "{$errmesg}" );
echo "\r\n<form action=fpasswordnilai.php method=post>".createinputhidden( "pilihan", $pilihan, "" ).createinputhidden( "aksi", "tambah", "" ).createinputhidden( "idmakulupdate", "{$idmakulupdate}", "" ).createinputhidden( "iddosenupdate", "{$iddosenupdate}", "" ).createinputhidden( "idprodiupdate", "{$idprodiupdate}", "" ).createinputhidden( "tahunupdate", "{$tahunupdate}", "" ).createinputhidden( "kelasupdate", "{$kelasupdate}", "" ).createinputhidden( "id", "{$id}", "" ).createinputhidden( "semesterupdate", "{$semesterupdate}", "" )."\r\n\r\n      Silakan masukkan ID dan password Supervisor sebelum melanjutkan pengubahan nilai\r\n<br>\r\n<br>  <table class=form>\r\n     <tr>\r\n      <td width=150>ID Supervisor</td>\r\n      <td><input type=text size=20 name=idsp></td>\r\n    </tr>\r\n    <tr>\r\n      <td>Password Supervisor</td>\r\n      <td><input type=password size=20 name=passwordsp></td>\r\n    </tr>\r\n    <tr>\r\n      <td></td>\r\n      <td><input type=submit name=aksi2 value='Submit'></td>\r\n    </tr>\r\n  </table>\r\n</form>\r\n";
?>
