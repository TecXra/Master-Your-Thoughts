<template>
  <div>
    <!-- Your component content here -->
  </div>
</template>

<script>
import { mapState } from "vuex";
export default {
  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },

  mounted() {
    // Set the inactive timeout duration (in milliseconds)
    const inactiveTimeout = 60 * 60 * 1000; // 1 hour

    let timeoutId;

    const resetTimer = () => {
      clearTimeout(timeoutId);
      timeoutId = setTimeout(this.logout, inactiveTimeout);
    };

    this.resetTimer = resetTimer;

    window.addEventListener("mousemove", resetTimer);
    window.addEventListener("mousedown", resetTimer);
    window.addEventListener("keydown", resetTimer);
    window.addEventListener("touchstart", resetTimer);
    window.addEventListener("scroll", resetTimer);
    resetTimer();
  },
  methods: {
    logout() {
      if (this.$auth.loggedIn) {
        this.$auth
          .logout()
          .then(() => {
            return this.$router.push("/login");
          })
          .catch((error) => {
            console.log("Error occurred during logout:", error);
            return this.$router.push("/");
          });
      }
    },
  },
  beforeDestroy() {
    window.removeEventListener("mousemove", this.resetTimer); // Access the resetTimer method using "this"
    window.removeEventListener("mousedown", this.resetTimer);
    window.removeEventListener("keydown", this.resetTimer);
    window.removeEventListener("touchstart", this.resetTimer);
    window.removeEventListener("scroll", this.resetTimer);
  },
};
</script>
