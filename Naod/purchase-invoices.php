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
        <button class="btn btn-primary" onclick="replace_div_content('purchases-invoice-content','items-per-purchases-invoice.php');">Record New Purchases Invoice</button>
    </div>
    <p>
    <div class="row">
        <?php include 'purchase_invoice_list.php'; ?>

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
                alert(data);
            }
        });
    }
</script>
