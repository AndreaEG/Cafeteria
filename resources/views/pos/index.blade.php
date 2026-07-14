@extends('layouts.app')
@section('content')
<div class="row">
    <div class="col-md-7">
        <input type="text" id="buscador" class="form-control form-control-lg mb-3" placeholder="Buscar producto o escanear código...">
        <div class="row" id="lista-productos">
            @foreach ($products as $p)
            <div class="col-4 mb-3 producto-card" data-id="{{ $p->id }}" data-nombre="{{ $p->name }}" data-precio="{{ $p->sale_price }}">
                <div class="card h-100 text-center p-2" style="cursor:pointer">
                    @if ($p->image_path)
                        <img src="{{ asset('storage/'.$p->image_path) }}" class="card-img-top" style="height:80px;object-fit:cover">
                    @endif
                    <div class="card-body p-2">
                        <p class="mb-1 small">{{ $p->name }}</p>
                        <strong>${{ number_format($p->sale_price, 2) }}</strong>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <div class="col-md-5">
        <div class="card">
            <div class="card-header">Ticket de Compra</div>
            <ul class="list-group list-group-flush" id="carrito"></ul>
            <div class="card-body">
                <h4>Total: $<span id="total">0.00</span></h4>
                <button id="btn-cobrar" class="btn btn-success btn-lg w-100">COBRAR</button>
            </div>
        </div>
    </div>
</div>

<script>
let carrito = [];

document.querySelectorAll('.producto-card').forEach(card => {
    card.addEventListener('click', () => {
        const id = card.dataset.id, nombre = card.dataset.nombre, precio = parseFloat(card.dataset.precio);
        const existente = carrito.find(i => i.id === id);
        existente ? existente.cantidad++ : carrito.push({ id, nombre, precio, cantidad: 1 });
        renderCarrito();
    });
});

function renderCarrito() {
    const ul = document.getElementById('carrito');
    ul.innerHTML = '';
    let total = 0;
    carrito.forEach(item => {
        const subtotal = item.precio * item.cantidad;
        total += subtotal;
        ul.innerHTML += `<li class="list-group-item d-flex justify-content-between">
            ${item.nombre} x${item.cantidad} <span>$${subtotal.toFixed(2)}</span>
        </li>`;
    });
    document.getElementById('total').innerText = total.toFixed(2);
}

document.getElementById('btn-cobrar').addEventListener('click', () => {
    if (carrito.length === 0) return alert('Carrito vacío');

    fetch('{{ route("sales.store") }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            items: carrito.map(i => ({ product_id: i.id, quantity: i.cantidad }))
        })
    })
    .then(res => res.json())
    .then(data => {
        if (data.success) {
            alert('Venta registrada. Total: $' + data.total);
            carrito = [];
            renderCarrito();
        } else {
            alert('Error: ' + data.message);
        }
    });
});

document.getElementById('buscador').addEventListener('input', function () {
    const filtro = this.value.toLowerCase();
    document.querySelectorAll('.producto-card').forEach(card => {
        card.style.display = card.dataset.nombre.toLowerCase().includes(filtro) ? '' : 'none';
    });
});
</script>
@endsection