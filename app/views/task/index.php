<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1>Мои Задачи (API-Рендеринг)</h1>
            <div>
                <a href="/task/add" class="btn btn-primary me-2">
                    <i class="fas fa-plus"></i> Add New Task
                </a>
                <a href="/task/completed" class="btn btn-outline-success">
                    Completed Tasks
                </a>
            </div>
        </div>

        <table class="table table-hover shadow-sm rounded-3 overflow-hidden">
            <thead class="table-dark">
                <tr>
                    <th scope="col" style="width: 55%;">Задача</th>
                    <th scope="col" style="width: 15%;">Приоритет</th>
                    <th scope="col" style="width: 15%;">Действия</th>
                </tr>
            </thead>
            <tbody id="tasks-body">
                <tr>
                    <td colspan="3" class="text-center py-4">
                        <i class="fas fa-spinner fa-spin me-2"></i> Loading tasks...
                    </td>
                </tr>
            </tbody>
        </table>
        
        <div id="empty-list-message" class="alert alert-info text-center d-none" role="alert">
            No tasks found. Start by adding a new one!
        </div>
        
    </div>
</div>

<script src="js/main.js"></script>