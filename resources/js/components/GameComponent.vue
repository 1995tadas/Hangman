<template>
    <div class="play-center">
        <div>
            <div class="hangman-board">
                <canvas id="hangman-canvas"></canvas>
            </div>
            <div class="play-grid">
                <div v-for="n in wordLength" class="play-cell">
                    <template v-if="letterIsGuessed(word[n-1])">
                        {{ word[n - 1] }}
                    </template>
                </div>
            </div>
            <div class="input-block">
                <input type="text" class="input-cell" maxlength="1" v-model="letter" autofocus
                       @keydown.enter="guess">
                <input type="button" class="game-button" value="Guess" @click.prevent="guess"
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
    mounted() {
        this.paintHangman();
    },
    methods: {
        guess() {
            let letter = this.addLetter();
            if (letter) {
                let wrongGuesses = this.guessedLetters.filter(x => !this.word.includes(x)).length;
                this.paintHangman(wrongGuesses);
            }
        },
        addLetter() {
            if (this.letter && !this.letterIsGuessed(this.letter)) {
                this.guessedLetters.push(this.letter[0]);
                this.letter = '';
                return true;
            }

            return false;
        },
        letterIsGuessed(letter) {
            return this.guessedLetters.includes(letter)
        },
        paintHangman(wrong = 0) {
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
            if (wrong >= 1) {
                ctx.arc(x, y += 10, 10, 1.5 * Math.PI, 3.5 * Math.PI);
                if (wrong >= 2) {
                    ctx.moveTo(x, y += 10);
                    ctx.lineTo(x, y += 40);
                    if (wrong >= 3) {
                        ctx.moveTo(x, y -= 32)
                        ctx.lineTo(x -= 30, y -= 13);
                        if (wrong >= 4) {
                            ctx.moveTo(x += 30, y += 13);
                            ctx.lineTo(x += 30, y -= 13);
                            if (wrong >= 5) {
                                ctx.moveTo(x -= 30, y += 44);
                                ctx.lineTo(x -= 20, y += 26);
                                if (wrong >= 6) {
                                    ctx.moveTo(x += 20, y -= 26);
                                    ctx.lineTo(x += 20, y += 26);
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
