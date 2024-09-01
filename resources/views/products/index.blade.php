<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Product List') }}
        </h2>
    </x-slot>
        <style>
            body {
                font-family: Arial, sans-serif;
                background-color: #f4f4f4;
                margin: 0;
                padding: 20px;
                min-height: 100vh;
            }

            .header {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 10px 20px;
                background-color: #3498db;
                color: #fff;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                margin-bottom: 20px;
                position: relative;
                z-index: 1000; /* Ensure the header stays on top */
            }

            .header h1 {
                margin: 0;
                font-size: 24px;
            }

            .username {
                font-size: 16px;
                margin-left: auto;
                padding-left: 20px;
            }

            .product-container {
                display: grid;
                grid-template-columns: repeat(4, minmax(250px, 1fr));
                gap: 20px;
                max-width: 1200px;
                margin: 0 auto;
            }

            .product-card {
                background-color: #fff;
                border-radius: 8px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                padding: 20px;
                transition: transform 0.3s ease;
                display: flex;
                flex-direction: column;
                align-items: center;
            }

            .product-card:hover {
                transform: translateY(-5px);
            }

            .product-card img {
                max-width: 100%;
                height: auto;
                max-height: 150px;
                object-fit: cover;
                margin-bottom: 15px;
                border-radius: 8px;
            }

            .product-card h2 {
                font-size: 24px;
                margin: 0 0 10px;
                color: #333;
            }

            .product-card p {
                margin: 5px 0;
                color: #666;
                text-align: center;
            }

            .product-card .action-btn {
                color: #fff;
                padding: 8px 12px;
                border-radius: 4px;
                text-align: center;
                display: inline-block;
                margin-right: 5px;
            }

            .update-btn {
                background-color: #4CAF50;
            }

            .update-btn:hover {
                background-color: #45a049;
            }

            .delete-btn {
                background-color: #e74c3c;
            }

            .delete-btn:hover {
                background-color: #c0392b;
            }

            .button-container {
                text-align: center;
                margin-top: 50px;
            }

            .create-btn {
                padding: 15px 30px;
                background-color: #3498db;
                color: #fff;
                text-align: center;
                border-radius: 8px;
                text-decoration: none;
                font-size: 18px;
                box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                transition: background-color 0.3s ease, box-shadow 0.3s ease;
                display: inline-block;
            }

            .create-btn:hover {
                background-color: #2980b9;
                box-shadow: 0 6px 8px rgba(0, 0, 0, 0.15);
            }
        </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-10 lg:px-18">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <!-- Product List Content -->
                    <div>
                        <div class="search-filter-container" style="text-align: center; margin-bottom: 20px;">
                            <input type="text" id="search" placeholder="Search products..." value="{{ request()->input('search') }}" style="padding: 10px; width: 200px; margin-right: 10px;">

                            <form id="filter-form" action="{{ route('product.index') }}" method="GET" style="display:inline;">
                                <select name="category" style="padding: 10px; width: 200px; margin-right: 10px;">
                                    <option value="">All Categories</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category }}" {{ request()->input('category') == $category ? 'selected' : '' }}>
                                        {{ $category }}
                                    </option>
                                    @endforeach
                                </select>
                                <input type="number" name="price_min" placeholder="Min Price" value="{{ request()->input('price_min') }}" style="padding: 10px; width: 100px; margin-right: 10px;">
                                <input type="number" name="price_max" placeholder="Max Price" value="{{ request()->input('price_max') }}" style="padding: 10px; width: 100px; margin-right: 10px;">
                                <input type="number" name="qty_min" placeholder="Min Quantity" value="{{ request()->input('qty_min') }}" style="padding: 10px; width: 100px; margin-right: 10px;">
                                <input type="number" name="qty_max" placeholder="Max Quantity" value="{{ request()->input('qty_max') }}" style="padding: 10px; width: 100px; margin-right: 10px;">

                                <select name="sort" style="padding: 10px; width: 200px; margin-right: 10px;">
                                    <option value="asc" {{ request()->input('sort') == 'asc' ? 'selected' : '' }}>Sort by Name (a-A-z-Z)</option>
                                    <option value="desc" {{ request()->input('sort') == 'desc' ? 'selected' : '' }}>Sort by Name (z-Z-a-A)</option>
                                </select>
                                <button type="submit" style="padding: 10px 20px; background-color: #3498db; color: #fff; border: none; border-radius: 5px; cursor: pointer;">
                                    Filter
                                </button>
                            </form>
                        </div>
                        <div id="product-container" class="product-container">
                            @foreach($products as $product)
                            <div class="product-card">
                                @if($product->image)
                                <img src="{{ asset('images/' . $product->image) }}" alt="Product Image">
                                @else
                                <img src="https://via.placeholder.com/250x150" alt="Default Image"> <!-- Default image if none provided -->
                                @endif
                                <h2>{{ $product->name }}</h2>
                                <p><strong>Quantity:</strong> {{ $product->qty }}</p>
                                <p><strong>Price:</strong> ${{ $product->price }}</p>
                                <p><strong>Description:</strong> {{ $product->description }}</p>
                                <p><strong>Category:</strong> {{ $product->category }}</p>
                                @if(auth()->user()->role == 'admin')
                                <div>
                                    <a class="action-btn update-btn" href="{{ route('product.update', ['product' => $product]) }}">Update</a>
                                    <form action="{{ route('product.delete', ['product'=> $product]) }}" method="post" style="display:inline;">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="action-btn delete-btn">Delete</button>
                                    </form>
                                </div>
                                @endif
                            </div>
                            @endforeach
                        </div>
                        <div class="button-container">
                            @if(auth()->user()->role == 'admin')
                            <a href="{{ route('product.create') }}" class="create-btn">Add Product</a>
                            @endif
                            <a href="{{ route('product.export') }}" class="create-btn">Download XL Report</a>
                        </div>
                    </div>
                    <script>
                        document.getElementById('search').addEventListener('input', function() {
                            const searchTerm = this.value.toLowerCase();

                            // Fetch the filtered products dynamically
                            fetch('{{ route('product.index') }}?search=' + searchTerm)
                        .then(response => response.text())
                                .then(html => {
                                    const parser = new DOMParser();
                                    const doc = parser.parseFromString(html, 'text/html');
                                    const newProductContainer = doc.getElementById('product-container');
                                    document.getElementById('product-container').innerHTML = newProductContainer.innerHTML;
                                });
                        });
                    </script>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
