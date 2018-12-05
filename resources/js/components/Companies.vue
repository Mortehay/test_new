<template>
    <div>
        <h2>
            Companies
        </h2>
        <form @submit.prevent="addCompany" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Company Name" v-model="company.name">
            </div>
            <div class="form-group">
                <textarea type="text" class="form-control" placeholder="Company Logo" v-model="company.logo"></textarea>
            </div>
            <button type="submit" class="btn btn-light btn-block">Save</button>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchCompanies(pagination.prev_page_url)">Previous</a>
                </li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchCompanies(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>
        <div class="card card-body mb-2" v-for="company in companies" v-bind:key="company.id">
            <h3>{{ company.name }}</h3>
            <p>{{ company.logo }}</p>
            <hr>
            <button @click="goToEmployees(company)" class="btn btn-primary mb-2">Employee</button>
            <button @click="editCompany(company)" class="btn btn-warning mb-2">edit</button>
            <button @click="deleteCompany(company.id)" class="btn btn-danger">delete</button>
        </div>
    </div>

</template>

<script>
    export default {
        name: "companies",
        data() {
            return {
                companies: [],
                company: {
                    id: '',
                    name: '',
                    logo: ''
                },
                company_id: '',
                pagination: {},
                edit: false
            };
        },
        created() {
            this.fetchCompanies();
        },
        methods:{
            fetchCompanies(page_url){
                let vm = this;
                page_url = page_url || '/api/companies';
                fetch(page_url)
                    .then(res => res.json())
                    .then(res =>{
                        ///console.log(res.data);
                        this.companies = res.data;
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
            deleteCompany(id){
                if(confirm('are you sure?')){
                    fetch(`api/company/${id}`,{method:'delete'})
                        .then(res => res.json())
                        .then(data => {
                            alert('company removed');
                            this.fetchCompanies();
                        })
                        .catch(err =>console.log(err));
                }
            },
            addCompany(){
                console.log(this.edit);

                if(this.edit === false){
                    //add
                    fetch('api/company',{
                        method: 'post',
                        body : JSON.stringify(this.company),
                        headers:{
                            'content-type':'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data =>{
                            this.company.name = '';
                            this.company.logo = '';
                            alert('company added');
                            this.fetchCompanies();
                        })
                        .catch(err => console.log(err));
                } else {
                    //update
                    fetch('api/company',{
                        method: 'put',
                        body : JSON.stringify(this.company),
                        headers:{
                            'content-type':'application/json'
                        }
                    })
                        .then(res => res.json())
                        .then(data =>{
                            this.edit = false;
                            this.company = {
                                id: '',
                                name: '',
                                logo: ''
                            };
                            alert('company updated');
                            this.fetchCompanies();
                        })
                        .catch(err => console.log(err));

                }
            },
            editCompany(company){
                this.edit = true;
                this.company.id = company.id;
                this.company.company_id = company.id;
                this.company.name = company.name;
                this.company.logo = company.logo;

            },
            goToEmployees(company){
                //this.$route.push({ path: `/companies/${company.id}/employees` }) // -> /companies/1/employees
                window.location.href = `/companies/${company.id}/employees`;
            }
        }
    }
</script>

<style scoped>

</style>