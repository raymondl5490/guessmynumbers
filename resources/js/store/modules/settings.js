import {settingApi} from '../../api'
import {defineStore} from "pinia";

const SETTING_KEYS = [
    'result_text_win_try_1',
    'result_text_win_try_2',
    'result_text_win_try_3',
    'result_text_lose_correct_0',
    'result_text_lose_correct_1',
    'result_text_lose_correct_2',
];

export default defineStore('settings', {
    state: () => ({
        allSettings: [],
    }),
    getters: {
        settingValueByKey() {
            return (key) => {
                const setting = _.find(this.allSettings, setting => setting.key === key);
                return setting && setting.value;
            };
        },
    },
    actions: {
        // TODO: should be changed to index
        async getResultTexts() {
            this.allSettings = await settingApi.getResultTexts();
        },
        async getSettingByKey(key) {
            const value = await settingApi.getSettingByKey(key);
            _.each(this.allSettings, (setting) => {
                if (setting.key === 'key') {
                    setting.value = value;
                }
            });
        },
        async updateSettingByKey(key, value) {
            await settingApi.updateSettingByKey(key, value);
            await this.getResultTexts();
        },
    },
    persistedState: {
        persist: false,
    },
})
