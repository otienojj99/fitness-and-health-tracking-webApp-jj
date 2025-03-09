<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="script.js"></script>

    <!-- <link rel="stylesheet" href="styles.css"> -->
</head>


<body>
    <div style="display: none;">
        <div class="bg-white p-5 rounded-lg shadow ">
            <h3 class="text-xl font-semibold mb-4">Diet Logs</h3>
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden tailwind-table">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4">Date</th>
                        <th class="py-2 px-4">Meal</th>
                        <th class="py-2 px-4">Proteins</th>
                        <th class="py-2 px-4">Carbs</th>
                        <th class="py-2 px-4">Fats</th>
                        <th class="py-2 px-4">Calories</th>
                    </tr>
                </thead>
                <tbody id="diet-logs-body" class="text-gray-700">
                    <!-- Data will be inserted here -->
                </tbody>
            </table>
        </div>

        <!-- Workout Logs Table -->
        <div class="bg-white p-5 rounded-lg shadow mt-6 tailwind-table">
            <h3 class="text-xl font-semibold mb-4">Workout Logs</h3>
            <table class="w-full bg-white shadow-md rounded-lg overflow-hidden">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-2 px-4">Date</th>
                        <th class="py-2 px-4">User</th>
                        <th class="py-2 px-4">Exercise</th>
                        <th class="py-2 px-4">MET Value</th>
                        <th class="py-2 px-4">Duration</th>
                    </tr>
                </thead>
                <tbody id="workout-logs-body" class="text-gray-700">
                    <!-- Data will be inserted here -->
                </tbody>
            </table>
        </div>
    </div>
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->

</body>

</html>