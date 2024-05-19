<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

periksaroot( );
if ( $lihatsemua != 1 )
{
    if ( $maxdata == "" || $maxdata <= 0 )
    {
        $maxdata = 100;
    }
    if ( $hal == "" || $hal < 0 )
    {
        $hal = 1;
    }
    $gright = "<img alt='next page' src='".$root."gambar/right.png' border=0>";
    $grightg = "<img alt='next page' src='".$root."gambar/rightg.png' border=0>";
    $gleft = "<img alt='prev page' src='".$root."gambar/left.png' border=0>";
    $gleftg = "<img alt='prev page' src='".$root."gambar/leftg.png' border=0>";
    $glast = "<img alt='last page' src='".$root."gambar/last.png' border=0>";
    $glastg = "<img alt='last page' src='".$root."gambar/lastg.png' border=0>";
    $gfirst = "<img alt='first page' src='".$root."gambar/first.png' border=0>";
    $gfirstg = "<img alt='first page' src='".$root."gambar/firstg.png' border=0>";
    $maxhal = ceil( $total / $maxdata );
    if ( $hal == 1 && 1 < $maxhal )
    {
        $tnext = " <font id=tombolnext><a   href='{$href}&sort={$sort}&hal=".( $hal + 1 )."'>{$gright}</a> \r\n\t\t\t <a  href='{$href}&sort={$sort}&hal={$maxhal}'>{$glast}</a></font>";
        $tprev = "<font id=tombolprev_end>{$gfirstg} {$gleftg}</font >";
    }
    else if ( $maxhal == $hal && $maxhal != 1 )
    {
        $tprev = "<font  id=tombolprev>\r\n\t\t\t <a href='{$href}&sort={$sort}&hal=1'>{$gfirst}</a>\r\n\t\t\t <a href='{$href}&sort={$sort}&hal=".( $hal - 1 )."'>{$gleft}</a>\r\n\t\t\t </font >";
        $tnext = "<font  id=tombolnext_end>{$grightg} {$glastg}</font >";
    }
    else if ( $maxhal == $hal && $maxhal == 1 )
    {
        $tprev = "<font id=tombolprev_end>{$gfirstg} {$gleftg}</font>";
        $tnext = "<font  id=tombolnext_end>{$grightg} {$glastg}</font>";
    }
    else
    {
        $tnext = "<font id=tombolnext> <a href='{$href}&sort={$sort}&hal=".( $hal + 1 )."'>{$gright}</a>\r\n\t\t\t <a  href='{$href}&sort={$sort}&hal={$maxhal}'>{$glast}</a>\r\n\t\t\t </font >";
        $tprev = "<font  id=tombolprev>\r\n\t\t\t  <a href='{$href}&sort={$sort}&hal=1'>{$gfirst}</a>\r\n\t\t\t <a href='{$href}&sort={$sort}&hal=".( $hal - 1 )."'>{$gleft}</a></font\t >";
    }
    $first = $maxdata * ( $hal - 1 );
    $qlimit = "LIMIT {$first},{$maxdata}";
    if ( $aksi != "cetak" )
    {
        #$tpage = "\r\n\t\t\t<table  width=95% cellspacing=0    class=paginating>\r\n\t\t\t\t<tr  class=paginating valign=top>\r\n\t\t\t\t\t<td>\r\n\t\t\t\t\t\tHalaman ke {$hal} dari {$maxhal}, ditemukan total {$total} data\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td align=center>\r\n\t\t\t\t\t\t halaman ";
        $tpage = "\r\n\t\t\t<table  width=95% cellspacing=0    class=paginating>\r\n\t\t\t\t<tr  class=paginating valign=top>\r\n\t\t\t\t\t<td>\r\n\t\t\t\t\t\tHalaman ke {$hal} dari {$maxhal}, ditemukan total {$total} data\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td align=center> ";
        
		$pertama = 1;
        $terakhir = $maxhal;
        $pertama = $hal - 10;
        if ( $pertama < 1 )
        {
            $pertama = 1;
        }
        $terakhir = $pertama + 14;
        if ( $maxhal < $terakhir )
        {
            $terakhir = $maxhal;
        }
        /*$ii = $pertama;
        while ( $ii <= $terakhir )
        {
            if ( $ii != $hal )
            {
                $tpage .= " <a href='{$href}&sort={$sort}&hal={$ii}'><b>{$ii}</b></a> ";
            }
            else
            {
                $tpage .= "{$ii} ";
            }
            ++$ii;
        }*/
        $tpage .= "\r\n\t\t\t\t\t</td>\r\n\t\t\t\t\t<td align=right nowrap>\r\n\t\t\t\t\t\t{$tprev} &nbsp;  {$tnext} \r\n\t\t\t\t\t</td>\r\n\t\t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t";
    }
}
if ( $aksi != "cetak" )
{
    $tpage2 .= "\r\n\t\t\t<table  width=95%  cellspacing=0    class=paginating  id=paginate>\r\n\t\t\t\t<tr  class=paginating>\r\n\t\t\t\t\t<td>\r\n\t\t\t\t\t\t<a id=nopaged href=\"{$href}&sort={$sort}&lihatsemua=1 \">Tampilkan semua</a>\r\n\t\t\t\t\t\t| <a id=paged href='{$href}&sort={$sort}&hal=1'>Tampilkan per halaman</a>\r\n\t\t\t\t\t</td>\r\n\t \t\t\t</tr>\r\n\t\t\t</table>\r\n\t\t\t";
}
$input .= "\r\n\t\t<input type=hidden name=hal value='{$hal}'>\r\n\t\t<input type=hidden name=lihatsemua value='{$lihatsemua}'>\r\n\t\t";
$href .= "&hal={$hal}&lihatsemua={$lihatsemua}";
?>
