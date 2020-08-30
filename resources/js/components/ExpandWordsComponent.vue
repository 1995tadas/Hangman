<template>
    <div v-if="!empty">
        <i @click="toggleShowFilter()" class="show-all-link fas"
           :class="showAll?'fa-angle-double-up':'fa-angle-double-down'"></i>
        <div v-for="letter in Object.keys(formattedWords)">
            <template v-if="checkIfShowLetter(letter)">
                <span @click="toggleWords(letter)" class="first-letter">{{ letter }}</span>
                <i class="fas" :class="checkIfShowLetterWords(letter)?'fa-minus':'fa-plus'"></i>
            </template>
            <div v-for="(word,index) in formattedWords[letter]" :key="index">
                <span v-show="checkIfShowLetterWords(letter) && word" class="word">
                    {{ word }}
                    <a class="word-icon" :href="editRoute+'/'+index">
                        <i class="fas fa-pencil-ruler"></i>
                    </a>
                    <a v-show="readyToDelete" @click.prevent="instantiateDeleteModal(index,word)" class="word-icon"
                       href="#">
                        <i class="far fa-trash-alt"></i>
                    </a>
                </span>
            </div>
        </div>
        <div @click.self="closeModal()" v-if="showDeleteModal" ref="modal" class="delete-warning">
            <div class="delete-modal">
                <h1>Delete {{ getSelectedWord.toUpperCase() }}</h1>
                <ul class="delete-confirmation">
                    <li>
                        <a @click.once.prevent="deleteWord(getSelectedWordIndex,getSelectedWord.charAt(0))"
                           href="#">Yes</a>
                    </li>
                    <li>
                        <a @click.prevent="closeModal()" href="#">No</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <div v-else>Empty</div>
</template>
<script>
export default {
    props: {
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
            formattedWords: [],
            showWords: [],
            showAll: true,
            selectedWordForModal: [],
            closeDeleteModal: false,
            readyToDelete: true,
            empty: false
        }
    },
    created() {
        this.formatFilteredArray();
        this.checkIfWordsExist();
    },
    methods: {
        formatFilteredArray() {
            for (const word of this.words) {
                let firstLetter = word.word.charAt(0);
                if (!this.formattedWords[firstLetter]) {
                    this.formattedWords[firstLetter] = [];
                }
                this.formattedWords[firstLetter][word.id] = word.word;
            }
        },
        toggleWords(letter) {
            if (this.showWords.includes(letter)) {
                this.showWords.splice(this.showWords.indexOf(letter), 1)
            } else {
                this.showWords.push(letter)
            }
        },
        checkIfShowLetterWords(letter) {
            if (this.showAll) {
                return !this.showWords.includes(letter)
            }
            return this.showWords.includes(letter)
        },
        checkIfShowLetter(letter) {
            return this.formattedWords[letter].filter(word => word.length).length > 0
        },
        checkIfWordsExist() {
            let size = 0;
            for (const element of Object.keys(this.formattedWords)) {
                if (this.formattedWords[element].filter(Boolean).length > 0) {
                    size++;
                }
            }
            if (size === 0) {
                this.empty = true;
            }
        },
        toggleShowFilter() {
            this.showAll = !this.showAll;
            this.showWords = [];
        },
        instantiateDeleteModal(index, letter) {
            this.selectedWordForModal = [];
            this.openModal();
            Vue.set(this.selectedWordForModal, index, letter)
        },
        deleteWord(index, letter) {
            this.readyToDelete = false;
            axios.delete(this.deleteRoute + '/' + index).then(
                (response) => {
                    if (response.data) {
                        delete this.formattedWords[letter][index];
                        this.checkIfWordsExist();
                        this.closeDeleteModal = true
                    }
                }
            ).catch((error) => {
                console.log(error)
            }).finally(() => {
                    this.readyToDelete = true;
                }
            )
        },
        closeModal() {
            this.closeDeleteModal = true
        },
        openModal() {
            this.closeDeleteModal = false;
        },
    },
    computed: {
        showDeleteModal() {
            return !this.closeDeleteModal && this.selectedWordForModal.length !== 0;
        },
        getSelectedWord() {
            let word = this.selectedWordForModal[this.getSelectedWordIndex];
            if (typeof word !== "undefined") {
                return word;
            }
        },
        getSelectedWordIndex() {
            let index = Object.keys(this.selectedWordForModal)[0];
            if (/^\d+$/.test(index)) {
                return index;
            }
        }
    }
}
</script>
