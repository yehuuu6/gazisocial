window.setupNavController = function () {
    return {
        activityOpen: false,
        showActivities() {
            if (this.menuOpen) {
                this.showMenuBar();
            }
            if (this.categoriesOpen) {
                this.showCategories();
            }
            this.activityOpen = !this.activityOpen;
            const activities = document.querySelector(
                "#responsive-user-activities"
            );
            if (this.activityOpen) {
                activities.classList.add("right-0");
                activities.classList.remove("-right-2/3");
            } else {
                activities.classList.remove("right-0");
                activities.classList.add("-right-2/3");
            }
        },
        categoriesOpen: false,
        showCategories() {
            if (this.menuOpen) {
                this.showMenuBar();
            }
            if (this.activityOpen) {
                this.showActivities();
            }
            this.categoriesOpen = !this.categoriesOpen;
            const categories = document.querySelector("#responsive-categories");
            if (this.categoriesOpen) {
                categories.classList.add("right-0");
                categories.classList.remove("-right-2/3");
            } else {
                categories.classList.remove("right-0");
                categories.classList.add("-right-2/3");
            }
        },
        menuOpen: false,
        showMenuBar() {
            if (this.categoriesOpen) {
                this.showCategories();
            }
            if (this.activityOpen) {
                this.showActivities();
            }
            this.menuOpen = !this.menuOpen;
            const menu = document.querySelector("#responsive-menu");
            if (this.menuOpen) {
                menu.classList.add("right-0");
                menu.classList.remove("-right-2/3");
            } else {
                menu.classList.remove("right-0");
                menu.classList.add("-right-2/3");
            }
        },
    };
};
