<?php 
include '../include/server.php'; 
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
    $admin = array(
        'username' => $row['username'],
        'email' => $row['email'],
        'password' => $row['password'] // Note: Storing password in session isn't recommended
    );
} else {
    // Invalid session or user not found
    session_destroy();
    header('Location: ../index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png" />
    <link rel="icon" type="image/png" href="../assets/img/favicon.png" />
    <title>Profile</title>
    <!--     Fonts and icons     -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
    <!-- Font Awesome Icons -->
    <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
    <!-- Nucleo Icons -->
    <link href="../assets/css/nucleo-icons.css" rel="stylesheet" />
    <link href="../assets/css/nucleo-svg.css" rel="stylesheet" />
    <!-- Popper -->
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <!-- iziToast -->
    <link href="../iziToast/css/iziToast.min.css" rel="stylesheet" />
    <script src="../iziToast/js/iziToast.min.js"  type="text/javascript"></script>
    <!-- Main Styling -->
    <link href="../assets/css/argon-dashboard-tailwind.css?v=1.0.1" rel="stylesheet" />
  </head>
  <body class="m-0 font-sans antialiased font-normal dark:bg-slate-900 text-base leading-default bg-gray-50 text-slate-500">
   
    <?php
    if (isset($_GET['msg']) && $_GET['msg'] === "success") {
        ?>
        <script>
            iziToast.success({
                title: 'Success',
                message: 'Profile Updated Successfully!',
                position: 'topRight',
                animateInside: true,
            });
        </script>
    <?php } ?>


    <?php
    if (isset($_GET['msg']) && $_GET['msg'] === "error") {
        // Safely escape username for JS context
        $safeUsername = htmlspecialchars($username, ENT_QUOTES, 'UTF-8');
        ?>
        <script>
            iziToast.error({
                title: '',
                message: 'An Error Occured, Please Try Again!',
                position: 'topRight',
                animateInside: true,
            });
        </script>
    <?php } ?>
  
  <div class="absolute bg-y-50 w-full top-0 bg-[url('https://raw.githubusercontent.com/creativetimofficial/public-../assets/master/argon-dashboard-pro/../assets/img/profile-layout-header.jpg')] min-h-75">
      <span class="absolute top-0 left-0 w-full h-full bg-blue-500 opacity-60"></span>
    </div>

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
            <a class="py-2.7 bg-blue-500/13 dark:text-white dark:opacity-80 text-sm ease-nav-brand my-0 mx-2 flex items-center whitespace-nowrap rounded-lg px-4 font-semibold text-slate-700 transition-colors" href="profile.php">
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

    <div class="relative h-full max-h-screen transition-all duration-200 ease-in-out xl:ml-68">
      <nav class="absolute z-20 flex flex-wrap items-center justify-between w-full px-6 py-2 -mt-56 text-white transition-all ease-in shadow-none duration-250 lg:flex-nowrap lg:justify-start" navbar-profile navbar-scroll="true">
        <div class="flex items-center justify-between w-full px-6 py-1 mx-auto flex-wrap-inherit">
          <nav>
            <!-- breadcrumb -->
            <ol class="flex flex-wrap pt-1 pl-2 pr-4 mr-12 bg-transparent rounded-lg sm:mr-16">
              <li class="leading-normal text-sm">
                <a class="opacity-50" href="javascript:;">Pages</a>
              </li>
              <li class="text-sm pl-2 capitalize leading-normal before:float-left before:pr-2 before:content-['/']" aria-current="page">Profile</li>
            </ol>
            <h6 class="mb-2 ml-2 font-bold text-white capitalize dark:text-white">Profile</h6>
          </nav>

          
        </div>
      </nav>

      <div class="relative w-full mx-auto mt-60 ">
      </div>
      <div class="w-full p-6 mx-auto">
        <div class="flex flex-wrap -mx-3">
          

          <div class="w-full max-w-full px-3 shrink-0 md:w-8/12 md:flex-0">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <div class="border-black/12.5 rounded-t-2xl border-b-0 border-solid p-6 pb-0">
                <div class="flex items-center">
                  <p class="mb-0 dark:text-white/80">Edit Profile</p>
                  <button type="button" class="inline-block px-8 py-2 mb-4 ml-auto font-bold leading-normal text-center text-white align-middle transition-all ease-in bg-blue-500 border-0 rounded-lg shadow-md cursor-pointer text-xs tracking-tight-rem hover:shadow-xs hover:-translate-y-px active:opacity-85">Settings</button>
                </div>
              </div>
             
              <form method="post" class="w-full">
                <div class="flex-auto p-6">
                  <p class="leading-normal uppercase dark:text-white dark:opacity-60 text-sm mb-4">User Information</p>

                  <div class="flex flex-wrap -mx-3">

                    <!-- Username -->
                    <div class="w-full max-w-full px-3 mb-4 md:w-6/12">
                      <label for="username" class="block mb-2 font-bold text-xs text-slate-700 dark:text-white/80">Username</label>
                      <input type="text" id="username" name="username" 
                             value="<?php echo htmlspecialchars($admin['username']); ?>"
                             class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-normal text-gray-700 placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:shadow-primary-outline dark:bg-slate-850 dark:text-white" />
                    </div>

                    <!-- Email -->
                    <div class="w-full max-w-full px-3 mb-4 md:w-6/12">
                      <label for="email" class="block mb-2 font-bold text-xs text-slate-700 dark:text-white/80">Email Address</label>
                      <input type="email" id="email" name="email" 
                             value="<?php echo htmlspecialchars($admin['email']); ?>"
                             class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-normal text-gray-700 placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:shadow-primary-outline dark:bg-slate-850 dark:text-white" />
                    </div>

                    <!-- Password -->
                    <div class="w-full max-w-full px-3 mb-4 md:w-6/12">
                      <label for="password" class="block mb-2 font-bold text-xs text-slate-700 dark:text-white/80">Password</label>
                      <input type="password" id="password" name="password" 
                             value="<?php echo htmlspecialchars($admin['password']); ?>"
                             class="block w-full rounded-lg border border-gray-300 bg-white px-3 py-2 text-sm font-normal text-gray-700 placeholder-gray-500 focus:border-blue-500 focus:outline-none focus:shadow-primary-outline dark:bg-slate-850 dark:text-white" />
                    </div>

                    <!-- Submit Button -->
                    <div class="w-full max-w-full px-3 mb-4 md:w-6/12 flex items-end">
                      <button type="submit" name="update_profile"
                        class="px-4 py-2 rounded-lg bg-blue-500 text-white text-sm font-bold hover:bg-blue-600 transition-all">
                        Update
                      </button>
                    </div>

                  </div>

                  <hr class="h-px mx-0 my-4 bg-gradient-to-r from-transparent via-black/40 to-transparent opacity-25 dark:via-white" />
                </div>
              </form>

            </div>
          </div>

          
          <div class="w-full max-w-full px-3 mt-6 shrink-0 md:w-4/12 md:flex-0 md:mt-0">
            <div class="relative flex flex-col min-w-0 break-words bg-white border-0 shadow-xl dark:bg-slate-850 dark:shadow-dark-xl rounded-2xl bg-clip-border">
              <img class="w-full rounded-t-2xl" src="../assets/img/bg-profile.jpg" alt="profile cover image">
              <div class="flex flex-wrap justify-center -mx-3">
                <div class="w-4/12 max-w-full px-3 flex-0 ">
                </div>
              </div>
              
              
            </div>
          </div>
        </div>
        
      </div>
    </div>
  </body>
  <!-- plugin for scrollbar  -->
  <script src="../assets/js/plugins/perfect-scrollbar.min.js" async></script>
  <!-- main script file  -->
  <script src="../assets/js/argon-dashboard-tailwind.js?v=1.0.1" async></script>
</html>
