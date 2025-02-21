<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diet Plan Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .meal-group {
            display: flex;
            gap: 10px;
            margin-bottom: 5px;
        }
        .remove-btn {
            background: red;
            color: white;
            border: none;
            padding: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <h2>Diet Plan Form</h2>
    <form action="save_diet.php" method="POST">
        <label for="diet_name">Diet Name:</label>
        <input type="text" id="diet_name" name="diet_name" required><br><br>

        <label for="meal_type">Meal Type:</label>
        <select id="meal_type" name="meal_type" required>
            <option value="Breakfast">Breakfast</option>
            <option value="Lunch">Lunch</option>
            <option value="Dinner">Dinner</option>
            <option value="Snack">Snack</option>
        </select><br><br>

        <label>Days per Week:</label><br>
        <input type="checkbox" name="days[]" value="Monday"> Monday
        <input type="checkbox" name="days[]" value="Tuesday"> Tuesday
        <input type="checkbox" name="days[]" value="Wednesday"> Wednesday
        <input type="checkbox" name="days[]" value="Thursday"> Thursday
        <input type="checkbox" name="days[]" value="Friday"> Friday
        <input type="checkbox" name="days[]" value="Saturday"> Saturday
        <input type="checkbox" name="days[]" value="Sunday"> Sunday
        <br><br>

        <label>Meals:</label> <button type="button" id="addMeal">+ Add Meal</button><br>
        <div id="mealList">
            <div class="meal-group">
                <input type="text" name="meal_name[]" placeholder="Meal Name" required>
                <input type="number" name="calories[]" placeholder="Calories" min="1" required>
                <input type="number" name="protein[]" placeholder="Protein (g)" min="0" required>
                <input type="number" name="carbs[]" placeholder="Carbs (g)" min="0" required>
                <input type="number" name="fats[]" placeholder="Fats (g)" min="0" required>
            </div>
        </div>
        <br>

        <label for="target_calories">Target Daily Calories:</label>
        <input type="number" id="target_calories" name="target_calories" min="500" required><br><br>

        <label for="diet_type">Diet Type:</label>
        <select id="diet_type" name="diet_type" required>
            <option value="Vegetarian">Vegetarian</option>
            <option value="Keto">Keto</option>
            <option value="High Protein">High Protein</option>
            <option value="Balanced">Balanced</option>
            <option value="Custom">Custom</option>
        </select><br><br>

        <label for="notes">Additional Notes (Optional):</label>
        <textarea id="notes" name="notes" rows="4"></textarea><br><br>

        <button type="submit">Save Diet Plan</button>
    </form>

    <script>
        $(document).ready(function() {
            $("#addMeal").click(function() {
                $("#mealList").append(`
                    <div class="meal-group">
                        <input type="text" name="meal_name[]" placeholder="Meal Name" required>
                        <input type="number" name="calories[]" placeholder="Calories" min="1" required>
                        <input type="number" name="protein[]" placeholder="Protein (g)" min="0" required>
                        <input type="number" name="carbs[]" placeholder="Carbs (g)" min="0" required>
                        <input type="number" name="fats[]" placeholder="Fats (g)" min="0" required>
                        <button type="button" class="remove-btn">X</button>
                    </div>
                `);
            });

            $(document).on("click", ".remove-btn", function() {
                $(this).closest(".meal-group").remove();
            });
        });
    </script>

</body>
</html>
