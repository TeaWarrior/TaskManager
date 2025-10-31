<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager - All Tasks</title>
</head>
<body>

    <h1>Task List</h1>

    <?php if (empty($tasks)): ?>
        <p>No tasks found.</p>
    <?php else: ?>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <strong>ID #<?php echo htmlspecialchars($task['id']); ?>:</strong> 
                    <?php echo htmlspecialchars($task['title']); ?>
                    
                    (<?php echo $task['is_completed'] ? 'Completed ✅' : 'Pending ⏳'; ?>)
                    <br>
                    <small><?php echo htmlspecialchars($task['description']); ?></small>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</body>
</html>