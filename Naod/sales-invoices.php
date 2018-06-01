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

        <div class="col-md-3"><button class="btn btn-primary" onclick="replace_div_content('sales-invoices-content','items-per-sales-invoice.php');">Create New Sales Invoice</button></div>
        <div class="col-md-9 text-center">
            <div class="success_create_div" style="display: none;">Successfully Generated Invoice</div>
            <div class="success_delete_div" style="display: none;">Successfully Deleted Invoice</div>
        </div>
    </div>
    <p>
    <div class="row">
        <div id="sales-invoices-list">
            <?php include 'sales-invoice-list.php'; ?>
        </div>

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
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                $('#sales-invoices-list').load('sales-invoices.php #sales-invoices-list', function() {

                    $('.success_delete_div').finish().fadeIn("fast").delay(3000).fadeOut("slow");
                });
            }
        });
    }
</script>