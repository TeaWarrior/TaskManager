<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
</head>
<body>

    <h1>User Registration</h1>

    <?php if (isset($error) && $error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="/user/handleRegister">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required 
                   value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
        </div>
        <div>
            <label for="password">Password (min 6 chars):</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Register</button>
    </form>
    
    <p>Already have an account? <a href="/user/login">Login here</a></p>

</body>
</html>