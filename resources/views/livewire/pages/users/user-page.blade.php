<div class="bg-white shadow-md rounded-xl flex flex-col overflow-hidden">
    <x-header-title>
        Kullanıcı Profili
    </x-header-title>
    <x-seperator />
    <livewire:components.user.details :$user />
    <div class="flex">
        <button wire:click='$dispatch("showUserPosts")' id="user-posts"
            class="active-profile-tab flex-1 py-2 text-center font-medium border-b-2">Gönderiler</button>
        <button wire:click='$dispatch("showUserComments")' id="user-comments"
            class="flex-1 py-2 text-center font-medium border-b-2">Yorumlar</button>
        <button wire:click='$dispatch("showUserLikes")' id="user-likes"
            class="flex-1 py-2 text-center font-medium border-b-2">Beğeniler</button>
    </div>
    <x-seperator />
    <livewire:pages.users.user-sub-page :$user />
</div>

@script
    <script>
        let userPosts = document.getElementById('user-posts');
        let userComments = document.getElementById('user-comments');
        let userLikes = document.getElementById('user-likes');

        function removeActiveClass() {
            userPosts.classList.remove('active-profile-tab');
            userComments.classList.remove('active-profile-tab');
            userLikes.classList.remove('active-profile-tab');
        }

        function removeProfileTabClass() {
            userPosts.classList.remove('profile-tab');
            userComments.classList.remove('profile-tab');
            userLikes.classList.remove('profile-tab');
        }

        Livewire.on('showUserPosts', () => {
            removeActiveClass();
            removeProfileTabClass();
            userPosts.classList.add('active-profile-tab');
            userComments.classList.add('profile-tab');
            userLikes.classList.add('profile-tab');
        });

        Livewire.on('showUserComments', () => {
            removeActiveClass();
            removeProfileTabClass();
            userComments.classList.add('active-profile-tab');
            userPosts.classList.add('profile-tab');
            userLikes.classList.add('profile-tab');
        });

        Livewire.on('showUserLikes', () => {
            removeActiveClass();
            removeProfileTabClass();
            userLikes.classList.add('active-profile-tab');
            userPosts.classList.add('profile-tab');
            userComments.classList.add('profile-tab');
        });
    </script>
@endscript
