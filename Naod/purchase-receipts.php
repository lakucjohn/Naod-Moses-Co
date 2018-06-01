<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/8/18
 * Time: 5:15 PM
 */

?>
<div id="purchase-receipt-content">
    <div class="row">
        <div class="col-md-3"><button class="btn btn-primary" onclick="createPurchaseReceipt()">Record New Cash Purchase Receipt</button></div>
        <div class="col-md-9 text-center">
            <div class="success_create_div" style="display: none;">Successfully Generated Receipt</div>
            <div class="success_delete_div" style="display: none;">Successfully Deleted Receipt</div>
            <div class="success_edit_div" style="display: none;">Successfully Edited Receipt Information</div>
        </div>

    </div>
    <p>
    <div class="row">
        <div id="purchase-receipts-list">
            <?php include 'purchase_receipts_list.php'; ?>
        </div>

    </div>
    </p>
</div>

<script>
    function createPurchaseReceipt(){

        replace_div_content('purchase-receipt-content','items-per-purchase-receipt.php');
    }

    function setPurchaseReceiptDetails(receipt_number, supplier, Amount){
        receiptRecNoEdited.setAttribute('value',receipt_number);
        supplierRecNameEdited.setAttribute('value',supplier);
        receiptRecAmountEdited.setAttribute('value',Amount);
    }

    function editPurchaseReceipt(){
        var editedreceiptrecno = document.getElementById('receiptRecNoEdited').value;
        var editedsupplierrecno = document.getElementById('supplierRecNameEdited').value;
        var editedsupplierreceiptrecamount = document.getElementById('receiptRecAmountEdited').value;

    }

    function setPurchaseReceiptId(purchase_receipt_id){
        purchaseReceiptToDelete.setAttribute('value',purchase_receipt_id);
    }

    function deletePurchaseReceipt(){
        var deletedreceiptno = document.getElementById('purchaseReceiptToDelete');
    }

    function setDeleteDocument(supplier_id,document_id){
        PurchaseReceiptToDelete.setAttribute('value',document_id);
        SupplyReceipterToDelete.setAttribute('value',supplier_id);
    }

    function DeleteDocument(){
        var supplier_id = document.getElementById('SupplyReceipterToDelete').value;
        var document_id = document.getElementById('PurchaseReceiptToDelete').value;
        $.ajax({
            url:'http://localhost/Naod-Moses-Co/Transaction/Purchase/PurchaseReceipt.php',
            type:'post',
            data:{'action':'deleteDocument','documentId':document_id,'supplierId':supplier_id},
            success: function(data){
                $('body').removeClass('modal-open');
                $('.modal-backdrop').remove();
                $('#purchase-receipts-list').load('purchase-receipts.php #purchase-receipts-list', function() {

                    $('.success_delete_div').finish().fadeIn("fast").delay(3000).fadeOut("slow");
                });


            }
        });


    }

</script>