<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=template_plan.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<table>
    <tr>
        <th>YEAR</th>
        <th>PERIOD</th>
        <th>PRODUCT_NO</th>
        <th>CUSTOMER</th>
        <th>SITE</th>
        <th>START_DATE</th>
        <th>END_DATE</th>
        <th>PRICE</th>
        <th>SP</th>
    </tr>
</table>