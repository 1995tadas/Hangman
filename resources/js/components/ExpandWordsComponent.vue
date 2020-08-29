<template>
    <div>
        <i @click="toggleShowAll()" class="show-all-link fas"
           :class="showAll?'fa-angle-double-up':'fa-angle-double-down'"></i>
        <div v-for="letter in Object.keys(formattedWords)">
            <span @click="toggleWords(letter)" class="first-letter">{{ letter }}</span>
            <i class="fas" :class="checkIfShow(letter)?'fa-minus':'fa-plus'"></i>
            <div v-for="(word,index) in formattedWords[letter]" :key="index">
                <span v-show="checkIfShow(letter) && word" class="word">
                    {{ word }}
                    <a class="edit-icon" :href="editRoute+'/'+index">
                        <i class="fas fa-pencil-ruler"></i>
                    </a>
                </span>
            </div>
        </div>
    </div>
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
        }
    },
    data() {
        return {
            formattedWords: [],
            showWords: [],
            showAll: true
        }
    },
    created() {
        this.formatFilteredArray();
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
        checkIfShow(letter) {
            if (this.showAll) {
                return !this.showWords.includes(letter)
            }
            return this.showWords.includes(letter)
        },
        toggleShowAll() {
            this.showAll = !this.showAll;
            this.showWords = [];
        }
    }
}
</script>
