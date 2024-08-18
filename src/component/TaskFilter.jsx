import React from 'react';

const TaskFilter = ({ filter, setFilter }) => {
    return (
        <div className='btn-area'>
            <button
                className={`secondaryBtn ${filter === 'all' ? 'active' : ''}`}
                onClick={() => setFilter('all')}
            >
                Tous
            </button>
            <button
                className={`secondaryBtn ${filter === 'completed' ? 'active' : ''}`}
                onClick={() => setFilter('completed')}
            >
                Complétés
            </button>
            <button
                className={`secondaryBtn ${filter === 'incomplete' ? 'active' : ''}`}
                onClick={() => setFilter('incomplete')}
            >
                Non Complétés
            </button>
        </div>
    );
};

export default TaskFilter;
