<template>
  <div class="card mb-4">
    <div class="card-header font-weight-bold">
      Change Email
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-sm-12 col-md-6 col-lg-4">
          <div class="form-group">
            <label for="name">Email:</label>
            <input
              type="email"
              placeholder="email"
              id="name"
              class="form-control"
              v-model="form.email"
            />
          </div>
        </div>

        <div class="col-sm-12 col-md-12 col-lg-12 text-right">
          <b-button variant="primary" @click="updateEmailInfoById()">
            Update
          </b-button>
        </div>
      </div>
    </div>

    <b-modal id="getpassword" centered hide-header hide-footer>
      <div class="container">
        <div class="row">
          <div class="col text-center">
            <div class="form-group">
              <label for="name">Password:</label>
              <input
                type="password"
                placeholder="*********"
                id="name"
                class="form-control"
                v-model="form.password"
              />
            </div>
            <div class="mt-4 mb-2">
              <b-button variant="light" @click="closeModal">
                Cancel
              </b-button>
              <b-button variant="primary" @click="onUpdateEmailById">
                <i v-if="isLoading" class="fa fa-spinner fa-pulse"></i>
                Update
              </b-button>
            </div>
          </div>
        </div>
      </div>
    </b-modal>
  </div>
</template>
<script type="text/javascript">
import { mapState } from "vuex";
export default {
  props: ["userInfo"],
  data() {
    return {
      isLoading: false,
      form: {
        id: "",
        password: "",
        email: "",
      },
    };
  },

  computed: {
    ...mapState("auth", ["loggedIn", "user"]),
  },

  methods: {
    closeModal() {
      this.$bvModal.hide("getpassword");
    },
    updateEmailInfoById() {
      this.$bvModal.show("getpassword");
    },

    async onUpdateEmailById() {
      event.preventDefault();
      this.isLoading = true;
      var self = this;

      await this.$axios
        .post("admin/updateEmailInfoById", this.form)
        .then(function(response) {
            self.$bvToast.toast("Email Updated Successfuly.", {
              variant: "success",
              solid: true,
            });
          self.$bvModal.hide("getpassword");
          self.form.email = "";
          self.form.password = "";

        })
        .catch(function(error) {
          console.log("error");
          console.log(error.response.data.errors);
        });
        self.isLoading = false
    },
  },
  mounted() {
    this.form.id = this.user.id;
  },
};
</script>
