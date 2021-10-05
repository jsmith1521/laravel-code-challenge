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
                    label: 'Name',
                    field: 'full_name',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Address',
                    field: 'address',
                    headerAlign: 'left',
                    align: 'left',
                    interpolate: true,
                    representedAs: function (r) {
                        return r.address + '<br>' + r.city + '<br>' + r.country + '<br>' + r.postal_code;
                    }
                },
                {
                    label: 'Make',
                    field: 'make',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Model',
                    field: 'model',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Year',
                    field: 'year',
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
        showCars: function () {
            axios.get('/car',{})
            .then(function (response) {
                this.rows = response.data.map(o => ({...o, 'type': 'car'}));
            }.bind(this))
            .catch(function (error) {
                // handle error
                console.log(error);
            });
        }
    },
    created: function () {
        this.showCars()
    }
}
</script>
