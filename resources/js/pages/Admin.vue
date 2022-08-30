<template>
    <div class="container mx-auto">
        <div class="flex flex-col items-center justify-center p-8">
            <p class="m-4 text-3xl text-center sm:text-6xl md:text-8xl">
                {{currentGame.number_one}} - {{currentGame.number_two}} - {{currentGame.number_three}}
            </p>
            <p class="text-sm text-center text-gray-400 sm:text-base md:text-lg">
                <p class="whitespace-pre">
                    Submitted by: 
                </p>
                <p class="flex justify-center font-bold text-green-700 flex-nowrap">
                    <a :href="currentGame.link" target="_blank" class="underline">
                        {{currentGame.author_name}}
                    </a>
                    , {{currentGame.author_location}}
                    <img class="inline w-6 h-6" src="https://img.icons8.com/color/48/FAB005/approval--v3.png"/>
                </p>
                <p class="font-bold text-blue-900">
                    {{formatCurrentTime()}}
                </p>
            </p>
            <el-button size="small" type="success" @click="onEditClicked(null, currentGame)">Edit Current Game</el-button>
        </div>

        <div class="text-sm text-center text-gray-400 sm:text-base md:text-lg">Current Round</div>

        <div class="grid grid-cols-3 gap-2 py-1 mx-8 my-1 sm:py-4 sm:my-2 md:my-3 md:gap-4">
            <div class="flex flex-col items-center justify-center p-2 border-2 rounded-md shadow-sm">
                <div class="text-xl font-bold text-blue-900 sm:text-2xl md:text-3xl">{{currentGame.number_of_attempts}}</div>
                <div class="text-xs text-gray-500 sm:text-sm">Players</div>
            </div>
            <div class="flex flex-col items-center justify-center p-2 border-2 rounded-md shadow-sm">
                <div class="text-xl font-bold text-blue-900 sm:text-2xl md:text-3xl">{{currentGame.number_of_wons}}</div>
                <div class="text-xs text-gray-500 sm:text-sm">Winners</div>
            </div>
            <div class="flex flex-col items-center justify-center p-2 border-2 rounded-md shadow-sm">
                <div class="text-xl font-bold text-blue-900 sm:text-2xl md:text-3xl">{{winPercentage(currentGame)}}%</div>
                <div class="text-xs text-gray-500 sm:text-sm">Winners/Players</div>
            </div>
        </div>

        <div class="text-sm text-center text-gray-400 sm:text-base md:text-lg">Daily Statistics</div>

        <div class="grid grid-cols-3 gap-2 py-1 mx-8 my-1 sm:py-4 sm:my-2 md:my-3 md:gap-4">
            <div class="flex flex-col items-center justify-center p-2 border-2 rounded-md shadow-sm">
                <div class="text-xl font-bold text-blue-900 sm:text-2xl md:text-3xl">{{daily_statistics.number_of_attempts}}</div>
                <div class="text-xs text-gray-500 sm:text-sm">Players</div>
            </div>
            <div class="flex flex-col items-center justify-center p-2 border-2 rounded-md shadow-sm">
                <div class="text-xl font-bold text-blue-900 sm:text-2xl md:text-3xl">{{daily_statistics.number_of_wons}}</div>
                <div class="text-xs text-gray-500 sm:text-sm">Winners</div>
            </div>
            <div class="flex flex-col items-center justify-center p-2 border-2 rounded-md shadow-sm">
                <div class="text-xl font-bold text-blue-900 sm:text-2xl md:text-3xl">{{winPercentage(daily_statistics)}}%</div>
                <div class="text-xs text-gray-500 sm:text-sm">Winners/Players</div>
            </div>
        </div>

        <div class="text-sm text-center text-gray-400 sm:text-base md:text-lg">Overall Statistics</div>

        <div class="grid grid-cols-3 gap-2 py-1 mx-8 my-1 sm:py-4 sm:my-2 md:my-3 md:gap-4">
            <div class="flex flex-col items-center justify-center p-2 border-2 rounded-md shadow-sm">
                <div class="text-xl font-bold text-blue-900 sm:text-2xl md:text-3xl">{{overall_statistics.number_of_attempts}}</div>
                <div class="text-xs text-gray-500 sm:text-sm">Players</div>
            </div>
            <div class="flex flex-col items-center justify-center p-2 border-2 rounded-md shadow-sm">
                <div class="text-xl font-bold text-blue-900 sm:text-2xl md:text-3xl">{{overall_statistics.number_of_wons}}</div>
                <div class="text-xs text-gray-500 sm:text-sm">Winners</div>
            </div>
            <div class="flex flex-col items-center justify-center p-2 border-2 rounded-md shadow-sm">
                <div class="text-xl font-bold text-blue-900 sm:text-2xl md:text-3xl">{{winPercentage(overall_statistics)}}%</div>
                <div class="text-xs text-gray-500 sm:text-sm">Winners/Players</div>
            </div>
        </div>

        <el-collapse :model-value="['submitted', 'queued']" class="p-4 m-8 text-center border-2 rounded-md shadow-sm">

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
                                {{scope.row.author_name}}
                                , {{scope.row.author_location}}
                            </p>
                            <p>
                                <el-link :href="'mailto:'+ scope.row.author_email" target="_blank" type="primary">
                                    {{scope.row.author_email}}
                                </el-link>
                            </p>
                            <p>
                                <el-link :href="scope.row.link" target="_blank" type="success">
                                    {{scope.row.link}}
                                </el-link>
                            </p>
                        </template>
                    </el-table-column>
                    <el-table-column label="Live on" width="150">
                        <template #default="scope">
                            {{scope.row.live_on}}
                        </template>
                    </el-table-column>
                    <el-table-column fixed="right" width="70">
                        <template #default="scope">
                            <div class="grid grid-cols-1 gap-0">
                                <div>
                                    <el-button size="small" class="w-full" type="success" @click="onEditClicked(scope.$index, scope.row)">
                                        <el-icon><Edit /></el-icon>
                                    </el-button>
                                </div>
                                <div>
                                    <el-button size="small" class="w-full" type="danger" @click="onRemoveClicked(scope.$index, scope.row)">
                                        <el-icon><Delete /></el-icon>
                                    </el-button>
                                </div>
                            </div>
                        </template>
                    </el-table-column>
                </el-table>
            </el-collapse-item>

            <el-collapse-item title="Submitted Games" name="submitted">
                <template #title>
                    <div class="flex items-center content-center justify-between w-full">
                        <p>Submitted Games</p>
                        <div class="flex items-center content-center">
                            <el-pagination
                                v-if="submittedGamesPaginator"
                                layout="total, prev, pager, next"
                                :total="submittedGamesPaginator.meta.total"
                                :page-size="submittedGamesPaginator.meta.per_page"
                                :current-page="submittedGamesPaginator.meta.current_page"
                                @update:current-page="getSubmittedGames"
                                @click.stop=""
                            />
                            <el-button size="small" type="primary" @click.stop="showGameModalCreate = true">
                                <el-icon><Plus /></el-icon>
                            </el-button>
                        </div>
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
                                {{scope.row.author_name}}
                                , {{scope.row.author_location}}
                            </p>
                            <p>
                                <el-link :href="'mailto:'+ scope.row.author_email" target="_blank" type="primary">
                                    {{scope.row.author_email}}
                                </el-link>
                            </p>
                            <p>
                                <el-link :href="scope.row.link" target="_blank" type="success">
                                    {{scope.row.link}}
                                </el-link>
                            </p>
                            <p>{{convertISOFormat2Date(scope.row.created_at)}}</p>
                        </template>
                    </el-table-column>
                    <el-table-column fixed="right" width="70">
                        <template #header>
                            <el-input v-model="search" size="small" placeholder="Type to search" />
                        </template>
                        <template #default="scope">
                            <div class="grid grid-cols-1 gap-0">
                                <div>
                                    <el-button size="small" class="w-full" type="primary" @click="onApproveClicked(scope.$index, scope.row)">
                                        <el-icon><Check /></el-icon>
                                    </el-button>
                                </div>
                                <div>
                                    <el-button size="small" class="w-full" type="success" @click="onEditClicked(scope.$index, scope.row)">
                                        <el-icon><Edit /></el-icon>
                                    </el-button>
                                </div>
                                <div>
                                    <el-button size="small" class="w-full" type="danger" @click="onRemoveClicked(scope.$index, scope.row)">
                                        <el-icon><Delete /></el-icon>
                                    </el-button>
                                </div>
                            </div>
                        </template>
                    </el-table-column>
                </el-table>
            </el-collapse-item>

            <el-collapse-item title="Finished Games" name="finished">
                <template #title>
                    <div class="flex items-center content-center justify-between w-full">
                        <p>Finished Games</p>
                        <el-pagination
                            v-if="finishedGamesPaginator"
                            layout="total, prev, pager, next"
                            :total="finishedGamesPaginator.meta.total"
                            :page-size="finishedGamesPaginator.meta.per_page"
                            :current-page="finishedGamesPaginator.meta.current_page"
                            @update:current-page="getFinishedGames"
                            @click.stop
                        />
                    </div>
                </template>
                <el-table :data="finishedGamesPaginator && finishedGamesPaginator.data">
                    <el-table-column label="ID" fixed prop="id" width="50px"/>
                    <el-table-column label="NUMBERS" width="100px">
                        <template #default="scope">
                            {{scope.row.number_one}} - {{scope.row.number_two}} - {{scope.row.number_three}}
                        </template>
                    </el-table-column>
                    <el-table-column label="SUBMITTED BY">
                        <template #default="scope">
                            <p class="font-bold text-blue-900">
                                {{scope.row.author_name}}
                                , {{scope.row.author_location}}
                            </p>
                            <p>
                                <el-link :href="'mailto:'+ scope.row.author_email" target="_blank" type="primary">
                                    {{scope.row.author_email}}
                                </el-link>
                            </p>
                            <p>
                                <el-link :href="scope.row.link" target="_blank" type="success">
                                    {{scope.row.link}}
                                </el-link>
                            </p>
                        </template>
                    </el-table-column>
                    <el-table-column label="Live on" width="150">
                        <template #default="scope">
                            {{scope.row.live_on}}
                        </template>
                    </el-table-column>
                    <el-table-column label="Statistics">
                        <template #default="scope">
                            {{scope.row.number_of_wons}}/{{scope.row.number_of_attempts}}({{winPercentage(scope.row)}}%)
                        </template>
                    </el-table-column>
                    <el-table-column fixed="right" width="70">
                        <template #default="scope">
                            <div class="grid grid-cols-1 gap-0">
                                <div>
                                    <el-button size="small" class="w-full" type="success" @click="onCloneClicked(scope.$index, scope.row)">
                                        <el-icon><RefreshLeft /></el-icon>
                                    </el-button>
                                </div>
                                <div>
                                    <el-button size="small" class="w-full" type="danger" @click="onRemoveClicked(scope.$index, scope.row)">
                                        <el-icon><Delete /></el-icon>
                                    </el-button>
                                </div>
                            </div>
                        </template>
                    </el-table-column>
                </el-table>
            </el-collapse-item>
        </el-collapse>

        <ResultTextForm class="p-4 m-8 border-2 rounded-md shadow-sm" />

        <GameModalCreate v-model="showGameModalCreate" :is-admin="true" />
        <GameModalEdit v-model="showGameModalEdit" :is-admin="true" :game-id="editingGameId" />

    </div>
</template>
<script>
import {mapActions, mapState} from "pinia";
import {useGameStore} from "../store";
import GameModalCreate from "../components/modals/GameModalCreate.vue";
import GameModalEdit from "../components/modals/GameModalEdit.vue";
import ResultTextForm from "../components/forms/ResultTextForm.vue";
import Sortable from 'sortablejs';
import { v4 as uuidv4 } from 'uuid';
import { nextTick } from "vue";
import { gameApi, attemptApi } from "../api";
import { formatCurrentTime, convertISOFormat2Date } from "../utils";

export default {
    components: {
        GameModalCreate,
        GameModalEdit,
        ResultTextForm,
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

            overall_statistics: {},
            daily_statistics: {},
        };
    },
    async created() {
        await Promise.all([
            this.getCurrentGame(),
            this.refreshGames(),
        ]);
        this.overall_statistics = await attemptApi.getOverallStatistics();
        this.daily_statistics = await gameApi.getDailyStatistics();
    },
    mounted() {
        this.initSortable();
    },
    computed: {
        ...mapState(useGameStore, ['currentGame', 'submittedGamesPaginator', 'queuedGames', 'finishedGamesPaginator']),
        filteredSubmittedGames() {
            return this.submittedGamesPaginator && this.submittedGamesPaginator.data.filter((data) =>
                !this.search ||
                (data.author_name + data.author_email + data.author_location + data.link)
                .toLowerCase().includes(this.search.toLowerCase())
            )
        },
    },
    methods: {
        ...mapActions(useGameStore, ['getCurrentGame', 'getSubmittedGames', 'getFinishedGames', 'refreshGames', 'approveGame', 'cloneAndQueueGame', 'removeGame', 'handleQueueChange']),
        winPercentage(game) {
            const number_of_attempts = game.number_of_attempts;
            const number_of_wons = game.number_of_wons;
            if (!number_of_attempts) return 0;
            return _.min([_.round(number_of_wons / number_of_attempts * 100, 0), 100]);
        },
        initSortable() {
            const el = document.querySelector('#queued-games-table tbody');
            this.sortable = Sortable.create(el, {
                animation: 180,
                delay: 0,
                onEnd: async evt => {
                    if (evt.oldIndex === evt.newIndex) return;
                    this.queuedLoading = true;
                    await this.handleQueueChange(evt.oldIndex, evt.newIndex);
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
        async onCloneClicked(index, row) {
            await this.cloneAndQueueGame(row.id);
        },
        onEditClicked(index, row) {
            this.editingGameId = row.id;
            this.showGameModalEdit = true;
        },
        async onRemoveClicked(index, row) {
            await this.removeGame(row.id);
        },
        formatCurrentTime,
        convertISOFormat2Date,
    }
}
</script>
