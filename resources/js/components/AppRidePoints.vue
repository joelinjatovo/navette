<template>
	<div class="timeline timeline-5 mt-3">
		<AppRidePoint v-for="point in points" :key="point.pivot.id"  :point="point"></AppRidePoint>
	</div>
</template>

<script>
  import {mapGetters} from 'vuex'
  import AppRidePoint from './AppRidePoint'

  export default {
    name: "AppRidePoints",
    components: {AppRidePoint},
    props: ['points']
  }
</script>

<style>
</style>