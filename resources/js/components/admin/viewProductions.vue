<template>
    <div class="col">
        <div class="card card-warning">
            <div class="card-header">
                <h3 class="card-title">Productions</h3>
            </div>
            <div class="card-body">
                <table class="table table-responsive-sm">
                    <thead>
                    <tr>
                        <th>Show</th>
                        <th>Type</th>
                        <th>Week</th>
                        <th>Producer</th>
                        <th>Number of Roles</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="show in productions">
                        <td><a :href="'view/' + show.id">{{ show.name }}</a></td>
                        <td>{{ show.type }}</td>
                        <td>{{ show.week }}</td>
                        <td>{{ show.prod }} ( <a :href="`mailto:${show.email}`">{{ show.email }}</a> )</td>
                        <td>{{ show.roles }}</td>
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
        productions:{
            type: Array,
        },
    }
}
</script>
