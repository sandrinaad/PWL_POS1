<!-- resources/views/user/profile.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
</head>
<body>
    <div class="profile-container">
        <div class="profile-header">
            <h1>User Profile</h1>
        </div>

        <div class="profile-info">
            <p><strong>ID User:</strong> {{ $id }}</p>
            <p><strong>Nama:</strong> {{ $name }}</p>
        </div>
    </div>
</body>
</html>