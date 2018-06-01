<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/8/18
 * Time: 5:15 PM
 */
?>
<div id="cash-receipts-content">
<div class="row">

    <div class="col-md-3"><button class="btn btn-primary" onclick="replace_div_content('cash-receipts-content','items-per-sale-receipt.php');">Create New Cash Sale Receipt</button></div>
    <div class="col-md-9 text-center">
        <div class="success_create_div" style="display: none;">Successfully Generated Receipt</div>
        <div class="success_delete_div" style="display: none;">Successfully Deleted Receipt</div>
    </div>
</div>
<p>
<div class="row">
        <div id="cash-sale-receipts-list">
            <?php include 'cash_sale_receipts_list.php'; ?>
        </div>

</div>
</div>

<script>
    function setDeleteDocument(document_id){
        CashSaleToDelete.setAttribute('value',document_id);
    }

    function DeleteDocument(){
        var document_id = document.getElementById('CashSaleToDelete').value;
        $.ajax({
            url:'http://localhost/Naod-Moses-Co/Transaction/Sale/SaleReceipt.php',
            type:'post',
            data:{'action':'deleteDocument','documentId':document_id},
            success: function(data){
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                $('#cash-sale-receipts-list').load('cash-receipts.php #cash-sale-receipts-list', function() {

                    $('.success_delete_div').finish().fadeIn("fast").delay(3000).fadeOut("slow");
                });
            }
        });
    }
</script>