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
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- iziToast -->
    <link href="../iziToast/css/iziToast.min.css" rel="stylesheet" />
    <script src="../iziToast/js/iziToast.min.js"  type="text/javascript"></script>
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

  <body class="m-0 font-sans text-base antialiased font-normal dark:bg-slate-900 leading-default bg-gray-50 text-slate-500">
    
    <?php
    if (isset($_GET['msg']) && $_GET['msg'] === "success") {?>
        <script>
            iziToast.success({
                title: 'Success',
                message: 'Sale Added Successfully!',
                position: 'topRight',
                animateInside: true,
            });
        </script>
    <?php } ?>


    <?php
    if (isset($_GET['msg']) && $_GET['msg'] === "error") {?>
        <script>
            iziToast.error({
                title: 'Error',
                message: 'An Error Occured, Please Try Again!',
                position: 'topRight',
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
            <a class="py-2.7 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 text-slate-700 transition-colors" href="index.php">
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
            <a class="py-2.7 bg-blue-500/13 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold text-slate-700 transition-colors" href="sales.php">
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
              <li class="text-sm pl-2 capitalize leading-normal text-white before:float-left before:pr-2 before:text-white before:content-['/']" aria-current="page">Sales</li>
            </ol>
            <h6 class="mb-0 font-bold text-white capitalize">Sales</h6>
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
      
      <div class="w-full p-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
          <div class="w-full max-w-full px-3 shrink-0 md:w-5/12 md:flex-0">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0">
                <div class="flex items-center">
                  <p class="mb-0 dark:text-white/80">Add Sale</p>
                </div>
              </div>
              <form method="post">
                <div class="flex-auto p-6">
                <div class="flex flex-wrap -mx-3">
                  <div class="w-full max-w-full px-3 shrink-0 md:w-12/12 md:flex-0">
                    <div class="mb-4">
                      <label class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Product</label>
                      <input type="text" id="product" name="product" placeholder="Product name" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                      <div id="availability" class="text-xs mt-1"></div>
                    </div>
                  </div>
                  <div class="w-6/12 max-w-6/12 px-3 shrink-0 md:w-6/12 md:flex-0">
                    <div class="mb-4">
                      <label for="price" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Price</label>
                      <input type="text" id="price" name="price_display" readonly class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                      <input type="hidden" id="price_numeric" name="price" />
                    </div>
                  </div>

                  <div class="w-6/12 max-w-6/12 px-3 shrink-0 md:w-6/12 md:flex-0">
                    <div class="mb-4">
                      <label for="quantity" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Quantity</label>
                      <input type="number" id="quantity" name="quantity" value="1" min="1" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none" />
                    </div>
                  </div>                
                    
                <div class="w-full max-w-full px-3 shrink-0 md:w-12/12 md:flex-0">
                    <div class="mb-4">
                      <label for="phone" class="inline-block mb-2 ml-1 font-bold text-xs text-slate-700 dark:text-white/80">Payment Type</label>
                      <select name="payment_type" class="focus:shadow-primary-outline dark:bg-slate-850 dark:text-white text-sm leading-5.6 ease block w-full appearance-none rounded-lg border border-solid border-gray-300 bg-white bg-clip-padding px-3 py-2 font-normal text-gray-700 outline-none transition-all placeholder:text-gray-500 focus:border-blue-500 focus:outline-none">
                        <option value="">Select Payment Type</option>
                        <option value="cash">Cash</option>
                        <option value="transfer">Transfer</option>
                        <option value="pos">POS</option>
                      </select>
                    </div>
                  
                  
                <div class="flex flex-wrap -mx-3">
                  <div class="w-full max-w-full px-3 shrink-0 md:w-full md:flex-0">
                    <div class="mb-4">
                        <button type="submit" name="add_sale" class="inline-block px-8 py-2 mb-4 ml-auto font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">Add Sale</button>
                    </div>
                  </div>
                </div>
            </div>
              </form>
          </div>
          </div>
        </div>
          </div>
          <div class="w-full max-w-full px-3 mt-6 shrink-0 md:w-7/12 md:flex-0 md:mt-0">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
           
              <div class="flex-auto p-6 pt-0">
                <br>
                <table class="items-center w-full mb-0 align-top border-collapse dark:border-white/40 text-slate-500">
                    Manage Records <br>
                    <thead class="align-bottom">
                      <tr>
                        <small style="color: blue">
                          POS:  <?php
                            // Query to get the total POS payment_types
                            $querys = "SELECT SUM(price) AS total_pos 
                                      FROM sales 
                                      WHERE payment_type = 'POS'";

                            $result = mysqli_query($dbcon, $querys);

                            if (!$result) {
                                // Handle query error
                                echo "Error: " . mysqli_error($dbcon);
                            } else {
                                $row = mysqli_fetch_assoc($result);
                                // If no POS payment_types, set to 0
                                $total_pos = $row['total_pos'] ?? 0;
                                // Display formatted with Naira symbol
                                echo "&#8358;" . number_format($total_pos, 2);
                            }
                            ?>
                    
                  
                          - Transfer:  <?php
                            // Query to get the total POS payment_types
                            $querys = "SELECT SUM(price) AS total_pos 
                                      FROM sales 
                                      WHERE payment_type = 'Transfer'";

                            $result = mysqli_query($dbcon, $querys);

                            if (!$result) {
                                // Handle query error
                                echo "Error: " . mysqli_error($dbcon);
                            } else {
                                $row = mysqli_fetch_assoc($result);
                                // If no POS payment_types, set to 0
                                $total_pos = $row['total_pos'] ?? 0;
                                // Display formatted with Naira symbol
                                echo "&#8358;" . number_format($total_pos, 2);
                            }
                            ?>
                    
                  
                          - Cash:  <?php
                            // Query to get the total POS payment_types
                            $querys = "SELECT SUM(price) AS total_pos 
                                      FROM sales 
                                      WHERE payment_type = 'cash'";

                            $result = mysqli_query($dbcon, $querys);

                            if (!$result) {
                                // Handle query error
                                echo "Error: " . mysqli_error($dbcon);
                            } else {
                                $row = mysqli_fetch_assoc($result);
                                // If no POS payment_types, set to 0
                                $total_pos = $row['total_pos'] ?? 0;
                                // Display formatted with Naira symbol
                                echo "&#8358;" . number_format($total_pos, 2);
                            }
                            ?>
                      </small>
                      </tr>
                      <tr>
                        <th class="px-6 py-3 font-bold text-left uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-90">Product</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-90">Quantity</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-90">Cost</th>
                        <th class="px-6 py-3 font-bold text-center uppercase align-middle bg-transparent border-b border-collapse shadow-none dark:border-white/40 dark:text-white text-xxs border-b-solid tracking-none whitespace-nowrap text-slate-400 opacity-90">Type</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php
                        $sales_query = "SELECT product, price, quantity, payment_type FROM sales ORDER BY id DESC";
                        $sales_result = mysqli_query($dbcon, $sales_query);
                        if ($sales_result && mysqli_num_rows($sales_result) > 0) {
                          while ($row = mysqli_fetch_assoc($sales_result)) {
                            $product = htmlspecialchars($row['product']);
                            $price = floatval($row['price']);
                            $quantity = intval($row['quantity']);
                            $payment_type = htmlspecialchars($row['payment_type']);
                            echo '<tr>
                              <td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">'.$product.'</p>
                              </td>
                              <td class="p-2 text-sm leading-normal text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">'.$quantity.'</p>
                              </td>
                              <td class="p-2 text-center align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                <p class="mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">&#8358;'.number_format($price,2).'</p>
                              </td><td class="p-2 align-middle bg-transparent border-b dark:border-white/40 whitespace-nowrap shadow-transparent">
                                <p class="text-center mb-0 text-xs leading-tight dark:text-white dark:opacity-80 text-slate-400">'.ucwords($payment_type).'</p>
                              </td>
                              
                            </tr>';
                          }
                        } else {
                          echo '
                            <tr>
                                <td colspan="6" class="text-center p-4">
                                    <center>
                                        <div class="no-records-found">
                                            <img src="../assets/img/no-data.png" alt="No records found" class="img-fluid" style="max-width:100px;">
                                            <p class="text-muted small mb-0">No sales records found</p>
                                        </div>
                                    </center>
                                </td>
                            </tr>
                          ';
                        }
                      ?>
                    </tbody>
                  </table>
              </div>
            </div>
          </div>

        </div>
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

<!-- making form not to be submitted -->
  <!-- <script>
  document.querySelector("form").addEventListener("submit", function (e) {
    const displayPrice = document.getElementById("price").value;
    document.getElementById("price_numeric").value = displayPrice;

    // allow slight delay to apply value before form is submitted
    setTimeout(() => {
      e.target.submit();
    }, 0);

    // stop immediate submission
    e.preventDefault();
  });
</script> -->

  <script>
function fetchProductInfo() {
  let product = document.getElementById('product').value;
  let quantity = document.getElementById('quantity').value;
  
  if (!product) {
    document.getElementById('availability').innerHTML = '';
    document.getElementById('price').value = '';
    return;
  }
  fetch('product_lookup.php?product=' + encodeURIComponent(product) + '&quantity=' + encodeURIComponent(quantity))
    .then(res => res.json())
    .then(data => {
      document.getElementById('availability').innerHTML = data.available;
      document.getElementById('price').value = data.price; // display value
      document.getElementById('price_numeric').value = data.price_raw; // numeric value
    });
}
document.getElementById('product').addEventListener('input', fetchProductInfo);
document.getElementById('quantity').addEventListener('input', fetchProductInfo);
window.addEventListener('DOMContentLoaded', fetchProductInfo);
</script>
</html>
