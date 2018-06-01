
<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/28/18
 * Time: 10:22 AM
 */

require '/opt/lampp/htdocs/Naod-Moses-Co/core_resources/connect.inc.php';
?>

<div id="printable-document">

    <?php
    if(isset($_POST['documentId']) && isset($_POST['supplierId'])) {
        $documentId = $_POST['documentId'];
        $supplierId = $_POST['supplierId'];

        $getDocumentContentSql = "SELECT * FROM purchases_invoice_content WHERE invoice_number='$documentId' AND supplier='$supplierId'";
        if ($getDocumentContentSqlRun = mysqli_query($db_conn, $getDocumentContentSql)) {
            if (mysqli_num_rows($getDocumentContentSqlRun) == 0) {

                ?>

                <?php
            } else {

                ?>
                <table class="table table-responsive table-bordered">
                    <tr>
                        <th>#</th>
                        <th>Item</th>
                        <th>Description</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Amount</th>
                    </tr>
                    <?php
                    $counter = 0;
                    while ($rs = mysqli_fetch_assoc($getDocumentContentSqlRun)) {

                        ?>
                        <tr>
                            <td><?php echo ++$counter; ?></td>
                            <td><?php
                                $getSpareNameSql = "SELECT spare_part FROM spare_parts WHERE part_id = ".$rs['spare_part'];
                                if($getSpareNameSqlRun = mysqli_query($db_conn, $getSpareNameSql)){
                                    $spareName = mysqli_fetch_assoc($getSpareNameSqlRun);
                                    echo $spareName['spare_part'];
                                }else{
                                    echo mysqli_error($db_conn);
                                }
                                ?></td>
                            <td><?php echo $rs['description']; ?></td>
                            <td><?php echo $rs['quantity']; ?></td>
                            <td><?php echo $rs['price']; ?></td>
                            <td><?php echo $rs['amount']; ?></td>
                        </tr>

                        <?php
                    }
                    ?>
                </table>
                    <?php

            }
        }
    }
    ?>
</div>

<div class="col-md-12 right-text">
    <div class="col-md-3"></div>
    <div class="col-md-4"><button type="button" class="btn btn-danger" onclick="printDocument('printable-document');">Print This Receipt</button></div>
    <div class="col-md-5"></div>
</div>

<script>
    function printDocument(divName){
        //Printing the content
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
