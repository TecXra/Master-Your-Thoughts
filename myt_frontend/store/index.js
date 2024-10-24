export const getters = {
    isAuthenticated(state) {
      return state.auth.loggedIn
    },
    loggedInUser(state) {
      return state.auth.user
    },
    loggedIn(state) {
        return state.auth.loggedIn
	},
  	user(state) {
  	    return state.auth.user
	},
}
