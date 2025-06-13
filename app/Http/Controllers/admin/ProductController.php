<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with('category')->where('is_deleted', 0);

        // Fitur search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                  ->orWhere('description', 'like', "%$search%");
            });
        }

        $products = $query->get();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        // Ambil hanya kategori yang aktif dan tidak dihapus
        $categories = Category::where('is_deleted', 0)->where('status', 1)->get();
        return view('admin.products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $data = $request->all();
        $data['company_code'] = 'default';
        $data['status'] = 1;
        $data['is_deleted'] = 0;
        $data['created_by'] = auth()->user()->name ?? 'admin';
        $data['created_date'] = now();
        $data['last_update_by'] = null;
        $data['last_update_date'] = null;
        $data['category_id'] = null; // pastikan tidak mengisi category_id

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambah!');
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::where('is_deleted', 0)->where('status', 1)->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
        ]);

        $data = $request->all();
        $data['last_update_by'] = auth()->user()->name ?? 'admin';
        $data['last_update_date'] = now();

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function show($id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('admin.products.show', compact('product'));
    }

    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->update([
            'is_deleted' => 1,
            'last_update_by' => auth()->user()->name ?? 'admin',
            'last_update_date' => now()
        ]);
        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
    }
}