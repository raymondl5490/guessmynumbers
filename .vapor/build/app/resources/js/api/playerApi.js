export default {
    async getPlayer(playerId) {
        return await axios.get(`/players/${playerId}`).then(response => {
            return response.data.data;
        }).catch(error => {
            console.log({error})
        })
    },
    async createPlayer() {
        return await axios.post('/players').then(response => {
            return response.data.data;
        }).catch(error => {
            console.log({error})
        })
    }
}
