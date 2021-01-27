
new Vue({
    el: '#app',
    data() {
        return {
            page : { name : "loading-page" },
            categories:[],
            facilities:[],
            ticket_prices:[],
            distances: [],
            ages:[],
            param : {
                category_choosed : 0,
                facility : { id : 5,label : "Fasilitas Wisata", values : [] },
                distance : { id : 3,label : "Jarak", value : {} },
                ticket_price : { id : 2,label : "Tiket Masuk", value : {} },
                age : { id : 4,label : "Pilih Umur", value : {} }
            },
            results : [],
            detail : { id : 0, kategori_id : 0,  nama : "", lokasi : "",  jarak : 0, deskripsi : "" },
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
        this.loadPageData()
    },
    mounted () {
        this.modal_warning.modal = window.$('#modal-warning')
        window.$('.dropdown-trigger').dropdown();
        window.$('.modal').modal();
    },
    methods : {
        switchPage(name){
            this.page.name = name 
        },
        chooseCategory(value){ 
            this.param.category_choosed = value; 
            this.switchPage("criteria-page")  
        },
        loadPageData(){
            this.switchPage("loading-page")

            const requestCategory = axios.post(this.baseUrl() + "/api/kategori/list.php",{
                "search_by": "id",
                "search_value": "",
                "order_by": "id",
                "order_dir": "asc",
                "offset": 0,
                "limit": 10
            });
            const requestFacilities = axios.post(this.baseUrl() + "/api/kriteria_range/list.php",{
                "search_by": "kriteria_id",
                "search_value": "5",
                "order_by": "id",
                "order_dir": "asc",
                "offset": 0,
                "limit": 10
            });
            const requestTicketPrices = axios.post(this.baseUrl() + "/api/kriteria_range/list.php",{
                "search_by": "kriteria_id",
                "search_value": "2",
                "order_by": "id",
                "order_dir": "asc",
                "offset": 0,
                "limit": 10
            });
            const requestDistances = axios.post(this.baseUrl() + "/api/kriteria_range/list.php",{
                "search_by": "kriteria_id",
                "search_value": "3",
                "order_by": "id",
                "order_dir": "asc",
                "offset": 0,
                "limit": 10
            });
            const requestAges = axios.post(this.baseUrl() + "/api/kriteria_range/list.php",{
                "search_by": "kriteria_id",
                "search_value": "4",
                "order_by": "id",
                "order_dir": "asc",
                "offset": 0,
                "limit": 10
            });

            axios.all([requestCategory,requestFacilities,requestTicketPrices, requestDistances,requestAges])
                .then(axios.spread((...responses) => {
                    this.categories = responses[0].data.data;
                    this.facilities = responses[1].data.data ;
                    this.ticket_prices = responses[2].data.data;
                    this.distances = responses[3].data.data;
                    this.ages = responses[4].data.data;
                    this.switchPage("category-page")
                }))
                .catch(errors => {
                    console.log(errors)
                    this.switchPage("category-page")
                }) 
        },
        getSAWResult(){
            if (this.param.facility.values.length == 0){
                this.showWarning("Perhatian","Harap memilih fasilitas wisata minimal satu!")
                return;
            }
            if (this.param.ticket_price.value == {}){
                this.showWarning("Perhatian","Harap memilih harga tiket!")
                return;
            }
            if (this.param.distance.value == {}){
                this.showWarning("Perhatian","Harap memilih harga tiket!")
                return;
            }
            if (this.param.age.value == {}){
                this.showWarning("Perhatian","Harap memilih umur!")
                return;
            }

            this.switchPage("loading-page")

            let list_kriteria_ranges_facilities = []
            this.param.facility.values.forEach(element => {
                list_kriteria_ranges_facilities.push({ kriteria_range_id : element.id })
            });

            const reqParam = {
                list_kriteria_ranges: [
                    {
                        kriteria_id: 2,
                        list_kriteria_ranges: [
                            {
                                kriteria_range_id : this.param.ticket_price.value.id
                            } 
                        ]
                    },
                    {
                        kriteria_id: 3,
                        list_kriteria_ranges: [
                            {
                                kriteria_range_id :  this.param.distance.value.id
                            }
                        ]
                    },
                    {
                        kriteria_id: 4,
                        list_kriteria_ranges: [
                            {
                                kriteria_range_id : this.param.age.value.id
                            }
                        ]
                    },
                    {
                        kriteria_id: 5,
                        list_kriteria_ranges: list_kriteria_ranges_facilities
                    }
                ],
                kategori_id : this.param.category_choosed,
                offset: 0,
                limit: 100
            }

            axios
                .post(this.baseUrl() + '/api/saw/list.php',reqParam)
                .then(response => {
                    console.log(JSON.stringify(response.data.data))
                    this.results = response.data.data.list_hasil
                    this.switchPage("result-page")
                })
                .catch(errors => {
                    console.log(errors)
                    this.switchPage("result-page")
                }) 
        },
        getDetail(id){
            this.switchPage("loading-page")
            axios
                .post(this.baseUrl() + '/api/data_pariwisata/one.php',{ 
                    id : id,
                    kategori_id: 0,
                    nama: "",
                    deskripsi: "",
                    lokasi: ""                   
                })
                .then(response => {
                    this.detail = response.data.data
                    this.switchPage("detail-page")
                })
                .catch(errors => {
                    console.log(errors)
                    this.switchPage("detail-page")
                }) 
        },
        toHome(){
            this.param = {
                category_choosed : 0,
                facility : { label : "Fasilitas Wisata", values : [] },
                distance : { label : "Jarak", min_value : "10", max_value : "60" },
                ticket_price : { label : "Tiket Masuk", min_value : "", max_value : "" },
                age : { label : "Pilih Umur", min_value : "", max_value : "" }
            }
            this.switchPage("category-page")
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
                case "criteria-page": this.switchPage("category-page"); break;
                case "result-page": this.switchPage("criteria-page"); break;
                case "detail-page": this.switchPage("result-page"); break;
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
