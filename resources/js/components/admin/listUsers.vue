<template>
    <div class="col">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Users</h3>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Remove</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="person in people">
                        <td>{{ person.name }}</td>
                        <td>{{ person.email }}</td>
                        <td>{{ person.menuroles }}</td>
                        <td><button type="button"  class="btn btn-danger" @click="remove_person(person.id)"><span class="cil-trash btn-icon mr-2"></span></button></td>
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
        people:{
            type: Array,
        },
    },

    data() {
        return {
            submitting: false
        }
    },

    methods: {
        remove_person(id){
            Swal.fire({
                title: 'Are You Sure?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Do It!',
                cancelButtonText: 'No! Go back!'
            }).then((result) => {
                if (result.isConfirmed) {
                    axios.post('users/' + id + '/delete')
                        .then(response => {
                            this.errors = {}
                            this.submitting = false
                            Swal.fire({
                                title: 'Removed!',
                                icon: 'success',
                                confirmButtonText: 'OK',
                            }).then((result) => {
                                    location.reload();
                                }
                            )
                        }).catch(error => {
                        console.log(error)
                        this.submitting = false
                        location.reload();
                    })
                }
            });

        }
    }
}
</script>
