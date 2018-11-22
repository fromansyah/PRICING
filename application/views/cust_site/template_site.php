<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=template_customer_site.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<table>
    <tr>
        <td>CUST_ID</td>
        <td>SITE_ID</td>
        <td>NOTE</td>
    </tr>
</table>