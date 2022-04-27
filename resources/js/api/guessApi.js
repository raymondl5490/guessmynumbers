export default {
    async createGuess(playerId, attemptId, payload) {
        return await axios.post(`players/${playerId}/attempts/${attemptId}/guesses`, payload).then(response => {
            return response.data.data;
        }).catch(error => {
            console.log({error})
        })
    }
}
