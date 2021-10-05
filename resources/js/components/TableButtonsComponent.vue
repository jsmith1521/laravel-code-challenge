<template>
    <div>
        <button class="btn btn-primary" @click="displayViewEditPage($props.row.id, $props.row.type)">View/Edit</button>
        <button class="btn btn-danger" @click="confirmDelete($props.row.id, $props.row.type)">Delete</button>
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
        confirmDelete(id, type){
            let confirmed = confirm(`Are you sure you want to delete row id: ${id} from category ${type}?`);
            if(confirmed){
                axios
                    .delete(`/${type}/delete/${id}`)
                    .then(function () {
                        window.location.reload()
                    })
                    .catch(error => {
                        console.log("delete error: ", error)
                    });
            }
        },
        displayViewEditPage(id, type){
            this.$router.push({
                path:`/ViewEditRecord/${id}/${type}`,
            });
        }
    }
}
</script>
