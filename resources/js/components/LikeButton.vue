<style scoped>

  img:hover {
      cursor: pointer;
  }

</style>

<template>

<!--
Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This file contains LikeButton component. Toggles like - notLike when User clicks on it.
-->

  <div class="container d-flex align-items-center">
    <img class="w-100 pr-2" style="max-width:30px;" v-bind:src="buttonImage" @click="like">
    <span class="font-weight-bold" v-text="buttonText"></span>
  </div>

</template>

<script>

  export default {
    props: ['componentType', 'componentId', 'likes', 'likesCount'],

    mounted() {
      console.log('Component mounted.')
    },

    data: function() {
      return {
        status: this.likes,
        statusFlag: 0,
        wasPressed: 0,
        count: this.likesCount,
      }
    },

    methods: {
      // Executes Ajax function that makes User like-unlike a post or comment.
      like: function()
      {
        axios.post('/like/' + this.componentType + '/' + this.componentId)
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
      // Get button image's path.
      // @return String.
      buttonImage: function() {
        return (this.status) ? '/storage/images/Blue-Like-button.png' : '/storage/images/Like-button.png';
      },

      // Get button's text that shows how many likes it has.
      // @return String.
      buttonText: function() {
        // If User likes it already.
        if(this.status)
        {
          // If User didn't like it originally.
          if(this.statusFlag == 0)
          {
            this.statusFlag = 1;
            this.wasPressed = 1;
            return parseInt(this.count);
          }

          this.count = parseInt(this.count) + 1;
          return parseInt(this.count);
        }
        else
        {
          // If this is the first time that User clicks on LikeButton.
          if(this.wasPressed == 0)
          {
            this.wasPressed = 1;
            this.statusFlag = 1;
            return parseInt(this.count);
          }

          this.count = parseInt(this.count) - 1;
          return parseInt(this.count);
        }
      },
    }
  }
  
</script>
