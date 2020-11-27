<template>
    <div class="col">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">People</h3>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Delete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="person in people">
                        <td>{{ person.name }}</td>
                        <td>{{ person.email }}@york.ac.uk</td>
                        <td>{{ person.phone }}</td>
                        <td><button type="button" class="btn btn-square btn-danger"><i class="cil-trash"></i>
                            Delete {{person.id}}</button>
                        </td>
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
            type: Object,
        },
    }
}
</script>
