@extends('layouts.adminLayout')

@section('title', 'Gestión de Inventario')

@section('content')

<a href="{{ route('admin.dashboard') }}" class="btn btn-light">
    <i class="fas fa-arrow-left"></i>
</a>

<div class="container mt-5 mb-5">
    <div class="card border-0 shadow-sm">
        <div class="card-header" style="background-color: #14b8a6; color: white;">
            <h1 class="text-center mb-0">Gestión de Inventario</h1>
        </div>
        <div class="card-body">
            <!-- Productos -->
            <h2 class="mb-3">Productos</h2>
            <form action="{{ route('inventory.store.product') }}" method="POST" class="mb-4">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="name" class="form-control" placeholder="Nombre" required>
                    </div>
                    <div class="col-md-3">
                        <input type="number" step="0.01" name="density" class="form-control" placeholder="Densidad (g/ml)" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="location" class="form-control" placeholder="Ubicación" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn" style="background-color: #14b8a6; color: white;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </form>
            <ul class="list-group">
                @foreach($products as $product)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <strong>{{ $product->name }}</strong> - Ubicación: {{ $product->location }}
                        </span>
                        <span>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editProductModal{{ $product->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('inventory.destroy.product', $product->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </span>
                    </li>

                    <!-- Modal para editar producto -->
                    <div class="modal fade" id="editProductModal{{ $product->id }}" tabindex="-1" aria-labelledby="editProductModalLabel{{ $product->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('inventory.update.product', $product->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header" style="background-color: #14b8a6; color: white;">
                                        <h5 class="modal-title" id="editProductModalLabel{{ $product->id }}">Editar Producto</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nombre</label>
                                            <input type="text" name="name" class="form-control" value="{{ $product->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="density" class="form-label">Densidad (g/ml)</label>
                                            <input type="number" step="0.01" name="density" class="form-control" value="{{ $product->density }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="location" class="form-label">Ubicación</label>
                                            <input type="text" name="location" class="form-control" value="{{ $product->location }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </ul>

            <!-- Máquinas -->
            <h2 class="mt-5 mb-3">Máquinas</h2>
            <form action="{{ route('inventory.store.machine') }}" method="POST" class="mb-4">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="name" class="form-control" placeholder="Nombre" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="reference" class="form-control" placeholder="Referencia" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="location" class="form-control" placeholder="Ubicación" required>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn " style="background-color: #14b8a6; color: white;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </form>
            <ul class="list-group">
                @foreach($machines as $machine)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <strong>{{ $machine->name }}</strong> - Ubicación: {{ $machine->location }}
                        </span>
                        <span>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editMachineModal{{ $machine->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('inventory.destroy.machine', $machine->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </span>
                    </li>

                    <!-- Modal para editar máquina -->
                    <div class="modal fade" id="editMachineModal{{ $machine->id }}" tabindex="-1" aria-labelledby="editMachineModalLabel{{ $machine->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('inventory.update.machine', $machine->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header" style="background-color: #14b8a6; color: white;">
                                        <h5 class="modal-title" id="editMachineModalLabel{{ $machine->id }}">Editar Máquina</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="reference" class="form-label">Referencia</label>
                                            <input type="text" name="reference" class="form-control" value="{{ $machine->reference }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nombre</label>
                                            <input type="text" name="name" class="form-control" value="{{ $machine->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="location" class="form-label">Ubicación</label>
                                            <input type="text" name="location" class="form-control" value="{{ $machine->location }}" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </ul>

            <!-- Herramientas -->
            <h2 class="mt-5 mb-3">Herramientas</h2>
            <form action="{{ route('inventory.store.tool') }}" method="POST" class="mb-4">
                @csrf
                <div class="row g-3">
                    <div class="col-md-3">
                        <input type="text" name="name" class="form-control" placeholder="Nombre" required>
                    </div>
                    <div class="col-md-3">
                        <input type="text" name="reference" class="form-control" placeholder="Referencia" required>
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
                        <button type="submit" class="btn" style="background-color: #14b8a6; color: white;">
                            <i class="fas fa-plus"></i>
                        </button>
                    </div>
                </div>
            </form>
            <ul class="list-group">
                @foreach($tools as $tool)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <span>
                            <strong>{{ $tool->name }}</strong> - Material: {{ $tool->material }} (Stock: {{ $tool->stock }})
                        </span>
                        <span>
                            <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editToolModal{{ $tool->id }}">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('inventory.destroy.tool', $tool->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </span>
                    </li>

                    <!-- Modal para editar herramienta -->
                    <div class="modal fade" id="editToolModal{{ $tool->id }}" tabindex="-1" aria-labelledby="editToolModalLabel{{ $tool->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('inventory.update.tool', $tool->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="modal-header" style="background-color: #14b8a6; color: white;">
                                        <h5 class="modal-title" id="editToolModalLabel{{ $tool->id }}">Editar Herramienta</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label for="reference" class="form-label">Referencia</label>
                                            <input type="text" name="reference" class="form-control" value="{{ $tool->reference }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nombre</label>
                                            <input type="text" name="name" class="form-control" value="{{ $tool->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="stock" class="form-label">Stock</label>
                                            <input type="number" name="stock" class="form-control" value="{{ $tool->stock }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="material" class="form-label">Material</label>
                                            <select name="material" class="form-select" required>
                                                <option value="vidrio" {{ $tool->material === 'vidrio' ? 'selected' : '' }}>Vidrio</option>
                                                <option value="madera" {{ $tool->material === 'madera' ? 'selected' : '' }}>Madera</option>
                                                <option value="plástico" {{ $tool->material === 'plástico' ? 'selected' : '' }}>Plástico</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            <i class="fas fa-times"></i>
                                        </button>
                                        <button type="submit" class="btn btn-success">
                                            <i class="fas fa-save"></i>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </ul>
        </div>
    </div>
</div>
@endsection
