import axios from "../api/axios";

export const ArticleByCategory = async (catId) => {
    return await axios.get("article_par_categorie/" + catId);
}
export const AllArticle = async () => {
    return await axios.get("tout_article");
} 