<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Machine;
use App\Models\Tool;

class InventoryController extends Controller
{
    // Mostrar inventario
    public function index()
    {
        $products = Product::all();
        $machines = Machine::all();
        $tools = Tool::all();

        return view('admin.inventory.index', compact('products', 'machines', 'tools'));
    }

    // Crear producto
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

    // Actualizar producto
    public function updateProduct(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'density' => 'required|numeric',
            'location' => 'required|string|max:255',
        ]);

        $product = Product::findOrFail($id);
        $product->update($request->all());

        return redirect()->route('inventory.index')->with('success', 'Producto actualizado con éxito.');
    }

    // Eliminar producto
    public function destroyProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('inventory.index')->with('success', 'Producto eliminado con éxito.');
    }

    // Crear máquina
    public function storeMachine(Request $request)
    {
        $request->validate([
            'reference' => 'required|string|max:255|unique:machines',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        Machine::create($request->all());

        return redirect()->route('inventory.index')->with('success', 'Máquina creada con éxito.');
    }

    // Actualizar máquina
    public function updateMachine(Request $request, $id)
    {
        $request->validate([
            'reference' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        $machine = Machine::findOrFail($id);
        $machine->update($request->all());

        return redirect()->route('inventory.index')->with('success', 'Máquina actualizada con éxito.');
    }

    // Eliminar máquina
    public function destroyMachine($id)
    {
        $machine = Machine::findOrFail($id);
        $machine->delete();

        return redirect()->route('inventory.index')->with('success', 'Máquina eliminada con éxito.');
    }

    // Crear herramienta
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

    // Actualizar herramienta
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

    // Eliminar herramienta
    public function destroyTool($id)
    {
        $tool = Tool::findOrFail($id);
        $tool->delete();

        return redirect()->route('inventory.index')->with('success', 'Herramienta eliminada con éxito.');
    }
}
