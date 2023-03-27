<template>
    <div class="container">
        <div class="filter__selects">
            <v-dialog
                v-model="showFilter"
                scrollable
                width="auto"
            >
        <template v-slot:activator="{ props }">
            <v-btn
            color="primary"
            v-bind="props"
            >
            Фильтр по объектам
            </v-btn>
        </template>
        <v-card>
            <v-card-title>Фильтр по объектам</v-card-title>
            <v-divider></v-divider>
            <v-card-text style="height: 300px;">
                <div>Выберите город</div>
                <div v-for="item in filterCity" :key="item.id" class="flex items-center mb-4">
                    <input v-model="selectedFilterCity[item.id]" id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ item.name }}</label>
                </div>
                 <div>Выберите объекты</div>
                <div v-for="item in filterObject" :key="item.id" class="flex items-center mb-4">
                    <input v-model="selectedFilterObject[item.id]" id="default-checkbox" type="checkbox" value="" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ item.name }}</label>
                </div>
            </v-card-text>
            <v-divider></v-divider>
            <v-card-actions>
                <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="showFilter = false"
                >
                    Close
                </v-btn>
                <v-btn
                    color="blue-darken-1"
                    variant="text"
                    @click="updateFromfilter"
                >
                    Save
                </v-btn>
            </v-card-actions>
        </v-card>
        </v-dialog>
        </div>
        <div class="cards d-flex">
            <Card v-for="card in cards" :key="card.id" :card={...card} />
        </div>
         <v-pagination
            v-model="page"
            :length="last_page"
            rounded="circle"
        ></v-pagination>
    </div>
</template>

<script>
    import Card from './Card.vue';
    import axios from 'axios';

    export default {
        components: {
            Card
        },
        data(){
            return{
                cards:[],
                filterObject: [{id:'1',name:'1'},{id:'2',name:'2'},{id:'3',name:'3'}],
                selectedFilterObject: [],
                filterCity: [{id:'1',name:'a'},{id:'2',name:'b'},{id:'3',name:'c'}],
                selectedFilterCity: [],
                showFilter:false,
                page:1,
                last_page:null,
            }
        },
        methods:{
            updateData()
            {
                let params = {
                            type_id: this.selectedFilterObject,
                            city_id: this.selectedFilterCity,
                            page: this.page
                        };
                axios.post(import.meta.env.VITE_API_BACKEND_API+'/builds/index',params).then(response=>{
                    const result = response.data;
                    this.cards =  result.items.data;
                    this.last_page =  result.items.last_page;
                    this.filterObject =  result.types;
                    this.filterCity =  result.cities;
                });
            },
            updateFromfilter()
            {
                this.showFilter = false;
                this.updateData();
            }
        },
        watch: {
            page(newQuestion, oldQuestion) {
                this.updateData();
            },
        },
        mounted() {
            this.updateData();
        }
    }
</script>
<style>
    .cards
    {
        margin-top:20px
    }
    .filter__selects
    {
        width: 250px;
        margin-top:20px;
    }
</style>