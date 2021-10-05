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
                    label: 'Average number of addresses, per user',
                    field: 'avg_number_of_addresses',
                    headerAlign: 'left',
                    align: 'left',
                    sort: false
                },
                {
                    label: 'Average number of cars, per user',
                    field: 'avg_number_of_cars',
                    headerAlign: 'left',
                    align: 'left',
                    sort: false
                },
            ],
            rows: [],
            filter:  '',
            perPage: 1,
            loading: true
        }
    },
    methods: {
        showOwnerAddressCar: function () {
            axios.get('/average_number_addresses_and_cars_per_user').then(function (res) {
                this.rows = res.data.map(o => ({...o, 'type': 'owner'}));
            }.bind(this));
        }
    },
    created: function () {
        this.showOwnerAddressCar()
    }
}
</script>
