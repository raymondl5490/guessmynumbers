<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-8 flex flex-col">
            <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-300">
                            <thead class="bg-gray-50">
                            <tr>
                                <th scope="col"
                                    v-for="field in fields"
                                    class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6"
                                    :key="'table_field_' + field.name"
                                >
                                    {{ field.title }}
                                </th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 bg-white">
                            <tr
                                v-for="row in data"
                                :key="row.id"
                                @click="() => onRowClick(row)"
                                class="hover:bg-gray-300 cursor-pointer"
                            >
                                <td
                                    :key="field.name ? field.name : field.title"
                                    v-for="field in fields"
                                    class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6"
                                >
                                    <slot :name="field.name" :row="row">
                                        <span
                                            v-if="field.clickEvent"
                                            @click.stop="() => onFieldClick(field, row)"
                                        >
                                            {{ getRowDisplay(field, row) }}
                                        </span>
                                        <span v-else>
                                            {{ getRowDisplay(field, row) }}
                                        </span>
                                    </slot>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        data: {
            type: Array,
            default: [
                {name: 'Lindsay Walton', title: 'Front-end Developer', email: 'lindsay.walton@example.com', role: 'Member'},
                {name: 'Dave Walton', title: 'Front-end Developer', email: 'lindsay.walton@example.com', role: 'Member'},
                {name: 'Walt Walton', title: 'Front-end Developer', email: 'lindsay.walton@example.com', role: 'Member'},
            ],
            required: false
        },
        fields: {
            type: Array,
            default: [{
                name: 'name',
                title: 'Name',
            }, {
                name: 'title',
                title: 'Title',
            }, {
                name: 'email',
                title: 'Email',
            }, {
                name: 'role',
                title: 'Role',
                clickEvent: 'role-clicked',
            }],
            required: false,
        },
    },
    methods: {
        onRowClick(row) {
            this.$emit('row-clicked', row);
        },
        onFieldClick(field, row) {
            if (!field.clickEvent) {
                return;
            }

            this.$emit(field.clickEvent, row);
        },
        getRowDisplay(field, row) {
            if (field.name) {
                return row[field.name];
            }

            return 'testing'
        }
    }
}

const exampleData = [
    {name: 'Lindsay Walton', title: 'Front-end Developer', email: 'lindsay.walton@example.com', role: 'Member'},
    {name: 'Dave Walton', title: 'Front-end Developer', email: 'lindsay.walton@example.com', role: 'Member'},
    {name: 'Walt Walton', title: 'Front-end Developer', email: 'lindsay.walton@example.com', role: 'Member'},
];

const exampleFields = [{
    name: 'name',
    title: 'Name',
}, {
    name: 'title',
    title: 'Title',
}, {
    name: 'email',
    title: 'Email',
}, {
    name: 'role',
    title: 'Role',
    clickEvent: 'role-clicked',
}];
</script>
