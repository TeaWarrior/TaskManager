// public/js/add.js

document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('task-form');
    const errorDisplay = document.querySelector('.alert-danger'); 

    form.addEventListener('submit', async (e) => {
        e.preventDefault(); 

        const formData = new FormData(form);
        const taskData = {
            title: formData.get('title'),
            description: formData.get('description'),
            priority: formData.get('priority')
            
        };

        try {
            
            const response = await fetch('/task/apistore', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json' 
                },
                body: JSON.stringify(taskData) 
            });

            const result = await response.json();

           
            if (response.ok && result.status === 'success') {
                alert('Задача успешно создана!');
               
                window.location.href = '/'; 
            } else {
                
                const errorMessage = result.message || 'Unknown error occurred.';
                alert('Ошибка при создании задачи: ' + errorMessage);
                
                if (errorDisplay) {
                     errorDisplay.textContent = errorMessage;
                     errorDisplay.classList.remove('d-none');
                }
            }

        } catch (error) {
            console.error('Fetch error:', error);
            alert('Сетевая ошибка. Не удалось связаться с сервером.');
        }
    });
});