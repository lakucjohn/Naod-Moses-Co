<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/25/18
 * Time: 2:03 PM
 */
require '../core_resources/connect.inc.php';
$document_list_sql = "SELECT * FROM credit_sales WHERE status=1";
$counter = 0;

?>
<table class="table table-responsive table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Invoice No</th>
        <th>Customer</th>
        <th>Amount</th>
        <th>Date Issued</th>
        <th>Options</th>
    </tr>
    </thead>
    <tbody>

    <?php
    if($sql_run = mysqli_query($db_conn, $document_list_sql)){
        if(mysqli_num_rows($sql_run) !=0){
            $counter = 0;
            while($rs = mysqli_fetch_assoc($sql_run)) {
                ?>
                <tr>
                    <td><?php echo ++$counter; ?></td>
                    <td><?php echo $rs['invoice_number']; ?></td>
                    <td><?php
                        $personSql = "SELECT customer_name FROM customers WHERE customer_number=".$rs['customer'];
                        if($personSqlRun = mysqli_query($db_conn,$personSql)){
                            $name = mysqli_fetch_assoc($personSqlRun);
                            echo $name['customer_name'];
                        }

                        ?></td>
                    <td><?php echo $rs['amount']; ?></td>
                    <td><?php echo $rs['timestamp']; ?></td>
                    <td>
                        <button class="btn btn-info"
                                onclick="loadDocumentData('<?php echo $rs['invoice_number']; ?>');">
                            <i class="fa fa-info-circle"> More</i></button>
<!--                        <button class="btn btn-primary"><i class="fa fa-edit"> Edit</i></button>-->
                        <button class="btn btn-danger" data-toggle="modal" data-target="#deleteSaleInvoice" onclick="setDeleteDocument('<?php echo $rs['invoice_number']; ?>');"><i class="fa fa-remove"> Delete</i></button>
                    </td>
                </tr>
                <?php
            }
        }else{

        }
    }
    ?>


    </tbody>
</table>

<div class="modal fade" id="deleteSaleInvoice" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"  style="background-color:#5A9599; color:white;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Confirm Delete Sale Invoice</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-md-12">

                            <h3 class="confirm-txt">Are you sure you want to delete this sale invoice ? </h3>

                        </div>
                    </div>
                    <input type="hidden" id="SalesInvoiceToDelete" />
                    <section class="pull-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button"class="btn btn-danger" onclick="DeleteDocument();">Delete</button>
                    </section>
                </form>

            </div>
        </div><!-- /.modal-content -->
    </div>
</div>
<!-- END MODAL/-->

<script>
    function loadDocumentData(documentId){
        $.ajax({
            url:"items-per-saved-sales-invoice.php",
            type:'post',
            data:{'document':documentId},
            success:function(data){
                $('#sales-invoices-content').load('items-per-saved-sales-invoice.php',{'document':documentId});
            }
        })
    }
</script>