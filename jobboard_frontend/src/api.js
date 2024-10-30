import axios from 'axios';

const API_URL = "http://localhost:8000/api";  

export const fetchOffers = async () => {
  try {
    const response = await axios.get(`${API_URL}/offers`);
    return response.data;
  } catch (error) {
    console.error("Failed to fetch offers", error);
    return [];
  }
};