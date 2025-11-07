<h1 class="mb-4">Task List</h1>

<?php if (empty($tasks)): ?>
    <div class="alert alert-info" role="alert">
        No tasks found. Go ahead and add one! 
        <a href="/task/add" class="btn btn-sm btn-success ms-3">Add New Task</a>
    </div>
<?php else: ?>

    <table class="table table-striped table-hover align-middle">
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
                <th>Priority</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            
            <?php foreach ($tasks as $task): ?>
            
            <tr>
                <td><?= htmlspecialchars($task['title']) ?></td>

                <td>
                    <button type="button" class="btn btn-sm btn-outline-info" 
                            data-bs-toggle="modal" 
                            data-bs-target="#descriptionModal<?= $task['id'] ?>">
                        Показать описание
                    </button>
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
                    </td>
            </tr>
            
            <div class="modal fade" id="descriptionModal<?= $task['id'] ?>" tabindex="-1" aria-labelledby="descriptionModalLabel<?= $task['id'] ?>" aria-hidden="true">
              <div class="modal-dialog modal-lg">
                <div class="modal-content">
                  <div class="modal-header bg-light">
                    <h5 class="modal-title" id="descriptionModalLabel<?= $task['id'] ?>">
                        Полное описание: **<?= htmlspecialchars($task['title']) ?>**
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                  </div>
                  <div class="modal-body">
                    <?= nl2br(htmlspecialchars($task['description'])) ?>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Закрыть</button>
                  </div>
                </div>
              </div>
            </div>

            <?php endforeach; ?>
            
        </tbody>
    </table>
    
    <a href="/task/add" class="btn btn-primary">Add New Task</a>
    
<?php endif; ?>