<template>
    <div>
        <bootstrap-4-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage" class="table-bordered"></bootstrap-4-datatable>
    </div>
</template>

<script>
export default {
    data() {
        return {
            columns: [
                {
                    label: 'Average number of cars per address',
                    field: 'number_of_cars',
                    headerAlign: 'left',
                    align: 'left',
                    sort: false
                },
            ],
            rows: [],
            page: 1,
            filter:  '',
            perPage: 1,
            loading: true
        }
    },
    methods: {
        showAddressCarPerAddress: function () {
            axios.get('/average_number_of_cars_per_address').then(function (res) {
                this.rows = res.data.map(o => ({...o, 'type': 'owner'}));
            }.bind(this));
        }
    },
    created: function () {
        this.showAddressCarPerAddress()
    }
}
</script>
