<template>
    <div class="container mx-auto">
        <div>{{currentGame.author_name}}</div>

        <el-collapse :model-value="['submitted', 'queued']">
            <el-collapse-item title="Submitted Games" name="submitted">
                <el-table :data="filteredSubmittedGames">
                    <el-table-column label="ID" prop="id" width="50px"/>
                    <el-table-column label="Numbers" width="100px">
                        <template #default="scope">
                            {{scope.row.number_one}} - {{scope.row.number_two}} - {{scope.row.number_three}}
                        </template>
                    </el-table-column>
                    <el-table-column label="Author">
                        <template #default="scope">
                            <p>{{scope.row.author_name}}</p>
                            <p>{{scope.row.author_location}}</p>
                            <el-link :href="'mailto:'+ scope.row.author_email" target="_blank" type="primary">
                                {{scope.row.author_email}}
                            </el-link>
                        </template>
                    </el-table-column>
                    <el-table-column label="Link">
                        <template #default="scope">
                            <el-link :href="scope.row.link" target="_blank" type="primary">{{scope.row.link_title}}</el-link>
                        </template>
                    </el-table-column>
                    <el-table-column align="right">
                        <template #header>
                            <el-row>
                                <el-col :span="20">
                                    <el-input v-model="search" size="small" placeholder="Type to search" />
                                </el-col>
                                <el-col :span="4">
                                    <el-button size="small" type="primary" @click="isVisibleGameDialogCreate = true">Create</el-button>
                                </el-col>
                            </el-row>
                        </template>
                        <template #default="scope">
                            <el-button size="small" type="primary" @click="onApproveClicked(scope.$index, scope.row)">Approve</el-button>
                            <el-button size="small" type="success" @click="onEditClicked(scope.$index, scope.row)">Edit</el-button>
                            <el-button size="small" type="danger" @click="onRemoveClicked(scope.$index, scope.row)">Remove</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </el-collapse-item>

            <el-collapse-item title="Queued Games" name="queued">
                <el-table :data="queuedGames">
                    <el-table-column label="ID" prop="id" width="50px"/>
                    <el-table-column label="Numbers" width="100px">
                        <template #default="scope">
                            {{scope.row.number_one}} - {{scope.row.number_two}} - {{scope.row.number_three}}
                        </template>
                    </el-table-column>
                    <el-table-column label="Author">
                        <template #default="scope">
                            <p>{{scope.row.author_name}}</p>
                            <p>{{scope.row.author_location}}</p>
                            <el-link :href="'mailto:'+ scope.row.author_email" target="_blank" type="primary">
                                {{scope.row.author_email}}
                            </el-link>
                        </template>
                    </el-table-column>
                    <el-table-column label="Link">
                        <template #default="scope">
                            <el-link :href="scope.row.link" target="_blank" type="primary">{{scope.row.link_title}}</el-link>
                        </template>
                    </el-table-column>
                    <el-table-column label="Live on">
                        <template #default="scope">
                            {{scope.row.live_on}}
                        </template>
                    </el-table-column>
                    <el-table-column align="right">
                        <template #default="scope">
                            <el-button size="small" type="success" @click="onEditClicked(scope.$index, scope.row)">Edit</el-button>
                            <el-button size="small" type="danger" @click="onRemoveClicked(scope.$index, scope.row)">Remove</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </el-collapse-item>

            <el-collapse-item title="Finished Games" name="finished">
                <el-table :data="finishedGames">
                    <el-table-column label="ID" prop="id" width="50px"/>
                    <el-table-column label="Numbers" width="100px">
                        <template #default="scope">
                            {{scope.row.number_one}} - {{scope.row.number_two}} - {{scope.row.number_three}}
                        </template>
                    </el-table-column>
                    <el-table-column label="Author">
                        <template #default="scope">
                            <p>{{scope.row.author_name}}</p>
                            <p>{{scope.row.author_location}}</p>
                            <el-link :href="'mailto:'+ scope.row.author_email" target="_blank" type="primary">
                                {{scope.row.author_email}}
                            </el-link>
                        </template>
                    </el-table-column>
                    <el-table-column label="Link">
                        <template #default="scope">
                            <el-link :href="scope.row.link" target="_blank" type="primary">{{scope.row.link_title}}</el-link>
                        </template>
                    </el-table-column>
                    <el-table-column label="Live on">
                        <template #default="scope">
                            {{scope.row.live_on}}
                        </template>
                    </el-table-column>
                    <el-table-column align="right">
                        <template #default="scope">
                            <el-button size="small" type="danger" @click="onRemoveClicked(scope.$index, scope.row)">Remove</el-button>
                        </template>
                    </el-table-column>
                </el-table>
            </el-collapse-item>
        </el-collapse>

        <game-dialog-create v-model="isVisibleGameDialogCreate" @submitted="isVisibleGameDialogCreate = false;"></game-dialog-create>

        <game-dialog-edit v-model="isVisibleGameDialogEdit" :game-id="editingGameId" @submitted="isVisibleGameDialogEdit = false;"></game-dialog-edit>

    </div>
</template>
<script>
import {mapActions, mapState} from "pinia";
import {useGameStore} from "../store";
import { parseISO, format } from 'date-fns'
import GameDialogCreate from "../components/modals/GameDialogCreate.vue";
import GameDialogEdit from "../components/modals/GameDialogEdit.vue";

export default {
    components: {
        GameDialogCreate,
        GameDialogEdit,
    },
    data() {
        return {
            isVisibleGameDialogCreate: false,
            isVisibleGameDialogEdit: false,
            editingGameId: 0,

            selectedGame: null,
            search: '',
        };
    },
    async created() {
        await Promise.all([
            this.getCurrentGame(),
            this.refreshGames(),
        ]);
    },

    computed: {
        ...mapState(useGameStore, ['currentGame', 'submittedGames', 'queuedGames', 'finishedGames']),
        filteredSubmittedGames() {
            return this.submittedGames.filter(
                (data) =>
                !this.search ||
                (data.author_name + data.author_email + data.author_location + data.link_title + data.link)
                .toLowerCase().includes(this.search.toLowerCase())
            )
        },
    },
    methods: {
        ...mapActions(useGameStore, ['getCurrentGame', 'refreshGames', 'removeGame']),
        formatDate(date) {
            if (!date) {
                return;
            }

            let parsedDate = parseISO(date);
            return format(parsedDate, 'MMM do, yyyy h:mm aaa');
        },
        onApproveClicked(index, row) {
            console.log('approve');
            console.log(index, row)
        },
        onEditClicked(index, row) {
            this.editingGameId = row.id;
            this.isVisibleGameDialogEdit = true;
        },
        async onRemoveClicked(index, row) {
            await this.removeGame(row.id);
        },
    }
}
</script>
