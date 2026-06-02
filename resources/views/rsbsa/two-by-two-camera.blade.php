{{-- 2x2 camera capture. Opens a centered modal with a live preview, sends the
     snapshot to the Livewire method captureTwoByTwo(). Requires HTTPS. --}}
<div x-data="{
        open: false,
        captured: false,
        done: false,
        stream: null,
        photoData: null,
        start() {
            if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
                alert('Camera needs HTTPS and a supported browser.');
                return;
            }
            this.open = true;
            this.captured = false;
            this.$nextTick(() => {
                navigator.mediaDevices.getUserMedia({ video: { width: 480, height: 360 } })
                    .then(s => { this.stream = s; this.$refs.preview.srcObject = s; })
                    .catch(() => { alert('Unable to access the camera.'); this.open = false; });
            });
        },
        stop() { if (this.stream) { this.stream.getVideoTracks().forEach(t => t.stop()); this.stream = null; } },
        retake() {
            this.captured = false;
            this.$nextTick(() => {
                navigator.mediaDevices.getUserMedia({ video: { width: 480, height: 360 } })
                    .then(s => { this.stream = s; this.$refs.preview.srcObject = s; });
            });
        },
        capture() {
            this.$refs.canvas.getContext('2d').drawImage(this.$refs.preview, 0, 0, 480, 360);
            this.stop();
            this.captured = true;
        },
        save() {
            this.photoData = this.$refs.canvas.toDataURL('image/png');
            $wire.captureTwoByTwo(this.photoData);
            this.stop();
            this.done = true; this.open = false; this.captured = false;
        },
        cancel() { this.stop(); this.open = false; this.captured = false; }
    }" class="space-y-2">

    {{-- Inline trigger button --}}
    <div>
        <button type="button" @click="start()"
            class="inline-flex items-center justify-center gap-1 px-3 py-2 text-sm font-semibold text-white rounded bg-primary-500 hover:bg-primary-600 whitespace-nowrap">
            <x-heroicon-o-camera class="w-4 h-4 shrink-0" /> Use Camera
        </button>
        <span x-show="done" x-cloak class="block mt-1 text-sm font-medium text-green-600">Photo captured &#10003;</span>
    </div>

    {{-- Preview of the captured camera photo --}}
    <div x-show="done && photoData" x-cloak class="mt-1">
        <img :src="photoData" class="object-cover w-32 h-32 border rounded" alt="2x2 preview">
        <button type="button" @click="start()" class="block mt-1 text-xs text-primary-600 hover:underline">Retake photo</button>
    </div>

    {{-- Centered modal overlay --}}
    <div x-show="open" x-cloak
         class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black bg-opacity-60"
         @click.self="cancel()" @keydown.escape.window="cancel()">
        <div class="w-full max-w-lg p-4 bg-white shadow-xl rounded-xl" @click.stop>
            <div class="flex items-center justify-between mb-3">
                <h3 class="text-base font-bold text-gray-800">Take 2x2 Photo</h3>
                <button type="button" @click="cancel()" class="text-gray-400 hover:text-gray-600">
                    <x-heroicon-o-x class="w-5 h-5" />
                </button>
            </div>

            <video x-show="!captured" x-ref="preview" width="480" height="360" autoplay playsinline
                   class="w-full mx-auto bg-black rounded"></video>
            <canvas x-show="captured" x-cloak x-ref="canvas" width="480" height="360"
                    class="w-full mx-auto bg-black rounded"></canvas>

            <div class="flex flex-wrap justify-end gap-2 mt-4">
                <button type="button" x-show="!captured" @click="capture()"
                    class="px-4 py-2 text-sm font-semibold text-white rounded bg-primary-500 hover:bg-primary-600">Capture</button>
                <button type="button" x-show="captured" x-cloak @click="retake()"
                    class="px-4 py-2 text-sm font-semibold border rounded border-primary-500 text-primary-600 hover:bg-primary-50">Retake</button>
                <button type="button" x-show="captured" x-cloak @click="save()"
                    class="px-4 py-2 text-sm font-semibold text-white rounded bg-primary-500 hover:bg-primary-600">Use this photo</button>
                <button type="button" @click="cancel()"
                    class="px-4 py-2 text-sm font-semibold border rounded hover:bg-gray-50">Cancel</button>
            </div>
            <p class="mt-2 text-xs text-gray-500">This replaces an uploaded file if both are provided.</p>
        </div>
    </div>
</div>
