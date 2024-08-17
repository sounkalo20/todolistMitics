// src/components/TaskList.js

import React, { useState, useEffect } from 'react';
import Task from './Task'; // Importation du composant Task
import TaskForm from './TaskForm'; // Importation du composant TaskForm
import { getTasks, createTask, updateTask, deleteTask } from '../services/todoService';

// Composant principal pour afficher et gérer la liste des tâches
const TaskList = () => {
    const [tasks, setTasks] = useState([]); // État pour stocker la liste des tâches

    // Fonction pour récupérer toutes les tâches au chargement du composant
    useEffect(() => {
        fetchTasks();
    }, []);

    const fetchTasks = async () => {
        const response = await getTasks(); // Appel à l'API pour récupérer les tâches
        setTasks(response.data); // Mise à jour de l'état avec les tâches récupérées
    };

    // Fonction pour gérer la création d'une nouvelle tâche
    const handleCreateTask = async (task) => {
        await createTask(task); // Appel à l'API pour créer une tâche
        fetchTasks(); // Mise à jour de la liste des tâches
    };

    // Fonction pour gérer la suppression d'une tâche
    const handleDeleteTask = async (id) => {
        await deleteTask(id); // Appel à l'API pour supprimer la tâche
        fetchTasks(); // Mise à jour de la liste des tâches
    };

    // Fonction pour gérer la mise à jour d'une tâche
    const handleUpdateTask = async (id, updatedTask) => {
        await updateTask(id, updatedTask); // Appel à l'API pour mettre à jour la tâche
        fetchTasks(); // Mise à jour de la liste des tâches
    };

    return (
        <div>
            <h1>Liste des Tâches</h1>
            {/* Utilisation du composant TaskForm pour ajouter des tâches */}
            <TaskForm onCreateTask={handleCreateTask} />
            <ul>
                {tasks.map((task) => (
                    // Utilisation du composant Task pour afficher chaque tâche
                    <Task
                        key={task.id}
                        task={task}
                        onUpdateTask={handleUpdateTask}
                        onDeleteTask={handleDeleteTask}
                    />
                ))}
            </ul>
        </div>
    );
};

export default TaskList;
