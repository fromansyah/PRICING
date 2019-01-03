<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=template_emp.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<table>
    <tr>
        <td>EMP_ID</td>
        <td>EMP_NAME</td>
        <td>EMAIL</td>
        <td>POSITION</td>
        <td>NOTE</td>
        <td>SUBSCRIBE</td>
    </tr>
</table>
