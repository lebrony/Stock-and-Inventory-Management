<?php

	include "config.php";
	include "includes/header.php"; 
	include "includes/check_login.php";
	include "includes/nav.php";

?>

<div class="panel panel-default">
	<div class="panel-heading">
		<div class="row">
                <div class="col-sm-12">
                    <div class="col-md-2 form-inline form-group-sm">
						<a class="btn btn-primary " href='add_customer.php'><span class="glyphicon glyphicon-plus"></span> New Customers</a>
					</div>
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="customerListPerPage">Show</label>
                        <select id="customerListPerPage" class="form-control">
                            <option value="1">1</option>
                            <option value="5">5</option>
                            <option value="10" selected>10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="30">30</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                        <label for="customerListPerPage">per page</label>
                    </div>
                    <div class="col-sm-4 form-inline form-group-sm">
                        <label for="customerListPerPage" class="control-label">Sort by</label> 
                        <select id="customerListPerPage" class="form-control">
                            <option value="first_name-ASC" selected>Name (A to Z)</option>
                            <option value="first_name-DESC">Name (Z to A)</option>
                            <option value="created_on-ASC">Date Created (older first)</option>
                            <option value="created_on-DESC">Date Created (recent first)</option>
                            <option value="email-ASC">E-mail - ascending</option>
                            <option value="email-DESC">E-mail - descending</option>
                        </select>
                    </div>
                    <div class="col-sm-3 form-inline form-group-sm">
                        <label for="CustomerSearch"><i class="fa fa-search"></i></label>
                        <input type="search" name="q" id="q" placeholder="Search...." class="form-control">
                    </div>
                </div>
            </div>
	</div>
	<div class="panel-body">
		<div id="table"></div>
	</div>
</div>

<?php include "includes/footer.php"; ?>

<script>
  
$(document).ready(function() {
  	checkHash();
	function checkHash(){
			var hash = window.location.hash.substring(1);
			if (hash != ''){
				query(hash);
			}else{
				query('q=');
			}
	}			
		
	$(window).on('hashchange', function() {
		q = window.location.hash.substring(1);
		var qval = urlGetVars("q");
		$("#q").val(qval);
	  	query(q)
	});

	$("#q").keyup(function(){
		var q = $("#q").val();
		q = "q="+q+"";
		window.location.hash = q;
		query(q);	
	});
	
	function query(q){		
		$.ajax({
		    url: "customers_ajax.php?"+q+"",      
		}).success(function(response) {
		    $("#table").html(response);
		    ajaxresponse();
		});
	}

	function deleteId(id){	
		id = id.split("_");
	 	id = id[1];		
		$.ajax({
	    	url: "post.php?delete_customer="+id+"",       
		}).success(function(response) {
	 		$('#tr_'+id).addClass("danger");
	  		$( "#tr_"+id ).fadeOut( "slow", function() {
	  			urlVars = urlGetVars();
			 	window.location.hash = urlVars;
			 	checkHash();	
			});
		});
	}

	function ajaxresponse(){
		$( '[id^="p_"]' ).click(function() {
			var pid = this.id;
		 	pid = pid.split("_");
		 	pid = pid[1];
			var q = $("#q").val();
			q = "q="+q+"&p="+pid;
			window.location.hash = q;
			query(q);
		}); 

		$( '[id^="del_"]' ).click(function() {
			var id = this.id;
			id = "delete="+id+"";
			deleteId(id);
		}); 	
	}

	function urlGetVars(varName){
		var hash = window.location.hash.substring(1);
		if(varName == undefined) {
			return hash;
		}
		hashes = hash.split("&");
		var len = hashes.length;
		var vars = [];
		for (var i = 0; i < len; i++){
			hashVar = hashes[i].split("=");
			if (hashVar[0] == varName){
				return hashVar[1];
			}      	
		}	
	}

});

$("#adminListSortBy, #adminListPerPage").change(function(){
        displayFlashMsg("Please wait...", spinnerClass, "", "");
        laad_();
    });

	function laad_(url){
		var orderBy = $("#adminListSortBy").val().split("-")[0];
		var orderFormat = $("#adminListSortBy").val().split("-")[1];
		var limit = $("#adminListPerPage").val();
		
		$.ajax({
			type:'get',
			url: url ? url : appRoot+"customers_/laad_/",
			data: {orderBy:orderBy, orderFormat:orderFormat, limit:limit},
		}).done(function(returnedData){
				hideFlashMsg();
				
				$("#allAdmin").html(returnedData.adminTable);
			});
	}
</script> 