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
    <button class="btn btn-primary" onclick="replace_div_content('cash-receipts-content','items-per-sale-receipt.php');">Create New Cash Sale Receipt</button>
</div>
<p>
<div class="row">
    <?php include 'cash_sale_receipts_list.php'; ?>

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
                alert(document_id);
            }
        });
    }
</script>