<?php

include "config.php";
include "includes/header.php";
include "includes/check_login.php";
include "includes/nav3.php";


$all_products = mysqli_num_rows(mysqli_query($link, "SELECT * FROM inventory ORDER BY inventory_id"));
$low_quantity = mysqli_num_rows(mysqli_query($link, "SELECT * FROM inventory WHERE quantity <= 10 "));

mysqli_query($link, "SELECT item_name,COUNT(*) as count FROM inventory GROUP BY item_name ORDER BY count ASC");
mysqli_query($link, "SELECT item_code,COUNT(*) as count FROM inventory GROUP BY item_code ORDER BY count ASC");


?>

<div class="row latestStuffs">
    <div class="col-sm-4">
        <div class="panel panel-info" style="font-size:150%;">
            <div class="panel-body latestStuffsBody" style="background-color: #ff3333">
                <div class="pull-left"><i class="fa fa-exchange-alt"></i></div>
                <div class="pull-right">
                    <div><?=$low_quantity?></div>
                    <div class="latestStuffsText">Low Quantity</div>
                </div>
            </div>
            <div class="panel-footer text-center" style="color:#ff3333">Number of Low Quantity Items </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="panel panel-info" style="font-size:150%;">
            <div class="panel-body latestStuffsBody" style="background-color: #f0ad4e">
                <div class="pull-left"><i class="fa fa-tasks"></i></div>
                <div class="pull-right">
                    <div><?=$all_products?></div>
                    <div class="latestStuffsText pull-right">Total Transactions</div>
                </div>
            </div>
            <div class="panel-footer text-center" style="color:#f0ad4e">All-time Total Transactions</div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="panel panel-info" style="font-size:150%;">
            <div class="panel-body latestStuffsBody" style="background-color: #337ab7">
                <div class="pull-left"><i class="fa fa-shopping-cart"></i></div>
                <div class="pull-right">
                    <div><?=$all_products?></div>
                    <div class="latestStuffsText pull-right">Items in Stock</div>
                </div>
            </div>
            <div class="panel-footer text-center" style="color:#337ab7">Total Items in Stock</div>
        </div>
    </div>
</div>

<!-- ROW OF SUMMARY -->
<div class="row margin-top-5">
    <div class="col-sm-3">
        <div class="panel panel-hash">
            <div class="panel-heading"><i class="fa fa-cart-plus"></i> HIGH IN DEMAND</div>

            <table class="table table-striped table-responsive table-hover">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty Sold</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="col-sm-3">
        <div class="panel panel-hash">
            <div class="panel-heading"><i class="fa fa-cart-arrow-down"></i> LOW IN DEMAND</div>
            
            <table class="table table-striped table-responsive table-hover">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Qty Sold</th>
                    </tr>
                </thead>
                <tbody>
                <td></td>
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="col-sm-3">
        <div class="panel panel-hash">
            <div class="panel-heading"><i class="fa fa-money"></i> HIGHEST EARNING</div>
            <table class="table table-striped table-responsive table-hover">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Total Earned</th>
                    </tr>
                </thead>
                <tbody>
            
                </tbody>
            </table>

        </div>
    </div>
    
    <div class="col-sm-3">
        <div class="panel panel-hash">
            <div class="panel-heading"><i class="fa fa-money"></i> LOWEST EARNING</div>
            
            <table class="table table-striped table-responsive table-hover">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Total Earned</th>
                    </tr>
                </thead>
                <tbody>
                
                </tbody>
            </table>
        
        </div>
    </div>
</div>
<!-- END OF ROW OF SUMMARY -->


<script src="js/dashboard.js"></script>

<?php include "includes/footer.php"; ?>