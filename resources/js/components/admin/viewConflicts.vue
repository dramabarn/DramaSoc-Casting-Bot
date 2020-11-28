<template>
    <div class="col">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Cast Conflicts</h3>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Number</th>
                            <th>Show 1</th>
                            <th>Show 2</th>
                            <th>Cast</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="conflict in productionconflicts">
                            <td>{{ conflict.name }}</td>
                            <td>{{ conflict.phone }}</td>
                            <td>{{ conflict.firstshow }} - {{conflict.firstrole }}</td>
                            <td>{{ conflict.secondshow }} - {{conflict.secondrole }}</td>
                            <td><button type="button" class="btn btn-square btn-danger" @click="make_cast(conflict.firstid, conflict.secondid)"><i class="plus"></i>
                            Cast {{conflict.name}}</button></td>
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
        productionconflicts:{
            type: Object,
        },
    },

    data() {
        return {
            submitting: false
        }
    },

    methods: {

        make_cast(role1, role2) {
            this.submitting = true
            console.log(id)

            let data = {
                role_id: role1,
            }

            axios.post(`/admin/cast-person`, data)
                .then(response => {
                    this.errors = {}
                    let data = {
                        role_id: role2,
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