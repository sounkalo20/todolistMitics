// src/components/TaskForm.js

import React, { useState } from 'react';

// Composant pour le formulaire d'ajout de tâche
const TaskForm = ({ onCreateTask }) => {
    const [newTask, setNewTask] = useState({ title: '', description: '' });

    // Gestionnaire de soumission du formulaire
    const handleSubmit = (e) => {
        e.preventDefault();
        onCreateTask(newTask); // Appel de la fonction de création de tâche depuis les props
        setNewTask({ title: '', description: '' }); // Réinitialiser le formulaire après la soumission
    };

    return (
        <form onSubmit={handleSubmit}>
            <input
                type="text"
                value={newTask.title}
                onChange={(e) => setNewTask({ ...newTask, title: e.target.value })}
                placeholder="Titre de la tâche"
                required
            />
            <textarea
                value={newTask.description}
                onChange={(e) => setNewTask({ ...newTask, description: e.target.value })}
                placeholder="Description de la tâche"
            />
            <button type="submit">Ajouter Tâche</button>
        </form>
    );
};

export default TaskForm;
