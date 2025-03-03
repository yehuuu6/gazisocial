import { Alpine } from "../../vendor/livewire/livewire/dist/livewire.esm";

Alpine.data("pollContainer", ($wire) => {
    return {
        allPolls: [], // Array to store all poll ELEMENTS
        draftPolls: [], // Array to store all draft poll IDs
        activePolls: $wire.entangle("selectedPolls"),
        init() {
            // Set all polls by collecting the elements with the data-poll attribute
            this.allPolls = Array.from(
                document.querySelectorAll("[data-poll]")
            ).map((poll) => poll);
        },
        inserIntoPolls(pollElement, isDraft) {
            // Insert given poll element into the allPolls array if not already exists
            if (!this.allPolls.includes(pollElement)) {
                this.allPolls.push(pollElement);
            }

            // If the poll is draft, push it to draftPolls array
            if (isDraft) {
                if (!this.draftPolls.includes(pollElement.dataset.poll)) {
                    this.draftPolls.push(pollElement.dataset.poll);
                }
            } else {
                // If the poll is active, push it to activePolls array
                if (!this.activePolls.includes(pollElement.dataset.poll)) {
                    this.activePolls.push(pollElement.dataset.poll);
                }
            }
        },
        placePollOnCanvas(poll, isDraft) {
            const activePollsContainer = this.$refs.activePollsContainer;
            const draftPollsContainer = this.$refs.draftPollsContainer;

            const activeRect = activePollsContainer.getBoundingClientRect();
            const draftRect = draftPollsContainer.getBoundingClientRect();

            // Calculate the available width for each section
            const activeWidth = activeRect.width;
            const draftWidth = draftRect.width;

            // Calculate the available height for each section
            const activeHeight = activeRect.height;
            const draftHeight = draftRect.height;

            // Calculate random position within the appropriate section
            if (!isDraft) {
                const randomX =
                    Math.random() * (activeWidth - poll.offsetWidth);
                const randomY =
                    Math.random() * (activeHeight - poll.offsetHeight);
                poll.style.left = `${randomX}px`;
                poll.style.top = `${randomY}px`;
            } else {
                const randomX =
                    Math.random() * (draftWidth - poll.offsetWidth) +
                    activeWidth;
                const randomY =
                    Math.random() * (draftHeight - poll.offsetHeight);
                poll.style.left = `${randomX}px`;
                poll.style.top = `${randomY}px`;
            }
        },
    };
});

Alpine.data("pollCreator", (isDraft) => {
    return {
        newX: 0,
        newY: 0,
        startX: 0,
        startY: 0,
        isDragging: false,
        isDraft: isDraft,
        pollTitleText: isDraft ? "Taslak" : "Seçildi",
        init() {
            this.$watch("isDraft", (value) => {
                this.pollTitleText = value ? "Taslak" : "Seçildi";
            });
            this.inserIntoPolls(this.$el, isDraft);
            this.placePollOnCanvas(this.$el, isDraft);
        },
        arrangeDivs() {
            this.allPolls.forEach((poll) => {
                poll.style.zIndex = 0;
            });
            this.$el.style.zIndex = 1;
        },
        mouseDown(e) {
            if (this.isDragging) return;
            this.startX = e.pageX;
            this.startY = e.pageY;
            this.isDragging = true;
            this.arrangeDivs(e.target.dataset.poll);
        },
        mouseMove(e) {
            if (!this.isDragging) return;
            this.newX = this.startX - e.pageX;
            this.newY = this.startY - e.pageY;

            this.startX = e.pageX;
            this.startY = e.pageY;

            this.$el.style.top = this.$el.offsetTop - this.newY + "px";
            this.$el.style.left = this.$el.offsetLeft - this.newX + "px";

            const draftRect =
                this.$refs.draftPollsContainer.getBoundingClientRect();
            const activeRect =
                this.$refs.activePollsContainer.getBoundingClientRect();
            const pollRect = this.$el.getBoundingClientRect();

            if (this.isInside(pollRect, activeRect)) {
                this.isDraft = false; // Mark as active
                this.$refs.draftPollsContainer.style.backgroundColor = "";
                this.$refs.activePollsContainer.style.backgroundColor =
                    "#d1fae5"; // Light green highlight
            } else if (this.isInside(pollRect, draftRect)) {
                this.isDraft = true; // Mark as draft
                this.$refs.activePollsContainer.style.backgroundColor = "";
                this.$refs.draftPollsContainer.style.backgroundColor =
                    "#fef3c7"; // Light yellow highlight
            } else {
                this.isDraft = false; // Not inside any section
                this.$refs.activePollsContainer.style.backgroundColor = "";
                this.$refs.draftPollsContainer.style.backgroundColor = "";
            }
        },

        pushToActiveArray(pollId) {
            // If not already in the array
            if (!this.activePolls.includes(pollId)) {
                this.activePolls.push(pollId);
            }

            // Remove from draftPolls array if exists
            if (this.draftPolls.includes(pollId)) {
                this.draftPolls.splice(this.draftPolls.indexOf(pollId), 1);
            }
        },

        pushToDraftArray(pollId) {
            // If not already in the array
            if (!this.draftPolls.includes(pollId)) {
                this.draftPolls.push(pollId);
            }

            // Remove from activePolls array if exists
            if (this.activePolls.includes(pollId)) {
                this.activePolls.splice(this.activePolls.indexOf(pollId), 1);
            }
        },

        setPollActive(pollId) {
            if (this.activePolls.includes(pollId)) return;
            this.pushToActiveArray(pollId);
        },

        setPollDraft(pollId) {
            if (this.draftPolls.includes(pollId)) return;
            this.pushToDraftArray(pollId);
        },

        mouseUp() {
            this.isDragging = false;

            if (!this.isDraft) {
                this.setPollActive(this.$el.dataset.poll);
            } else if (this.isDraft) {
                this.setPollDraft(this.$el.dataset.poll);
            }

            // Clear background colors
            this.$refs.activePollsContainer.style.backgroundColor = "";
            this.$refs.draftPollsContainer.style.backgroundColor = "";
        },
        isInside(pollRect, containerRect) {
            return (
                pollRect.right > containerRect.left &&
                pollRect.left < containerRect.right &&
                pollRect.bottom > containerRect.top &&
                pollRect.top < containerRect.bottom
            );
        },
    };
});
