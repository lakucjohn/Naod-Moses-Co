<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/25/18
 * Time: 2:14 PM
 */
require '../core_resources/connect.inc.php';
$document_list_sql = "SELECT * FROM credit_purchases WHERE status=1";
$counter = 0;

?>
<table class="table table-responsive table-bordered">
    <thead>
    <tr>
        <th>#</th>
        <th>Invoice No</th>
        <th>Supplier</th>
        <th>Amount</th>
        <th>Date Received</th>
        <th>Timestamp</th>
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
                        $personSql = "SELECT supplier_name FROM suppliers WHERE supplier_id=".$rs['supplier'];
                        if($personSqlRun = mysqli_query($db_conn,$personSql)){
                            $name = mysqli_fetch_assoc($personSqlRun);
                            echo $name['supplier_name'];
                        }
                        ?></td>
                    <td><?php echo $rs['amount']; ?></td>
                    <td><?php echo $rs['date_received']; ?></td>
                    <td><?php echo $rs['timestamp']; ?></td>
                    <td>
                        <button class="btn btn-info"
                                onclick="loadPurchaseInvoiceData('<?php echo $rs['supplier']; ?>','<?php echo $rs['invoice_number']; ?>');">
                            <i class="fa fa-info-circle"> More</i></button>
                        <button class="btn btn-primary" onclick="editPurchaseInvoiceDetails();"><i class="fa fa-edit"> Edit</i></button>
                        <button class="btn btn-danger" data-toggle="modal" data-target="#deletePurchaseInvoice" onclick="setDeleteDocument('<?php echo $rs['supplier']; ?>','<?php echo $rs['invoice_number']; ?>');"><i class="fa fa-remove"> Delete</i></button>
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

<div class="modal fade" id="deletePurchaseInvoice" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header"  style="background-color:#5A9599; color:white;">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times</button>
                <h4 class="modal-title"><i class="fa fa-plus-circle"></i> Confirm Delete Purchase Invoice</h4>
            </div>
            <div class="modal-body">
                <form role="form" action="" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                        <div class="col-md-12">

                            <h3 class="confirm-txt">Are you sure you want to delete this purchase invoice ? </h3>

                        </div>
                    </div>
                    <input type="hidden" id="PurchaseInvoiceToDelete" />
                    <input type="hidden" id="SupplyInvoicerToDelete" />
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
    function loadPurchaseInvoiceData(supplierId, documentId){
        Data = {'supplierId':supplierId,'documentId':documentId};
        $.ajax({
            url:"http://localhost/Naod-Moses-Co/Naod/items-per-saved-purchases-invoice.php",
            type:'post',
            data:Data,
            success: function(data){
                $('#purchases-invoice-content').load('items-per-saved-purchases-invoice.php',Data);
            }
        });
    }

    function setEditDocument(){

    }
</script>