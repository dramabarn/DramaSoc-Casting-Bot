<template>
    <div class="col">
        <div class="row" v-for="show in productions">
            <div class="col-sm">
                <div class="card card-warning">
                    <div class="card-header">
                        <h3 class="card-title">This Show</h3>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <tbody>
                            <tr>
                                <th>Show Name</th>
                                <td>{{ show.name }}</td>
                            </tr>
                            <tr>
                                <th>Show Type</th>
                                <td>{{ show.type }}</td>
                            </tr>
                            <tr>
                                <th>Show Week</th>
                                <td>{{ show.week }}</td>
                            </tr>
                            <tr>
                                <th>Producer</th>
                                <td>{{ show.prod }} ( <a :href="`mailto:${show.email}`">{{ show.email }}</a> )</td>
                            </tr>
                            <tr>
                                <th>Number of Roles</th>
                                <td>{{ show.roles }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {

    name: "viewSingleProduction",

    props:{
        productions:{
            type: Object,
        },
    }

}
</script>
