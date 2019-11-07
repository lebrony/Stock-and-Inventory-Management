<?php 
	
	include "config.php";
	include "includes/header.php";
	include "includes/check_login.php";
	include "includes/nav.php";

	if(isset($_GET['id'])){
		$id = $_GET['id'];
	}

	$sql = mysqli_query($link,"SELECT * from customers WHERE customer_id = $id");

	$row = mysqli_fetch_array($sql);
	
	$company = $row['company'];
    $last_name = ucwords($row['last_name']);
    $first_name = ucwords($row['first_name']);
    $address = ucwords($row['address']);
    $city = $row['city'];
    $street = $row['street'];
    $ward = $row['ward'];
    $phone = $row['phone'];
    if(strlen($phone)>2){ $phone = substr($row['phone'],0,3)."-".substr($row['phone'],3,3)."-".substr($row['phone'],6,4);}
    $mobile = $row['mobile'];
    if(strlen($mobile)>2){ $mobile = substr($row['mobile'],0,3)."-".substr($row['mobile'],3,3)."-".substr($row['mobile'],6,4);}
    $email = $row['email'];
    $date_added = date($date_format,$row['date_added']);

?>
<div class="row">
	<div class="col-md-3">
		<table class="table table-bordered">
			<tr>
				<th><h4><i class="fa fa-user"></i> <?php echo "$first_name $last_name<br><div class='pull-right text-info'>$company</div>"; ?></h4></th>
			</tr>
			<tr>
				<td><a href="https://maps.google.com?q=<?php echo "$address, $ward"; ?>" target="_blank" class="text-info"><?php echo "$address<br>$city, $street, $ward"; ?></a></td>
			</tr>
			<tr>
				<td>
					<?php 
					if($phone <> ''){ echo "<p><i class='fa fa-phone'></i> $phone</p>"; }
					if($mobile <> ''){ echo "<p><i class='glyphicon glyphicon-phone'></i> $mobile</p>"; }
					if($email <> ''){ echo "<p><i class='fa fa-envelope'></i> <small><a href='https://google.com/search.php?q=$email' target='_blank' class='text-info'>$email</small></p>"; } 
					?>
				</td>
			</tr>
			<tr>	
				<td><?php echo "$date_added"; ?></td>
			</tr>
		</table>	
	</div>
	<div class="col-md-9">
		<div id="response"></div>	
		<div class='btn-group'>
			<button data-toggle="collapse" data-parent="#accordion" href="#collapseWorkOrder" class="tip btn btn-primary" title="New Work Order"><i class="glyphicon glyphicon-wrench"></i> WorkOrder</button>
			<button data-toggle="collapse" data-parent="#accordion" href="#collapseNote" class="tip btn btn-default" title="New Note"><i class="glyphicon glyphicon-edit"></i> Note</button>
			<button data-toggle="collapse" data-parent="#accordion" href="#collapseBillQty" class="tip btn btn-default" title="New BOQ"><i class="glyphicon glyphicon-leaf"></i> BOQ</button>
			<!-- <button data-toggle="collapse" data-parent="#accordion" href="#collapseQuote" class="tip btn btn-default" title="New Quote"><i class="glyphicon glyphicon-file"></i> Quotation</button> -->
		</div>
		<div class='btn-group pull-right'>
			<a href="edit_customer.php?id=<?php echo $id; ?>" class="btn btn-default tip" title="Edit Customer"><i class="fa fa-pencil-alt"> Edit</i></a>
			<button data-toggle="modal" href="#customer_delete" class="btn btn-danger tip" title="Delete Customer"><i class="fa fa-trash-o"></i> Delete</button>
		</div>
		<div id="accordion">
			<div id="collapseWorkOrder" class="panel-collapse collapse">
				<br>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">New Orders</h3>
					</div>
					<div class="panel-body">
					    <form id="formWorkOrder" class="form col-sm-11" autocomplete="off">
					    <input type="hidden" name="customer_id" value="<?php echo $id; ?>">
					    <input type="hidden" name="new_work_order">
						<div class="form-group">
							<div class="col-sm-7">
								<label>Scope</label>
									<select class="form-control input-lg" name="scope" autofocus required>		       		
										<option></option>

											<?php

												$result = mysqli_query($link, "SELECT * FROM commons WHERE category = 'work_order_type' ORDER BY value ASC");
												while ($row = mysqli_fetch_array($result)) {
													$value = $row['value'];
													$value2 = $row['value2'];
													$value3 = $row['value3'];
													$value4 = $row['value4'];

													echo "<option>$value</option>";
													echo "<option>$value2</option>";
													echo "<option>$value3</option>";
													echo "<option>$value4</option>";




												}

											?>
									</select>
							</div>
						</div>

						<div class="form-group">
							<div class="col-sm-7">
								<label>Asset Type</label>
									<select class="form-control input-lg" name="asset_type" autofocus required>		       		
										<option></option>

											<?php

										$result = mysqli_query($link, "SELECT * FROM commons WHERE category = 'product_type' ORDER BY value ASC");
										while ($row = mysqli_fetch_array($result)) {
											$value = $row['value'];
											$value2 = $row['value2'];

											echo "<option>$value</option>";
											echo "<option>$value2</option>";




										}

										?>
									</select>
							</div>
						</div>

						<div id="newlinks">
							<div class="form-group">
								<div class="col-sm-7">
									<label>Assets</label>
										<select class="form-control input-lg" name="product" autofocus required>		       		
											<option></option>

												<?php

											$result = mysqli_query($link, "SELECT * FROM commons WHERE category = 'product_list' ORDER BY value ASC");
											while ($row = mysqli_fetch_array($result)) {
												$value = $row['value'];
												$value2 = $row['value2'];
												$value3 = $row['value3'];
												$value4 = $row['value4'];
												$value5 = $row['value5'];
												$value6 = $row['value6'];

												echo "<option>$value</option>";
												echo "<option>$value2</option>";
												echo "<option>$value3</option>";
												echo "<option>$value4</option>";
												echo "<option>$value5</option>";
												echo "<option>$value6</option>";

											}

											?>
										</select>
								</div>
							</div>

							<div class="form-group">                          
								<div class="col-sm-7">
									<label>Quantity</label>
									<input type="number" class="form-control input-lg" name="quantity" onkeyup="tots(this)" id="txtQty">
								</div>
							</div>

							<div class="form-group">                          
								<div class="col-sm-7">
									<label>Price</label>
										<input type="number" class="form-control input-lg" name="price" onkeyup="tots(this)" id="txtPrice">
								</div>
							</div>

							<div class="form-group">                          
								<div class="col-sm-5">
									<label>Amount (Tshs)</label>
										<input type="number" id="total" class="form-control input-lg" style="width:60%;" name="amount" <span id="update" readonly></span>
								</div>
							</div>

							<div class="form-group">                          
								<div class="col-sm-6">
									<label>&nbsp;</label>
										<a href="javascript:new_links()"><i class="fa fa-plus"></i> <strong>Add More</strong></a>
								</div>
							</div>
						</div>

						<br>

						<div class="form-group">                          
							<div class="col-sm-7">
								<label>Asigned worker</label>
								<select class="form-control input-lg" name="worker" autofocus required>		       		
											<option></option>

												<?php

											$result = mysqli_query($link, "SELECT * FROM technician ORDER BY technician_code ASC");
											while ($row = mysqli_fetch_array($result)) {
												$first_name = $row['first_name'];
												$last_name = $row['last_name'];

												echo "<option>$first_name $last_name</option>";

											}

											?>
										</select>
							</div>
						</div>

						<div class="form-group">                          
								<div class="col-sm-5">
									<label>Work Duration(Weeks)</label>
										<select class="form-control input-lg" style="width:50%;" name="duration" required>
											<option></option>
											<option>1 <b>Week</b></option>
											<option>2 <b>Week's</b></option>
											<option>3 <b>Week's</b></option>
											<option>1 <b>Month</b></option>
											<option>2 <b>Month's</b></option>
											<option>3 <b>Month's</b></option>
											<option>4 <b>Month's</b></option>
											<option>5 <b>Month's</b></option>
											<option>6 <b>month's</b></option>
										</select>
								</div>
							</div>

						<div class="form-group">                          
							<div class="col-sm-7">
								<label>Taking Notes</label>
								<textarea class="form-control" name="take_in_notes" rows="6" required></textarea>
								<br>
								<button class="btn btn-primary">Submit</button>
								<button class="btn btn-warning">Print and Close</button>
							</div>
						</div>

						<!-- <div id="newlinked"  style="display:none">
							<div class="form-group">
								<div class="col-sm-7">
									<label>Assets</label>
										<select class="form-control input-lg" name="product" autofocus required>		       		
											<option></option>

												<?php

											$result = mysqli_query($link, "SELECT * FROM commons WHERE category = 'product_list' ORDER BY value ASC");
											while ($row = mysqli_fetch_array($result)) {
												$value = $row['value'];
												$value2 = $row['value2'];
												$value3 = $row['value3'];
												$value4 = $row['value4'];
												$value5 = $row['value4'];
												$value6 = $row['value4'];

												echo "<option>$value</option>";
												echo "<option>$value2</option>";
												echo "<option>$value3</option>";
												echo "<option>$value4</option>";
												echo "<option>$value5</option>";
												echo "<option>$value6</option>";

											}

											?>
										</select>
								</div>
							</div>
						
							<div class="form-group">                          
								<div class="col-sm-7">
									<label>Quantity</label>
									<input type="number" class="form-control input-lg" name="quantity" onkeyup="tots(this)" id="txtQty">
								</div>
							</div>

							<div class="form-group">                          
								<div class="col-sm-7">
									<label>Price</label>
										<input type="number" class="form-control input-lg" name="price" onkeyup="tots(this)" id="txtPrice">
								</div>
							</div>

							<div class="form-group">                          
								<div class="col-sm-5">
									<label>Amount (Tshs)</label>
										<input type="number" id="total" class="form-control input-lg" style="width:60%;" name="amount" <span id="update" readonly></span>
								</div>
							</div>

							<div class="form-group">                          
								<div class="col-sm-6">
									<label>&nbsp;</label>
										<a href="javascript:new_links()"><i class="fa fa-plus"></i> <strong>Add More</strong></a>
								</div>
							</div>
						</div> -->

					</div>
				</div>
			</div>

			<div id="collapseNote" class="panel-collapse collapse">
				<br>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">New Note</h3>
					</div>
					<div class="panel-body">
					    <form id="formNote" class="form form-horizontal" autocomplete="off">
					    	<input type="hidden" name="customer_id" value="<?php echo $id; ?>">
					    	<input type="hidden" name="new_customer_note">
					    	<div class="form-group">
					        <div class="col-md-12">
						        <textarea class="form-control input-lg" name="note"></textarea>
						    	<br>
						    	<button class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-ok"></span> Add</button>
						    </div>
						  </div>
					    </form>
					</div>
				</div>
			</div>

			<div id="collapseBillQty" class="panel-collapse collapse">
				<br>
				<div class="panel panel-default">
					<div class="panel-heading">
						<h3 class="panel-title">New BOQ</h3>
					</div>
					<div class="panel-body">
					    <form id="formWorkBoq" class="form form-horizontal" autocomplete="off">
					    <input type="hidden" name="customer_id" value="<?php echo $id; ?>">
					    <input type="hidden" name="add_boq">
							<div class="form-group">
								<div class="col-sm-4">
									<input type="text" class="form-control input-lg" Placeholder="Bill Number" name="system_number" autofocus required/>
								</div>
							</div>
						<div id="newlink">
                            <div class="form-group">                          
                                <div class="col-sm-4">
									<label>Items</label>
                                	<select name="items" class="form-control input-lg" placeholder="Please Select!" required="required">
										<option></option>
                                		<?php

									$result = mysqli_query($link, "SELECT * FROM product ORDER BY id ASC");
									while ($row = mysqli_fetch_array($result)) {
										$value = $row['name'];

										echo "<option>$value</option>";
									
									
										
									}

									?>
                                    </select>
                                </div>
                            </div>
                            
                            
                            <div class="form-group">                          
                                <div class="col-sm-4">
									<label >Dimension's</label>
                                    <select class="form-control input-lg" name="length" placeholder="" required="required">
									<option></option>
										<?php

											$result = mysqli_query($link, "SELECT * FROM dimensions ORDER BY id ASC");
											while ($row = mysqli_fetch_array($result)) {
												$value = $row['name'];
												
												

												echo "<option>$value</option>";

											}

										?>
									</select>
								</div>
							</div>

							<div class="form-group">                          
                                <div class="col-sm-4">
                                    <input type="number" class="form-control input-lg" placeholder="Running Feet" name="qty" placeholder="" required="required">
                                </div>
                            </div>

							<div class="form-group">                          
                                <div class="col-sm-4">
								<label>Technician</label>
								<select class="form-control input-lg" name="technician" placeholder="" required="required">
									<option></option>
										<?php

											$result = mysqli_query($link, "SELECT * FROM technician ORDER BY technician_id ASC");
											while ($row = mysqli_fetch_array($result)) {
												$first_name = $row['first_name'];
												$last_name = $row['last_name'];
												

												echo "<option>$first_name $last_name</option>";

											}

										?>
									</select>
                                </div>
                            </div>

							<div class="form-group">
								<label >&nbsp;</label>
								<div class="col-sm-6">
									<a href="javascript:new_link()"><i class="fa fa-plus"></i> Add More</a>
								</div>
							</div>
                            
                        
						</div>
							
							<div class="form-group">
					        <div class="col-sm-5">
							<label>Total Cost</label>
						        <input type="text" class="form-control input-lg" onkeyup="boq(this)" id="total_cost" name="total_cost" required/>
						    </div>
							</div>

							<div class="form-group">
								<div class="col-sm-5">
									<label>Labour Cost</label>
										<input type="text" class="form-control input-lg" onkeyup="boq(this)" id="labour_cost" name="labour_cost" required/>										
								</div>
							</div>
							<div class="Amounts" >
								<div class="col-md-6" style="margin-left:50%;">
									<h4 class="heading" >BOQ Totals</h4>
										<table  class="table table-bordered col-md-6"  >
											<tbody>
												<tr>
													<th>BOQ Amount</th>
													<td><input type="text" id="boq_cost" name="amount" style="text-align:center;" class="form-control " readonly <span id="update_cost" ></span></td>
												</tr>
												<tr>
													<th>TAX</th>
													<td><input type="text" class="form-control " readonly/></td>
												</tr>
												<tr>
													<th>Profit</th>
													<td><input type="text" class="form-control " readonly/></td>
												</tr>
											</tbody>
										</table>
								</div>
							</div>
							<div class="col-sm-6" style="margin-left:83%;">
					       		 <button class="btn btn-primary btn-lg"><span class="glyphicon glyphicon-save"></span>Submit</button>
							</div>
						</form>
					</div>
				</div>

				<div id="newlinktpl" style="display:none">
            
				<div class="form-group">                          
                <div class="col-sm-4">
					<label>Items</label>
                    	<select name="items" class="form-control input-lg" placeholder="Please Select!" required="required">
							<option></option>
                            	<?php

									$result = mysqli_query($link, "SELECT * FROM inventory ORDER BY inventory_id ASC");
									while ($row = mysqli_fetch_array($result)) {
										$value = $row['item_name'];

										echo "<option>$value</option>";
									
									
										
									}

								?>
                        </select>
                </div>
            </div>
                
            <div class="form-group">                          
                <div class="col-sm-4">
                    <input type="number" class="form-control input-lg" name="qty" placeholder="Required Quantity"  required="required">
                </div>
            </div>
            
            <div class="form-group">                          
                <div class="col-sm-4">
					<label >Dimension's</label>
                        <select class="form-control input-lg" name="length" placeholder="" required="required">
							<option></option>
								<?php

									$result = mysqli_query($link, "SELECT * FROM dimensions ORDER BY id ASC");
										while ($row = mysqli_fetch_array($result)) {
												$value = $row['name'];
												
												

												echo "<option>$value</option>";

											}

								?>
						</select>
				</div>
			</div>
							
			<div class="form-group">                          
                <div class="col-sm-4">
					<label >Width</label>
                        <select class="form-control input-lg" name="size" placeholder="" required="required">
							<option></option>
								<?php

									$result = mysqli_query($link, "SELECT * FROM width ORDER BY id ASC");
										while ($row = mysqli_fetch_array($result)) {
												$value = $row['name'];
												
												

												echo "<option>$value</option>";

											}

								?>
						</select>
				</div>
            </div>
                            

			<div class="form-group">
				<label >&nbsp;</label>
					<div class="col-sm-6">
						<a href="javascript:new_link()"><i class="fa fa-plus"></i> Add More</a>
					</div>
			</div>
					</div>
			</div>

		</div>
		<hr>
		<div id="salesHistory">
			<div align="center">
				<img src="img/loading.gif">
			</div>
		</div>
		<div id="returnsHistory">
			<div align="center">
				<img src="img/loading.gif">
			</div>
		</div>
		<div id="openWorkOrders">
			<div align="center">
				<img src="img/loading.gif">
			</div>
		</div>
		<div id="workOrderHistory">
			<div align="center">
				<img src="img/loading.gif">
			</div>
		</div>
		<div id="notesHistory">
			<div align="center">
				<img src="img/loading.gif">
			</div>
		</div>
		<div id="quotesHistory">
			<div align="center">
				<img src="img/loading.gif">
			</div>
		</div>
	</div>
</div>


<?php 
	

	include "includes/footer.php";

?>

<script>

$(document).ready(function() {	
	loadSalesHistory();
	loadReturnsHistory();
	loadOpenWorkOrders();
	loadWorkOrderHistory();
	loadNotes();
	loadQuotes();

	$('#accordion').on('show.bs.collapse', function () {
    $('#accordion .in').collapse('hide');
	});

	function loadSalesHistory(){
    	var customerId = "<?php echo $id; ?>";
    	$.ajax({
	    	url: "customer_details_sales.php?id="+customerId+"",      
		}).success(function(response) {
			$("#salesHistory").html(response); 		
		});
    }

    function loadReturnsHistory(){
    	var customerId = "<?php echo $id; ?>";
    	$.ajax({
	    	url: "customer_details_returns.php?id="+customerId+"",      
		}).success(function(response) {
			$("#returnsHistory").html(response); 		
		});
    }

    function loadOpenWorkOrders(){
    	var customerId = "<?php echo $id; ?>";
    	$.ajax({
	    	url: "customer_details_open_work_orders.php?id="+customerId+"",      
		}).success(function(response) {
			$("#openWorkOrders").html(response); 		
		});
    }

    function loadWorkOrderHistory(){
    	var customerId = "<?php echo $id; ?>";
    	$.ajax({
	    	url: "customer_details_work_order_history.php?id="+customerId+"",      
		}).success(function(response) {
			$("#workOrderHistory").html(response); 		
		});
	}
	
    function loadNotes(){
    	var customerId = "<?php echo $id; ?>";
    	$.ajax({
	    	url: "customer_details_notes.php?id="+customerId+"",      
		}).success(function(response) {
			$("#notesHistory").html(response); 		
		});
	}
	
	function loadQuotes(){
    	var customerId = "<?php echo $id; ?>";
    	$.ajax({
	    	url: "customer_details_quote.php?id="+customerId+"",      
		}).success(function(response) {
			$("#quotesHistory").html(response); 		
		});
	}




	$("#formSale").submit(function(e)
	{
		var postData = $(this).serializeArray();	   
	    $.ajax(
	    {
	        url : "post.php",
	        type: "POST",
	        data : postData,
	        success : function(response)
	        {
	            $("#response").html(response);
	        	loadSalesHistory();
	        	$('#collapseSale').collapse('toggle');
	        	$("#formSale")[0].reset();
	        }, 	
	    });
	    e.preventDefault(); //STOP default POST action
	});

	$("#formWorkOrder").submit(function(e)
	{
		var postData = $(this).serializeArray();	   
	    $.ajax(
	    {
	        url : "post.php",
	        type: "POST",
	        data : postData,
	        success : function(response)
	        {
	            $("#response").html(response);
	            loadWorkOrderHistory();
	            loadOpenWorkOrders();
	            $('#collapseWorkOrder').collapse('toggle');
	        	$("#formWorkOrder")[0].reset();
	        }, 	
	    });
	    e.preventDefault(); //STOP default POST action
	});

	$("#formNote").submit(function(e)
	{
		var postData = $(this).serializeArray();	   
	    $.ajax(
	    {
	        url : "post.php",
	        type: "POST",
	        data : postData,
	        success : function(response)
	        {
	            $("#response").html(response);
	            loadNotes();
	            $('#collapseNote').collapse('toggle');
	        	$("#formNote")[0].reset();
	        }, 	
	    });
	    e.preventDefault(); //STOP default POST action
	});

	$("#formWorkBoq").submit(function(e)
	{
		var postData = $(this).serializeArray();	   
	    $.ajax(
	    {
	        url : "post.php",
	        type: "POST",
	        data : postData,
	        success : function(response)
	        {
	            $("#response").html(response);
	            loadQuotes();
	            $('#collapseBillQty').collapse('toggle');
	        	$("#formWorkBoq")[0].reset();
	        }, 	
	    });
	    e.preventDefault(); //STOP default POST action
	});

	$("#formQuote").submit(function(e)
	{
		var postData = $(this).serializeArray();	   
	    $.ajax(
	    {
	        url : "post.php",
	        type: "POST",
	        data : postData,
	        success : function(response)
	        {
				$("#response").html(response);
				loadQuotes();
	            $('#collapseQuote').collapse('toggle');
	        	$("#formQuote")[0].reset();
	        }, 	
	    });
	    e.preventDefault(); //STOP default POST action
	});
})
</script>

<script>
	$(document).ready(function() {

		generateSystemNumber();
						
		function generateSystemNumber(){
		$.ajax({
		url: "generate_system_number.php"       
			}).success(function(response) {
		$( "#systemNumber" ).val(response);
		});

		}
	})
</script>

<script type="text/javascript">
		var a = 0;
		var b = 0;
		var c = 0;
		function calc(obj) {
			var e = obj.id.toString();
			if (e == 'quantitytxt') {
				a = Number(obj.value);
				b = Number(document.getElementById('Pricetxt').value);
			} else {
				a = Number(document.getElementById('quantitytxt').value);
				b = Number(obj.value);
			}
			c = a * b;
				document.getElementById('equals').value = c;
				document.getElementById('submit').innerHTML = c;
		}

					
</script>

<script type="text/javascript">
		var b = 0;
		var o = 0;
		var q = 0;
		function boq(obj) {
			var e = obj.id.toString();
			if (e == 'labour_cost') {
				b = Number(obj.value);
				o = Number(document.getElementById('total_cost').value);
			} else {
				b = Number(document.getElementById('labour_cost').value);
				o = Number(obj.value);
			}
			q = b + o;
				document.getElementById('boq_cost').value = q;
				document.getElementById('update_cost').innerHTML = q;
		}

					
</script>

<script type="text/javascript">
					var a = 0;
					var b = 0;
					var c = 0;
					function tots(obj) {
						var e = obj.id.toString();
						if (e == 'txtQty') {
							a = Number(obj.value);
							b = Number(document.getElementById('txtPrice').value);
						} else {
							a = Number(document.getElementById('txtQty').value);
							b = Number(obj.value);
						}
						c = a * b;
						document.getElementById('total').value = c;
						document.getElementById('update').innerHTML = c;
					}

</script>
<script type="text/javascript">
	/*
	This script is identical to the above JavaScript function.
	*/
	var ct = 1;
	function new_link()
	{
	ct++;
	var div1 = document.createElement('div');
	div1.id = ct;
	// link to delete extended form elements
	var delLink = '<div style="text-align:right;margin-right:50%"><a href="javascript:delIt('+ ct +')"><i class="fa fa-trash-alt"></i> Delete</a></div>';
	//var delLink = '<div class="form-group"><label class="col-sm-3 control-label">&nbsp;</label><div class="col-sm-6" style="text-align:right;margin-right:65px"><a href="javascript:delIt('+ ct +')"><i class="fa fa-trash-o"></i> Delete</a></div></div>';
	div1.innerHTML = document.getElementById('newlinktpl').innerHTML + delLink;
	document.getElementById('newlink').appendChild(div1);
	}
	// function to delete the newly added set of elements
	function delIt(eleId)
	{
	d = document;
	var ele = d.getElementById(eleId);
	var parentEle = d.getElementById('newlink');
	parentEle.removeChild(ele);
	}
</script>

<script type="text/javascript">
	/*
	This script is identical to the above JavaScript function.
	*/
	var dt = 1;
	function new_links()
	{
	dt++;
	var div1 = document.createElement('div');
	div1.id = dt;
	// link to delete extended form elements
	var delLink = '<div style="text-align:right;margin-right:40%"><a href="javascript:delIt('+ dt +')"><i class="fa fa-trash-alt"></i> <strong>Delete</strong></a></div>';
	//var delLink = '<div class="form-group"><label class="col-sm-3 control-label">&nbsp;</label><div class="col-sm-6" style="text-align:right;margin-right:65px"><a href="javascript:delIt('+ ct +')"><i class="fa fa-trash-o"></i> Delete</a></div></div>';
	div1.innerHTML = document.getElementById('newlinked').innerHTML + delLink;
	document.getElementById('newlinks').appendChild(div1);
	}
	// function to delete the newly added set of elements
	function delIt(eleId)
	{
	d = document;
	var ele = d.getElementById(eleId);
	var parentEle = d.getElementById('newlinks');
	parentEle.removeChild(ele);
	}
</script>
    