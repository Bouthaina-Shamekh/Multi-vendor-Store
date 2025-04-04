<?php
  return [
       [
        'icon' => 'nav-icon fas fa-tachometer-alt ',
        'route' =>'dashboard',
        'title' =>'Dashboard',
       ],

       [
        'icon' => ' far fa-circle nav-icon ',
        'route' =>'category.index',
        'title' =>'Categories',
       ],

       [
          'icon' => 'fas fa-box nav-icon',
          'route' => 'products.index',
          'title' => 'Products',
          'active' => 'dashboard.products.*',
          'ability' => 'products.view',
      ],
      

      [
        'icon' => 'fas fa-shield nav-icon',
        'route' => 'roles.index',
        'title' => 'Roles',
        'active' => 'dashboard.roles.*',
        'ability' => 'roles.view',
    ],
    // [
    //     'icon' => 'fas fa-users nav-icon',
    //     'route' => 'users.index',
    //     'title' => 'Users',
    //     'active' => 'dashboard.users.*',
    //     'ability' => 'users.view',
    // ],
    // [
    //     'icon' => 'fas fa-users nav-icon',
    //     'route' => 'admins.index',
    //     'title' => 'Admins',
    //     'active' => 'dashboard.admins.*',
    //     'ability' => 'admins.view',
    // ],


  ];