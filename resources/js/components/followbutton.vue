<template>
    <div class="container">
        <button class="btn btn-primary" @click="following" v-text="buttonText"></button>
    </div>
</template>

<script>
    export default {
        mounted() {
            console.log('Component mounted.')
        },

        props: [
            'userUuid',
            'follows'
        ],

        data: function() {
            return {
                status: this.follows
            }
        },

        methods: {
            following(){
                axios.post('/follow/' + this.userUuid).then(response => {
                    this.status = !this.status;
                }).catch(errors => {
                    if (errors.response.status == 401) {
                        window.location = '/login';
                    }
                 });
            }
        },

        computed: {
            buttonText() {
                return (this.status) ? 'Following' : 'Follow';
            }
        }
    }
</script>
