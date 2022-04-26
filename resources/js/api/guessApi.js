export default {
    async createGuess(gameId, attemptId, payload) {
        return await axios.post(`api/games/${gameId}/attempts/${attemptId}/guesses`, payload).then(response => {
            return response.data.data;
        }).catch(error => {
            console.log({error})
        })
    }
}
