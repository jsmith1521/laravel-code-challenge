<template>
    <div>
        <bootstrap-4-datatable :columns="columns" :data="rows" :filter="filter" :per-page="perPage" class="table-bordered"></bootstrap-4-datatable>
        <bootstrap-4-datatable-pager v-model="page" type="abbreviated"></bootstrap-4-datatable-pager>
    </div>
</template>

<script>

export default {
    props: {
        row: {
            type: Object
        }
    },
    data() {
        return {
            columns: [
                {
                    label: 'First Name',
                    field: 'first_name',
                    headerAlign: 'left',
                    align: 'left',
                },
                {
                    label: 'Last Name',
                    field: 'last_name',
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
            ],
            rows: [],
            page: 1,
            filter:  '',
            perPage: 20,
            loading: true
        }
    },
    methods: {
        viewRecord: function() {
            axios.get(`/${this.$route.params.type}/show/${this.$route.params.id}`).then(function (response) {
                this.rows = response.data.map(o => ({...o, 'type': this.$route.params.type}));
            }.bind(this));
        }
    },
    created: function () {
        this.viewRecord()
    }
}
</script>
