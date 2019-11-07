<?php

include "config.php";
include "includes/check_login.php";

if(isset($_GET['id'])){
	$id = intval($_GET['id']);

$sql = mysqli_query($link,"SELECT * FROM work_orders 
    				WHERE customer_id = '$id'
					AND work_order_status != 'Picked Up'
    				ORDER BY work_order_id DESC"
);
	
$num = mysqli_num_rows($sql);
if($num>0){

?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-wrench"></i> Open WorkOrders <span class="badge pull-right"><?php echo "$num"; ?></span></h3>
	</div>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Date</th>
				<th>Type</th>
				<th>Asset</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			
			<?php
				
				while ($row = mysqli_fetch_array($sql)){
					$work_order_id = $row['work_order_id'];
					$take_in_date =  date($date_format, $row['take_in_date']);
					$type = ucwords($row['type']);
					$items = $row['product'];
					$quantity = $row['quantity'];
					$price = $row['price'];
					$amount = $row['amount'];
					$work_order_type = $row['work_order_type'];
					$work_order_status = $row['work_order_status'];
			    	
			    	echo "
						<tr>
							<td>$take_in_date</td>
							<td>$work_order_type<br><small class='text-muted'>$work_order_status</small></td>
							<td><i class='$type'></i> $items <small>$quantity</small></td>
							<td>
								<div class='btn-group'>
									<a class='btn btn-default btn-sm' href='print_work_order.php?id=$work_order_id' target='_blank'><i class='fa fa-print'></i></a>
									<a class='btn btn-default btn-sm' href='work_order_details.php?id=$work_order_id'><i class='glyphicon glyphicon-eye-open'></i></a>
								</div>
							</td>
						</tr>
					";
				}
				$count = mysqli_num_rows($sql);

			?>
		
		</tbody>
	</table>
</div>

<?php
	} //End if no records found for Work Orders Open
}
?>