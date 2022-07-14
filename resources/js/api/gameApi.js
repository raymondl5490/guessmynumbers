export default {
    async index() {
        return await axios.get('games').then(response => {
            return response.data.data;
        }).catch(error => {
            console.error({error});
        });
    },
    async submitted() {
        return await axios.get('games/submitted').then(response => {
            return response.data.data;
        }).catch(error => {
            console.error({error});
        });
    },
    async queued() {
        return await axios.get('games/queued-or-current').then(response => {
            return response.data.data;
        }).catch(error => {
            console.error({error});
        });
    },
    async finished() {
        return await axios.get('games/finished').then(response => {
            return response.data.data;
        }).catch(error => {
            console.error({error});
        });
    },
    async getGameById(gameId) {
        return await axios.get(`games/${gameId}`).then(response => {
            return response.data.data;
        }).catch(error => {
            console.error({error})
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
    },
    async updateLiveOn(gameId, payload) {
        return await axios.patch(`games/${gameId}/live-on`, payload).then(response => {
            return response.data.data;
        }).catch(error => {
            console.error({error});
        })
    },
    async approve(gameId) {
        return await axios.patch(`games/${gameId}/approve`).then(response => {
            return response.data.data;
        }).catch(error => {
            console.error({error});
        })
    },
    async remove(gameId) {
        await axios.delete(`games/${gameId}`).then(response => {
            return response.data.data;
        }).catch(error => {
            console.error({error});
        })
    },
}
