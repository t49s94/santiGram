<style scoped>

#numberNotifications {
  border-radius: 50%;
  width: 25px;
  height: 25px;
  background-color: red;
  color: white;
  text-align: center;
  font-weight: bold;
  position: absolute;
  margin-left: 25px;
}

#numberNotifications a {
  margin: 0 auto;
}

</style>

<template>

<!--
Developer: Sergio Eduardo Santillana Lopez.
Last update: 15/04/2021.

This file contains NotificationButton component. Shows the number of new notifications the user has.
-->

  <div id="notificationButton" class="d-flex pl-4" v-if="getProfileId != '-1'">

    <div class="d-flex align-items-center justify-content-center">
      <a :href="getNotificationLink"><img style="max-width:40px;" src='/storage/images/Notification-bell.png'></a>
    </div>

    <span id="numberNotifications" v-text="buttonText" v-if="buttonText != ''"></span>

  </div>

</template>

<script>
  export default {
    props: ['profileId'],

    mounted() {
      console.log('Component mounted.');

      // If user has logged in.
      if(this.profileId != -1)
        axios.post('/profile/' + this.profileId + '/notifications/numberNotifications')
            .then(response => {
                var countNotifications = parseInt(response.data);


                if(countNotifications > 99)
                  this.numberNotifications = "99+";

                else if(countNotifications > 0)
                  this.numberNotifications = countNotifications + "";

                else
                  this.numberNotifications = "";

            })
            .catch(errors => {
                if(errors.response.status == 401)
                {
                    window.location = '/login';
                }
            });
    },

    data: function() {
      return {
          numberNotifications: "",
      }
    },

    computed: {
      // Gets profile's Id
      // @return String.
      getProfileId: function () {
          return this.profileId;
      },

      // Gets address to Profile's notification page.
      // @return String.
      getNotificationLink: function () {
          return "/profile/" + this.profileId + "/notifications";
      },

      // Gets number of notifications.
      // @return String.
      buttonText: function() {
        return this.numberNotifications;
      },

    }
  }
</script>
