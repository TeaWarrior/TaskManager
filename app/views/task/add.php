<div class="row">
    <div class="col-md-8 col-lg-6 mx-auto">
        <h1 class="mb-4">Add New Task</h1>
        
        <a href="/" class="btn btn-sm btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to list
        </a>
        <hr>
        
        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form id="task-form" method="POST">
            
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" id="title" name="title" required class="form-control">
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="4"></textarea>
            </div>
            
            <div class="mb-3">
                <label for="priority" class="form-label">Приоритет</label>
                <select class="form-select" id="priority" name="priority" required>
                    <option value="High">High</option>
                    <option value="Medium" selected>Medium</option>
                    <option value="Low">Low</option>
                </select>
            </div>
            
            <button type="submit" class="btn btn-primary w-100">Add Task</button>
        </form>
    </div>
</div>

<script src="/js/add.js"></script>