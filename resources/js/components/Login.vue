<template>
<div class="limiter">
    <div class="container-login100" style="/* background-image: url('img/bg-01.jpg'); */">
        <div class="wrap-login100 p-l-20 p-r-20 p-t-35 p-b-24">
            <form @submit.prevent="!signupMode ? loginUser() : registerUser()" class="login100-form validate-form">
                <span v-show="!signupMode" class="login100-form-title p-b-29">
                    Login
                </span>
                <span v-show="signupMode" class="login100-form-title p-b-29">
                    Register
                </span>

                <span class="has-error" v-if="msg.auth">{{msg.auth}}</span>
                
                <div v-show="signupMode" class="wrap-input100 validate-input m-b-13">
                    <span class="label-input100">Username</span>
                    <input  v-model="name" class="input100" type="text" placeholder="Type your username">
                    <span class="focus-input100 focus-input-user"></span>
                    <span class="has-error" v-if="msg.name">{{msg.name}}</span>
                </div>

                <!-- <div v-show="signupMode" class="wrap-input100 validate-input m-b-13">
                    <span class="label-input100">Phone Number</span>
                    <input v-model="phone" class="input100" type="tel" name="phone" placeholder="">
                    <span class="focus-input100 focus-input-user"></span>
                </div> -->

                <div class="wrap-input100 validate-input m-b-13">
                    <span class="label-input100">Email</span>
                    <input autocomplete="false" v-model="email" class="input100" type="text" placeholder="Type your email">
                    <span class="focus-input100 focus-input-email"></span>
                    <span class="has-error" v-if="msg.email">{{msg.email}}</span>
                </div>

                <div class="wrap-input100 validate-input">
                    <span class="label-input100">Password</span>
                    <input v-model="password" class="input100" autocomplete="false" type="password" placeholder="Type your password">
                    <span class="focus-input100 focus-input-password"></span>
                    <span class="has-error" v-if="msg.password">{{msg.password}}</span>
                </div>
                
                <div class="text-right p-t-4 p-b-11">
                    <a v-show="!signupMode" href="#">
                        Forgot password?
                    </a>
                </div>
                
                <div class="container-login100-form-btn">
                    <div class="wrap-login100-form-btn">
                        <div class="login100-form-bgbtn"></div>
                        <input type="submit" value="Login" v-show="!signupMode" class="login100-form-btn">
                        <input type="submit" value="Register" v-show="signupMode" class="login100-form-btn">
                    </div>
                </div>

                <div class="txt1 text-center p-t-24 p-b-10">
                    <span>
                        Or Sign Up Using
                    </span>
                </div>

                <div class="flex-c-m">
                    <a href="#" class="login100-social-item bg1">
                        <i class="fa fa-facebook"></i>
                    </a>

                    <a href="#" class="login100-social-item bg2">
                        <i class="fa fa-twitter"></i>
                    </a>

                    <a href="#" class="login100-social-item bg3">
                        <i class="fa fa-google"></i>
                    </a>

                </div>

                <div v-show="!signupMode" class="flex-col-c p-t-10">
                    <span class="txt1 p-b-7">
                        Or Sign Up Using
                    </span>

                    <a @click="changeSignupMode" class="txt2">
                        Sign Up
                    </a>
                </div>
                <div v-show="signupMode" class="flex-col-c p-t-10">
                    <span class="txt1 p-b-7">
                        Or Sign In Using
                    </span>

                    <a @click="changeSignupMode" class="txt2">
                        Login
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
</template>

<script>
    export default {
        name: "Login",
        data() {
            return {
                signupMode: false,
                name: '',
                password: '',
                phone: '',
                email: '',
                msg: [],
                isError: true
            }
        },
        watch: {
            email(value) {
                this.email = value;
                this.validateEmail(value);
            },
            password(value) {
                this.password = value;
                this.validatePswd(value);
            },
            name(value) {
                this.name = value;
                this.validateName(value);
            }
        },
        
        created() {
            console.log(this.msg)
        },
        mounted() {
            console.log(this.$store.state.user);
        console.log(this.$store.state.token);
        },
        methods: {
            validatePswd(value) {
                let difference = 6 - value.length;
                if (value.length == 0) {
                    this.msg['password'] = "Fill the input field"
                    this.isError = true;
                }
                else if (value.length<6) {
                    this.msg['password'] = 'Must be 6 characters! '+ difference + ' characters left' ;
                    this.isError = true;
                } else {
                    this.msg['password'] = '';
                    this.isError = false;
                }
            },
            validateEmail(value) {
                if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(value)) {
                    this.msg['email'] = '';
                    this.isError = false;
                } else if (!value.length) {
                    this.msg['email'] = "Email is required";
                    this.isError = true;
                } else {
                    this.msg['email'] = 'Invalid Email Address';
                    this.isError = true;
                }
            },

            validateName(value) {
                if (value.length == 0) {
                   this.msg['name'] = "Username is required";
                   this.isError = true; 
                } else {
                    this.msg['name'] = '';
                    this.isError = false;
                }
            },
            
            changeSignupMode() {
                this.signupMode = !this.signupMode;
                this.msg = [];
            },

            async registerUser(e) {
                // Check for Validation
                if (!this.password.length) this.isError =true;
                if (!this.email.length) this.isError = true
                if (!this.name.length) this.isError = true
                if (this.isError) return;
                
                const data = {
                    username: this.name,
                    email: this.email,
                    password: this.password
                }

                
                await axios.post('/api/regiser', data)
                    .then(() => {
                        this.$router.go("/home");
                    }).catch((e) => {
                        console.log(e.data.error);
                        this.msg['auth'] = e.data.error[0];
                    });
                
            },

            async loginUser() {
                // Check for Validation
                if (!this.password.length) this.isError =true;
                if (!this.email.length) this.isError = true;
                if (this.isError) return;
                
                const data = {
                    email: this.email,
                    password: this.password
                }

                try {
                    const response = await axios.post('/api/login', data)
                        .then(response => {
                            let user = JSON.stringify(response.data.message.user);
                            let token = response.data.message.token;
                            localStorage.setItem('token', token);
                            axios.defaults.headers.common['Authorization'] = 'Bearer ' + token;
                            this.$store.add(user, token);
                            if (this.$store.state.token != null){
                                if(this.$route.params.nextUrl != null){
                                    this.$router.push(this.$route.params.nextUrl)
                                }
                                else{
                                    this.$router.push('/dashboard')
                                }
                            }
                          })                                                  
                } catch (e) {
                    console.log(e.response.data.error)
                    this.msg['auth'] = e.response.data.error;
                }
                
            }
        }
    }
</script>
