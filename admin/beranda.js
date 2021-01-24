
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
            tab : { name : "tab-kategori" },
            tab_category : {
                categories :[],
                query : {
                    search_by: "id",
                    search_value: "",
                    order_by: "id",
                    order_dir: "asc",
                    offset: 0,
                    limit: 10
                }
            },
            tab_criteria : {
                criterias :[],
                query : {
                    search_by: "id",
                    search_value: "",
                    order_by: "id",
                    order_dir: "asc",
                    offset: 0,
                    limit: 10
                }
            },
            tab_criteria_range : {
                criteria_ranges :[],
                query : {
                    search_by: "id",
                    search_value: "",
                    order_by: "id",
                    order_dir: "asc",
                    offset: 0,
                    limit: 10
                }
            },
            tab_data_wisata : {
                data_wisatas :[],
                query : {
                    search_by: "id",
                    search_value: "",
                    order_by: "id",
                    order_dir: "asc",
                    offset: 0,
                    limit: 10
                }
            },
            tab_attribute : {
                attributes : [],
                query : {
                    search_by: "id",
                    search_value: "",
                    order_by: "id",
                    order_dir: "asc",
                    offset: 0,
                    limit: 10
                }
            },
            tab_admin : {
                admins :[],
                query : {
                    search_by: "id",
                    search_value: "",
                    order_by: "id",
                    order_dir: "asc",
                    offset: 0,
                    limit: 10
                }
            },
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
        this.loadSession()
    },
    methods : {
        switchPage(name){
            this.page.name = name 
        },
        switchTab(name){
            this.tab.name = name 
        },
        loadPageData(){
            this.switchPage("loading-page")

            const requestCategories = axios.post(this.baseUrl() + "/api/kategori/list.php", this.tab_category.query);
            const requestCriterias = axios.post(this.baseUrl() + "/api/kriteria/list.php", this.tab_criteria.query);
            const requestCriteriaRanges = axios.post(this.baseUrl() + "/api/kriteria_range/list.php",this.tab_criteria_range.query);
            const requestDataWisatas = axios.post(this.baseUrl() + "/api/data_pariwisata/list.php",this.tab_data_wisata.query);
            const requestAttributes = axios.post(this.baseUrl() + "/api/data_pariwisata_attribut/list.php",this.tab_attribute.query);
            const requestAdmins = axios.post(this.baseUrl() + "/api/admin/list.php", this.tab_admin.query);

            axios.all([requestCategories,requestCriterias,requestCriteriaRanges,requestDataWisatas,requestAttributes,requestAdmins])
                .then(axios.spread((...responses) => {
                    this.tab_category.categories = responses[0].data.data;
                    this.tab_criteria.criterias = responses[1].data.data;
                    this.tab_criteria_range.criteria_ranges = responses[2].data.data ;
                    this.tab_data_wisata.data_wisatas = responses[3].data.data;
                    this.tab_attribute.attributes = responses[4].data.data;
                    this.tab_admin.admins = responses[5].data.data;
                    this.switchPage("dashboard-page")
                }))
                .catch(errors => {
                    console.log(errors)
                    this.switchPage("dashboard-page")
                }) 
        },
        loadSession(){
            if (window.localStorage && window.localStorage.getItem('admin_session')) {
                this.admin = JSON.parse(window.localStorage.getItem('admin_session'))
                this.switchPage("dashboard-page")
                this.loadPageData()
                return;
            }
            window.location = this.baseUrl() + "/admin/index.html"
        },
        logout(){
            if (window.localStorage) {
                window.localStorage.removeItem('admin_session')
                window.location = this.baseUrl() + "/admin/index.html"   
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
