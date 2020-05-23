<template>
	<!--begin::Item-->
	<div class="timeline-item align-items-start">
		<!--begin::Label-->
		<div class="timeline-label font-weight-bolder text-dark-75 font-size-lg text-right pr-3">{{ point.pivot.duration }}</div>
		<!--end::Label-->

		<!--begin::Badge-->
		<div class="timeline-badge">
			<i class="fa fa-genderless text-default icon-xxl"></i>
		</div>
		<!--end::Badge-->

		<!--begin::Content-->
		<div class="timeline-content">
			<div class="d-flex">
				<span>
					<span class="text-dark-50">{{ point.name }}</span>
					<span v-if="point.pivot.duration" >
						- <span class="font-weight-boldest text-primary mr-2">{{ point.pivot.duration }}</span>
					</span>
					<span v-if="point.pivot.distance" >
						- <span class="font-weight-boldest text-success mr-2">{{ point.pivot.duration }}</span>
					</span>
				</span>

				<!--begin::Section-->
				<div class="d-flex align-items-start mr-2">
					<!--begin::Symbol-->
					<a href="#" class="symbol symbol-35 mr-2">
						<img src="/img/avatar.png" class="h-75 align-self-end" alt="">
					</a>
					<!--end::Symbol-->
				</div>
				<!--end::Section-->
			</div>

			<div class="d-flex">
				<span v-if="isDropOff" class="label label-inline label-light-primary mr-2">DropOff</span>
				<span v-if="!isDropOff" class="label label-inline label-light-success mr-2">PickUp</span>
			</div>
		</div>
		<!--end::Content-->
	</div>
	<!--end::Item-->
</template>

<script>
  import {mapGetters} from 'vuex'

  export default {
    name: "AppRidePoint",
    props: ['point'],
    computed: {
      isDropOff() {
        return this.point.pivot.type == 'drop'
      },
      created_at() {
        return moment(this.point.created_at).format('MMMM Do YYYY')
      },
      avatar() {
        return `/img/avatar.png`
      }
    }
  }
</script>

<style>
</style>