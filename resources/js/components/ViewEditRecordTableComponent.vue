<template>
    <div id="dataTable">
        <b-table :items="items" :fields="fields">
            <template #cell(first_name)="data">
                <b-form-input v-if="data.item.isEdit === true" type="text" v-model="items[data.index].first_name"></b-form-input>
                <span v-else>{{data.value}}</span>
            </template>
            <template #cell(last_name)="data">
                <b-form-input v-if="data.item.isEdit=== true" type="text" v-model="items[data.index].last_name"></b-form-input>
                <span v-else>{{data.value}}</span>
            </template>
            <template #cell(address)="data">
                <b-form-textarea rows="8" v-if="data.item.isEdit" type="text" v-model="items[data.index].address"></b-form-textarea>
                <span v-else>{{data.value}}</span>
            </template>
            <template #cell(city)="data">
                <b-form-input v-if="items[data.index].isEdit === true" type="text" v-model="items[data.index].city"></b-form-input>
                <span v-else>{{data.value}}</span>
            </template>
            <template #cell(country)="data">
                <b-form-input v-if="data.item.isEdit === true" type="text" v-model="items[data.index].country"></b-form-input>
                <span v-else>{{data.value}}</span>
            </template>
            <template #cell(postal_code)="data">
                <b-form-input v-if="data.item.isEdit === true" type="text" v-model="items[data.index].postal_code"></b-form-input>
                <span v-else>{{data.value}}</span>
            </template>
            <template #cell(make)="data">
                <b-form-input v-if="data.item.isEdit === true" type="text" v-model="items[data.index].make"></b-form-input>
                <span v-else>{{data.value}}</span>
            </template>
            <template #cell(model)="data">
                <b-form-input v-if="data.item.isEdit === true" type="text" v-model="items[data.index].model"></b-form-input>
                <span v-else>{{data.value}}</span>
            </template>
            <template #cell(year)="data">
                <b-form-input v-if="data.item.isEdit === true" type="text" v-model="items[data.index].year"></b-form-input>
                <span v-else>{{data.value}}</span>
            </template>
            <template #cell(edit)="data">
                <b-button @click="viewEditRowHandler(data)">
                    <span v-if="data.item.isEdit !== true">Edit</span>
                    <span v-else>Done</span>
                </b-button>
            </template>
        </b-table>
    </div>
</template>

<script>
export default {
    name: "dataTable",
    components: {},
    data() {
        return {
            fields: [
                {
                    label: 'First Name',
                    key: 'first_name',
                    headerAlign: 'left',
                    align: 'left',
                },
                {
                    label: 'Last Name',
                    key: 'last_name',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Address',
                    key: 'address',
                    headerAlign: 'left',
                    align: 'left',
                },
                {
                    label: 'City',
                    key: 'city',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Country',
                    key: 'country',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Postal Code',
                    key: 'postal_code',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Make',
                    key: 'make',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Model',
                    key: 'model',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: 'Year',
                    key: 'year',
                    headerAlign: 'left',
                    align: 'left'
                },
                {
                    label: '',
                    key: 'edit'
                },
            ],
            items: [],
        }
    },
    methods: {
        viewEditRowHandler(data) {
            data.item.isEdit = !data.item.isEdit;
            if(data.item.isEdit !== true){
                axios.put(`/${this.$route.params.type}/update/${this.$route.params.id}`)
                    .then(function (response) {
                    console.log(response);
                })
            }
        },
        viewEditRecord: function() {
            axios.get(`/${this.$route.params.type}/show/${this.$route.params.id}`).then(function (response) {
                this.items = response.data.map(o => ({...o, 'type': this.$route.params.type}));
                this.items = this.items.map(item => ({...item, isEdit: false}));
            }.bind(this));
        },
    },
    created: function () {
        this.viewEditRecord()
    }
}
</script>

<style>
#dataTable {
    text-align: center;
    margin: 60px;
}
thead, tbody, tfoot, tr, td, th {
    text-align: left;
    width: 100px;
    vertical-align: middle;
}
</style>
