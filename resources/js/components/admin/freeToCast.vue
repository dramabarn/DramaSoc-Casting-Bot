<template>
    <div class="col">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Free to Cast!</h3>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <th>Show</th>
                        <th>Role</th>
                        <th>Name</th>
                        <th>Number</th>
                        <th>Cast</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="choice in castable">
                        <td>{{ choice.play }}</td>
                        <td>{{ choice.role }}</td>
                        <td>{{ choice.person }}</td>
                        <td>{{ choice.phone }}</td>
                        <td><button type="button" class="btn btn-square btn-info" @click="make_cast(choice.id)"><i class="plus"></i>
                            Cast {{choice.person}}</button></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    props:{
        castable:{
            type: Object,
        },
    },

    data() {
        return {
            submitting: false
        }
    },

    methods: {

        make_cast(id) {
            this.submitting = true
            console.log(id)

            let data = {
                role_id: id,
            }

            axios.post(`/admin/cast-person`, data)
                .then(response => {
                    this.errors = {}
                    this.submitting = false
                    Swal.fire({
                        title: 'Casted!',
                        icon: 'success',
                        confirmButtonText: 'OK',
                    }).then((result) => {
                            window.location.href = "/admin/meeting"
                        }
                    )
                }).catch(error => {
                console.log(error)
                // console.log(response.data.errors)
                this.submitting = false
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Something went wrong!',
                }).then((result) => {
                    location.reload();
                });
            })
        }

    }
}
</script>
