// public/js/edit.js

document.addEventListener('DOMContentLoaded', () => {
    
    const form = document.getElementById('edit-task-form');
    
    
    const currentUrl = window.location.pathname;
    const parts = currentUrl.split('/');
    
    const taskId = parts[parts.length - 1]; 

    if (!form || isNaN(taskId)) {
        console.error('Edit form or Task ID not found in URL.');
        return;
    }

    form.addEventListener('submit', async (e) => {
        e.preventDefault(); 

        const formData = new FormData(form);

        const data = {
            title: formData.get('title'),
            description: formData.get('description'),
            priority: formData.get('priority')
            
        };
        
        
        const submitButton = form.querySelector('button[type="submit"]');
        submitButton.disabled = true;
        submitButton.textContent = 'Saving...';


        try {
            
            const response = await fetch(`/task/update/${taskId}`, {
                method: 'POST', 
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(data)
            });

            const result = await response.json();

            if (response.ok && result.status === 'success') {
                alert('Задача успешно обновлена!');
               
                window.location.href = '/'; 
            } else {
                
                throw new Error(result.message || 'Failed to update task.');
            }

        } catch (error) {
            console.error('Update error:', error);
            alert('Ошибка при сохранении: ' + error.message);
        } finally {
            
            submitButton.disabled = false;
            submitButton.textContent = 'Save Changes';
        }
    });
});