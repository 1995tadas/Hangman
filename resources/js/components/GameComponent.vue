<template>
    <div class="play-center">
        <div>
            <div class="play-grid" :style="{'grid-template-columns':'repeat('+wordLength+', 1fr)'}">
                <div v-for="n in wordLength" class="play-cell">
                    <template v-if="guessedLetters.includes(word[n-1])">
                        {{ word[n - 1] }}
                    </template>
                </div>
            </div>
            <div class="input-block">
                <input type="text" class="input-cell" maxlength="1" v-model="letter" autofocus
                       @keydown.enter="addLetter">
                <input type="button" class="game-button" value="Guess" @click.prevent="addLetter"
                       :disabled="letter === ''">
            </div>
        </div>
        <ul class="guessed-letters">
            <li class="letter-placeholder">|</li>
            <li v-for="n in guessedLetters">{{ n }}</li>
        </ul>
    </div>
</template>
<script>
export default {
    props: {
        word: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            letter: '',
            wordLength: this.word.length,
            guessedLetters: []
        }
    },
    created() {
        console.log(this.word);
    },
    methods: {
        addLetter() {
            if (this.letter && !this.guessedLetters.includes(this.letter)) {
                this.guessedLetters.push(this.letter[0]);
                this.letter = '';
            }
            console.log(this.guessedLetters);
        }
    }
}
</script>
