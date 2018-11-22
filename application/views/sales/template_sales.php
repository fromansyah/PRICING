<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=template_sale.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<table>
    <tr>
        <th>DATE</th>
        <th>SALES_PERSON</th>
        <th>CUSTOMER</th>
        <th>SITE</th>
        <th>PRODUCT_NO</th>
        <th>CURRENCY</th>
        <th>PRICE</th>
        <th>QUANTITY</th>
        <th>TOTAL</th>
    </tr>
</table>