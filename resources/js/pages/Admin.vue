<template>
    <div class="container mx-auto">
        <div class="flex items-center justify-center">
            <p class="m-4 text-4xl md:text-8xl">
                {{currentGame.number_one}} - {{currentGame.number_two}} - {{currentGame.number_three}}
            </p>
        </div>

        <div class="grid grid-cols-1 gap-2 p-4 m-8 border-2 rounded-md shadow-sm md:grid-cols-2 md:gap-4">
            <div class="text-center">Players This Round: #5555</div>
            <div class="text-center">Winners This Round: #1124</div>
        </div>

        <div class="grid grid-cols-1 gap-2 p-4 m-8 border-2 rounded-md shadow-sm md:grid-cols-2 md:gap-4">
            <div class="text-center">Author Name: <span class="font-bold text-blue-900">{{currentGame.author_name}}</span></div>
            <div class="text-center">Author Location: <span class="font-bold text-blue-900">{{currentGame.author_location}}</span></div>
            <div class="text-center">Author Email: <span class="font-bold text-blue-900">{{currentGame.author_email}}</span></div>
            <div class="text-center">Author Link: 
                <el-link :href="currentGame.link" target="_blank" type="primary">
                    {{currentGame.link_title}}
                </el-link>
            </div>
        </div>

        <el-collapse :model-value="['submitted', 'queued']" class="p-4 m-8 text-center border-2 rounded-md shadow-sm">
            <el-collapse-item title="Submitted Games" name="submitted">
                <template #title>
                    <div class="flex items-center content-center justify-between w-full">
                        <p>Submitted Games</p>
                        <el-button size="small" type="primary" @click.stop="isVisibleGameDialogCreate = true">Create</el-button>
                    </div>
                </template>
                <el-table :data="filteredSubmittedGames">
                    <el-table-column label="ID" fixed prop="id" width="50px"/>
                    <el-table-column label="Numbers" fixed width="100px">
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
                    <el-table-column label="Numbers" fixed width="100px">
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
                    <el-table-column label="Numbers" fixed width="100px">
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
import Sortable from 'sortablejs';
import { v4 as uuidv4 } from 'uuid';
import { nextTick } from "vue";

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
            return this.submittedGames.filter(
                (data) =>
                !this.search ||
                (data.author_name + data.author_email + data.author_location + data.link_title + data.link)
                .toLowerCase().includes(this.search.toLowerCase())
            )
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
            this.isVisibleGameDialogEdit = true;
        },
        async onRemoveClicked(index, row) {
            await this.removeGame(row.id);
        },
    }
}
</script>
