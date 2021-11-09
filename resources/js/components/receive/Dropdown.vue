<template>

       <div class="dropdown-wrapper"  >
       <div @click="isVisible = !isVisible" class="selected-item">
           <span v-if="selectedItem" >
               {{ selectedItem.name }}
           </span>
           <span v-else >Select User</span>
           <svg 
           class="drop-down-icon" 
           xmlns="http://www.w3.org/2000/svg" 
           viewBox="0 0 24 24" 
           width="24" 
           height="24"
           >
           <path fill="none" d="M0 0h24v24H0z"/>
           <path d="M12 10.828l-4.95 4.95-1.414-1.414L12 8l6.364 6.364-1.414 1.414z"/>
           </svg>

       </div>

       <div :class="isVisible ? 'visible': 'invisible'" class="dropdown-popover">
           <input type="text" v-model="searchQuery" placeholder="search for Material">
           <span v-if="filteredUser.length === 0"> No data </span>
           <div class="options">
               <ul>
                   <li
                     @click="selectItem(user)"
                     v-for="(user,index) in filteredUser"
                     :key="index"
                    >
                        {{user.name}} 
                </li>
                  
               </ul>
           </div>
       </div>
       </div>
  
</template>
<script>
export default {
    data(){
        return{
            searchQuery:"",
            selectedItem: null,
            isVisible:false,
            userArray:[]
        };
    },

    computed: {
        filteredUser(){
            const query = this.searchQuery.toLowerCase();
            if (this.searchQuery === ""){
                return this.userArray;
            }
            return this.userArray.filter((user) =>{
                return Object.values(user).some((word) => 
                String(word).toLowerCase().includes(query)
                );
            });          
        },
    },

    methods:{
        selectItem(user){
            this.selectedItem = user;
            this.isVisible = false;
        },
    },

    mounted(){

       fetch("https://jsonplaceholder.typicode.com/users")
       .then((res) => res.json())
       .then((json) => {
           console.log(json);
           this.userArray = json;
       });
       
      

 },

}
</script>
<style scoped lang="scss">

.dropdown-wrapper{

    max-width:350px;
    position: relative;
    margin: 0 auto;


  .selected-item{

    height: 40px;
    border:2px solid lightgrey;
    border-radius: 5px;
    padding: 5px 10px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 18px;
    font-weight: 400;

    .drop-down-icon{
       transform: rotate(0deg);
       transition: all 0.4s ease;

        &.dropdown {
           transform: rotate(180deg);

       }

    }
}

.dropdown-popover{
    position: absolute;
    border: 2px solid lightgrey;
    top: 46px;
    left: 0;
    right:0;
    background-color: #fff;
    max-width: 100%;
    padding: 10px;
    visibility: hidden;
    transition: all 0.5s linear;
    max-height: 0px;
    overflow: hidden;

    &.visible{
        max-height: 450px;
        visibility: visible;
    }


input{
    width:90%;
    height: 30px;
    border: 2px solid lightgrey;
    font-size: 16px;
    padding-left: 8px;
    
}
.options{
    width: 100%;
    ul{
        list-style: none;
        text-align: left;
        padding-left: 8px;
        max-height: 180px;
        overflow-y: scroll;
        overflow-x: hidden;

        li{
            width: 100%;
            border-bottom: 1px solid lightgrey;
            padding: 10px;
            background-color: #f1f1f1;
            cursor: pointer;
            font-size: 16px;
            &:hover{
                background: #70878a;
                color: white;
                font-weight: bold;
            }
        }
    }
  }
 }
}
</style>