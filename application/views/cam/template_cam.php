<?php 
header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=template_cam.xls");
header("Pragma: no-cache");
header("Expires: 0");
?>
<meta http-equiv="content-type" content="application/vnd.ms-excel; charset=UTF-8">
<table>
    <tr>
        <td>CAM_ID</td>
        <td>CAM_NAME</td>
        <td>NOTE</td>
    </tr>
</table>