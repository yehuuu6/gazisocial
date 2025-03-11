<div class="text-gray-700 text-sm md:text-lg lg:text-xl font-medium font-mono" x-data="{
    startTime: null,
    endTime: null,
    isStarted: null,
    countdownText: '0:15',
    timerInterval: null,
    init() {
        this.setProps();
        this.setInitialCountdownText();
        this.startCountdown();
    },
    setProps() {
        this.startTime = $wire.startTime;
        this.endTime = $wire.endTime;
        this.isStarted = $wire.isStarted;
    },
    setInitialCountdownText() {
        if (!this.isStarted) {
            this.countdownText = '0:15';
            return;
        }
        let now = new Date().getTime();
        let endDate = new Date(this.endTime);
        let distance = endDate - now;
        this.countdownText = this.formatCountdown(distance);
    },
    formatCountdown(distance) {
        if (distance < 0) return '0:00';
        let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        let seconds = Math.floor((distance % (1000 * 60)) / 1000);
        return `${minutes}:${seconds < 10 ? '0' + seconds : seconds}`;
    },
    updateCountdown() {
        let now = new Date().getTime();
        let endDate = new Date(this.endTime);
        let distance = endDate - now;

        if (distance < 0) {
            this.countdownText = '0:00';
            $wire.$parent.call('goToNextGameState');
            this.stopCountdown();
            return;
        }

        this.countdownText = this.formatCountdown(distance);
        requestAnimationFrame(() => this.updateCountdown());
    },
    startCountdown() {
        if (!this.isStarted) return;
        this.stopCountdown(); // Ensure previous interval is cleared
        requestAnimationFrame(() => this.updateCountdown());
    },
    stopCountdown() {
        if (this.timerInterval) {
            clearInterval(this.timerInterval);
            this.timerInterval = null;
        }
    },
}"
    x-on:game-state-updated.window="init();" x-text="countdownText">
</div>
