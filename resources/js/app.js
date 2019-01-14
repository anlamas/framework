
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

const app = new Vue({
    el: '#app',
    data: {
        errors: {},
        name : '',
        email: '',
        body: '',
        loading: false,
        tasks: [],
        paginator: {
            total: 0,
            perPage: 1,
            currentPage: 1,
            lastPage: 1,
            elements: []
        },
        queryParams: {
            orderBy: 'updatedAt',
            direction: 'desc',
            page: 1
        },
        filters: {
            updatedAt : 'desc',
            finished : 'asc',
            name : 'desc',
            email : 'desc',
        },
        toaster: {
            opened: false,
            message : ''
        }
    },
    methods: {
        addTask: function (e) {
            
            e.preventDefault();
            
            this.errors = {};
            this.loading = true;
            
            axios.post('/tasks', {
                name : this.name,
                email : this.email,
                body: this.body
            })
            .then(response => {
                if (response.data.hasOwnProperty('errors')) {
                    this.errors = response.data.errors;
                    this.toastMessage('Не удалось добавить задачу');
                } else {
                    this.body = '';
                    this.toastMessage('Задача успешно добавлена');
                }
            })
            .catch(error => {
                this.toastMessage(error.statusText);
            })
            .then(() => {
                this.loading = false;
                this.loadTasks();
            });
        },
        loadTasks: function () {
            axios.get('/tasks', {
               params: this.queryParams
            })
            .then(response => {
                this.tasks = response.data.data;
                this.paginator = response.data.paginator
            })
            .catch(error => {
                console.log(error);
            });
        },
        hasMorePages: function () {
            return this.paginator.currentPage !== 1 || this.paginator.currentPage < this.paginator.lastPage;
        },
        isFirstPage: function () {
            return this.paginator.currentPage <= 1;
        },
        isLastPage: function () {
            return this.paginator.currentPage === this.paginator.lastPage;
        },
        previousPage: function (e) {
            // $event.preventDefault();
            // this.query_data.page -= 1;
            // this.paginator.currentPage -= 1;
            // vm.actions.init();
        },
        nextPage: function (e) {
            // $event.preventDefault();
            // this.query_data.page += 1;
            // this.paginator.currentPage += 1;
            // vm.actions.init();
        },
        toPage: function(page) {
            this.paginator.currentPage = page;
            this.queryParams.page = page;
            this.loadTasks();
        },
        orderBy: function (column) {
            this.filters[column] = this.filters[column] === 'asc' ? 'desc' : 'asc';
            this.queryParams.orderBy = column;
            this.queryParams.direction = this.filters[column];
            this.queryParams.page = this.paginator.currentPage;
            this.loadTasks();
        },
        updateTask: function (i) {
            task = this.tasks[i];
            axios.post('/tasks/' + task.id, {
                finished : task.finished,
                body: task.body
            })
            .then(response => {
                if (response.data.hasOwnProperty('errors')) {
                    this.toastMessage(response.data.errors[0]);
                } else {
                    this.toastMessage('Успешно обновлено')
                }
            })
            .catch(error => {
                this.toastMessage(error.statusText)
            })
            .then(() => {
                this.loadTasks();
            });
        },
        toastMessage: function (message) {
            this.toaster.message = message;
            this.toaster.opened = true;
            setTimeout(function (toaster) {
                toaster.message = '';
                toaster.opened = false;
            }, 5000, this.toaster);
        }
    },
    mounted() {
        this.loadTasks();
    }
});