<?php
/*
 * Created on Sat Feb 19 2022
 *
 *  Devlan Agency - devlan.co.ke 
 *
 * hello@devlan.co.ke
 *
 *
 * The Devlan End User License Agreement
 *
 * Copyright (c) 2022 Devlan Agency
 *
 * 1. GRANT OF LICENSE
 * Devlan Agency hereby grants to you (an individual) the revocable, personal, non-exclusive, and nontransferable right to
 * install and activate this system on two separated computers solely for your personal and non-commercial use,
 * unless you have purchased a commercial license from Devlan Agency. Sharing this Software with other individuals, 
 * or allowing other individuals to view the contents of this Software, is in violation of this license.
 * You may not make the Software available on a network, or in any way provide the Software to multiple users
 * unless you have first purchased at least a multi-user license from Devlan Agency.
 *
 * 2. COPYRIGHT 
 * The Software is owned by Devlan Agency and protected by copyright law and international copyright treaties. 
 * You may not remove or conceal any proprietary notices, labels or marks from the Software.
 *
 * 3. RESTRICTIONS ON USE
 * You may not, and you may not permit others to
 * (a) reverse engineer, decompile, decode, decrypt, disassemble, or in any way derive source code from, the Software;
 * (b) modify, distribute, or create derivative works of the Software;
 * (c) copy (other than one back-up copy), distribute, publicly display, transmit, sell, rent, lease or 
 * otherwise exploit the Software.  
 *
 * 4. TERM
 * This License is effective until terminated. 
 * You may terminate it at any time by destroying the Software, together with all copies thereof.
 * This License will also terminate if you fail to comply with any term or condition of this Agreement.
 * Upon such termination, you agree to destroy the Software, together with all copies thereof.
 *
 * 5. NO OTHER WARRANTIES. 
 * DEVLAN AGENCY  DOES NOT WARRANT THAT THE SOFTWARE IS ERROR FREE. 
 * DEVLAN AGENCY SOFTWARE DISCLAIMS ALL OTHER WARRANTIES WITH RESPECT TO THE SOFTWARE, 
 * EITHER EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO IMPLIED WARRANTIES OF MERCHANTABILITY, 
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT OF THIRD PARTY RIGHTS. 
 * SOME JURISDICTIONS DO NOT ALLOW THE EXCLUSION OF IMPLIED WARRANTIES OR LIMITATIONS
 * ON HOW LONG AN IMPLIED WARRANTY MAY LAST, OR THE EXCLUSION OR LIMITATION OF 
 * INCIDENTAL OR CONSEQUENTIAL DAMAGES,
 * SO THE ABOVE LIMITATIONS OR EXCLUSIONS MAY NOT APPLY TO YOU. 
 * THIS WARRANTY GIVES YOU SPECIFIC LEGAL RIGHTS AND YOU MAY ALSO 
 * HAVE OTHER RIGHTS WHICH VARY FROM JURISDICTION TO JURISDICTION.
 *
 * 6. SEVERABILITY
 * In the event of invalidity of any provision of this license, the parties agree that such invalidity shall not
 * affect the validity of the remaining portions of this license.
 *
 * 7. NO LIABILITY FOR CONSEQUENTIAL DAMAGES IN NO EVENT SHALL DEVLAN AGENCY  OR ITS SUPPLIERS BE LIABLE TO YOU FOR ANY
 * CONSEQUENTIAL, SPECIAL, INCIDENTAL OR INDIRECT DAMAGES OF ANY KIND ARISING OUT OF THE DELIVERY, PERFORMANCE OR 
 * USE OF THE SOFTWARE, EVEN IF DEVLAN HAS BEEN ADVISED OF THE POSSIBILITY OF SUCH DAMAGES
 * IN NO EVENT WILL DEVLAN  LIABILITY FOR ANY CLAIM, WHETHER IN CONTRACT 
 * TORT OR ANY OTHER THEORY OF LIABILITY, EXCEED THE LICENSE FEE PAID BY YOU, IF ANY.
 */
session_start();
require_once 'config/config.php';
require_once 'config/codeGen.php';

/* Add Product */
if (isset($_POST['add_product'])) {
    $product_code = $a . $b;
    $product_name = $_POST['product_name'];
    $product_qty = $_POST['product_qty'];
    $product_desc = $_POST['product_desc'];
    $product_price = $_POST['product_price'];

    /* Persist */
    $sql = "INSERT INTO products (product_name, product_code, product_qty, product_price, product_desc) VALUES(?,?,?,?,?)";
    $prepare = $mysqli->prepare($sql);
    $bind  = $prepare->bind_param(
        'sssss',
        $product_name,
        $product_code,
        $product_qty,
        $product_price,
        $product_desc
    );
    $prepare->execute();
    if ($prepare) {
        $success = "$product_code  $product_name Added";
    } else {
        $err = "Failed!, Please Try Again Later";
    }
}

/* Update Product */
if (isset($_POST['update_product'])) {
    $product_code = $_POST['product_code'];
    $product_name = $_POST['product_name'];
    $product_qty = $_POST['product_qty'];
    $product_desc = $_POST['product_desc'];
    $product_price = $_POST['product_price'];

    /* Persist */
    $sql = "UPDATE products SET product_name =?, product_qty =?, product_price =?,  product_desc =? WHERE product_code =?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param(
        'sssss',
        $product_name,
        $product_qty, 
        $product_price,
        $product_desc,
        $product_code
    );
    $prepare->execute();
    if ($prepare) {
        $success  = "$product_code - $product_name Updated";
    } else {
        $err = "Failed!, Please Try Again";
    }
}

/* Delete Product */
if (isset($_POST['delete_product'])) {
    $product_id = $_POST['product_id'];
    /* Persist */
    $sql = "DELETE FROM products WHERE product_id = ?";
    $prepare = $mysqli->prepare($sql);
    $bind = $prepare->bind_param('s', $product_id);
    $prepare->execute();
    if ($prepare) {
        $success = "Product Deleted";
    } else {
        $err = "Failed!, Please Try Again";
    }
}


/* Load Header Partial */
require_once('partials/head.php');
?>

<body>

    <!-- Navigation Bar-->
    <?php require_once('partials/navbar.php'); ?>
    <!-- End Navigation Bar-->



    <!-- ============================================================== -->
    <!-- Start right Content here -->
    <!-- ============================================================== -->
    <div class="wrapper">
        <div class="container">

            <!-- Page-Title -->
            <div class="row">
                <div class="col-sm-12">
                    <div class="page-title-box">
                        <div class="btn-group float-right m-t-15">
                            <button type="button" data-toggle="modal" data-target="#add_modal" class="btn btn-primary"> Register New Product</button>
                        </div>
                        <h4 class="page-title">Mukure Dairy System Farm Products</h4>
                    </div>
                </div>
            </div>
            <!-- Add User MOdal -->
            <!-- Add Modal -->
            <div class="modal fade fixed-right" id="add_modal" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog  modal-xl" role="document">
                    <div class="modal-content">
                        <div class="modal-header align-items-center">
                            <div class="modal-title">
                                <h6 class="mb-0">Register New Product</h6>
                            </div>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" enctype="multipart/form-data" role="form">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="">Product Name</label>
                                        <input type="text" required name="product_name" class="form-control" id="exampleInputEmail1">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">Product Quantity</label>
                                        <input type="number" required name="product_qty" class="form-control" id="exampleInputEmail1">
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="">Unit Price (KSH)</label>
                                        <input type="number" required name="product_price" class="form-control" id="exampleInputEmail1">
                                    </div>
                                    <div class="form-group col-md-12">
                                        <label for="">Product Details</label>
                                        <textarea type="text" name="product_desc" rows="5" class="form-control" id="exampleInputEmail1"></textarea>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <button type="submit" name="add_product" class="btn btn-primary">Register Product</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12 col-xl-12">
                    <div class="card-box">
                        <table id="dt" class="table table-bordered mb-0">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Qty</th>
                                    <th>Unit Price</th>
                                    <th>Details</th>
                                    <th>Manage</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $ret = "SELECT * FROM products ";
                                $stmt = $mysqli->prepare($ret);
                                $stmt->execute(); //ok
                                $res = $stmt->get_result();
                                while ($products = $res->fetch_object()) {
                                ?>
                                    <tr>
                                        <td>
                                            <?php echo $products->product_code; ?>
                                        </td>
                                        <td>
                                            <?php echo $products->product_name; ?>
                                        </td>
                                        <td>
                                            <?php echo $products->product_qty; ?>
                                        </td>
                                        <td>
                                            Ksh <?php echo number_format($products->product_price, 2); ?>
                                        </td>
                                        <td><?php echo $products->product_desc; ?></td>
                                        <td>
                                            <a data-toggle="modal" href="#update_<?php echo $products->product_id; ?>" class="badge badge-primary"><i class="fa fa-edit"></i> Edit</a>
                                            <a data-toggle="modal" href="#delete_<?php echo $products->product_id; ?>" class="badge badge-danger"><i class="fa fa-trash"></i> Delete</a>
                                        </td>
                                        <!-- Update Modal -->
                                        <div class="modal fade fixed-right" id="update_<?php echo $products->product_id; ?>" tabindex="-1" role="dialog" aria-hidden="true">
                                            <div class="modal-dialog  modal-xl" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header align-items-center">
                                                        <div class="modal-title">
                                                            <h6 class="mb-0">Update <?php echo $products->product_name; ?></h6>
                                                        </div>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" enctype="multipart/form-data" role="form">
                                                            <div class="row">
                                                                <div class="form-group col-md-6">
                                                                    <label for="">Product Name</label>
                                                                    <input type="text" required value="<?php echo $products->product_name; ?>" name="product_name" class="form-control" id="exampleInputEmail1">
                                                                    <input type="hidden" required value="<?php echo $products->product_code; ?>" name="product_code" class="form-control" id="exampleInputEmail1">
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label for="">Product Quantity</label>
                                                                    <input type="number" required value="<?php echo $products->product_qty; ?>" name="product_qty" class="form-control" id="exampleInputEmail1">
                                                                </div>
                                                                <div class="form-group col-md-3">
                                                                    <label for="">Unit Price (KSH)</label>
                                                                    <input type="number" required value="<?php echo $products->product_price; ?>" name="product_price" class="form-control" id="exampleInputEmail1">
                                                                </div>
                                                                <div class="form-group col-md-12">
                                                                    <label for="">Product Details</label>
                                                                    <textarea type="text" name="product_desc" rows="5" class="form-control" id="exampleInputEmail1"><?php echo $products->product_desc; ?></textarea>
                                                                </div>
                                                            </div>
                                                            <div class="text-right">
                                                                <button type="submit" name="update_product" class="btn btn-primary">Update Product</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->

                                        <!-- Delete Modal -->
                                        <div class="modal fade" id="delete_<?php echo $products->product_id; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">CONFIRM DELETE</h5>
                                                        <button type="button" class="close" data-dismiss="modal">
                                                            <span>&times;</span>
                                                        </button>
                                                    </div>
                                                    <form method="POST">
                                                        <div class="modal-body text-center text-danger">
                                                            <h4>Delete <?php echo $products->product_name; ?> </h4>
                                                            <br>
                                                            <!-- Hide This -->
                                                            <input type="hidden" name="product_id" value="<?php echo $products->product_id; ?>">
                                                            <button type="button" class="text-center btn btn-success" data-dismiss="modal">No</button>
                                                            <input type="submit" name="delete_product" value="Delete" class="text-center btn btn-danger">
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                        <!-- End Modal -->
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div><!-- end col-->
            </div>
            <!-- end row -->
        </div> <!-- container -->


        <!-- Footer -->
        <?php require_once('partials/footer.php'); ?>
        <!-- End Footer -->

    </div> <!-- End wrapper -->


    <?php require_once('partials/scripts.php'); ?>

</body>

</html>