<template>
  <section class="py-8">
    <div class="d-flex overflow-auto bg-secondary">
      <div
        v-for="(singleUnit, index) in unitListWithQuestions"
        :key="index"
        style="width: 200px"
      >
        <div
          class="p-3 border-left d-flex justify-content-between align-items-center mb-3"
          style="width: inherit;"
        >
          <h4 class="mb-0" v-if="!singleUnit.isTitleEditActive">
            {{ singleUnit.title }}
          </h4>
          <input
            type="text"
            v-model="selectedUnitTitle"
            class="form-control py-1"
            autofocus
            v-else
          />

          <i
            v-b-tooltip.hover="'Click to edit unit title'"
            class="fas fa-pencil-alt fa-sm text-info cursor-pointer ml-2"
            v-if="!singleUnit.isTitleEditActive"
            @click="editUnitTitle(singleUnit, index)"
          ></i>

          <i
            v-b-tooltip.hover="'Save unit title'"
            class="fas fa-check fa-sm text-info cursor-pointer ml-2"
            v-else
            @click="saveUnitTitle(singleUnit)"
          ></i>
        </div>
        <draggable :list="singleUnit.questions" disabled="true">
          <transition-group type="transition" name="flip-list">
            <div
              v-for="question in singleUnit.questions"
              :key="question.id"
              class="mx-2 mb-3 p-2 bg-white cursor-pointer question-container"
            >
              <div class="d-flex flex-row items-center">
                <div
                  class="d-flex justify-content-between w-100 align-items-center"
                >
                  <span
                    class="py-1 text-lg font-weight-bold text-primary-light"
                  >
                    Question No {{ question.number }}
                  </span>
                  <i
                    v-b-tooltip.hover="'Click to delete question'"
                    class="fas fa-trash-alt fa-sm text-danger cursor-pointer ml-2"
                    @click="deleteQuestionModal(question)"
                  ></i>
                </div>
              </div>
              <div
                class="flex flex-wrap mx-1 my-2"
                @click="openEditQuestionModal(singleUnit, question)"
              >
                <span class="badge badge-success">
                  {{ question.phrases.length }} phrases
                </span>
                <span class="badge badge-success">
                  {{ question.answers.length }} answers
                </span>
                <span class="badge badge-info" v-if="question.type == 0">
                  practice check
                </span>
                <span class="badge badge-info" v-if="question.type == 1">
                  video review
                </span>
              </div>
            </div>
          </transition-group>
        </draggable>
        <div class="mx-2 mb-2 p-2 shadow cursor-pointer bg-primary text-white d-flex flex-column justify-content-center align-items-center" @click="openAddNewQuestionModal(singleUnit)" v-if="singleUnit.questions.length < 7">
          <span class="fas fa-plus-circle fa-2x"></span>
          <p class="text-3xl mt-2 mb-0 text-white">Add new</p>
        </div>
      </div>
    </div>

    <b-modal
      ref="add_question-modal"
      class="save-question-modal"
      centered
      scrollable
      header-bg-variant="primary"
      size="lg"
      header-class="py-3 d-flex align-items-center"
    >
      <template #modal-header="{ close }">
        <h4 class="text-white mb-0" v-if="isEditActive">
          Edit Question Details
        </h4>
        <h4 class="text-white mb-0" v-else>
          Add Question Phrases with Answers
        </h4>
        <i
          class="fas fa-times-circle fa-lg text-white cursor-pointer"
          @click="close()"
        ></i>
      </template>

      <template slot="default">
        <div v-if="questionEditLoader">
          <p
            class="text-center p-5 d-flex flex-column justify-content-center align-items-center"
          >
            <i class="fa fa-spinner fa-pulse fa-3x text-primary mb-2"></i>
            <span>
              Loading...Please wait
            </span>
          </p>
        </div>
        <div class="row" v-if="!questionEditLoader">
          <!-- <div class="col-lg-12 mb-2 d-flex justify-content-between">
						<label class="font-weight-bold">
							Choose Question Type:
						</label>
						<b-form-radio-group
							v-model="selected_question_type"
							:options="questionTypeList"
							class="d-flex align-items-center"
							value-field="item"
							text-field="name"
						>
						</b-form-radio-group>
					</div> -->
          <div
            class="col-lg-12 mb-2 d-flex justify-content-between align-items-center"
          >
            <label
              for="question_number"
              class="font-weight-bold flex-shrink-0 mr-2 mb-0"
            >
              Question # :
            </label>
            <b-form-select
              id="question_number"
              class="form-control"
              v-model="selectedQuestionNumber"
              :options="questionsNumberList"
            >
              <template #first>
                <b-form-select-option :value="null" disabled>
                  -- Please select question number --
                </b-form-select-option>
              </template>
            </b-form-select>
          </div>
          <div
            class="col-lg-12 mb-2"
            v-if="selected_question_type == 'video_review'"
          >
            <div class="mb-3 row">
              <label for="question_video_url" class="col-sm-2 col-form-label"
                >Add video URL</label
              >
              <div class="col-sm-10">
                <input
                  type="url"
                  id="question_video_url"
                  v-model="question_video_url"
                  class="form-control"
                  placeholder="Enter Vimeo video URL"
                  @input="getVideoWithUrl"
                />
                <small v-show="!isValidUrl" class="text-danger">
                  Please enter a valid video url
                </small>
              </div>
            </div>
            <div v-if="videoLoading" class="text-center p-5">
              <i class="fa fa-spinner fa-pulse fa-3x text-primary"></i>
            </div>
            <div
              v-if="question_video_iframe != ''"
              class="embed-responsive embed-responsive-16by9"
            >
              <div v-html="question_video_iframe"></div>
              <!-- <add-video v-on:videoAdded="getVideoInfo"></add-video> -->
            </div>
          </div>
        </div>

        <div class="accordion" role="tablist" v-if="!questionEditLoader">
          <!-- question phrases accordion -->
          <b-card no-body class="mb-1 shadow">
            <b-card-header header-tag="header" class="p-1" role="tab">
              <b-button block v-b-toggle.phrases_accordion variant="info">
                Question Phrases
              </b-button>
            </b-card-header>
            <b-collapse
              id="phrases_accordion"
              visible
              accordion="question-phrases_answers"
              role="tabpanel"
            >
              <b-card-body>


                <b-card-text>
                  <div
                    class="row my-1"
                    v-for="(input, questionIndex) in questionsList.phrasesList"
                    :key="`questionInput-${questionIndex}`"
                  >
                    <div class="col-lg-10">
                      <label for="">{{ `Phrase  ${questionIndex + 1}` }}</label>
                      <textarea
                        type="text"
                        class="form-control"
                        rows="2"
                        v-model="input.text"
                        :placeholder="`Question Phrase  ${questionIndex + 1}`"
                      />
                      <div class="mb-1 text-right">
                        <p>
                          <strong v-text="wordCount(input.text)"></strong
                          ><span>/135</span>
                        </p>
                      </div>
                    </div>
                    <div class="col-lg-2 text-right">
                      <button
                        class="p-1 btn btn-success rounded-circle"
                        disabled="true"
                        v-if="isEditActive"
                      >
                        <i class="fas fa-pencil-alt cursor-pointer"></i>
                      </button>

                      <button
                        class="p-1 btn btn-info rounded-circle"
                        :disabled="!isPhraseAdded"
                        @click="addNewQuestionPhrase()"
                        v-show="
                          showAddMoreQuestionButton(
                            questionIndex,
                            questionsList.phrasesList
                          )
                        "
                        v-b-tooltip.hover.top="'Click to add new phrase.'"
                      >
                        <i class="fas fa-plus-circle cursor-pointer"></i>
                      </button>

                      <button
                        v-if="!isEditActive"
                        class="p-1 btn btn-danger rounded-circle"
                        v-show="
                          showRemoveQuestionButton(
                            questionIndex,
                            questionsList.phrasesList
                          )
                        "
                        @click="removeQuestionPhrase(questionIndex)"
                        v-b-tooltip.hover.top="'Click to remove phrase.'"
                      >
                        <i class="fas fa-times-circle cursor-pointer"></i>
                      </button>
                    </div>
                  </div>
                </b-card-text>
              </b-card-body>
            </b-collapse>
          </b-card>

          <!-- answers accordion -->
          <b-card no-body class="mb-1 shadow">
            <b-card-header header-tag="header" class="p-1" role="tab">
              <b-button block v-b-toggle.answers-accordion variant="info"
                >Answers</b-button
              >
            </b-card-header>
            <b-collapse
              id="answers-accordion"
              accordion="question-phrases_answers"
              role="tabpanel"
            >
              <b-card-body>
                <b-card-text>
                  <div class="row my-1 mt-0">
                    <div
                      class="col-lg-2 d-flex justify-content-center align-items-center"
                    >
                      <div class="form-group mb-0">
                        Label
                      </div>
                    </div>
                    <div
                      class="col-lg-3 d-flex justify-content-center align-items-center"
                    >
                      <div class="form-group mb-0">
                        Answer
                      </div>
                    </div>
                    <div
                      class="col-lg-5 d-flex justify-content-center align-items-center"
                    >
                      <div class="form-group mb-0">
                        Score
                      </div>
                    </div>
                    <div
                      class="col-lg-2 d-flex justify-content-center align-items-center"
                    ></div>
                  </div>
                  <div
                    class="row my-1 mt-3"
                    v-for="(answer, answerIndex) in questionsList.answersList"
                    :key="`answerInput-${answerIndex}`"
                  >
                    <div
                      class="col-lg-2 d-flex justify-content-center align-items-center"
                    >
                      <div class="form-group mb-0">
                        <input
                          type="text"
                          class="form-control"
                          :placeholder="'Label ' + (answerIndex + 1)"
                          v-model="answer.label"
                        />
                      </div>
                    </div>
                    <div class="col-lg-3">
                      <div class="form-group mb-0">
                        <input
                          type="text"
                          class="form-control"
                          :placeholder="'Answer ' + (answerIndex + 1)"
                          v-model="answer.answer"
                        />
                      </div>
                    </div>
                    <div
                      class="col-lg-5 d-flex justify-content-center align-items-center"
                    >
                      <b-form-radio
                        v-model="answer.score"
                        value="upper"
                        class="video-option-radio mr-3"
                        :id="'upper_score_' + (answerIndex + 1)"
                      >
                        <label :for="'upper_score_' + (answerIndex + 1)">
                          Upper Score
                        </label>
                      </b-form-radio>
                      <b-form-radio
                        v-model="answer.score"
                        value="lower"
                        class="video-option-radio"
                        :id="'lower_score_' + (answerIndex + 1)"
                      >
                        <label :for="'lower_score_' + (answerIndex + 1)">
                          Lower Score
                        </label>
                      </b-form-radio>
                    </div>
                    <div class="col-lg-2 text-right">
                      <button
                        class="p-1 btn btn-success rounded-circle"
                        disabled="true"
                        v-if="isEditActive"
                      >
                        <i class="fas fa-pencil-alt fa-lg cursor-pointer"></i>
                      </button>
                      <button
                        class="p-1 btn btn-info rounded-circle"
                        v-b-tooltip.hover.top="'Click to add new answer.'"
                        v-show="
                          showAddMoreAnswerButton(
                            answerIndex,
                            questionsList.answersList
                          )
                        "
                        @click="addNewAnswer()"
                        :disabled="!isAnswerAdded"
                      >
                        <i class="fas fa-plus-circle fa-lg cursor-pointer"></i>
                      </button>
                      <button
                        v-if="!isEditActive"
                        class="p-1 btn btn-danger rounded-circle"
                        v-show="
                          showRemoveAnswerButton(
                            answerIndex,
                            questionsList.answersList
                          )
                        "
                        @click="removeAnswer(answerIndex)"
                      >
                        <i class="fas fa-times-circle fa-lg cursor-pointer"></i>
                      </button>
                    </div>
                  </div>
                </b-card-text>
              </b-card-body>
            </b-collapse>
          </b-card>
        </div>
      </template>

      <template #modal-footer>
        <div class="row w-100 my-3 justify-content-md-center">
          <div class="col d-flex align-items-center">
            <p class="alert alert-warning mb-0 py-2">
              Please fill all the required fields
              <strong>(<span>{{phrasesCount}}</span> Question Phrases & <span>{{answersCount}}</span> Answers).</strong>
            </p>
          </div>
          <div class="col col-md-auto text-right">
            <div class="text-right" v-if="isEditActive">
              <b-button variant="danger" @click="closeQuestionAnswerModal">
                Close
              </b-button>
              <b-button
                variant="primary"
                @click="updateQuestionAnswer"
                :disabled="!isValidQuestion || isWordLimit"
              >
                <i v-if="btnLoader" class="fa fa-spinner fa-pulse"></i>
                Update
              </b-button>
            </div>
            <div class="text-right w-100" v-else>
              <b-button variant="danger" @click="closeQuestionAnswerModal">
                Cancel
              </b-button>
              <b-button
                variant="primary"
                @click="saveQuestionAnswer"
                :disabled="!isValidQuestion"
              >
                <i v-if="btnLoader" class="fa fa-spinner fa-pulse"></i>
                Save
              </b-button>
            </div>
          </div>
        </div>
        <!-- <div class="w-100 d-flex">
				</div> -->
      </template>
    </b-modal>

    <!-- Unit title and Description Edit Modal -->
    <b-modal
      ref="edit-unit_modal"
      title="Edit Unit Title and Description"
      centered
      hide-footer
    >
      <div class="from-group mb-2">
        <label for="unit_title" class="mb-0">
          Title
        </label>
        <input
          type="text"
          id="unit_title"
          v-model="editUnit.title"
          class="form-control"
          placeholder="title"
        />
      </div>
      <div class="from-group mb-2">
        <label for="unit_description" class="mb-0">
          Description
        </label>
        <input
          type="text"
          id="unit_description"
          v-model="editUnit.description"
          class="form-control"
          placeholder="description"
        />
      </div>
      <div class="text-right w-100">
        <b-button variant="danger" @click="closeUnitModal">
          Cancel
        </b-button>
        <b-button
          variant="primary"
          @click="updateUnitTileAndDescription"
          :disabled="isLoading"
        >
          <i v-if="isLoading" class="fa fa-spinner fa-pulse"></i>
          Update
        </b-button>
      </div>
    </b-modal>

    <!-- Question Delete Modal -->
    <b-modal
      ref="delete-question_modal"
      title="Delete question"
      centered
      hide-footer
    >
      <div class="from-group mb-2">
        <label for="unit_title" class="mb-0">
          Are you sure you want to delete this question?
        </label>
      </div>
      <div class="text-right w-100">
        <b-button variant="danger" @click="closeQuestionDeleteModal">
          Cancel
        </b-button>
        <b-button
          variant="primary"
          @click="deleteQuestion"
          :disabled="isDeleting"
        >
          <i v-if="isDeleting" class="fa fa-spinner fa-pulse"></i>
          Delete
        </b-button>
      </div>
    </b-modal>
  </section>
</template>
<script>
import draggable from "vuedraggable";
import AddVideo from "@/components/AddVideo";

export default {
  name: "kanban-view",
  components: {
    draggable,
    AddVideo,
  },
  data() {
    return {
      isLoading: false,

      editUnit: {
        id: "",
        title: "",
        description: "",
      },
      phrasesCount: 10,
      answersCount: 5,
      selected_question_type: "practice_check",
      questionTypeList: [
        { item: "practice_check", name: "Practice Check Question" },
        { item: "video_review", name: "Video Review Question" },
      ],
      questionsNumberList: [
        { value: 1, text: 1 },
        { value: 2, text: 2 },
        { value: 3, text: 3 },
        { value: 4, text: 4 },
        { value: 5, text: 5 },
        { value: 6, text: 6 },
        { value: 7, text: 7 },
      ],
      selectedQuestionNumber: null,
      selectedQuestionId: null,
      question_video_url: "",
      question_video_iframe: "",
      videoLoading: false,
      selectedUnit: null,
      selectedUnitTitle: "",
      question: "",
      markAnswerAs: "upper",
      isTitleEditActive: false,
      isEditActive: false,
      btnLoader: false,
      unitListWithQuestions: [],
      questionsList: {
        phrasesList: [],
        answersList: [],
      },
      videoApiData: "",
      questionEditLoader: false,
      isDeleting: false,
    };
  },
  computed: {
    wordCount: function() {
      var vm = this;
      return function(text) {
        if (text) {
          return text.split(" ").length;
        }
      };
    },
    isWordLimit() {
      let isWordLimit = true;

      for (var i = 0; i < this.questionsList.phrasesList.length; i++) {
        var count = this.questionsList.phrasesList[i].text.split(" ").length;
        if (count >= 3) {
          isWordLimit = false;
        } else {
          isWordLimit = true;
        }
      }
      return isWordLimit;
    },
    isValidQuestion() {
      let allValidPhrases = false;
      let allValidAnswers = false;

      if (this.questionsList.phrasesList.length == this.phrasesCount) {
        allValidPhrases = true;
        for (var i = 0; i < this.questionsList.phrasesList.length; i++) {
          if (
            this.questionsList.phrasesList[i].text == "" ||
            this.questionsList.phrasesList[i].text == null
          ) {
            allValidPhrases = false;
            break;
          }
        }
      }
      if (this.questionsList.answersList.length == this.answersCount) {
        allValidAnswers = true;
        for (var i = 0; i < this.answersCount; i++) {
          if (
            this.questionsList.answersList[i].answer != null &&
            this.questionsList.answersList[i].answer != "" &&
            this.questionsList.answersList[i].score == null
          ) {
            allValidAnswers = false;
            break;
          }
        }
      }
      return (
        !this.btnLoader &&
        allValidPhrases &&
        allValidAnswers &&
        this.selectedQuestionNumber != null
      );
    },

    isPhraseAdded() {
      for (var i = 0; i < this.phrasesCount; i++) {
        if (
          this.questionsList.phrasesList.length == i + 1 &&
          this.questionsList.phrasesList[i].text != "" &&
          this.questionsList.phrasesList[i].text != null
        ) {
          return true;
        }
      }
      return false;
    },
    isAnswerAdded() {
      for (var i = 0; i < this.answersCount; i++) {
        if (
          this.questionsList.answersList.length == i + 1 &&
          this.questionsList.answersList[i].answer != null &&
          this.questionsList.answersList[i].answer != "" &&
          this.questionsList.answersList[i].score != null
        ) {
          return true;
        }
      }
      return false;
    },
    isValidUrl() {
      var regexp = /^(?:(?:https?|ftp):\/\/)?(?:(?!(?:10|127)(?:\.\d{1,3}){3})(?!(?:169\.254|192\.168)(?:\.\d{1,3}){2})(?!172\.(?:1[6-9]|2\d|3[0-1])(?:\.\d{1,3}){2})(?:[1-9]\d?|1\d\d|2[01]\d|22[0-3])(?:\.(?:1?\d{1,2}|2[0-4]\d|25[0-5])){2}(?:\.(?:[1-9]\d?|1\d\d|2[0-4]\d|25[0-4]))|(?:(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)(?:\.(?:[a-z\u00a1-\uffff0-9]-*)*[a-z\u00a1-\uffff0-9]+)*(?:\.(?:[a-z\u00a1-\uffff]{2,})))(?::\d{2,5})?(?:\/\S*)?$/;

      if (this.question_video_url != "") {
        if (!regexp.test(this.question_video_url)) {
          return false;
        } else {
          return true;
        }
      }
      // return false;
    },
  },
  methods: {
    deleteQuestionModal(question) {
      this.isDeleting = false;
      this.selectedQuestionId = question.id;
      this.$refs["delete-question_modal"].show();
    },

    closeQuestionDeleteModal() {
      this.$refs["delete-question_modal"].hide();
      this.selectedQuestionId = null;
    },

    async deleteQuestion() {
      var self = this;
      self.isDeleting = true;
      await this.$axios
        .$get("/admin/deleteQuestion/" + this.selectedQuestionId)
        .then(function(response) {
          self.getUnitsListWithQuestions();
          self.closeQuestionDeleteModal();
          self.isDeleting = false;
        })
        .catch(function(error) {
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },

    // updateQuestionType(value)
    // {
    // 	console.log(value);
    // },
    showAddMoreQuestionButton(index, dataArray) {
      if (index == dataArray.length - 1) {
        if (dataArray.length == this.phrasesCount) {
          return false;
        }
        return true;
      }
    },
    showAddMoreAnswerButton(index, dataArray) {
      if (index == dataArray.length - 1) {
        if (dataArray.length == this.answersCount) {
          return false;
        }
        return true;
      }
    },
    showRemoveAnswerButton(index, dataArray) {
      if (dataArray.length != 1) {
        return true;
      }
    },
    showRemoveQuestionButton(index, dataArray) {
      if (dataArray.length != 1) {
        return true;
      }
    },
    addNewQuestionPhrase() {
      this.questionsList.phrasesList.push({ text: null });
    },
    removeQuestionPhrase(index) {
      this.questionsList.phrasesList.splice(index, 1);
    },
    addNewAnswer() {
      this.questionsList.answersList.push({
        label: null,
        answer: null,
        score: null,
      });
    },
    removeAnswer(index) {
      this.questionsList.answersList.splice(index, 1);
    },
    async getUnitsListWithQuestions() {
      var self = this;
      await this.$axios
        .$get("/admin/getUnitsListWithQuestions")
        .then(function(response) {
          self.unitListWithQuestions = response;
          for (var i = 0; i < self.unitListWithQuestions.length; i++) {
            self.unitListWithQuestions[i].isTitleEditActive = false;
          }
        })
        .catch(function(error) {
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },
    editUnitTitle(unit, index) {
      this.editUnit.id = unit.id;
      this.editUnit.title = unit.title;
      this.editUnit.description = unit.description;
      this.$refs["edit-unit_modal"].show();

      this.selectedUnit = unit;
      // for (var i = 0; i < this.unitListWithQuestions.length; i++) {
      // 	if (this.unitListWithQuestions[i].id == unit.id) {
      // 		this.unitListWithQuestions[i].isTitleEditActive = true;
      // 		this.selectedUnitTitle = unit.title;
      // 	}
      // }
    },
    closeUnitModal() {
      this.$refs["edit-unit_modal"].hide();
    },
    async updateUnitTileAndDescription() {
      this.isLoading = true;
      var self = this;
      await this.$axios
        .$post("/admin/updateUnitTileAndDescription", this.editUnit)
        .then(function(response) {
          self.$bvToast.toast("Unit updated successfuly.", {
            variant: "success",
            solid: true,
          });
          self.getUnitsListWithQuestions();
          self.closeUnitModal();
          self.isLoading = false;
        })
        .catch(function(error) {
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },
    async saveUnitTitle(unit) {
      let url =
        "admin/updateUnitTitle?unitId=" +
        unit.id +
        "&unitTitle=" +
        this.selectedUnitTitle;
      var self = this;
      await this.$axios
        .$get(url)
        .then(function(response) {
          self.$bvToast.toast("Unit title updated successfuly.", {
            variant: "success",
            solid: true,
          });
          self.selectedUnit = 0;
          for (var i = 0; i < self.unitListWithQuestions.length; i++) {
            if (self.unitListWithQuestions[i].id == unit.id) {
              self.unitListWithQuestions[i].isTitleEditActive = false;
              self.unitListWithQuestions[i].title = response.title;
            }
          }
        })
        .catch(function(error) {
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },
    getVideoInfo(videoObj) {},

    openAddNewQuestionModal(unit) {
      this.questionsList.phrasesList = [];
      this.questionsList.answersList = [];
      this.selectedUnit = unit;
      this.questionsList.phrasesList.push({ text: null });
      this.questionsList.answersList.push({
        label: null,
        answer: null,
        score: null,
      });
      this.selectedQuestionNumber = null;
      this.selectedQuestionId = null;
      this.$refs["add_question-modal"].show();
      this.isEditActive = false;
    },

    closeQuestionAnswerModal() {
      this.$refs["add_question-modal"].hide();
      this.questionsList.phrasesList = [];
      this.questionsList.answersList = [];
      this.selectedUnit = null;
      this.selectedQuestionNumber = null;
      this.selectedQuestionId = null;
    },
    async openEditQuestionModal(unit, question) {
      this.selectedUnit = unit;
      this.isEditActive = true;

      this.questionsList.phrasesList = [];
      this.questionsList.answersList = [];
      this.selectedQuestionNumber = null;
      this.selectedQuestionId = question.id;
      this.$refs["add_question-modal"].show();

      this.questionEditLoader = true;
      let url =
        "admin/getSelectedQuestionDetail?unitId=" +
        this.selectedUnit.id +
        "&questionId=" +
        question.id;
      var self = this;
      await this.$axios
        .get(url)
        .then(function(response) {
          self.questionEditLoader = false;
          self.selectedQuestionNumber = response.data.questionNumber;
          for (var i = 0; i < response.data.phrasesList.length; i++) {
            self.questionsList.phrasesList.push({
              id: response.data.phrasesList[i].id,
              text: response.data.phrasesList[i].phrase,
            });
          }

          for (var i = 0; i < response.data.answersList.length; i++) {
            var tempObj = {};
            tempObj["label"] = response.data.answersList[i].label;
            tempObj["id"] = response.data.answersList[i].id;
            tempObj["answer"] = response.data.answersList[i].answer;
            if (response.data.answersList[i].tag_id == 1) {
              tempObj["score"] = "upper";
            }
            if (response.data.answersList[i].tag_id == 2) {
              tempObj["score"] = "lower";
            }
            self.questionsList.answersList.push(tempObj);
          }
        })
        .catch(function(error) {
          self.questionEditLoader = false;
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },
    async saveQuestionAnswer() {
      let payload = {
        unitId: this.selectedUnit.id,
        questionNumber: this.selectedQuestionNumber,
        phrasesList: this.questionsList.phrasesList,
        answersList: this.questionsList.answersList,
      };

      this.btnLoader = true;
      var self = this;
      await this.$axios
        .post("admin/addUnitQuestionPhrasesAndAnswer", payload)
        .then(function(response) {
          self.$bvToast.toast("Question added successfully.", {
            variant: "success",
            solid: true,
          });
          self.$refs["add_question-modal"].hide();
          self.getUnitsListWithQuestions();
          self.btnLoader = false;
        })
        .catch(function(error) {
          self.btnLoader = false;
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },

    async updateQuestionAnswer() {
      let payload = {
        unitId: this.selectedUnit.id,
        questionId: this.selectedQuestionId,
        questionNumber: this.selectedQuestionNumber,
        phrasesList: this.questionsList.phrasesList,
        answersList: this.questionsList.answersList,
      };

      this.btnLoader = true;
      var self = this;
      await this.$axios
        .post("admin/updateUnitQuestionPhrasesAndAnswer", payload)
        .then(function(response) {
          self.$bvToast.toast("Record updated successfuly.", {
            variant: "success",
            solid: true,
          });
          self.$refs["add_question-modal"].hide();
          self.getUnitsListWithQuestions();
          self.btnLoader = false;
        })
        .catch(function(error) {
          self.btnLoader = false;
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },

    async getVideoApiData() {
      let url = "admin/getVideoApiData";
      var self = this;
      await this.$axios
        .$get(url)
        .then(function(response) {
          // console.log("getVideoApiData response");
          // console.log(response);
          self.videoApiData = response;
        })
        .catch(function(error) {
          self.$bvToast.toast(error, {
            variant: "danger",
            solid: true,
          });
        });
    },
    getVideoWithUrl() {
      var video_id = this.question_video_url.split("/")[3];
      this.videoLoading = true;
      var self = this;

      let Vimeo = require("vimeo").Vimeo;

      let client = new Vimeo(
        this.videoApiData.client_id,
        this.videoApiData.client_secret,
        this.videoApiData.personal_access_token
      );
      client.request(
        {
          method: "GET",
          path: "/videos/" + video_id,
        },
        function(error, body, status_code, headers) {
          if (error) {
            console.log(error);
            self.videoLoading = true;
          } else {
            self.videoLoading = false;
            self.question_video_iframe = body.embed.html;
          }
        }
      );
    },
  },
  mounted() {
    this.getVideoApiData();
    this.getUnitsListWithQuestions();
  },
};
</script>

<style lang="scss">
.video-option-radio .custom-control-label {
  width: 100%;
}
.question-container:hover {
  box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
}
.tooltip-inner {
  color: #ffffff !important;
  background-color: #000000 !important;
}
.bs-tooltip-top .arrow::before {
  border-top-color: #000000 !important;
}
.modal-dialog-scrollable .modal-footer {
  padding-bottom: 0;
  border-top: 2px solid gray;
}
.modal-dialog-scrollable .modal-footer p {
  background-color: #ffc107;
}
</style>
