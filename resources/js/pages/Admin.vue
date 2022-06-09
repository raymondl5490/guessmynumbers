<template>
    <div>
        <div class="button max-w-fit ml-auto mr-8" @click="onCreateGame">Create Game</div>
        <table-component
            :data="games"
            :fields="fields"
            @row-clicked="onRowClicked"
        >
            <template #numbers="{ row: { number_one, number_two, number_three } }">
                {{ number_one }} - {{ number_two }} - {{ number_three }}
            </template>
            <template #game_start="{ row: { game_start }}">
                {{ formatDate(game_start) }}
            </template>
            <template #created_at="{ row: { created_at }}">
                {{ formatDate(created_at) }}
            </template>
        </table-component>
        <create-game-modal-component :show="showCreateGameModal" :game="selectedGame" @close="onClose"/>
    </div>
</template>
<script>
import {mapActions, mapState} from "pinia";
import {useGameStore} from "../store";
import TableComponent from "../components/ui/TableComponent";
import { parseISO, format } from 'date-fns'
import ModalComponent from "../components/ui/ModalComponent";
import CreateGameModalComponent from "../components/modals/CreateGameModalComponent";

export default {
    components: {ModalComponent, TableComponent, CreateGameModalComponent},
    data() {
        return {
            fields: [{
                name: 'numbers',
                title: 'Numbers',
            }, {
                name: 'author_name',
                title: 'Name',
            }, {
                name: 'author_location',
                title: 'Location',
            }, {
                name: 'author_email',
                title: 'Email',
            }, {
                name: "link",
                title: 'Link',
            }, {
                name: 'game_start',
                title: 'Game Start',
            }, {
                name: 'created_at',
                title: 'Date Submitted',
            }],
            showCreateGameModal: false,
            selectedGame: null,
        };
    },
    created() {
        this.getAllGames();
    },
    computed: {
        ...mapState(useGameStore, ['games']),
    },
    methods: {
        ...mapActions(useGameStore, ['getAllGames']),
        formatDate(date) {
            if (!date) {
                return;
            }

            let parsedDate = parseISO(date);
            return format(parsedDate, 'MMM do, yyyy h:mm aaa');
        },
        onCreateGame() {
            this.showCreateGameModal = true
        },
        onClose() {
            this.showCreateGameModal = false
            this.selectedGame = null;
        },
        onRowClicked(data) {
            this.selectedGame = data;
            this.showCreateGameModal = true;
        }
    }
}
</script>
