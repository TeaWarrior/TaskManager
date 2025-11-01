<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
</head>
<body>

    <h1>User Login</h1>

    <?php if (isset($error) && $error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="/user/authenticate">
        <div>
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required 
                   value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
        </div>
        <div>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit">Login</button>
    </form>
    
    <p>Don't have an account? <a href="/user/register">Register here</a></p>

</body>
</html>