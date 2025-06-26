<div class="modal fade" id="chatModal-{{ $sale->id }}" tabindex="-1" aria-labelledby="chatModalLabel-{{ $sale->id }}" aria-hidden="true">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="chatModalLabel-{{ $sale->id }}">
                    <i class="fab fa-whatsapp me-2"></i>
                    Riwayat Sesi Chat WhatsApp - <span class="fw-bold">{{ $sale->name }}</span>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                @if($chats->count() > 0)
                <div class="table-responsive" style="max-height: 480px; overflow-y: auto;">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light sticky-top" style="z-index:2;">
                            <tr>
                                <th style="width:40px;">#</th>
                                <th style="min-width:120px;">Waktu</th>
                                <th style="min-width:120px;">User</th>
                                <th style="min-width:180px;">Produk</th>
                                <th style="min-width:220px;">Pesan</th>
                                <th style="min-width:100px;">IP</th>
                                <th style="min-width:180px;">User Agent</th>
                                <th style="width:40px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($chats as $i => $chat)
                            <tr>
                                <td>{{ $i+1 }}</td>
                                <td><span class="badge bg-light text-dark">{{ $chat->chatted_at->format('d M Y H:i') }}</span></td>
                                <td>
                                    @if($chat->user)
                                        <span class="badge bg-primary"><i class="fas fa-user me-1"></i>{{ $chat->user->name }}</span>
                                    @else
                                        <span class="badge bg-secondary">Guest</span>
                                    @endif
                                </td>
                                <td>
                                    @if($chat->product)
                                        <div class="d-flex align-items-center gap-2">
                                            @if($chat->product->thumbnail)
                                                <img src="{{ asset('storage/'.$chat->product->thumbnail) }}" alt="{{ $chat->product->name }}" style="width:36px;height:36px;object-fit:cover;border-radius:6px;">
                                            @endif
                                            <div>
                                                <a href="{{ route('products.show', $chat->product->slug) }}" target="_blank" class="fw-semibold text-decoration-none">{{ $chat->product->name }}</a>
                                                <div class="text-muted small">ID: {{ $chat->product->id }}</div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td>
                                    @if($chat->message)
                                        <div class="bg-light border rounded px-3 py-2" style="white-space:pre-line;max-width:320px;">
                                            <i class="fab fa-whatsapp text-success me-1"></i>{{ $chat->message }}
                                        </div>
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </td>
                                <td><span class="badge bg-light text-dark">{{ $chat->visitor_ip }}</span></td>
                                <td style="max-width:200px;overflow:auto;font-size:0.95em;">{{ $chat->visitor_user_agent }}</td>
                                <td>
                                    <form action="{{ route('admin.sales.chat.delete', [$sale->id, $chat->id]) }}" method="POST" onsubmit="return confirm('Hapus sesi chat ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger"><i class="fas fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <div class="p-4 text-center text-muted">Belum ada sesi chat WhatsApp.</div>
                @endif
            </div>
        </div>
    </div>
</div>
<style>
    .modal-xl { max-width: 1100px; }
    .table thead th.sticky-top { background: #f8f9fa !important; }
</style> 