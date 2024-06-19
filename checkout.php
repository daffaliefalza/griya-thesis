<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}


date_default_timezone_set('Asia/Jakarta');

include 'server/connection.php';

function generateOrderNumber()
{
    return 'ORD' . mt_rand(100000, 999999) . time();
}

// Fetch cart items for the current user
$user_id = $_SESSION['user_id'];

$select_user = mysqli_query($conn, "SELECT fullname, phone_number, email FROM users WHERE id_users = '$user_id'");

while ($select = mysqli_fetch_assoc($select_user)) {
    $_SESSION['fullname'] = $select['fullname'];
    $_SESSION['phone'] = $select['phone_number'];
    $_SESSION['user_email'] = $select['email'];
}

$select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE id_users = '$user_id'");
$total = 0;

$product_details = array();

if (mysqli_num_rows($select_cart) > 0) {
    while ($fetch_cart = mysqli_fetch_assoc($select_cart)) {
        $total_price = $fetch_cart['price'] * $fetch_cart['quantity'];
        $total += $total_price;

        // naro data ke array product details
        $product_details[] = array(
            'name' => $fetch_cart['product_name'],
            'quantity' => $fetch_cart['quantity'],
            'total_price' => $total_price
        );
    }
}


if ($total > 0 && isset($_POST['order_btn'])) {
    $detail_address = $_POST['detail_address'];
    $totalberat = $_POST['total_berat'];
    $provinsi = $_POST['provinsi'];
    $distrik = $_POST['distrik'];
    $tipe = $_POST['tipe'];
    $kodepos = $_POST['kodepos'];
    $ekspedisi = $_POST['ekspedisi'];
    $paket = $_POST['paket'];
    $ongkir = $_POST['ongkir'];
    $estimasi = $_POST['estimasi'];

    $total_dengan_ongkir = $total + $ongkir;

    // Generate unique order number
    $order_number = generateOrderNumber();

    // Get current timestamp                            
    $order_date = date('Y-m-d H:i:s');

    // logic expired 1 hari setelahnya
    $payment_expiry = date('Y-m-d H:i:s', strtotime($order_date . ' +1 day'));

    // Insert delivery details into delivery table
    $insert_delivery_query = "INSERT INTO delivery (weight, province, district, type, detail_address, postal_code, expedition, packet, shipping, estimation) VALUES ('$totalberat', '$provinsi', '$distrik', '$tipe', '$detail_address', '$kodepos', '$ekspedisi', '$paket', '$ongkir', '$estimasi')";
    if (mysqli_query($conn, $insert_delivery_query)) {
        // Get the last inserted delivery ID
        $delivery_id = mysqli_insert_id($conn);

        // Insert order into orders table with order creation timestamp and payment expiry
        $insert_order_query = "INSERT INTO orders (order_number, id_users, id_delivery, total_price, order_date, payment_expiry) VALUES ('$order_number', '$user_id', '$delivery_id', '$total_dengan_ongkir', '$order_date', '$payment_expiry')";

        if (mysqli_query($conn, $insert_order_query)) {
            // Get the last inserted order ID
            $order_id = mysqli_insert_id($conn);

            // Insert items into order_items table
            foreach ($product_details as $product) {
                $product_name = $product['name'];
                $quantity = $product['quantity'];
                $total_price = $product['total_price']; // Individual total price for each product
                $insert_item_query = "INSERT INTO order_items (order_id, product_name, quantity, total_price) VALUES ('$order_id', '$product_name', '$quantity', $total_price)";
                if (!mysqli_query($conn, $insert_item_query)) {
                    echo "Error inserting item: " . mysqli_error($conn);
                    exit();
                }
            }

            // Clear cart for the current user
            mysqli_query($conn, "DELETE FROM `cart` WHERE id_users = '$user_id'");

            // Redirect to checkout history or any other page
            echo "<script>alert('Pemesanan Berhasil'); window.location.href = 'checkout_history.php';</script>";

            exit();
        } else {
            // Error occurred while inserting order
            echo "Error inserting order: " . mysqli_error($conn);
        }
    } else {
        // Error occurred while inserting delivery details
        echo "Error inserting delivery details: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>

    <link rel="stylesheet" href="css/default.css">
    <link rel="stylesheet" href="css/checkouts.css">
    <script src="js/jquery.min.js"></script>


    <style>
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            color: #22afff;
        }

        .back {
            display: inline-block;
            text-decoration: none;
            font-size: 20px;
            color: #fff !important;
            margin-left: 15px;
            margin-top: 10px;
            background-color: #007bff;
            border-radius: 50%;

            padding: 5px 10px;
        }

        .back:hover {
            text-decoration: underline;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }

        th,
        td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        th {
            text-align: left;
        }

        form {
            margin-bottom: 30px;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>

</head>

<body>

    <a href="cart.php" style="text-decoration: none;" class="back">
        ⬅
    </a>

    <div class="container">
        <h1>Form Pemesanan</h1>
        <?php if (empty($product_details)) : ?>
            <p>Cart belanja anda kosong, <a href="produk.php">silahkan belanja</a></p>
        <?php else : ?>
            <table>
                <thead>
                    <th>No</th>
                    <th>Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Sub harga</th>
                </thead>
                <tbody>
                    <?php
                    $counter = 1; // Initialize a counter variable
                    foreach ($product_details as $product) {
                        echo "<tr>";
                        echo "<td>" . $counter++ . "</td>"; // Display product number
                        echo "<td>" . $product['name'] . "</td>"; // Display product name
                        echo "<td>Rp " . number_format($product['total_price'] / $product['quantity'], 0, ',', '.') . "</td>"; // Display price per unit
                        echo "<td>" . $product['quantity'] . "</td>"; // Display quantity
                        echo "<td>Rp " . number_format($product['total_price'], 0, ',', '.') . "</td>"; // Display total price
                        echo "</tr>";
                    }
                    ?>
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="4" style="text-align: right;"><strong>Total Harga:</strong></td>
                        <td><strong>Rp <?php echo number_format($total, 0, ',', '.'); ?></strong></td>
                    </tr>
                </tfoot>
            </table>
        <?php endif; ?>

        <form action="" method="post">



            <input type="text" name="fullname" readonly value="<?php echo $_SESSION['fullname']   ?>" style=" background-color: #f2f2f8; 
                border: 1px solid #ddd; 
                color: #555; 
                cursor: not-allowed; ">

            <input type="email" placeholder="Masukkan Alamat Email.." name="email" readonly required value="<?php echo $_SESSION['user_email'] ?>" style=" background-color: #f2f2f8; 
                border: 1px solid #ddd; 
                color: #555; 
                cursor: not-allowed; ">

            <div class="phone-wrappe">
                <h4 style="margin-top: 10px;">No. Telepon</h4>
                <input type="number" value="<?php echo $_SESSION['phone'] ?>" name="phone_number" required readonly style=" background-color: #f2f2f8; 
                border: 1px solid #ddd; 
                color: #555; 
                cursor: not-allowed; ">
            </div>


            <div class="alamat-wrapper">
                <h4>Alamat Lengkap Pengiriman</h4>
                <textarea name="detail_address" id="" cols="30" rows="10" placeholder="Masukkan alamat lengkap pengiriman" required></textarea>
            </div>

            <div class="province-wrapper">
                <h4>Provinsi</h4>
                <select name="nama_provinsi" id="" required>

                </select>
            </div>

            <div class="district-wrapper">
                <h4>Distrik</h4>
                <select name="nama_distrik" id="" required>

                </select>
            </div>

            <div class="expedition-wrapper">
                <h4>Ekspedisi</h4>
                <select name="nama_ekspedisi" id="" class="form-control" required>

                </select>
            </div>

            <div class="paket-wrapper">
                <h4>Paket</h4>
                <select name="nama_paket" id="" class="form-control" required>

                </select>
            </div>

            <?php $totalberat = 0; ?>
            <div class="selected-data">
                <input type="hidden" name="total_berat" value="1000">
                <input type="hidden" name="provinsi">
                <input type="hidden" name="distrik">
                <input type="hidden" name="tipe">
                <input type="hidden" name="kodepos">
                <input type="hidden" name="ekspedisi">
                <input type="hidden" name="paket">
                <input type="hidden" name="ongkir">
                <input type="hidden" name="estimasi">
            </div>


            <button type="submit" name="order_btn">Checkout</button>
        </form>

    </div>

    <script>
        $(document).ready(function() {
            $.ajax({
                type: 'post',
                url: 'dataprovinsi.php',
                success: function(hasil_provinsi) {
                    $("select[name=nama_provinsi]").html(hasil_provinsi);
                }
            });

            $("select[name=nama_provinsi]").on("change", function() {
                // Ambil id_provinsi ynag dipilih (dari atribut pribadi)
                var id_provinsi_terpilih = $("option:selected", this).attr("id_provinsi");
                $.ajax({
                    type: 'post',
                    url: 'datadistrik.php',
                    data: 'id_provinsi=' + id_provinsi_terpilih,
                    success: function(hasil_distrik) {
                        $("select[name=nama_distrik]").html(hasil_distrik);
                    }
                })
            });

            $.ajax({
                type: 'post',
                url: 'jasaekspedisi.php',
                success: function(hasil_ekspedisi) {
                    $("select[name=nama_ekspedisi]").html(hasil_ekspedisi);
                }
            });

            $("select[name=nama_ekspedisi]").on("change", function() {
                // Mendapatkan data ongkos kirim

                // Mendapatkan ekspedisi yang dipilih
                var ekspedisi_terpilih = $("select[name=nama_ekspedisi]").val();
                // Mendapatkan id_distrik yang dipilih
                var distrik_terpilih = $("option:selected", "select[name=nama_distrik]").attr("id_distrik");
                // Mendapatkan toatal berat dari inputan
                $total_berat = $("input[name=total_berat]").val();
                $.ajax({
                    type: 'post',
                    url: 'datapaket.php',
                    data: 'ekspedisi=' + ekspedisi_terpilih + '&distrik=' + distrik_terpilih + '&berat=' + $total_berat,
                    success: function(hasil_paket) {
                        // console.log(hasil_paket);
                        $("select[name=nama_paket]").html(hasil_paket);

                        // Meletakkan nama ekspedisi terpilih di input ekspedisi
                        $("input[name=ekspedisi]").val(ekspedisi_terpilih);
                    }
                })
            });

            $("select[name=nama_distrik]").on("change", function() {
                var prov = $("option:selected", this).attr('nama_provinsi');
                var dist = $("option:selected", this).attr('nama_distrik');
                var tipe = $("option:selected", this).attr('tipe_distrik');
                var kodepos = $("option:selected", this).attr('kodepos');

                $("input[name=provinsi]").val(prov);
                $("input[name=distrik]").val(dist);
                $("input[name=tipe]").val(tipe);
                $("input[name=kodepos]").val(kodepos);
            });

            $("select[name=nama_paket]").on("change", function() {
                var paket = $("option:selected", this).attr("paket");
                var ongkir = $("option:selected", this).attr("ongkir");
                var etd = $("option:selected", this).attr("etd");

                $("input[name=paket]").val(paket);
                $("input[name=ongkir]").val(ongkir);
                $("input[name=estimasi]").val(etd);
            })
        });
    </script>


</body>

</html>