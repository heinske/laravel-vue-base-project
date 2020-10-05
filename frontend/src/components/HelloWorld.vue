<template>
  <site-template>
    <div class="hello">
      <h1>Login com Facebook</h1>
      <facebook-login class="button" appId="2324798960909722" loginLabel="Login pelo Facebook" @login="onLogin" @click="onLogout" @sdk-loaded="sdkLoaded"></facebook-login>
      <GoogleLogin class="btn btn-googleplus btn-lg" :params="params" :onSuccess="onSuccess" :onFailure="onFailure">
        <i class="fa fa-google-plus fa-fw"></i>Login pelo Google
      </GoogleLogin>
      <a href="#" onclick="signOut();">Sign out</a>
    </div>
  </site-template>
</template>

<script>
import SiteTemplate from '@/templates/site-interno/SiteTemplate'
import facebookLogin from 'facebook-login-vuejs'
import GoogleLogin from 'vue-google-login'

export default {
  name: 'HelloWorld',
  components: {
    SiteTemplate,
    facebookLogin,
    GoogleLogin
  },
  data () {
    return {
      isConnected: false,
      name: '',
      email: '',
      FB: undefined,
      params: {
        client_id: '719807998074-nku7i6rfsgm8dsmehggqtd9mvrqpmq3r'
      }
    }
  },
  methods: {
    onSuccess (googleUser) {
      let profile = googleUser.getBasicProfile()
      console.log('ID: ' + profile.getId()) // Do not send to your backend! Use an ID token instead.
      console.log('Name: ' + profile.getName())
      console.log('Image URL: ' + profile.getImageUrl())
      console.log('Email: ' + profile.getEmail()) // This is null if the 'email' scope is not present.
    },
    onFailure (err) {
      console.log(err)
    },
    getUserData () {
      this.FB.api('/me', 'GET', { fields: 'id,name,email' },
        userInformation => {
          console.warn('data api', userInformation)
          this.email = userInformation.email
          this.name = userInformation.name
        }
      )
    },
    sdkLoaded (payload) {
      this.isConnected = payload.isConnected
      this.FB = payload.FB
      if (this.isConnected) this.getUserData()
    },
    onLogin () {
      this.isConnected = true
      this.getUserData()
    },
    onLogout () {
      this.FB.logout(function (response) {
        console.log(response)
        this.isConnected = false
      })
    }
  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>
  .btn-googleplus {
    background: #E93F2E;
    border-radius: 0;
    color: #fff;
    border-width: 1px;
    border-style: solid;
    border-color: #b72213;
  }
  .btn-googleplus:link, .btn-googleplus:visited {
    color: #fff;
  }
  .btn-googleplus:active, .btn-googleplus:hover {
    background: #b72213;
    color: #fff;
  }
</style>
