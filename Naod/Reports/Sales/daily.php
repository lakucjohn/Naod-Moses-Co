<style>
    .danger-txt{
        color:red;
    }
    .success-txt{
        color:green;
    }
</style>
<?php
require '/opt/lampp/htdocs/Naod-Moses-Co/core_resources/connect.inc.php';

$cashTransactionTodaySql = "SELECT * FROM cash_sales WHERE DATE(timestamp) = CURDATE()";
$creditTransactionTodaySql = "SELECT * FROM credit_sales WHERE DATE(timestamp) = CURDATE()";

?>

<p>&nbsp</p>
<h3>Daily Sales Report</h3>
<div class="row">
    <div class="col-md-3">
        <select id="daySalesView" class="form-control">
            <option value="">Select Filter</option>
            <option value="all">Cleared</option>
            <option value="cleared">Cleared</option>
            <option value="uncleared">Uncleared</option>
        </select>
    </div>
</div>
<p>&nbsp;</p>
<div class="container">
    <div class="row">
        <?php
        if($cashTransactionTodaySqlRun = mysqli_query($db_conn, $cashTransactionTodaySql)){

            ?>
            <table class="table table-responsive table-bordered">
                <thead>
                <tr>
                    <th>#</th>
                    <th>Receipt No</th>
                    <th>Customer</th>
                    <th>Transaction Type</th>
                    <th>Amount</th>
                    <th>Timestamp</th>
                </tr>
                </thead>
                <tbody>
        <?php
        $counter = 0;
            while($rs = mysqli_fetch_assoc($cashTransactionTodaySqlRun)){

                ?>
                <tr class="success">
                    <td><?php echo ++$counter; ?></td>
                    <td><?php echo $rs['receipt_number']; ?></td>
                    <td><?php
                        $customerId = $rs['customer'];
                        $customerNameSql = "SELECT customer_name FROM customers WHERE customer_number='$customerId'";
                        if($customerNameSqlRun = mysqli_query($db_conn,$customerNameSql)){
                            $customer = mysqli_fetch_assoc($customerNameSqlRun);
                            echo $customer['customer_name'];
                        }
                        ?>
                        </td>
                    <td class="success-txt">cash</td>
                    <td><?php echo $rs['amount']; ?></td>
                    <td><?php echo $rs['timestamp']; ?></td>
                </tr>
        <?php
            }
        }
        if($creditTransactionTodaySqlRun = mysqli_query($db_conn, $creditTransactionTodaySql)){
            while($rs = mysqli_fetch_assoc($creditTransactionTodaySqlRun)){

                ?>
                <tr class="danger">
                    <td><?php echo ++$counter; ?></td>
                    <td><?php echo $rs['invoice_number']; ?></td>
                    <td><?php
                        $customerId = $rs['customer'];
                        $customerNameSql = "SELECT customer_name FROM customers WHERE customer_number='$customerId'";
                        if($customerNameSqlRun = mysqli_query($db_conn,$customerNameSql)){
                            $customer = mysqli_fetch_assoc($customerNameSqlRun);
                            echo $customer['customer_name'];
                        }
                        ?>
                    </td>
                    <td class="danger-txt">credit</td>
                    <td><?php echo $rs['amount']; ?></td>
                    <td><?php echo $rs['timestamp']; ?></td>
                </tr>
                <?php
            }
        }
        ?>


            </tbody>
        </table>
    </div>
</div>
