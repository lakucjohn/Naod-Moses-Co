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
$supplierId ='';
$documentDate = '';
$documentLPO = '';
if(isset($_POST['supplierId']) && isset($_POST['documentId'])){
    $documentId = $_POST['documentId'];
    $supplierId = $_POST['supplierId'];

    $supplierNameSql = "SELECT supplier_name FROM suppliers WHERE supplier_id='$supplierId'";
    if($supplierNameSqlRun = mysqli_query($db_conn,$supplierNameSql)){
        $supName = mysqli_fetch_assoc($supplierNameSqlRun);
        $suppierName = $supName['supplier_name'];
    }

    $documentDetailsSql = "SELECT * FROM credit_purchases WHERE invoice_number='$documentId' AND supplier='$supplierId'";

    if($documentDetailsSqlRun = mysqli_query($db_conn,$documentDetailsSql)){
        $docData = mysqli_fetch_assoc($documentDetailsSqlRun);
        $documentDate = $docData['date_received'];
        $documentLPO = $docData['lpo_number'];
    }
}
//echo date("m/d/Y", strtotime($documentDate));
?>
<style>
    .push-button{
        margin-left: 5%;
        margin-top: 2%;
    }
</style>
<div id="purchases-invoice-content">



    <div class="row push-button">
        <button type="button" class="btn btn-primary" onclick="replace_div_content('purchases-invoice-content','purchase-invoices.php');"><-- Back to Purchases Invoice List</button>
    </div>
    <div class="document-content">

        <div class="row" style="margin-top: 2%;">
            <div class="row" style="margin-left: 2rem;">
                <div class="col-md-2">
                    <label for="InvoiceName">Name of Supplier: </label>
                </div>
                <div class="col-md-4">
                    <input type="text" id="InvoiceName" name="InvoiceName" list="suppliers" class="form-control" value="<?php echo $suppierName; ?>" placeholder="Enter Supplier Name"/>
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
            </div>

            <div class="row" style="margin-left: 2rem;">
                <div class="card header-card">
                    <div class="card-body">
                        <div class="card-body">

                            <div class="row">

                                <div class="col-md-4">
                                    <label for="InvoiceDate">Date: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="date" id="InvoiceDate" class="form-control" value="<?php echo $documentDate; ?>" />
                                </div>

                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="InvoiceNumber">Invoice Number: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="number" id="InvoiceNumber" class="form-control" value="<?php echo $documentId; ?>" />
                                </div>

                            </div>
                            <br/>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for="LPONo">LPO No: </label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" id="LPONo" class="form-control" value="<?php echo $documentLPO; ?>" />
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="card content-card">
                <div class="card-body">
                    <table class="table table-responsive table-bordered" id="purchaseInvoiceContent">
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

                        <tr style="display: none;">
                            <!--                            <td>1</td>-->
                            <!--                            <td>Tyre</td>-->
                            <!--                            <td>B230</td>-->
                            <!--                            <td>120</td>-->
                            <!--                            <td>240,000</td>-->
                            <!--                            <td>12309000</td>-->
                            <!--                            <td>-->
                            <!--                                <button class="btn btn-info" data-toggle="modal" data-target="#editPurchaseReceiptContent"><i class="fa fa-edit"> Edit</i> </button>-->
                            <!--                                <button class="btn btn-danger"><i class="fa fa-remove" data-toggle="modal" data-target="#deletePurchaseReceiptContent"> Delete</i> </button>-->
                            <!--                            </td>-->
                        </tr>

                        <?php
                            $documentContentSql = "SELECT * FROM purchases_invoice_content WHERE invoice_number='$documentId' AND supplier='$supplierId'";

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
                        <tr>
                            <td>&nbsp;</td>
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
                            <td><input type="number" id="itemPrice" style="width: 100px;" class="form-control" placeholder="Price" /></td>
                            <td><input type="number" id="itemAmount" style="width: 100px;" class="form-control" placeholder="Amount" onblur="addValueToTotal();" /></td>
                            <td><button type="button" class="btn btn-primary" onclick="addNewPurchaseInvoice();">Insert Record</button></td>

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

                    <button type="button" onclick="printDocument('printable-purchase-invoice');" class="btn btn-danger space-doc-btn">Save Changes</button>

                </div>
            </div>
        </div>
    </div>

</div>
