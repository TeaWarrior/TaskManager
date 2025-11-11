<div class="row">
    <div class="col-md-8 col-lg-6 mx-auto">
        
        <h1 class="mb-4">Edit Task: <?php echo htmlspecialchars($task['title']); ?></h1>
        
        <a href="/" class="btn btn-sm btn-outline-secondary mb-3">
            <i class="fas fa-arrow-left"></i> Back to list
        </a>
        <hr>
        
        <?php if (isset($error) && $error): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>

        <form method="POST" action="/task/update/<?php echo htmlspecialchars($task['id']); ?>">
            
            <div class="mb-3">
                <label for="title" class="form-label">Title:</label>
                <input type="text" id="title" name="title" required class="form-control"
                       value="<?php echo htmlspecialchars($task['title']); ?>">
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description:</label>
                <textarea id="description" name="description" class="form-control" rows="4"><?php echo htmlspecialchars($task['description']); ?></textarea>
            </div>
            
            <div class="mb-3">
                <label for="priority" class="form-label">Приоритет</label>
                <select class="form-select" id="priority" name="priority" required>
                    <option value="High" <?php echo ($task['priority'] === 'High') ? 'selected' : ''; ?>>High</option>
                    <option value="Medium" <?php echo ($task['priority'] === 'Medium') ? 'selected' : ''; ?>>Medium</option>
                    <option value="Low" <?php echo ($task['priority'] === 'Low') ? 'selected' : ''; ?>>Low</option>
                </select>
            </div>
            
            <div class="mb-3 form-check">
                <input type="checkbox" id="is_completed" name="is_completed" class="form-check-input" 
                       <?php echo $task['is_completed'] ? 'checked' : ''; ?>>
                <label class="form-check-label" for="is_completed">Completed</label>
            </div>
            
            <button type="submit" class="btn btn-success w-100">Update Task</button>
        </form>
        
    </div>
</div>