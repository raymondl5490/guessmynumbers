<template>
    <el-dialog :title="dialogType === 'create' ? 'Create Game' : 'Edit Game'">
        <el-form ref="formEl" :model="form" :rules="rules" label-width="140px" status-icon label-position="top">
            <el-form-item label="Numbers">
                <el-input-number v-model="form.number_one" :min="0" :max="9" controls-position="right" />
                <el-input-number v-model="form.number_two" :min="0" :max="9" controls-position="right" />
                <el-input-number v-model="form.number_three" :min="0" :max="9" controls-position="right" />
            </el-form-item>
            <el-form-item label="Author Name">
                <el-input v-model="form.author_name" />
            </el-form-item>
            <el-form-item label="Author Email">
                <el-input v-model="form.author_email" />
            </el-form-item>
            <el-form-item label="Author Location">
                <el-input v-model="form.author_location" />
            </el-form-item>
            <el-form-item label="Link">
                <el-input v-model="form.link" />
            </el-form-item>
        </el-form>
        <template #footer>
            <span class="dialog-footer">
                <el-button type="primary" @click="onSubmitClicked">
                    {{dialogType === 'create' ? 'Create' : 'Edit'}}
                </el-button>
            </span>
        </template>
    </el-dialog>
</template>
<script>
import { mapActions } from 'pinia';
import { useGameStore } from '../../store';
import { gameApi } from '../../api';

export default {
    name: 'GameDialog',
    emits: ['submitted'],
    props: {
        dialogType: {
            type: String,
            required: true,
            validator: function (value) {
                return _.includes(['create', 'edit'], value);
            },
        },
        gameId: {
            type: Number,
        },
    },
    data() {
        return {
            form: {
                number_one: 0,
                number_two: 0,
                number_three: 0,
                author_name: '',
                author_email: '',
                author_location: '',
                link: '',
            },
            rules: {
                number_one: [
                    { required: true, message: 'Please input number', trigger: 'blur' },
                    { min: 1, max: 1, message: 'One digit Number', trigger: 'blur' },
                ],
                number_two: [
                    { required: true, message: 'Please input number', trigger: 'blur' },
                    { min: 1, max: 1, message: 'One digit Number', trigger: 'blur' },
                ],
                number_three: [
                    { required: true, message: 'Please input number', trigger: 'blur' },
                    { min: 1, max: 1, message: 'One digit Number', trigger: 'blur' },
                ],
                author_name: [
                    { required: true, message: 'Please input author name', trigger: 'blur' },
                    { min: 2, max: 60, message: 'Length should be 2 to 60', trigger: 'blur' },
                ],
                author_email: [
                    { type: 'email', message: 'The author email must be a valid email address.', trigger: ['blur', 'change'] },
                ],
                author_location: [
                    { min: 2, max: 255, message: 'Length should be 2 to 255', trigger: 'blur' },
                ],
                link: [
                    { type: 'url', message: 'The link must be a valid URL.', trigger: ['blur', 'change'] },
                ],
            },
        };
    },
    watch: {
        async gameId() {
            if (this.dialogType === 'edit') {
                this.form = await gameApi.getGameById(this.gameId);
            }
        }
    },
    methods: {
        ...mapActions(useGameStore, ['createGame', 'updateGame']),

        async onSubmitClicked() {
            const valid = await this.$refs.formEl.validate();
            if (!valid) {
                console.log('invalid fields');
                return;
            }
            console.log('submit', this.$refs.formEl)

            if (this.dialogType === 'create') {
                await this.createGame(this.form);
            } else if (this.dialogType === 'edit') {
                await this.updateGame(this.gameId, this.form);
            }
            this.$emit('submitted');
        },
    },
}
</script>