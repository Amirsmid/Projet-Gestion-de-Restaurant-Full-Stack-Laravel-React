import axios from "../api/axios";


export const getCategories = async () => {
    return await axios.get("tout_categorie");
} 