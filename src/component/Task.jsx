// src/components/Task.js

import React from 'react';

// Composant pour afficher une tâche individuelle
const Task = ({ task, onUpdateTask, onDeleteTask }) => {
    return (
        <li>
            <h2>{task.title}</h2>
            <p>{task.description}</p>
            <p>Complétée : {task.completed ? "Oui" : "Non"}</p>
            <button onClick={() => onUpdateTask(task.id, { ...task, completed: !task.completed })}>
                {task.completed ? "Marquer Non Complétée" : "Marquer Complétée"}
            </button>
            <button onClick={() => onDeleteTask(task.id)}>Supprimer</button>
        </li>
    );
};

export default Task;
