<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=template_sales_person.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<table>
    <tr>
        <td>SP_ID</td>
        <td>SP_NAME</td>
        <td>NOTE</td>
    </tr>
</table>