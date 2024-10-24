export default function({ app, store, redirect }) {
	if (!store.state.auth.loggedIn) {
		return redirect("/login");
	}
	if (store.state.auth.loggedIn && store.state.auth.user.user_type == 0) {
		return redirect("/admin/dashboard");
	}
	if (store.state.auth.loggedIn && store.state.auth.user.user_type == 1) {
		return redirect("/user/dashboard");
	}
}
