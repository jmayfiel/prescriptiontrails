<?php 
require("/nfs/users/clind/public_html/prescriptiontrails.org/admin/db.php"); 
$superPage = true;
require("/nfs/users/clind/public_html/prescriptiontrails.org/src/secure.php"); 

$special = "breadcrumb";
$breadcrumb = '<a href="'.$baseurl.'admin/" class="green-text text-darken-3"><i class="fa fa-home"></i></a>';
$breadcrumb .= '&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'report/" class="green-text text-darken-3">Reports</a>&nbsp;&nbsp;<i class="fa fa-chevron-right grey-text text-darken-1" style="padding-top:1px;"></i>&nbsp;&nbsp;<a href="'.$baseurl.'report/users.php" class="green-text text-darken-3">Users</a>';

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0"/>
  <title>Prescription Trails</title>

  <!-- CSS  -->
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/style_base.php"); ?>
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.10/css/jquery.dataTables.min.css">
<style>
td.details-control {
    background: url('<?php echo($baseurl); ?>img/details_open.png') no-repeat center center;
    cursor: pointer;
}
tr.shown td.details-control {
    background: url('<?php echo($baseurl); ?>img/details_close.png') no-repeat center center;
}
</style>

</head>
<body class="<?php echo($bodyclass); ?>">
  

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/nav.php"); ?>

<div class="container">
    <div class="row">
    
        
  <div class="col s12">

        <div class="row no-print">
            <div class="col m4 s12" style="margin-top:10px"><a class="waves-effect waves-dark btn herobtn white black-text" href="<?php echo($baseurl); ?>admin/">Admin Home</a></div>
            <div class="col m4 s12" style="margin-top:10px"><a class="waves-effect waves-dark btn herobtn white black-text" href="<?php echo($baseurl); ?>admin/report/">All Reports</a></div>
            <div class="col m4 s12" style="margin-top:10px"><a class="waves-effect waves-dark btn herobtn white black-text" href="#!" onClick="window.print();">Print</a></div>
        </div>

   <div class="row">    
   		<div class="col s12">
			<div class="card white">
            	<div class="card-content">
                <h4>Report: Users</h4>        
<table id="reportTable" class="display" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th></th>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Permissions</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th></th>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Permissions</th>
            </tr>
        </tfoot>
    </table>
				</div>
             </div>
             
          </div>          
	</div>


           </div>
 
    </div>

</div>
      
<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/drawer.php"); ?>

<?php require("/nfs/users/clind/public_html/prescriptiontrails.org/src/js_base.php"); ?>
<script src="https://cdn.datatables.net/1.10.10/js/jquery.dataTables.min.js"></script>
<script>
/* Formatting function for row details - modify as you need */
function format ( d ) {
    // `d` is the original data object for the row
    return '<table cellpadding="5" cellspacing="0" border="0" style="padding-left:50px;">'+
        '<tr>'+
            '<td width="120" style="text-align:right;">Full name:</td>'+
            '<td>'+d.fname+' '+d.lname+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td width="120" style="text-align:right;">Email status:</td>'+
            '<td>'+d.verified+'</td>'+
        '</tr>'+
        '<tr>'+
            '<td width="120" style="text-align:right;">Account Status:</td>'+
            '<td>'+d.status+' - <a href="<?php echo($baseurl); ?>src/changeUser.php?id='+d.id+'&status='+d.status+'">Disable/Enable</a> - Requires SuperUser</td>'+
        '</tr>'+
    '</table>';
}
 
$(document).ready(function() {
    var table = $('#reportTable').DataTable( {
        "ajax": "<?php echo($baseurl); ?>src/allUsers.php",
        "columns": [
            {
                "className":      'details-control',
                "orderable":      false,
                "data":           null,
                "defaultContent": ''
            },
            { "data": "id" },
            { "data": "fname" },
            { "data": "lname" },
            { "data": "email" },
            { "data": "permissions" }
        ],
        "order": [[3, 'asc']]
    } );
     
    // Add event listener for opening and closing details
    $('#reportTable tbody').on('click', 'td.details-control', function () {
        var tr = $(this).closest('tr');
        var row = table.row( tr );
 
        if ( row.child.isShown() ) {
            // This row is already open - close it
            row.child.hide();
            tr.removeClass('shown');
        }
        else {
            // Open this row
            row.child( format(row.data()) ).show();
            tr.addClass('shown');
        }
    } );
} );
</script>

  </body>
</html>
