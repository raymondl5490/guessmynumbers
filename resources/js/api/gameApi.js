export default {
    async index() {
        return await axios.get('games').then(response => {
            return response.data.data;
        }).catch(error => {
            console.error({error});
        });
    },
    async submitted(page = 1) {
        return await axios.get('games/submitted?page=' + page).then(response => {
            return response.data;
        }).catch(error => {
            console.error({error});
        });
    },
    async queued() {
        return await axios.get('games/queued').then(response => {
            return response.data.data;
        }).catch(error => {
            console.error({error});
        });
    },
    async finished(page = 1) {
        return await axios.get('games/finished?page=' + page).then(response => {
            return response.data;
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
    async getDailyStatistics() {
        return await axios.get('games/daily-statistics').then(response => {
            return response.data;
        }).catch(error => {
            console.log({error});
        });
    },
}
