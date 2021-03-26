<template>
    <div class="row">
        <div class="col-sm-12 text-left">
            <ol class="breadcrumb">
                <li>
                    <router-link to="/">Home</router-link>
                </li>
                <li><a href="#">Emails</a></li>
                <li class="active">All</li>
            </ol>
        </div>
        <div class="col-sm-12">
            <form class="navbar-form navbar-right" role="form">
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <select class="form-control" v-model='condition' aria-label="Default select example">
                        <option selected value="from">From Email</option>
                        <option value="to">To Email</option>
                        <option value="subject">Subject</option>
                    </select>
                </div>
                <div class="input-group">
                    <span class="input-group-addon"><i class="glyphicon glyphicon-user"></i></span>
                    <input type="text" class="form-control" debounce="500" v-model="term" value="" :placeholder="condition">
                </div>
            </form>

            <table class="table table-bordered table-responsive table-small">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>To</th>
                        <th>From</th>
                        <th>Subject</th>
                        <th>Status</th>
                        <th>Created At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(mail,index) in emails" :key="mail.id">
                        <td>{{ index +1 }}</td>
                        <td>{{ mail.to }}</td>
                        <td>{{ mail.from }}</td>
                        <td>{{ mail.subject | truncate(10, '...') }}</td>
                        <td>
                            <span v-if='mail.status.id ==1' class="label label-default">{{ mail.status.name }}</span>
                            <span v-if='mail.status.id ==2' class="label label-success">{{ mail.status.name }}</span>
                            <span v-if='mail.status.id ==3' class="label label-danger">{{ mail.status.name }}</span>

                        </td>
                        <td>{{ mail.created_at | date }}</td>
                        <td>
                            <div class="btn-group" role="group">
                                <router-link :to="{name: 'email', params: { id: mail.id }}"
                                    class="btn btn-primary btn-sm">View
                                </router-link>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="col-sm-12 text-center">
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <li>
                        <a href="#" aria-label="Previous">
                            <span aria-hidden="true">&laquo;</span>
                        </a>
                    </li>
                    <li><a href="#">1</a></li>
                    <li><a href="#">2</a></li>
                    <li><a href="#">3</a></li>
                    <li><a href="#">4</a></li>
                    <li><a href="#">5</a></li>
                    <li>
                        <a href="#" aria-label="Next">
                            <span aria-hidden="true">&raquo;</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                emails: [],
                pagination: null,
                term: '',
                condition: 'from',
            }
        },
        created() {
            this.axios
                .get('http://localhost:8000/api/emails')
                .then(response => {
                    this.emails = response.data.data.data;
                    this.pagination = {
                        'current_page': response.data.current_page,
                        'last_page': response.data.last_page,
                        'per_page': response.data.per_page,
                        'total': response.data.total,
                    }
                    console.log('data', response.data.data.data)
                });
        },
        watch: {
            term: function (searchterm) {
                this.axios
                .get('http://localhost:8000/api/emails?condition='+this.condition+'&term='+searchterm)
                .then(response => {
                    this.emails = response.data.data.data;
                    this.pagination = {
                        'current_page': response.data.current_page,
                        'last_page': response.data.last_page,
                        'per_page': response.data.per_page,
                        'total': response.data.total,
                    }
                    console.log('data', response.data.data.data)
                });
            }
        },
        filters: {
            truncate: function (text, length, suffix) {
                if (text.length > length) {
                    return text.substring(0, length) + suffix;
                } else {
                    return text;
                }
            },
        }
    }

</script>
