export default {
    async index() {
        return await axios.get('games').then(response => {
            return response.data.data;
        }).catch(error => {
            console.error({error});
        });
    },
    async store(payload) {
        return await axios.post('games', payload).then(response => {
            return response.data.data;
        }).catch(error => {
            console.error({error})
        });
    },
    async update(gameId, payload) {
        return await axios.patch(`games/${gameId}`, payload).then(response => {
            return response.data.data;
        }).catch(error => {
            console.error({error});
        })
    }
}
