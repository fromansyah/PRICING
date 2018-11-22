<html>
<head>
<title>jQGrid example</title>
<link href="<?=$this->config->item('base_url');?>css/style.css" rel="stylesheet" type="text/css" />
<link href="<?=$this->config->item('base_url');?>css/ui.jqgrid.css" rel="stylesheet" type="text/css" />
<link href="<?=$this->config->item('base_url');?>css/jquery-ui.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="<?= base_url() ?>js/datetimepicker_css.js"></script>

<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/jquery.js"></script>
<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/jquery-ui-1.8.2.min.js"></script>
<script type="text/javascript" src="<?=$this->config->item('base_url');?>js/jquery.jqGrid.min.js"></script>

</head>
<body>
    <br/>
    <br/>
    <br/>
    <br/>
    <table>
        <tr>
            <td width="6"></td>
            <td width="230" valign="top">
            </td>
            <td width="1076">
                <table id="datagrid"></table>
                <div id="navGrid"></div>
                <p><script language="javascript">
                jQuery("#datagrid").jqGrid({
                        url:'http://localhost/jqgrid/book.php',
                    datatype: "json",
                    colNames:['No','Title', 'Author', 'Publisher','Year_published'],
                    colModel:[
                                {name:'no',index:'no', width:55,editable:false,editoptions:{readonly:true,size:10}},
                                {name:'title',index:'title', width:80,editable:true,editoptions:{size:10}},
                                {name:'author',index:'author', width:90,editable:true,editoptions:{size:25}},
                                {name:'publisher',index:'publisher', width:60, align:"right",editable:true,editoptions:{size:10}},
                                {name:'year_published',index:'year_published', width:60, align:"right",editable:true,editoptions:{size:10}}
                        ],
                        rowNum:10,
                        rowList:[10,15,20,25,30,35,40],
                        pager: '#navGrid',
                        sortname: 'no',
                        sortorder: "asc",
                        height: 210,
                        viewrecords: true,
                        caption:"Example"
                });
                jQuery("#datagrid").jqGrid('navGrid','#navGrid',{edit:true,add:true,del:true});
                </script>
            </td>
            <td><? print_r($book)?></td>
        </tr>
    </table>  

    
    

</body>
</html>