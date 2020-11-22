<template>
    <div class="play-center">
        <div>
            <div class="hangman-board">
                <canvas id="hangman-canvas"></canvas>
            </div>
            <div v-show="!loser && !winner" class="play-grid">
                <div v-for="n in letterCount" class="play-cell">
                    <template v-if="letterIsGuessed(letters[n-1])">
                        {{ letters[n - 1] }}
                    </template>
                </div>
            </div>
            <div class="input-block">
                <template v-if="!loser && !winner">
                    <input type="text" class="input-cell" maxlength="1" autofocus required
                           :pattern="letterRegex" v-model="letter" @keydown.enter="guess">
                    <input type="button" class="game-button" value="Spėk!" @click.prevent="guess"
                           :disabled="letter === ''">
                </template>
                <div class="result" v-else>
                    <span v-if="loser">Pralaimėjai!</span>
                    <span v-if="winner">Laimėjai!</span>
                    <span>Teisingas žodis buvo
                        <span class="correct-answer">
                            <template v-for="letter in letters">{{ letter }}</template>
                        </span>
                    </span>
                    <a href="">
                        <button class="replay-btn">Iš naujo!</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="guessed-letters">
            <span class="guessed-notation">Spėjimai:</span>
            <ul>
                <li class="guessed-letters-placeholder">|</li>
                <li v-for="n in guessedLetters">{{ n }}</li>
            </ul>
        </div>
    </div>
</template>
<script>
export default {
    props: {
        letters: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            letter: '',
            letterCount: this.letters.length,
            guessedLetters: [],
            loser: false,
            winner: false,
            letterRegex: '^[A-Za-zĄąČčĘęĖėĮįŠšŲųŪūŽž]$'
        }
    },
    mounted() {
        this.paintHangman();
    },
    methods: {
        guess() {
            let letter = this.addLetter();
            if (letter) {
                let wrongGuesses = this.guessedLetters.filter(x => !this.letters.includes(x)).length;
                this.paintHangman(wrongGuesses);
            }
        },
        loss() {
            this.loser = true;
        },
        won() {
            let uniqueLetters = [];
            for (let i = 0; i < this.letterCount; i++) {
                if (!uniqueLetters.includes(this.letters[i])) {
                    uniqueLetters.push(this.letters[i])
                }
            }
            this.winner = this.guessedLetters.filter(x => this.letters.includes(x)).length === uniqueLetters.length;
        },
        validateLetter() {
            this.letter = this.letter.toLowerCase();
            let regex = new RegExp(this.letterRegex);
            return regex.test(this.letter) && !this.letterIsGuessed(this.letter);
        },
        addLetter() {
            if (this.validateLetter()) {
                this.guessedLetters.push(this.letter[0]);
                this.letter = '';
                this.won();
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
