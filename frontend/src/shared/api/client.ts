import axios from 'axios';

export const apiClient = axios.create({
    baseURL: 'http://symf.commerce.local:8081/api',
    headers: {
        'Content-Type': 'application/json',
    },
});