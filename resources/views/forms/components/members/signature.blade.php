<x-dynamic-component :component="$getFieldWrapperView()" :id="$getId()" :label="$getLabel()" :label-sr-only="$isLabelHidden()" :helper-text="$getHelperText()" :hint="$getHint()" :hint-action="$getHintAction()" :hint-color="$getHintColor()" :hint-icon="$getHintIcon()" :required="$isRequired()" :state-path="$getStatePath()">
    <div wire:model.defer="data.signature" x-data="{
        ctx: null,
        memCtx: null,
        memCanvas: null,
        points: [],
        shouldDraw: false,
        coord: {
            x: 0,
            y: 0,
        },
        clear() {
            this.memCtx.clearRect(0, 0, 400, 200);
            this.ctx.clearRect(0, 0, 400, 200);
        },
        startDrawing(event) {
            this.coord = this.getMouse(event, $refs.ctx)
            this.points.push({
                x: this.coord.x,
                y: this.coord.y,
            });
            this.shouldDraw = true;
        },
        stopDrawing() {
            this.memCtx.clearRect(0, 0, 400, 200);
            this.memCtx.drawImage($refs.ctx, 0, 0);
            this.points = [];
            this.shouldDraw = false;
            $dispatch('input', $refs.ctx.toDataURL());
        },
        drawPoints(ctx, points) {
            if (points.length < 6) {
                var b = points[0];
                ctx.beginPath(), ctx.arc(b.x, b.y, ctx.lineWidth / 2, 0, Math.PI * 2, !0), ctx.closePath(), ctx.fill();
                return
            }
            ctx.beginPath(), ctx.moveTo(points[0].x, points[0].y);
            for (i = 1; i < points.length - 2; i++) {
                var c = (points[i].x + points[i + 1].x) / 2,
                    d = (points[i].y + points[i + 1].y) / 2;
                ctx.quadraticCurveTo(points[i].x, points[i].y, c, d)
            }
            ctx.quadraticCurveTo(points[i].x, points[i].y, points[i + 1].x, points[i + 1].y), ctx.stroke()
        },
        draw(event) {
            if (this.shouldDraw) {
                this.ctx.clearRect(0, 0, 400, 200);
                this.ctx.drawImage(this.memCanvas, 0, 0);
                this.coord = this.getMouse(event, $refs.ctx)
                this.points.push({
                    x: this.coord.x,
                    y: this.coord.y,
                });
                this.drawPoints(this.ctx, this.points);
            }
        },
        getMouse(e, canvas) {
            var element = canvas,
                offsetX = 0,
                offsetY = 0,
                mx, my;
            if (element.offsetParent !== undefined) {
                do {
                    offsetX += element.offsetLeft;
                    offsetY += element.offsetTop;
                } while ((element = element.offsetParent));
            }
            mx = e.pageX - offsetX;
            my = e.pageY - offsetY;
            return { x: mx, y: my };
        },
        init() {
            this.ctx = $refs.ctx.getContext('2d');
            this.ctx.lineWidth = 2;
            this.ctx.lineJoin = 'round';
            this.ctx.lineCap = 'round';
            this.memCanvas = document.createElement('canvas');
            this.memCanvas.width = 400;
            this.memCanvas.height = 200;
            this.memCtx = this.memCanvas.getContext('2d');
        },
    }" x-init="init">
        <canvas @mouseup="stopDrawing" @mousedown="startDrawing" @mouseleave="shouldDraw = false;" @mousemove="draw" x-ref="ctx" height="200" width="400" class="bg-white border-2 border-black rounded">
        </canvas>
        <button @click="clear">Clear</button>
    </div>
</x-dynamic-component>
