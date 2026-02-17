<?php
include "connection.php";
session_start();

// පරිශීලකයා ලොගින් වී ඇත්දැයි පරීක්ෂා කිරීම
if (!isset($_SESSION["u"])) {
    // ලොගින් වී නැත්නම් ලොගින් පිටුවට යවන්න
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Buy Products</title>
    <link rel="stylesheet" href="bootstrap.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css" />
    <link rel="stylesheet" href="style.css" />
    <link rel="icon" href="resource/logo.svg" />

    <style>
        body {
            background: linear-gradient(135deg, #fff1eb 0%, #ace0f9 100%);
            min-height: 100vh;
        }

        .section-header {
            color: #333;
            font-weight: 700;
            border-bottom: 2px solid #aaa;
            padding-bottom: 10px;
            margin-bottom: 20px;
            font-size: 1.2rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .section-header i {
            color: #198754;
            font-size: 1.4rem;
        }

        .form-label {
            font-weight: 600;
            color: #555;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #198754;
            box-shadow: 0 0 0 0.25rem rgba(25, 135, 84, 0.25);
        }

        .img-preview {
            border: 2px dashed #198754;
            border-radius: 10px;
            padding: 10px;
            background: #f8f9fa;
            transition: all 0.3s;
        }

        .img-preview:hover {
            background: #e9ecef;
            transform: scale(1.02);
        }

        /* Mobile එකට ගැලපෙන ලෙස Title එක සහ Button එක සකස් කිරීම */
        @media (max-width: 768px) {
            .header-container {
                display: flex;
                flex-direction: column-reverse;
                /* බට්න් එක උඩට ගන්න */
                gap: 15px;
            }

            .back-btn-area {
                position: static !important;
                text-align: center;
            }

            h2 {
                font-size: 1.2rem !important;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row gy-3">

            <div class="col-12 mt-4 header-container position-relative">
                <div class="text-center">
                    <h2 class="fw-bold text-success text-uppercase" style="letter-spacing: 2px;">Purchase information form</h2>
                    <h2 class="fw-bold text-success text-uppercase" style="letter-spacing: 2px;">මිලට ගැනුම් තොරතුරැ පෝරමය</h2>
                </div>

                <div class="back-btn-area position-absolute top-0 end-0 me-lg-4">
                    <a href="home.php" class="text-decoration-none">
                        <button class="btn btn-dark fw-bold btn-sm shadow-sm">
                            <i class="bi bi-arrow-left-circle me-1"></i> Back To Dashboard
                        </button>
                    </a>
                </div>
            </div>
            <div class="col-12 col-lg-10 offset-lg-1">
                <div class="row">

                    <div class="col-12 col-lg-4 border-end border-secondary">
                        <div class="section-header">
                            <i class=""></i> Basic Information
                        </div>



                        <div class="mb-3">
                            <label class="form-label">For credit or cash / ණයට හෝ මුදලට</label>
                            <select class="form-select text-center bg-light" id="pm" onchange="toggleCustomerField();">
                                <option value="0">Select Method</option>

                                <?php
                                // connection.php එකේ $conn variable එක පාවිච්චි කර ඇත
                                $pm_rs = mysqli_query($conn, "SELECT * FROM `payment_method` ");
                                $pm_num = mysqli_num_rows($pm_rs);

                                for ($i = 0; $i < $pm_num; $i++) {
                                    $pm_data = mysqli_fetch_assoc($pm_rs);
                                ?>
                                    <option value="<?php echo $pm_data["id"]; ?>">
                                        <?php echo $pm_data["method_name"]; ?>
                                    </option>
                                <?php
                                }
                                ?>

                            </select>

                            <br>

                            <div class="col-12 mb-3" id="customerField" style="display: none;">
                                <label class="form-label"> person name / පුද්ගලයාගෙ නම</label>
                                <input type="text" class="form-control" id="c_name" />
                            </div>

                        </div>



                        <div class="mb-3">
                            <label class="form-label">Product Brand</label>
                            <select class="form-select text-center bg-light" id="br">
                                <option value="0">Select Brand</option>

                                <?php
                                // connection.php එක දැනටමත් include කර ඇති බව උපකල්පනය කෙරේ
                                // නැත්නම් මෙතනට include "connection.php"; දාන්න

                                $brand_rs = mysqli_query($conn, "SELECT * FROM `brand` ORDER BY `name` ASC");
                                $brand_num = mysqli_num_rows($brand_rs);

                                for ($x = 0; $x < $brand_num; $x++) {
                                    $brand_data = mysqli_fetch_assoc($brand_rs);
                                ?>
                                    <option value="<?php echo $brand_data["id"]; ?>">
                                        <?php echo $brand_data["name"]; ?>
                                    </option>
                                <?php
                                }
                                ?>

                            </select>

                            <div class="input-group mt-2 input-group-sm">
                                <input type="text" class="form-control" placeholder="Add New Brand" id="n_brand" />
                                <button class="btn btn-outline-success" type="button" onclick="addNewBrand();">
                                    <i class="bi bi-plus"></i> Add
                                </button>
                            </div>
                        </div>


                    </div>

                    <div class="col-12 col-lg-8">
                        <div class="section-header">
                            <i class=""></i> Product Details
                        </div>

                        <div class="row">
                            <div class="col-12 mb-3">
                                <label class="form-label">Product Title</label>
                                <input type="text" class="form-control" id="title" />
                            </div>



                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Product Quantity</label>
                                <input type="text" class="form-control" min="Kg/g " value=" " id="qty" />
                            </div>

                            <div class="col-12 col-md-6 mb-3">
                                <label class="form-label">Products Cost</label>
                                <div class="input-group">
                                    <span class="input-group-text">Rs.</span>
                                    <input type="text" class="form-control" id="cost" />
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>

                <hr class="my-4 text-secondary">

                <div class="col-12 col-lg-6">
                    <div class="section-header">
                        <i class=""></i> Product Description
                    </div>
                    <textarea cols="30" rows="8" class="form-control" id="desc"></textarea>
                </div>
            </div>

            <hr class="my-4 text-secondary">

            <div class="row pb-5">
                <div class="col-12 col-lg-4 offset-lg-4 d-grid">
                    <button class="btn btn-success fw-bold btn-lg shadow" onclick="purchaseProduct();">
                        <i class="bi me-2"></i> Buy Product
                    </button>
                </div>
            </div>

        </div>
    </div>



    </div>
    </div>

    <script src="bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>