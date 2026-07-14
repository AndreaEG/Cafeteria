@extends('layouts.app')

@section('content')

<style>
    .dashboard-bg {
        position: relative;
        min-height: 100vh;
        padding: 30px 20px;
        background-color: #FAFAF7;
        background-image:
            linear-gradient(135deg, rgba(216, 137, 60, 0.04) 25%, transparent 25%),
            linear-gradient(225deg, rgba(216, 137, 60, 0.04) 25%, transparent 25%),
            linear-gradient(45deg, rgba(90, 141, 108, 0.04) 25%, transparent 25%),
            linear-gradient(315deg, rgba(90, 141, 108, 0.04) 25%, transparent 25%);
        background-position: 40px 0, 40px 0, 0 0, 0 0;
        background-size: 80px 80px;
        border-radius: 12px;
    }

    .buscador-comedor {
        border: 1px solid #E4E6E1;
        border-radius: 12px;
        padding: 14px 18px;
        background-color: #FFFFFF;
        color: #2E3A32;
        box-shadow: 0 4px 15px rgba(46, 58, 50, 0.06);
        transition: border-color 0.2s ease, box-shadow 0.2s ease;
    }

    .buscador-comedor:focus {
        border-color: #5A8D6C;
        box-shadow: 0 0 0 3px rgba(90, 141, 108, 0.12);
        outline: none;
    }

    .producto-card .card {
        border: none;
        border-radius: 14px;
        background: #FFFFFF;
        box-shadow: 0 3px 10px rgba(46, 58, 50, 0.07);
        transition: transform 0.15s ease, box-shadow 0.15s ease;
    }

    .producto-card .card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 18px rgba(46, 58, 50, 0.13);
    }

    .producto-card .card-img-top {
        border-radius: 10px 10px 0 0;
    }

    .producto-card .card-body p {
        color: #2E3A32;
        font-weight: 500;
    }

    .producto-card .card-body strong {
        color: #5A8D6C;
        font-size: 1rem;
    }

    .ticket-card {
        border: none;
        border-radius: 14px;
        background: #FFFFFF;
        box-shadow: 0 4px 18px rgba(46, 58, 50, 0.09);
        position: sticky;
        top: 20px;
        overflow: hidden;
    }

    .ticket-header {
        background-color: #2E3A32;
        color: #F7F9F6;
        font-weight: 600;
        letter-spacing: 0.4px;
        padding: 16px 20px;
        font-size: 0.95rem;
        text-transform: uppercase;
    }

    #carrito {
        max-height: 320px;
        overflow-y: auto;
    }

    #carrito .list-group-item {
        border-color: #F0F1EE;
        color: #2E3A32;
        padding: 12px 20px;
    }

    .ticket-total-box {
        background-color: #F7F9F6;
        padding: 20px;
    }

    .ticket-total-box h4 {
        color: #2E3A32;
        font-weight: 700;
        margin-bottom: 14px;
    }

    .ticket-total-box h4 span {
        color: #5A8D6C;
    }

    .btn-cobrar-comedor {
        background-color: #D8893C;
        border: none;
        color: #fff;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 14px;
        border-radius: 10px;
        width: 100%;
        font-size: 1.05rem;
        transition: background-color 0.2s ease, transform 0.15s ease;
    }

    .btn-cobrar-comedor:hover {
        background-color: #C27829;
        color: #fff;
        transform: translateY(-2px);
    }
</style>

<div class="dashboard-bg">
    <div class="row">
        <div class="col-md-7">
            <input type="text" id="buscador" class="form-control form-control-lg mb-3 buscador-comedor" placeholder="Buscar producto o escanear código...">
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
            <div class="ticket-card">
                <div class="ticket-header">Ticket de Compra</div>
                <ul class="list-group list-group-flush" id="carrito"></ul>
                <div class="ticket-total-box">
                    <h4>Total: $<span id="total">0.00</span></h4>
                    <button id="btn-cobrar" class="btn-cobrar-comedor">COBRAR</button>
                </div>
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