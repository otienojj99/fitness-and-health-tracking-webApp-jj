<?php
include 'config.php';
session_start();
if (!isset($_SESSION['user_id'])) {
    die("Error: User is not logged in. Please log in first.");
}
$user_id = $_SESSION['user_id'];
$username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Guest';
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100 font-sans">
    <div class="flex flex-col h-screen">

        <header class="bg-[#322D2D] text-white px-6 py-4 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <a href="index.php"><img src="images/OIP (7).jpg" alt="" class="w-12 h-12 rounded-full"></a>
                <h1 class="text-xl font-semibold text-white">Welcome to G-fit</h1>
            </div>

            <!-- <div class="logo"></div> -->
            <div class="relative">
                <div class="bg-gray-700 px-4 py-2 rounded-lg cursor-pointer" id="user-menu-button">Signed In ▾</div>

                <div id="user-menu"
                    class="hidden absolute right-0 mt-2 w-40 bg-white text-black shadow-lg rounded-lg z-50">
                    <a href="profileSetup.php" class="block px-4 py-2 hover:bg-gray-200">Profile</a>
                    <a href="#" class="block px-4 py-2 hover:bg-gray-200">Log Out</a>
                </div>
            </div>
        </header>
        <div class="flex h-screen">
            <aside
                class="w-64 bg-blue-900 text-white p-5 relative transition-all duration-300 ease-in-out  fixed h-screen"
                id="sidebar">
                <button class="absolute top-4 right-4 text-white text-2xl focus:outline-none"
                    id="close-sidebar">×</button>
                <ul class="mt-8">
                    <li class="mb-3 flex items-center space-x-3">
                        <span class="text-lg">📌</span>
                        <a href="#" class="side-link hover:text-blue-300 sidebar-text"
                            data-page="dashbord.php">Dashboard</a>
                    </li>
                    <li class="mb-3 flex items-center space-x-3">
                        <span class="text-lg">📌</span>
                        <a href="#" class="side-link hover:text-blue-300 sidebar-text"
                            data-page="workout-plan.php">Workouts</a>
                    </li>
                    <li class="mb-3 flex items-center space-x-3">
                        <span class="text-lg">📌</span>
                        <a href="#" class="side-link hover:text-blue-300 sidebar-text" data-page="diet_logs.php">Diet
                            Logs</a>
                    </li>
                    <li class="mb-3 flex items-center space-x-3">
                        <span class="text-lg">📌</span>
                        <a href="#" class="side-link hover:text-blue-300 sidebar-text" data-page="n.php">Goals</a>
                    </li>
                    <li class="mb-3 flex items-center space-x-3">
                        <span class="text-lg">📌</span>
                        <a href="#" class="side-link hover:text-blue-300 sidebar-text" data-page="n.php">Payments</a>
                    </li>
                </ul>
            </aside>


            <main id="content" class="flex-1 p-6  overflow-y-auto mt-16 p-5">
                <h1 class="text-3xl font-bold mb-6">Dashboard</h1>

                <div class="flex-1 p-6 overflow-y-auto mt-16 grid grid-cols-3 gap-6">
                    <div class="bg-white p-5 rounded-lg shadow">
                        <h1 class="text-xl font-semibold text-[#322D2D]">Welcome,
                            <?php echo htmlspecialchars($username); ?>
                        </h1>
                        <!-- <p class="text-2xl font-bold mt-2">15 Sessions</p> -->
                        <p class="text-2xl font-bold mt-2">Weight: 34</p>
                        <p class="text-2xl font-bold mt-2">Height: 166</p>
                        <p class="text-2xl font-bold mt-2">Gender: Male</p>
                    </div>
                    <div class="bg-white p-5 rounded-lg shadow">
                        <p id="tdeeDisplay" class="text-2xl font-bold mt-2">Loading...</p>
                        <p id="bMIDisplay" class="text-2xl font-bold mt-2">Loading...</p>
                        <p id="clasify" class="text-2xl font-bold mt-2"></p>
                    </div>

                    <div class="bg-white p-5 rounded-lg shadow">
                        <h3 class="text-xl font-semibold">Workout Logs</h3>
                        <p class="text-2xl font-bold mt-2">15 Sessions</p>
                    </div>

                    <div class="bg-white p-5 w-500 h-500 rounded-lg shadow">
                        <h3 class="text-xl font-semibold">Activity Summary</h3>
                        <div class="flex items-center space-x-4">
                            <div>
                                <p class="text-2xl font-bold mt-2">Calories Banned</p>
                                <img src="images/OIP (1).jfif" alt="" class="w-12 h-12 rounded-full">
                                <p class="text-2xl font-bold mt-2">2,500 kcal</p>
                            </div>
                        </div>
                    </div>

                    <div id="notification" style="color: red; font-weight: bold;">reminder</div>
                </div>
            </main>
        </div>


    </div>

    <script src="script2.js"></script>
    <script>
        const user_id = <?php echo json_encode($_SESSION['user_id'] ?? null); ?>;
    </script>
</body>

</html>