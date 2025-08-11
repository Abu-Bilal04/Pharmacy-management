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
.carousel-slide img {
    width: 100%;
    height: 100%;
    object-fit: cover; /* Maintain aspect ratio */
    object-position: center;
}

.carousel-slide.active {
    opacity: 1;
    transform: translateX(0);
}

.carousel-slide.prev {
    transform: translateX(-100%);
}

.carousel-container {
    height: 400px; /* Fixed height */
    min-height: 400px;
    width: 100%;
    position: relative;
    overflow: hidden;
}
.no-records-found {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 2rem;
    text-align: center;
}

.no-records-found img {
    width: 150px;
    height: 150px;
    margin-bottom: 1rem;
    opacity: 0.7;
}
  </style>

  <body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">

<?php
if (isset($_GET['msg']) && $_GET['msg'] === "success") {
    // Safely escape username for JS context
    $safeUsername = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
    ?>
    <script>
        iziToast.success({
            title: '',
            message: 'Welcome back, <?php echo $safeUsername; ?>',
            position: 'topCenter',
            animateInside: true,
        });
    </script>
<?php } ?>


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
            <a class="py-2.7 bg-blue-500/13 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold text-slate-700 transition-colors" href="index.php">
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
            <a class="py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 text-slate-700 transition-colors" href="history.php">
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
              <li class="text-sm pl-2 capitalize leading-normal text-white before:float-left before:pr-2 before:text-white before:content-['/']" aria-current="page">Dashboard</li>
            </ol>
            <h6 class="mb-0 font-bold text-white capitalize">Dashboard</h6>
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
        <!-- row 1 -->
        <div class="flex flex-wrap -mx-3">
          <!-- card1 -->
          <div class="w-full max-w-full px-3 mb-6 sm:w-1/2 sm:flex-none xl:mb-0 xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                  <div>
                    <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Today's Sales</p>
                    <h5 class="mb-2 font-bold dark:text-white">
                      <?php
                        // Get today's date
                        $today = date('Y-m-d');
                        $yesterday = date('Y-m-d', strtotime('-1 day'));

                        // Get today's total sales
                        $today_sales_query = "SELECT SUM(price * quantity) AS total_sales 
                                              FROM sales 
                                              WHERE DATE(timestamp) = '$today'";
                        $today_sales_result = mysqli_query($dbcon, $today_sales_query);
                        $today_sales_row = mysqli_fetch_assoc($today_sales_result);
                        $today_total_sales = $today_sales_row['total_sales'] / 100 ?? 0;

                        // Get yesterday's total sales
                        $yesterday_sales_query = "SELECT SUM(price * quantity) AS total_sales 
                                                  FROM sales 
                                                  WHERE DATE(timestamp) = '$yesterday'";
                        $yesterday_sales_result = mysqli_query($dbcon, $yesterday_sales_query);
                        $yesterday_sales_row = mysqli_fetch_assoc($yesterday_sales_result);
                        $yesterday_total_sales = $yesterday_sales_row['total_sales'] ?? 0;

                        // Format today's sales with Naira symbol
                        echo "&#8358;" . number_format($today_total_sales, 2);
                      ?>
                    </h5>
                    <p class="mb-0 dark:text-white dark:opacity-60">
                      <?php
                        // Calculate percentage change
                        if ($yesterday_total_sales > 0) {
                            $percentage_change = (($today_total_sales - $yesterday_total_sales) / $yesterday_total_sales) * 100;
                        } else {
                            $percentage_change = 0;
                        }

                        // Choose color based on increase or decrease
                        $color_class = $percentage_change >= 0 ? 'text-emerald-500' : 'text-red-500';
                        $sign = $percentage_change >= 0 ? '+' : '';

                        echo "<span class='text-sm font-bold leading-normal $color_class'>{$sign}" . number_format($percentage_change, 2) . "%</span> profit";
                      ?>
                    </p>
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
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Today's Profit</p>
                    <h5 class="mb-2 font-bold dark:text-white">
                      <?php
                        // Get today's sales
                        $today = date('Y-m-d');
                        $sales_query = "SELECT product, price, quantity FROM sales WHERE DATE(timestamp) = '$today'";
                        $sales_result = mysqli_query($dbcon, $sales_query);
                        $total_profit = 0;

                        if ($sales_result && mysqli_num_rows($sales_result) > 0) {
                          while ($row = mysqli_fetch_assoc($sales_result)) {
                            $price = floatval($row['price']);
                            $quantity = intval($row['quantity']);
                            
                            // Calculate profit for each sale using the formula
                            $ten = 1100;
                            $pack_qty = 1;
                            $left_hand_division = $price / $pack_qty;
                            $right_hand_division = $left_hand_division / $ten;
                            $unit_profit = $right_hand_division; // The profit is the right hand division
                            $sale_profit = $unit_profit * $quantity;
                            
                            $total_profit += $sale_profit;
                          }
                        }

                        echo "&#8358;" . number_format($total_profit, 2);
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
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Balance</p>
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

                          echo "&#8358;" . number_format($balance);
                          ?>
                      </h5>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-emerald-500 to-teal-400">
                      <i class="ni leading-none ni-paper-diploma text-lg relative top-3.5 text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <!-- card4 -->
          <div class="w-full max-w-full px-3 sm:w-1/2 sm:flex-none xl:w-1/4">
            <div class="relative flex flex-col min-w-0 break-words bg-white shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="flex-auto p-4">
                <div class="flex flex-row -mx-3">
                  <div class="flex-none w-2/3 max-w-full px-3">
                    <div>
                      <p class="mb-0 font-sans text-sm font-semibold leading-normal uppercase dark:text-white dark:opacity-60">Total Distributors</p>
                      <h5 class="mb-2 font-bold dark:text-white">
                        <?php
                          $sql = "SELECT COUNT(id) AS total FROM distributors";
                          $run = mysqli_query($dbcon,$sql);
                          $total = mysqli_fetch_assoc($run);
                          $distributors = $total['total'];
                          echo $distributors;
                        ?>
                      </h5>
                    </div>
                  </div>
                  <div class="px-3 text-right basis-1/3">
                    <div class="inline-block w-12 h-12 text-center rounded-circle bg-gradient-to-tl from-orange-500 to-yellow-500">
                      <i class="ni leading-none ni-cart text-lg relative top-3.5 text-white"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- cards row 2 -->
        <div class="flex flex-wrap mt-6 -mx-3">
          <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
              <div class="p-4 pb-0 mb-0 rounded-t-4">
                <div class="flex justify-between">
                  <h6 class="mb-2 dark:text-white">Sales by Customers</h6>
                </div>
              </div>
              <div class="overflow-x-auto">
                <table class="items-center w-full mb-4 align-top border-collapse border-gray-200 dark:border-white/40">
                  <tbody>
                    <?php
                        $sales_query = "SELECT product, price, quantity FROM sales ORDER BY id DESC LIMIT 4";
                        $sales_result = mysqli_query($dbcon, $sales_query);
                        if ($sales_result && mysqli_num_rows($sales_result) > 0) {
                          while ($row = mysqli_fetch_assoc($sales_result)) {
                            $product = htmlspecialchars($row['product']);
                            $price = floatval($row['price'] / 100);
                            $quantity = intval($row['quantity']);
                            $cost = $price;
                            echo '<tr>
                              <td class="p-2 align-middle bg-transparent border-b w-3/10 whitespace-nowrap dark:border-white/40">
                                <div class="flex items-center px-2 py-1">
                                  <div class="ml-6">
                                    <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Product:</p>
                                    <h6 class="mb-0 text-sm leading-normal dark:text-white">'.$product.'</h6>
                                  </div>
                                </div>
                              </td>
                              <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <div class="text-center">
                                  <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Price:</p>
                                  <h6 class="mb-0 text-sm leading-normal dark:text-white">'.$price.'</h6>
                                </div>
                              </td>
                              <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <div class="text-center">
                                  <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Quantity:</p>
                                  <h6 class="mb-0 text-sm leading-normal dark:text-white">'.$quantity.'</h6>
                                </div>
                              </td>
                              <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <div class="flex-1 text-center">
                                  <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Total:</p>
                                  <h6 class="mb-0 text-sm leading-normal dark:text-white">'.$price * $quantity.'</h6>
                                </div>
                              </td>
                              
                          </tr>';
                          }
                        } else {
                          echo '<tr>
                                  <td colspan="4" class="p-4">
                                    <div class="no-records-found">
                                      <img src="../assets/img/no-data.png" alt="No records found">
                                      <span class="text-sm text-slate-400">No sales records found</span>
                                    </div>
                                  </td>
                                </tr>';
                        }
                      ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>

          <div class="w-full max-w-full px-3 lg:w-5/12 lg:flex-none">
           <div slider class="carousel-container rounded-2xl">

              <!-- slide 1 -->
              <div class="carousel-slide absolute w-full h-full transition-all duration-500">
                <img class="object-cover h-full" src="../assets/img/carousel-1.jpg" alt="carousel image" />
                <div class="block text-start ml-12 left-0 bottom-0 absolute right-[15%] pt-5 pb-5 text-white">
                  <div class="inline-block w-8 h-8 mb-4 text-center text-black bg-white bg-center rounded-lg fill-current stroke-none">
                    <i class="top-0.75 text-xxs relative text-slate-700 ni ni-camera-compact"></i>
                  </div>
                  <h5 class="mb-1 text-white">Your Health, Our Priority</h5>
                  <p class="dark:opacity-80">Providing quality medicines and trusted health advice since day one.</p>
                </div>
              </div>

              <!-- slide 2 -->
              <div class="carousel-slide absolute w-full h-full transition-all duration-500">
                <img class="object-cover h-full" src="../assets/img/carousel-2.jpg" alt="carousel image" />
                <div class="block text-start ml-12 left-0 bottom-0 absolute right-[15%] pt-5 pb-5 text-white">
                  <div class="inline-block w-8 h-8 mb-4 text-center text-black bg-white bg-center rounded-lg fill-current stroke-none">
                    <i class="top-0.75 text-xxs relative text-slate-700 ni ni-bulb-61"></i>
                  </div>
                  <h5 class="mb-1 text-white">Fast & Reliable Service</h5>
                  <p class="dark:opacity-80">From prescriptions to over-the-counter essentials — we’ve got you covered.</p>
                </div>
              </div>

              <!-- slide 3 -->
              <div class="carousel-slide absolute w-full h-full transition-all duration-500">
                <img class="object-cover h-full" src="../assets/img/carousel-3.jpg" alt="carousel image" />
                <div class="block text-start ml-12 left-0 bottom-0 absolute right-[15%] pt-5 pb-5 text-white">
                  <div class="inline-block w-8 h-8 mb-4 text-center text-black bg-white bg-center rounded-lg fill-current stroke-none">
                    <i class="top-0.75 text-xxs relative text-slate-700 ni ni-trophy"></i>
                  </div>
                  <h5 class="mb-1 text-white">Expert Health Guidance</h5>
                  <p class="dark:opacity-80">Our pharmacists are here to answer your questions and care for your well-being.</p>
                </div>
              </div>

              <!-- Control buttons -->
              <button btn-next class="absolute z-10 w-10 h-10 p-2 text-lg text-white border-none opacity-50 cursor-pointer hover:opacity-100 far fa-chevron-right active:scale-110 top-6 right-4"></button>
              <button btn-prev class="absolute z-10 w-10 h-10 p-2 text-lg text-white border-none opacity-50 cursor-pointer hover:opacity-100 far fa-chevron-left active:scale-110 top-6 right-16"></button>
            </div>
          </div>
        </div>

        <!-- cards row 3 -->

        <div class="flex flex-wrap mt-6 -mx-3">
          <div class="w-full max-w-full px-3 mt-0 mb-6 lg:mb-0 lg:w-7/12 lg:flex-none">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 border-solid shadow-xl dark:bg-slate-850 dark:shadow-dark-xl dark:bg-gray-950 border-black-125 rounded-2xl bg-clip-border">
              <div class="p-4 pb-0 mb-0 rounded-t-4">
                <div class="flex justify-between">
                  <h6 class="mb-2 dark:text-white">Recent Expenses</h6>
                </div>
              </div>
              <div class="overflow-x-auto">
                <table class="items-center w-full mb-4 align-top border-collapse border-gray-200 dark:border-white/40">
                  <tbody>
                    <?php
                        $expenses_query = "SELECT item, price, transaction FROM expenses ORDER BY id DESC LIMIT 3";
                        $expenses_result = mysqli_query($dbcon, $expenses_query);
                        if ($expenses_result && mysqli_num_rows($expenses_result) > 0) {
                          while ($row = mysqli_fetch_assoc($expenses_result)) {
                            $item = htmlspecialchars($row['item']);
                            $price = floatval($row['price']);
                            $transaction = htmlspecialchars($row['transaction']);
                            echo '
                            </tr>
                              <td class="p-2 align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <div class="text-center">
                                  <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Item:</p>
                                  <h6 class="mb-0 text-sm leading-normal dark:text-white">'. $item .'</h6>
                                </div>
                              </td>

                              <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <div class="flex-1 text-center">
                                  <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Price:</p>
                                  <h6 class="mb-0 text-sm leading-normal dark:text-white">'. $price .'</h6>
                                </div>
                              </td>
                              
                              <td class="p-2 text-sm leading-normal align-middle bg-transparent border-b whitespace-nowrap dark:border-white/40">
                                <div class="flex-1 text-center">
                                  <p class="mb-0 text-xs font-semibold leading-tight dark:text-white dark:opacity-60">Transaction:</p>
                                  <h6 class="mb-0 text-sm leading-normal dark:text-white">'. $transaction .'</h6>
                                </div>
                              </td>
                            </tr>';
                          }
                        } else {
                           echo '<tr>
                                  <td colspan="4" class="p-4">
                                    <div class="no-records-found">
                                      <img src="../assets/img/no-data.png" alt="No records found">
                                      <span class="text-sm text-slate-400">No sales records found</span>
                                    </div>
                                  </td>
                                </tr>';
                        }
                      ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
          <div class="w-full max-w-full px-3 mt-0 lg:w-5/12 lg:flex-none">
            <div class="border-black/12.5 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl relative flex min-w-0 flex-col break-words rounded-2xl border-0 border-solid bg-white bg-clip-border">
              <div class="p-4 pb-0 rounded-t-4">
                <h6 class="mb-0 dark:text-white">Distributors</h6>
              </div>
              <div class="flex-auto p-4">
                <ul class="flex flex-col pl-0 mb-0 rounded-lg">
                  <?php
                        $distributors_query = "SELECT company, location FROM distributors ORDER BY id DESC LIMIT 3";
                        $distributors_result = mysqli_query($dbcon, $distributors_query);
                        if ($distributors_result && mysqli_num_rows($distributors_result) > 0) {
                          while ($row = mysqli_fetch_assoc($distributors_result)) {
                            $company = htmlspecialchars($row['company']);
                            $location = htmlspecialchars($row['location']);
                            echo '
                            <li class="relative flex justify-between py-2 pr-4 mb-2 border-0 rounded-t-lg rounded-xl text-inherit">
                              <div class="flex items-center">
                                <div class="inline-block w-8 h-8 mr-4 text-center text-black bg-center shadow-sm fill-current stroke-none bg-gradient-to-tl from-zinc-800 to-zinc-700 dark:bg-gradient-to-tl dark:from-slate-750 dark:to-gray-850 rounded-xl">
                                  <i class="text-white ni ni-mobile-button relative top-0.75 text-xxs"></i>
                                </div>
                                <div class="flex flex-col">
                                  <h6 class="mb-1 text-sm leading-normal text-slate-700 dark:text-white">'. $company .'</h6>
                                  <span class="text-xs leading-tight dark:text-white/80">'. $location .'</span>
                                </div>
                              </div>
                            </li>';
                          }
                        } else {
                          echo '<tr><td colspan="4" class="text-center text-xs text-slate-400">No Distributors records found.</td></tr>';
                        }
                      ?>
                  
                  
                </ul>
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
  <script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.carousel-slide');
    let current = 0;
    let intervalId;

    // Show a specific slide
    function showSlide(idx) {
        slides.forEach((slide, i) => {
            if (i === idx) {
                slide.style.display = 'block';
                slide.style.opacity = '1';
            } else {
                slide.style.display = 'none';
                slide.style.opacity = '0';
            }
        });
    }

    // Auto advance slides
    function startAutoSlide() {
        intervalId = setInterval(() => {
            current = (current + 1) % slides.length;
            showSlide(current);
        }, 5000); // Change slide every 5 seconds
    }

    // Stop auto advance
    function stopAutoSlide() {
        if (intervalId) {
            clearInterval(intervalId);
        }
    }

    // Initialize
    showSlide(current);
    startAutoSlide();

    // Next button click
    document.querySelector('[btn-next]').onclick = function() {
        stopAutoSlide();
        current = (current + 1) % slides.length;
        showSlide(current);
        startAutoSlide();
    };

    // Previous button click
    document.querySelector('[btn-prev]').onclick = function() {
        stopAutoSlide();
        current = (current - 1 + slides.length) % slides.length;
        showSlide(current);
        startAutoSlide();
    };

    // Pause on hover
    const slider = document.querySelector('[slider]');
    slider.addEventListener('mouseenter', stopAutoSlide);
    slider.addEventListener('mouseleave', startAutoSlide);
});
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const slides = document.querySelectorAll('.carousel-slide');
    let current = 0;
    let intervalId;

    // Show a specific slide with animation
    function showSlide(idx, direction = 'next') {
        const currentSlide = slides[current];
        const nextSlide = slides[idx];
        
        // Reset all slides
        slides.forEach(slide => {
            slide.style.display = 'block';
            slide.classList.remove('active', 'prev');
            slide.style.transform = direction === 'next' ? 'translateX(100%)' : 'translateX(-100%)';
            slide.style.opacity = '0';
        });

        // Animate current slide out
        currentSlide.style.transform = direction === 'next' ? 'translateX(-100%)' : 'translateX(100%)';
        currentSlide.style.opacity = '0';

        // Animate new slide in
        nextSlide.classList.add('active');
        nextSlide.style.transform = 'translateX(0)';
        nextSlide.style.opacity = '1';

        current = idx;
    }

    // Auto advance slides
    function startAutoSlide() {
        intervalId = setInterval(() => {
            const next = (current + 1) % slides.length;
            showSlide(next, 'next');
        }, 5000);
    }

    // Stop auto advance
    function stopAutoSlide() {
        if (intervalId) {
            clearInterval(intervalId);
        }
    }

    // Initialize
    slides.forEach((slide, i) => {
        if (i !== 0) {
            slide.style.transform = 'translateX(100%)';
            slide.style.opacity = '0';
        }
    });
    slides[0].classList.add('active');
    startAutoSlide();

    // Next button click
    document.querySelector('[btn-next]').onclick = function() {
        stopAutoSlide();
        const next = (current + 1) % slides.length;
        showSlide(next, 'next');
        startAutoSlide();
    };

    // Previous button click
    document.querySelector('[btn-prev]').onclick = function() {
        stopAutoSlide();
        const prev = (current - 1 + slides.length) % slides.length;
        showSlide(prev, 'prev');
        startAutoSlide();
    };

    // Pause on hover
    const slider = document.querySelector('[slider]');
    slider.addEventListener('mouseenter', stopAutoSlide);
    slider.addEventListener('mouseleave', startAutoSlide);
});
</script>
</html>
