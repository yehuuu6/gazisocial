<div x-data="{
    deleteCommentModal: false,
    commentId: null,
    deletePostModal: false,
    postId: null,
}">
    <div class="bg-white shadow-md rounded-xl flex flex-col overflow-hidden border border-gray-100">
        <livewire:components.user.details :$user />
        <div class="flex">
            <button wire:click='$dispatch("showUserPosts")' id="user-posts"
                class="active-profile-tab flex-1 py-2 text-center font-medium border-b-2">Gönderiler</button>
            <button wire:click='$dispatch("showUserComments")' id="user-comments"
                class="profile-tab flex-1 py-2 text-center font-medium border-b-2">Yorumlar</button>
        </div>
        <x-seperator />
        <livewire:pages.users.user-sub-page :$user />
    </div>
    @auth
        @if (Auth::user()->id === $user->id)
            <livewire:modals.delete-comment-modal />
            <livewire:modals.delete-post-modal />
        @endif
    @endauth
</div>

@script
    <script>
        const tabs = {
            posts: document.getElementById('user-posts'),
            comments: document.getElementById('user-comments'),
        };

        function updateTabs(activeTab) {
            Object.keys(tabs).forEach(key => {
                const tab = tabs[key];
                tab.classList.remove('active-profile-tab', 'profile-tab');
                tab.classList.add(activeTab === key ? 'active-profile-tab' : 'profile-tab');
            });
        }

        Livewire.on('showUserPosts', () => updateTabs('posts'));
        Livewire.on('showUserComments', () => updateTabs('comments'));
    </script>
@endscript
