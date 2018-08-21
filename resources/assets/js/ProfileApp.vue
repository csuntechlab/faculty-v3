<template>
	<div>
		<div class="tab-container">
            <div class="container">
              <ul class="nav">
                <li class="nav-item"> <router-link class="nav-link" to="/">HOME</router-link> </li>
                <li class="nav-item"> <router-link class="nav-link" to="/classes">CLASSES</router-link> </li>
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