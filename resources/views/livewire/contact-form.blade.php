<div>
    <div>

        <div>
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>sent!</strong> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
        </div>

        <!-- Form -->
        <form wire:submit.prevent="submitForm" class="form-ajax">
        @csrf

        <!-- Form Hidden Fields -->
            <input type="hidden" name="form" value="Contact">
            <!-- /Form Hidden Fields -->

            <!-- Row -->
            <div class="row">

                <!-- Form Group -->
                <div class="form-group col-md-6">
                    <label for="frm-contact-name">Your Name</label>
                    <input
                        wire:model.debounce.500ms="name"
                        id="frm-contact-name"
                        type="text"
                        name="name"
                        class="form-control bg-transparent"
                        placeholder="Your Name... *"
                        required=""
                        aria-describedby="nameHelp"
                    >
                    @error('name')
                    <div id="nameHelp" class="form-text alert-warning">{{ $message }}</div>
                    @enderror
                </div>
                <!-- /Form Group -->

                <!-- Form Group -->
                <div class="form-group col-md-6">
                    <label for="frm-contact-email">E-mail Address</label>
                    <input
                        wire:model.debounce.500ms="email"
                        id="frm-contact-email"
                        type="email"
                        name="email"
                        class="form-control bg-transparent"
                        placeholder="E-mail address... *"
                        aria-describedby="emailHelp"
                    >
                    @error('email')
                    <div id="emailHelp" class="form-text alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <!-- /Form Group -->

            </div>
            <!-- /Row -->

            <!-- Form Group -->
            <div class="form-group mb-4">
                <label for="frm-contact-message">Message</label>
                <textarea
                    wire:model.debounce.500ms="message"
                    id="frm-contact-message"
                    name="message"
                    class="form-control bg-transparent"
                    placeholder="Message... "
                    rows="9"
                    aria-describedby="messageHelp"
                >
                </textarea>
                @error('message')
                <div id="messageHelp" class="form-text">{{ $message }}</div>
                @enderror
            </div>
            <!-- /Form Group -->

            <!-- Send Message Button -->
            <button type="submit" class="btn btn-primary">Send Message</button>
            <!-- /Send Message Button -->

        </form>
        <!-- Form -->

    </div>
</div>
