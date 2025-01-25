import { Alpine } from "../../vendor/livewire/livewire/dist/livewire.esm";

Alpine.data("tagsLister", (tags, count) => {
    return {
        loadedTags: tags,
        tagsDropdown: false,
        search: "",
        foundTagCount: count,
        displayText: "Etiketler",
        init() {
            // Set the selected tag if the page is loaded with a tag slug in the URL
            const url = window.location.pathname;
            const tagSlug = url.split("/")[url.split("/").length - 1];
            this.updateSelectedTag(tagSlug, false);
            document.addEventListener("livewire:navigated", () => {
                this.detectIfNotTagsPage();
            });
            window.addEventListener("popstate", () => {
                this.detectIfNotTagsPage();
            });
        },
        detectIfNotTagsPage() {
            // If the pathname does not start with /tags/ then clear the selected tag
            if (!window.location.pathname.startsWith("/tags/")) {
                this.displayText = "Etiketler";
                this.resetSearchResults();
                this.removeIndicatorClass();
            } else {
                const tagSlug = window.location.pathname.split("/")[2];
                this.updateSelectedTag(tagSlug, false);
            }
        },
        removeIndicatorClass() {
            const tagsButton = document.getElementById("tags-button");
            tagsButton.classList.remove("border-l-4");
            tagsButton.classList.forEach((className) => {
                if (
                    className.startsWith("border-") &&
                    className.endsWith("-500")
                ) {
                    tagsButton.classList.remove(className);
                }
            });
        },
        updateSelectedTag(givenSlug, redirect = true) {
            this.tagsDropdown = false;
            const tag = this.loadedTags.find((tag) => tag.slug === givenSlug);
            if (!tag) return;
            this.displayText = tag.name;
            this.resetSearchResults();

            // Add class to the tags-button
            const tagsButton = document.getElementById("tags-button");
            this.removeIndicatorClass();
            tagsButton.classList.add("border-l-4");
            tagsButton.classList.add(`border-${tag.color}-500`);

            // Redirect to the tag page using livewire navigation
            if (redirect) {
                Livewire.navigate(`/tags/${tag.slug}`);
            }
        },
        searchTags() {
            const tags = this.$refs.tagsLister.querySelectorAll("button");
            let count = 0;
            tags.forEach((tag) => {
                let condition1 = tag.dataset.searchKey
                    .toLowerCase()
                    .includes(this.search.toLowerCase());
                let condition2 = tag.innerText
                    .toLowerCase()
                    .includes(this.search.toLowerCase());
                if (condition1 || condition2) {
                    count++;
                    tag.classList.remove("hidden");
                } else {
                    tag.classList.add("hidden");
                }
            });

            this.foundTagCount = count;
        },
        resetSearchResults() {
            this.search = "";
            this.foundTagCount = this.loadedTags.length;
            this.$refs.tagsLister.querySelectorAll("button").forEach((tag) => {
                tag.classList.remove("hidden");
            });
        },
    };
});
