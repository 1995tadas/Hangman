<template>
    <div v-if="!empty">
        <i @click="toggleAllGuides()" class="show-all-link fas"
           :title="(IsGuidesDisabled?translation.collapse:translation.expand) +' '+ translation.all"
           :class="IsGuidesDisabled?'fa-angle-double-up':'fa-angle-double-down'"></i>
        <div v-for="firstLetter in Object.keys(groupedWords)">
            <template v-if="checkIfArrayNotEmpty(groupedWords[firstLetter])">
                <span @click="toggleGuide(firstLetter)"
                      :title="(checkIfGuideIsCollapsed(firstLetter)?translation.collapse:translation.expand) + ' '+ firstLetter.toUpperCase()"
                      class="first-letter">
                    {{ firstLetter }}
                </span>
                <i class="fas" :class="checkIfGuideIsCollapsed(firstLetter)?'fa-minus':'fa-plus'"></i>
            </template>
            <div v-for="(word, wordIndex) in groupedWords[firstLetter]" :key="wordIndex">
                <span v-show="checkIfGuideIsCollapsed(firstLetter) && word" class="word">
                    {{ word }}
                    <a class="word-icon" :title="translation.edit" :href="editRoute+'/'+wordIndex">
                        <i class="fas fa-pencil-ruler"></i>
                    </a>
                    <a class="word-icon" :title="translation.delete" href="#"
                       v-show="readyToDelete" @click.prevent="instantiateDeleteModal(wordIndex, word)">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </span>
            </div>
        </div>
        <div @click.self="closeDeleteModal()" v-if="showDeleteModal" class="delete-warning">
            <div class="delete-modal" ref="deleteModal" :style="{'margin-left': '-'+ deleteModalWidth/2 + 'px'}">
                <h1>{{ translation.delete + ' ' + getWordForDeletion.toUpperCase() }}</h1>
                <ul class="delete-confirmation">
                    <li @click.once.prevent="deleteWord(getWordForDeletionIndex, getFirstLetter(getWordForDeletion))">
                        <a href="#">{{ translation.yes }}</a>
                    </li>
                    <li @click.prevent="closeDeleteModal()">
                        <a href="#">{{ translation.no }}</a>
                    </li>
                </ul>
                <div class="delete-error" v-show="deleteError">
                    Error: {{ deleteError }}
                </div>
            </div>
        </div>
    </div>
    <div v-else>{{ translation.empty }}</div>
</template>
<script>
export default {
    props: {
        translation: {
            type: Object,
            required: true
        },
        words: {
            type: Array,
            required: true
        },
        editRoute: {
            type: String,
            required: true
        },
        deleteRoute: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            groupedWords: [],
            collapsedGuides: [],
            IsGuidesDisabled: false,
            selectedWordToDelete: [],
            deleteModalStatus: false,
            readyToDelete: true,
            empty: false,
            deleteModalWidth: 400,
            deleteError: ''
        }
    },
    created() {
        this.groupWordsByAlphabet();
    },
    methods: {

        /*
            Creates array where every word is grouped by first letter alphabetically
        */
        groupWordsByAlphabet() {
            for (const word of this.words) {
                let firstLetter = this.getFirstLetter(word.word);
                if (!this.groupedWords[firstLetter]) {
                    this.groupedWords[firstLetter] = [];
                }

                this.groupedWords[firstLetter][word.id] = word.word;
            }
        },

        /*
          Keeps track of every collapsed letter guide by pushing letter into array
        */
        toggleGuide(letter) {
            if (this.collapsedGuides.includes(letter)) {
                this.collapsedGuides.splice(this.collapsedGuides.indexOf(letter), 1)
            } else {
                this.collapsedGuides.push(letter)
            }
        },

        /*
            toggles collapsion of all letter guides
        */
        toggleAllGuides() {
            this.IsGuidesDisabled = !this.IsGuidesDisabled;
            this.collapsedGuides = [];
        },

        /*
          Checks if guide is inside collapsed array
        */
        checkIfGuideIsCollapsed(letter) {
            if (this.IsGuidesDisabled) {
                return !this.collapsedGuides.includes(letter)
            }

            return this.collapsedGuides.includes(letter)
        },

        /*
            Check if passed array has items inside
        */
        checkIfArrayNotEmpty(array) {
            return array.filter(word => word.length).length > 0
        },

        /*
            Sets this.empty variable to true if there is no words left
         */
        checkIfAllWordsBeenDeleted() {
            let exists = false;
            for (const singleGroup of Object.keys(this.groupedWords)) {
                if (this.groupedWords[singleGroup].filter(Boolean).length > 0) {
                    exists = true;
                }
            }

            this.empty = !exists;
        },

        /*
           Returns first string letter
        */
        getFirstLetter(word) {
            if (typeof (word) === 'string') {
                return word.charAt(0);
            }

            return false;
        },

        // delete Modal methods

        /*
            Select word for deletion and calls method to open delete modal
        */
        instantiateDeleteModal(index, letter) {
            this.selectedWordToDelete = [];
            Vue.set(this.selectedWordToDelete, index, letter),
                this.openDeleteModal();
        },

        /*
            Deletes selected word
        */
        deleteWord(index, letter) {
            this.readyToDelete = false;
            let config = {
                headers: {
                    "Accept": "application/json"
                }
            };
            axios.delete(this.deleteRoute + '/' + index, config).then(
                (response) => {
                    if (response.data) {
                        delete this.groupedWords[letter][index];
                        this.checkIfAllWordsBeenDeleted();
                        this.closeDeleteModal();
                    }
                }
            ).catch((error) => {
                this.deleteError = error.response.statusText;
            }).finally(() => {
                    this.readyToDelete = true;
                }
            )
        },

        /*
           Opens delete modal and adds scrolling limitation
        */
        openDeleteModal() {
            document.body.classList.add("no-scroll");
            this.deleteModalStatus = false;
            this.getDeleteModalWidth();
        },

        /*
            Closes delete modal and removes scrolling limitation
        */
        closeDeleteModal() {
            document.body.classList.remove("no-scroll");
            this.deleteModalStatus = true
        },

        /*
            Gets delete modal width for positioning
         */
        getDeleteModalWidth() {
            this.$nextTick(() => {
                this.deleteModalWidth = this.$refs.deleteModal.getBoundingClientRect().width;
            });
        }
    },
    computed: {

        /*
            Returns boolean if delete module can be shown
        */
        showDeleteModal() {
            return !this.deleteModalStatus && this.selectedWordToDelete.length !== 0;
        },

        /*
            Return word that is ready to be deleted
        */
        getWordForDeletion() {
            let word = this.selectedWordToDelete[this.getWordForDeletionIndex];
            if (typeof word !== "undefined") {
                return word;
            }
        },

        /*
            Return word index that is ready to be deleted
        */
        getWordForDeletionIndex() {
            let index = Object.keys(this.selectedWordToDelete)[0];
            if (/^\d+$/.test(index)) {
                return index;
            }
        }
    }
}
</script>
