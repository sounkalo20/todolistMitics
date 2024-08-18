import axios from 'axios';

// Base URL de l'API
const API_URL = 'http://localhost/todoList/todolist/backend/api';

// Fonction pour récupérer toutes les tâches
export const getTasks = async () => {
    return await axios.get(`${API_URL}/get.php`);
};

// Fonction pour créer une nouvelle tâche
export const createTask = async (task) => {
    return await axios.postForm(`${API_URL}/post.php`, task);
};
// Fonction pour modifier tâche
export const updateTask = async (id, updatedTask) => {
    try {
        const response = await axios.put(`${API_URL}/put.php`, updatedTask, {
            params: { id } // Passer l'identifiant en tant que paramètre d'URL
        });
        return response.data;
    } catch (error) {
        // Gérer les erreurs
        console.error('Erreur lors de la mise à jour de la tâche:', error);
        throw error;
    }
};


// Fonction pour supprimer une tâche
export const deleteTask = async (id) => {
    return await axios.delete(`${API_URL}/delete.php?id=${id}`);
};
