<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=template_customer.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<table>
    <tr>
        <td>CUST_NO</td>
        <td>CUST_NAME</td>
        <td>CUST_TYPE</td>
        <td>CORP_ID</td>
        <td>BU</td>
        <td>NOTE</td>
    </tr>
</table>