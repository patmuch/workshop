<template>
<div class="panel panel-default">
    <div class="panel-body">
      <input type="text" placeholder="Enter Material name to receive..." v-model="query" @keyup="autoComplete"  class="form-control input-lg" />
      </div>
      <div class="panel-footer" v-show="results.length > 1">
        <ul class="list-group">
          <li class="list-group-item" v-for="result in results" :key="result.id">
             {{result}}
          </li>
        </ul>
      </div>
  </div>
</template>
<script>
export default {
    name: 'MaterialAutocomplete',

    data(){

      return{
        query:'',
        results:[]
      }
    },
    methods:{

      autoComplete(){
        this.results = [];
         if(this.query.length > 2){

        axios.get('api/search',{params: {
          query:this.query
        }}).then(response => {
          this.results = response.data;
        });
       }
      },

   
    }


}
</script>