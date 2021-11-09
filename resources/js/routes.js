export default [
    { path: '/dashboard', component: require('./components/Dashboard.vue').default },
    { path: '/profile', component: require('./components/Profile.vue').default },
    { path: '/developer', component: require('./components/Developer.vue').default },
    { path: '/users', component: require('./components/Users.vue').default },
    { path: '/suppliers', component: require('./components/Suppliers.vue').default },
    { path: '/sale', component: require('./components/Sale.vue').default },
    { path: '/receive', component: require('./components/receive/Receive.vue').default },
    { path: '/search/material', component: require('./components/receive/Demo.vue').default },
    { path: '/customers', component: require('./components/Customers.vue').default },
    { path: '/contacts', component: require('./components/Contacts.vue').default },
    { path: '/products', component: require('./components/product/Products.vue').default },
    { path: '/materials', component: require('./components/material/Materials.vue').default },
    { path: '/material/uom', component: require('./components/material/Uom.vue').default },
    { path: '/order/manufacturingOrder', component: require('./components/order/ManufacturingOrder.vue').default },
    { path: '/order/salesOrder', component: require('./components/order/SalesOrder.vue').default },
    { path: '/make', component: require('./components/production/Production.vue').default },
    { path: '/product/tag', component: require('./components/product/Tag.vue').default },
    { path: '/product/category', component: require('./components/product/Category.vue').default },
    { path: '/material/materialCategory', component: require('./components/material/MaterialCategory.vue').default },
    { path: '*', component: require('./components/NotFound.vue').default }
];
