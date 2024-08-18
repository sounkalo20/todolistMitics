// src/components/Task.js

import { faSquarePen, faTrash } from '@fortawesome/free-solid-svg-icons';
import { FontAwesomeIcon } from '@fortawesome/react-fontawesome';
import React from 'react';

// Composant pour afficher une tâche individuelle
const Task = ({ task, onUpdateTask, onDeleteTask }) => {
    return (
        <div className='todo-list-item'>
            <div>
                <h2>{task.title}</h2>
                <p>{task.description}</p>
            </div>
            <div className='btnZone'>
                <input type="checkbox" checked={task.completed ? true : false} onChange={() => onUpdateTask(task.id, { ...task, completed: !task.completed })} className='check-icon'/>
                <FontAwesomeIcon icon={faSquarePen} size='25' style={{ cursor: 'pointer', fontSize: '20px' }} />
                <FontAwesomeIcon icon={faTrash} color='red' onClick={() => onDeleteTask(task.id)} style={{ cursor: 'pointer', fontSize: '20px' }} />
            </div>
        </div>
    );
};

export default Task;
