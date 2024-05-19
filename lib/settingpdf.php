<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

$root = "../";
include( $root."sesiuser.php" );
include( $root."header.php" );
periksaroot( );
$arrayukuranhalamanpdf['A4'] = "A4";
$arrayukuranhalamanpdf['Letter'] = "Letter";
$arrayukuranhalamanpdf['Legal'] = "Legal";
$arrayorientasipdf['P'] = "Potrait";
$arrayorientasipdf['L'] = "Landscape";
$q = "SELECT * FROM settingpdf WHERE ID=0";
$h = mysqli_query($koneksi,$q);
if ( 0 < sqlnumrows( $h ) )
{
    $d = sqlfetcharray( $h );
    $ukuran = $d[UKURAN];
    $orientasi = $d[ORIENTASI];
    $marginkiri = $d[MARGINKIRI];
    $marginkanan = $d[MARGINKIRI];
    $marginatas = $d[MARGINATAS];
    $marginbawah = $d[MARGINBAWAH];
}
echo "\r\n<script>\r\nfunction isInteger(value) {\r\n    if ((undefined === value) || (null === value)) {\r\n        return false;\r\n    }\r\n    return value % 1 == 0;\r\n}\r\n\r\n\r\n$('.error').hide();  \r\n$(function() {  \r\n $('.error').hide();  \r\n  $('.button').click(function() {  \r\n    // validate and process form here  \r\n\r\n      var ukuran = $(\"select#ukuran\").val();  \r\n      var orientasi = $(\"select#orientasi\").val();  \r\n      var marginkiri = $(\"input#marginkiri\").val();  \r\n      var marginkanan = $(\"input#marginkanan\").val();  \r\n      var marginatas = $(\"input#marginatas\").val();  \r\n      var marginbawah = $(\"input#marginbawah\").val();  \r\n\r\n      if (!isInteger(marginkiri) ) {  \r\n        alert('Margin kiri harus diisi bilangan bulat!');\r\n        return false;  \r\n      }   \r\n      if (!isInteger(marginkanan) ) {  \r\n        alert('Margin kanan harus diisi bilangan bulat!');\r\n        return false;  \r\n      }   \r\n      if (!isInteger(marginatas) ) {  \r\n        alert('Margin atas harus diisi bilangan bulat!');\r\n        return false;  \r\n      }   \r\n      if (!isInteger(marginbawah) ) {  \r\n        alert('Margin bawah harus diisi bilangan bulat!');\r\n        return false;  \r\n      }   \r\n    \r\nvar dataString = 'ukuran='+ ukuran + '&orientasi=' + orientasi + '&marginkiri=' + marginkiri + '&marginkanan=' + marginkanan + '&marginatas=' + marginatas + '&marginbawah=' + marginbawah ;  \r\n// alert(dataString);return false;  \r\n\r\n\r\n$.ajax({  \r\n  type: 'POST',  \r\n  url: '../lib/prosessettingpdf.php',  \r\n  data: dataString,  \r\n  success: function() {  \r\n    $('#formsetting').html(\"<div id='message'></div>\");  \r\n    $('#message').html(\"<h2 align=center>Setting PDF berhasil disimpan!</h2>\")  \r\n     \r\n    .hide()  \r\n    .fadeIn(500, function() {  \r\n      $('#message').append(\" \");  \r\n    });  \r\n  }  \r\n});  \r\nreturn false;  \r\n\r\n\r\n\r\n  });  \r\n});  \r\n\r\n\r\n\r\n\r\n</script>";
printjudulmenu( "SETTING CETAK PDF" );
echo "\r\n<div id='formsetting'>\r\n<form name='formsetting' action='' >\r\n    <table width=600>\r\n      <tr>\r\n        <td>Ukuran</td>\r\n        <td>\r\n        <select name=ukuran id=ukuran>\r\n          ";
foreach ( $arrayukuranhalamanpdf as $k => $v )
{
    $selected = "";
    if ( $k == $ukuran )
    {
        $selected = "selected";
    }
    echo "<option {$selected} value='{$k}'>{$v}</option>";
}
echo "\r\n        </select>\r\n        </td>\r\n      </tr>\r\n      <tr>\r\n        <td>Orientasi</td>\r\n        <td>\r\n        <select name=orientasi id=orientasi>\r\n          ";
foreach ( $arrayorientasipdf as $k => $v )
{
    $selected = "";
    if ( $k == $orientasi )
    {
        $selected = "selected";
    }
    echo "<option {$selected} value='{$k}'>{$v}</option>";
}
echo "\r\n        </select>\r\n        </td>\r\n      </tr>\r\n      <tr>\r\n        <td>Margin </td>\r\n        <td> \r\n          <table>\r\n            <tr>\r\n              <td>Kiri</td><td nowrap> \r\n              <input type=text size=4 value='{$marginkiri}' name=marginkiri id=marginkiri> mm \r\n              <label class=error for=marginkiri id=marginkiri_error>Harus diisi bilangan</label>  \r\n              </td>\r\n            </tr>\r\n            <tr><td  nowrap>\r\n        Kanan </td><td  nowrap><input type=text size=4 value='{$marginkanan}' name=marginkanan id=marginkanan> mm </td>\r\n            </tr>\r\n            <tr><td>\r\n        Atas </td><td  nowrap><input type=text size=4 value='{$marginatas}' name=marginatas id=marginatas> mm </td>\r\n            </tr>\r\n            <tr><td>\r\n        Bawah </td><td  nowrap><input type=text size=4 value='{$marginbawah}' name=marginbawah id=marginbawah> mm </td>\r\n            </tr>\r\n          </table>\r\n         </td>\r\n      </tr>\r\n      <tr>\r\n        <td></td>\r\n        <td>\r\n   <input type=submit name=submit class=button id=submit_btn  value='Simpan'>\r\n        </td>\r\n      </tr>    \r\n    </table>\r\n    \r\n</form>\r\n</div>\r\n";
?>
