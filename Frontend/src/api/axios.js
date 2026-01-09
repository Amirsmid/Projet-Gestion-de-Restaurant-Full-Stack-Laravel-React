import axios from 'axios'
import { BaseUrl } from "./shared";

export default axios.create({
    baseURL: BaseUrl
})