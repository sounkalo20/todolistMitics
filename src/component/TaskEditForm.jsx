import React, { useState, useEffect } from 'react';

// Composant pour éditer une tâche
const TaskEditForm = ({ task, onUpdate }) => {
    // État local pour stocker les données de la tâche modifiée
    const [editedTask, setEditedTask] = useState({ title: '', description: '' });

    // Effet pour initialiser les champs du formulaire avec les valeurs de la tâche passée en prop
    useEffect(() => {
        // Met à jour l'état local lorsque la tâche change
        setEditedTask({ title: task.title, description: task.description });
    }, [task]);

    // Fonction pour gérer la soumission du formulaire
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
