export default {
    async getCurrentGame() {
        return await axios.get('games/current').then(response => {
            return response.data;
        }).catch(error => {
            console.error({error});
        });
    },
}
