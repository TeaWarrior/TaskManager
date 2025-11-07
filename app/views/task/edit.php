<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Task</title>
</head>
<body>
    <h1>Edit Task: <?php echo htmlspecialchars($task['title']); ?></h1>
    <a href="/">Back to list</a>
    <hr>
    
    <?php if (isset($error) && $error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <form method="POST" action="/task/update/<?php echo htmlspecialchars($task['id']); ?>">
        <div>
            <label for="title">Title:</label>
            <input type="text" id="title" name="title" required 
                   value="<?php echo htmlspecialchars($task['title']); ?>">
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea id="description" name="description"><?php echo htmlspecialchars($task['description']); ?></textarea>
        </div>
        <div>
            <label for="is_completed">Completed:</label>
            <input type="checkbox" id="is_completed" name="is_completed" 
                   <?php echo $task['is_completed'] ? 'checked' : ''; ?>>
        </div>
        <div class="mb-3">
    <label for="priority" class="form-label">Приоритет</label>
    <select class="form-select" id="priority" name="priority" required>
        <option value="High">High</option>
        <option value="Medium" selected>Medium</option>
        <option value="Low">Low</option>
    </select>
</div>
        <button type="submit">Update Task</button>
    </form>

</body>
</html>