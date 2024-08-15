<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Update Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        form {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 300px;
        }
        div {
            margin-bottom: 15px;
        }
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        input[type="text"], select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 10px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
        .image-preview-container {
            position: relative;
        }
        #image-preview {
            display: block;
            margin-top: 10px;
            max-width: 100%;
            max-height: 200px;
            object-fit: cover;
        }
        .remove-image {
            position: absolute;
            top: 10px;
            right: 10px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 50%;
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            font-size: 14px;
            color: #e74c3c;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
    </style>
</head>
<body>
<form method="post" action="{{ route('product.update1', ['product' => $product]) }}" enctype="multipart/form-data">
    @csrf
    @method('put')
    <h1>Update Product</h1>
    <div>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Enter product name" value="{{ $product->name }}" />
    </div>
    <div>
        <label for="qty">Quantity</label>
        <input type="text" id="qty" name="qty" placeholder="Enter quantity" value="{{ $product->qty }}"/>
    </div>
    <div>
        <label for="price">Price</label>
        <input type="text" id="price" name="price" placeholder="Enter price" value="{{ $product->price }}"/>
    </div>
    <div>
        <label for="description">Description</label>
        <input type="text" id="description" name="description" placeholder="Enter description" value="{{ $product->description }}"/>
    </div>
    <div>
        <label for="category">Category</label>
        <select id="category" name="category">
            @foreach($categories as $category)
            <option value="{{ $category }}" {{ $product->category == $category ? 'selected' : '' }}>
                {{ $category }}
            </option>
            @endforeach
        </select>
    </div>
    <div>
        <label for="image">Image</label>
        <input type="file" id="image" name="image"/>
        @if($product->image)
        <div class="image-preview-container">
            <img id="image-preview" src="{{ asset('images/' . $product->image) }}"  alt="Product Image">
            <div class="remove-image" id="remove-image">×</div>
        </div>
        @endif
    </div>
    <div>
        <input type="submit" value="Update"/>
    </div>
</form>

<script>
    document.getElementById('image').addEventListener('change', function(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.getElementById('image-preview');
                var removeIcon = document.getElementById('remove-image');
                img.src = e.target.result;
                img.style.display = 'block';
                removeIcon.style.display = 'flex';
            }
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('remove-image').addEventListener('click', function() {
        var img = document.getElementById('image-preview');
        var fileInput = document.getElementById('image');
        img.style.display = 'none';
        this.style.display = 'none';
        fileInput.value = ''; // Clear the file input
    });
</script>

</body>
</html>
