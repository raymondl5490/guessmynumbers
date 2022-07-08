export default {
    async createAttempt(playerId, payload) {
        return await axios.post(`players/${playerId}/attempts`, payload).then(response => {
            return response.data.data;
        }).catch(error => {
            console.log({error});
        })
    },
    async getCurrentAttempt(playerId) {
        return await axios.get(`players/${playerId}/attempts/current`).then(response => {
            return response.data.data;
        }).catch(error => {
            console.log({error});
        });
    },
    async winAttempt(attemptId) {
        return await axios.patch(`attempts/${attemptId}/win`).then(response => {
            return response.data.data;
        }).catch(error => {
            console.log({error});
        });
    },
    async hasSubmittedVipGame(attemptId) {
        return await axios.patch(`attempts/${attemptId}/has-submitted-vip-game`).then(response => {
            return response.data.data;
        }).catch(error => {
            console.log({error});
        });
    },
    async getOverallStatistics() {
        return await axios.get('attempts/overall-statistics').then(response => {
            return response.data;
        }).catch(error => {
            console.log({error});
        });
    },
}
