<template>
    <div>
        <bootstrap-4-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage" class="table-bordered"></bootstrap-4-datatable>
        <bootstrap-4-datatable-pager v-model="page" type="abbreviated"></bootstrap-4-datatable-pager>
    </div>
</template>

<script>
import TableButtonsComponent from "./TableButtonsComponent";

export default {
    data() {
        return {
            columns: [
                {
                    label: 'ID',
                    field: 'id',
                    align: 'center'
                },
                {
                    label: 'First Name',
                    field: 'first_name',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Last Name',
                    field: 'last_name',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'number of addresses',
                    field: 'number_of_addresses',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'number of cars',
                    field: 'number_of_cars',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Actions',
                    headerAlign: 'right',
                    align: 'right',
                    component: TableButtonsComponent
                }
            ],
            rows: [],
            page: 1,
            filter:  '',
            perPage: 20,
            loading: true
        }
    },
    methods: {
        showOwners: function () {
            axios.get('/owner').then(function (res1) {
                this.rows = res1.data.map(o => ({...o, 'type': 'owner'}));
            }.bind(this));
        }
    },
    created: function () {
        this.showOwners()
    }
}
</script>
