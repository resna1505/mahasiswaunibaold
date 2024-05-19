<?php
/*********************/
/*                   */
/*  Dezend for PHP5  */
/*         NWS       */
/*      Nulled.WS    */
/*                   */
/*********************/

function stripcar_array( $arrayinput )
{
    foreach ( $arrayinput as $k => $v )
    {
        if ( is_array( $v ) )
        {
            $hasil[$k] = stripcar_array( $v );
        }
        else
        {
            $hasil[$k] = stripcar( $v );
        }
    }
    return $hasil;
}

function stripcar( $value )
{
    $hasil = $value;
    $hasil = eregi_replace_sikad( "[\\\\'\"!@#$%^&*()_+=;:?<>]", "", $hasil, "/" );
    return $hasil;
}

function strip_input_error( )
{
    if ( is_array( $_POST ) )
    {
        foreach ( $_POST as $k => $v )
        {
            if ( is_array( $v ) )
            {
                $$k = stripcar_array( $v );
            }
            else
            {
                $$k = stripcar( $v );
            }
        }
    }
    if ( is_array( $_GET ) )
    {
        foreach ( $_GET as $k => $v )
        {
            if ( is_array( $v ) )
            {
                $$k = stripcar_array( $v );
            }
            else
            {
                $$k = stripcar( $v );
            }
        }
    }
}

function mstr2_array( $arrayinput )
{
    foreach ( $arrayinput as $k => $v )
    {
        if ( is_array( $v ) )
        {
            $hasil[$k] = mstr2_array( $v );
        }
        else
        {
            $hasil[$k] = mstr2( $v );
        }
    }
    return $hasil;
}

function mstr2( $value )
{
    global $koneksi;	
    global $arraykataterlarang;
    $hasil = $value;
    $hasil = htmlentities( $value );
    foreach ( $arraykataterlarang as $v )
    {
        $hasil = preg_replace( "#".$v." #i", "", $hasil );
    }
    if ( get_magic_quotes_gpc( ) )
    {
        $hasil = stripslashes( $hasil );
    }
    $hasil = mysqli_real_escape_string($koneksi, $hasil );
    $hasil = trim( $hasil );
    return $hasil;
}

unset( $arraykataterlarang );
$arraykataterlarang[] = "SELECT";
$arraykataterlarang[] = "INSERT";
$arraykataterlarang[] = "DELETE";
$arraykataterlarang[] = "GRANT";
$arraykataterlarang[] = "DROP";
$arraykataterlarang[] = "WHILE";
$arraykataterlarang[] = "UNION";
$arraykataterlarang[] = "TRUNCATE";
if ( is_array( $_GET ) )
{
    foreach ( $_GET as $k => $v )
    {
        if ( is_array( $v ) )
        {
            $$k = mstr2_array( $v );
        }
        else
        {
            $$k = mstr2( $v );
        }
    }
}
if ( is_array( $_POST ) )
{
    foreach ( $_POST as $k => $v )
    {
        if ( is_array( $v ) )
        {
            $$k = mstr2_array( $v );
        }
        else
        {
            $$k = mstr2( $v );
        }
    }
}
if ( is_array( $_COOKIE ) )
{
    foreach ( $_COOKIE as $k => $v )
    {
        if ( is_array( $v ) )
        {
            $$k = mstr2_array( $v );
        }
        else
        {
            $$k = mstr2( $v );
        }
    }
}
if ( is_array( $_SERVER ) )
{
    foreach ( $_SERVER as $k => $v )
    {
        $$k = $v;
    }
}
if ( is_array( $_FILES ) )
{
    foreach ( $_FILES as $k => $v )
    {
        foreach ( $v as $kk => $vv )
        {
            $str = $k."_".$kk;
            $$str = $vv;
        }
        $$k = $v['tmp_name'];
    }
}
?>
