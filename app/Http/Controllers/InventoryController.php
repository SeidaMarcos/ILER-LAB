<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Machine;
use App\Models\Tool;

class InventoryController extends Controller
{
    // Mostrar el inventario completo
    public function index()
    {
        $products = Product::all();
        $machines = Machine::all();
        $tools = Tool::all();

        return view('admin.inventory.index', compact('products', 'machines', 'tools'));
    }

    // Crear un nuevo producto
    public function storeProduct(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'density' => 'required|numeric',
            'location' => 'required|string|max:255',
        ]);

        Product::create($request->all());

        return redirect()->route('inventory.index')->with('success', 'Producto creado con éxito.');
    }

    // Crear una nueva máquina
    public function storeMachine(Request $request)
    {
        $request->validate([
            'reference' => 'required|string|max:255|unique:machines',
            'location' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        Machine::create($request->all());

        return redirect()->route('inventory.index')->with('success', 'Máquina creada con éxito.');
    }

    // Crear una nueva herramienta
    public function storeTool(Request $request)
    {
        $request->validate([
            'reference' => 'required|string|max:255|unique:tools',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'material' => 'required|in:vidrio,madera,plástico',
        ]);

        Tool::create($request->all());

        return redirect()->route('inventory.index')->with('success', 'Herramienta creada con éxito.');
    }

// Editar un producto
    public function editProduct($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.inventory.edit-product', compact('product'));
    }

    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date',
            'density' => 'required|numeric',
            'location' => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('inventory.index')->with('success', 'Producto actualizado con éxito.');
    }

    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('inventory.index')->with('success', 'Producto eliminado con éxito.');
    }

    // Métodos similares para máquinas y herramientas
    public function editMachine($id)
    {
        $machine = Machine::findOrFail($id);
        return view('admin.inventory.edit-machine', compact('machine'));
    }

    public function updateMachine(Request $request, $id)
    {
        $request->validate([
            'reference' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'name' => 'required|string|max:255',
        ]);

        $machine = Machine::findOrFail($id);
        $machine->update($request->all());

        return redirect()->route('inventory.index')->with('success', 'Máquina actualizada con éxito.');
    }

    public function destroyMachine($id)
    {
        $machine = Machine::findOrFail($id);
        $machine->delete();

        return redirect()->route('inventory.index')->with('success', 'Máquina eliminada con éxito.');
    }

    public function editTool($id)
    {
        $tool = Tool::findOrFail($id);
        return view('admin.inventory.edit-tool', compact('tool'));
    }

    public function updateTool(Request $request, $id)
    {
        $request->validate([
            'reference' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'stock' => 'required|integer|min:0',
            'material' => 'required|in:vidrio,madera,plástico',
        ]);

        $tool = Tool::findOrFail($id);
        $tool->update($request->all());

        return redirect()->route('inventory.index')->with('success', 'Herramienta actualizada con éxito.');
    }

    public function destroyTool($id)
    {
        $tool = Tool::findOrFail($id);
        $tool->delete();

        return redirect()->route('inventory.index')->with('success', 'Herramienta eliminada con éxito.');
    }}
