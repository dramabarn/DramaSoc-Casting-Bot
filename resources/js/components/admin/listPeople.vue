<template>
    <div class="col">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Actors</h3>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="person in people">
                        <td>{{ person.name }}</td>
                        <td>{{ person.email }}</td>
                        <td>{{ person.phone }}</td>
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
    }
}
</script>
