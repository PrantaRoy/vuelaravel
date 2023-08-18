<template>
<nav class="navbar navbar-expand-sm bg-dark navbar-dark">
  <div class="container-fluid">
    <a class="navbar-brand" :to="{name: 'Home'}" >Logo</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
      <ul class="navbar-nav">
        <li class="nav-item">
          <router-link class="nav-link" :to="{name: 'Home'}">Home</router-link>
        </li>

        <li class="nav-item">
          <router-link class="nav-link" :to="{name: 'About'}">About</router-link>
        </li>

        <li class="nav-item">
          <router-link class="nav-link" v-if="$store.getters.getToken == 0" :to="{name: 'Register'}">Register</router-link>
        </li>
        <li class="nav-item">
          <router-link class="nav-link" v-if="$store.getters.getToken == 0" :to="{name: 'Login'}">Login</router-link>
        </li>

        <li class="nav-item">
          <router-link class="nav-link"  v-if="$store.getters.getToken != 0" :to="{name: 'Dashboard'}">Dashboard</router-link>
        </li>
        
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Dropdown</a>
          <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="#">Link</a></li>
            <li><a class="dropdown-item" href="#">Another link</a></li>
            <li><a class="dropdown-item" href="#">A third link</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
 
</nav>

<router-view></router-view>

</template>