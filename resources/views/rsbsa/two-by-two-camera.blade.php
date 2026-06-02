{{-- 2x2 camera capture. Sends the snapshot to the Livewire method captureTwoByTwo().
     Requires HTTPS (getUserMedia). Used alongside the file upload field. --}}
<div x-data="{
        open: false,
        captured: false,
        done: false,
        stream: null,
        start() {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                alert('Camera needs HTTPS and a supported browser.');
                return;
            }
            navigator.mediaDevices.getUserMedia({ video: { width: 480, height: 360 } })
                .then(s => { this.stream = s; this.$refs.preview.srcObject = s; this.open = true; this.captured = false; })
                .catch(() => alert('Unable to access the camera.'));
        },
        stop() { if (this.stream) { this.stream.getVideoTracks().forEach(t => t.stop()); this.stream = null; } },
        capture() {
            this.$refs.canvas.getContext('2d').drawImage(this.$refs.preview, 0, 0, 480, 360);
            this.stop();
            this.captured = true;
        },
        save() {
            $wire.captureTwoByTwo(this.$refs.canvas.toDataURL('image/png'));
            this.done = true; this.open = false; this.captured = false;
        },
        cancel() { this.stop(); this.open = false; this.captured = false; }
    }" class="space-y-2">

    <div class="flex items-center gap-2">
        <button type="button" @click="start()"
            class="inline-flex items-center gap-1 px-3 py-2 text-sm font-semibold text-white rounded bg-primary-500 hover:bg-primary-600">
            <x-heroicon-o-camera class="w-4 h-4" /> Use Camera
        </button>
        <span x-show="done" x-cloak class="text-sm font-medium text-green-600">Photo captured &#10003;</span>
    </div>

    <div x-show="open" x-cloak class="p-3 mt-2 border rounded bg-gray-50" style="max-width: 500px;">
        <video x-show="!captured" x-ref="preview" width="480" height="360" autoplay playsinline class="w-full bg-black rounded"></video>
        <canvas x-show="captured" x-cloak x-ref="canvas" width="480" height="360" class="w-full bg-black rounded"></canvas>
        <div class="flex flex-wrap gap-2 mt-2">
            <button type="button" x-show="!captured" @click="capture()"
                class="px-3 py-1 text-sm font-semibold text-white rounded bg-primary-500">Capture</button>
            <button type="button" x-show="captured" x-cloak @click="start()"
                class="px-3 py-1 text-sm font-semibold text-white rounded bg-amber-500">Retake</button>
            <button type="button" x-show="captured" x-cloak @click="save()"
                class="px-3 py-1 text-sm font-semibold text-white rounded bg-green-600">Use this photo</button>
            <button type="button" @click="cancel()"
                class="px-3 py-1 text-sm font-semibold border rounded">Cancel</button>
        </div>
        <p class="mt-2 text-xs text-gray-500">Tip: this replaces the uploaded file if both are provided.</p>
    </div>
</div>
