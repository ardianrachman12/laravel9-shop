@if ($produk->stok == 0)
    <div class="card-badges">
        <span class="badge badge-card"><span class="f-w-2 f-h-2 bg-secondary rounded-circle d-block me-1"></span> Sold
            Out</span>
    </div>
@else
    <div class="card-badges">
        <span class="badge badge-card"><span class="f-w-2 f-h-2 bg-success rounded-circle d-block me-1"></span>
            Sale</span>
    </div>
@endif
