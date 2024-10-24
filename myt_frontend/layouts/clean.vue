<template>
  <div>
    <!-- <vue-particles
		id="particles-js"
		color="#CAA223"
		:particleOpacity="0.7"
		:particlesNumber="80"
		shapeType="circle"
		:particleSize="4"
		linesColor="#CAA223"
		:linesWidth="1"
		:lineLinked="true"
		:lineOpacity="0.4"
		:linesDistance="150"
		:moveSpeed="3"
		:hoverEffect="true"
		hoverMode="grab"
		:clickEffect="true"
		clickMode="push"
		>
	</vue-particles>
 -->
    <nuxt />
    <!-- <LogoutOnInactive /> -->
  </div>
</template>

<script>
// import LogoutOnInactive from "@/components/LogoutOnInactive.vue"; // Import the LogoutOnInactive component
export default {
  components: {
    // LogoutOnInactive,
  },
};
</script>

<style>
#particles-js {
  position: absolute;
  background-size: cover;
  top: 0;
  bottom: 0;
  left: 0;
  right: 0;
  overflow-y: hidden;
  z-index: 0;
}
</style>
