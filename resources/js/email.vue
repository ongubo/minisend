<template>
    <div class="row">
        <div class="col-sm-12 text-left">
            <ol class="breadcrumb">
                <li>
                <router-link to="/">Home</router-link></li>
                <li><a href="#">Email</a></li>
                <li class="active">View</li>
            </ol>
        </div>
        <div class="col-sm-12" style="border:1px solid #grey">
            <h3>{{email.subject}}</h3>
            <h5>From: {{email.from}}</h5>
            <p>To: {{email.to}}</p>
            <hr>
            <span v-html="email.html_content"></span>
        </div>
    </div>
</template>

<script>
    export default {
        data() {
            return {
                email: null
            }
        },
        created() {
            console.log('email id',this.$route.params.id);
            this.axios
                .get('http://localhost:8000/api/emails/'+this.$route.params.id)
                .then(response => {
                    this.email= response.data.data
                    console.log('data', response.data.data)
                });
        }
    }

</script>
