<?php
/**
 * Created by PhpStorm.
 * User: sbtech
 * Date: 5/19/18
 * Time: 2:23 PM
 */
session_start();
?>

<div class="card header-card">

    <div class="card-body">
        <?php echo '<img src="data:image;base64,'.$_SESSION['logo'].'" class="company-logo" height="150  width="150"/>';?>
    </div>
</div>

<div class="card header-card right-content">

    <div class="card-body">
        <h3 class="card-title"><?php echo $_SESSION['company']; ?></h3>
        <p class="card-text">
            <?php echo $_SESSION['location']; ?> <br>

            Tel: <?php echo $_SESSION['telephone']; ?>.</p>
    </div>
</div>
