<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/28/18
 * Time: 3:28 PM
 */
require '../core_resources/connect.inc.php';
$suppierName='';
$documentId = '';
$documentDate = '';
$supplierId = '';
if(isset($_POST['supplierId']) && isset($_POST['documentId'])){
    $documentId = $_POST['documentId'];
    $supplierId = $_POST['supplierId'];

    $supplierNameSql = "SELECT supplier_name FROM suppliers WHERE supplier_id='$supplierId'";
    if($supplierNameSqlRun = mysqli_query($db_conn,$supplierNameSql)){
        $supName = mysqli_fetch_assoc($supplierNameSqlRun);
        $suppierName = $supName['supplier_name'];
    }

    $documentDetailsSql = "SELECT * FROM cash_purchases WHERE receipt_number='$documentId' AND supplier='$supplierId'";

    if($documentDetailsSqlRun = mysqli_query($db_conn,$documentDetailsSql)){
        $docData = mysqli_fetch_assoc($documentDetailsSqlRun);
        $documentDate = $docData['timestamp'];
    }
}
//echo date("m-d-Y", strtotime($documentDate));
 ?>
<style>
    .push-button{
        margin-left: 5%;
        margin-top: 2%;
    }
</style>
<div class="row push-button">
    <button type="button" class="btn btn-primary" onclick="replace_div_content('purchase-receipt-content','purchase-receipts.php');"><-- Back to Purchases Receipts List</button>
</div>
<div class="document-content">

    <div class="row">

        <div class="card content-card">
            <h3>Details of the Supplier</h3>
            <hr>
            <div class="card-body">
                <div class="col-md-6">
                    <label for="receiptName">Name of Supplier: </label>
                    <input type="text" id="receiptName" name="receiptName" list="suppliers" class="form-control" placeholder="Enter Supplier Name" value="<?php echo $suppierName; ?>"/>
                    <datalist id="suppliers">
                        <?php
                        $SuppliersListSql = 'SELECT * FROM suppliers';
                        if($SuppliersListRun = mysqli_query($db_conn,$SuppliersListSql)){
                            while($rs = mysqli_fetch_assoc($SuppliersListRun)){
                                ?>
                                <option value="<?php echo $rs['supplier_name']; ?>"><?php echo $rs['supplier_name']; ?></option>
                                <?php
                            }
                        }
                        ?>
                    </datalist>
                </div>
                <div class="col-md-6">

                    <label for="datetimepicker">Date: </label>
                    <input type="date" id="datetimepicker-2" placeholder="Enter The Date" name="receipt_date" class="form-control" value="<?php echo date("Y-m-d", strtotime($documentDate));?>"/>
                </div>
                <div class="col-md-6">

                    <label for="receiptNo">Receipt No: </label>
                    <input type="text" id="receiptNo" placeholder="Enter The Receipt No" name="receiptNo" class="form-control" value="<?php echo $documentId; ?>"/>
                </div>


            </div>
        </div>

    </div>

    <hr>
    <div class="row">
        <div class="card content-card">

            <div class="card-body">
                <table class="table table-responsive table-bordered" id="purchaseReceiptContent">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Amount</th>
                        <th>Options</th>
                    </tr>
                    </thead>
                    <tbody>

                    <tr>
                        <!--                        <td>1</td>-->
                        <!--                        <td>Tyre</td>-->
                        <!--                        <td>B230</td>-->
                        <!--                        <td>120</td>-->
                        <!--                        <td>240,000</td>-->
                        <!--                        <td>12309000</td>-->
                        <!--                        <td>-->
                        <!--                            <button class="btn btn-info" data-toggle="modal" data-target="#editPurchaseReceiptContent"><i class="fa fa-edit"> Edit</i> </button>-->
                        <!--                            <button class="btn btn-danger"><i class="fa fa-remove" data-toggle="modal" data-target="#deletePurchaseReceiptContent"> Delete</i> </button>-->
                        <!--                        </td>-->
                    </tr>
                    <?php
                    $documentContentSql = "SELECT * FROM purchases_receipt_content WHERE receipt_number='$documentId' AND supplier='$supplierId'";

                    if($documentContentSqlRun = mysqli_query($db_conn, $documentContentSql)){
                        while($docContent = mysqli_fetch_assoc($documentContentSqlRun)){
                            $itemNameSql = "SELECT spare_part FROM spare_parts WHERE part_id='".$docContent['spare_part']."'";

                            if($itemNameSqlRun = mysqli_query($db_conn, $itemNameSql)){
                                $item = mysqli_fetch_assoc($itemNameSqlRun);
                                $itemName = $item['spare_part'];
                            }
                            ?>
                            <tr>
                                <td>&nbsp;</td>
                                <td><input type="text" id="itemName" style="width: 100px;" class="form-control" placeholder="Item Name" list="items-list" value="<?php echo $itemName; ?>" />
                                    <datalist id="items-list">
                                        <?php
                                        $ItemsListSql = 'SELECT * FROM spare_parts';
                                        if($ItemsListRun = mysqli_query($db_conn,$ItemsListSql)){
                                            while($rs = mysqli_fetch_assoc($ItemsListRun)){
                                                ?>
                                                <option value="<?php echo $rs['spare_part']; ?>"><?php echo $rs['spare_part']; ?></option>
                                                <?php
                                            }
                                        }
                                        ?>
                                    </datalist>
                                </td>
                                <td><input type="text" id="itemDescription" style="width: 160px;" class="form-control" placeholder="Example: model, size" value="<?php echo $docContent['description']; ?>" /></td>
                                <td><input type="text" id="itemQuantity" style="width: 60px;" class="form-control" placeholder="Quantity" value="<?php echo $docContent['quantity']; ?>" /></td>
                                <td><input type="number" id="itemPrice" style="width: 100px;" class="form-control" placeholder="Price" value="<?php echo $docContent['price']; ?>" /></td>
                                <td><input type="number" id="itemAmount" style="width: 100px;" class="form-control" placeholder="Amount" value="<?php echo $docContent['amount']; ?>" onblur="addValueToTotal();" /></td>
                                <td>&nbsp;</td>

                            </tr>
                            <?php

                        }
                    }

                    ?>

                    <tr><td>&nbsp;</td>
                        <td><input type="text" id="itemName" style="width: 100px;" class="form-control" placeholder="Item Name" list="items-list" />
                            <datalist id="items-list">
                                <?php
                                $ItemsListSql = 'SELECT * FROM spare_parts';
                                if($ItemsListRun = mysqli_query($db_conn,$ItemsListSql)){
                                    while($rs = mysqli_fetch_assoc($ItemsListRun)){
                                        ?>
                                        <option value="<?php echo $rs['spare_part']; ?>"><?php echo $rs['spare_part']; ?></option>
                                        <?php
                                    }
                                }
                                ?>
                            </datalist>
                        </td>
                        <td><input type="text" id="itemDescription" style="width: 160px;" class="form-control" placeholder="Example: model, size" /></td>
                        <td><input type="text" id="itemQuantity" style="width: 60px;" class="form-control" placeholder="Quantity" /></td>
                        <td><input type="text" id="itemPrice" style="width: 100px;" class="form-control" placeholder="Price" /></td>
                        <td><input type="text" id="itemAmount" style="width: 100px;" class="form-control" placeholder="Amount" onblur="addValueToTotal();" /></td>
                        <td><button type="button" class="btn btn-primary" onclick="addNewPurchaseItem();">Insert Record</button></td>

                    </tr>
                    <tr>
                        <td colspan="7">&nbsp;</td>
                    </tr>

                    <tr>
                        <td>&nbsp;</td>
                        <td colspan="4" align="center"><h3>Total</h3> </td>
                        <td colspan="2" align="right"><h4><div id="Amount">0</div></h4></td>
                    </tr>


                    </tbody>
                </table>

                <button type="button" onclick="printDocument('printable-purchase-receipt');" class="btn btn-danger space-doc-btn">Save Changes</button>

            </div>
        </div>
    </div>
</div>
