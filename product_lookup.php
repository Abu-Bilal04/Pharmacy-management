<?php
include "../include/server.php";

$product = trim($_GET['product'] ?? '');
$quantity = max(1, intval($_GET['quantity'] ?? 1));

// Get latest purchase for price calculation
$purchase = mysqli_query($dbcon, "SELECT * FROM purchases WHERE product = '".mysqli_real_escape_string($dbcon, $product)."' ORDER BY id DESC LIMIT 1");
if ($prop = mysqli_fetch_assoc($purchase)) {
    $price = $prop['price'];
    $pack_qty = $prop['quantity'];
    // Calculate total purchased
    $total_purchased = 0;
    $purchases = mysqli_query($dbcon, "SELECT package, quantity FROM purchases WHERE product = '".mysqli_real_escape_string($dbcon, $product)."'");
    while ($p = mysqli_fetch_assoc($purchases)) {
        $total_purchased += $p['package'] * $p['quantity'];
    }
    // Calculate total sold
    $sold = mysqli_query($dbcon, "SELECT SUM(quantity) as sold FROM sales WHERE product = '".mysqli_real_escape_string($dbcon, $product)."'");
    $sold_row = mysqli_fetch_assoc($sold);
    $total_sold = $sold_row['sold'] ?? 0;
    $stock_left = $total_purchased - $total_sold;

    $ten = 10;
    $left_hand_division = $price / $pack_qty;
    $right_hand_division = $left_hand_division / $ten;
    $unit_price = $left_hand_division + $right_hand_division;
    $total_price = $unit_price * $quantity;

    $available = ($stock_left > 0)
        ? "<span style='color:green'>Available ($stock_left in stock)</span>"
        : "<span style='color:red'>Not Available</span>";

    echo json_encode([
        'available' => $available,
        'price' => "₦ " . number_format($total_price,2),
        'price_raw' => round($total_price, 2) // <-- numeric value, no symbol
    ]);
} else {
    // Product not found, still show price calculation
    $ten = 10;
    $price = 1000; // Default price if not found
    $pack_qty = 1;
    $left_hand_division = $price / $pack_qty;
    $right_hand_division = $left_hand_division / $ten;
    $unit_price = $left_hand_division + $right_hand_division;
    $total_price = $unit_price * $quantity;

    echo json_encode([
        'available' => "<span style='color:red'>Not Available</span>",
        'price' => "₦ " . number_format($total_price,2),
        'price_raw' => round($total_price, 2)
    ]);
}
?>