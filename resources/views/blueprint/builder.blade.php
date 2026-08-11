@php
$konsep    = $konsep    ?? 'umum';
$fromFase  = $fromFase  ?? null;
$backRoute = $backRoute ?? route('simulasi.index');
$backLabel = $backLabel ?? '← Beranda';
$nextRoute = $nextRoute ?? null;
$nextLabel = $nextLabel ?? 'Lanjut ke Fase 5';
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>{{ $konsep === 'enkapsulasi' ? 'Fase 4 – Aplikasi · Enkapsulasi' : ($konsep === 'inheritance' ? 'Blueprint · Inheritance' : 'Blueprint Builder') }} — OOP Learn</title>
<script src="https://cdn.tailwindcss.com"></script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=JetBrains+Mono:wght@400;500;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
<style>
/* ─── LMS base ─── */
body { font-family: 'Inter', sans-serif; }
[x-cloak] { display: none !important; }

/* ─── ICS theme — light (matches LMS) ─── */
#ics-root {
  --bg:#f5f6f8;--panel:#ffffff;--panel2:#f3f4f6;--border:#e5e7eb;--border2:#eef0f3;
  --text:#1f2937;--dim:#6b7280;--faint:#9ca3af;
  --amber:#d97706;--amber-bg:rgba(217,119,6,.07);--amber-dim:#fef3c7;
  --cyan:#0891b2;--violet:#7c3aed;--rose:#e11d48;--rose-bg:rgba(225,29,72,.06);
  --green:#16a34a;--green-bg:rgba(22,163,74,.06);
  --r:10px;--mono:'JetBrains Mono',monospace;--sans:'Inter',sans-serif;
  background:var(--bg);
  color:var(--text);
  font-family:var(--sans);
  -webkit-font-smoothing:antialiased;
  min-height:100%;
}
#ics-root a{color:var(--cyan);text-decoration:none;}
#ics-root a:hover{text-decoration:underline;}
#ics-root input,#ics-root textarea,#ics-root select{font-family:var(--sans);}

/* Toast */
#toast{
  position:fixed;bottom:24px;right:24px;z-index:9999;display:none;
  background:#15181f;border:1px solid #262b38;border-radius:10px;
  padding:12px 18px;font-size:13px;box-shadow:0 4px 24px rgba(0,0,0,.4);
  max-width:320px;color:#e8eaf0;
}
#toast.success{border-color:#7ee08a;color:#7ee08a;}
#toast.error{border-color:#ff7a8a;color:#ff7a8a;}

/* Python status badge */
.py-status{font-family:'JetBrains Mono',monospace;font-size:11px;padding:4px 10px;border-radius:6px;
  border:1px solid #e5e7eb;color:#9ca3af;}
.py-status.ready{border-color:#16a34a;color:#16a34a;}
.py-status.loading{border-color:#d97706;color:#d97706;}


/* ─── PHASE INDICATOR ──────────────────────────────────── */
.phase-bar{display:flex;align-items:center;gap:0;margin-bottom:24px;overflow:hidden;border-radius:10px;border:1px solid var(--border);}
.phase-step{
  flex:1;display:flex;align-items:center;justify-content:center;gap:8px;
  padding:11px 16px;font-size:12.5px;color:var(--faint);background:var(--panel);
  transition:.2s;border-right:1px solid var(--border);cursor:pointer;
}
.phase-step:last-child{border-right:none;}
.phase-step .num{
  width:22px;height:22px;border-radius:50%;border:1.5px solid var(--border);
  display:flex;align-items:center;justify-content:center;font-family:var(--mono);
  font-size:11px;flex-shrink:0;transition:.2s;
}
.phase-step.done{color:var(--dim);}
.phase-step.done .num{background:var(--faint);border-color:var(--faint);color:var(--bg);}
.phase-step.active{color:var(--amber);background:var(--amber-bg);}
.phase-step.active .num{background:var(--amber);border-color:var(--amber);color:#1a0e00;font-weight:700;}

/* ─── SHARED PANELS ────────────────────────────────────── */
.panel{background:var(--panel);border:1px solid var(--border);border-radius:var(--r);box-shadow:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);}
.panel-hdr{display:flex;align-items:center;justify-content:space-between;padding:10px 14px;border-bottom:1px solid var(--border2);}
.panel-hdr h3{font-size:11px;font-family:var(--mono);text-transform:uppercase;letter-spacing:.9px;color:var(--faint);font-weight:600;}
#accessPanel .panel-hdr{justify-content:flex-start;gap:10px;}
.panel-body{padding:14px;}
.btn{font-family:var(--sans);font-size:13px;font-weight:500;border:none;border-radius:8px;padding:9px 16px;cursor:pointer;transition:.15s;display:inline-flex;align-items:center;gap:6px;}
.btn-amber{background:var(--amber);color:#1a0e00;font-weight:600;}
.btn-amber:hover{filter:brightness(1.07);}
.btn-amber:disabled{opacity:.4;cursor:not-allowed;}
.btn-ghost{background:transparent;color:var(--dim);border:1px solid var(--border);}
.btn-ghost:hover{color:var(--text);border-color:#3a4254;}
.btn-green{background:var(--green);color:#0d1e10;font-weight:600;}
.btn-green:hover{filter:brightness(1.07);}
.btn-rose{background:var(--rose-bg);color:var(--rose);border:1px solid rgba(255,122,138,.3);}

/* ─── PHASE 1: BLUEPRINT BUILDER ──────────────────────── */
#phase1{display:block;}
.builder-layout{display:grid;grid-template-columns:340px 1fr;gap:14px;align-items:start;}
@media(max-width:900px){.builder-layout{grid-template-columns:1fr;}}

/* class tabs */
.class-tabs{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:14px;}
.cls-tab{font-family:var(--mono);font-size:12px;padding:6px 12px;border-radius:7px;
  border:1px solid var(--border);background:var(--panel);color:var(--dim);cursor:pointer;transition:.15s;
  display:flex;align-items:center;gap:6px;}
.cls-tab:hover{border-color:#3a4254;color:var(--text);}
.cls-tab.active{border-color:var(--cyan);color:var(--cyan);background:rgba(106,214,232,.07);}
.cls-tab .del-cls{color:var(--faint);font-size:14px;line-height:1;padding:0 2px;}
.cls-tab .del-cls:hover{color:var(--rose);}
.btn-add-cls{font-family:var(--mono);font-size:12px;padding:6px 11px;border-radius:7px;
  border:1.5px dashed var(--border);background:transparent;color:var(--faint);cursor:pointer;transition:.15s;}
.btn-add-cls:hover{border-color:var(--amber);color:var(--amber);}

/* class editor form */
.form-field{margin-bottom:14px;}
.form-label{font-size:11.5px;color:var(--faint);font-weight:500;margin-bottom:5px;display:block;font-family:var(--mono);letter-spacing:.5px;text-transform:uppercase;}
.form-input{width:100%;padding:9px 11px;background:var(--panel2);border:1px solid var(--border);
  border-radius:7px;color:var(--text);font-size:13px;}
.form-input:focus{outline:none;border-color:var(--amber);}
select.form-input option{background:var(--panel2);}

/* attr/method rows */
.attr-list,.meth-list{display:flex;flex-direction:column;gap:7px;margin-bottom:8px;}
.attr-row,.meth-row{
  display:flex;align-items:center;gap:6px;
  background:var(--panel2);border:1px solid var(--border);border-radius:8px;padding:7px 9px;
}
.vis-badge{
  font-family:var(--mono);font-size:11px;font-weight:700;cursor:pointer;
  width:22px;height:22px;border-radius:5px;display:flex;align-items:center;justify-content:center;
  flex-shrink:0;border:1.5px solid transparent;transition:.15s;
}
.vis-badge.pub{color:var(--green);border-color:rgba(126,224,138,.4);background:rgba(126,224,138,.07);}
.vis-badge.pro{color:var(--amber);border-color:rgba(255,180,84,.4);background:rgba(255,180,84,.07);}
.vis-badge.priv{color:var(--rose);border-color:rgba(255,122,138,.4);background:rgba(255,122,138,.07);}
.mini-input{
  flex:1;background:transparent;border:none;color:var(--text);font-family:var(--mono);font-size:12px;
  padding:2px 4px;min-width:0;
}
.mini-input::placeholder{color:var(--faint);}
.mini-input:focus{outline:none;}
.type-input{width:72px;background:transparent;border:none;color:var(--violet);font-family:var(--mono);font-size:11.5px;padding:2px 4px;}
.type-input::placeholder{color:var(--faint);}
.type-input:focus{outline:none;}
.colon{color:var(--faint);font-family:var(--mono);font-size:12px;flex-shrink:0;}
.btn-del-row{background:transparent;border:none;color:var(--faint);cursor:pointer;font-size:16px;flex-shrink:0;padding:0 2px;line-height:1;}
.btn-del-row:hover{color:var(--rose);}
.ret-sep{color:var(--faint);font-family:var(--mono);font-size:11px;flex-shrink:0;}
.btn-add-row{
  font-family:var(--mono);font-size:11.5px;color:var(--faint);background:transparent;
  border:1px dashed var(--border2);border-radius:7px;padding:5px 10px;cursor:pointer;
  transition:.15s;width:100%;text-align:left;
}
.btn-add-row:hover{border-color:var(--amber);color:var(--amber);}

/* live diagram (right panel) */
.diagram-container{
  position:sticky;top:72px;background:var(--panel);border:1px solid var(--border);
  border-radius:var(--r);min-height:180px;
  box-shadow:0 1px 3px rgba(0,0,0,.06),0 1px 2px rgba(0,0,0,.04);
}
.diagram-svg-wrap{padding:20px;overflow:auto;min-height:140px;display:flex;align-items:flex-start;justify-content:center;}
.diagram-hint-bar{padding:8px 14px 12px;font-size:11.5px;color:var(--faint);border-top:1px solid var(--border2);}
.code-preview-box{
  margin:0 14px 14px;background:var(--panel2);border:1px solid var(--border2);border-radius:8px;
  padding:12px 14px;font-family:var(--mono);font-size:11.5px;line-height:1.9;max-height:220px;
  overflow:auto;white-space:pre-wrap;
}
.kw{color:var(--violet);}
.fn-c{color:var(--cyan);}
.st-c{color:var(--green);}
.cm-c{color:var(--faint);font-style:italic;}
.priv-c{color:var(--rose);}

/* phase1 footer */
.phase1-footer{display:flex;align-items:center;gap:12px;margin-top:16px;flex-wrap:wrap;}

/* ─── PHASE 2: CODE EDITOR ─────────────────────────────── */
#phase2{display:none;}
.code-layout{display:grid;grid-template-columns:260px 1fr;gap:14px;align-items:start;}
@media(max-width:860px){.code-layout{grid-template-columns:1fr;}}
.code-sidebar{display:flex;flex-direction:column;gap:12px;position:sticky;top:72px;}
.editor-wrap{position:relative;border:1px solid var(--border);border-radius:var(--r);overflow:hidden;background:var(--panel);}
.editor-wrap:focus-within{border-color:var(--amber);}
.editor-hl{
  position:absolute;top:0;left:0;width:100%;height:100%;pointer-events:none;z-index:0;
  overflow:hidden;font-family:var(--mono);font-size:13px;line-height:1.9;
  padding:16px;box-sizing:border-box;white-space:pre;color:transparent;
}
.editor-hl .todo-ln{display:block;background:rgba(255,180,84,.13);border-left:3px solid var(--amber);padding-left:2px;margin-left:-3px;}
.editor-hl .norm-ln{display:block;}
textarea#codeEditor{
  position:relative;z-index:1;
  width:100%;min-height:380px;font-family:var(--mono);font-size:13px;line-height:1.9;
  background:transparent;border:none;outline:none;
  color:var(--text);padding:16px;resize:vertical;caret-color:var(--amber);
}
textarea#codeEditor:focus{outline:none;}
.tip-item{display:flex;gap:8px;font-size:12.5px;color:var(--dim);padding:5px 0;line-height:1.5;}
.tip-item .tip-dot{width:6px;height:6px;border-radius:50%;background:var(--amber);flex-shrink:0;margin-top:5px;}
.pred-box{background:var(--amber-dim);border:1px solid var(--amber);border-radius:var(--r);padding:13px 14px;}
.pred-label{font-family:var(--mono);font-size:10.5px;text-transform:uppercase;letter-spacing:.9px;color:var(--amber);margin-bottom:6px;}
textarea.pred-input{width:100%;min-height:68px;font-family:var(--sans);font-size:13px;
  background:var(--bg);border:1px solid var(--border);border-radius:7px;color:var(--text);
  padding:9px 10px;resize:vertical;}
textarea.pred-input:focus{outline:none;border-color:var(--amber);}
.phase2-footer{display:flex;align-items:center;gap:12px;margin-top:16px;flex-wrap:wrap;}
.loader-row{display:none;align-items:center;gap:10px;}
.loader-row.show{display:flex;}
.spin{width:18px;height:18px;border:2px solid var(--border);border-top-color:var(--amber);border-radius:50%;animation:spin .8s linear infinite;}
@keyframes spin{to{transform:rotate(360deg)}}

/* ─── PHASE 3: SIMULATION ──────────────────────────────── */
#phase3{display:none;}
.sim-header{display:flex;align-items:center;gap:10px;margin-bottom:18px;flex-wrap:wrap;}
.sim-header h2{font-size:14px;font-weight:600;}
.sim-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-bottom:14px;}
@media(max-width:820px){.sim-grid{grid-template-columns:1fr;}}
.code-viewer{font-family:var(--mono);font-size:12.5px;line-height:2;max-height:320px;overflow:auto;}
.cl{display:flex;padding:0 12px;border-left:3px solid transparent;white-space:pre;}
.cl.active{background:var(--amber-bg);border-left-color:var(--amber);}
.cl.error-line{background:var(--rose-bg);border-left-color:var(--rose);}
.ln{color:var(--faint);width:22px;flex-shrink:0;user-select:none;}
.ct{color:var(--dim);}
.cl.active .ct,.cl.error-line .ct{color:var(--text);}
.obj-card{flex:1 1 190px;border-radius:8px;padding:11px 13px;border:1px solid var(--border);background:var(--panel2);}
.obj-title{font-family:var(--mono);font-size:12px;font-weight:700;color:var(--cyan);margin-bottom:8px;}
.obj-title .oty{color:var(--faint);font-weight:400;}
.arow{display:flex;justify-content:space-between;font-family:var(--mono);font-size:11.5px;padding:2.5px 0;}
.akey{color:var(--dim);}
.aval{color:var(--text);}
.ibadge{font-size:9px;color:var(--violet);border:1px solid rgba(183,148,246,.4);border-radius:3px;padding:1px 4px;font-family:var(--sans);}
.pbadge{font-size:9px;color:var(--rose);border:1px solid rgba(255,122,138,.3);border-radius:3px;padding:1px 4px;font-family:var(--sans);}
.cons{font-family:var(--mono);font-size:12.5px;min-height:50px;}
.cline{padding:2px 0;color:var(--dim);}
.cline.cerr{color:var(--rose);}
.cline.cok{color:var(--green);}
.cempty{color:var(--faint);}
/* ─── CONCEPT INDICATOR ─────────────────────── */
#conceptBox{
  display:none;border-radius:var(--r);padding:13px 16px;margin-bottom:12px;
  border:1.5px solid;transition:background .25s,border-color .25s;
  animation:fadeSlide .25s ease;
}
@keyframes fadeSlide{from{opacity:0;transform:translateY(-6px)}to{opacity:1;transform:none}}
.ci-row{display:flex;align-items:center;gap:12px;}
.ci-icon{font-size:22px;flex-shrink:0;line-height:1;}
.ci-label{font-family:var(--mono);font-size:10px;font-weight:800;letter-spacing:1.2px;text-transform:uppercase;margin-bottom:3px;}
.ci-desc{font-size:12.5px;color:var(--dim);line-height:1.55;}
.ci-desc code{font-family:var(--mono);font-size:11px;background:rgba(0,0,0,.2);padding:1px 5px;border-radius:3px;}
/* ─── NARRATION ─────────────────────────────── */
.narr{background:var(--panel);border:1px solid var(--border);border-radius:var(--r);padding:14px 18px;font-size:13px;line-height:1.6;color:var(--dim);margin-bottom:14px;}
.narr b{color:var(--text);}
.narr code{font-family:var(--mono);font-size:11.5px;background:var(--panel2);padding:1px 5px;border-radius:4px;}
.narr-title{font-size:13.5px;font-weight:600;color:var(--text);display:flex;align-items:center;gap:8px;margin-bottom:6px;flex-wrap:wrap;}
.narr-body{font-size:12.5px;color:var(--dim);line-height:1.65;}
.narr-badge{font-family:var(--mono);font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;padding:2px 8px;border-radius:5px;border:1px solid;margin-left:4px;}
.narr-badge.class{color:var(--cyan);border-color:rgba(106,214,232,.4);background:rgba(106,214,232,.07);}
.narr-badge.inh{color:var(--violet);border-color:rgba(167,139,250,.4);background:rgba(167,139,250,.07);}
.narr-badge.enc{color:var(--rose);border-color:rgba(255,122,138,.3);background:rgba(255,122,138,.07);}
.narr-badge.meth{color:var(--amber);border-color:rgba(255,180,84,.4);background:rgba(255,180,84,.07);}
.narr-badge.obj{color:var(--green);border-color:rgba(126,224,138,.4);background:rgba(126,224,138,.07);}
.narr-badge.out{color:var(--faint);border-color:var(--border);background:var(--panel2);}
.narr-divider{border:none;border-top:1px solid var(--border2);margin:8px 0;}
.pred-sim-box{border:1px solid var(--amber);background:var(--amber-dim);border-radius:var(--r);padding:14px;margin-bottom:14px;}
.pred-sim-q{font-size:13px;color:var(--text);margin:6px 0 10px;}
.pred-irow{display:flex;gap:8px;}
.pred-irow input{flex:1;font-family:var(--sans);font-size:13px;padding:9px 10px;border-radius:7px;border:1px solid var(--border);background:var(--bg);color:var(--text);}
.pred-irow input:focus{outline:none;border-color:var(--amber);}
.refl-box{border:1px solid var(--border);background:var(--panel);border-radius:var(--r);padding:15px;margin-bottom:14px;}
.refl-label{font-family:var(--mono);font-size:10.5px;text-transform:uppercase;letter-spacing:.9px;color:var(--green);margin-bottom:8px;}
.tl{display:flex;align-items:center;gap:3px;overflow-x:auto;padding:4px 2px;margin-bottom:12px;}
.tn{width:9px;height:9px;border-radius:50%;background:var(--border);flex-shrink:0;cursor:pointer;transition:.15s;}
.tn.done{background:var(--faint);}
.tn.cur{background:var(--amber);box-shadow:0 0 0 4px rgba(255,180,84,.18);}
.tn.err{background:var(--rose);}
.tl-line{height:1px;background:var(--border);flex:1;min-width:5px;}
.tl-line.done{background:var(--faint);}
.ctrl-row{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:12px;}
#floatNext,#floatPrev{display:none;}
#floatLanjut{
  position:fixed;bottom:24px;right:24px;z-index:301;
  display:none;align-items:center;gap:8px;
  background:#16a34a;color:#fff;border:none;cursor:pointer;
  font-size:14px;font-weight:700;padding:13px 20px;border-radius:14px;
  box-shadow:0 4px 24px rgba(22,163,74,.45);
  transition:.15s;white-space:nowrap;
}
#floatLanjut:hover{background:#15803d;transform:scale(1.04);box-shadow:0 6px 28px rgba(22,163,74,.55);}
#floatLanjut svg{flex-shrink:0;}
.ctrl-left{display:flex;gap:8px;}
.cbtn{width:36px;height:36px;border-radius:8px;border:1px solid var(--border);background:var(--panel);color:var(--text);cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:15px;transition:.15s;}
.cbtn:hover:not(:disabled){border-color:var(--amber);color:var(--amber);}
.cbtn:disabled{opacity:.3;cursor:not-allowed;}
.cbtn.wide{width:auto;padding:0 14px;font-family:var(--sans);font-size:12px;gap:5px;}
.step-info{font-family:var(--mono);font-size:12px;color:var(--faint);}
.frame-badge{font-family:var(--mono);font-size:11px;background:var(--panel2);border:1px solid var(--border);border-radius:5px;padding:3px 8px;color:var(--dim);}

/* ─── CONCEPT PAGE BANNER ───────────────────────────────── */
.konsep-banner{
  display:flex;align-items:center;gap:14px;
  border-radius:10px;border:1.5px solid;padding:13px 18px;margin-bottom:20px;
}
.konsep-banner.enc{border-color:rgba(255,122,138,.35);background:rgba(255,122,138,.06);}
.konsep-banner.inh{border-color:rgba(183,148,246,.35);background:rgba(183,148,246,.06);}
.kb-icon{font-size:26px;flex-shrink:0;line-height:1;}
.kb-badge{font-family:var(--mono);font-size:9.5px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:2px 8px;border-radius:4px;border:1px solid;margin-bottom:4px;display:inline-block;}
.kb-badge.enc{color:var(--rose);border-color:rgba(255,122,138,.4);background:rgba(255,122,138,.1);}
.kb-badge.inh{color:var(--violet);border-color:rgba(183,148,246,.4);background:rgba(183,148,246,.1);}
.kb-title{font-size:14.5px;font-weight:700;margin-bottom:2px;}
.kb-title.enc{color:var(--rose);}
.kb-title.inh{color:var(--violet);}
.kb-desc{font-size:12.5px;color:var(--dim);line-height:1.5;}
.kb-actions{display:flex;align-items:center;gap:8px;margin-left:auto;flex-shrink:0;flex-wrap:wrap;}
.kb-action-btn{font-size:12px;font-weight:600;color:var(--text);text-decoration:none;padding:7px 14px;border-radius:8px;border:1.5px solid var(--border);background:var(--panel);cursor:pointer;transition:.15s;font-family:var(--sans);display:inline-flex;align-items:center;gap:6px;box-shadow:0 1px 3px rgba(0,0,0,.06);}
.kb-action-btn:hover{border-color:var(--amber);color:var(--amber);background:var(--amber-bg);text-decoration:none;}

/* ─── ACCESS MODIFIER TEST PANEL ─────────── */
.access-ctx-row{display:flex;gap:8px;margin-bottom:14px;flex-wrap:wrap;}
.ctx-btn{
  flex:1;padding:8px 12px;border-radius:8px;border:1.5px solid var(--border);
  background:var(--panel2);color:var(--dim);font-size:12.5px;cursor:pointer;
  transition:.15s;font-family:var(--sans);font-weight:500;white-space:nowrap;
}
.ctx-btn:hover{border-color:#3a4254;color:var(--text);}
.ctx-btn.outside.active{border-color:rgba(255,122,138,.55);background:rgba(255,122,138,.09);color:var(--rose);}
.ctx-btn.inside.active{border-color:rgba(126,224,138,.55);background:rgba(126,224,138,.09);color:var(--green);}
.ctx-btn.subclass.active{border-color:rgba(183,148,246,.55);background:rgba(183,148,246,.09);color:var(--violet);}
.access-attr-list{display:flex;flex-direction:column;gap:8px;}
.access-attr-row{
  display:flex;align-items:center;gap:10px;
  padding:9px 12px;background:var(--panel2);border:1px solid var(--border);border-radius:8px;
  transition:.15s;
}
.access-attr-row:hover{border-color:#3a4254;}
.acc-sym{font-family:var(--mono);font-size:14px;font-weight:700;width:16px;flex-shrink:0;}
.acc-name{font-family:var(--mono);font-size:12.5px;flex:1;}
.acc-vis-label{font-family:var(--mono);font-size:10px;font-weight:700;letter-spacing:.6px;text-transform:uppercase;padding:2px 7px;border-radius:4px;border:1px solid;flex-shrink:0;}
.acc-vis-label.priv{color:var(--rose);border-color:rgba(255,122,138,.35);background:rgba(255,122,138,.07);}
.acc-vis-label.pro{color:var(--amber);border-color:rgba(255,180,84,.35);background:rgba(255,180,84,.07);}
.acc-vis-label.pub{color:var(--green);border-color:rgba(126,224,138,.35);background:rgba(126,224,138,.07);}
/* Modal */
.acc-modal{
  display:none;position:fixed;inset:0;background:rgba(0,0,0,.72);z-index:500;
  align-items:center;justify-content:center;padding:20px;
}
.acc-modal.open{display:flex;}
.acc-modal-box{
  background:var(--panel);border:1px solid var(--border);border-radius:14px;
  padding:26px 24px 20px;width:100%;max-width:480px;
  animation:fadeSlide .2s ease;
}
.acc-result-box{border-radius:9px;border:1.5px solid;padding:14px 16px;margin-bottom:14px;}
.acc-result-title{font-family:var(--mono);font-size:11px;font-weight:800;letter-spacing:1.2px;text-transform:uppercase;margin-bottom:7px;}
.acc-result-msg{font-size:13px;color:var(--dim);line-height:1.7;}
.acc-result-msg code{font-family:var(--mono);font-size:11px;background:rgba(0,0,0,.3);padding:1px 5px;border-radius:3px;}
.acc-footer-meta{font-size:11.5px;color:var(--faint);font-family:var(--mono);text-align:center;padding-top:10px;border-top:1px solid var(--border2);}
.acc-predict-banner{border-radius:8px;padding:10px 14px;margin-bottom:14px;font-size:13px;font-weight:600;text-align:center;}
.acc-predict-banner.correct{background:rgba(22,163,74,.1);color:var(--green);border:1px solid rgba(22,163,74,.35);}
.acc-predict-banner.incorrect{background:rgba(225,29,72,.08);color:var(--rose);border:1px solid rgba(225,29,72,.3);}

/* ─── PUBLIC ATTR WARNING (enkapsulasi) ─── */
.attr-row.unsafe{border-color:rgba(255,180,84,.45);background:rgba(255,180,84,.04);}
.pub-warn-badge{
  font-family:var(--mono);font-size:9.5px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;
  padding:2px 7px;border-radius:4px;border:1px solid rgba(255,180,84,.45);
  background:rgba(255,180,84,.09);color:var(--amber);cursor:pointer;flex-shrink:0;
  transition:.15s;white-space:nowrap;
}
.pub-warn-badge:hover{background:rgba(255,180,84,.18);}

/* ─── PRESET EXAMPLES ───────────────────────── */
.preset-label{font-family:var(--mono);font-size:10px;text-transform:uppercase;letter-spacing:.9px;color:var(--faint);margin-bottom:10px;font-weight:600;}
.preset-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;}
.preset-card{border:1.5px solid var(--border);border-radius:10px;padding:13px;cursor:pointer;background:var(--panel);transition:.2s;box-shadow:0 1px 3px rgba(0,0,0,.06);}
.preset-card:hover{border-color:var(--amber);background:var(--amber-bg);box-shadow:0 4px 14px rgba(217,119,6,.12);}
.preset-card.featured{border-color:var(--cyan);background:rgba(8,145,178,.04);box-shadow:0 2px 10px rgba(8,145,178,.12);}
.preset-card.featured:hover{border-color:var(--cyan);background:rgba(8,145,178,.09);box-shadow:0 4px 16px rgba(8,145,178,.2);}
.preset-featured-badge{display:inline-flex;align-items:center;gap:4px;font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.7px;color:var(--cyan);background:rgba(8,145,178,.1);border:1px solid rgba(8,145,178,.25);border-radius:4px;padding:2px 7px;margin-bottom:6px;}
.preset-icon{font-size:22px;margin-bottom:6px;line-height:1;}
.preset-title{font-size:13px;font-weight:600;color:var(--text);margin-bottom:3px;}
.preset-desc{font-size:11.5px;color:var(--faint);line-height:1.5;}
.preset-tag{font-family:var(--mono);font-size:9.5px;color:var(--amber);border:1px solid rgba(255,180,84,.3);background:rgba(255,180,84,.07);border-radius:4px;padding:1px 6px;margin-top:7px;display:inline-block;}

/* ─── ONBOARDING MODAL ──────────────────────── */
.ob-modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.75);z-index:600;align-items:center;justify-content:center;padding:20px;}
.ob-modal.open{display:flex;}
.ob-box{background:var(--panel);border:1px solid var(--border);border-radius:16px;padding:28px 24px 22px;width:100%;max-width:500px;animation:fadeSlide .25s ease;}
.ob-dots{display:flex;gap:6px;justify-content:center;margin-bottom:20px;}
.ob-dot{width:8px;height:8px;border-radius:50%;background:var(--border);transition:.2s;}
.ob-dot.active{background:var(--amber);width:22px;border-radius:4px;}
.ob-icon{font-size:44px;text-align:center;margin-bottom:12px;}
.ob-title{font-size:17px;font-weight:700;text-align:center;margin-bottom:6px;}
.ob-desc{font-size:13.5px;color:var(--dim);line-height:1.7;text-align:center;margin-bottom:22px;}
.ob-desc code{font-family:var(--mono);font-size:11.5px;background:var(--panel2);padding:1px 5px;border-radius:3px;}
.ob-nav{display:flex;gap:8px;}

/* ─── GLOSSARY ──────────────────────────────── */
.glossary-modal{display:none;position:fixed;inset:0;background:rgba(0,0,0,.65);z-index:500;align-items:center;justify-content:center;padding:20px;}
.glossary-modal.open{display:flex;}
.glossary-box{background:var(--panel);border:1px solid var(--border);border-radius:14px;padding:22px 20px;width:100%;max-width:540px;max-height:80vh;display:flex;flex-direction:column;animation:fadeSlide .2s ease;}
.glossary-search{width:100%;padding:8px 12px;border:1px solid var(--border);border-radius:8px;background:var(--panel2);color:var(--text);font-size:13px;margin-bottom:14px;}
.glossary-search:focus{outline:none;border-color:var(--amber);}
.glossary-list{overflow-y:auto;flex:1;}
.glossary-item{padding:11px 4px;border-bottom:1px solid var(--border2);}
.glossary-item:last-child{border-bottom:none;}
.glossary-term{font-family:var(--mono);font-size:12.5px;font-weight:700;color:var(--cyan);margin-bottom:4px;}
.glossary-def{font-size:12.5px;color:var(--dim);line-height:1.6;}

/* ─── CONCEPT SUMMARY ───────────────────────── */
.summary-box{border:1px solid rgba(126,224,138,.4);background:rgba(126,224,138,.05);border-radius:var(--r);padding:16px 18px;margin-bottom:14px;}
.summary-title{font-size:13.5px;font-weight:600;color:var(--green);margin-bottom:12px;display:flex;align-items:center;gap:8px;}
.summary-grid{display:flex;flex-wrap:wrap;gap:8px;}
.summary-chip{display:flex;align-items:center;gap:6px;padding:5px 12px;border-radius:20px;font-size:12px;border:1px solid;}
.summary-chip.enc{color:var(--rose);border-color:rgba(255,122,138,.35);background:rgba(255,122,138,.07);}
.summary-chip.inh{color:var(--violet);border-color:rgba(183,148,246,.35);background:rgba(183,148,246,.07);}
.summary-chip.gen{color:var(--cyan);border-color:rgba(106,214,232,.3);background:rgba(106,214,232,.06);}

/* ─── MINI QUIZ ─────────────────────────────── */
.quiz-box{border:1px solid var(--amber);background:var(--amber-dim);border-radius:var(--r);padding:16px 18px;margin-bottom:14px;}
.quiz-hdr{font-family:var(--mono);font-size:10.5px;text-transform:uppercase;letter-spacing:.9px;color:var(--amber);margin-bottom:8px;}
.quiz-q{font-size:13.5px;color:var(--text);margin-bottom:14px;line-height:1.55;font-weight:500;}
.quiz-opts{display:flex;flex-direction:column;gap:8px;}
.quiz-opt{text-align:left;padding:10px 14px;border-radius:8px;border:1.5px solid var(--border);background:var(--panel);color:var(--dim);font-size:13px;cursor:pointer;transition:.15s;}
.quiz-opt:hover:not(:disabled){border-color:var(--amber);color:var(--text);}
.quiz-opt.correct{border-color:var(--green);background:rgba(126,224,138,.1);color:var(--green);font-weight:600;}
.quiz-opt.wrong{border-color:var(--rose);background:rgba(255,122,138,.08);color:var(--rose);}
.quiz-opt:disabled{cursor:not-allowed;}
.quiz-feedback{font-size:12.5px;margin-top:10px;line-height:1.6;padding:10px 13px;border-radius:7px;}
.quiz-feedback.correct{background:rgba(126,224,138,.08);color:var(--green);border:1px solid rgba(126,224,138,.3);}
.quiz-feedback.wrong{background:rgba(255,122,138,.08);color:var(--rose);border:1px solid rgba(255,122,138,.3);}

/* ─── Code editor stays dark for readability ─── */
#ics-root .editor-wrap{
  --text:#e8eaf0;--panel:#15181f;--panel2:#1b1f29;--border:#262b38;
  --faint:#545b6e;--dim:#8d96ab;--amber:#ffb454;--violet:#b794f6;--cyan:#6ad6e8;
  background:#15181f;border-color:#262b38;
}
#ics-root textarea#codeEditor{color:#e8eaf0;caret-color:#ffb454;}
#ics-root .editor-wrap .editor-hl{color:transparent;}

/* ─── MOBILE ────────────────────────────────── */
@media(max-width:600px){
  .content{padding:16px 12px 60px;}
  .konsep-banner{flex-wrap:wrap;}.kb-actions{margin-left:0;width:100%;}
  .phase-step span{display:none;}
  .preset-grid{grid-template-columns:1fr 1fr;}
  .sim-grid{grid-template-columns:1fr;}
}
@media(max-width:400px){.preset-grid{grid-template-columns:1fr;}}
</style>

</head>
<body class="bg-gray-50 text-gray-800">
<div class="flex min-h-screen" x-data="{ sidebarOpen: window.innerWidth >= 1024 }">
    @include('sidebar-siswa')
    <main class="flex-1 flex flex-col overflow-hidden min-w-0">
        @include('_navbar', ['navTitle' => $fromFase === 4 ? 'Fase 4 – Aplikasi · ICS Enkapsulasi' : 'Blueprint Builder · ICS'])
        <div class="flex-1 overflow-y-auto">
            @if($fromFase === 4)
            <div class="px-8 pt-6 pb-0 bg-white border-b border-gray-100">
                <div class="flex items-center gap-3 mb-2">
                    <span class="inline-flex items-center gap-1.5 bg-green-600 text-white text-xs font-bold px-3 py-1 rounded-full">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                        </svg>
                        Fase 4 dari 5
                    </span>
                    <span class="text-xs text-gray-400 font-medium">Model Needham Lima Fase · Aplikasi</span>
                </div>
                <p class="text-xs text-gray-500 mb-3">Terapkan konsep Enkapsulasi: rancang class, generate Python, dan jalankan simulasi interaktif.</p>
                @include('_needham-stepper', ['currentFase' => 4])
            </div>
            @endif
            <div id="ics-root" style="padding:28px 32px 80px;">
<div style="display:flex;justify-content:flex-end;margin-bottom:4px;">
  <span class="py-status loading" id="pyStatusGlobal">Memuat Python…</span>
</div>

@if($konsep === 'enkapsulasi')
<div class="konsep-banner enc">
  <span class="kb-icon">🔒</span>
  <div>
    <div class="kb-badge enc">OOP · Enkapsulasi</div>
    <div class="kb-title enc">Enkapsulasi (Encapsulation)</div>
    <div class="kb-desc">Rancang class dengan atribut privat (<code style="font-family:var(--mono);font-size:11px;background:rgba(0,0,0,.3);padding:1px 5px;border-radius:3px;">__attr</code>) dan protected (<code style="font-family:var(--mono);font-size:11px;background:rgba(0,0,0,.3);padding:1px 5px;border-radius:3px;">_attr</code>), lalu tambahkan getter &amp; setter sebagai pintu akses data yang aman.</div>
  </div>
  <div class="kb-actions">
    <button class="kb-action-btn" onclick="showOnboarding()">❓ Panduan</button>
    <button class="kb-action-btn" onclick="showGlossary()">📖 Glosarium</button>
    <a href="{{ $backRoute ?? route('home') }}" class="kb-action-btn">{{ $backLabel ?? '← Beranda' }}</a>
  </div>
</div>
@elseif($konsep === 'inheritance')
<div class="konsep-banner inh">
  <span class="kb-icon">📐</span>
  <div>
    <div class="kb-badge inh">OOP · Inheritance</div>
    <div class="kb-title inh">Inheritance (Pewarisan)</div>
    <div class="kb-desc">Rancang class induk dengan atribut &amp; method, lalu buat class anak (<code style="font-family:var(--mono);font-size:11px;background:rgba(0,0,0,.3);padding:1px 5px;border-radius:3px;">class Anak(Induk)</code>) yang mewarisi dan memperluas fungsionalitasnya.</div>
  </div>
  <div class="kb-actions">
    <button class="kb-action-btn" onclick="showOnboarding()">❓ Panduan</button>
    <button class="kb-action-btn" onclick="showGlossary()">📖 Glosarium</button>
    <a href="{{ $backRoute ?? route('home') }}" class="kb-action-btn">{{ $backLabel ?? '← Beranda' }}</a>
  </div>
</div>
@endif

<!-- ── PHASE INDICATOR ───────────────────────────────────────── -->
<div class="phase-bar">
  <div class="phase-step active" id="tab1" onclick="goPhase(1)">
    <div class="num">1</div><span>Blueprint Class</span>
  </div>
  <div class="phase-step" id="tab2" onclick="goPhase(2)">
    <div class="num">2</div><span>Editor Kode</span>
  </div>
  <div class="phase-step" id="tab3" onclick="goPhase(3)">
    <div class="num">3</div><span>Simulasi</span>
  </div>
</div>

<!-- ══════════════════════════════════════════════════════════════
     PHASE 1 — BLUEPRINT BUILDER
═══════════════════════════════════════════════════════════════ -->
<div id="phase1">

  {{-- Tujuan Pembelajaran --}}
  @if($fromFase)
  <div style="background:color-mix(in srgb,var(--amber) 8%,var(--panel));border:1px solid color-mix(in srgb,var(--amber) 30%,var(--border));border-radius:12px;padding:14px 16px;margin-bottom:18px;display:flex;gap:12px;align-items:flex-start;">
    <div style="width:34px;height:34px;border-radius:9px;background:color-mix(in srgb,var(--amber) 18%,var(--panel));display:flex;align-items:center;justify-content:center;flex-shrink:0;">
      <svg width="17" height="17" fill="none" viewBox="0 0 24 24" stroke="var(--amber)" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
    </div>
    <div>
      <p style="font-size:11px;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--amber);margin-bottom:7px;">Tujuan Pembelajaran – Fase 4 Aplikasi</p>
      <ul style="list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:5px;">
        <li style="display:flex;gap:8px;font-size:13px;color:var(--text);"><span style="color:var(--amber);font-weight:700;flex-shrink:0;">✓</span> Merancang class diagram OOP menggunakan Blueprint Builder visual</li>
        <li style="display:flex;gap:8px;font-size:13px;color:var(--text);"><span style="color:var(--amber);font-weight:700;flex-shrink:0;">✓</span> Mengimplementasikan konsep enkapsulasi / inheritance dalam kode Python</li>
        <li style="display:flex;gap:8px;font-size:13px;color:var(--text);"><span style="color:var(--amber);font-weight:700;flex-shrink:0;">✓</span> Mensimulasikan eksekusi kode langkah demi langkah dan menganalisis state objek</li>
      </ul>
    </div>
  </div>
  @endif

  <!-- Preset Examples -->
  <div style="margin-bottom:18px;">
    <div class="preset-label">⚡ Muat Contoh Siap Jalankan</div>
    <div class="preset-grid" id="presetGrid"></div>
  </div>

  <!-- Class Tabs -->
  <div class="class-tabs" id="classTabs"></div>

  <div class="builder-layout">

    <!-- LEFT: Editor Form -->
    <div>
      <div class="panel">
        <div class="panel-hdr">
          <h3 id="editorTitle">Definisi Class</h3>
          <span style="font-size:11px;color:var(--faint);font-family:var(--mono);">klik + untuk ganti visibilitas</span>
        </div>
        <div class="panel-body">

          <!-- Class Name -->
          <div class="form-field">
            <label class="form-label">Nama Class</label>
            <input class="form-input" id="clsName" type="text" placeholder="Contoh: Motor, Kendaraan, Akun..." autocomplete="off">
          </div>

          <!-- Parent (Inheritance) — hidden for enkapsulasi -->
          <div class="form-field" @if($konsep === 'enkapsulasi') style="display:none" @endif>
            <label class="form-label" style="display:flex;align-items:center;gap:6px;">
              <span style="font-family:var(--mono);font-size:9px;font-weight:700;text-transform:uppercase;
                letter-spacing:.8px;padding:1px 7px;border-radius:4px;
                background:rgba(124,58,237,.08);color:var(--violet);border:1px solid rgba(124,58,237,.25);">extends</span>
              Mewarisi dari (opsional)
            </label>
            <div style="display:flex;align-items:center;gap:8px;">
              <input class="form-input" id="clsParent" type="text"
                placeholder="Nama class induk, misal: Hewan"
                autocomplete="off"
                style="font-family:var(--mono);font-size:12.5px;flex:1;">
              <span id="parentStatus" style="font-size:11px;white-space:nowrap;flex-shrink:0;min-width:72px;text-align:right;"></span>
            </div>
          </div>

          <!-- Attributes -->
          <div class="form-field">
            <label class="form-label" style="margin-bottom:8px;">Atribut</label>
            <div class="attr-list" id="attrList"></div>
            <button class="btn-add-row" onclick="addAttr()">＋ Tambah Atribut</button>
          </div>

          <!-- Methods -->
          <div class="form-field" style="margin-bottom:0;">
            <label class="form-label" style="margin-bottom:8px;">Method</label>
            <div class="meth-list" id="methList"></div>
            <button class="btn-add-row" onclick="addMeth()">＋ Tambah Method</button>
          </div>

        </div>
      </div>
    </div>

    <!-- RIGHT: Live Diagram + Code Preview -->
    <div class="diagram-container">
      <div class="panel-hdr">
        <h3>Diagram class (live)</h3>
        <span style="font-size:11px;color:var(--faint);">diperbarui otomatis</span>
      </div>
      <div class="diagram-svg-wrap" id="diagramWrap">
        <!-- SVG generated by JS -->
      </div>
      <div class="diagram-hint-bar">
        <span style="color:var(--violet);">▪ ungu</span> = class anak &nbsp;·&nbsp;
        <span style="color:var(--cyan);">▪ cyan</span> = class induk &nbsp;·&nbsp;
        <span style="color:var(--rose);">- priv</span> &nbsp;
        <span style="color:var(--amber);"># prot</span> &nbsp;
        <span style="color:var(--green);">+ pub</span>
      </div>
      <div class="panel-hdr" style="border-top:1px solid var(--border2);">
        <h3>Preview kode yang akan digenerate</h3>
      </div>
      <div class="code-preview-box" id="codePreview"></div>
    </div>

  </div><!-- /builder-layout -->

  @if($konsep === 'enkapsulasi')
  <!-- ── Access Modifier Test Panel ── -->
  <div class="panel" id="accessPanel" style="margin-top:14px;">
    <div class="panel-hdr">
      <h3>🔐 Uji Access Modifier</h3>
      <span style="font-size:11px;color:var(--faint);">pilih konteks → klik atribut → prediksi dulu, baru lihat jawaban</span>
      <span id="accScoreBadge" style="margin-left:auto;font-size:11.5px;font-family:var(--mono);color:var(--dim);background:var(--panel2);border:1px solid var(--border);border-radius:6px;padding:3px 10px;flex-shrink:0;">Skor Nalar: 0/0</span>
    </div>
    <div class="panel-body" id="accessPanelBody">
      <div style="color:var(--faint);font-size:12.5px;text-align:center;padding:8px 0;">Tambahkan atribut di atas untuk mulai menguji</div>
    </div>
  </div>

  <!-- Modal hasil uji akses -->
  <div id="accModal" class="acc-modal" onclick="closeAccModal()">
    <div class="acc-modal-box" onclick="event.stopPropagation()">
      <div id="accModalContent"></div>
      <button onclick="closeAccModal()" class="btn btn-ghost" style="margin-top:14px;width:100%;justify-content:center;">Mengerti ✓</button>
    </div>
  </div>
  @endif

  @if($konsep === 'inheritance')
  <!-- ── Inheritance Test Panel ── -->
  <div class="panel" id="inheritancePanel" style="margin-top:14px;">
    <div class="panel-hdr">
      <h3>🧬 Uji Pewarisan</h3>
      <span style="font-size:11px;color:var(--faint);">pilih skenario → prediksi dulu, baru lihat jawaban</span>
      <span id="inheritanceScoreBadge" style="margin-left:auto;font-size:11.5px;font-family:var(--mono);color:var(--dim);background:var(--panel2);border:1px solid var(--border);border-radius:6px;padding:3px 10px;flex-shrink:0;">Skor Nalar: 0/0</span>
    </div>
    <div class="panel-body" id="inheritanceScenarioList"></div>
  </div>

  <!-- Modal hasil uji pewarisan -->
  <div id="inheritanceModal" class="acc-modal" onclick="closeInheritanceModal()">
    <div class="acc-modal-box" onclick="event.stopPropagation()">
      <div id="inheritanceModalContent"></div>
      <button onclick="closeInheritanceModal()" class="btn btn-ghost" style="margin-top:14px;width:100%;justify-content:center;">Mengerti ✓</button>
    </div>
  </div>
  @endif

  <div class="phase1-footer">
    <button class="btn-add-cls" onclick="addClass()">＋ Tambah Class Lain</button>
    <div style="flex:1;"></div>
    <button class="btn btn-amber" onclick="goToCodeEditor()">Generate Kode &amp; Lanjut →</button>
  </div>

</div><!-- /phase1 -->

<!-- ══════════════════════════════════════════════════════════════
     PHASE 2 — CODE EDITOR
═══════════════════════════════════════════════════════════════ -->
<div id="phase2">

  <div class="code-layout">

    <!-- Sidebar -->
    <div class="code-sidebar">
      <!-- Mini diagram -->
      <div class="panel">
        <div class="panel-hdr"><h3>Blueprint ringkas</h3></div>
        <div class="panel-body" style="padding:10px;">
          <div id="miniDiagram" style="overflow:auto;max-height:220px;display:flex;justify-content:center;"></div>
        </div>
      </div>
      <!-- Tips -->
      <div class="panel">
        <div class="panel-hdr"><h3>Panduan mengisi</h3></div>
        <div class="panel-body">
          <div class="tip-item"><div class="tip-dot"></div><div>Cari baris komentar <code style="font-family:var(--mono);font-size:11px;background:var(--panel2);padding:1px 4px;border-radius:3px;">✏ Lengkapi logika...</code>, lalu ganti <code style="font-family:var(--mono);font-size:11px;background:var(--panel2);padding:1px 4px;border-radius:3px;">pass</code> dengan logika method yang sesuai.</div></div>
          <div class="tip-item"><div class="tip-dot"></div><div>Tambahkan pemanggilan objek di bawah definisi class untuk menguji kode.</div></div>
          <div class="tip-item"><div class="tip-dot"></div><div>Gunakan <code style="font-family:var(--mono);font-size:11px;background:var(--panel2);padding:1px 4px;border-radius:3px;">print()</code> agar output tampil di console simulasi.</div></div>
          <div class="tip-item"><div class="tip-dot"></div><div>Atribut privat (<code style="font-family:var(--mono);font-size:11px;background:var(--panel2);padding:1px 4px;border-radius:3px;">__nama</code>) hanya bisa diakses dari dalam class.</div></div>
        </div>
      </div>
      <!-- Prediksi awal -->
      <div class="pred-box">
        <div class="pred-label">Prediksi Awal</div>
        <p style="font-size:12.5px;color:var(--dim);margin-bottom:8px;">Sebelum menjalankan — apa yang kamu prediksi akan terjadi?</p>
        <textarea class="pred-input" id="predAwal" placeholder="Tulis prediksimu..."></textarea>
      </div>
    </div>

    <!-- Code editor -->
    <div>
      <div class="panel">
        <div class="panel-hdr">
          <h3>Kode Python — lengkapi badan method</h3>
          <button class="btn-ghost btn" style="padding:5px 10px;font-size:11.5px;" onclick="resetCode()">↺ Reset ke Blueprint</button>
        </div>
        <div class="panel-body" style="padding:0;">
          <div class="editor-wrap">
            <div class="editor-hl" id="editorHl"></div>
            <textarea id="codeEditor" spellcheck="false"></textarea>
          </div>
        </div>
      </div>
    </div>

  </div><!-- /code-layout -->

  <div class="phase2-footer">
    <button class="btn btn-ghost" onclick="goPhase(1)">← Kembali ke Blueprint</button>
    <button class="btn btn-ghost" onclick="unduhKode()" title="Unduh kode Python sebagai file .py">⬇ Unduh .py</button>
    <button class="btn btn-amber" id="btnJalankan" onclick="jalankanSimulasi()">▶ Jalankan Simulasi</button>
    <div class="loader-row" id="loaderRow">
      <div class="spin"></div>
      <span style="font-size:13px;color:var(--dim);" id="loaderMsg">Mengeksekusi Python…</span>
    </div>
    <div id="runError" style="font-family:var(--mono);font-size:12.5px;color:var(--rose);display:none;"></div>
  </div>

</div><!-- /phase2 -->

<!-- ══════════════════════════════════════════════════════════════
     PHASE 3 — SIMULATION PLAYER
═══════════════════════════════════════════════════════════════ -->
<div id="phase3">

  <div class="sim-header">
    <div style="width:34px;height:34px;border-radius:8px;background:linear-gradient(145deg,var(--cyan),#3ab8d0);display:flex;align-items:center;justify-content:center;font-size:13px;color:#0d1a1e;">▶</div>
    <div>
      <h2 id="simTitle">Simulasi aktif</h2>
      <p style="font-size:12px;color:var(--dim);" id="simSubtitle"></p>
    </div>
    <div style="margin-left:auto;display:flex;align-items:center;gap:8px;">
      <button id="floatPrev" class="cbtn" title="Langkah sebelumnya (←)"
              onclick="if(!this.disabled) document.getElementById('btnPrev').click()">‹</button>
      <button id="floatNext" class="cbtn" title="Langkah berikutnya (→)"
              onclick="if(!this.disabled) document.getElementById('btnNext').click()">›</button>
      <button class="btn btn-ghost" onclick="goPhase(2)">← Edit Kode</button>
    </div>
  </div>

  <div class="sim-grid">
    <!-- Diagram (read-only) -->
    <div class="panel">
      <div class="panel-hdr">
        <h3>Diagram class</h3>
        <button class="btn-ghost btn" style="padding:4px 9px;font-size:11.5px;" id="btnToggleDiag">Sembunyikan</button>
      </div>
      <div id="simDiagBody">
        <div style="padding:14px;display:flex;justify-content:center;" id="simDiagSvg"></div>
      </div>
    </div>
    <!-- Code viewer -->
    <div class="panel">
      <div class="panel-hdr">
        <h3>Kode tersinkronisasi</h3>
        <span class="frame-badge" id="frameBadge">modul</span>
      </div>
      <div class="panel-body" style="padding:10px 0;">
        <div class="code-viewer" id="codeViewer"></div>
      </div>
    </div>
    <!-- Objects -->
    <div class="panel">
      <div class="panel-hdr"><h3>Status objek (memori)</h3></div>
      <div class="panel-body" id="objBody"></div>
    </div>
    <!-- Console -->
    <div class="panel">
      <div class="panel-hdr"><h3>Console output</h3></div>
      <div class="panel-body"><div class="cons" id="consBody"></div></div>
    </div>
  </div>

  <!-- Concept Indicator -->
  <div id="conceptBox"></div>

  <!-- Narration -->
  <div class="narr" id="narr"></div>

  <!-- Predict (conditional) -->
  <div class="pred-sim-box" id="predSimBox" style="display:none;">
    <div class="pred-label">Prediksi sebelum lanjut</div>
    <div class="pred-sim-q" id="predSimQ"></div>
    <div class="pred-irow">
      <input type="text" id="predSimIn" placeholder="Tulis prediksimu...">
      <button class="btn btn-amber" onclick="checkPred()" style="padding:9px 14px;">Periksa</button>
    </div>
    <div id="predSimResult" style="margin-top:10px;display:none;font-family:var(--mono);font-size:12px;"></div>
  </div>

  <!-- Reflection (last step) -->
  <div class="refl-box" id="reflBox" style="display:none;">
    <div class="refl-label">Refleksi Akhir</div>
    <p style="font-size:13px;color:var(--dim);margin-bottom:10px;line-height:1.55;" id="reflQ"></p>
    <div style="display:flex;gap:8px;">
      <textarea style="flex:1;min-height:70px;font-family:var(--sans);font-size:12.5px;background:var(--bg);border:1px solid var(--border);border-radius:7px;color:var(--text);padding:9px;resize:vertical;" id="reflIn" placeholder="Tulis kesimpulanmu..."></textarea>
      <button class="btn btn-green" style="align-self:flex-start;" onclick="simpanRefleksi()">Simpan</button>
    </div>
  </div>

  <!-- Concept Summary -->
  <div class="summary-box" id="summaryBox" style="display:none;"></div>

  <!-- Mini Quiz -->
  <div class="quiz-box" id="quizBox" style="display:none;"></div>

  <!-- Timeline -->
  <div class="tl" id="tl"></div>

  <!-- Controls -->
  <div class="ctrl-row">
    <div class="ctrl-left">
      <button class="cbtn wide" onclick="resetSim()">↺ Reset</button>
      <button class="cbtn" id="btnPrev">‹</button>
      <button class="cbtn" id="btnNext">›</button>
    </div>
    <span class="step-info" id="stepInfo"></span>
  </div>

  @if($nextRoute)
  <div style="margin-top:24px;padding-top:20px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:flex-end;gap:12px;">
    <span style="font-size:13px;color:var(--faint);">Sudah selesai eksplorasi simulasi?</span>
    <form method="POST" action="{{ $nextRoute }}">
      @csrf
      <button type="submit"
              class="btn btn-green"
              style="font-size:14px;padding:11px 22px;gap:8px;">
        {{ $nextLabel }}
        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
          <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
        </svg>
      </button>
    </form>
  </div>
  @endif

</div><!-- /phase3 -->

<!-- ── Onboarding Modal ──────────────────────────────────── -->
<div id="onboardModal" class="ob-modal">
  <div class="ob-box">
    <div class="ob-dots" id="obDots"></div>
    <div id="obContent"></div>
    <div class="ob-nav" id="obNav"></div>
  </div>
</div>

<!-- ── Glossary Modal (trigger dipindah ke header, gabung dgn Panduan/Dashboard) ── -->
<div id="glossaryModal" class="glossary-modal" onclick="if(event.target===this)closeGlossary()">
  <div class="glossary-box">
    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
      <span style="font-size:14px;font-weight:600;">📖 Glosarium OOP</span>
      <button onclick="closeGlossary()" class="btn btn-ghost" style="padding:4px 10px;font-size:12px;">✕ Tutup</button>
    </div>
    <input class="glossary-search" id="glossarySearch" placeholder="Cari istilah OOP..." oninput="filterGlossary()">
    <div class="glossary-list" id="glossaryList"></div>
  </div>
</div>

            </div>{{-- /ics-root --}}
        </div>{{-- /overflow-y-auto --}}
    </main>
</div>{{-- /flex min-h-screen --}}

<div id="toast"></div>
<button id="floatLanjut" onclick="submitLanjutFase()">
  Selesai — <span id="floatLanjutLabel"></span>
  <svg width="15" height="15" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5L21 12m0 0l-7.5 7.5M21 12H3"/>
  </svg>
</button>
<form id="lanjutFaseForm" method="POST" style="display:none;">
  @csrf
</form>
<script>
window.showToast = (msg, type='success', ms=3000) => {
  const t = document.getElementById('toast');
  t.textContent = msg; t.className = type; t.style.display = 'block';
  setTimeout(() => t.style.display = 'none', ms);
};
window.CSRF = document.querySelector('meta[name="csrf-token"]').content;

function submitLanjutFase() {
  const route = window.NEXT_FASE_ROUTE;
  if (!route) return;
  const form = document.getElementById('lanjutFaseForm');
  form.action = route;
  form.submit();
}
</script>

<script src="https://cdn.jsdelivr.net/pyodide/v0.26.4/full/pyodide.js"></script>
<script>
window.KONSEP = '{{ $konsep }}';
window.NEXT_FASE_ROUTE = {!! json_encode($nextRoute ?? null) !!};
window.NEXT_FASE_LABEL = {!! json_encode($nextLabel ?? 'Lanjut ke Fase 5') !!};

/* ══════════════════════════════════════════════════════════════
   STATE — Blueprint
══════════════════════════════════════════════════════════════ */
let classes = [newClass('Kendaraan')];
let activeId = classes[0].id;
let generatedCode = '';
let currentPhase = 1;
let traceSteps = [], traceClasses = [], diagramClasses = [], stepIdx = 0;
let codeLines = [], predAnswered = {}, predInitial = '';
let pyodide = null;
let diagVisible = true;
let sessionToken = null;

function newClass(name = '') {
  return {
    id: 'c' + Date.now() + Math.random().toString(36).slice(2, 6),
    name, parentId: null, parent: '',
    attrs: [],
    meths: []
  };
}
function newAttr() { return { id: 'a' + Date.now(), vis: 'pub', name: '', type: '', value: '' }; }
function newMeth() { return { id: 'm' + Date.now(), vis: 'pub', name: '', params: '', ret: '' }; }

/* ══════════════════════════════════════════════════════════════
   PHASE NAVIGATION
══════════════════════════════════════════════════════════════ */
function goPhase(n) {
  const fromPhase = currentPhase;
  currentPhase = n;
  [1,2,3].forEach(i => {
    document.getElementById('phase'+i).style.display = i===n ? 'block' : 'none';
    const tab = document.getElementById('tab'+i);
    tab.className = 'phase-step' + (i<n?' done':i===n?' active':'');
  });
  if (n===2) {
    if (fromPhase === 1) {
      generatedCode = generateCode();
      document.getElementById('codeEditor').value = generatedCode;
    }
    syncEditorHl();
    renderMiniDiagram();
  }
  if (n===3) {
    document.getElementById('simDiagSvg').innerHTML = '';
  }
  const fn = document.getElementById('floatNext');
  const fp = document.getElementById('floatPrev');
  const fl = document.getElementById('floatLanjut');
  if (fn) fn.style.display = n===3 ? 'flex' : 'none';
  if (fp) fp.style.display = n===3 ? 'flex' : 'none';
  if (fl) fl.style.display = 'none';
  window.scrollTo({top:0,behavior:'smooth'});
}

/* ══════════════════════════════════════════════════════════════
   CLASS MANAGEMENT
══════════════════════════════════════════════════════════════ */
function addClass() {
  const cls = newClass('');
  classes.push(cls);
  activeId = cls.id;
  renderTabs();
  renderEditor();
  renderDiagram();
  renderCodePreview();
}

function deleteClass(id) {
  if (classes.length === 1) return;
  classes = classes.filter(c => c.id !== id);
  // Clear broken parent refs
  classes.forEach(c => { if (c.parentId === id) { c.parentId = null; c.parent = ''; } });
  activeId = classes[classes.length - 1].id;
  renderTabs(); renderEditor(); renderDiagram(); renderCodePreview();
}

function setActive(id) {
  activeId = id;
  renderTabs(); renderEditor();
}

function getActive() { return classes.find(c => c.id === activeId); }

/* ══════════════════════════════════════════════════════════════
   RENDER TABS
══════════════════════════════════════════════════════════════ */
function renderTabs() {
  const wrap = document.getElementById('classTabs');
  wrap.innerHTML = '';
  classes.forEach(cls => {
    const div = document.createElement('div');
    div.className = 'cls-tab' + (cls.id === activeId ? ' active' : '');
    div.onclick = () => setActive(cls.id);
    div.innerHTML = `<span>${cls.name || '<em>tanpa nama</em>'}</span>`
      + (classes.length > 1
        ? `<span class="del-cls" onclick="event.stopPropagation();deleteClass('${cls.id}')">×</span>`
        : '');
    wrap.appendChild(div);
  });
}

/* ══════════════════════════════════════════════════════════════
   RENDER EDITOR FORM
══════════════════════════════════════════════════════════════ */
function renderEditor() {
  const cls = getActive();
  if (!cls) return;
  document.getElementById('editorTitle').textContent = cls.name || 'Class Baru';
  document.getElementById('clsName').value = cls.name;

  // Parent text input (Inheritance)
  const parentInput = document.getElementById('clsParent');
  parentInput.value = cls.parent || '';
  const statusEl = document.getElementById('parentStatus');
  if (cls.parent) {
    const resolved = classes.find(c => c.name === cls.parent && c.id !== cls.id);
    statusEl.innerHTML = resolved
      ? '<span style="color:var(--green);">✓ ditemukan</span>'
      : '<span style="color:var(--amber);">? belum ada</span>';
  } else {
    statusEl.innerHTML = '';
  }

  // Attrs
  const attrList = document.getElementById('attrList');
  attrList.innerHTML = '';
  cls.attrs.forEach((a, i) => {
    const row = document.createElement('div');
    const isUnsafe = window.KONSEP === 'enkapsulasi' && a.vis === 'pub' && a.name;
    row.className = 'attr-row' + (isUnsafe ? ' unsafe' : '');
    const warnBtn = isUnsafe
      ? `<button class="pub-warn-badge" onclick="showPubWarn('${escHtml(a.name)}')">⚠ Publik</button>`
      : '';
    row.innerHTML = `
      <span class="vis-badge ${a.vis}" title="Klik untuk ganti visibilitas" onclick="cycleVis('attr',${i})">${a.vis==='pub'?'+':a.vis==='pro'?'#':'-'}</span>
      <input class="mini-input" placeholder="namaAtribut" value="${escHtml(a.name)}"
        oninput="updateField('attr',${i},'name',this.value)">
      <span class="colon">:</span>
      <input class="type-input" placeholder="tipe" value="${escHtml(a.type)}"
        oninput="updateField('attr',${i},'type',this.value)">
      <span class="colon" style="font-size:10px;flex-shrink:0;">=</span>
      <input class="type-input" placeholder="nilai" title="Nilai default atribut"
        value="${escHtml(a.value||'')}"
        oninput="updateField('attr',${i},'value',this.value)"
        style="color:var(--cyan);width:58px;">
      <button class="btn-del-row" onclick="delField('attr',${i})">×</button>${warnBtn}`;
    attrList.appendChild(row);
  });

  // Meths
  const methList = document.getElementById('methList');
  methList.innerHTML = '';
  cls.meths.forEach((m, i) => {
    const row = document.createElement('div');
    row.className = 'meth-row';
    row.innerHTML = `
      <span class="vis-badge ${m.vis}" title="Klik untuk ganti visibilitas" onclick="cycleVis('meth',${i})">${m.vis==='pub'?'+':m.vis==='pro'?'#':'-'}</span>
      <input class="mini-input" placeholder="namaMethod" value="${escHtml(m.name)}"
        oninput="updateField('meth',${i},'name',this.value)">
      <span class="colon">(</span>
      <input class="mini-input" placeholder="param, ..." style="max-width:80px;" value="${escHtml(m.params)}"
        oninput="updateField('meth',${i},'params',this.value)">
      <span class="ret-sep">)</span>
      <span class="colon">→</span>
      <input class="type-input" placeholder="tipe" value="${escHtml(m.ret)}"
        oninput="updateField('meth',${i},'ret',this.value)">
      <button class="btn-del-row" onclick="delField('meth',${i})">×</button>`;
    methList.appendChild(row);
  });

  renderAccessPanel();
  renderInheritancePanel();
}

function escHtml(s){ return (s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;'); }

/* ══════════════════════════════════════════════════════════════
   FIELD OPERATIONS
══════════════════════════════════════════════════════════════ */
function addAttr() { getActive().attrs.push(newAttr()); renderEditor(); renderDiagram(); renderCodePreview(); }
function addMeth() { getActive().meths.push(newMeth()); renderEditor(); renderDiagram(); renderCodePreview(); }

function delField(type, i) {
  const cls = getActive();
  if (type==='attr') cls.attrs.splice(i,1); else cls.meths.splice(i,1);
  renderEditor(); renderDiagram(); renderCodePreview();
}

function updateField(type, i, key, val) {
  const cls = getActive();
  if (type==='attr') cls.attrs[i][key] = val; else cls.meths[i][key] = val;
  renderDiagram(); renderCodePreview();
}

function cycleVis(type, i) {
  const order = ['pub','pro','priv'];
  const cls = getActive();
  const arr = type==='attr' ? cls.attrs : cls.meths;
  arr[i].vis = order[(order.indexOf(arr[i].vis)+1) % 3];
  renderEditor(); renderDiagram(); renderCodePreview();
}

// Listen name + parent changes
document.getElementById('clsName').addEventListener('input', e => {
  const cls = getActive(); if (!cls) return;
  cls.name = e.target.value;
  document.getElementById('editorTitle').textContent = cls.name || 'Class Baru';
  renderTabs(); renderDiagram(); renderCodePreview();
});
document.getElementById('clsParent').addEventListener('input', e => {
  const cls = getActive(); if (!cls) return;
  cls.parent = e.target.value.trim();
  // Sync parentId so diagram arrows + topSort work correctly
  const resolved = classes.find(c => c.name === cls.parent && c.id !== cls.id);
  cls.parentId = resolved ? resolved.id : null;
  // Update status indicator live
  const statusEl = document.getElementById('parentStatus');
  if (cls.parent) {
    statusEl.innerHTML = resolved
      ? '<span style="color:var(--green);">✓ ditemukan</span>'
      : '<span style="color:var(--amber);">? belum ada</span>';
  } else { statusEl.innerHTML = ''; }
  renderDiagram(); renderCodePreview();
});

/* ══════════════════════════════════════════════════════════════
   SVG DIAGRAM GENERATOR
══════════════════════════════════════════════════════════════ */
function buildDiagramSVG(classList, activeName='') {
  if (!classList.length) return '';
  const BOX_W = 170, GAP_X = 40, GAP_Y = 70;
  const classMap = {}; classList.forEach(c => classMap[c.name || c.id] = c);

  // Rank (topological)
  const rank = {};
  classList.forEach(c => {
    const pName = classList.find(x => x.id === (c.parentId||c.parent))?.name;
    if (!pName || !classMap[pName]) rank[c.name||c.id] = 0;
  });
  for (let pass=0; pass<8; pass++) classList.forEach(c => {
    const pName = classList.find(x => x.id === (c.parentId||c.parent))?.name;
    if (pName && classMap[pName]) {
      const r = (rank[pName]??0)+1;
      if ((rank[c.name||c.id]??0) < r) rank[c.name||c.id] = r;
    }
  });
  classList.forEach(c => { if (rank[c.name||c.id]===undefined) rank[c.name||c.id]=0; });

  const byRank = {};
  classList.forEach(c => { const r=rank[c.name||c.id]||0; (byRank[r]=byRank[r]||[]).push(c); });
  const maxRank = Math.max(...Object.keys(byRank).map(Number));
  const maxCols = Math.max(...Object.values(byRank).map(a=>a.length));
  const svgW = Math.max(280, maxCols*(BOX_W+GAP_X)+GAP_X);

  // Box heights
  const bh = {};
  classList.forEach(c => {
    const attrRows = (c.attrs||[]).length;
    const methRows = (c.meths||[]).filter(m=>m.name!=='__init__').length;
    bh[c.name||c.id] = 36 + Math.max(0, attrRows+methRows)*16 + (attrRows>0&&methRows>0?8:0) + 12;
    bh[c.name||c.id] = Math.max(bh[c.name||c.id], 60);
  });

  // Positions
  const pos = {};
  Object.entries(byRank).forEach(([r, rcs]) => {
    const totalW = rcs.length*BOX_W + (rcs.length-1)*GAP_X;
    const startX = (svgW-totalW)/2;
    rcs.forEach((c,i) => pos[c.name||c.id] = { x: startX+i*(BOX_W+GAP_X), y: parseInt(r)*150+16 });
  });

  const svgH = (maxRank+1)*150+30;
  let svg = `<svg viewBox="0 0 ${svgW} ${svgH}" width="${svgW}" style="max-width:100%;overflow:visible;">
  <defs>
    <marker id="inh" markerWidth="9" markerHeight="9" refX="4.5" refY="4.5" orient="auto">
      <path d="M0,0 L9,4.5 L0,9 Z" fill="var(--violet)"/>
    </marker>
    <marker id="inhC" markerWidth="9" markerHeight="9" refX="4.5" refY="4.5" orient="auto">
      <path d="M0,0 L9,4.5 L0,9 Z" fill="var(--cyan)"/>
    </marker>
  </defs>`;

  // Arrows (behind)
  classList.forEach(c => {
    const pName = classList.find(x => x.id===(c.parentId||c.parent))?.name;
    if (pName && pos[c.name||c.id] && pos[pName]) {
      const from=pos[c.name||c.id], to=pos[pName];
      const fx=from.x+BOX_W/2, fy=from.y, tx=to.x+BOX_W/2, ty=to.y+bh[pName];
      svg+=`<line x1="${fx}" y1="${fy}" x2="${tx}" y2="${ty}" stroke="var(--violet)" stroke-width="1.5" marker-end="url(#inh)"/>`;
    }
  });

  // Boxes
  classList.forEach(c => {
    const key = c.name||c.id;
    if (!pos[key]) return;
    const {x,y} = pos[key], h = bh[key];
    const isParent = classList.some(oc => classList.find(x=>x.id===(oc.parentId||oc.parent))?.name===key);
    const hasParent = !!classList.find(x=>x.id===(c.parentId||c.parent));
    const isActive = key === activeName;
    const stroke = isActive ? 'var(--amber)' : hasParent ? 'var(--violet)' : isParent ? 'var(--cyan)' : 'var(--faint)';
    const strokeW = isActive ? '2.5' : '1.4';
    const isEmpty = !c.name;

    // Blueprint style for empty/draft
    const dashArr = isEmpty ? 'stroke-dasharray="6 3"' : '';
    svg+=`<rect x="${x}" y="${y}" width="${BOX_W}" height="${h}" rx="6" fill="${isActive?'rgba(255,180,84,0.06)':'rgba(21,24,31,0.95)'}" stroke="${stroke}" stroke-width="${strokeW}" ${dashArr}/>`;

    if (isEmpty) {
      svg+=`<text x="${x+BOX_W/2}" y="${y+h/2+4}" text-anchor="middle" fill="var(--faint)" font-family="Inter" font-size="11" font-style="italic">blueprint kosong...</text>`;
    } else {
      svg+=`<text x="${x+BOX_W/2}" y="${y+20}" text-anchor="middle" fill="var(--text)" font-family="JetBrains Mono" font-size="12" font-weight="700">${escSvg(c.name)}</text>`;
      svg+=`<line x1="${x+6}" y1="${y+26}" x2="${x+BOX_W-6}" y2="${y+26}" stroke="var(--border)" stroke-width="1"/>`;
      let ly = y+40;
      (c.attrs||[]).forEach(a => {
        const col = a.vis==='priv'?'var(--rose)':a.vis==='pro'?'var(--amber)':'var(--green)';
        const pre = a.vis==='priv'?'-':a.vis==='pro'?'#':'+';
        const prefix = a.vis==='priv'?'__':a.vis==='pro'?'_':'';
        const label = `${pre} ${prefix}${a.name||'?'}${a.type?': '+a.type:''}`;
        svg+=`<text x="${x+7}" y="${ly}" fill="${col}" font-family="JetBrains Mono" font-size="9.5">${escSvg(label)}</text>`;
        ly+=16;
      });
      if ((c.attrs||[]).length && (c.meths||[]).length) {
        svg+=`<line x1="${x+6}" y1="${ly}" x2="${x+BOX_W-6}" y2="${ly}" stroke="var(--border2)" stroke-width="1"/>`;
        ly+=10;
      }
      (c.meths||[]).forEach(m => {
        const col = m.vis==='priv'?'var(--rose)':m.vis==='pro'?'var(--amber)':'var(--cyan)';
        const pre = m.vis==='priv'?'-':m.vis==='pro'?'#':'+';
        const label = `${pre} ${m.name||'?'}(${m.params||''})${m.ret?' → '+m.ret:''}`;
        svg+=`<text x="${x+7}" y="${ly}" fill="${col}" font-family="JetBrains Mono" font-size="9.5">${escSvg(label)}</text>`;
        ly+=16;
      });
    }
  });

  svg+='</svg>';
  return svg;
}

function escSvg(s) { return (s||'').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

function renderDiagram() {
  document.getElementById('diagramWrap').innerHTML = buildDiagramSVG(classes);
}
function renderMiniDiagram() {
  document.getElementById('miniDiagram').innerHTML = buildDiagramSVG(classes);
}

/* ══════════════════════════════════════════════════════════════
   CODE GENERATOR (Blueprint → Python)
══════════════════════════════════════════════════════════════ */
function generateCode() {
  const sorted = topSort(classes);
  let code = '';

  sorted.forEach(cls => {
    // Resolve parent: by synced ID first, then by text name (allows external parents)
    const parent     = classes.find(c => c.id === cls.parentId)
                    || classes.find(c => c.name === cls.parent && c.id !== cls.id);
    const parentName = parent?.name || cls.parent || '';
    const baseStr    = parentName ? `(${parentName})` : '';
    const cName      = cls.name || 'NamaClass';
    code += `class ${cName}${baseStr}:\n`;

    const ownAttrs    = cls.attrs.filter(a => a.name);
    const parentAttrs = parent ? parent.attrs.filter(a => a.name) : [];

    // Bug 2 — private attrs are NOT constructor parameters; they get type-based defaults
    const privateAttrs    = ownAttrs.filter(a => a.vis === 'priv');
    const nonPrivateAttrs = ownAttrs.filter(a => a.vis !== 'priv');

    const allParams = [...parentAttrs.map(a => a.name), ...nonPrivateAttrs.map(a => a.name)];
    const paramStr  = allParams.length ? ', ' + allParams.join(', ') : '';
    code += `    def __init__(self${paramStr}):\n`;

    if (parentName) {
      const pParams = parentAttrs.map(a => a.name).join(', ');
      code += `        super().__init__(${pParams})\n`;
    }

    if (!ownAttrs.length && !parent) {
      code += `        pass\n`;
    }

    // Public / protected attrs — assigned from constructor parameter
    nonPrivateAttrs.forEach(a => {
      const prefix = a.vis === 'pro' ? '_' : '';
      code += `        self.${prefix}${a.name} = ${a.name}\n`;
    });

    // Bug 2 — private attrs initialized with type-based defaults (0, 0.0, False, None)
    privateAttrs.forEach(a => {
      const defaultVal = a.type === 'int'   ? '0'
                       : a.type === 'float' ? '0.0'
                       : a.type === 'bool'  ? 'False'
                       :                     'None';
      code += `        self.__${a.name} = ${defaultVal}\n`;
    });

    code += '\n';

    // Methods — Bug 3: rename when method name collides with an attribute name
    cls.meths.filter(m => m.name).forEach(m => {
      const pStr   = m.params ? ', ' + m.params.split(',').map(p => p.trim()).filter(Boolean).join(', ') : '';
      const retStr = m.ret ? ` -> ${m.ret}` : '';

      // Bug 3 — if method name exactly matches an attr name → auto-prefix get/set
      const matchAttr = ownAttrs.find(a => a.name === m.name);
      let methodName  = m.name;
      if (matchAttr) {
        const cap  = m.name.charAt(0).toUpperCase() + m.name.slice(1);
        methodName = m.params ? `set${cap}` : `get${cap}`;
      }

      code += `    def ${methodName}(self${pStr})${retStr}:\n`;
      code += `        # ✏ Lengkapi logika method ini (hapus baris pass setelah selesai)\n`;
      code += `        pass\n\n`;
    });

    if (!cls.meths.length && !ownAttrs.length && parent) code += '';
    code += '\n';
  });

  // Instantiation example
  // Bug 1 + Bug 2: only non-private attrs as constructor args; smart string quoting
  const last = sorted[sorted.length - 1];
  if (last?.name) {
    const parent        = classes.find(c => c.id === last.parentId);
    const parentAttrs   = parent ? parent.attrs.filter(a => a.name) : [];
    const ownAttrs      = last.attrs.filter(a => a.name);
    const nonPrivOwn    = ownAttrs.filter(a => a.vis !== 'priv');  // Bug 2
    const allA          = [...parentAttrs, ...nonPrivOwn];

    // Bug 1 — if attr has a value, detect string vs number; else fall back to type defaults
    const args = allA.map(a => {
      if (a.value && a.value !== '') {
        return isNaN(a.value) ? `"${a.value}"` : a.value;  // Bug 1: smart quoting
      }
      if (a.type === 'int')   return '0';
      if (a.type === 'float') return '0.0';
      if (a.type === 'bool')  return 'True';
      return `"${a.name}"`;
    }).join(', ');

    const varName = last.name.charAt(0).toLowerCase() + last.name.slice(1) + '1';
    code += `# ── Contoh penggunaan ─────────────────────────\n`;
    code += `${varName} = ${last.name}(${args})\n`;

    if (ownAttrs.length) {
      const firstPub = ownAttrs.find(a => a.vis !== 'priv');
      if (firstPub) {
        const prefix = firstPub.vis === 'pro' ? '_' : '';
        code += `print(${varName}.${prefix}${firstPub.name})\n`;
      } else {
        // All attrs private — find getter using new Bug 3 convention
        const getter = last.meths.find(m => /^(get|is|has)/i.test(m.name));
        if (getter?.name) code += `print(${varName}.${getter.name}())\n`;
        else code += `# Akses atribut private lewat method getter\n`;
      }
    }
  }

  return code;
}

function topSort(cls) {
  const sorted = [], visited = new Set();
  function visit(c) {
    if (visited.has(c.id)) return;
    visited.add(c.id);
    const parent = cls.find(x => x.id === c.parentId);
    if (parent) visit(parent);
    sorted.push(c);
  }
  cls.forEach(visit);
  return sorted;
}

/* ══════════════════════════════════════════════════════════════
   CODE PREVIEW (highlighted, in Phase 1)
══════════════════════════════════════════════════════════════ */
function renderCodePreview() {
  const code = generateCode();
  const box = document.getElementById('codePreview');
  box.innerHTML = hlCode(code);
}

function hlCode(code) {
  return code.split('\n').map(line => {
    let s = line.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    s = s.replace(/(#.*)$/, m=>`<span class="cm-c">${m}</span>`);
    if (s.includes('cm-c')) return s + '\n';
    s = s.replace(/"[^"]*"|'[^']*'/g, m=>`<span class="st-c">${m}</span>`);
    s = s.replace(/\b(class|def|self|super|return|pass|import|from|as|try|except|if|else|elif|for|while|in|not|and|or|True|False|None)\b/g,
      m=>`<span class="kw">${m}</span>`);
    s = s.replace(/\b(print|len|range|str|int|float|bool|isinstance)\b/g,m=>`<span class="fn-c">${m}</span>`);
    s = s.replace(/(self\.__\w+)/g,m=>`<span class="priv-c">${m}</span>`);
    return s;
  }).join('\n');
}

function syncEditorHl() {
  const ta = document.getElementById('codeEditor');
  const hl = document.getElementById('editorHl');
  if (!ta || !hl) return;
  hl.innerHTML = ta.value.split('\n').map(line => {
    const isTodo = /^\s*#\s*TODO/.test(line);
    const safe = line.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
    return `<span class="${isTodo?'todo-ln':'norm-ln'}">${safe}\n</span>`;
  }).join('');
  hl.scrollTop = ta.scrollTop;
}

(function initEditor() {
  const ta = document.getElementById('codeEditor');
  if (!ta) return;
  ta.addEventListener('input', syncEditorHl);
  ta.addEventListener('scroll', () => {
    const hl = document.getElementById('editorHl');
    if (hl) hl.scrollTop = ta.scrollTop;
  });
})();

function resetCode() {
  document.getElementById('codeEditor').value = generateCode();
  syncEditorHl();
}

function unduhKode() {
  const code = (document.getElementById('codeEditor').value || '').trim();
  if (!code) { window.showToast('Belum ada kode untuk diunduh.', 'error'); return; }
  const nama = {'enkapsulasi':'enkapsulasi', 'inheritance':'inheritance'}[window.KONSEP] || 'python';
  const filename = nama + '_simulasi.py';
  const blob = new Blob([code], {type: 'text/plain'});
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url; a.download = filename; a.click();
  URL.revokeObjectURL(url);
  window.showToast('Kode diunduh sebagai ' + filename + ' ✓', 'success');
}

/* ── Bug 4: cascading scaffolding validation for enkapsulasi ── */
function validateInheritance() {
  // Level 1 — need at least 2 classes (parent + child)
  if (classes.length < 2) {
    return { ok: false, msg: '❌ Tambahkan minimal 2 class: satu class induk dan satu class anak!' };
  }

  // Level 2 — at least one child class must declare a parent
  const childClasses = classes.filter(c => c.parent || c.parentId);
  if (!childClasses.length) {
    return { ok: false, msg: '❌ Belum ada class yang mewarisi. Isi kolom "Mewarisi dari" pada class anak!' };
  }

  // Level 3 — the named parent must exist in the workspace
  for (const c of childClasses) {
    const parentExists = classes.some(p =>
      p.id === c.parentId || (c.parent && p.name === c.parent && p.id !== c.id)
    );
    if (!parentExists) {
      const label = c.parent || c.name || 'anak';
      return { ok: false, msg: `❌ Class induk "${c.parent}" belum dibuat di workspace. Tambahkan class "${c.parent}" terlebih dahulu!` };
    }
  }

  // Level 4 — each child must add at least one own attribute or method
  for (const c of childClasses) {
    const hasOwn = c.attrs.some(a => a.name) || c.meths.some(m => m.name);
    if (!hasOwn) {
      return { ok: false, msg: `❌ Class "${c.name || 'anak'}" belum punya atribut atau method sendiri. Tambahkan sesuatu yang membedakannya dari class induk!` };
    }
  }

  return { ok: true, msg: '✅ Inheritance sudah benar! Class anak berhasil mewarisi class induk.' };
}

function validateEnkapsulasi() {
  const allAttrs = classes.flatMap(c => c.attrs).filter(a => a.name);
  const allMeths = classes.flatMap(c => c.meths).filter(m => m.name);
  const methNames = allMeths.map(m => m.name.toLowerCase());

  // Step 1 — must have at least one private attribute
  const privAttrs = allAttrs.filter(a => a.vis === 'priv');
  if (!privAttrs.length) {
    return { ok: false, msg: "❌ Belum ada atribut Private. Ubah visibilitas atribut menjadi private (−) agar data terlindungi!" };
  }

  // Step 2 — each private attr must have a getter (get_X atau getX), tanpa mewajibkan setter
  for (const a of privAttrs) {
    const cap       = a.name.charAt(0).toUpperCase() + a.name.slice(1);
    const lowerName = a.name.toLowerCase();
    const hasGetter = methNames.some(n =>
      n === 'get_' + lowerName || n === 'get' + lowerName || n === 'get' + cap.toLowerCase()
    );
    if (!hasGetter) {
      return {
        ok: false,
        msg: `❌ Validasi Gagal: Untuk mengamankan ${a.name}, gunakan method get_${lowerName}() (atau get${cap}()), setor(), dan tarik().`
      };
    }
  }

  // Step 3 — must have at least one operational method selain getter/setter
  // (generik: tidak wajib bernama setor/tarik — cocok untuk domain apa pun)
  const methodOperasional = methNames.filter(n => !n.startsWith('get_') && !n.startsWith('set_'));
  if (methodOperasional.length === 0) {
    const attrName = privAttrs[0].name;
    return {
      ok: false,
      msg: `❌ Validasi Gagal: Tambahkan minimal 1 method operasional (selain getter/setter) untuk mengelola atribut ${attrName} secara aman — contoh: method yang memvalidasi atau memproses perubahan data.`
    };
  }

  return { ok: true, msg: '✅ Enkapsulasi sudah benar! Class punya getter dan method operasional yang aman. Siap generate kode.' };
}

function goToCodeEditor() {
  if (!classes.some(c => c.name)) {
    alert('Beri nama setidaknya satu class terlebih dahulu!');
    return;
  }

  // Scaffolding validation — switched by active konsep
  if (window.KONSEP === 'gabungan') {
    // Pertemuan 3: enkapsulasi LALU inheritance — keduanya harus lulus
    const enc = validateEnkapsulasi();
    if (!enc.ok) {
      window.showToast('🛡️ Enkapsulasi: ' + enc.msg.replace(/^❌\s*/,''), 'error', 5000);
      return;
    }
    const inh = validateInheritance();
    if (!inh.ok) {
      window.showToast('🌳 Inheritance: ' + inh.msg.replace(/^❌\s*/,''), 'error', 5000);
      return;
    }
  }
  if (window.KONSEP === 'inheritance') {
    const check = validateInheritance();
    if (!check.ok) {
      window.showToast(check.msg, 'error', 4500);
      return;
    }
  }
  if (window.KONSEP === 'enkapsulasi') {
    const check = validateEnkapsulasi();
    if (!check.ok) {
      window.showToast(check.msg, 'error', 4500);
      return;
    }
  }

  // Enkapsulasi: warn if any named attribute is still public
  if (window.KONSEP === 'enkapsulasi') {
    const pubAttrs = classes.flatMap(c => c.attrs).filter(a => a.name && a.vis === 'pub');
    if (pubAttrs.length) {
      const names = pubAttrs.map(a => `<code>${a.name}</code>`).join(', ');
      document.getElementById('accModalContent').innerHTML = `
        <div style="text-align:center;font-size:38px;line-height:1;margin-bottom:16px;">⚠️</div>
        <div class="acc-result-box" style="background:rgba(255,180,84,.08);border-color:rgba(255,180,84,.4);">
          <div class="acc-result-title" style="color:var(--amber);">ATRIBUT PUBLIK TERDETEKSI</div>
          <div class="acc-result-msg">
            Atribut ${names} masih bersifat <b>publik (+)</b>.<br><br>
            Artinya siapa saja bisa mengakses dan mengubahnya langsung dari luar class tanpa melewati method apapun:<br>
            <code style="color:var(--rose);">objek.${pubAttrs[0].name} = nilai_sembarang</code><br><br>
            Ini <b>melanggar prinsip enkapsulasi</b>. Ubah ke <b style="color:var(--rose);">− private</b> atau <b style="color:var(--amber);"># protected</b> agar data terlindungi.
          </div>
        </div>
        <div style="display:flex;gap:8px;margin-top:14px;">
          <button onclick="closeAccModal()" class="btn btn-ghost" style="flex:1;justify-content:center;">← Kembali &amp; Ubah</button>
          <button onclick="closeAccModal();goPhase(2);" class="btn" style="flex:1;justify-content:center;background:rgba(255,180,84,.12);color:var(--amber);border:1px solid rgba(255,180,84,.4);">Lanjut Tetap →</button>
        </div>`;
      document.getElementById('accModal').classList.add('open');
      return;
    }
  }

  goPhase(2);
}

/* ══════════════════════════════════════════════════════════════
   ACCESS MODIFIER TEST — enkapsulasi only
══════════════════════════════════════════════════════════════ */
let accessCtx = 'outside';
let accessAttempts = {};

function renderAccessPanel() {
  if (window.KONSEP !== 'enkapsulasi') return;
  const body = document.getElementById('accessPanelBody');
  if (!body) return;

  const cls = getActive();
  const attrs = (cls?.attrs || []).filter(a => a.name);

  const ctxDefs = [
    { key:'outside',  label:'↗ Luar Class',   cls:'outside' },
    { key:'inside',   label:'🏠 Dalam Class',  cls:'inside'  },
    { key:'subclass', label:'👨‍👧 Subclass',      cls:'subclass'},
  ];

  let html = `<div class="access-ctx-row">`;
  ctxDefs.forEach(({key,label,cls:c}) => {
    html += `<button class="ctx-btn ${c}${accessCtx===key?' active':''}" onclick="setAccessCtx('${key}')">${label}</button>`;
  });
  html += `</div>`;

  if (!attrs.length) {
    html += `<div style="color:var(--faint);font-size:12.5px;text-align:center;padding:8px 0;">Tambahkan atribut di atas untuk mulai menguji</div>`;
  } else {
    html += `<div class="access-attr-list">`;
    attrs.forEach(a => {
      const prefix  = a.vis==='priv'?'__':a.vis==='pro'?'_':'';
      const sym     = a.vis==='priv'?'−':a.vis==='pro'?'#':'+';
      const symCol  = a.vis==='priv'?'var(--rose)':a.vis==='pro'?'var(--amber)':'var(--green)';
      const visLbl  = a.vis==='priv'?'private':a.vis==='pro'?'protected':'public';
      const fullName = prefix + a.name;
      const attempted = accessAttempts[`${fullName}|${a.vis}|${accessCtx}`];
      const checkSpan = attempted ? ` <span style="color:var(--green);font-size:11px;vertical-align:middle;font-weight:700;">✓</span>` : '';
      html += `<div class="access-attr-row">
        <span class="acc-sym" style="color:${symCol};">${sym}</span>
        <span class="acc-name">${fullName}${checkSpan}</span>
        <span class="acc-vis-label ${a.vis}">${visLbl}</span>
        <button class="btn btn-ghost" style="padding:4px 12px;font-size:11.5px;margin-left:auto;" onclick="openPredictModal('${fullName}','${a.vis}')">Uji Prediksimu →</button>
      </div>`;
    });
    html += `</div>`;
  }

  body.innerHTML = html;
}

function setAccessCtx(ctx) {
  accessCtx = ctx;
  renderAccessPanel();
}

function getAccessVerdict(attrName, vis, ctx) {
  let icon, title, color, bg, border, msg;

  if (vis === 'priv') {
    if (ctx === 'inside') {
      icon='✅'; title='DIIZINKAN'; color='var(--green)'; bg='rgba(126,224,138,.08)'; border='rgba(126,224,138,.4)';
      msg = `Atribut privat <code>${attrName}</code> <b>bisa diakses dari dalam class.</b><br><br>` +
            `Ini adalah satu-satunya tempat yang diizinkan — hanya method di dalam class yang sama boleh membaca atau mengubah atribut ini.<br><br>` +
            `Contoh: method <code>get_${attrName.replace(/^__/,'')}</code> atau <code>set_${attrName.replace(/^__/,'')}</code> berjalan di dalam class, sehingga akses diizinkan.`;
    } else if (ctx === 'subclass') {
      icon='❌'; title='AKSES DITOLAK'; color='var(--rose)'; bg='rgba(255,122,138,.08)'; border='rgba(255,122,138,.4)';
      msg = `Atribut privat <code>${attrName}</code> <b>tidak bisa diakses bahkan dari subclass.</b><br><br>` +
            `Python menerapkan <em>name mangling</em>: atribut disimpan dengan nama yang disamarkan (<code>_NamaClass${attrName}</code>), sehingga subclass pun tidak dapat mengaksesnya secara langsung.<br><br>` +
            `<b>Solusi:</b> Sediakan method getter di class induk, lalu subclass memanggil method tersebut.`;
    } else {
      icon='❌'; title='AKSES DITOLAK'; color='var(--rose)'; bg='rgba(255,122,138,.08)'; border='rgba(255,122,138,.4)';
      msg = `Atribut privat <code>${attrName}</code> <b>tidak bisa diakses dari luar class.</b><br><br>` +
            `Mencoba <code>objek.${attrName}</code> di Python akan menghasilkan:<br>` +
            `<code style="color:var(--rose);">AttributeError: objek tidak memiliki atribut '${attrName}'</code><br><br>` +
            `<b>Cara yang benar:</b> Panggil method getter — misalnya <code>objek.get_${attrName.replace(/^__/,'')}</code> — yang sudah disediakan oleh class.`;
    }
  } else if (vis === 'pro') {
    if (ctx === 'outside') {
      icon='⚠️'; title='TIDAK DISARANKAN'; color='var(--amber)'; bg='rgba(255,180,84,.08)'; border='rgba(255,180,84,.4)';
      msg = `Atribut protected <code>${attrName}</code> secara teknis <em>dapat</em> diakses dari luar, namun <b>sangat tidak disarankan.</b><br><br>` +
            `Awalan <code>_</code> adalah konvensi resmi Python yang menyatakan: "atribut ini hanya untuk class sendiri dan subclass-nya". Mengaksesnya dari luar melanggar prinsip enkapsulasi.<br><br>` +
            `<b>Analogi:</b> Seperti membuka laci pribadi orang lain — secara fisik bisa, tapi bukan hak kita.`;
    } else if (ctx === 'inside') {
      icon='✅'; title='DIIZINKAN'; color='var(--green)'; bg='rgba(126,224,138,.08)'; border='rgba(126,224,138,.4)';
      msg = `Atribut protected <code>${attrName}</code> <b>diizinkan diakses dari dalam class.</b><br><br>` +
            `Semua method di dalam class dapat membaca dan mengubah atribut ini dengan bebas menggunakan <code>self.${attrName}</code>.`;
    } else {
      icon='✅'; title='DIIZINKAN'; color='var(--green)'; bg='rgba(126,224,138,.08)'; border='rgba(126,224,138,.4)';
      msg = `Atribut protected <code>${attrName}</code> <b>diizinkan diakses dari subclass.</b><br><br>` +
            `Ini adalah kegunaan utama atribut protected — memungkinkan class anak mengakses data dari class induk. Method di subclass bisa menggunakan <code>self.${attrName}</code> secara langsung.`;
    }
  } else {
    icon='✅'; title='DIIZINKAN'; color='var(--green)'; bg='rgba(126,224,138,.08)'; border='rgba(126,224,138,.4)';
    const ctxLbl = ctx==='outside'?'luar class':ctx==='inside'?'dalam class':'subclass';
    msg = `Atribut publik <code>${attrName}</code> <b>dapat diakses dari mana saja</b>, termasuk dari ${ctxLbl}.<br><br>` +
          `Atribut tanpa awalan <code>_</code> tidak memiliki batasan. Bisa dibaca dan diubah langsung dengan <code>objek.${attrName}</code> dari mana pun dalam program.`;
  }

  const verdict = title === 'DIIZINKAN' ? 'allowed'
                : title === 'TIDAK DISARANKAN' ? 'caution'
                : 'denied';
  return { icon, title, color, bg, border, msg, verdict };
}

/* ── Langkah 3: buka modal prediksi ── */
function openPredictModal(attrName, vis) {
  const ctxLabels = { outside: 'Luar Class', inside: 'Dalam Class', subclass: 'Subclass' };
  const ctxLabel = ctxLabels[accessCtx];
  document.getElementById('accModalContent').innerHTML = `
    <div style="text-align:center;font-size:30px;line-height:1;margin-bottom:12px;">🤔</div>
    <div style="font-size:14px;font-weight:600;color:var(--text);margin-bottom:6px;">Prediksi dulu!</div>
    <p style="font-size:13px;color:var(--dim);margin-bottom:18px;line-height:1.6;">
      Menurutmu, apakah <code style="font-family:var(--mono);font-size:11.5px;background:rgba(0,0,0,.25);padding:1px 5px;border-radius:3px;">${attrName}</code>
      bisa diakses dari <b>${ctxLabel}</b>?
    </p>
    <div style="display:flex;flex-direction:column;gap:8px;">
      <button class="btn btn-green" style="justify-content:flex-start;" onclick="submitPrediction('${attrName}','${vis}','allowed')">✅ Diizinkan</button>
      <button class="btn" style="justify-content:flex-start;background:rgba(217,119,6,.1);color:var(--amber);border:1px solid rgba(217,119,6,.35);" onclick="submitPrediction('${attrName}','${vis}','caution')">⚠️ Tidak Disarankan</button>
      <button class="btn btn-rose" style="justify-content:flex-start;" onclick="submitPrediction('${attrName}','${vis}','denied')">❌ Akses Ditolak</button>
    </div>
  `;
  document.getElementById('accModal').classList.add('open');
}

/* ── Langkah 4: proses prediksi siswa ── */
function submitPrediction(attrName, vis, predicted) {
  const result  = getAccessVerdict(attrName, vis, accessCtx);
  const isCorrect = predicted === result.verdict;
  const key = `${attrName}|${vis}|${accessCtx}`;

  if (!accessAttempts[key]) {
    accessAttempts[key] = { predicted, actual: result.verdict, correct: isCorrect };
    updateScoreBadge();
  }

  const ctxLabel = accessCtx === 'outside' ? 'Luar Class'
                 : accessCtx === 'inside'   ? 'Dalam Class'
                 : 'Subclass';

  document.getElementById('accModalContent').innerHTML = `
    <div class="acc-predict-banner ${isCorrect ? 'correct' : 'incorrect'}">${isCorrect ? '🎯 Prediksimu TEPAT!' : '🤔 Prediksimu belum tepat'}</div>
    <div style="text-align:center;font-size:38px;line-height:1;margin-bottom:16px;">${result.icon}</div>
    <div class="acc-result-box" style="background:${result.bg};border-color:${result.border};">
      <div class="acc-result-title" style="color:${result.color};">${result.title}</div>
      <div class="acc-result-msg">${result.msg}</div>
    </div>
    <div class="acc-footer-meta">Konteks: <b style="color:var(--dim);">${ctxLabel}</b> &nbsp;·&nbsp; Atribut: <b style="color:var(--dim);">${attrName}</b></div>
  `;

  renderAccessPanel();
}

/* ── Langkah 5: perbarui badge skor ── */
function updateScoreBadge() {
  const all     = Object.values(accessAttempts);
  const correct = all.filter(a => a.correct).length;
  const badge   = document.getElementById('accScoreBadge');
  if (badge) badge.textContent = `Skor Nalar: ${correct}/${all.length} tepat`;
}

function closeAccModal() {
  document.getElementById('accModal').classList.remove('open');
}

/* ══════════════════════════════════════════════════════════════
   UJI PEWARISAN (Pertemuan 2 — konsep inheritance)
   Skenario tetap berdasarkan preset "Karakter Gim RPG". Arsitektur
   identik dengan Uji Access Modifier di atas, state & fungsi terpisah.
══════════════════════════════════════════════════════════════ */
const inheritanceScenarios = [
  { id: 1,
    pertanyaan: "hero1.info() dipanggil — method siapa yang jalan?",
    opsi: [
      { key: 'hero', label: "Method info() milik Hero" },
      { key: 'karakter', label: "Method info() milik Karakter" },
      { key: 'both', label: "Keduanya dijalankan berurutan" }
    ],
    kunci: 'hero',
    penjelasan: "Karena Hero meng-override method info(), Python akan menjalankan versi milik Hero, bukan versi asli dari Karakter. Ini contoh polimorfisme — objek Hero punya perilaku sendiri meski mewarisi dari Karakter."
  },
  { id: 2,
    pertanyaan: "monster1.info() dipanggil — method siapa yang jalan?",
    opsi: [
      { key: 'monster', label: "Method info() milik Monster" },
      { key: 'karakter', label: "Method info() milik Karakter" },
      { key: 'hero', label: "Method info() milik Hero" }
    ],
    kunci: 'monster',
    penjelasan: "Monster juga meng-override info() dengan versinya sendiri (berbeda dari Hero). Setiap subclass bisa punya implementasi override yang berbeda-beda, meski nama method-nya sama."
  },
  { id: 3,
    pertanyaan: "hero1.nama diakses — apakah berhasil, padahal Hero tidak mendefinisikan atribut nama sendiri?",
    opsi: [
      { key: 'berhasil', label: "Berhasil, nilai berasal dari Karakter lewat super().__init__()" },
      { key: 'gagal', label: "Gagal, karena Hero tidak punya atribut nama sendiri" },
      { key: 'error', label: "Error, atribut harus didefinisikan ulang di tiap subclass" }
    ],
    kunci: 'berhasil',
    penjelasan: "Atribut nama dan nyawa didefinisikan di Karakter dan diwariskan ke Hero lewat pemanggilan super().__init__() di constructor Hero — jadi Hero otomatis punya kedua atribut itu tanpa perlu mendefinisikan ulang."
  },
  { id: 4,
    pertanyaan: "Objek Karakter biasa (bukan Hero/Monster) memanggil .info() — apa yang terjadi?",
    opsi: [
      { key: 'asli', label: "Menjalankan info() versi asli milik Karakter, tidak terpengaruh Hero/Monster" },
      { key: 'error', label: "Error, karena Karakter tidak boleh diinstansiasi langsung" },
      { key: 'hero', label: "Menjalankan versi Hero secara default" }
    ],
    kunci: 'asli',
    penjelasan: "Override di subclass (Hero/Monster) tidak mengubah method asli di class induk. Objek Karakter murni tetap menjalankan info() versi aslinya sendiri."
  }
];

let inheritanceAttempts = {};

function renderInheritancePanel() {
  if (window.KONSEP !== 'inheritance') return;
  const container = document.getElementById('inheritanceScenarioList');
  if (!container) return;

  container.innerHTML = inheritanceScenarios.map(s => {
    const sudahDiuji = !!inheritanceAttempts[s.id];
    const checkSpan  = sudahDiuji ? ` <span style="color:var(--green);font-size:11px;vertical-align:middle;font-weight:700;">✓</span>` : '';
    return `
      <div class="access-attr-row">
        <span class="acc-name">${s.pertanyaan}${checkSpan}</span>
        <button class="btn btn-ghost" style="padding:4px 12px;font-size:11.5px;margin-left:auto;" onclick="openInheritanceModal(${s.id})">Uji Prediksimu →</button>
      </div>
    `;
  }).join('');
}

function openInheritanceModal(scenarioId) {
  const s = inheritanceScenarios.find(x => x.id === scenarioId);
  document.getElementById('inheritanceModalContent').innerHTML = `
    <div style="text-align:center;font-size:30px;line-height:1;margin-bottom:12px;">🤔</div>
    <div style="font-size:14px;font-weight:600;color:var(--text);margin-bottom:6px;">Prediksi dulu!</div>
    <p style="font-size:13px;color:var(--dim);margin-bottom:18px;line-height:1.6;">${s.pertanyaan}</p>
    <div style="display:flex;flex-direction:column;gap:8px;">
      ${s.opsi.map(o => `<button class="btn" style="justify-content:flex-start;" onclick="submitInheritancePrediction(${scenarioId},'${o.key}')">${o.label}</button>`).join('')}
    </div>
  `;
  document.getElementById('inheritanceModal').classList.add('open');
}

function submitInheritancePrediction(scenarioId, jawabanDipilih) {
  const s = inheritanceScenarios.find(x => x.id === scenarioId);
  const isCorrect = jawabanDipilih === s.kunci;

  if (!inheritanceAttempts[scenarioId]) {
    inheritanceAttempts[scenarioId] = { jawabanDipilih, isCorrect };
    updateInheritanceScoreBadge();
  }

  document.getElementById('inheritanceModalContent').innerHTML = `
    <div class="acc-predict-banner ${isCorrect ? 'correct' : 'incorrect'}">${isCorrect ? '🎯 Prediksimu TEPAT!' : '🤔 Prediksimu belum tepat — pelajari penjelasannya:'}</div>
    <div class="acc-result-box">
      <div class="acc-result-msg">${s.penjelasan}</div>
    </div>
  `;
  renderInheritancePanel();
}

function updateInheritanceScoreBadge() {
  const vals    = Object.values(inheritanceAttempts);
  const correct = vals.filter(v => v.isCorrect).length;
  const badge   = document.getElementById('inheritanceScoreBadge');
  if (badge) badge.textContent = `Skor Nalar: ${correct}/${vals.length}`;
}

function closeInheritanceModal() {
  document.getElementById('inheritanceModal').classList.remove('open');
}

function showPubWarn(attrName) {
  const modal = document.getElementById('accModal');
  if (!modal) return;
  document.getElementById('accModalContent').innerHTML = `
    <div style="text-align:center;font-size:38px;line-height:1;margin-bottom:16px;">⚠️</div>
    <div class="acc-result-box" style="background:rgba(255,180,84,.08);border-color:rgba(255,180,84,.4);">
      <div class="acc-result-title" style="color:var(--amber);">RISIKO ENKAPSULASI — ATRIBUT PUBLIK</div>
      <div class="acc-result-msg">
        Atribut <code>${attrName}</code> saat ini bersifat <b>publik (+)</b> — siapa saja bisa mengakses dan mengubahnya langsung tanpa melewati method apapun:<br><br>
        <code style="color:var(--rose);">objek.${attrName} = nilai_sembarang  # tidak ada validasi!</code><br><br>
        Untuk data sensitif seperti <b>saldo rekening</b>, hal ini sangat berbahaya. Pengguna bisa mengubah saldo secara bebas tanpa melalui proses validasi di <code>setor()</code> atau <code>tarik()</code>.<br><br>
        <b>💡 Solusi:</b> Ubah ke <b style="color:var(--rose);">− private (<code>__${attrName}</code>)</b> agar hanya bisa diakses dari dalam class melalui method yang aman.
      </div>
    </div>
    <div class="acc-footer-meta">Klik simbol <b style="color:var(--green);">+</b> pada atribut untuk mengubah visibilitas ke <b>#</b> atau <b>−</b></div>
  `;
  modal.classList.add('open');
}

// Close modal on Escape key
document.addEventListener('keydown', e => {
  if (e.key === 'Escape') closeAccModal();
});

/* ══════════════════════════════════════════════════════════════
   PYODIDE — TRACER
══════════════════════════════════════════════════════════════ */
const TRACER = `
import sys, io, json, traceback as _tb, ast as _ast

def _objs(frame):
    skip = {'int','str','float','bool','list','dict','tuple','set','frozenset',
            'NoneType','type','function','module','builtin_function_or_method',
            'method-wrapper','wrapper_descriptor','method_descriptor',
            'classmethod','staticmethod','property','mappingproxy'}
    objs = {}
    scope = {**{k:v for k,v in frame.f_globals.items() if not k.startswith('__')},
             **{k:v for k,v in frame.f_locals.items() if not k.startswith('__')}}
    for name, val in scope.items():
        tp = type(val)
        if tp.__name__ in skip or tp is type or not hasattr(val,'__dict__'): continue
        raw = val.__dict__; clean = {}
        for k, v in raw.items():
            if k.startswith('__'): continue
            disp, priv = k, False
            mangle = '_'+tp.__name__+'__'
            if k.startswith(mangle): disp='__'+k[len(mangle):]; priv=True
            try: clean[disp]={'val':repr(v),'priv':priv,'inh':False}
            except: clean[disp]={'val':'?','priv':priv,'inh':False}
        objs[name]={'type':tp.__name__,'attrs':clean}
    return objs

def _cls(code):
    try:
        tree=_ast.parse(code); out=[]
        for n in tree.body:
            if isinstance(n,_ast.ClassDef):
                bases=[b.id for b in n.bases if isinstance(b,_ast.Name)]
                attrs,meths=[],[]
                for item in n.body:
                    if isinstance(item,_ast.FunctionDef):
                        if item.name!='__init__':
                            meths.append({'name':item.name,'lineno':item.lineno})
                        if item.name=='__init__':
                            for s in _ast.walk(item):
                                if isinstance(s,_ast.Assign):
                                    for t in s.targets:
                                        if isinstance(t,_ast.Attribute) and isinstance(t.value,_ast.Name) and t.value.id=='self':
                                            attrs.append({'name':t.attr,'lineno':s.lineno})
                out.append({'name':n.name,'bases':bases,'attrs':attrs,'meths':meths,'parentId':None,'id':n.name,'lineno':n.lineno})
        return out
    except: return []

def _run(code):
    steps=[]; ci=_cls(code)
    # Mark inherited attrs
    def mark_inh(objs):
        parent_attrs={}
        for c in ci:
            if c['bases']:
                parent_attrs[c['name']]=set()
                for b in c['bases']:
                    for oc in ci:
                        if oc['name']==b:
                            for a in oc['attrs']:
                                            nm=a['name'] if isinstance(a,dict) else a
                                            parent_attrs[c['name']].add(nm.lstrip('_'))
        for obj in objs.values():
            if obj['type'] in parent_attrs:
                for k in obj['attrs']:
                    if k.lstrip('_') in parent_attrs[obj['type']]: obj['attrs'][k]['inh']=True
        return objs
    buf=io.StringIO(); old=sys.stdout; sys.stdout=buf; ns={}; MAX=120
    def tr(frame,event,arg):
        if frame.f_code.co_filename!='<ics>': return tr
        if event=='line':
            if len(steps)>=MAX: raise RuntimeError(f'Batas {MAX} langkah tercapai.')
            o=buf.getvalue(); ob=mark_inh(_objs(frame))
            steps.append({'line':frame.f_lineno,'output':o,'objects':ob,'frame':frame.f_code.co_name,'error':None})
        return tr
    err=None
    try:
        sys.settrace(tr)
        exec(compile(code,'<ics>','exec'),ns)
    except Exception as e:
        o=buf.getvalue(); tbl=_tb.extract_tb(sys.exc_info()[2]); ln=-1
        for f in reversed(tbl):
            if f.filename=='<ics>': ln=f.lineno; break
        err={'line':ln,'output':o,'objects':{},'frame':'<error>','error':type(e).__name__+': '+str(e)}
    finally:
        sys.settrace(None); sys.stdout=old
    if err: steps.append(err)
    elif steps: steps[-1]['output']=buf.getvalue()
    return json.dumps({'steps':steps,'classes':ci})
`;

async function initPy() {
  try {
    pyodide = await loadPyodide();
    await pyodide.runPythonAsync(TRACER);
    const el = document.getElementById('pyStatusGlobal');
    el.textContent = 'Python siap ✓';
    el.className = 'py-status ready';
    document.getElementById('btnJalankan').disabled = false;
  } catch(e) {
    document.getElementById('pyStatusGlobal').textContent = 'Python gagal dimuat';
    console.error(e);
  }
}

/* ══════════════════════════════════════════════════════════════
   RUN SIMULATION
══════════════════════════════════════════════════════════════ */
async function jalankanSimulasi() {
  const code = document.getElementById('codeEditor').value.trim();
  if (!code) return;
  predInitial = document.getElementById('predAwal').value.trim();

  // Validasi server (Laravel)
  const loaderRow = document.getElementById('loaderRow');
  const errDiv = document.getElementById('runError');
  loaderRow.classList.add('show');
  errDiv.style.display = 'none';
  document.getElementById('btnJalankan').disabled = true;
  document.getElementById('loaderMsg').textContent = 'Memeriksa kode...';

  try {
    const resp = await fetch('{{ route("simulasi.jalankan") }}', {
      method: 'POST',
      headers: { 'Content-Type':'application/json', 'X-CSRF-TOKEN': window.CSRF },
      body: JSON.stringify({ kode_python: code })
    });

    if (resp.status === 419) {
      errDiv.innerHTML = '⚠ Sesi kamu sudah berakhir karena terlalu lama tidak aktif. <a href="javascript:location.reload()" style="text-decoration:underline;font-weight:600;">Klik di sini untuk muat ulang halaman</a>, lalu coba lagi (pekerjaanmu yang sudah tersimpan tidak akan hilang).';
      errDiv.style.display = 'block';
      return;
    }

    const check = await resp.json();
    if (!check.boleh) throw new Error(check.pesan);

    document.getElementById('loaderMsg').textContent = 'Mengeksekusi Python...';
    pyodide.globals.set('_ics_code', code);
    const result = await pyodide.runPythonAsync('_run(_ics_code)');
    const data = JSON.parse(result);

    if (!data.steps.length) throw new Error('Tidak ada langkah dihasilkan. Pastikan kode memiliki statement eksekusi (bukan hanya definisi class).');

    traceSteps = data.steps;
    traceClasses = data.classes;
    codeLines = code.split('\n');
    stepIdx = 0; predAnswered = {}; quizIdx = 0;
    const sb=document.getElementById('summaryBox'); if(sb) sb.style.display='none';
    const qb=document.getElementById('quizBox'); if(qb) qb.style.display='none';

    // Build diagramClasses dari traceClasses — simpan lineno per attr/meth
    diagramClasses = traceClasses.map(c => {
      const parent = traceClasses.find(p => (c.bases||[]).includes(p.name));
      const allAttrs = (c.attrs||[]).map(a => {
        const nm = typeof a === 'string' ? a : a.name;
        const ln = typeof a === 'object' ? (a.lineno||9999) : 9999;
        const vis = nm.startsWith('__') ? 'priv' : nm.startsWith('_') ? 'pro' : 'pub';
        return {vis, name: nm.replace(/^__/,'').replace(/^_/,''), type:'', lineno: ln};
      });
      const allMeths = (c.meths||[])
        .filter(m => (typeof m==='string'?m:m.name) !== '__init__')
        .map(m => {
          const nm = typeof m==='string' ? m : m.name;
          const ln = typeof m==='object' ? (m.lineno||9999) : 9999;
          return {vis:'pub', name:nm, params:'', ret:'', lineno: ln};
        });
      return {id:c.name, name:c.name, parentId:parent?parent.name:null, lineno:c.lineno||1, allAttrs, allMeths};
    });

    // Auto predict flags
    const errIdx = traceSteps.findIndex(s=>s.error);
    if (errIdx>0 && !traceSteps[errIdx-1].predict)
      traceSteps[errIdx-1].predict = 'Perhatikan baris berikutnya. Apa yang kamu prediksi akan terjadi?';
    const objIdx = traceSteps.findIndex(s=>Object.keys(s.objects||{}).length>0);
    if (objIdx>0 && !traceSteps[objIdx-1].predict)
      traceSteps[objIdx-1].predict = 'Baris berikutnya akan membuat objek di memori. Atribut apa saja yang akan dimiliki objek tersebut?';

    document.getElementById('simTitle').textContent = 'Simulasi: ' + (traceClasses.map(c=>c.name).join(', ') || 'kode kustom');
    document.getElementById('simSubtitle').textContent = `${traceSteps.length} langkah · Python 3 (Pyodide)`;

    goPhase(3);
    renderSim();
  } catch(e) {
    errDiv.textContent = '⚠ ' + e.message;
    errDiv.style.display = 'block';
  } finally {
    loaderRow.classList.remove('show');
    document.getElementById('btnJalankan').disabled = false;
  }
}

/* ══════════════════════════════════════════════════════════════
   SIMULATION RENDER
══════════════════════════════════════════════════════════════ */
function hlLine(line) {
  let s = line.replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;');
  s = s.replace(/(#.*)$/, m=>`<span style="color:var(--faint);font-style:italic;">${m}</span>`);
  if (s.includes('font-style')) return s;
  s = s.replace(/"[^"]*"|'[^']*'/g, m=>`<span style="color:var(--green);">${m}</span>`);
  s = s.replace(/\b(class|def|self|super|return|pass|import|from|as|try|except|if|else|elif|for|while|in|not|and|or|True|False|None)\b/g,
    m=>`<span style="color:var(--violet);">${m}</span>`);
  s = s.replace(/\b(print|len|range|str|int|float|bool)\b/g,m=>`<span style="color:var(--cyan);">${m}</span>`);
  s = s.replace(/(self\.__\w+)/g,m=>`<span style="color:var(--rose);">${m}</span>`);
  return s;
}

function getActiveConcept(step) {
  if (step.error) return {
    icon:'⚠️', label:'ERROR',
    color:'var(--rose)', bg:'rgba(255,122,138,.08)', border:'rgba(255,122,138,.35)',
    desc:'Python menemukan kesalahan dan menghentikan eksekusi. Periksa baris yang ditandai merah.'
  };
  const raw = (codeLines[step.line-1]||'').trim();
  const fr  = step.frame;

  // ENCAPSULATION — private attribute
  if (raw.match(/self\.__\w+\s*=/)) return {
    icon:'🔒', label:'ENKAPSULASI — Atribut Privat',
    color:'var(--rose)', bg:'rgba(255,122,138,.07)', border:'rgba(255,122,138,.3)',
    desc:`Awalan <code>__</code> menjadikan atribut ini <b>privat</b> — tidak bisa diakses langsung dari luar class. Hanya method di dalam class yang boleh membaca atau mengubahnya.`
  };
  // ENCAPSULATION — protected attribute
  if (raw.match(/self\._\w+\s*=/) && !raw.match(/self\.__/)) return {
    icon:'🛡️', label:'ENKAPSULASI — Atribut Protected',
    color:'#f59e6b', bg:'rgba(245,158,107,.07)', border:'rgba(245,158,107,.3)',
    desc:`Awalan <code>_</code> menandai atribut sebagai <b>protected</b> — boleh diakses dari class sendiri dan subclass, tapi tidak disarankan diakses langsung dari luar.`
  };
  // ENCAPSULATION — getter/setter method
  if (fr && fr !== '<module>' && fr !== '<error>' && fr !== '__init__' && /^(get|set|is|has)/.test(fr)) return {
    icon:'🔐', label:'ENKAPSULASI — Getter / Setter',
    color:'var(--rose)', bg:'rgba(255,122,138,.07)', border:'rgba(255,122,138,.3)',
    desc:`Method <b>${fr}()</b> adalah <em>pintu resmi</em> untuk mengakses atau mengubah data privat. Inilah inti enkapsulasi — data dikontrol melalui method, bukan diakses langsung.`
  };

  // INHERITANCE — class with parent
  if (raw.startsWith('class ') && raw.match(/\(\w+\)/)) {
    const base = raw.match(/\((\w+)\)/)?.[1]||'induk';
    const cn   = raw.replace(/^class\s+/,'').replace(/\s*\(.*/,'').trim();
    return {
      icon:'📐', label:'INHERITANCE — Pewarisan Class',
      color:'var(--violet)', bg:'rgba(167,139,250,.07)', border:'rgba(167,139,250,.3)',
      desc:`<b>${cn}</b> mewarisi semua atribut dan method dari <b>${base}</b>. Tidak perlu menulis ulang — cukup tambahkan atau override yang berbeda saja.`
    };
  }
  // INHERITANCE — super()
  if (raw.includes('super().__init__')) return {
    icon:'⬆️', label:'INHERITANCE — super().__init__()',
    color:'var(--violet)', bg:'rgba(167,139,250,.07)', border:'rgba(167,139,250,.3)',
    desc:`<code>super()</code> memanggil constructor class <b>induk</b> agar atribut yang diwariskan ikut terinisialisasi. Tanpa ini, atribut warisan tidak akan terbentuk.`
  };

  // CONSTRUCTOR
  if (raw.match(/^def\s+__init__/)) return {
    icon:'🔧', label:'CONSTRUCTOR — __init__',
    color:'var(--amber)', bg:'rgba(255,180,84,.07)', border:'rgba(255,180,84,.3)',
    desc:`Constructor dijalankan <em>otomatis</em> setiap objek dibuat. Tugasnya: menyiapkan semua atribut awal agar objek siap digunakan.`
  };
  if (fr === '__init__') return {
    icon:'🔧', label:'CONSTRUCTOR — sedang berjalan',
    color:'var(--amber)', bg:'rgba(255,180,84,.07)', border:'rgba(255,180,84,.3)',
    desc:`Python sedang menginisialisasi objek baru — mengisi atribut satu per satu di dalam <code>__init__</code>. Perhatikan Status Objek berubah tiap langkah.`
  };

  // ENKAPSULASI: direct public attr access from outside (e.g. obj.saldo or obj.saldo = ...)
  if (window.KONSEP === 'enkapsulasi' && fr === '<module>') {
    const pubNames = diagramClasses.flatMap(c => c.allAttrs)
      .filter(a => a.vis === 'pub').map(a => a.name);
    const hit = pubNames.find(n => new RegExp(`\\.${n}\\b`).test(raw));
    if (hit) return {
      icon:'⚠️', label:'RISIKO ENKAPSULASI — Akses Langsung',
      color:'var(--amber)', bg:'rgba(255,180,84,.08)', border:'rgba(255,180,84,.4)',
      desc:`Atribut <code>${hit}</code> bersifat <b>publik</b> dan diakses langsung dari luar class. Siapa saja bisa membaca atau mengubahnya tanpa validasi apapun — ini melanggar prinsip enkapsulasi. Idealnya gunakan method getter/setter sebagai pintu akses yang aman.`
    };
  }

  // OBJECT CREATION
  if (raw.match(/^\w+\s*=\s*\w+\(/) && fr === '<module>') {
    const cn = raw.match(/=\s*(\w+)\(/)?.[1]||'class';
    const vn = raw.split('=')[0].trim();
    return {
      icon:'🏗️', label:'PEMBUATAN OBJEK',
      color:'var(--green)', bg:'rgba(126,224,138,.07)', border:'rgba(126,224,138,.3)',
      desc:`Python mengalokasikan memori dan membuat <em>instance</em> baru dari class <b>${cn}</b>, lalu menyimpan referensinya ke variabel <b>${vn}</b>.`
    };
  }

  // METHOD definition
  if (raw.startsWith('def ') && !raw.match(/^def\s+__/)) {
    const mn = raw.match(/def\s+(\w+)/)?.[1]||'';
    return {
      icon:'⚙️', label:'METHOD — Didefinisikan',
      color:'var(--cyan)', bg:'rgba(106,214,232,.07)', border:'rgba(106,214,232,.3)',
      desc:`Method <b>${mn}()</b> didaftarkan ke dalam class ini. Method adalah <em>perilaku</em> yang bisa dilakukan oleh setiap objek — dipanggil dengan <code>objek.${mn}()</code>.`
    };
  }
  // METHOD running
  if (fr && fr !== '<module>' && fr !== '<error>' && fr !== '__init__') return {
    icon:'⚙️', label:`METHOD — ${fr}() berjalan`,
    color:'var(--cyan)', bg:'rgba(106,214,232,.07)', border:'rgba(106,214,232,.3)',
    desc:`Python sedang mengeksekusi method <b>${fr}()</b> pada objek di memori. Setiap baris di dalam method dijalankan satu per satu.`
  };

  // RETURN
  if (raw.includes('return ')) return {
    icon:'↩️', label:'RETURN — Nilai Dikembalikan',
    color:'var(--dim)', bg:'var(--panel2)', border:'var(--border)',
    desc:`Method mengevaluasi ekspresi lalu mengirim hasilnya kembali ke pemanggil. Setelah ini eksekusi keluar dari method.`
  };

  // OUTPUT
  if (raw.includes('print(')) return {
    icon:'🖨️', label:'OUTPUT — print()',
    color:'var(--faint)', bg:'var(--panel2)', border:'var(--border)',
    desc:`Hasil dicetak ke Console Output. Lihat panel Console di bawah untuk melihat outputnya.`
  };

  // CLASS definition (no parent)
  if (raw.startsWith('class ')) {
    const cn = raw.replace(/^class\s+/,'').replace(/\s*:.*/,'').trim();
    return {
      icon:'📐', label:'DEFINISI CLASS',
      color:'var(--cyan)', bg:'rgba(106,214,232,.07)', border:'rgba(106,214,232,.3)',
      desc:`Python mendaftarkan blueprint <b>${cn}</b> — template yang mendefinisikan struktur dan perilaku objek. Belum ada objek yang dibuat.`
    };
  }

  return null;
}

function narr(step) {
  function b(icon, title, body, badgeLabel='', badgeCls='') {
    const badge = badgeLabel ? `<span class="narr-badge ${badgeCls}">${badgeLabel}</span>` : '';
    return `<div class="narr-title">${icon} ${title} ${badge}</div><hr class="narr-divider"><div class="narr-body">${body}</div>`;
  }
  function esc(s){ return (s||'').replace(/</g,'&lt;').replace(/>/g,'&gt;'); }

  if (step.error) {
    const [et,...rest] = step.error.split(': ');
    const emsg = rest.join(': ');
    let hint = 'Periksa logika kode dan pastikan tipe data, nama variabel, dan pemanggilan method sudah benar.';
    if (et.includes('AttributeError')) {
      const mAttr = emsg.match(/'([^']+)'/g);
      const atName = mAttr ? mAttr[mAttr.length-1] : '';
      hint = `Kamu mencoba mengakses atribut ${atName} yang tidak ada atau bersifat <b>private</b>.<br><br>`+
        `<b>✅ Solusi:</b> Kalau atribut itu private (<code>__nama</code>), gunakan method getter yang disediakan class, bukan akses langsung. `+
        `Contoh: ganti <code>objek.__saldo</code> dengan <code>objek.get_saldo()</code>.`;
    } else if (et.includes('NameError')) {
      const mName = emsg.match(/'([^']+)'/);
      hint = `Variabel atau fungsi <code>${mName?mName[1]:'?'}</code> belum didefinisikan saat Python mencoba menggunakannya.<br><br>`+
        `<b>✅ Solusi:</b> Pastikan variabel sudah diinisialisasi sebelum digunakan, dan perhatikan huruf besar/kecil (Python <em>case-sensitive</em>).`;
    } else if (et.includes('TypeError')) {
      hint = `Tipe data tidak cocok dengan yang diharapkan.<br><br>`+
        `<b>✅ Solusi:</b> Cek tipe data yang dikirim ke fungsi. Mungkin perlu konversi: <code>int(x)</code>, <code>str(x)</code>, atau <code>float(x)</code>. `+
        `Juga pastikan jumlah argumen yang dikirim sesuai dengan parameter method.`;
    } else if (et.includes('IndentationError')) {
      hint = `Indentasi (spasi di awal baris) tidak konsisten.<br><br>`+
        `<b>✅ Solusi:</b> Pastikan setiap blok kode menggunakan indentasi yang sama — pilih salah satu: 4 spasi atau 1 tab, jangan dicampur.`;
    } else if (et.includes('SyntaxError')) {
      hint = `Python tidak bisa membaca sintaks kode ini.<br><br>`+
        `<b>✅ Solusi:</b> Periksa tanda kurung yang tidak tutup, titik dua (<code>:</code>) yang hilang di akhir <code>def</code>/<code>class</code>/<code>if</code>, atau tanda kutip yang tidak berpasangan.`;
    } else if (et.includes('ValueError')) {
      hint = `Nilai yang diberikan tidak valid untuk operasi ini.<br><br>`+
        `<b>✅ Solusi:</b> Periksa nilai yang dikirim ke fungsi — mungkin di luar rentang yang diizinkan atau format tidak sesuai.`;
    } else if (et.includes('ZeroDivisionError')) {
      hint = `Kamu mencoba membagi angka dengan nol.<br><br>`+
        `<b>✅ Solusi:</b> Tambahkan pengecekan: <code>if pembagi != 0:</code> sebelum melakukan operasi bagi.`;
    }
    return b('⚠', `<span style="color:var(--rose)">${et}</span>`,
      `<b>Pesan error:</b> <code style="color:var(--rose)">${esc(emsg)}</code><br><br>${hint}`,
      'ERROR', 'enc');
  }

  const raw = (codeLines[step.line-1]||'').trim();
  const fr = step.frame;
  if (!raw) return b('→', `Baris ${step.line}`, 'Python berada di baris ini (baris kosong atau komentar).');

  // class X:
  if (raw.startsWith('class ') && !raw.startsWith('class ') === false) {
    const cn = raw.replace(/^class\s+/,'').replace(/\s*:.*/,'').replace(/\(.*\)/,'').trim();
    const base = raw.match(/\((\w+)\)/)?.[1];
    if (base) {
      return b('📐', `Mendefinisikan class <b>${cn}</b> (mewarisi <b>${base}</b>)`,
        `Python membaca blueprint baru bernama <b>${cn}</b>.<br><br>`+
        `Karena ditulis <code>${cn}(${base})</code>, class ini menggunakan <b>inheritance (pewarisan)</b> — `+
        `<b>${cn}</b> secara otomatis mewarisi semua atribut dan method dari <b>${base}</b>, `+
        `dan bisa menambahkan atau menimpa (override) method-nya sendiri.<br><br>`+
        `<b>💡 Analogi:</b> Seperti "Kucing" adalah jenis khusus dari "Hewan" — punya semua sifat hewan, ditambah ciri khas kucing.`,
        'Inheritance', 'inh');
    }
    return b('📐', `Mendefinisikan class <b>${cn}</b>`,
      `Python membaca deklarasi <code>class ${cn}:</code> sebagai <b>blueprint</b> untuk membuat objek.<br><br>`+
      `Pada langkah ini, Python <em>hanya mendaftarkan</em> nama class — belum ada objek yang dibuat. `+
      `Class mendefinisikan <b>struktur</b> (atribut apa yang dimiliki) dan <b>perilaku</b> (method apa yang bisa dilakukan) dari setiap objek yang nanti dibuat.<br><br>`+
      `<b>💡 Analogi:</b> Class seperti cetakan kue — cetakannya ada, tapi kuenya belum dibuat.`,
      'Class', 'class');
  }

  // def __init__
  if (raw.match(/^def\s+__init__/)) {
    const params = raw.match(/\(([^)]+)\)/)?.[1]||'';
    const paramList = params.split(',').map(p=>p.trim()).filter(p=>p && p!=='self').join(', ');
    return b('🔧', `Mendefinisikan constructor <b>__init__</b>`,
      `<code>__init__</code> adalah method khusus yang dijalankan <em>secara otomatis</em> setiap kali objek baru dibuat dari class ini.<br><br>`+
      `<b>Parameter yang dibutuhkan:</b> <code>${paramList||'(tidak ada)'}</code><br>`+
      `<code>self</code> merujuk ke objek itu sendiri dan tidak perlu diisi saat memanggil — Python mengisinya otomatis.<br><br>`+
      `<b>💡 Fungsi:</b> Constructor bertugas menyiapkan semua atribut awal objek saat pertama kali dibuat.`,
      'Constructor', 'meth');
  }

  // def method
  if (raw.startsWith('def ')) {
    const mn = raw.match(/def\s+(\w+)/)?.[1]||'';
    const params = raw.match(/\(([^)]+)\)/)?.[1]||'';
    const paramList = params.split(',').map(p=>p.trim()).filter(p=>p && p!=='self').join(', ')||'tidak ada';
    const retType = raw.match(/->\s*(\w+)/)?.[1]||'';
    return b('⚙️', `Mendefinisikan method <b>${mn}()</b>`,
      `Python mendaftarkan method <b>${mn}</b> ke dalam class ini.<br><br>`+
      `<b>Parameter tambahan:</b> ${paramList}<br>`+
      (retType ? `<b>Tipe nilai kembali:</b> <code>${retType}</code><br><br>` : '<br>')+
      `Body method <em>belum dijalankan</em> sekarang — hanya didaftarkan. Method ini akan dieksekusi nanti saat dipanggil pada sebuah objek dengan <code>objek.${mn}()</code>.`,
      'Method', 'meth');
  }

  // super().__init__
  if (raw.includes('super().__init__')) {
    const args = raw.match(/super\(\)\.__init__\(([^)]*)\)/)?.[1]||'';
    const parentCls = diagramClasses.find(c => diagramClasses.some(child => child.parentId === c.name))?.name || 'class induk';
    return b('⬆️', `Memanggil constructor class induk via <b>super()</b>`,
      `<code>super().__init__(${args})</code> memanggil constructor milik class induk.<br><br>`+
      `Python <em>berpindah eksekusi</em> ke <b>${parentCls}</b> untuk menyiapkan atribut yang diwariskan. `+
      `Nilai <code>${args}</code> diteruskan sebagai argumen ke constructor induk.<br><br>`+
      `<b>💡 Mengapa perlu super()?</b> Tanpa ini, atribut yang didefinisikan di class induk tidak akan terinisialisasi — objek tidak akan punya atribut warisan.`,
      'Inheritance', 'inh');
  }

  // self.__attr (private)
  if (raw.match(/self\.__\w+\s*=/)) {
    const attr = raw.match(/self\.(_{2}\w+)/)?.[1]||'';
    const val = raw.split('=').slice(1).join('=').trim();
    return b('🔒', `Menyimpan atribut privat <b>${attr}</b>`,
      `<code>self.${attr} = ${esc(val)}</code><br><br>`+
      `Awalan <code>__</code> (double underscore) membuat atribut ini <b>privat (private)</b> — hanya bisa diakses dari dalam class, tidak bisa diakses langsung dari luar.<br><br>`+
      `Python secara internal menyimpannya dengan nama yang diubah (<em>name mangling</em>) menjadi <code>_${fr}${attr}</code> untuk mencegah akses dari luar.<br><br>`+
      `<b>💡 Tujuan:</b> Melindungi data sensitif agar tidak bisa diubah sembarangan dari luar class.`,
      'Encapsulation', 'enc');
  }

  // self._attr (protected)
  if (raw.match(/self\._\w+\s*=/) && !raw.match(/self\.__/)) {
    const attr = raw.match(/self\.(_\w+)/)?.[1]||'';
    const val = raw.split('=').slice(1).join('=').trim();
    return b('🛡️', `Menyimpan atribut protected <b>${attr}</b>`,
      `<code>self.${attr} = ${esc(val)}</code><br><br>`+
      `Awalan <code>_</code> (single underscore) menandai atribut ini sebagai <b>protected</b> — `+
      `secara konvensi boleh diakses dari class sendiri dan subclass-nya, tapi sebaiknya tidak diakses langsung dari luar.<br><br>`+
      `Nilai <b>${esc(val)}</b> kini tersimpan di objek. Cek panel <em>Status Objek</em> — atribut ini akan tampil dengan label <em>diwariskan</em> jika berasal dari class induk.`,
      'Encapsulation', 'enc');
  }

  // self.attr (public)
  if (raw.match(/self\.\w+\s*=/)) {
    const attr = raw.match(/self\.(\w+)/)?.[1]||'';
    const val = raw.split('=').slice(1).join('=').trim();
    return b('📦', `Menyimpan atribut <b>${attr}</b> ke objek`,
      `<code>self.${attr} = ${esc(val)}</code><br><br>`+
      `Nilai <b>${esc(val)}</b> disimpan sebagai atribut <b>publik</b> pada objek ini. `+
      `Atribut publik bisa diakses dari mana saja dengan <code>objek.${attr}</code>.<br><br>`+
      `<b>💡 Catatan:</b> Setiap objek punya salinan atributnya sendiri di memori — objek lain yang dibuat dari class yang sama akan memiliki nilai <code>${attr}</code> yang berbeda.`,
      'Atribut', 'obj');
  }

  // ENKAPSULASI: public attr direct access from outside
  if (window.KONSEP === 'enkapsulasi' && fr === '<module>') {
    const pubNames = diagramClasses.flatMap(c => c.allAttrs)
      .filter(a => a.vis === 'pub').map(a => a.name);
    const hit = pubNames.find(n => new RegExp(`\\.${n}\\b`).test(raw));
    if (hit) {
      const isWrite = raw.includes(`${hit} =`) || raw.includes(`${hit}=`);
      return b('⚠️', `Akses langsung ke atribut publik <b>${hit}</b>`,
        `<code>${esc(raw)}</code><br><br>`+
        `Karena <code>${hit}</code> bersifat <b>publik</b>, Python mengizinkan akses ini — tidak ada error yang muncul. `+
        `Namun ini adalah <b>kelemahan enkapsulasi</b>: `+
        (isWrite
          ? `nilai bisa diubah langsung dari luar class tanpa melewati validasi apapun di method <code>setor()</code> atau <code>tarik()</code>.`
          : `nilainya bisa dibaca langsung tanpa melewati method getter.`)+
        `<br><br><b>💡 Bandingkan:</b> Jika <code>${hit}</code> dibuat private (<code>__${hit}</code>), baris ini akan menghasilkan <code style="color:var(--rose);">AttributeError</code> dan memaksa penggunaan method yang aman.`,
        'Risiko Enkapsulasi', 'enc');
    }
  }

  // variable = Class(...)
  if (raw.match(/^\w+\s*=\s*\w+\(/) && fr==='<module>') {
    const vn = raw.split('=')[0].trim();
    const cn = raw.match(/=\s*(\w+)\(/)?.[1]||'';
    const args = raw.match(/\(([^)]*)\)/)?.[1]||'';
    return b('🏗️', `Membuat objek baru dari class <b>${cn}</b>`,
      `<code>${vn} = ${cn}(${args})</code><br><br>`+
      `Python mengalokasikan ruang memori untuk objek baru, kemudian secara otomatis memanggil <code>${cn}.__init__(${args})</code>.<br><br>`+
      `<b>Argumen yang diberikan:</b> <code>${args}</code><br>`+
      `<b>Variabel penyimpan:</b> <code>${vn}</code> → menyimpan <em>referensi</em> ke objek di memori<br><br>`+
      `Langkah-langkah berikutnya akan menunjukkan proses constructor berjalan satu per satu.`,
      'Objek', 'obj');
  }

  // return
  if (raw.includes('return ')) {
    const retExpr = raw.replace(/^\s*return\s*/,'');
    return b('↩️', `Method <b>${fr}()</b> mengembalikan nilai`,
      `<code>return ${esc(retExpr)}</code><br><br>`+
      `Python mengevaluasi ekspresi di atas menggunakan nilai atribut objek saat ini, `+
      `lalu <em>mengirim hasilnya kembali</em> ke tempat method ini dipanggil.<br><br>`+
      `Setelah <code>return</code>, eksekusi keluar dari method <b>${fr}</b> dan melanjutkan di baris pemanggil.`,
      'Return', 'meth');
  }

  // print
  if (raw.includes('print(')) {
    const arg = raw.match(/print\((.+)\)/)?.[1]||'';
    return b('🖨️', `Menampilkan output ke console`,
      `<code>print(${esc(arg)})</code><br><br>`+
      `Python mengevaluasi argumen <code>${esc(arg)}</code> terlebih dahulu `+
      `(termasuk memanggil method jika ada), kemudian hasilnya dicetak ke <em>Console Output</em>.<br><br>`+
      `Lihat panel Console Output di bawah — hasil akan muncul di sini setelah langkah ini selesai.`,
      'Output', 'out');
  }

  // inside method
  if (fr && fr!=='<module>' && fr!=='<error>') {
    return b('→', `Eksekusi di dalam method <b>${fr}()</b>`,
      `Baris aktif: <code>${esc(raw)}</code><br><br>`+
      `Python sedang menjalankan perintah ini di dalam method <b>${fr}</b>.`,
      '', '');
  }

  return b('→', `Python mengeksekusi baris ${step.line}`,
    `<code>${esc(raw)}</code>`, '', '');
}

function renderSim() {
  const step = traceSteps[stepIdx];
  const isLast = stepIdx===traceSteps.length-1;

  // Code viewer
  const viewer = document.getElementById('codeViewer');
  viewer.innerHTML = '';
  codeLines.forEach((line,i) => {
    const div=document.createElement('div');
    const isA=(i+1)===step.line, isE=step.error&&isA;
    div.className='cl'+(isE?' error-line':isA?' active':'');
    div.innerHTML=`<span class="ln">${i+1}</span><span class="ct">${hlLine(line)||'&nbsp;'}</span>`;
    viewer.appendChild(div);
  });
  const ae=viewer.querySelector('.active,.error-line');
  if(ae) ae.scrollIntoView({block:'nearest',behavior:'smooth'});

  // Frame badge
  document.getElementById('frameBadge').textContent=step.frame==='<module>'?'modul':step.frame==='<error>'?'error':step.frame+'()';

  // Objects
  const obBody=document.getElementById('objBody');
  const objs=step.objects||{};
  const names=Object.keys(objs);
  if(!names.length){obBody.innerHTML='<div style="font-family:var(--mono);font-size:12px;color:var(--faint);border:1px dashed var(--border);border-radius:8px;padding:16px;text-align:center;">Belum ada objek di memori</div>';}
  else{
    obBody.innerHTML='';
    const row=document.createElement('div');
    row.style.cssText='display:flex;flex-wrap:wrap;gap:10px;';
    names.forEach(name=>{
      const obj=objs[name];
      const card=document.createElement('div');
      card.className='obj-card';
      if(step.error)card.style.borderColor='var(--rose)';
      let rows='';
      Object.entries(obj.attrs||{}).forEach(([k,v])=>{
        const lock=v.priv?'<span class="pbadge">privat</span>':'';
        const inh=v.inh?'<span class="ibadge">diwariskan</span>':'';
        rows+=`<div class="arow"><span class="akey">${escHtml(k)} ${lock}${inh}</span><span class="aval">${escHtml(v.val)}</span></div>`;
      });
      if(!rows)rows='<div class="arow"><span class="akey" style="color:var(--faint)">(kosong)</span></div>';
      card.innerHTML=`<div class="obj-title">${escHtml(name)} <span class="oty">: ${escHtml(obj.type)}</span></div>${rows}`;
      row.appendChild(card);
    });
    obBody.appendChild(row);
  }

  // Console
  const con=document.getElementById('consBody');
  const out=(step.output||'').trimEnd();
  const err=step.error||'';
  if(!out&&!err){con.innerHTML='<div class="cempty">(belum ada output)</div>';}
  else{
    con.innerHTML='';
    if(out) out.split('\n').forEach(l=>{const d=document.createElement('div');d.className='cline cok';d.textContent='> '+l;con.appendChild(d);});
    if(err){const d=document.createElement('div');d.className='cline cerr';d.textContent='✕ '+err;con.appendChild(d);}
  }

  // Concept indicator
  const concept = getActiveConcept(step);
  const cb = document.getElementById('conceptBox');
  if (concept) {
    cb.style.display = 'block';
    cb.style.background = concept.bg;
    cb.style.borderColor = concept.border;
    cb.innerHTML = `<div class="ci-row">
      <span class="ci-icon">${concept.icon}</span>
      <div>
        <div class="ci-label" style="color:${concept.color}">${concept.label}</div>
        <div class="ci-desc">${concept.desc}</div>
      </div>
    </div>`;
  } else {
    cb.style.display = 'none';
  }

  // Narration
  document.getElementById('narr').innerHTML=narr(step);

  // Update diagram per langkah: class muncul progresif, attr/meth muncul sesuai baris
  if (diagramClasses.length) {
    const seen = diagramClasses
      .filter(c => c.lineno <= step.line)
      .map(c => ({
        ...c,
        attrs: c.allAttrs.filter(a => a.lineno <= step.line),
        meths: c.allMeths.filter(m => m.lineno <= step.line)
      }));
    const activeClass = diagramClasses.find(c =>
      step.frame && step.frame !== '<module>' && step.frame !== '<error>' &&
      c.allMeths.some(m => m.name === step.frame)
    );
    document.getElementById('simDiagSvg').innerHTML = buildDiagramSVG(seen, activeClass ? activeClass.name : '');
  }

  // Predict
  const pkey='s'+stepIdx;
  const pb=document.getElementById('predSimBox');
  if(step.predict&&!predAnswered[pkey]){
    pb.style.display='block';
    document.getElementById('predSimQ').textContent=step.predict;
    document.getElementById('predSimIn').value='';
    document.getElementById('predSimResult').style.display='none';
  } else pb.style.display='none';

  // Reflect
  const rb=document.getElementById('reflBox');
  if(isLast){
    showEndCards();
    muatRefleksiTersimpan();
    rb.style.display='block';
    const hasErr=traceSteps.some(s=>s.error);
    const hasInh=traceSteps.some(s=>Object.values(s.objects||{}).some(o=>Object.values(o.attrs||{}).some(a=>a.inh)));
    const hasPriv=traceSteps.some(s=>Object.values(s.objects||{}).some(o=>Object.values(o.attrs||{}).some(a=>a.priv)));
    let rq='Apa yang paling kamu pelajari dari simulasi ini?';
    if(hasInh) rq='Bagaimana mekanisme pewarisan (inheritance) bekerja dalam simulasi ini? Apa yang berubah dari pemahamanmu sebelumnya?';
    if(hasPriv) rq='Mengapa Python memiliki konsep atribut privat (__)? Berikan argumenmu berdasarkan apa yang kamu amati.';
    if(hasErr) rq='Error yang terjadi dalam simulasi ini mengajarkan apa tentang cara Python menjaga aturan akses atribut?';
    document.getElementById('reflQ').textContent=rq;
  } else rb.style.display='none';

  // Timeline
  const tl=document.getElementById('tl');
  tl.innerHTML='';
  traceSteps.forEach((s,i)=>{
    const n=document.createElement('div');
    n.className='tn'+(i<stepIdx?' done':'')+(i===stepIdx?' cur':'')+(s.error?' err':'');
    n.title=`Langkah ${i+1}${s.error?' (error)':''}`;
    n.onclick=()=>{stepIdx=i;renderSim();};
    tl.appendChild(n);
    if(i<traceSteps.length-1){const l=document.createElement('div');l.className='tl-line'+(i<stepIdx?' done':'');tl.appendChild(l);}
  });

  // Controls
  document.getElementById('btnPrev').disabled=stepIdx===0;
  document.getElementById('btnNext').disabled=stepIdx===traceSteps.length-1;
  const fn=document.getElementById('floatNext');
  const fp=document.getElementById('floatPrev');
  if(fn) fn.disabled=stepIdx===traceSteps.length-1;
  if(fp) fp.disabled=stepIdx===0;
  document.getElementById('stepInfo').textContent=`Langkah ${stepIdx+1} / ${traceSteps.length}`;

  // Floating "Lanjut ke Fase berikutnya" — show only at last step when route is set
  const fl=document.getElementById('floatLanjut');
  const flLabel=document.getElementById('floatLanjutLabel');
  if(fl){
    const atEnd=isLast&&!!window.NEXT_FASE_ROUTE;
    fl.style.display=atEnd?'flex':'none';
    if(flLabel&&window.NEXT_FASE_LABEL) flLabel.textContent=window.NEXT_FASE_LABEL;
  }
}

function checkPred(){
  const key='s'+stepIdx;
  const val=document.getElementById('predSimIn').value.trim()||'(tidak diisi)';
  predAnswered[key]=val;
  const res=document.getElementById('predSimResult');
  res.innerHTML=`<span style="color:var(--faint);">Prediksimu:</span> <span style="color:var(--text);">${escHtml(val)}</span><br><span style="color:var(--faint);">→ Tekan › untuk melihat apa yang terjadi.</span>`;
  res.style.display='block';
}

function resetSim(){stepIdx=0;renderSim();}
function simpanRefleksi(){
  const val = document.getElementById('reflIn').value.trim();
  if (!val) { window.showToast('Tulis refleksimu terlebih dahulu.', 'error'); return; }
  const key = 'ics_refl_' + window.KONSEP;
  localStorage.setItem(key, val);
  window.showToast('Refleksi tersimpan ✓ — tetap ada walau halaman di-refresh.', 'success');
}

function muatRefleksiTersimpan(){
  const val = localStorage.getItem('ics_refl_' + window.KONSEP);
  if (val) document.getElementById('reflIn').value = val;
}

// Keyboard nav
document.addEventListener('keydown',e=>{
  if(!document.getElementById('phase3') || document.getElementById('phase3').style.display==='none') return;
  if(e.target.tagName==='INPUT'||e.target.tagName==='TEXTAREA') return;
  if(e.key==='ArrowRight') document.getElementById('btnNext').click();
  if(e.key==='ArrowLeft') document.getElementById('btnPrev').click();
});

document.getElementById('btnPrev').onclick=()=>{if(stepIdx>0){stepIdx--;renderSim();}};
document.getElementById('btnNext').onclick=()=>{if(stepIdx<traceSteps.length-1){stepIdx++;renderSim();}};

// Toggle diagram in sim
document.getElementById('btnToggleDiag').onclick=function(){
  diagVisible=!diagVisible;
  document.getElementById('simDiagBody').style.display=diagVisible?'':'none';
  this.textContent=diagVisible?'Sembunyikan':'Tampilkan';
};

/* ══════════════════════════════════════════════════════════════
   BOOT
══════════════════════════════════════════════════════════════ */
/* ══════════════════════════════════════════════════════════════
   PRESETS DATA
══════════════════════════════════════════════════════════════ */
const PRESETS = {
  enkapsulasi:[
    { id:'bank', icon:'🏦', title:'Rekening Bank', desc:'Saldo dilindungi private, akses hanya lewat getter & setter',
      clsDefs:[{name:'BankAccount',parentId:null,
        attrs:[{vis:'pro',name:'pemilik',type:'str'},{vis:'priv',name:'saldo',type:'float'}],
        meths:[{vis:'pub',name:'get_saldo',params:'',ret:'float'},{vis:'pub',name:'setor',params:'jumlah',ret:''},{vis:'pub',name:'tarik',params:'jumlah',ret:''}]}],
      code:['class BankAccount:','    def __init__(self, pemilik, saldo_awal):','        self._pemilik = pemilik','        self.__saldo = saldo_awal','','    def get_saldo(self):','        return self.__saldo','','    def setor(self, jumlah):','        if jumlah > 0:','            self.__saldo += jumlah','            print("Setor berhasil. Saldo:", self.__saldo)','','    def tarik(self, jumlah):','        if jumlah > self.__saldo:','            print("Saldo tidak mencukupi!")','        else:','            self.__saldo -= jumlah','            print("Tarik berhasil. Saldo:", self.__saldo)','','# Contoh penggunaan','akun = BankAccount("Alissa", 1000000)','akun.setor(500000)','akun.tarik(200000)','print(akun.get_saldo())'].join('\n')
    },
    { id:'mhs', icon:'🎓', title:'Data Mahasiswa', desc:'NIM bersifat private, nilai protected dengan validasi setter',
      clsDefs:[{name:'Mahasiswa',parentId:null,
        attrs:[{vis:'pub',name:'nama',type:'str'},{vis:'priv',name:'nim',type:'str'},{vis:'pro',name:'nilai',type:'float'}],
        meths:[{vis:'pub',name:'get_nim',params:'',ret:'str'},{vis:'pub',name:'get_nilai',params:'',ret:'float'},{vis:'pub',name:'set_nilai',params:'nilai_baru',ret:''}]}],
      code:['class Mahasiswa:','    def __init__(self, nama, nim, nilai):','        self.nama = nama','        self.__nim = nim','        self._nilai = nilai','','    def get_nim(self):','        return self.__nim','','    def get_nilai(self):','        return self._nilai','','    def set_nilai(self, nilai_baru):','        if 0 <= nilai_baru <= 100:','            self._nilai = nilai_baru','            print("Nilai diperbarui:", self._nilai)','        else:','            print("Nilai harus antara 0 dan 100!")','','# Contoh penggunaan','mhs = Mahasiswa("Budi", "2024001", 75)','print(mhs.get_nim())','mhs.set_nilai(85)','print(mhs.get_nilai())'].join('\n')
    },
    { id:'akun', icon:'🔑', title:'Akun Pengguna', desc:'Password private, hanya bisa dicek atau diganti via method',
      clsDefs:[{name:'AkunUser',parentId:null,
        attrs:[{vis:'pub',name:'username',type:'str'},{vis:'priv',name:'password',type:'str'}],
        meths:[{vis:'pub',name:'cek_password',params:'input_pw',ret:''},{vis:'pub',name:'ganti_password',params:'pw_lama, pw_baru',ret:''}]}],
      code:['class AkunUser:','    def __init__(self, username, password):','        self.username = username','        self.__password = password','','    def cek_password(self, input_pw):','        if input_pw == self.__password:','            print("Password benar! Login berhasil.")','        else:','            print("Password salah! Akses ditolak.")','','    def ganti_password(self, pw_lama, pw_baru):','        if pw_lama == self.__password:','            self.__password = pw_baru','            print("Password berhasil diganti.")','        else:','            print("Password lama tidak cocok!")','','# Contoh penggunaan','user = AkunUser("alissa123", "rahasia99")','user.cek_password("salah123")','user.cek_password("rahasia99")','user.ganti_password("rahasia99", "passwordbaru")'].join('\n')
    }
  ],
  inheritance:[
    { id:'rpg_character', icon:'🎮', title:'Karakter Gim RPG', featured:true,
      desc:'Praktekkan Inheritance! Buat class Karakter, lalu wariskan ke Hero dan Monster.',
      clsDefs:[
        {name:'Karakter', parentId:null,
          attrs:[{vis:'pub',name:'nama',type:'str'},{vis:'pub',name:'nyawa',type:'int'}],
          meths:[{vis:'pub',name:'info',params:'',ret:''}]},
        {name:'Hero', parentId:'__ref_Karakter',
          attrs:[{vis:'pub',name:'energi_sihir',type:'int'}],
          meths:[{vis:'pub',name:'info',params:'',ret:''}]},
        {name:'Monster', parentId:'__ref_Karakter',
          attrs:[{vis:'pub',name:'elemen_serangan',type:'str'}],
          meths:[{vis:'pub',name:'info',params:'',ret:''}]}
      ],
      code:['class Karakter:',
            '    def __init__(self, nama, nyawa):',
            '        self.nama = nama',
            '        self.nyawa = nyawa',
            '',
            '    def info(self):',
            '        print(self.nama, "- HP:", self.nyawa)',
            '',
            'class Hero(Karakter):',
            '    def __init__(self, nama, nyawa, energi_sihir):',
            '        super().__init__(nama, nyawa)',
            '        self.energi_sihir = energi_sihir',
            '',
            '    def info(self):',
            '        print("Hero:", self.nama, "| HP:", self.nyawa, "| Mana:", self.energi_sihir)',
            '',
            'class Monster(Karakter):',
            '    def __init__(self, nama, nyawa, elemen_serangan):',
            '        super().__init__(nama, nyawa)',
            '        self.elemen_serangan = elemen_serangan',
            '',
            '    def info(self):',
            '        print("Monster:", self.nama, "| HP:", self.nyawa, "| Elemen:", self.elemen_serangan)',
            '',
            '# Contoh penggunaan',
            'hero1    = Hero("Aragorn", 100, 50)',
            'monster1 = Monster("Naga Api", 200, "api")',
            'hero1.info()',
            'monster1.info()'].join('\n')
    },
    { id:'hewan', icon:'🐾', title:'Hewan → Kucing', desc:'Kucing mewarisi Hewan dan override method bersuara()',
      clsDefs:[
        {name:'Hewan',parentId:null,attrs:[{vis:'pub',name:'nama',type:'str'},{vis:'pub',name:'suara',type:'str'}],meths:[{vis:'pub',name:'bersuara',params:'',ret:''}]},
        {name:'Kucing',parentId:'__ref_Hewan',attrs:[{vis:'pub',name:'warna',type:'str'}],meths:[{vis:'pub',name:'bersuara',params:'',ret:''}]}],
      code:['class Hewan:','    def __init__(self, nama, suara):','        self.nama = nama','        self.suara = suara','','    def bersuara(self):','        print(self.nama, "bersuara:", self.suara)','','class Kucing(Hewan):','    def __init__(self, nama, warna):','        super().__init__(nama, "Meow")','        self.warna = warna','','    def bersuara(self):','        print("Kucing", self.nama, "berwarna", self.warna, "bersuara: Meow!")','','# Contoh penggunaan','kucing1 = Kucing("Mimi", "putih")','kucing1.bersuara()'].join('\n')
    },
    { id:'kendaraan', icon:'🚗', title:'Kendaraan → Mobil', desc:'Mobil mewarisi Kendaraan dan menambah atribut jumlah_pintu',
      clsDefs:[
        {name:'Kendaraan',parentId:null,attrs:[{vis:'pub',name:'merek',type:'str'},{vis:'pub',name:'tahun',type:'int'}],meths:[{vis:'pub',name:'info',params:'',ret:''}]},
        {name:'Mobil',parentId:'__ref_Kendaraan',attrs:[{vis:'pub',name:'jumlah_pintu',type:'int'}],meths:[{vis:'pub',name:'info',params:'',ret:''}]}],
      code:['class Kendaraan:','    def __init__(self, merek, tahun):','        self.merek = merek','        self.tahun = tahun','','    def info(self):','        print("Kendaraan:", self.merek, "("+str(self.tahun)+")")','','class Mobil(Kendaraan):','    def __init__(self, merek, tahun, jumlah_pintu):','        super().__init__(merek, tahun)','        self.jumlah_pintu = jumlah_pintu','','    def info(self):','        print("Mobil:", self.merek, "("+str(self.tahun)+") -", self.jumlah_pintu, "pintu")','','# Contoh penggunaan','mobil1 = Mobil("Toyota", 2023, 4)','mobil1.info()'].join('\n')
    },
    { id:'pegawai', icon:'👔', title:'Pegawai → Manager', desc:'Manager mewarisi gaji protected dan override info()',
      clsDefs:[
        {name:'Pegawai',parentId:null,attrs:[{vis:'pub',name:'nama',type:'str'},{vis:'pro',name:'gaji',type:'int'}],meths:[{vis:'pub',name:'info',params:'',ret:''}]},
        {name:'Manager',parentId:'__ref_Pegawai',attrs:[{vis:'pub',name:'divisi',type:'str'}],meths:[{vis:'pub',name:'info',params:'',ret:''}]}],
      code:['class Pegawai:','    def __init__(self, nama, gaji):','        self.nama = nama','        self._gaji = gaji','','    def info(self):','        print("Pegawai:", self.nama, "- Gaji:", self._gaji)','','class Manager(Pegawai):','    def __init__(self, nama, gaji, divisi):','        super().__init__(nama, gaji)','        self.divisi = divisi','','    def info(self):','        print("Manager:", self.nama, "| Divisi:", self.divisi, "| Gaji:", self._gaji)','','# Contoh penggunaan','mgr = Manager("Siti", 15000000, "Teknologi")','mgr.info()'].join('\n')
    }
  ],

  /* ── Pertemuan 3: Enkapsulasi + Inheritance ─────────────────── */
  gabungan:[
    { id:'school_management', icon:'🏫', title:'Sistem Akun Sekolah', featured:true,
      desc:'Proyek Akhir! Buat class AkunSekolah dengan private __password & getter/setter. Lalu wariskan ke class Guru dan Siswa.',
      clsDefs:[
        { name:'AkunSekolah', parentId:null,
          attrs:[
            {vis:'pub',  name:'nama',     type:'str'},
            {vis:'priv', name:'password', type:'str'}
          ],
          meths:[
            {vis:'pub', name:'get_password', params:'',            ret:'str'},
            {vis:'pub', name:'set_password', params:'password_baru', ret:''},
            {vis:'pub', name:'login',        params:'input_pw',    ret:''}
          ]
        },
        { name:'Guru', parentId:'__ref_AkunSekolah',
          attrs:[{vis:'pub', name:'mata_pelajaran', type:'str'}],
          meths:[{vis:'pub', name:'info', params:'', ret:''}]
        },
        { name:'Siswa', parentId:'__ref_AkunSekolah',
          attrs:[{vis:'pub', name:'kelas', type:'str'}],
          meths:[{vis:'pub', name:'info', params:'', ret:''}]
        }
      ],
      code:[
        'class AkunSekolah:',
        '    def __init__(self, nama, password):',
        '        self.nama = nama',
        '        self.__password = password',
        '',
        '    def get_password(self):',
        '        return self.__password',
        '',
        '    def set_password(self, password_baru):',
        '        if len(password_baru) >= 6:',
        '            self.__password = password_baru',
        '            print("Password berhasil diperbarui.")',
        '        else:',
        '            print("Password minimal 6 karakter!")',
        '',
        '    def login(self, input_pw):',
        '        if input_pw == self.__password:',
        '            print(self.nama, "berhasil login!")',
        '        else:',
        '            print("Password salah!")',
        '',
        'class Guru(AkunSekolah):',
        '    def __init__(self, nama, password, mata_pelajaran):',
        '        super().__init__(nama, password)',
        '        self.mata_pelajaran = mata_pelajaran',
        '',
        '    def info(self):',
        '        print("Guru:", self.nama, "- Mapel:", self.mata_pelajaran)',
        '',
        'class Siswa(AkunSekolah):',
        '    def __init__(self, nama, password, kelas):',
        '        super().__init__(nama, password)',
        '        self.kelas = kelas',
        '',
        '    def info(self):',
        '        print("Siswa:", self.nama, "- Kelas:", self.kelas)',
        '',
        '# Contoh penggunaan',
        'guru1  = Guru("Bu Rina", "guru123", "Informatika")',
        'siswa1 = Siswa("Budi", "siswa99", "XI RPL")',
        'guru1.info()',
        'guru1.login("guru123")',
        'siswa1.info()',
        'siswa1.login("salah")'
      ].join('\n')
    },
    { id:'toko', icon:'🏪', title:'Toko → Toko Online', desc:'TokoOnline mewarisi Toko dan mengunci diskon dengan private + setter validasi',
      clsDefs:[
        { name:'Toko', parentId:null,
          attrs:[{vis:'pub',name:'nama_toko',type:'str'},{vis:'pro',name:'stok',type:'int'}],
          meths:[{vis:'pub',name:'info',params:'',ret:''}]
        },
        { name:'TokoOnline', parentId:'__ref_Toko',
          attrs:[{vis:'pub',name:'url',type:'str'},{vis:'priv',name:'diskon',type:'float'}],
          meths:[
            {vis:'pub',name:'get_diskon',params:'',ret:'float'},
            {vis:'pub',name:'set_diskon',params:'persen',ret:''},
            {vis:'pub',name:'info',params:'',ret:''}
          ]
        }
      ],
      code:[
        'class Toko:',
        '    def __init__(self, nama_toko, stok):',
        '        self.nama_toko = nama_toko',
        '        self._stok = stok',
        '',
        '    def info(self):',
        '        print("Toko:", self.nama_toko, "| Stok:", self._stok)',
        '',
        'class TokoOnline(Toko):',
        '    def __init__(self, nama_toko, stok, url, diskon):',
        '        super().__init__(nama_toko, stok)',
        '        self.url = url',
        '        self.__diskon = diskon',
        '',
        '    def get_diskon(self):',
        '        return self.__diskon',
        '',
        '    def set_diskon(self, persen):',
        '        if 0 <= persen <= 90:',
        '            self.__diskon = persen',
        '            print("Diskon diset:", persen, "%")',
        '        else:',
        '            print("Diskon harus antara 0 dan 90%!")',
        '',
        '    def info(self):',
        '        print("Toko Online:", self.nama_toko, "| URL:", self.url, "| Diskon:", self.__diskon, "%")',
        '',
        '# Contoh penggunaan',
        'toko = TokoOnline("Warung Digital", 50, "warungdigital.id", 10)',
        'toko.info()',
        'toko.set_diskon(25)',
        'print("Diskon saat ini:", toko.get_diskon(), "%")'
      ].join('\n')
    }
  ]
};

function renderPresetGrid() {
  const grid = document.getElementById('presetGrid');
  if (!grid) return;
  const list = PRESETS[window.KONSEP] || PRESETS.enkapsulasi;
  grid.innerHTML = list.map(p =>
    `<div class="preset-card${p.featured ? ' featured' : ''}" onclick="loadPreset('${p.id}')">
      ${p.featured ? '<div class="preset-featured-badge">⭐ Studi Kasus Pertemuan Ini</div>' : ''}
      <div class="preset-icon">${p.icon}</div>
      <div class="preset-title">${p.title}</div>
      <div class="preset-desc">${p.desc}</div>
      <div class="preset-tag">▶ Muat &amp; Jalankan</div>
    </div>`
  ).join('');
}

function loadPreset(presetId) {
  const list = PRESETS[window.KONSEP] || PRESETS.enkapsulasi;
  const preset = list.find(p => p.id === presetId);
  if (!preset) return;

  const newClasses = preset.clsDefs.map((def, idx) => {
    const cls = newClass(def.name);
    cls.attrs = def.attrs.map((a,i) => ({id:'pa'+idx+'a'+i, vis:a.vis, name:a.name, type:a.type, value:a.value||''}));
    cls.meths = def.meths.map((m,i) => ({id:'pm'+idx+'m'+i, vis:m.vis, name:m.name, params:m.params||'', ret:m.ret||''}));
    return cls;
  });
  preset.clsDefs.forEach((def, idx) => {
    if (def.parentId && def.parentId.startsWith('__ref_')) {
      const pName = def.parentId.replace('__ref_','');
      const pCls = newClasses.find(c => c.name === pName);
      if (pCls) newClasses[idx].parentId = pCls.id;
    }
  });
  classes = newClasses;
  // Sync parent text field from resolved parentId
  classes.forEach(c => {
    if (c.parentId) {
      const p = classes.find(x => x.id === c.parentId);
      if (p) c.parent = p.name;
    }
  });
  activeId = classes[classes.length-1].id;

  renderTabs(); renderEditor(); renderDiagram(); renderCodePreview();
  goPhase(2);
  document.getElementById('codeEditor').value = preset.code;
  generatedCode = preset.code;
  syncEditorHl();
  window.showToast('Contoh "' + preset.title + '" dimuat — siap dijalankan!', 'success');
}

/* ══════════════════════════════════════════════════════════════
   ONBOARDING
══════════════════════════════════════════════════════════════ */
const OB_STEPS = [
  { icon:'📋', title:'Langkah 1 — Rancang Blueprint',
    desc:'Pilih contoh preset yang sudah siap, atau rancang class kamu sendiri. Tambahkan atribut dan method, lalu lihat diagram terbentuk otomatis.' },
  { icon:'✍️', title:'Langkah 2 — Lengkapi Kode Python',
    desc:'Kode Python di-generate dari blueprint. Isi bagian <code># TODO</code> dengan logika yang sesuai — atau langsung gunakan preset yang kodenya sudah lengkap!' },
  { icon:'▶️', title:'Langkah 3 — Jalankan Simulasi',
    desc:'Tekan "Jalankan Simulasi" dan lihat setiap baris kode berjalan langkah demi langkah, lengkap dengan penjelasan konsep dan diagram yang berubah real-time.' },
];
let obStep = 0;

function showOnboarding() {
  obStep = 0; renderObStep();
  document.getElementById('onboardModal').classList.add('open');
}
function closeOnboarding() {
  document.getElementById('onboardModal').classList.remove('open');
  localStorage.setItem('ics_ob_done','1');
}
function renderObStep() {
  const s = OB_STEPS[obStep];
  const dots = OB_STEPS.map((_,i) => `<div class="ob-dot${i===obStep?' active':''}"></div>`).join('');
  document.getElementById('obDots').innerHTML = dots;
  document.getElementById('obContent').innerHTML =
    `<div class="ob-icon">${s.icon}</div>
     <div class="ob-title">${s.title}</div>
     <div class="ob-desc">${s.desc}</div>`;
  const isLast = obStep === OB_STEPS.length-1;
  document.getElementById('obNav').innerHTML =
    `${obStep>0?'<button class="btn btn-ghost" style="flex:1;justify-content:center;" onclick="obNav(-1)">← Kembali</button>':''}
     <button class="btn btn-amber" style="flex:1;justify-content:center;" onclick="${isLast?'closeOnboarding()':'obNav(1)'}">
       ${isLast?'Mulai Belajar ✓':'Lanjut →'}
     </button>`;
}
function obNav(d) { obStep = Math.max(0, Math.min(OB_STEPS.length-1, obStep+d)); renderObStep(); }
function initOnboarding() { if (!localStorage.getItem('ics_ob_done')) showOnboarding(); }

/* ══════════════════════════════════════════════════════════════
   GLOSSARY
══════════════════════════════════════════════════════════════ */
const GLOSSARY = [
  {term:'Class',def:'Blueprint atau cetakan untuk membuat objek. Mendefinisikan struktur (atribut) dan perilaku (method) yang dimiliki setiap objek.'},
  {term:'Object / Objek',def:'Instance konkret yang dibuat dari sebuah class. Jika class adalah cetakan kue, objek adalah kue yang sudah jadi.'},
  {term:'Atribut',def:'Data atau properti yang dimiliki oleh suatu objek. Contoh: objek Kucing bisa punya atribut nama, warna, dan suara.'},
  {term:'Method',def:'Fungsi yang didefinisikan di dalam class dan menentukan perilaku atau aksi yang bisa dilakukan oleh objek.'},
  {term:'Constructor (__init__)',def:'Method khusus yang dijalankan otomatis setiap kali objek baru dibuat. Tugasnya menyiapkan semua atribut awal objek.'},
  {term:'self',def:'Referensi ke objek itu sendiri di dalam method. Digunakan untuk mengakses atribut dan method milik objek tersebut dari dalam class.'},
  {term:'Enkapsulasi',def:'Konsep OOP yang menyembunyikan data internal class dari akses luar, dan mengontrol akses data hanya melalui method tertentu (getter/setter).'},
  {term:'Inheritance / Pewarisan',def:'Konsep OOP di mana class baru (class anak) mewarisi semua atribut dan method dari class yang sudah ada (class induk).'},
  {term:'Private (__)',def:'Tingkat akses paling ketat. Atribut/method berawalan __ hanya bisa diakses dari dalam class itu sendiri.'},
  {term:'Protected (_)',def:'Tingkat akses menengah. Atribut/method berawalan _ sebaiknya hanya diakses dari dalam class sendiri dan subclass-nya.'},
  {term:'Public (+)',def:'Tingkat akses paling bebas. Atribut/method tanpa awalan khusus bisa diakses dari mana saja dalam program.'},
  {term:'Getter',def:'Method untuk mengambil (membaca) nilai atribut private/protected secara aman dari luar class.'},
  {term:'Setter',def:'Method untuk mengubah nilai atribut private/protected, biasanya disertai validasi agar data tetap valid.'},
  {term:'super()',def:'Fungsi untuk memanggil method milik class induk dari dalam class anak. Paling sering digunakan di constructor: super().__init__().'},
  {term:'Override',def:'Mendefinisikan ulang method yang sudah ada di class induk di dalam class anak, dengan implementasi yang berbeda.'},
  {term:'Instance',def:'Objek konkret yang dibuat dari sebuah class. Satu class bisa menghasilkan banyak instance dengan nilai atribut yang berbeda.'},
  {term:'Name Mangling',def:'Mekanisme Python yang mengubah nama atribut private (misal __saldo) menjadi _NamaClass__saldo agar tidak mudah diakses dari luar class.'},
];

function showGlossary() {
  renderGlossaryList('');
  document.getElementById('glossarySearch').value='';
  document.getElementById('glossaryModal').classList.add('open');
}
function closeGlossary() { document.getElementById('glossaryModal').classList.remove('open'); }
function filterGlossary() { renderGlossaryList(document.getElementById('glossarySearch').value); }
function renderGlossaryList(q) {
  const list = GLOSSARY.filter(g => !q || g.term.toLowerCase().includes(q.toLowerCase()) || g.def.toLowerCase().includes(q.toLowerCase()));
  document.getElementById('glossaryList').innerHTML = list.length
    ? list.map(g => `<div class="glossary-item"><div class="glossary-term">${g.term}</div><div class="glossary-def">${g.def}</div></div>`).join('')
    : '<div style="color:var(--faint);padding:12px;text-align:center;">Tidak ditemukan</div>';
}

/* ══════════════════════════════════════════════════════════════
   CONCEPT SUMMARY
══════════════════════════════════════════════════════════════ */
function renderConceptSummary() {
  const box = document.getElementById('summaryBox');
  if (!box || !traceSteps.length) return;
  const found = new Set();
  traceSteps.forEach(s => {
    const raw = (codeLines[s.line-1]||'').trim();
    if (raw.match(/self\.__\w+\s*=/)) found.add('enc_priv');
    if (raw.match(/self\._\w+\s*=/) && !raw.match(/self\.__/)) found.add('enc_pro');
    if (s.frame && /^(get|set|is|has)/.test(s.frame)) found.add('enc_getter');
    if (raw.startsWith('class ') && raw.match(/\(\w+\)/)) found.add('inh_class');
    if (raw.includes('super().__init__')) found.add('inh_super');
    if (raw.match(/^def\s+__init__/)) found.add('ctor');
    if (raw.match(/^\w+\s*=\s*\w+\(/) && s.frame==='<module>') found.add('obj');
    if (raw.includes('return ')) found.add('ret');
    if (raw.includes('print(')) found.add('out');
  });
  const map = {
    enc_priv:{label:'Atribut Private (__)',cls:'enc'},enc_pro:{label:'Atribut Protected (_)',cls:'enc'},
    enc_getter:{label:'Getter / Setter Method',cls:'enc'},inh_class:{label:'Pewarisan Class',cls:'inh'},
    inh_super:{label:'super().__init__()',cls:'inh'},ctor:{label:'Constructor __init__',cls:'gen'},
    obj:{label:'Pembuatan Objek',cls:'gen'},ret:{label:'Return Value',cls:'gen'},out:{label:'Output print()',cls:'gen'}
  };
  const active = Object.entries(map).filter(([k]) => found.has(k));
  if (!active.length) { box.style.display='none'; return; }
  box.innerHTML = `<div class="summary-title">✨ Konsep yang Kamu Pelajari Hari Ini</div>
    <div class="summary-grid">${active.map(([,v])=>`<div class="summary-chip ${v.cls}">✓ ${v.label}</div>`).join('')}</div>`;
  box.style.display='block';
}

/* ══════════════════════════════════════════════════════════════
   MINI QUIZ
══════════════════════════════════════════════════════════════ */
const QUIZZES = {
  enkapsulasi:[
    { q:'Apa yang terjadi jika kamu mencoba mengakses <code>__saldo</code> langsung dari luar class?',
      opts:['Program berjalan normal, nilai ditampilkan','Muncul AttributeError dan program berhenti','Nilai atribut berubah menjadi 0'],
      ans:1, fb:'Benar! Python menerapkan name mangling pada atribut private (__), sehingga mengaksesnya dari luar class menghasilkan AttributeError.' },
    { q:'Apa fungsi utama method getter seperti <code>get_saldo()</code>?',
      opts:['Menambah nilai saldo secara otomatis','Memberikan akses terkontrol ke atribut private dari luar class','Membuat objek BankAccount baru'],
      ans:1, fb:'Tepat! Getter adalah pintu resmi untuk membaca nilai atribut private. Tanpa getter, data tidak bisa diakses dari luar class.' },
    { q:'Awalan <code>_</code> (single underscore) menandakan atribut bersifat...',
      opts:['Private — hanya bisa diakses di dalam class','Protected — untuk class sendiri dan subclass, tidak disarankan dari luar','Public — bebas diakses dari mana saja'],
      ans:1, fb:'Tepat! Protected (_) adalah konvensi Python yang menandakan atribut untuk internal class dan subclass-nya.' },
    { q:'Mengapa method <code>setor()</code> lebih aman dari pada mengakses <code>__saldo</code> secara langsung? (Analisis)',
      opts:['Karena setor() berjalan lebih cepat dari akses langsung','Karena setor() dapat memvalidasi nilai sebelum mengubah saldo, mencegah nilai ilegal','Karena setor() otomatis menyimpan data ke database'],
      ans:1, fb:'Tepat! Inilah inti enkapsulasi — method operasional seperti setor() dan tarik() dapat berisi logika validasi (mis. cek saldo tidak boleh negatif) sebelum mengubah data privat.' },
    { q:'Jika class <code>BankAccount</code> tidak memiliki method <code>tarik()</code>, apa risiko yang muncul?',
      opts:['Program akan error saat dijalankan karena Python mewajibkan method tarik()','Saldo bisa diubah sembarangan dari luar class tanpa validasi batas minimum','Class tidak dapat membuat objek baru sama sekali'],
      ans:1, fb:'Benar! Tanpa method operasional yang terkontrol, pengguna class bisa memanipulasi saldo secara bebas — bertentangan dengan prinsip enkapsulasi.' }
  ],
  inheritance:[
    { q:'Apa fungsi <code>super().__init__()</code> di dalam constructor class anak?',
      opts:['Menghapus constructor class induk','Memanggil constructor class induk agar atribut warisan ikut terinisialisasi','Membuat class induk baru secara otomatis'],
      ans:1, fb:'Benar! Tanpa super().__init__(), atribut yang didefinisikan di class induk tidak akan ada pada objek class anak.' },
    { q:'Apa yang dimaksud dengan "override" method?',
      opts:['Menghapus method dari class induk','Mendefinisikan ulang method yang sama di class anak dengan implementasi berbeda','Memanggil method class induk dari class anak'],
      ans:1, fb:'Tepat! Override memungkinkan class anak memiliki perilaku berbeda dari class induk meskipun nama method-nya sama.' },
    { q:'Atribut mana yang ditandai "diwariskan" di panel Status Objek?',
      opts:['Atribut yang didefinisikan di class anak','Atribut yang berasal dari class induk','Semua atribut pada objek'],
      ans:1, fb:'Benar! Panel Status Objek menandai atribut dari class induk dengan label "diwariskan" agar kamu bisa membedakannya.' },
    { q:'Kapan sebaiknya class anak memanggil <code>super().method()</code> alih-alih menimpa seluruh method? (Analisis)',
      opts:['Ketika method class induk sudah salah dan perlu diganti sepenuhnya','Ketika class anak ingin menambahkan perilaku baru tanpa kehilangan logika class induk','Ketika class anak ingin menghapus method dari class induk'],
      ans:1, fb:'Tepat! Pola super().method() memungkinkan class anak memperluas (extend) perilaku induk, bukan mengganti sepenuhnya — prinsip penting dalam desain inheritance yang baik.' },
    { q:'Jika class <code>Warrior</code> mewarisi <code>Character</code>, objek Warrior dapat mengakses atribut <code>nama</code> dari Character karena...',
      opts:['Python menyalin semua atribut Character ke dalam Warrior saat program dicompile','Warrior mewarisi namespace class induk, sehingga atribut Character tersedia di objek Warrior','Atribut nama dideklarasikan ulang secara otomatis di dalam Warrior'],
      ans:1, fb:'Benar! Inheritance di Python bekerja melalui MRO (Method Resolution Order) — Python mencari atribut di class anak dulu, lalu naik ke class induk secara berurutan.' }
  ],
  umum:[]
};
let quizIdx = 0, quizAnswered = false;

function renderQuiz() {
  const box = document.getElementById('quizBox');
  if (!box) return;
  const qs = QUIZZES[window.KONSEP] || [];
  if (!qs.length) { box.style.display='none'; return; }
  if (quizIdx >= qs.length) {
    box.innerHTML = `<div class="quiz-hdr">📝 Evaluasi Pemahaman</div>
      <div style="text-align:center;padding:12px 0;">
        <div style="font-size:32px;margin-bottom:8px;">🎉</div>
        <div style="font-size:14px;font-weight:600;margin-bottom:4px;">Semua soal selesai!</div>
        <div style="font-size:12.5px;color:var(--dim);">Kamu telah menjawab ${qs.length} soal. Bagus sekali!</div>
      </div>`;
    box.style.display='block'; return;
  }
  const q = qs[quizIdx];
  box.innerHTML = `<div class="quiz-hdr">📝 Evaluasi Pemahaman · Soal ${quizIdx+1} / ${qs.length}</div>
    <div class="quiz-q">${q.q}</div>
    <div class="quiz-opts">${q.opts.map((o,i)=>`<button class="quiz-opt" onclick="answerQuiz(${i})">${String.fromCharCode(65+i)}. ${o}</button>`).join('')}</div>
    <div id="quizFeedback" style="display:none;"></div>
    <div id="quizNext" style="display:none;margin-top:12px;display:none;">
      <button class="btn btn-amber" onclick="nextQuiz()">Soal Berikutnya →</button>
    </div>`;
  box.style.display='block'; quizAnswered=false;
}

function answerQuiz(idx) {
  if (quizAnswered) return; quizAnswered=true;
  const q = (QUIZZES[window.KONSEP]||[])[quizIdx];
  document.querySelectorAll('.quiz-opt').forEach((b,i)=>{
    b.disabled=true;
    if (i===q.ans) b.classList.add('correct');
    else if (i===idx) b.classList.add('wrong');
  });
  const fb=document.getElementById('quizFeedback');
  fb.className='quiz-feedback '+(idx===q.ans?'correct':'wrong');
  fb.innerHTML=(idx===q.ans?'✓ ':'✗ Belum tepat. ')+q.fb;
  fb.style.display='block';
  const nxt=document.getElementById('quizNext');
  if(nxt){nxt.style.display='flex';}
}
function nextQuiz(){quizIdx++;renderQuiz();}

// Init on summary+quiz when last step reached
function showEndCards(){renderConceptSummary();if(quizIdx===0)renderQuiz();}

// Init default classes based on active concept
if (window.KONSEP === 'enkapsulasi') {
  // Enkapsulasi example: BankAccount with private & protected attrs + getter/setter
  classes[0] = newClass('BankAccount');
  classes[0].attrs = [
    {id:'a1', vis:'priv', name:'saldo',   type:'float'},
    {id:'a2', vis:'pro',  name:'pemilik', type:'str'},
  ];
  classes[0].meths = [
    {id:'m1', vis:'pub', name:'get_saldo', params:'',       ret:'float'},
    {id:'m2', vis:'pub', name:'setor',     params:'jumlah', ret:''},
    {id:'m3', vis:'pub', name:'tarik',     params:'jumlah', ret:''},
  ];
  classes = [classes[0]];
  activeId = classes[0].id;

} else if (window.KONSEP === 'inheritance') {
  // Inheritance example: Hewan (induk) → Kucing (anak)
  classes[0] = newClass('Hewan');
  classes[0].attrs = [
    {id:'a1', vis:'pub', name:'nama',  type:'str'},
    {id:'a2', vis:'pub', name:'suara', type:'str'},
  ];
  classes[0].meths = [
    {id:'m1', vis:'pub', name:'bersuara', params:'', ret:'str'},
  ];

  const kucing = newClass('Kucing');
  kucing.parentId = classes[0].id;
  kucing.parent   = 'Hewan';
  kucing.attrs  = [{id:'a3', vis:'pub', name:'warna', type:'str'}];
  kucing.meths  = [{id:'m2', vis:'pub', name:'bersuara', params:'', ret:'str'}];
  classes = [classes[0], kucing];
  activeId = kucing.id;

} else if (window.KONSEP === 'gabungan') {
  // Gabungan example: AkunSekolah (induk) → Guru (anak) — sama persis dengan
  // preset 'school_management' di PRESETS.gabungan (baris ~2724)
  classes[0] = newClass('AkunSekolah');
  classes[0].attrs = [
    {id:'a1', vis:'pub',  name:'nama',     type:'str'},
    {id:'a2', vis:'priv', name:'password', type:'str'},
  ];
  classes[0].meths = [
    {id:'m1', vis:'pub', name:'get_password', params:'',              ret:'str'},
    {id:'m2', vis:'pub', name:'set_password', params:'password_baru', ret:''},
    {id:'m3', vis:'pub', name:'login',        params:'input_pw',      ret:''},
  ];

  const guru = newClass('Guru');
  guru.parentId = classes[0].id;
  guru.parent   = 'AkunSekolah';
  guru.attrs  = [{id:'a3', vis:'pub', name:'mata_pelajaran', type:'str'}];
  guru.meths  = [{id:'m4', vis:'pub', name:'info', params:'', ret:''}];
  classes = [classes[0], guru];
  activeId = guru.id;

} else {
  // Default / generic example: Kendaraan → Motor
  classes[0].attrs = [{id:'a1', vis:'pro', name:'merek', type:'str'}];
  classes[0].meths = [];
  const motor = newClass('Motor');
  motor.parentId = classes[0].id;
  motor.parent   = 'Kendaraan';
  motor.attrs = [{id:'a2', vis:'pub', name:'jenis_motor', type:'str'}];
  motor.meths = [{id:'m1', vis:'pub', name:'info', params:'', ret:'str'}];
  classes.push(motor);
  activeId = motor.id;
}

renderTabs();
renderEditor();
renderDiagram();
renderCodePreview();
renderPresetGrid();
initOnboarding();

// Start Pyodide
document.getElementById('btnJalankan').disabled = true;
initPy();
</script>
</body>
</html>
