<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=template_product.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<table>
    <tr>
        <td>PRODUCT_NO</td>
        <td>PRODUCT_NAME</td>
        <td>KG_PER_PAIL</td>
        <td>DESC</td>
    </tr>
</table>