<template>
    <div>
        <div>Result Texts</div>
        <div v-if="loading">Loading</div>
        <div v-else class="gap-8 space-y-10 columns-1 sm:columns-2 md:columns-3">
            <div v-for="(resultText, index) in resultTexts" class="mt-3" :key="'setting_' + resultText.key">
                <label class="block text-sm font-medium text-gray-700">{{SETTING_DISPLAY_NAME_BY_KEY[resultText.key]}}</label>
                <div v-for="(text, index) in resultText.value" class="mt-1" :key="'_text_' + index">
                    <input v-model="resultText.value[index]" class="input" />
                </div>
            </div>
        </div>
        <el-button :disabled="loading" @click="onSave" type="primary">Save</el-button>
    </div>
</template>
<script>
import { settingApi } from "../../api";
import { SETTING_DISPLAY_NAME_BY_KEY } from "../../utils/constants";

export default {
    data() {
        return {
            loading: true,
            resultTexts: [],
            SETTING_DISPLAY_NAME_BY_KEY,
        };
    },
    async mounted() {
        this.loading = true;
        await this.fetchResultTexts();
        this.loading = false;
    },
    methods: {
        async fetchResultTexts() {
            this.resultTexts = await settingApi.getResultTexts();
        },
        async onSave() {
            await Promise.all(_.map(this.resultTexts, (resultText) => settingApi.updateSettingByKey(resultText.key, resultText.value)))
            this.fetchResultTexts();
        },
    },
}
</script>
