<template>
	<div>
      <div class="profile-nav">
        <div class="container">
          <ul class="nav nav-metaphor font-weight-bold">
            <li class="nav-item"> <router-link class="nav-link" to="/" active-class="" exact-active-class="active">HOME</router-link> </li>
            <li class="nav-item"> <router-link class="nav-link" to="/classes" active-class="" exact-active-class="active">CLASSES</router-link> </li>
            <li class="nav-item"> <router-link class="nav-link" to="/projects" active-class="" exact-active-class="active">PROJECTS</router-link> </li>
            <li class="nav-item"> <router-link class="nav-link" to="/citations" active-class="" exact-active-class="active">CITATIONS</router-link> </li>
            <li class="nav-item"> <router-link class="nav-link" to="/students" active-class="" exact-active-class="active">STUDENTS</router-link> </li>
          </ul>
        </div>
      </div>
      <router-view></router-view>
	</div>
</template>

<script>
export default {
  name: 'ProfileApp'
}
</script>