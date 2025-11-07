<div class="row justify-content-center mt-5">
    <div class="col-md-6 col-lg-5">
        <div class="card shadow-sm">
            <div class="card-header bg-primary text-white text-center">
                <h1 class="h3 mb-0">User Login</h1>
            </div>
            <div class="card-body">

                <?php if (isset($error) && $error): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form method="POST" action="/user/authenticate">
                    
                    <div class="mb-3">
                        <label for="username" class="form-label">Username:</label>
                        <input type="text" id="username" name="username" required 
                               class="form-control"
                               value="<?php echo isset($username) ? htmlspecialchars($username) : ''; ?>">
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password:</label>
                        <input type="password" id="password" name="password" required 
                               class="form-control">
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                </form>

                <hr>
                
                <p class="text-center">
                    Don't have an account? 
                    <a href="/user/register" class="btn btn-sm btn-outline-secondary">Register here</a>
                </p>

            </div>
        </div>
    </div>
</div>