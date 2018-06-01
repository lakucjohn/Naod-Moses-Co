<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/8/18
 * Time: 5:15 PM
 */
?>
<div id="sales-invoices-content">
    <div class="row">
    <button class="btn btn-primary" onclick="replace_div_content('sales-invoices-content','items-per-sales-invoice.php');">Create New Sales Invoice</button>
    </div>
    <p>
    <div class="row">
        <?php include 'sales-invoice-list.php'; ?>

    </div>

</div>

<script>
    function setDeleteDocument(document_id){
        SalesInvoiceToDelete.setAttribute('value',document_id);
    }

    function DeleteDocument(){
        var document_id = document.getElementById('SalesInvoiceToDelete').value;
        $.ajax({
            url:'http://localhost/Naod-Moses-Co/Transaction/Sale/SaleInvoice.php',
            type:'post',
            data:{'action':'deleteDocument','documentId':document_id},
            success: function(data){
                alert(document_id);
            }
        });
    }
</script>