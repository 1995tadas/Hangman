<template>
    <div class="play-center">
        <div>
            <div class="hangman-board">
                <canvas id="hangman-canvas"
                        :title="translation.left_lives[0] +' '+countLives(lives)+' '+ translation.left_lives[1]">
                </canvas>
            </div>
            <div v-show="end === null" class="play-grid">
                <div v-for="n in letterCount" class="play-cell">
                    <template v-if="letterIsGuessed(letters[n-1])">
                        {{ letters[n - 1] }}
                    </template>
                </div>
            </div>
            <div class="input-block">
                <template v-if="end === null">
                    <input type="text" class="input-cell" maxlength="1" autofocus required
                           :pattern="letterRegex" v-model="letter">
                </template>
                <div class="result" v-else>
                    <span v-if="end === true">{{ translation.won }}!</span>
                    <span v-if="end === false">{{ translation.lost }}!</span>
                    <span>
                        {{ translation.correct_word }}
                        <span class="correct-answer">
                            <template v-for="letter in letters">{{ letter }}</template>
                        </span>
                    </span>
                    <a href="">
                        <button class="replay-button">{{ translation.replay }}!</button>
                    </a>
                </div>
            </div>
        </div>
        <div v-show="guessedLetters.length" class="guessed-letters">
            <span class="guessed-notation">{{ translation.guessed_letters }}:</span>
            <ul>
                <li v-for="n in guessedLetters">{{ n }}</li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        translation: {
            type: Object,
            required: true
        },
        word: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            letters: [],
            letter: '',
            letterCount: this.word.length,
            guessedLetters: [],
            lives: 6,
            end: null,
            letterRegex: '^[A-Za-zĄąČčĘęĖėĮįŠšŲųŪūŽž]$'
        }
    },
    mounted() {
        this.letters = this.splitWord(this.word);
        this.paintHangman();
    },
    watch: {
        /*
         If letter is correct will add it to guessed letters array
         Then will count lives and paint hangman on canvas
        */
        letter: function () {
            let validatedAndAdded = this.addLetter();
            if (validatedAndAdded) {
                let lives = this.countLives(this.lives)
                this.paintHangman(lives);
            }
        }
    },
    methods: {

        /*
            Limits letters length to single character
        */
        limitLetterLength() {
            this.letter = this.letter.slice(0, 1);
        },

        /*
            Splits string and return string letter array
        */
        splitWord(word) {
            if (typeof word === 'string') {
                return word.split('')
            }

            return false;
        },

        /*
        Count how many lives are left
        */
        countLives(lives) {
            let wrongGuesses = this.guessedLetters.filter(x => !this.letters.includes(x)).length;
            return lives -= wrongGuesses
        },

        /*
            Ends game and sets status as lost
        */
        loss() {
            this.end = false;
        },

        /*
            Checks if all word letters have been guessed
            If yes ends game and sets status as lost
        */
        won() {
            let uniqueLetters = [];
            for (let i = 0; i < this.letterCount; i++) {
                if (!uniqueLetters.includes(this.letters[i])) {
                    uniqueLetters.push(this.letters[i])
                }
            }
            let won = this.guessedLetters.filter(x => this.letters.includes(x)).length === uniqueLetters.length;
            if (won) {
                this.end = won;
            }
        },

        /*
            Validates input letter and checks if it was already guesses
        */
        validateLetter() {
            this.letter = this.letter.toLowerCase();
            let regex = new RegExp(this.letterRegex);
            return regex.test(this.letter) && !this.letterIsGuessed(this.letter);
        },

        /*
            Pushes letter to already guessed letter array
        */
        addLetter() {
            if (this.validateLetter()) {
                this.guessedLetters.push(this.letter[0]);
                this.letter = '';
                this.won();
                return true;
            }

            return false;
        },

        /*
            Check if letter is already guesses
        */
        letterIsGuessed(letter) {
            return this.guessedLetters.includes(letter)
        },

        /*
            Paints hangman on canvas, have six stages/lives
        */
        paintHangman(lives = this.lives) {
            const canvas = document.getElementById('hangman-canvas');
            const ctx = canvas.getContext('2d');
            let x = 60;
            let y = 140;
            ctx.strokeStyle = '#fff';
            ctx.lineWidth = 3;
            ctx.moveTo(x, y);
            ctx.lineTo(x += 100, y);
            ctx.moveTo(x -= 50, y);
            ctx.lineTo(x, y -= 110);
            ctx.lineTo(x += 130, y);
            ctx.lineTo(x, y += 20);
            if (lives < 6) {
                ctx.arc(x, y += 10, 10, 1.5 * Math.PI, 3.5 * Math.PI);
                if (lives < 5) {
                    ctx.moveTo(x, y += 10);
                    ctx.lineTo(x, y += 40);
                    if (lives < 4) {
                        ctx.moveTo(x, y -= 32)
                        ctx.lineTo(x -= 30, y -= 13);
                        if (lives < 3) {
                            ctx.moveTo(x += 30, y += 13);
                            ctx.lineTo(x += 30, y -= 13);
                            if (lives < 2) {
                                ctx.moveTo(x -= 30, y += 44);
                                ctx.lineTo(x -= 20, y += 26);
                                if (lives < 1) {
                                    ctx.moveTo(x += 20, y -= 26);
                                    ctx.lineTo(x += 20, y += 26);
                                    this.loss();
                                }
                            }
                        }
                    }
                }
            }

            ctx.stroke();
        }
    }
}
</script>
