<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=template_corporate.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<table>
    <tr>
        <td>CORP_NO</td>
        <td>CORP_NAME</td>
        <td>NOTE</td>
    </tr>
</table>