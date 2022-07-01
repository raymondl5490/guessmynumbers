export default {
    async getResultTexts() {
        return await axios.get('settings/result-texts').then(response => {
            return response.data;
        }).catch(error => {
            console.error({error});
        })
    },
    async getSettingByKey(key) {
        return await axios.get(`settings/${key}`).then(response => {
            return response.data;
        }).catch(error => {
            console.error({error});
        })
    },
    async updateSettingByKey(key, value) {
        return await axios.put(`settings/${key}`, value).then(response => {
            return response.data;
        }).catch(error => {
            console.error({error});
        })
    },
}
