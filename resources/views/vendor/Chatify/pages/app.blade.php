@include('Chatify::layouts.headLinks')
<div class="messenger">
    {{-- ----------------------Users/Groups lists side---------------------- --}}
    <div class="messenger-listView {{ !!$id ? 'conversation-active' : '' }}">
        {{-- Header and search bar --}}
        <div class="m-header">
            <nav>
                <a style="display: flex;align-items: center; justify-content: space-between;"
                    href="{{ auth()->user()->role == 'admin' ? '/dashboard' : '/' }}"><img
                        src="{{ asset('bundle1/assets/images/spirit.png') }}" style="height: 30px;" alt=""><span
                        class="messenger-headTitle">Welcome <span>{{ auth()->user()->name }}</span></span></a>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    {{-- <a href="#"><i class="fas fa-cog settings-btn"></i></a> --}}
                    <a href="#" class="listView-x"><i class="fas fa-times"></i></a>
                </nav>
            </nav>
            {{-- Search input --}}
            {{-- @if (auth()->user()->role == 'admin') --}}
            <input type="text" class="messenger-search" placeholder="Search" />
            {{-- @endif --}}

            {{-- Tabs --}}
            {{-- <div class="messenger-listView-tabs">
                <a href="#" class="active-tab" data-view="users">
                    <span class="far fa-user"></span> Contacts</a>
            </div> --}}
        </div>
        {{-- tabs and lists --}}
        <div class="m-body contacts-container">
            {{-- Lists [Users/Group] --}}
            {{-- ---------------- [ User Tab ] ---------------- --}}
            <div class="show messenger-tab users-tab app-scroll" data-view="users">
                {{-- Favorites --}}
                <div class="favorites-section">
                    {{-- <p class="messenger-title"><span>Favorites</span></p>
                    <div class="messenger-favorites app-scroll-hidden"></div> --}}
                </div>
                {{-- Saved Messages --}}
                {{-- <p class="messenger-title"><span>Your Space</span></p>
               {!! view('Chatify::layouts.listItem', ['get' => 'saved']) !!} --}}
                {{-- Contact --}}
                @if (auth()->user()->role == 'member' || auth()->user()->role == 'guest' )
                    @php
                        $users = App\Models\User::where('role', 'admin')->get();
                    @endphp
                    <p class="messenger-title"><span>List Admin</span></p>
                    @foreach ($users as $user)
                        <table class="messenger-list-item" data-contact="{{ $user->id }}">
                            <tr data-action="0">
                                <td>
                                    <p data-id="{{ $user->id }}" data-type="user">
                                        {{ strlen($user->name) > 15 ? trim(substr($user->name, 0, 15)) . '..' : $user->name }}
                                    </p>
                                </td>
                            </tr>
                        </table>
                    @endforeach
                @endif

                <p class="messenger-title"><span>All Messages</span></p>
                <div class="listOfContacts" style="width: 100%;height: calc(100% - 272px);position: relative;"></div>

            </div>
            {{-- ---------------- [ Search Tab ] ---------------- --}}
            <div class="messenger-tab search-tab app-scroll" data-view="search">
                {{-- items --}}
                <p class="messenger-title"><span>Search</span></p>
                <div class="search-records">
                    <p class="message-hint center-el"><span>Type to search..</span></p>
                </div>
            </div>
        </div>
    </div>

    {{-- ----------------------Messaging side---------------------- --}}
    <div class="messenger-messagingView">
        {{-- header title [conversation name] amd buttons --}}
        <div class="m-header m-header-messaging">
            <nav class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                {{-- header back button, avatar and user name --}}
                <div class="chatify-d-flex chatify-justify-content-between chatify-align-items-center">
                    <a href="#" class="show-listView"><i class="fas fa-arrow-left"></i></a>
                    {{-- <div class="avatar av-s header-avatar"
                        style="margin: 0px 10px; margin-top: -5px; margin-bottom: -5px;">
                    </div> --}}
                    <a href="#" class="user-name" style="padding-left: 20px">Welcome to SPIRIT Chat</a>
                </div>
                {{-- header buttons --}}
                <nav class="m-header-right">
                    {{-- <a href="#" class="add-to-favorite"><i class="fas fa-star"></i></a> --}}
                    <a href="/chat"><i class="fas fa-home"></i></a>
                    <div class="messenger-infoView-btns">
                        <a href="#" class="danger delete-conversation"><i class="fas fa-trash"></i></a>
                    </div>
                    {{-- <a href="#" class="show-infoSide"><i class="fas fa-info-circle"></i></a> --}}
                </nav>
            </nav>
            {{-- Internet connection --}}
            <div class="internet-connection">
                <span class="ic-connected">Connected</span>
                <span class="ic-connecting">Connecting...</span>
                <span class="ic-noInternet">No internet access</span>
            </div>
        </div>

        {{-- Messaging area --}}
        <div class="m-body messages-container app-scroll">
            <div class="messages">
                @php
                    $auth = auth()->user()->role;
                    // dd($auth);
                @endphp
                @if ($auth == 'member' || $auth == 'guest')
                    <p class="message-hint center-el"><span>Please select admin to start chat</span></p>
                @else
                    <p class="message-hint center-el"><span>Please select a chat to start messaging</span></p>
                @endif
            </div>
            {{-- Typing indicator --}}
            <div class="typing-indicator">
                <div class="message-card typing">
                    <div class="message">
                        <span class="typing-dots">
                            <span class="dot dot-1"></span>
                            <span class="dot dot-2"></span>
                            <span class="dot dot-3"></span>
                        </span>
                    </div>
                </div>
            </div>

        </div>
        {{-- Send Message Form --}}
        @include('Chatify::layouts.sendForm')
    </div>
    {{-- ---------------------- Info side ---------------------- --}}
    {{-- <div class="messenger-infoView app-scroll">
        <nav>
            <p>User Details</p>
            <a href="#"><i class="fas fa-times"></i></a>
        </nav>
        {!! view('Chatify::layouts.info')->render() !!}
    </div> --}}
</div>

@include('Chatify::layouts.modals')
@include('Chatify::layouts.footerLinks')
