<template>
    <div class="col">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Cast Choices</h3>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <th>Show</th>
                        <th>Role</th>
                        <th>Option 1</th>
                        <th></th>
                        <th>Option 2</th>
                        <th></th>
                        <th>Option 3</th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="choice in productionchoices">
                        <td>{{ choice.show }} | {{ choice.type }} Week {{ choice.week}}</td>
                        <td>{{ choice.role }}</td>
                        <td>{{ choice.first }} </td>
                        <td><button v-if="choice.first != ''" type="button" class="btn btn-danger" @click="make_cast(choice.castId, 1)"><span class="cil-trash btn-icon mr-2"></span></button></td>
                        <td>{{ choice.second }}</td>
                        <td><button v-if="choice.second != ''" type="button" class="btn btn-danger" @click="make_cast(choice.castId, 2)"><span class="cil-trash btn-icon mr-2"></span></button></td>
                        <td>{{ choice.third }}</td>
                        <td><button type="button" v-if="choice.third != ''" class="btn btn-danger" @click="make_cast(choice.castId, 3)"><span class="cil-trash btn-icon mr-2"></span></button></td>
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
        productionchoices:{
            type: Array,
        },
    },

    data() {
        return {
            submitting: false
        }
    },

    methods: {

        make_cast(id, choice) {
            this.submitting = true

            let data = {
                cast_id: id,
                choice: choice,
            }

            axios.post(`/admin/remove`, data)
                .then(response => {
                    this.errors = {}
                    this.submitting = false
                    Swal.fire({
                        title: 'Removed!',
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
