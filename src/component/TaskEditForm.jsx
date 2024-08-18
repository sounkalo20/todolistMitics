import React, { useState, useEffect } from 'react';

const TaskEditForm = ({ task, onUpdate }) => {
    const [editedTask, setEditedTask] = useState({ title: '', description: '' });

    useEffect(() => {
        setEditedTask({ title: task.title, description: task.description });
    }, [task]);

    const handleUpdate = (e) => {
        e.preventDefault();
        onUpdate(task.id, editedTask);
        setEditedTask({ title: '', description: '' });
    };

    return (
        <form onSubmit={handleUpdate} className="edit-task-form">
            <div className='todo-input'>
                <div className='todo-input-item'>
                    <label htmlFor="">Titre</label>
                    <input
                        type="text"
                        value={editedTask.title}
                        onChange={(e) => setEditedTask({ ...editedTask, title: e.target.value })}
                        placeholder="Titre de la tâche"
                        required
                    />
                </div>
                <div className="todo-input-item">
                    <label htmlFor="">Description</label>
                    <input
                        type='text'
                        value={editedTask.description}
                        onChange={(e) => setEditedTask({ ...editedTask, description: e.target.value })}
                        placeholder="Description de la tâche"
                    />
                </div>
                <button type="submit" className='primaryBtn'>Valider</button>
            </div>
        </form>
    );
};

export default TaskEditForm;
