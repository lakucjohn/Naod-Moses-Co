<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/8/18
 * Time: 5:15 PM
 */
?>
<div id="purchases-invoice-content">

    <div class="row">

        <div class="col-md-3"><button class="btn btn-primary" onclick="replace_div_content('purchases-invoice-content','items-per-purchases-invoice.php');">Record New Purchases Invoice</button></div>
        <div class="col-md-9 text-center">
            <div class="success_create_div" style="display: none;">Successfully Generated Invoice</div>
            <div class="success_delete_div" style="display: none;">Successfully Deleted Invoice</div>
            <div class="success_edit_div" style="display: none;">Successfully Made Changes To Invoice</div>
        </div>
    </div>
    <p>
    <div class="row">
        <div id="purchase-invoices-list">
            <?php include 'purchase_invoice_list.php'; ?>
        </div>

    </div>
</div>

<script>
    function setDeleteDocument(supplier_id,document_id){
        PurchaseInvoiceToDelete.setAttribute('value',document_id);
        SupplyInvoicerToDelete.setAttribute('value',supplier_id);
    }

    function DeleteDocument(){
        var supplier_id = document.getElementById('SupplyInvoicerToDelete').value;
        var document_id = document.getElementById('PurchaseInvoiceToDelete').value;
        $.ajax({
            url:'http://localhost/Naod-Moses-Co/Transaction/Purchase/PurchaseInvoice.php',
            type:'post',
            data:{'action':'deleteDocument','documentId':document_id,'supplierId':supplier_id},
            success: function(data){
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                $('#purchase-invoices-list').load('purchase-invoices.php #purchase-invoices-list', function() {

                    $('.success_delete_div').finish().fadeIn("fast").delay(3000).fadeOut("slow");
                });
            }
        });
    }
</script>
