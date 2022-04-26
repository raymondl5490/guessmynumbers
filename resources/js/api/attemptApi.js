export default {
    async createAttempt(gameId) {
        return await axios.post(`api/games/${gameId}/attempts`).then(response => {
            return response.data.data;
        }).catch(error => {
            console.log({error});
        })
    }
}
