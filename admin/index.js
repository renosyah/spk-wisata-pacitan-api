
new Vue({
    el: '#app',
    data() {
        return {
            admin : {
                id: 0,
                name: "",
                username: "",
                password: ""
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
        this.switchPage("login-page")
        this.loadSession()
    },
    methods : {
        switchPage(name){
            this.page.name = name 
        },
        login(){
            if (this.admin.username == "" || this.admin.password == "" ){
                this.showWarning("Perhatian","Harap mengisi form login!")
                return;
            }

            axios
                .post(this.baseUrl() + '/api/admin/login.php',this.admin)
                .then(response => {
                    if (response.data.error != null){
                        this.showWarning("Perhatian",response.data.error)
                        return
                    }
                    if (window.localStorage) {
                        window.localStorage.setItem('admin_session', JSON.stringify(response.data.data))
                        window.location = this.baseUrl() + "/admin/beranda.html"
                    }
                })
                .catch(errors => {
                    console.log(errors)
                }) 
        },
        loadSession(){
            if (window.localStorage && window.localStorage.getItem('admin_session')) {
                this.admin = JSON.parse(window.localStorage.getItem('admin_session'))
                window.location = this.baseUrl() + "/admin/beranda.html" 
                return;
            }
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
