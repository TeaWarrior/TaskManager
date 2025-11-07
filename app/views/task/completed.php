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
                <td>
                    <del><?= htmlspecialchars($task['title']) ?></del>
                </td>
                
                <td>
                    <?php 
                        
                        $color = 'bg-secondary';
                        if ($task['priority'] === 'High') {
                            $color = 'bg-danger'; // Красный
                        } elseif ($task['priority'] === 'Medium') {
                            $color = 'bg-warning'; // Оранжевый/Желтый
                        } elseif ($task['priority'] === 'Low') {
                            $color = 'bg-success'; // Зеленый
                        }
                    ?>
                    <span class="badge rounded-pill <?= $color ?>" 
                          data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $task['priority'] ?>">
                        &nbsp;&nbsp;
                    </span>
                </td>
                
                <td>
                    <?php 
                        if ($task['completed_at']) {
                          
                            echo date('Y-m-d H:i', strtotime($task['completed_at']));
                        } else {
                            echo 'N/A';
                        }
                    ?>
                </td>
                
                <td>
                    <!--
                    <a href="/task/restore/<?= $task['id'] ?>" class="btn btn-sm btn-info me-2" title="Restore Task">
                        Restore
                    </a>
                    -->
                    <a href="/task/delete/<?= $task['id'] ?>" class="btn btn-sm btn-danger" title="Delete Task" 
                       onclick="return confirm('Are you sure you want to delete this task permanently?');">
                        Delete
                    </a>
                </td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    
<?php endif; ?>