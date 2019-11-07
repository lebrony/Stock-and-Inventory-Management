<?php

include "config.php";
include "includes/check_login.php";

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = mysqli_query($link, "SELECT * FROM boq 
    					WHERE customer_id = '$id'
    					ORDER BY system_number DESC");

    $num = mysqli_num_rows($sql);
    if ($num > 0) {

        ?>

<div class="panel panel-default">
	<div class="panel-heading">
		<h3 class="panel-title"><i class="fa fa-bell"></i> Bill Of Quantity <span class="badge pull-right"><?php echo "$num"; ?></span></h3>
	</div>
	<table class="table table-hover">
		<thead>
			<tr>
				<th>Date</th>
				<th>Material's</th>
				<th>Amount</th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			
			<?php

    while ($row = mysqli_fetch_array($sql)) {
        $system_number = $row['system_number'];
        $date_added = date($date_format, $row['date_added']);
        $items = $row['items'];
        $quantity = $row['quantity'];
        $labour_cost = $row['labour_cost'];
		$amount = $row['amount'];
		$technician = $row['technician'];
        $length = $row['length'];

        echo "
						<tr>
							<td>$date_added</td>
							<td>$items<br><small class='text-muted'>$quantity RF, $length</small></td>
							<td><i class='$amount'></i><small>$amount</small></td>
							<td>
								<div class='btn-group'>
									<a class='btn btn-default btn-sm' href='boq_details.php?id=$system_number' target='_blank'><i class='fa fa-eye'></i></a>
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