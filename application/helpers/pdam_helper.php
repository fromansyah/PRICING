<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
function pdam_debug($var) {
    echo "<pre>";
    print_r($var);
    echo "</pre>";
    exit();
}

function errormsg($errormsg) {
    echo "<div id=\"error-box\">";
    echo "<table>";
    echo "<tr><td>";
    echo $errormsg;
    echo "</td>";
    echo "</tr>";
    echo "</table>";
    echo "</div>";
    echo "<br />";
}

function tgl_indo($str) {
    $str = date('d-m-Y', strtotime($str));
    return $str;
}

function terbilang($x)
{
  $abil = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
  if ($x < 12)
    return " " . $abil[$x];
  elseif ($x < 20)
    return Terbilang($x - 10) . "belas";
  elseif ($x < 100)
    return Terbilang($x / 10) . " puluh" . Terbilang($x % 10);
  elseif ($x < 200)
    return " seratus" . Terbilang($x - 100);
  elseif ($x < 1000)
    return Terbilang($x / 100) . " ratus" . Terbilang($x % 100);
  elseif ($x < 2000)
    return " seribu" . Terbilang($x - 1000);
  elseif ($x < 1000000)
    return Terbilang($x / 1000) . " ribu" . Terbilang($x % 1000);
  elseif ($x < 1000000000)
    return Terbilang($x / 1000000) . " juta" . Terbilang($x % 1000000);
}

// date_validation callback
function valid_date($str)
{
    if(!ereg("^(0[1-9]|1[0-9]|2[0-9]|3[01])-(0[1-9]|1[012])-([0-9]{4})$", $str))
    {
        return false;
    }
    else
    {
        return true;
    }
}

?>