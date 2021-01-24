<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">
    <title>
       Tambah Data Attribut Pariwisata
    </title>

    <!-- CSS  -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="../css/materialize.css" type="text/css" rel="stylesheet" media="screen,projection" />
    <style>
        #bg_pc {
            position: fixed;
            background-image: url('../img/bg.jpg');
            background-clip: border-box;
            background-repeat: no-repeat;
            background-size: cover;
            z-index: -1;
            bottom: 0;
            top: 0;
            left: 0;
            right: 0;            
        }

        #bg_mobile {
            position: fixed;
            background-image: url('../img/bg_mobile.jpg');
            background-clip: border-box;
            background-repeat: no-repeat;
            background-size: cover;
            z-index: -1;
            bottom: 0;
            top: 0;
            left: 0;
            right: 0;            
        }

        .custom-text-on-image-container {
            position: relative;
            text-align: center;
        }
        .custom-text-on-image-centered {
            position: absolute;
        }
        .OfflineWarning {
            overflow: hidden;
            position: fixed;
            top: 25px;
            width: 100%;
            font-size: 32px;
            z-index: 10;
        }
        .bounce-enter-active {
            animation: bounce-in .5s;
        }
        .bounce-leave-active {
            animation: bounce-in .5s reverse;
        }
        @keyframes bounce-in {
            0% {
                transform: scale(0);
            }
            50% {
                transform: scale(1.5);
            }
            100% {
                transform: scale(1);
            }
        } 
    </style>
</head>

<body>
    <noscript>
      <strong>We're sorry but app doesn't work properly without JavaScript enabled. Please enable it to continue.</strong>
    </noscript>  
    <div id="app"> 
        <div id="bg_pc" class="hide-on-small-only" v-show="page.name != 'loading-page'"></div>
        <div id="bg_mobile" class="hide-on-med-and-up" v-show="page.name != 'loading-page'"></div>
        
        <div class="OfflineWarning">
            <transition name="bounce">
                <div class="container center" v-show="!is_online" v-on:click="is_online = true">
                    <div class="row">
                        <div class="col s12 m2"></div>
                        <div class="col s12 m8">
                            <div class="chip red white-text center">
                                <span class="white-text">Perangkat Anda Sedang Offline! 
                                </span>
                            </div>
                        </div>
                        <div class="col s12 m2"></div>
                    </div>
                </div>
            </transition>
        </div>
        <!-- Modal warning -->
        <div id="modal-warning" class="modal">
            <div class="modal-content black">
            <h4 class="orange-text">{{ modal_warning.title }}</h4>
            <p class="white-text">{{ modal_warning.message }}</p>
            </div>
            <div class="modal-footer black">
            <a style="cursor: pointer;" class="modal-close waves-effect waves-green btn-flat white-text">Oke</a>
            </div>
        </div>

        <!---- loading ---->
        <div id="loading-page" v-show="page.name == 'loading-page'">

            <div class="center container">
                <div class="row">
                    <div class="col m2 l4"></div>
                    <div class="col s12">
                        <br /><br /><br /><br />
                        <br /><br /><br /><br />
                        <img src="../img/logoa.png" class="responsive-img" width="500" height="200" />
                        <br />

                        <div class="preloader-wrapper small active">
                            <div class="spinner-layer spinner-green-only">
                              <div class="circle-clipper left">
                                <div class="circle"></div>
                              </div><div class="gap-patch">
                                <div class="circle"></div>
                              </div><div class="circle-clipper right">
                                <div class="circle"></div>
                              </div>
                            </div>
                          </div>

                    </div>
                    <div class="col m2 l4"></div>
                </div>
            </div>    
        </div>
        <!---- kategori---->
        <div id="kategori-page" v-show="page.name == 'kategori-page'">
            <nav class="nav-extended black white-text">
                <div class="nav-wrapper">
                <a href="/admin/beranda.html" class="brand-logo"><img src="../img/logoa.png" class="responsive-img" width="100" height="80" style="margin-top:15px" /></a>
            </nav> 
            <div id="tab-kategori" class="black white-text" style="margin:5px;padding:15px">
                <h4 class="center"><b><br>Tambah Attribut Pariwisata</b></h4><br>
                <h6>Id Pariwisata : {{ data_pariwisata_attribut.data_pariwisata_id }}</h6>
                <br /><br />
                <div class="input-field">
                    <input id="range" type="number" class="validate black white-text" placeholder="id range kriteria" v-model="data_pariwisata_attribut.kriteria_range.id">
                    <label for="range">
                        <span>Id Range Kriteria</span>
                    </label>
                </div>    
                <br />
                <a @click="addAttribut" class="center waves-effect waves-light btn-large orange white-text" style="text-transform:none;width:100%;">
                    <b>
                        <span>Tambah</span>
                    </b>    
                </a>
                <br />  <br />                
                <a href="/admin/beranda.html" class="center waves-effect waves-light btn-large grey white-text" style="text-transform:none;width:100%;">
                    <b>
                        <span>Kembali</span>
                    </b>    
                </a>                  
                <br />
            </div> 
 
        </div>

    </div>
    <!-- built files will be auto injected -->

    <!--  Scripts-->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="../js/materialize.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue/dist/vue.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script>
    
        new Vue({
            el: '#app',
            data() {
                return {
                    data_pariwisata_attribut : {
                        id: 0,
                        data_pariwisata_id : <?php echo (int) $_GET['data_pariwisata_id'];?>,
                        kriteria_range : {
                            id : 0
                        }
                    },
                    page : { name : "loading-page" },
                    is_online : true,
                    modal_warning : {
                        title :"Perhatian",
                        message : "",
                        modal : null,
                    },
                    host : {
                        name : "",
                        protocol : "",
                        port : ""
                    }
                }
            },
            created(){
                window.addEventListener('offline', () => { this.is_online = false })
                window.addEventListener('online', () => { this.is_online = true })
                window.history.pushState({ noBackExitsApp: true }, '')
                window.addEventListener('popstate', this.backPress )
                this.setCurrentHost()
            },
            mounted () {
                this.modal_warning.modal = window.$('#modal-warning')
                window.$('.dropdown-trigger').dropdown();
                window.$('.modal').modal();
                this.switchPage("kategori-page")
            },
            methods : {
                switchPage(name){
                    this.page.name = name 
                },
                addAttribut(){
 
                    axios
                        .post(this.baseUrl() + '/api/data_pariwisata_attribut/add.php',this.data_pariwisata_attribut)
                        .then(response => {
                            if (response.data.error != null){
                                this.showWarning("Perhatian",response.data.error)
                                return
                            }
                            window.location = this.baseUrl() + "/admin/beranda.html" 
 
                        })
                        .catch(errors => {
                            console.log(errors)
                        }) 
                },
                showWarning(title,message){
                    this.modal_warning.title = title
                    this.modal_warning.message = message
                    this.modal_warning.modal.modal('open')
                },
                backPress(){
                    if (event.state && event.state.noBackExitsApp) {
                        window.history.pushState({ noBackExitsApp: true }, '')
                    } 
                    switch(this.page.name) {
                        default: break;
                    }
                },
                setCurrentHost(){
                    this.host.name = window.location.hostname
                    this.host.port = location.port
                    this.host.protocol = location.protocol.concat("//")
                },
                baseUrl(){
                    return this.host.protocol.concat(this.host.name + ":" + this.host.port)
                }
            }
        })

    </script>
</body>

</html>