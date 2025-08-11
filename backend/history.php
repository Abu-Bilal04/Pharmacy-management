<?php
include "../include/server.php";
session_start(); // Needed for $_SESSION access

if (!isset($_SESSION['username']) || empty($_SESSION['username'])) {
    header('Location: ../index.php');
    exit();
}

$username = $_SESSION['username'];

// Use prepared statements to avoid SQL injection
$stmt = $dbcon->prepare("SELECT username, email, password FROM admin WHERE username = ? LIMIT 1");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    $username = $row['username'];
    $email = $row['email'];
    $password = $row['password']; // Ideally hashed
} else {
    // Invalid session or user not found
    session_destroy();
    header('Location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <title>Rukayyah Pharmacy</title>
    <!-- iziToast -->
    <link href="../iziToast/css/iziToast.min.css" rel="stylesheet" />
    <script src="../iziToast/js/iziToast.min.js"  type="text/javascript"></script>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Popper -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <!-- Main Styling -->
    <link href="../assets/css/argon-dashboard-tailwind.css?v=1.0.1" rel="stylesheet" />
  </head>
  <style>
    .carousel-slide { display: none; }
  </style>

  <body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">

  <div class="absolute w-full bg-blue-500 dark:hidden min-h-75"></div>
    <!-- sidenav  -->
    <aside class="fixed inset-y-0 flex-wrap items-center justify-between block w-full p-0 my-4 overflow-y-auto antialiased transition-transform duration-200 -translate-x-full bg-white border-0 shadow-xl dark:shadow-none dark:bg-slate-850 max-w-64 ease-nav-brand z-990 xl:ml-6 rounded-2xl xl:left-0 xl:translate-x-0" aria-expanded="false">
      <div class="h-19">
        <i class="absolute top-0 right-0 p-4 opacity-50 cursor-pointer fas fa-times dark:text-white text-slate-400 xl:hidden" sidenav-close></i>
        <a class="block px-8 py-6 m-0 text-sm whitespace-nowrap dark:text-white text-slate-700" href="index.php" >
          <img src="../assets/img/logo-ct-dark.png" class="inline h-full max-w-full transition-all duration-200 dark:hidden ease-nav-brand max-h-8" alt="main_logo" />
          <img src="../assets/img/logo-ct.png" class="hidden h-full max-w-full transition-all duration-200 dark:inline ease-nav-brand max-h-8" alt="main_logo" />
          <span class="ml-1 font-semibold transition-all duration-200 ease-nav-brand">Rukayyah Pharmacy</span>
        </a>
      </div>

      <hr class="h-px mt-0 bg-transparent bg-gradient-to-r from-transparent via-black/40 to-transparent dark:bg-gradient-to-r dark:from-transparent dark:via-white dark:to-transparent" />

      <div class="items-center block w-auto max-h-screen overflow-auto h-sidenav grow basis-full">
        <ul class="flex flex-col pl-0 mb-0">
          <li class="mt-0.5 w-full">
            <a class="py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold text-slate-700 transition-colors" href="index.php">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-tv-2"></i>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Dashboard</span>
            </a>
          </li>

          <li class="mt-0.5 w-full">
            <a class="py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 text-slate-700 transition-colors" href="distributors.php">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-delivery-fast"></i>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Distributors</span>
            </a>
          </li>

          <!-- <li class="mt-0.5 w-full">
            <a class="py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 text-slate-700 transition-colors" href="price_list.php">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-tag"></i>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Price list</span>
            </a>
          </li> -->


           <li class="mt-0.5 w-full">
            <a class="py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 text-slate-700 transition-colors" href="purchases.php">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-cart"></i>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Purchases</span>
            </a>
          </li>

           <li class="mt-0.5 w-full">
            <a class="py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 text-slate-700 transition-colors" href="sales.php">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-money-coins"></i>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Sales</span>
            </a>
          </li>

           <li class="mt-0.5 w-full">
            <a class="py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 text-slate-700 transition-colors" href="expenses.php">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-money-coins"></i>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Expenses</span>
            </a>
          </li>

           <li class="mt-0.5 w-full">
            <a class="py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 text-slate-700 transition-colors" href="things_to_buy.php">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-money-coins"></i>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Things to buy</span>
            </a>
          </li>

           <li class="mt-0.5 w-full">
            <a class="py-2.7 bg-blue-500/13 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 text-slate-700 transition-colors" href="history.php">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                <i class="relative top-0 text-sm leading-normal text-blue-500 ni ni-time-alarm"></i>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">History</span>
            </a>
          </li>

          <li class="w-full mt-4">
            <h6 class="pl-6 ml-2 text-xs font-bold leading-tight uppercase dark:text-white opacity-60">Account pages</h6>
          </li>

          <li class="mt-0.5 w-full">
            <a class=" dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="profile.php">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                <i class="relative top-0 text-sm leading-normal text-slate-700 ni ni-single-02"></i>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Profile</span>
            </a>
          </li>

          <li class="mt-0.5 w-full">
            <a class=" dark:text-white dark:opacity-80 py-2.7 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap px-4 transition-colors" href="logout.php">
              <div class="mr-2 flex h-8 w-8 items-center justify-center rounded-lg bg-center stroke-0 text-center xl:p-2.5">
                <i class="relative top-0 text-sm leading-normal text-orange-500 ni ni-user-run"></i>
              </div>
              <span class="ml-1 duration-300 opacity-100 pointer-events-none ease">Log out</span>
            </a>
          </li>
        </ul>
      </div>

      <div class="mx-4">
        <!-- load phantom colors for card after: -->
        <p class="invisible hidden text-gray-800 text-red-500 text-red-600 text-blue-500 dark:bg-white bg-slate-500 bg-gray-500/30 bg-cyan-500/30 bg-emerald-500/30 bg-orange-500/30 bg-red-500/30 after:bg-gradient-to-tl after:from-zinc-800 after:to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 after:from-blue-700 after:to-cyan-500 after:from-orange-500 after:to-yellow-500 after:from-green-600 after:to-lime-400 after:from-red-600 after:to-orange-600 after:from-slate-600 after:to-slate-300 text-emerald-500 text-cyan-500 text-slate-400"></p>
        <div class="relative flex flex-col min-w-0 break-words bg-transparent border-0 shadow-none rounded-2xl bg-clip-border" sidenav-card>
          <img class="w-1/2 mx-auto" src="../assets/img/illustrations/icon-documentation.svg" alt="sidebar illustrations" />
          <div class="flex-auto w-full p-4 pt-0 text-center">
            <div class="transition-all duration-200 ease-nav-brand">
              <h6 class="mb-0 dark:text-white text-slate-700">Need help?</h6>
              <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Please check our docs</p>
            </div>
          </div>
        </div>
        <a href="docs/documentation.php"  class="inline-block w-full px-8 py-2 mb-4 text-xs font-bold leading-normal text-center text-white capitalize transition-all ease-in rounded-lg shadow-md bg-slate-700 bg-150 hover:shadow-xs hover:-translate-y-px">Documentation</a>
      </div>
    </aside>

    <!-- end sidenav -->

    <main class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68 rounded-xl">
      <!-- Navbar -->
      <nav class="relative flex flex-wrap items-center justify-between px-0 py-2 mx-6 transition-all ease-in shadow-none duration-250 rounded-2xl lg:flex-nowrap lg:justify-start" navbar-main navbar-scroll="false">
        <div class="flex items-center justify-between w-full px-4 py-1 mx-auto flex-wrap-inherit">
          <nav>
            <!-- breadcrumb -->
            <ol class="flex flex-wrap pt-1 mr-12 bg-transparent rounded-lg sm:mr-16">
              <li class="text-sm leading-normal">
                <a class="text-white opacity-50" href="javascript:;">Pages</a>
              </li>
              <li class="text-sm pl-2 capitalize leading-normal text-white before:float-left before:pr-2 before:text-white before:content-['/']" aria-current="page">History</li>
            </ol>
            <h6 class="mb-0 font-bold text-white capitalize">History</h6>
          </nav>

          <div class="flex items-center mt-2 grow sm:mt-0 sm:mr-6 md:mr-0 lg:flex lg:basis-auto">
          
            <ul class="flex flex-row justify-end pl-0 mb-0 list-none md-max:w-full">
             
              <li class="flex items-center pl-4 xl:hidden">
                <a href="javascript:;" class="block p-0 text-sm text-white transition-all ease-nav-brand" sidenav-trigger>
                  <div class="w-4.5 overflow-hidden">
                    <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                    <i class="ease mb-0.75 relative block h-0.5 rounded-sm bg-white transition-all"></i>
                    <i class="ease relative block h-0.5 rounded-sm bg-white transition-all"></i>
                  </div>
                </a>
              </li>

              
            </ul>
          </div>
        </div>
      </nav>


      <!-- cards -->
      <div class="w-full px-6 py-6 mx-auto">

      <small style="color: white;">
        <?php
        function getTotalByType($dbcon, $table, $column, $type) {
            // Use different SUM calculation for purchases table
            if ($table === 'purchases') {
                $sum_field = "SUM(price * package)";
            } else {
                $sum_field = "SUM(price)";
            }

            $query = "SELECT $sum_field AS total 
                      FROM `$table`
                      WHERE LOWER($column) = LOWER('$type')";

            $result = mysqli_query($dbcon, $query);

            if ($result) {
                $row = mysqli_fetch_assoc($result);
                return $row['total'] ?? 0;
            } else {
                return 0;
            }
        }

        // POS totals
        $pos_total  = getTotalByType($dbcon, 'sales', 'payment_type', 'POS')
                    + getTotalByType($dbcon, 'expenses', 'transaction', 'POS')
                    + getTotalByType($dbcon, 'purchases', 'transaction', 'POS');

        // Transfer totals
        $transfer_total  = getTotalByType($dbcon, 'sales', 'payment_type', 'Transfer')
                        + getTotalByType($dbcon, 'expenses', 'transaction', 'Transfer')
                        + getTotalByType($dbcon, 'purchases', 'transaction', 'Transfer');

        // Cash totals
        $cash_total  = getTotalByType($dbcon, 'sales', 'payment_type', 'Cash')
                    + getTotalByType($dbcon, 'expenses', 'transaction', 'Cash')
                    + getTotalByType($dbcon, 'purchases', 'transaction', 'Cash');

        // Display all
        echo "POS: &#8358;" . number_format($pos_total, 2);
        echo " - Transfer: &#8358;" . number_format($transfer_total, 2);
        echo " - Cash: &#8358;" . number_format($cash_total, 2);
        ?>
        </small>

        <br>
        <br>
        <!-- row 1 Today-->
        <div class="flex flex-wrap -mx-3">
          <!-- card1 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Balance</p>
                      <h5 class="mb-2 font-bold dark:text-white">
                        <?php
                          // // Get today's purchases
                          $today = date('Y-m-d');

                          // Total sales (price * quantity)
                          $sales_query = "SELECT SUM(price) AS total_sales FROM sales WHERE DATE(timestamp) = '$today'";
                          $sales_result = mysqli_query($dbcon, $sales_query);
                          $sales_row = mysqli_fetch_assoc($sales_result);
                          $total_sales = $sales_row['total_sales'] ?? 0;

                          // Total purchases (price)
                          $purchases_query = "SELECT SUM(price) AS total_purchases FROM purchases WHERE DATE(timestamp) = '$today'";
                          $purchases_result = mysqli_query($dbcon, $purchases_query);
                          $purchases_row = mysqli_fetch_assoc($purchases_result);
                          $total_purchases = $purchases_row['total_purchases'] ?? 0;

                          // Total expenses (price)
                          $expenses_query = "SELECT SUM(price) AS total_expenses FROM expenses WHERE DATE(timestamp) = '$today'";
                          $expenses_result = mysqli_query($dbcon, $expenses_query);
                          $expenses_row = mysqli_fetch_assoc($expenses_result);
                          $total_expenses = $expenses_row['total_expenses'] ?? 0;

                          // Calculate balance
                          $balance = $total_sales - $total_purchases - $total_expenses;

                          echo "&#8358;" . number_format($balance, 2);
                          ?>
                      </h5>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500">
                      <i class="ni leading-none ni-money-coins text-lg relative top-3.5 text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- card2 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Purchases</p>
                      <h5 class="mb-2 font-bold dark:text-white">
                        <?php
                          // // Get today's purchases
                          $today = date('Y-m-d');

                          // Total purchases (price * quantity)
                          $today_purchases_query = "SELECT SUM(price * package) AS today_total_purchases 
                          FROM purchases 
                          WHERE DATE(timestamp) = '$today'";  // Add quotes and DATE() function
                          $today_purchases_result = mysqli_query($dbcon, $today_purchases_query);
                          $today_purchases_row = mysqli_fetch_assoc($today_purchases_result);
                          $today_total_purchases = $today_purchases_row['today_total_purchases'] ?? 0;

                          // Format with Naira symbol and thousands separator
                          echo "&#8358;" . number_format($today_total_purchases, 2);
                          ?>
                      </h5>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                      <i class="ni leading-none ni-world text-lg relative top-3.5 text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- card3 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Sales</p>
                      <h5 class="mb-2 font-bold dark:text-white">
                        <?php
                          // // Get today's sales
                          $today = date('Y-m-d');

                          // Total sales (price)
                          $today_sales_query = "SELECT SUM(price) AS today_total_sales 
                          FROM sales 
                          WHERE DATE(timestamp) = '$today'";  // Add quotes and DATE() function
                          $today_sales_result = mysqli_query($dbcon, $today_sales_query);
                          $today_sales_row = mysqli_fetch_assoc($today_sales_result);
                          $today_total_sales = $today_sales_row['today_total_sales'] ?? 0;

                          // Format with Naira symbol and thousands separator
                          echo "&#8358;" . number_format($today_total_sales, 2);
                          ?>
                      </h5>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                      <i class="ni leading-none ni-world text-lg relative top-3.5 text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- card4 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Expense</p>
                      <h5 class="mb-2 font-bold dark:text-white">
                        <?php
                          // // Get today's expenses
                          $today = date('Y-m-d');

                          // Total expenses (price * quantity)
                          $today_expenses_query = "SELECT SUM(price) AS today_total_expenses 
                          FROM expenses 
                          WHERE DATE(timestamp) = '$today'";  // Add quotes and DATE() function
                          $today_expenses_result = mysqli_query($dbcon, $today_expenses_query);
                          $today_expenses_row = mysqli_fetch_assoc($today_expenses_result);
                          $today_total_expenses = $today_expenses_row['today_total_expenses'] ?? 0;

                          // Format with Naira symbol and thousands separator
                          echo "&#8358;" . number_format($today_total_expenses, 2);
                          ?>
                      </h5>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                      <i class="ni leading-none ni-world text-lg relative top-3.5 text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>

        <br>
        <!-- row 2 Total -->
        <div class="flex flex-wrap -mx-3">
          <!-- card1 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Total Balance</p>
                      <h5 class="mb-2 font-bold dark:text-white">
                        <?php
                          // Total sales (price * quantity)
                          $sales_query = "SELECT SUM(price) AS total_sales FROM sales";
                          $sales_result = mysqli_query($dbcon, $sales_query);
                          $sales_row = mysqli_fetch_assoc($sales_result);
                          $total_sales = $sales_row['total_sales'] ?? 0;

                          // Total purchases (price)
                          $purchases_query = "SELECT SUM(price) AS total_purchases FROM purchases";
                          $purchases_result = mysqli_query($dbcon, $purchases_query);
                          $purchases_row = mysqli_fetch_assoc($purchases_result);
                          $total_purchases = $purchases_row['total_purchases'] ?? 0;

                          // Total expenses (price)
                          $expenses_query = "SELECT SUM(price) AS total_expenses FROM expenses";
                          $expenses_result = mysqli_query($dbcon, $expenses_query);
                          $expenses_row = mysqli_fetch_assoc($expenses_result);
                          $total_expenses = $expenses_row['total_expenses'] ?? 0;

                          // Calculate balance
                          $balance = $total_sales - $total_purchases - $total_expenses;

                          echo "&#8358;" . number_format($balance,2);
                          ?>
                      </h5>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-blue-500 to-violet-500">
                      <i class="ni leading-none ni-money-coins text-lg relative top-3.5 text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- card2 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Total Purchases</p>
                      <h5 class="mb-2 font-bold dark:text-white">
                        <?php
                          
                          // Total purchases (price * quantity)
                          $today_purchases_query = "SELECT SUM(price * package) AS today_total_purchases 
                          FROM purchases";  // Add quotes and DATE() function
                          $today_purchases_result = mysqli_query($dbcon, $today_purchases_query);
                          $today_purchases_row = mysqli_fetch_assoc($today_purchases_result);
                          $today_total_purchases = $today_purchases_row['today_total_purchases'] ?? 0;

                          // Format with Naira symbol and thousands separator
                          echo "&#8358;" . number_format($today_total_purchases, 2);
                          ?>
                      </h5>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                      <i class="ni leading-none ni-world text-lg relative top-3.5 text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- card3 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Total Sales</p>
                      <h5 class="mb-2 font-bold dark:text-white">
                        <?php
                          // Total sales (price * quantity)
                          $sales_query = "SELECT SUM(price) AS total_sales 
                          FROM sales ";  // Add quotes and DATE() function
                          $sales_result = mysqli_query($dbcon, $sales_query);
                          $sales_row = mysqli_fetch_assoc($sales_result);
                          $total_sales = $sales_row['total_sales'] ?? 0;

                          // Format with Naira symbol and thousands separator
                          echo "&#8358;" . number_format($total_sales, 2);
                          ?>
                      </h5>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                      <i class="ni leading-none ni-world text-lg relative top-3.5 text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- card4 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Total Expenses</p>
                      <h5 class="mb-2 font-bold dark:text-white">
                        <?php
                          // Total expenses (price * quantity)
                          $today_expenses_query = "SELECT SUM(price) AS today_total_expenses 
                          FROM expenses";
                          $today_expenses_result = mysqli_query($dbcon, $today_expenses_query);
                          $today_expenses_row = mysqli_fetch_assoc($today_expenses_result);
                          $today_total_expenses = $today_expenses_row['today_total_expenses'] ?? 0;

                          // Format with Naira symbol and thousands separator
                          echo "&#8358;" . number_format($today_total_expenses, 2);
                          ?>
                      </h5>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-red-600 to-orange-600">
                      <i class="ni leading-none ni-world text-lg relative top-3.5 text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          
        </div>

        

        <?php include '../include/footer.php'; ?>
      </div>
      <!-- end cards -->
    </main>
 
  </body>
  <!-- plugin for charts  -->
  <script src="../assets/js/plugins/chartjs.min.js" async></script>
  <!-- plugin for scrollbar  -->
  <script src="../assets/js/plugins/perfect-scrollbar.min.js" async></script>
  <!-- main script file  -->
  <script src="../assets/js/argon-dashboard-tailwind.js?v=1.0.1" async></script>

</html>
