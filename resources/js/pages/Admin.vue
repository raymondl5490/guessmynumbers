<template>
    <div class="container mx-auto">
        <div class="flex flex-col items-center justify-center p-8">
            <p class="m-4 text-6xl text-center md:text-8xl">
                {{currentGame.number_one}} - {{currentGame.number_two}} - {{currentGame.number_three}}
            </p>
            <p class="text-sm text-center text-gray-500">
                SUBMMITED BY 
                <span class="font-bold text-blue-900">
                    <a :href="currentGame.link" class="underline">
                        {{currentGame.author_name}}
                    </a>
                    , {{currentGame.author_location}}
                </span>
                AT
                <span class="font-bold text-blue-900">
                    {{(new Date(currentGame.created_at).toDateString())}}
                </span>
            </p>
        </div>

        <div class="grid grid-cols-1 gap-2 py-4 m-8 sm:grid-cols-3 md:gap-4">
            <div class="flex flex-col items-center justify-center p-2 border-2 rounded-md shadow-sm">
                <div class="text-4xl font-bold text-blue-900">{{currentGame.number_of_attempts}}</div>
                <div class="text-sm text-gray-500">Players</div>
            </div>
            <div class="flex flex-col items-center justify-center p-2 border-2 rounded-md shadow-sm">
                <div class="text-4xl font-bold text-blue-900">{{currentGame.number_of_wons}}</div>
                <div class="text-sm text-gray-500">Winners</div>
            </div>
            <div class="flex flex-col items-center justify-center p-2 border-2 rounded-md shadow-sm">
                <div class="text-4xl font-bold text-blue-900">{{currentRoundWinPercentage}}%</div>
                <div class="text-sm text-gray-500">Winners/Players</div>
            </div>
        </div>

        <el-collapse :model-value="['submitted', 'queued']" class="p-4 m-8 text-center border-2 rounded-md shadow-sm">
            <el-collapse-item title="Submitted Games" name="submitted">
                <template #title>
                    <div class="flex items-center content-center justify-between w-full">
                        <p>Submitted Games</p>
                        <el-button size="small" type="primary" @click.stop="showGameModalCreate = true">Create</el-button>
                    </div>
                </template>
                <el-table :data="filteredSubmittedGames">
                    <el-table-column label="ID" fixed prop="id" width="50px"/>
                    <el-table-column label="NUMBERS" width="100px">
                        <template #default="scope">
                            {{scope.row.number_one}} - {{scope.row.number_two}} - {{scope.row.number_three}}
                        </template>
                    </el-table-column>
                    <el-table-column label="SUBMITTED BY">
                        <template #default="scope">
                            <p class="font-bold text-blue-900">
                                <a :href="scope.row.link" class="underline">
                                    {{scope.row.author_name}}
                                </a>
                                , {{scope.row.author_location}}
                            </p>
                            <el-link :href="'mailto:'+ scope.row.author_email" target="_blank" type="primary">
                                {{scope.row.author_email}}
                            </el-link>
                        </template>
                    </el-table-column>
                    <el-table-column fixed="right" width="100">
                        <template #header>
                            <el-input v-model="search" size="small" placeholder="Type to search" />
                        </template>
                        <template #default="scope">
                            <div class="grid grid-cols-1 gap-0">
                                <div>
                                    <el-button size="small" class="w-full" type="primary" @click="onApproveClicked(scope.$index, scope.row)">Approve</el-button>
                                </div>
                                <div>
                                    <el-button size="small" class="w-full" type="success" @click="onEditClicked(scope.$index, scope.row)">Edit</el-button>
                                </div>
                                <div>
                                    <el-button size="small" class="w-full" type="danger" @click="onRemoveClicked(scope.$index, scope.row)">Remove</el-button>
                                </div>
                            </div>
                        </template>
                    </el-table-column>
                </el-table>
            </el-collapse-item>

            <el-collapse-item title="Queued Games" name="queued">
                <el-table v-loading="queuedLoading" id="queued-games-table" :data="queuedGames" :key="queuedTableKey">
                    <el-table-column label="ID" fixed prop="id" width="50px"/>
                    <el-table-column label="NUMBERS" width="100px">
                        <template #default="scope">
                            {{scope.row.number_one}} - {{scope.row.number_two}} - {{scope.row.number_three}}
                        </template>
                    </el-table-column>
                    <el-table-column label="SUBMITTED BY">
                        <template #default="scope">
                            <p class="font-bold text-blue-900">
                                <a :href="scope.row.link" class="underline">
                                    {{scope.row.author_name}}
                                </a>
                                , {{scope.row.author_location}}
                            </p>
                            <el-link :href="'mailto:'+ scope.row.author_email" target="_blank" type="primary">
                                {{scope.row.author_email}}
                            </el-link>
                        </template>
                    </el-table-column>
                    <el-table-column label="Live on" width="150">
                        <template #default="scope">
                            {{scope.row.live_on}}
                        </template>
                    </el-table-column>
                    <el-table-column fixed="right" width="100">
                        <template #default="scope">
                            <div class="grid grid-cols-1 gap-0">
                                <div>
                                    <el-button size="small" class="w-full" type="success" @click="onEditClicked(scope.$index, scope.row)">Edit</el-button>
                                </div>
                                <div>
                                    <el-button size="small" class="w-full" type="danger" @click="onRemoveClicked(scope.$index, scope.row)">Remove</el-button>
                                </div>
                            </div>
                        </template>
                    </el-table-column>
                </el-table>
            </el-collapse-item>

            <el-collapse-item title="Finished Games" name="finished">
                <el-table :data="finishedGames">
                    <el-table-column label="ID" fixed prop="id" width="50px"/>
                    <el-table-column label="NUMBERS" width="100px">
                        <template #default="scope">
                            {{scope.row.number_one}} - {{scope.row.number_two}} - {{scope.row.number_three}}
                        </template>
                    </el-table-column>
                    <el-table-column label="SUBMITTED BY">
                        <template #default="scope">
                            <p class="font-bold text-blue-900">
                                <a :href="scope.row.link" class="underline">
                                    {{scope.row.author_name}}
                                </a>
                                , {{scope.row.author_location}}
                            </p>
                            <el-link :href="'mailto:'+ scope.row.author_email" target="_blank" type="primary">
                                {{scope.row.author_email}}
                            </el-link>
                        </template>
                    </el-table-column>
                    <el-table-column label="Live on" width="150">
                        <template #default="scope">
                            {{scope.row.live_on}}
                        </template>
                    </el-table-column>
                    <el-table-column fixed="right" width="100">
                        <template #default="scope">
                            <div class="grid grid-cols-1 gap-0">
                                <div>
                                    <el-button size="small" class="w-full" type="danger" @click="onRemoveClicked(scope.$index, scope.row)">Remove</el-button>
                                </div>
                            </div>
                        </template>
                    </el-table-column>
                </el-table>
            </el-collapse-item>
        </el-collapse>

        <GameModalCreate :show="showGameModalCreate" :is-admin="true" @close="showGameModalCreate = false" />
        <GameModalEdit :show="showGameModalEdit" :is-admin="true" :game-id="editingGameId" @close="showGameModalEdit = false" />

    </div>
</template>
<script>
import {mapActions, mapState} from "pinia";
import {useGameStore} from "../store";
import GameModalCreate from "../components/modals/GameModalCreate.vue";
import GameModalEdit from "../components/modals/GameModalEdit.vue";
import Sortable from 'sortablejs';
import { v4 as uuidv4 } from 'uuid';
import { nextTick } from "vue";

export default {
    components: {
        GameModalCreate,
        GameModalEdit,
    },
    data() {
        return {
            showGameModalCreate: false,
            showGameModalEdit: false,
            editingGameId: 0,

            queuedLoading: false,

            selectedGame: null,
            search: '',
            sortable: null,
            queuedTableKey: 'queued_games_table_',
        };
    },
    async created() {
        await Promise.all([
            this.getCurrentGame(),
            this.refreshGames(),
        ]);
    },
    mounted() {
        this.initSortable();
    },
    computed: {
        ...mapState(useGameStore, ['currentGame', 'submittedGames', 'queuedGames', 'finishedGames']),
        filteredSubmittedGames() {
            return this.submittedGames.filter((data) =>
                !this.search ||
                (data.author_name + data.author_email + data.author_location + data.link)
                .toLowerCase().includes(this.search.toLowerCase())
            )
        },
        currentRoundWinPercentage() {
            const number_of_attempts = this.currentGame.number_of_attempts;
            const number_of_wons = this.currentGame.number_of_wons;
            if (!number_of_attempts) return 0;
            return _.min([_.round(number_of_wons / number_of_attempts * 100, 0), 100]);
        },
    },
    methods: {
        ...mapActions(useGameStore, ['getCurrentGame', 'refreshGames', 'approveGame', 'removeGame', 'reorderGames']),
        initSortable() {
            const el = document.querySelector('#queued-games-table tbody');
            this.sortable = Sortable.create(el, {
                animation: 180,
                delay: 0,
                onEnd: async evt => {
                    if (evt.oldIndex === evt.newIndex) return;
                    this.queuedLoading = true;
                    await this.reorderGames(evt.oldIndex, evt.newIndex);
                    this.queuedLoading = false;
                    this.queuedTableKey = 'queued_games_table_' + uuidv4();
                    // location.reload();
                    await nextTick();
                    this.initSortable();
                }
            });
        },
        async onApproveClicked(index, row) {
            await this.approveGame(row.id);

        },
        onEditClicked(index, row) {
            this.editingGameId = row.id;
            this.showGameModalEdit = true;
        },
        async onRemoveClicked(index, row) {
            await this.removeGame(row.id);
        },
    }
}
</script>
