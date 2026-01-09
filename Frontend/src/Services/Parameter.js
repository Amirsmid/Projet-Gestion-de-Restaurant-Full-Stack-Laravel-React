import axios from "../api/axios";

const _API = "parameter"

export const GetParams = async () => {
    return await axios.get(_API);
}