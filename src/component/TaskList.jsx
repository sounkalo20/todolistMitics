import React, { useState, useEffect } from 'react';
import Task from './Task';
import TaskForm from './TaskForm';
import TaskEditForm from './TaskEditForm';
import TaskFilter from './TaskFilter'; // Importation du composant TaskFilter
import { getTasks, createTask, updateTask, deleteTask } from '../services/todoService';

const TaskList = () => {
    // État pour stocker les tâches, la tâche en cours d'édition, et le filtre appliqué
    const [tasks, setTasks] = useState([]);
    const [editingTask, setEditingTask] = useState(null);
    const [filter, setFilter] = useState('all'); // État pour le filtre

    // Effet pour récupérer les tâches au chargement du composant
    useEffect(() => {
        fetchTasks();
    }, []);

    // Fonction pour récupérer les tâches depuis le service
    const fetchTasks = async () => {
        const response = await getTasks();
        setTasks(response.data);
    };

    // Fonction pour créer une nouvelle tâche
    const handleCreateTask = async (task) => {
        await createTask(task);
        fetchTasks();
    };

    // Fonction pour supprimer une tâche
    const handleDeleteTask = async (id) => {
        await deleteTask(id);
        fetchTasks();
    };

    // Fonction pour mettre à jour une tâche existante
    const handleUpdateTask = async (id, updatedTask) => {
        await updateTask(id, updatedTask); 
        fetchTasks(); // Récupère les tâches mises à jour après la modification
        setEditingTask(null); // Réinitialiser l'édition après la mise à jour
    };

    // Filtrer les tâches en fonction du filtre sélectionné
    const filteredTasks = tasks.filter(task => {
        if (filter === 'completed') return task.completed;
        if (filter === 'incomplete') return !task.completed;
        return true; // 'all'
    });

    return (
        <div className='todo-wrapper'>
            <h1>Liste des Tâches</h1>
            <TaskForm onCreateTask={handleCreateTask} />
            {editingTask && (
                <TaskEditForm task={editingTask} onUpdate={handleUpdateTask} />
            )}
            <TaskFilter filter={filter} setFilter={setFilter} /> {/* Ajout du composant TaskFilter */}
            <div className="todo-list">
                {filteredTasks.length === 0 ? (
                    <h1>
                        {filter === 'completed'
                            ? 'Aucune tâche complétée'
                            : filter === 'incomplete'
                                ? 'Aucune tâche non complétée'
                                : 'Aucune tâche ajoutée pour le moment'}
                    </h1>
                ) : (
                    filteredTasks.map((task) => (
                        <Task
                            key={task.id}
                            task={task}
                            onUpdateTask={handleUpdateTask}
                            onEditingTask={() => setEditingTask(task)}
                            onDeleteTask={handleDeleteTask}
                        />
                    ))
                )}
            </div>
        </div>
    );
};

export default TaskList;
