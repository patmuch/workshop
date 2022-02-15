<nav class="mt-2">
    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
      <li class="nav-item">
        <router-link to="/dashboard" class="nav-link">
          <i class="nav-icon fas fa-desktop blue"></i>
          <p>
            Dashboard
          </p>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link to="/materials" class="nav-link">
          <i class="nav-icon fas fa-database yellow"></i>
          <p>
            Raw Material
          </p>
        </router-link>
      </li>

      <li class="nav-item">
        <router-link to="/receive" class="nav-link">
          <i class="nav-icon fas fa-truck green"></i>
          <p>
            Receiving
          </p>
        </router-link>
      </li>




       <li class="nav-item">
        <router-link to="/products" class="nav-link">
          <i class="nav-icon fas fa-list orange"></i>
          <p>
            Product
          </p>
        </router-link>
      </li>


      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cart-plus green"></i>
          <p>
            Orders
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">
           <li class="nav-item">
               <router-link to="/order/salesOrder" class="nav-link">
                <i class="nav-icon fas fa-list-ol green"></i>
                <p>
                    Sales Orders
                </p>
               </router-link>
            </li>
            <li class="nav-item">
               <router-link to="/order/manufacturingOrder" class="nav-link">
                <i class="nav-icon fas fa-list-ol blue"></i>
                <p>
                    Manufacturing Orders
                </p>
               </router-link>
            </li>
        </ul>

      </li>

      

      <li class="nav-item">
        <router-link to="/make" class="nav-link">
          <i class="nav-icon fas fa-upload  yellow "></i>
          <p>
               Production 
          </p>
        </router-link>
      </li>


      <li class="nav-item">
              <router-link to="/recipe" class="nav-link">
                  <i class="nav-icon fas fa-th-large blue"></i>
                  <p>
                      Order Recipe 
                  </p>
              </router-link>
         </li>

         

      <li class="nav-item">
        <router-link to="/wipInventory" class="nav-link">
          <i class="nav-icon fas fa-database  green "></i>
          <p>
            WIP Inventory 
          </p>
        </router-link>
      </li>


      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-tty grey"></i>
          <p>
            Contacts
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/suppliers" class="nav-link">
              <i class="nav-icon fas fa-users-cog blue"></i>
              <p>
                Suppliers
              </p>
            </router-link>
          </li>

          <li class="nav-item">
            <router-link to="/customers" class="nav-link">
              <i class="nav-icon fas fa-user-tag green"></i>
              <p>
                Customers
              </p>
            </router-link>
          </li>
          
        </ul>
      </li>


      @can('isAdmin')
        <li class="nav-item">
          <router-link to="/users" class="nav-link">
            <i class="fa fa-users nav-icon blue"></i>
            <p>Employees</p>
          </router-link>
        </li>
      @endcan

      

      @can('isAdmin')
      <li class="nav-item has-treeview">
        <a href="#" class="nav-link">
          <i class="nav-icon fas fa-cog green"></i>
          <p>
            Settings
            <i class="right fas fa-angle-left"></i>
          </p>
        </a>
        <ul class="nav nav-treeview">

          <li class="nav-item">
            <router-link to="/product/category" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                Product Category
              </p>
            </router-link>
          </li>
          <li class="nav-item">
            <router-link to="/material/materialCategory" class="nav-link">
              <i class="nav-icon fas fa-list-ol green"></i>
              <p>
                Material Category
              </p>
            </router-link>
          </li>
        

        
        </ul>
      </li>
          
            <li class="nav-item">
              <router-link to="/developer" class="nav-link">
                  <i class="nav-icon fas fa-cogs white"></i>
                  <p>
                      Developer
                  </p>
              </router-link>
            </li>
        </ul>
      </li>

      @endcan
      
      

      <li class="nav-item">
        <a href="#" class="nav-link" onclick="event.preventDefault();
          document.getElementById('logout-form').submit();">
          <i class="nav-icon fas fa-power-off red"></i>
          <p>
            {{ __('Logout') }}
          </p>
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
          @csrf
        </form>
      </li>
    </ul>
  </nav>