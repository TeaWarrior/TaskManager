// app/Views/js/main.js

document.addEventListener('DOMContentLoaded', () => {
    
    const tableBody = document.getElementById('tasks-body');
    const emptyMessage = document.getElementById('empty-list-message');
    const apiUrl = '/task/apiindex'; 

    
    function createTaskRow(task) {
        
        let colorClass = 'bg-secondary';
        if (task.priority === 'High') {
            colorClass = 'bg-danger';
        } else if (task.priority === 'Medium') {
            colorClass = 'bg-warning';
        } else if (task.priority === 'Low') {
            colorClass = 'bg-success';
        }

        return `
            <tr>
                <td>
                    ${task.title}
                    <button type="button" class="btn btn-sm btn-outline-info ms-2" disabled>
                        Показать описание
                    </button>
                </td>
                
                <td>
                    <span class="badge rounded-pill ${colorClass}" title="${task.priority}">
                        &nbsp;&nbsp;
                    </span>
                </td>
                
                <td>
                    <a href="/task/edit/${task.id}" class="btn btn-sm btn-warning me-2" title="Edit Task">
                        Edit
                    </a>
                    <a href="/task/delete/${task.id}" class="btn btn-sm btn-danger" title="Delete Task" 
                       onclick="return confirm('Are you sure you want to delete this task?');">
                        Delete
                    </a>
                </td>
            </tr>
        `;
    }

    
    function renderTasks(tasks) {
        tableBody.innerHTML = ''; 
        
        if (tasks.length === 0) {
            
            emptyMessage.classList.remove('d-none');
        } else {
            emptyMessage.classList.add('d-none');
            
            const html = tasks.map(createTaskRow).join('');
            tableBody.innerHTML = html;
        }
    }

   
    async function fetchTasks() {
        
        tableBody.innerHTML = `<tr><td colspan="3" class="text-center py-4"><i class="fas fa-spinner fa-spin me-2"></i> Loading tasks...</td></tr>`;
        emptyMessage.classList.add('d-none');

        try {
            
            const response = await fetch(apiUrl); 

            if (!response.ok) {
                throw new Error(`HTTP Error: ${response.status}`);
            }

            
            const result = await response.json(); 

            if (result.status === 'success') {
                
                renderTasks(result.data); 
            } else {
                
                tableBody.innerHTML = `<tr><td colspan="3" class="text-center text-danger py-4">Error loading tasks: ${result.message}</td></tr>`;
            }

        } catch (e) {
            console.error('Fetch Error:', e);
            tableBody.innerHTML = `<tr><td colspan="3" class="text-center text-danger py-4">Network error or failed to connect to API.</td></tr>`;
        }
    }

    
    fetchTasks();
});