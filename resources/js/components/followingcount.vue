<template>
    <div>
        Following <span v-text="count"></span>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            this.followingCount();
        },

        created: function(){

        },

        props: [
            'link'
        ],

        data: function() {
            return {
                count: "~"
            }
        },

        methods: {
            followingCount() {
                axios.get('/api/profile/' + this.link + '/following/count').then(response => {
                    this.count = response.data.following_count;
                });
            }
        }
    }
</script>
