<template>
  
    <q-layout view="lHh Lpr lFf" class="bg-grey-2">
      <div class="container">
	<div class="screen">
		<div class="screen__content">
			<form class="login" @submit.prevent="login">
				<div class="login__field">
					<i class="login__icon fas fa-user"></i>
					<input type="text" class="login__input" placeholder="Cuenta" v-model="cuenta" required>
				</div>
				<div class="login__field">
					<i class="login__icon fas fa-lock"></i>
					<input type="password" class="login__input" placeholder="Password" v-model="password" required>
				</div>
				<button class="button login__submit" type="submit">
					<span class="button__text">Log In Now</span>
					<i class="button__icon fas fa-chevron-right"></i>
				</button>				
			</form>
			<div class="social-login">
				<h3>log in via</h3>
				<div class="social-icons">
					<a href="#" class="social-login__icon fab fa-instagram"></a>
					<a href="#" class="social-login__icon fab fa-facebook"></a>
					<a href="#" class="social-login__icon fab fa-twitter"></a>
				</div>
			</div>
		</div>
		<div class="screen__background">
			<span class="screen__background__shape screen__background__shape4"></span>
			<span class="screen__background__shape screen__background__shape3"></span>		
			<span class="screen__background__shape screen__background__shape2"></span>
			<span class="screen__background__shape screen__background__shape1"></span>
		</div>		
	</div>
</div>
<!--
      <q-page-container>
        <q-page>
          <div class="row">
            <div class="col-1 col-sm-4"></div>
            <div class="col-10 col-sm-4">
              <div class="text-subtitle1 text-center q-pt-xs text-grey">INGRESO AL SISTEMA</div>
              <div class="text-h4 text-center q-pa-xs text-black text-bold">ATENCION EN CAJAS   </div>
              <q-card flat bordered>
                <q-card-section >
                  <q-form class="q-pa-lg" @submit.prevent="login">
                    <div class="row">
                      <div class="col-12">
                        <q-input outlined v-model="cuenta" label="Email" type="text" required />
                      </div>
                      <div class="col-12 q-pt-lg">
                        <q-input outlined v-model="password" label="Contraseña" :type="typePassword?'password':'text'" required >
                          <template v-slot:append>
                            <q-icon @click="typePassword=!typePassword" :name="typePassword?'visibility':'visibility_off'" />
                          </template>
                        </q-input>
                      </div>
                      <div class="col-12 q-pt-xs">
                        <q-btn size="22px" :loading="loading" class="full-width bold" color="primary" label="Iniciar Sesión" type="submit" no-caps />
                      </div>
                     </div>
                  </q-form>
                </q-card-section>
              </q-card>
              </div>
            <div class="col-1 col-sm-4"></div>
          </div>
        </q-page>
      </q-page-container>-->
    </q-layout>
  </template>
  
  <script>
import {globalStore} from 'stores/globalStore'
  // import { Providers} from 'universal-social-auth'
  export default {
    name: 'LoginPage',
    data () {
      return {
        cuenta: '',
        password: '',
        remember: false,
        typePassword: true,
        loading: false,
        store:globalStore()
      }
    },
    mounted () {
      if (this.store.isLoggedIn) {
        this.$router.push('/ventanilla')
      }
    },
    methods: {
      login () {
        this.loading = true
        this.$api.post('login', {
          cuenta: this.cuenta,
          password: this.password
        }).then(res => {
          this.$q.notify({
            message: 'Bienvenido',
            color: 'positive',
            icon: 'check_circle',
            position: 'top'
          })
          console.log(res.data)
          this.$router.push('/ventanilla')
          this.store.user = res.data.user
          this.store.isLoggedIn = true
		  res.data.user.permisos.forEach(r => {
				if(r.id==1) this.store.booluser=true
				if(r.id==2) this.store.boolcaja=true
		  });
          this.$api.defaults.headers.common.Authorization = 'Bearer ' + res.data.token
          localStorage.setItem('tokenTicket', res.data.token)
        }).catch(error => {
          console.log(error)
          this.$q.notify({
            message: error.response.data.message,
            color: 'negative',
            position: 'top',
            timeout: 2000
          })
        }).finally(() => {
          this.loading = false
        })
      }
    }
  }
  </script>
  
  <style scoped>
  @import url('https://fonts.googleapis.com/css?family=Raleway:400,700');

* {
	box-sizing: border-box;
	margin: 0;
	padding: 0;	
	font-family: Raleway, sans-serif;
}

body {
	background: linear-gradient(90deg, #C7C5F4, #776BCC);		
}

.container {
	display: flex;
	align-items: center;
	justify-content: center;
	min-height: 100vh;
}

.screen {		
	background: linear-gradient(90deg, #5D54A4, #7C78B8);		
	position: relative;	
	height: 600px;
	width: 360px;	
	box-shadow: 0px 0px 24px #5C5696;
}

.screen__content {
	z-index: 1;
	position: relative;	
	height: 100%;
}

.screen__background {		
	position: absolute;
	top: 0;
	left: 0;
	right: 0;
	bottom: 0;
	z-index: 0;
	-webkit-clip-path: inset(0 0 0 0);
	clip-path: inset(0 0 0 0);	
}

.screen__background__shape {
	transform: rotate(45deg);
	position: absolute;
}

.screen__background__shape1 {
	height: 520px;
	width: 520px;
	background: #FFF;	
	top: -50px;
	right: 120px;	
	border-radius: 0 72px 0 0;
}

.screen__background__shape2 {
	height: 220px;
	width: 220px;
	background: #6C63AC;	
	top: -172px;
	right: 0;	
	border-radius: 32px;
}

.screen__background__shape3 {
	height: 540px;
	width: 190px;
	background: linear-gradient(270deg, #5D54A4, #6A679E);
	top: -24px;
	right: 0;	
	border-radius: 32px;
}

.screen__background__shape4 {
	height: 400px;
	width: 200px;
	background: #7E7BB9;	
	top: 420px;
	right: 50px;	
	border-radius: 60px;
}

.login {
	width: 320px;
	padding: 30px;
	padding-top: 156px;
}

.login__field {
	padding: 20px 0px;	
	position: relative;	
}

.login__icon {
	position: absolute;
	top: 30px;
	color: #7875B5;
}

.login__input {
	border: none;
	border-bottom: 2px solid #D1D1D4;
	background: none;
	padding: 10px;
	padding-left: 24px;
	font-weight: 700;
	width: 75%;
	transition: .2s;
}

.login__input:active,
.login__input:focus,
.login__input:hover {
	outline: none;
	border-bottom-color: #6A679E;
}

.login__submit {
	background: #fff;
	font-size: 14px;
	margin-top: 30px;
	padding: 16px 20px;
	border-radius: 26px;
	border: 1px solid #D4D3E8;
	text-transform: uppercase;
	font-weight: 700;
	display: flex;
	align-items: center;
	width: 100%;
	color: #4C489D;
	box-shadow: 0px 2px 2px #5C5696;
	cursor: pointer;
	transition: .2s;
}

.login__submit:active,
.login__submit:focus,
.login__submit:hover {
	border-color: #6A679E;
	outline: none;
}

.button__icon {
	font-size: 24px;
	margin-left: auto;
	color: #7875B5;
}

.social-login {	
	position: absolute;
	height: 140px;
	width: 160px;
	text-align: center;
	bottom: 0px;
	right: 0px;
	color: #fff;
}

.social-icons {
	display: flex;
	align-items: center;
	justify-content: center;
}

.social-login__icon {
	padding: 20px 10px;
	color: #fff;
	text-decoration: none;	
	text-shadow: 0px 0px 8px #7875B5;
}

.social-login__icon:hover {
	transform: scale(1.5);	
}
  </style>