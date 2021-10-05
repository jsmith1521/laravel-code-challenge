<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        {{this.displayName()}}
                        <span style="float:right" >
                            <button class="btn btn-primary" @click="navigate">Back</button>
                        </span>
                    </div>

                    <div class="card-body">
                        <view-record-table-component></view-record-table-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        row: {
            type: Object
        }
    },
    methods: {
        navigate() {
            history.go(-1);
        },
        displayName(){
            return this.$route.params.type[0].toUpperCase() + this.$route.params.type.substr(1) + ' View';
        }
    }
}
</script>
