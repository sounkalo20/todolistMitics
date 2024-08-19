import axios from 'axios';

// Base URL de l'API
const API_URL = 'http://localhost/todolistMitics/backend/api';

// Token non haché
const TOKEN = 'aB3$eT1*Xz7&';

// Fonction pour récupérer toutes les tâches
export const getTasks = async () => {
    try {
        const response = await axios.post(`${API_URL}/get.php`, { token: TOKEN });
        return response.data;
    } catch (error) {
        console.error('Erreur lors de la récupération des tâches:', error);
        throw error;
    }
};

// Fonction pour créer une nouvelle tâche
export const createTask = async (task) => {
    try {
        const response = await axios.post(`${API_URL}/post.php`, { ...task, token: TOKEN });
        return response.data;
    } catch (error) {
        console.error('Erreur lors de la création de la tâche:', error);
        throw error;
    }
};

// Fonction pour mettre à jour une tâche
export const updateTask = async (id, updatedTask) => {
    try {
        const response = await axios.put(`${API_URL}/put.php`, { ...updatedTask, id, token: TOKEN });
        return response.data;
    } catch (error) {
        console.error('Erreur lors de la mise à jour de la tâche:', error);
        throw error;
    }
};

// Fonction pour supprimer une tâche
export const deleteTask = async (id) => {
    try {
        const response = await axios.delete(`${API_URL}/delete.php`, {
            data: { id, token: TOKEN }
        });
        return response.data;
    } catch (error) {
        console.error('Erreur lors de la suppression de la tâche:', error);
        throw error;
    }
};
