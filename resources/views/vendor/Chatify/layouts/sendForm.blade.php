<div class="messenger-sendCard">
    <form id="message-form" method="POST" action="{{ route('send.message') }}">
        @csrf
        <!-- Hapus bagian input file untuk attachment -->
        <!-- <label><span class="fas fa-plus-circle"></span><input disabled='disabled' type="file" class="upload-attachment" name="file" accept=".{{implode(', .',config('chatify.attachments.allowed_images'))}}, .{{implode(', .',config('chatify.attachments.allowed_files'))}}" /></label> -->
        <!-- Hapus tombol emoji jika tidak digunakan -->
        <!-- <button class="emoji-button"></span><span class="fas fa-smile"></button> -->
        <textarea name="message" class="m-send app-scroll" placeholder="Type a message.."></textarea>
        <button type="submit" class="send-button"><span class="fas fa-paper-plane"></span></button>
    </form>
</div>

