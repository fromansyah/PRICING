<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=template_price.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<table>
    <tr>
        <td>PRODUCT_NO</td>
        <td>YEAR</td>
        <td>PERIODE</td>
        <td>START_DATE</td>
        <td>END_DATE</td>
        <td>CATALOGUE_PRICE</td>
    </tr>
    <?  foreach ($data as $row):?>
    <tr>
        <td><?=$row->product_no?></td>
        <td><?=$row->periode_year?></td>
        <td><?=$row->periode_month?></td>
        <td><?=$row->start_date?></td>
        <td><?=$row->end_date?></td>
        <td><?=$row->catalogue_price?></td>
    </tr>
    <? endforeach;?>
</table>