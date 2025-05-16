<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Category</title>
    <style>
        body {
            background-color: #f1f1f1;
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .form-container {
            background-color: #fff;
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0,0,0,0.1);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        label {
            display: block;
            text-align: left;
            margin-bottom: 5px;
            font-weight: bold;
        }

        input[type="text"],
        textarea {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        button {
            width: 100%;
            padding: 12px;
            background-color: #007bff;
            border: none;
            color: white;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .note {
            margin-top: 10px;
            font-size: 12px;
            color: #777;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h2>Add New Category</h2>
    <form action="insert_categorie.php" method="POST">
        <label for="nom">Category Name</label>
        <input type="text" id="nom" name="nom" required>

        <label for="description">Description</label>
        <textarea id="description" name="description" rows="3" required></textarea>

        <button type="submit">Add Category</button>
    </form>
    <div class="note">Please fill in all fields</div>
</div>

</body>
</html>