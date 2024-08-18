// src/components/TaskList.js

import React, { useState, useEffect } from 'react';
import Task from './Task';
import TaskForm from './TaskForm';
import TaskEditForm from './TaskEditForm';
import TaskFilter from './TaskFilter'; // Importation du composant TaskFilter
import { getTasks, createTask, updateTask, deleteTask } from '../services/todoService';

const TaskList = () => {
    const [tasks, setTasks] = useState([]);
    const [editingTask, setEditingTask] = useState(null);
    const [filter, setFilter] = useState('all'); // État pour le filtre

    useEffect(() => {
        fetchTasks();
    }, []);

    const fetchTasks = async () => {
        const response = await getTasks();
        setTasks(response.data);
    };

    const handleCreateTask = async (task) => {
        await createTask(task);
        fetchTasks();
    };

    const handleDeleteTask = async (id) => {
        await deleteTask(id);
        fetchTasks();
    };

    const handleUpdateTask = async (id, updatedTask) => {
        await updateTask(id, updatedTask);
        fetchTasks();
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
                {filteredTasks.map((task) => (
                    <Task
                        key={task.id}
                        task={task}
                        onUpdateTask={handleUpdateTask}
                        onEditingTask={() => setEditingTask(task)}
                        onDeleteTask={handleDeleteTask}
                    />
                ))}
            </div>
        </div>
    );
};

export default TaskList;
