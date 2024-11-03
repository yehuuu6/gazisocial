<div x-data="{
    deleteCommentModal: false,
    commentId: null,
    deletePostModal: false,
    postId: null,
}">
    <div class="flex flex-col overflow-hidden rounded-xl border border-gray-100 bg-white shadow-md">
        <livewire:components.user.details :$user />
        <div class="flex">
            <button wire:click='$dispatch("showUserPosts")' id="user-posts"
                class="active-profile-tab flex-1 border-b-2 py-2 text-center font-medium">Gönderiler</button>
            <button wire:click='$dispatch("showUserComments")' id="user-comments"
                class="profile-tab flex-1 border-b-2 py-2 text-center font-medium">Yorumlar</button>
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
