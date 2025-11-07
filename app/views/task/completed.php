<h1 class="mb-4">Completed Tasks</h1>

<?php if (empty($tasks)): ?>
    <div class="alert alert-info" role="alert">
        No completed tasks found. 
    </div>
<?php else: ?>

    <table class="table table-striped table-hover align-middle">
        <thead>
            <tr>
                <th>Title</th>
                <th>Priority</th>
                <th>Completed At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($tasks as $task): ?>
            <tr>
                <td><del><?= htmlspecialchars($task['title']) ?></del></td>
                
                <td>
                    
                </td>
                
                <td></td>
                <td></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
<?php endif; ?>