<template>
    <div>
        <h2>
            Hosts
        </h2>
        <form @submit.prevent="addHost" class="mb-3">


            <div class="form-group">

                <div class="card-body">
                    <div class="row">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Host main_name" v-model="host.main_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Host main_name_link" v-model="host.main_name_link">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Host hosting_name" v-model="host.hosting_name">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Host hosting_link" v-model="host.hosting_link">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Host hosting_type" v-model="host.hosting_type">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Host hosting_login" v-model="host.hosting_login">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Host hosting_pass" v-model="host.hosting_pass">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Host comment" v-model="host.comment">
                        </div>
                    </div>


                </div>
            </div>

            <button type="submit" class="btn btn-light btn-block">Save</button>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchHosts(pagination.prev_page_url)">Previous</a>
                </li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchHosts(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>

        <div class="card card-body mb-2" v-for="host in hosts" v-bind:key="host.id">
            <div class="row">
                <h3>{{ host.id }}</h3>
            </div>
            <div class="row">
                <h3>{{ host.main_name }}</h3>
            </div>
            <div class="row">
                <h4>{{ host.main_name_link }}</h4>
            </div>
            <div class="row">
                <h4>{{ host.hosting_name }}</h4>
            </div>
            <div class="row">
                <h4>{{ host.hosting_link }}</h4>
            </div>
            <div class="row">
                <h4>{{ host.hosting_type }}</h4>
            </div>
            <div class="row">
                <h4>{{ host.hosting_login }}</h4>
            </div>
            <div class="row">
                <h4>{{ host.hosting_pass }}</h4>
            </div>
            <div class="row">
                <p>{{ host.comment }}</p>
            </div>

            <hr>
            <!--<button @click="goToEmployees(host)" class="btn btn-primary mb-2">Employees</button>-->
            <button @click="editHost(host)" class="btn btn-warning mb-2">edit</button>
            <button @click="deleteHost(host.id)" class="btn btn-danger">delete</button>

        </div>
    </div>

</template>

<script>
    export default {
        name: "hosts",
        data() {
            return {
                hosts: [],
                host: {
                    id: '',
                    main_name: '',
                    main_name_link:'',
                    hosting_name: '',
                    hosting_link: '',
                    hosting_type: '',
                    hosting_login: '',
                    hosting_pass: '',
                    comment: '',
                },
                host_id: '',
                pagination: {},
                edit: false,
                validationErrors:[],

            };
        },
        created() {
            this.fetchHosts();
        },
        methods:{


            logoChanged(e){
                if(e.target.files[0] !== undefined){
                    if(this.validationErrors.logo != undefined) this.validationErrors.logo = false;
                    console.log(e.target.files[0]);
                    let fileReader = new FileReader();
                    fileReader.readAsDataURL(e.target.files[0]);
                    fileReader.onload = (e) => {
                        this.host.image = e.target.result
                    }
                    this.host.logo = true;
                } else {
                    this.host.image = false;
                }

                console.log(this.host);
            },
            fetchHosts(page_url){
                let vm = this;

                page_url = page_url || '/api/tablehosts';
                fetch(page_url)
                    .then(res => res.json())
            .then(res =>{
                    console.log(res.data);
                this.hosts = res.data;
                vm.makePagination(res.meta, res.links);
            })
            .catch(err => console.log(err));
            },
            makePagination(meta, links){
                let pagination = {
                    current_page: meta.current_page,
                    last_page:meta.last_page,
                    next_page_url: links.next,
                    prev_page_url: links.prev
                };
                console.log(pagination);
                this.pagination = pagination;
            },
            deleteHost(id){
                if(confirm('are you sure?')){
                    fetch(`/api/tablehosts/${id}`,{method:'delete'})
                        .then(res => res.json())
                .then(data => {
                        alert('host removed');
                    this.fetchHosts();
                })
                .catch(err =>console.log(err));
                }
            },
            addHost(){
                console.log(this.edit);
                console.log(this.host);
                if(this.edit === false){
                    //add
                    axios('/api/tablehosts',{
                        method: 'post',
                        body : JSON.stringify(this.host),
                        headers:{

                            'Accept': 'application/json',
                            'content-type':'application/json'
                        },
                        data:this.host
                    })
                    /*'main_name',  'main_name_link', 'hosting_name', 'hosting_link', 'hosting_type', 'hosting_login', 'hosting_pass', 'comment'*/
                        .then(function(response){
                            console.log(response)
                            this.host.main_name = '';
                            this.host.main_name_link = '';
                            this.host.hosting_name = '';
                            this.host.hosting_link = '';
                            this.host.hosting_type = '';
                            this.host.hosting_login = '';
                            this.host.hosting_pass = '';
                            this.host.comment = '';
                            alert('host added');
                            this.fetchHosts();

                        })


                        .catch(err => {
                        if(err.response !== undefined && err.response.status == 422){
                        this.validationErrors = err.response.data.errors;
                    }
                    console.log(err);
                    console.log(this.validationErrors);
                }

                );
                } else {
                    //update
                    fetch('/api/tablehosts',{
                        method: 'put',
                        body : JSON.stringify(this.host),
                        headers:{

                            'content-type':'application/json'
                        }
                    })
                        .then(res => res.json())
                .then(data =>{
                        this.edit = false;
                    this.host = {
                        id: '',
                        main_name: '',
                        main_name_link:'',
                        hosting_name: '',
                        hosting_link: '',
                        hosting_type: '',
                        hosting_login: '',
                        hosting_pass: '',
                        comment: '',
                    };
                    alert('host updated');
                    this.fetchHosts();
                })
                .catch(err => console.log(err));

                }
            },
            editHost(host){
                this.edit = true;
                this.host.id = host.id;
                this.host.host_id = host.id;
                this.host.main_name = host.main_name;
                this.host.main_name_link = host.main_name_link;
                this.host.hosting_name = host.hosting_name;
                this.host.hosting_link = host.hosting_link;
                this.host.hosting_type = host.hosting_type;
                this.host.hosting_login = host.hosting_login;
                this.host.hosting_pass = host.hosting_pass;
                this.host.comment = host.comment;


            },
            goToEmployees(host){
                //this.$route.push({ path: `/hosts/${host.id}/employees` }) // -> /hosts/1/employees
                window.location.href = `/tablehosts/${host.id}/tableadditionalhosts`;
            },
            forceRerender() {
                this.componentKey += 1;
            }
        }
    }
</script>

<style scoped>

</style>