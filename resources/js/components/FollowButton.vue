<template>

<!--
Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This file contains FollowButton component. Toggles follow - unfollow when User clicks on it.
-->

  <div class="container">
    <button class="btn btn-primary ml-4" @click="followUser" v-text="buttonText"></button>
  </div>

</template>

<script>
  export default {
    props: ['userId', 'follows'],

    mounted() {
      console.log('Component mounted.')
    },

    data: function() {
      return {
          status: this.follows,
      }
    },

    methods: {
      // Executes Ajax functions that makes User follows or unfollows Profile
      // @return String.
      followUser()
      {
        axios.post('/follow/' + this.userId)
          .then(response => {
            this.status = ! this.status;
            console.log(response.data);
          })
          .catch(errors => {
            if(errors.response.status == 401)
            {
                window.location = '/login';
            }
          });
      }
    },

    computed: {
      // Gets button's text
      // @return String.
      buttonText() {
          return (this.status) ? 'Unfollow' : 'Follow';
      }
    }
  }
</script>
