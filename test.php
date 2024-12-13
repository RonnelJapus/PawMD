<form action="add_pet.php" method="POST" enctype="multipart/form-data">
    <label>Name:</label><input type="text" name="name" required><br>
    <label>Breed:</label><input type="text" name="breed" required><br>
    <label>Age:</label><input type="number" name="age" required><br>
    <label>Sex:</label>
    <select name="sex" required>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
        <option value="Unknown">Unknown</option>
    </select><br>
    <label>Client ID (optional):</label><input type="number" name="client_id"><br>
    <label>Image:</label><input type="file" name="image" required><br>
    <button type="submit">Add Pet</button>
</form>