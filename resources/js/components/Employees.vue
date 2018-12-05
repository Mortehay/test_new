<template>
    <div>
        <button @click="goToCompanies()" class="btn btn-primary mb-2">Go Back to Companies</button>
        <h2>
            Employees
        </h2>
        <p v-if="errors.length">
            <b>Please correct the following error(s):</b>
        <ul>
            <li v-for="error in errors">{{ error }}</li>
        </ul>
        </p>
        <form @submit.prevent="addEmployee($event)" class="mb-3">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Employee first_name" v-model="employee.first_name">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Employee last_name" v-model="employee.last_name"></input>
            </div>
            <div class="form-group">

                <input type="text" class="form-control" placeholder=""  v-model="employee.company_id" readonly></input>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Employee email" v-model="employee.email"></input>
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Employee phone" v-model="employee.phone"></input>
            </div>
            <button type="submit" class="btn btn-light btn-block">Save</button>
        </form>
        <nav aria-label="Page navigation example">
            <ul class="pagination">
                <li v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchEmployees(pagination.prev_page_url)">Previous</a>
                </li>
                <li class="page-item disabled"><a class="page-link text-dark" href="#">Page {{pagination.current_page}} of {{pagination.last_page}}</a></li>
                <li v-bind:class="[{disabled: !pagination.next_page_url}]" class="page-item">
                    <a class="page-link" href="#" @click="fetchEmployees(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>
        <div class="card card-body mb-2" v-for="employee in employees" v-bind:key="employee.id">
            <h4>{{ employee.first_name }}</h4>
            <h4>{{ employee.last_name }}</h4>
            <h4>{{ employee.company_id }}</h4>
            <h4>{{ employee.email }}</h4>
            <h4>{{ employee.phone }}</h4>
            <hr>
            <button @click="editEmployee(employee)" class="btn btn-warning mb-2">edit</button>
            <button @click="deleteEmployee(employee.id)" class="btn btn-danger">delete</button>
        </div>
    </div>

</template>

<script>
    export default {
        name: "employees",
        data() {
            return {
                employees: [],
                errors:[],
                employee: {
                    id: '',
                    first_name: '',
                    last_name: '',
                    company_id: '',
                    email: '',
                    phone: '',
                },
                employee_id: '',
                pagination: {},
                edit: false
            };
        },
        created() {

            this.fetchEmployees();

        },
        methods:{
            fetchEmployees(page_url){
                let vm = this;

                let id = window.location.pathname.split('/')[2];
                this.employee.company_id = id;
                page_url = page_url || `/api/employees/${id}`;
                fetch(page_url)
                    .then(res => res.json())
                    .then(res =>{
                        ///console.log(res.data);
                        this.employees = res.data;
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
            deleteEmployee(id){
                if(confirm('are you sure?')){
                    fetch(`/api/employee/${id}`,{method:'delete'})
                        .then(res => res.json())
                        .then(data => {
                            alert('employee removed');
                            this.fetchEmployees();
                        })
                        .catch(err =>console.log(err));
                }
            },
            addEmployee(){
                console.log(this.edit);
                if(this.checkForm(event)){
                    if(this.edit === false){
                        //add
                        fetch('/api/employee',{
                            method: 'post',
                            body : JSON.stringify(this.employee),
                            headers:{
                                'content-type':'application/json'
                            }
                        })
                            .then(res => res.json())
                            .then(data =>{
                                this.employee.first_name = '';
                                this.employee.last_name = '';
                                this.employee.company_id = '';
                                this.employee.email = '';
                                this.employee.phone = '';
                                alert('employee added');
                                this.fetchEmployees();
                            })
                            .catch(err => console.log(err));
                    } else {
                        //update
                        console.log(JSON.stringify(this.employee));
                        fetch('/api/employee',{
                            method: 'put',
                            body : JSON.stringify(this.employee),
                            headers:{
                                'content-type':'application/json'
                            }
                        })
                            .then(res => res.json())
                            .then(data =>{
                                this.edit = false;
                                this.employee = {
                                    id: '',
                                    first_name: '',
                                    last_name: '',
                                    company_id: '',
                                    email: '',
                                    phone: '',
                                };
                                alert('employee updated');
                                this.fetchEmployees();
                            })
                            .catch(err => console.log(err));

                    }
                }

            },
            editEmployee(employee){
                this.edit = true;
                this.employee.id = employee.id;
                this.employee.employee_id = employee.id;
                this.employee.first_name = employee.first_name;
                this.employee.last_name = employee.last_name;
                this.employee.company_id = employee.company_id;
                this.employee.email = employee.email;
                this.employee.phone = employee.phone;

            },
            checkForm(e){
                if(this.employee.first_name != '' && this.employee.last_name != '' && this.employee.last_name != '' && this.employee.email != '' &&this.employee.phone != '') return true;
                this.errors = [];
                if(this.employee.first_name == '') this.errors.push('First Name Required');
                if(this.employee.last_name == '') this.errors.push('Last Name Required');
                if(this.employee.company_id == '') this.errors.push('Company Id Required');
                if(this.employee.email == '') {
                    this.errors.push('Email Required');
                } else if (!this.validEmail(this.employee.email)){
                    this.errors.push('You shoul use correct email');
                }
                console.log('phone',this.employee.phone);
                if(this.employee.phone === '') {
                    this.errors.push('Phone Number Required')
                } else if(typeof this.employee.phone !== 'number'){
                    this.errors.push('You shoul use correct phone number');
                }


                return (!this.errors.length)?true:false;

            },
            goToCompanies(employee){

                window.location.href = `/home`;
            },
            validEmail: function (email) {
                var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
                return re.test(email);
            },


        }
    }
</script>

<style scoped>

</style>