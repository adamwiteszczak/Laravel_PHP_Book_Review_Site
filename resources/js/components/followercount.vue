<template>
    <div>
        Followers <span v-text="count"></span>
    </div>
</template>
<script>
    export default {
        mounted() {
            console.log('Component mounted.')
            this.followerCount();
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
            followerCount() {
                axios.get('/api/profile/' + this.link + '/followers/count').then(response => {
                    this.count = response.data.follower_count;
                });
            }
        }
    }
</script>
