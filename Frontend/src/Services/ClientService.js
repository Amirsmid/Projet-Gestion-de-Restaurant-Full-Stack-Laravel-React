import axios from "../api/axios";



export const AddUser = async (user) => {
    return await axios.post("inscrit_client", user);
}