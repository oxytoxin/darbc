<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>RSBSA PDF Tuner — {{ $rsbsa->surname }}, {{ $rsbsa->first_name }}</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: system-ui, sans-serif; background: #eef1f5; color: #1f2937; }

        .toolbar {
            position: sticky; top: 0; z-index: 50; display: flex; flex-wrap: wrap; gap: 10px;
            align-items: center; padding: 10px 16px; background: #111827; color: #fff;
            box-shadow: 0 2px 6px rgba(0,0,0,.2);
        }
        .toolbar h1 { font-size: 14px; margin: 0 12px 0 0; font-weight: 600; }
        .toolbar .who { font-size: 12px; opacity: .8; margin-right: auto; }
        .btn {
            border: 0; border-radius: 6px; padding: 7px 12px; font-size: 13px; font-weight: 600;
            cursor: pointer; color: #fff; background: #4f46e5; text-decoration: none; display: inline-block;
        }
        .btn.gray { background: #374151; }
        .btn.green { background: #059669; }
        .btn.red { background: #b91c1c; }
        .status { font-size: 12px; opacity: .9; }

        .help { padding: 8px 16px; font-size: 12px; color: #4b5563; background: #fff; border-bottom: 1px solid #e5e7eb; }

        .pageWrap { padding: 24px; display: flex; flex-direction: column; align-items: center; gap: 30px; }
        .pageTitle { align-self: flex-start; margin-left: 24px; font-weight: 600; color: #374151; }
        .page {
            position: relative; background-repeat: no-repeat; background-size: 100% 100%;
            box-shadow: 0 4px 18px rgba(0,0,0,.15); outline: 1px solid #cbd5e1;
        }

        .handle {
            position: absolute; white-space: nowrap; cursor: grab; user-select: none;
            color: #1d4ed8; font-family: Helvetica, Arial, sans-serif; line-height: 1;
            padding: 0; border: 1px dashed transparent; border-radius: 3px;
        }
        .handle:hover { border-color: #93c5fd; background: rgba(191,219,254,.35); }
        .handle.sel { border-color: #2563eb; background: rgba(147,197,253,.45); color: #b91c1c; }
        .handle .cell { display: inline-block; text-align: center; }
        .handle::after {
            content: attr(data-key); position: absolute; left: 0; top: -11px;
            font-size: 8px; line-height: 1; color: #b91c1c; background: #fff;
            border: 1px solid #fca5a5; border-radius: 3px; padding: 1px 3px;
            white-space: nowrap; display: none; pointer-events: none; z-index: 5;
        }
        .handle:hover::after, .handle.sel::after, body.show-labels .handle::after { display: block; }
        .handle.t-check { color: #b91c1c; font-weight: 700; }
        .handle.t-check::before {
            content: ''; position: absolute; inset: -3px; border: 1px solid rgba(185,28,28,.45);
            border-radius: 3px; pointer-events: none;
        }
        .handle.imgbox {
            display: flex; align-items: center; justify-content: center; text-align: center;
            background: rgba(59,130,246,.12); border: 1px dashed #2563eb; color: #1d4ed8;
            font-size: 11px; font-weight: 700;
        }

        .panel {
            position: fixed; right: 16px; bottom: 16px; z-index: 60; width: 230px;
            background: #fff; border: 1px solid #d1d5db; border-radius: 10px; padding: 12px;
            box-shadow: 0 8px 24px rgba(0,0,0,.18); font-size: 12px;
        }
        .panel .k { font-weight: 700; color: #111827; word-break: break-all; }
        .panel .row { display: flex; justify-content: space-between; margin-top: 6px; }
        .panel input { width: 70px; padding: 3px 6px; border: 1px solid #d1d5db; border-radius: 5px; }
        .panel .hint { margin-top: 8px; color: #6b7280; line-height: 1.4; }
    </style>
</head>
<body>
    @php $S = 1.5; $W = $page['w'] * $S; $H = $page['h'] * $S; @endphp

    <div class="toolbar">
        <h1>RSBSA PDF Tuner</h1>
        <span class="who">{{ $rsbsa->surname }}, {{ $rsbsa->first_name }} · DARBC {{ $rsbsa->darbc_id }}</span>
        <button class="btn green" onclick="saveCoords()">💾 Save positions</button>
        <a class="btn" href="{{ route('rsbsa.pdf', $rsbsa) }}" target="_blank">📄 Live PDF</a>
        <a class="btn gray" href="{{ route('rsbsa.pdf', $rsbsa) }}?grid=1" target="_blank">📐 PDF + grid</a>
        <button class="btn gray" onclick="document.body.classList.toggle('show-labels')">🏷 Labels</button>
        <span class="status" id="status"></span>
    </div>

    <div class="help">
        Drag any field onto its blank on the form. Click a field to select it, then use <b>arrow keys</b> for 1&nbsp;pt nudges
        (hold <b>Shift</b> for 5&nbsp;pt). Click <b>Save positions</b>, then <b>Live PDF</b> to confirm the real output.
        Fields shown as <code>〈name〉</code> have no value for this record but can still be positioned.
    </div>

    <div class="pageWrap">
        @foreach ([1, 2] as $pg)
            <div class="pageTitle">Page {{ $pg }}</div>
            <div class="page" id="page{{ $pg }}"
                 style="width: {{ $W }}px; height: {{ $H }}px; background-image: url('{{ asset('rsbsa-tuner/page'.$pg.'.png') }}');">
            </div>
        @endforeach
    </div>

    <div class="panel">
        <div class="k" id="pKey">— select a field —</div>
        <div class="row"><label>x (pt)</label><input id="pX" type="number" step="0.5" oninput="applyInput()"></div>
        <div class="row"><label>y (pt)</label><input id="pY" type="number" step="0.5" oninput="applyInput()"></div>
        <div class="row" id="gapRow" style="display:none"><label>gap (pt)</label><input id="pGap" type="number" step="0.5" oninput="applyGap()"></div>
        <div class="hint">Tip: the value text is rendered at the same scale as the PDF, so what you align here is what prints. For cell fields (DOB, PCN, mobile), use <b>gap</b> to tighten the spacing between characters.</div>
    </div>

    <script>
        const S = {{ $S }};
        const FONT = {{ $fontSize }};
        const ASCENT = 0.8 * FONT;            // pt: approx baseline offset from top
        const ITEMS = @json($items);
        const SAVE_URL = "{{ route('rsbsa.pdf.tuner.save') }}";
        const CSRF = document.querySelector('meta[name=csrf-token]').content;
        const LSKEY = 'rsbsa_tuner_{{ $rsbsa->id }}';
        let dirty = false;

        function markDirty() {
            dirty = true;
            try { localStorage.setItem(LSKEY, JSON.stringify(state)); } catch (e) {}
            const st = document.getElementById('status');
            if (st) st.textContent = '● Unsaved changes (auto-backed up in this browser) — click Save positions.';
        }

        const ptToTop  = y => (y - ASCENT) * S;
        const topToY   = t => t / S + ASCENT;
        const ptToLeft = x => x * S;
        const leftToX  = l => l / S;

        const state = {};   // key -> {x, y, gap}
        let selected = null;

        function makeHandle(it) {
            const el = document.createElement('div');
            el.className = 'handle t-' + it.type;
            el.dataset.key = it.key;
            el.title = it.key;
            el.style.fontSize = (FONT * S) + 'px';
            el.style.left = ptToLeft(it.x) + 'px';
            el.style.top  = ptToTop(it.y) + 'px';

            if (it.type === 'image') {
                el.classList.add('imgbox');
                el.style.left = (it.x * S) + 'px';
                el.style.top  = (it.y * S) + 'px';      // image anchor is top-left, no baseline
                el.style.width = (it.w * S) + 'px';
                el.style.height = (it.h * S) + 'px';
                el.textContent = it.value;
                state[it.key] = { x: it.x, y: it.y, w: it.w, h: it.h, img: true };
                attachDrag(el);
                return el;
            }

            if (it.type === 'boxed' && it.gap) {
                const cellW = it.gap * S;
                [...String(it.value)].forEach(ch => {
                    const c = document.createElement('span');
                    c.className = 'cell';
                    c.style.width = cellW + 'px';
                    c.textContent = ch;
                    el.appendChild(c);
                });
            } else {
                el.textContent = it.value;
                if (it.type === 'check') el.style.fontWeight = '700';
            }

            state[it.key] = { x: it.x, y: it.y, gap: it.gap };
            attachDrag(el);
            return el;
        }

        function attachDrag(el) {
            let sx, sy, ox, oy, dragging = false;
            el.addEventListener('mousedown', e => {
                e.preventDefault();
                select(el);
                dragging = true;
                el.style.cursor = 'grabbing';
                sx = e.clientX; sy = e.clientY;
                ox = parseFloat(el.style.left); oy = parseFloat(el.style.top);
            });
            window.addEventListener('mousemove', e => {
                if (!dragging) return;
                const nl = ox + (e.clientX - sx);
                const nt = oy + (e.clientY - sy);
                el.style.left = nl + 'px';
                el.style.top = nt + 'px';
                commit(el);
            });
            window.addEventListener('mouseup', () => {
                if (dragging) { dragging = false; el.style.cursor = 'grab'; }
            });
        }

        function commit(el) {
            const key = el.dataset.key;
            const left = parseFloat(el.style.left);
            const top = parseFloat(el.style.top);
            state[key].x = Math.round(leftToX(left) * 10) / 10;
            state[key].y = Math.round((state[key].img ? top / S : topToY(top)) * 10) / 10;
            if (selected === el) refreshPanel();
            markDirty();
        }

        function setTop(el, key) {
            el.style.top = (state[key].img ? state[key].y * S : ptToTop(state[key].y)) + 'px';
        }

        function select(el) {
            if (selected) selected.classList.remove('sel');
            selected = el;
            el.classList.add('sel');
            refreshPanel();
        }

        function refreshPanel() {
            if (!selected) return;
            const k = selected.dataset.key;
            document.getElementById('pKey').textContent = k;
            document.getElementById('pX').value = state[k].x;
            document.getElementById('pY').value = state[k].y;
            const gapRow = document.getElementById('gapRow');
            if (state[k].gap != null) {
                gapRow.style.display = 'flex';
                document.getElementById('pGap').value = state[k].gap;
            } else {
                gapRow.style.display = 'none';
            }
        }

        function applyGap() {
            if (!selected) return;
            const k = selected.dataset.key;
            const g = parseFloat(document.getElementById('pGap').value);
            if (isNaN(g) || g <= 0) return;
            state[k].gap = g;
            selected.querySelectorAll('.cell').forEach(c => c.style.width = (g * S) + 'px');
            markDirty();
        }

        function applyInput() {
            if (!selected) return;
            const k = selected.dataset.key;
            const x = parseFloat(document.getElementById('pX').value);
            const y = parseFloat(document.getElementById('pY').value);
            if (!isNaN(x)) { state[k].x = x; selected.style.left = (state[k].img ? x * S : ptToLeft(x)) + 'px'; }
            if (!isNaN(y)) { state[k].y = y; setTop(selected, k); }
            markDirty();
        }

        window.addEventListener('keydown', e => {
            if (!selected || ['INPUT'].includes(document.activeElement.tagName)) return;
            const step = e.shiftKey ? 5 : 1;
            let used = true;
            if (e.key === 'ArrowLeft')  state[selected.dataset.key].x -= step;
            else if (e.key === 'ArrowRight') state[selected.dataset.key].x += step;
            else if (e.key === 'ArrowUp')    state[selected.dataset.key].y -= step;
            else if (e.key === 'ArrowDown')  state[selected.dataset.key].y += step;
            else used = false;
            if (used) {
                e.preventDefault();
                const k = selected.dataset.key;
                selected.style.left = ptToLeft(state[k].x) + 'px';
                setTop(selected, k);
                refreshPanel();
                markDirty();
            }
        });

        function saveCoords() {
            const coords = {};
            for (const k in state) {
                coords[k] = { x: state[k].x, y: state[k].y };
                if (state[k].gap != null) coords[k].gap = state[k].gap;
            }
            const st = document.getElementById('status');
            st.textContent = 'Saving…';
            fetch(SAVE_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': CSRF, 'Accept': 'application/json' },
                body: JSON.stringify({ coords }),
            })
            .then(r => r.json())
            .then(d => {
                dirty = false;
                try { localStorage.removeItem(LSKEY); } catch (e) {}
                st.textContent = '✓ Saved ' + d.saved + ' fields — open Live PDF to verify.';
            })
            .catch(() => { st.textContent = '✗ Save failed — your changes are still backed up in this browser.'; });
        }

        // build
        ITEMS.forEach(it => {
            const host = document.getElementById('page' + (it.page || 1));
            if (host) host.appendChild(makeHandle(it));
        });

        // Restore any unsaved drags from this browser (survives refresh before Save)
        (function restoreBackup() {
            let backup;
            try { backup = JSON.parse(localStorage.getItem(LSKEY) || 'null'); } catch (e) { backup = null; }
            if (!backup) return;
            let restored = 0;
            document.querySelectorAll('.handle').forEach(el => {
                const k = el.dataset.key;
                if (backup[k] && (backup[k].x != null) && (backup[k].y != null)) {
                    state[k].x = backup[k].x;
                    state[k].y = backup[k].y;
                    el.style.left = ptToLeft(backup[k].x) + 'px';
                    setTop(el, k);
                    restored++;
                }
            });
            if (restored) {
                dirty = true;
                document.getElementById('status').textContent =
                    '↩ Restored ' + restored + ' unsaved positions from this browser — click Save positions to keep them.';
            }
        })();

        // Warn before leaving with unsaved changes
        window.addEventListener('beforeunload', e => {
            if (dirty) { e.preventDefault(); e.returnValue = ''; }
        });
    </script>
</body>
</html>
