<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Task Manager - All Tasks</title>
</head>
<body>

    <h1>Task List</h1>

<?php if (empty($tasks)): ?>
        <p>No tasks found. Go ahead and add one!</p>
    <?php else: ?>
        <ul>
            <?php foreach ($tasks as $task): ?>
                <li>
                    <strong><?php echo htmlspecialchars($task['title']); ?></strong>
                    (<?php echo $task['is_completed'] ? '✅ Completed' : '⏳ Pending'; ?>)
                    <br>
                    <small><?php echo htmlspecialchars($task['description']); ?></small>
                    
                    **[<a href="/task/edit/<?php echo htmlspecialchars($task['id']); ?>">Edit</a>]**
                    **[**
                        **<form style="display:inline;" method="POST" action="/task/delete/<?php echo htmlspecialchars($task['id']); ?>" onsubmit="return confirm('Are you sure?');">**
                            **<button type="submit" style="background:none;border:none;color:red;padding:0;cursor:pointer;">Delete</button>**
                        **</form>**
                    **]**
                </li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

</body>
</html>