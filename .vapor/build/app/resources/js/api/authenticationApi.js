export default {
    async getCSRFToken() {
        try {
            return await axios.get('/sanctum/csrf-cookie');
        } catch (error) {
            console.log({error})
        }
    }
}
