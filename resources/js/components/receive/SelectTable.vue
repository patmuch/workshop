<template>
    <div id="app">
  <h1>Vue Select</h1>

  <table class="table table-stripped table-bordered">
    <tr>
      <th style="width: 20%;">Emission Source Name</th>
      <th style="width: 40%;">Responsible person</th>
      <th style="width: 40%;">Calculation method</th>
      <th style="width: 40%;"></th>
    </tr>
    <tr v-for="(releaseSource,index) in releaseSources" :key= "index" >
      <td>{{ releaseSource.name }}</td>
      <td>
        <v-select :options="users" label="fullname" :value="releaseSource.responsible" @input="responsible => updateResponsible(releaseSource, responsible)" />
      </td>
      <td>
        <v-select :options="calcmethods" label="calcMethodName" :value="releaseSource.calcmethod" @input="calcmethod => updateCalcMethod(releaseSource, calcmethod)" />
      </td>
      <td class="text-right"><button class="btn btn-sm btn-outline-danger" @click.prevent="deleteItem(index)">Delete item</button></td>
    </tr>
    <tr>
      <td colspan="4">
        <button class="btn btn-sm btn-primary" @click.prevent="addRow">Add row</button>
      </td>
    </tr>
  </table>

  <textarea class="form-control" rows="5" v-model="releaseSources[index] ">  </textarea>

</div>

</template>
<script>
  
  import vSelect from 'vue-select';

export default {
 

   components: {
        vSelect
        },

 data() {

     return{

    releaseSources: [
      {
        uid: 1,
        name: "Power Generator CAT 334",
        responsible: "",
        calcmethod: {}
      },
      {
        uid: 2,
        name: "Welding machine Miller 123",
        responsible: "",
        calcmethod: {}
      },
      {
        uid: 3,
        name: "Compressor Atlas COPCO 111",
        responsible: "",
        calcmethod: {}
      }
    ],

  users: [
  {
    fullname: "Kovalenko Vyacheslav Stanislavovich" ,
    email: "kovalsky@mail.ru"
  },
  {
    fullname: "Dorofeev Matvey Bronislavovich",
    email: "dorofey@mail.ru"
  },
  {
    fullname: "Gorshkov Khariton Yaroslavovich",
    email: "gorshok@mail.ru"
  },
  {
    fullname: "Petrov Osip Valeryevich",
    email: "petroff@mail.ru"
  },
  {
    fullname: "Mazailo Erik Vitalievich",
    email: "maz-edik@mail.ru"
  },
  {
    fullname: "Efimov Karl Artemovich",
    email: "effim@mail.ru"
  },
  {
    fullname: "Orlov Fyodor Vadimovich",
    email: "the-eagle@mail.ru"
  },
  {
    fullname: "Butko Adrian Anatolievich",
    email: "but-co@mail.ru"
  },
  {
    fullname: "Sirko Denis Maksimovich",
    email: "sir-co@mail.ru"
  },
  {
    fullname: "Semyonov Vlad Sergeevich",
    email: "semenov-vlad@mail.ru"
  }
],

calcmethods: [
  { calcMethodId: "11", calcMethodName: "Calculation method 1" },
  { calcMethodId: "22", calcMethodName: "Calculation method 2" },
  { calcMethodId: "33", calcMethodName: "Calculation method 3" },
  { calcMethodId: "44", calcMethodName: "Calculation method 4" }
],


  }

 },


  methods:{

    updateResponsible(releaseSource, responsible){

      releaseSource.responsible = responsible;
    },

    updateCalcMethod(releaseSource, calcmethod){
      
      releaseSource.calcmethod = calcmethod;
    },

    addRow() {
      this.releaseSources.push({
        uid: "",
        name: "",
        responsible: "",
        calcmethod: {}
      });
    },
    deleteItem(index) {
      this.releaseSources.splice(index, 1);
    }
  },
  computed: {
    users: () => users,
    calcmethods: () => calcmethods
  }

}
</script>

<style scoped>

body {
  font-family: "Source Sans Pro", "Helvetica Neue", Arial, sans-serif;
  text-rendering: optimizelegibility;
  -moz-osx-font-smoothing: grayscale;
  -moz-text-size-adjust: none;
}

</style>