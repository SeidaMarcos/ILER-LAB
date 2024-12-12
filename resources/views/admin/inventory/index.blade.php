@extends('layouts.adminLayout')

@section('title', 'Gestión de Inventario')

@section('content')
<div class="container mt-5">
    <h1 class="text-center mb-5">Gestión de Inventario</h1>

    <!-- Productos -->
    <h2 class="mb-3">Productos</h2>
    <form action="{{ route('inventory.store.product') }}" method="POST" class="mb-4">
        @csrf
        <div class="row g-3">
            <div class="col-md-3">
                <input type="text" name="name" class="form-control" placeholder="Nombre" required>
            </div>
            <div class="col-md-2">
                <input type="number" step="0.01" name="density" class="form-control" placeholder="Densidad (g/ml)" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="location" class="form-control" placeholder="Ubicación" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Crear Producto</button>
            </div>
        </div>
    </form>
    <ul class="list-group">
        @foreach($products as $product)
            <li class="list-group-item">
                <strong>{{ $product->name }}</strong> - Ubicación: {{ $product->location }}
            </li>
        @endforeach
    </ul>

    <!-- Máquinas -->
    <h2 class="mt-5 mb-3">Máquinas</h2>
    <form action="{{ route('inventory.store.machine') }}" method="POST" class="mb-4">
        @csrf
        <div class="row g-3">
            <div class="col-md-3">
                <input type="text" name="reference" class="form-control" placeholder="Referencia" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="location" class="form-control" placeholder="Ubicación" required>
            </div>
            <div class="col-md-4">
                <input type="text" name="name" class="form-control" placeholder="Nombre" required>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Crear Máquina</button>
            </div>
        </div>
    </form>
    <ul class="list-group">
        @foreach($machines as $machine)
            <li class="list-group-item">
                <strong>{{ $machine->name }}</strong> - Ubicación: {{ $machine->location }}
            </li>
        @endforeach
    </ul>

    <!-- Herramientas -->
    <h2 class="mt-5 mb-3">Herramientas</h2>
    <form action="{{ route('inventory.store.tool') }}" method="POST" class="mb-4">
        @csrf
        <div class="row g-3">
            <div class="col-md-3">
                <input type="text" name="reference" class="form-control" placeholder="Referencia" required>
            </div>
            <div class="col-md-3">
                <input type="text" name="name" class="form-control" placeholder="Nombre" required>
            </div>
            <div class="col-md-2">
                <input type="number" name="stock" class="form-control" placeholder="Stock" required>
            </div>
            <div class="col-md-2">
                <select name="material" class="form-select" required>
                    <option value="" disabled selected>Material</option>
                    <option value="vidrio">Vidrio</option>
                    <option value="madera">Madera</option>
                    <option value="plástico">Plástico</option>
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary w-100">Crear Herramienta</button>
            </div>
        </div>
    </form>
    <ul class="list-group">
        @foreach($tools as $tool)
            <li class="list-group-item">
                <strong>{{ $tool->name }}</strong> - Material: {{ $tool->material }} (Stock: {{ $tool->stock }})
            </li>
        @endforeach
    </ul>
</div>
@endsection
