export default {
    async createAttempt(playerId, payload) {
        console.log({payload})
        return await axios.post(`players/${playerId}/attempts`, payload).then(response => {
            return response.data.data;
        }).catch(error => {
            console.log({error});
        })
    }
}
