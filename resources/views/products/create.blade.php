<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>Create a Product</title>
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
        input[type="file"] {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .category-section {
            margin-bottom: 15px;
        }
        .category-section input[type="text"] {
            display: inline-block;
            width: calc(100% - 120px);
        }
        .category-section button {
            display: inline-block;
            width: 100px;
            padding: 10px;
            border: none;
            border-radius: 4px;
            background-color: #3498db;
            color: white;
            cursor: pointer;
        }
        .category-section button:hover {
            background-color: #2980b9;
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
        .cross-icon {
            position: absolute;
            top: 5px;
            right: 5px;
            background-color: white;
            border: 1px solid #ccc;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }
        .cross-icon::before {
            content: "×";
            font-size: 16px;
            color: #e74c3c;
        }
    </style>
</head>
<body>

@if(session('success'))
<script>
    alert('{{ session('success') }}');
</script>
@endif

<form id="product-form" method="post" action="{{ route('product.store') }}" enctype="multipart/form-data">
    @csrf
    <h1>Create A Product</h1>

    <div>
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Enter product name" required />
    </div>

    <div>
        <label for="qty">Quantity</label>
        <input type="text" id="qty" name="qty" placeholder="Enter quantity" required />
    </div>

    <div>
        <label for="price">Price</label>
        <input type="text" id="price" name="price" placeholder="Enter price" required />
    </div>

    <div>
        <label for="description">Description</label>
        <input type="text" id="description" name="description" placeholder="Enter description" />
    </div>

    <div>
        <label for="category">Category</label>
        <select id="category" name="category">
            @foreach($categories as $category)
            <option value="{{ $category }}">{{ $category }}</option>
            @endforeach
        </select>
    </div>
    <div class="category-section">
        <input type="text" id="new_category" name="new_category" placeholder="Enter new category" />
        <button type="button" id="add-category">Add Category</button>
    </div>

    <div>
        <label for="image">Image</label>
        <input type="file" id="image" name="image" />
        <div class="image-preview-container">
            <img id="image-preview" src="#" alt="Image Preview" style="display: none;" />
            <div class="cross-icon" id="remove-image" style="display: none;"></div>
        </div>
    </div>

    <div>
        <input type="submit" value="Save" />
    </div>
</form>

<script>
    document.getElementById('add-category').addEventListener('click', function() {
        var newCategory = document.getElementById('new_category').value;
        if (!newCategory) {
            alert('Please enter a category name.');
            return;
        }

        fetch('{{ route('category.store') }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ name: newCategory })
        })
    .then(response => response.json())
            .then(data => {
                if (data.success) {
                    var select = document.getElementById('category');
                    var option = document.createElement('option');
                    option.value = newCategory;
                    option.text = newCategory;
                    select.add(option);
                    document.getElementById('new_category').value = '';
                    alert('Category added successfully.');
                } else {
                    alert('Failed to add category.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('An error occurred.');
            });
    });

    document.getElementById('image').addEventListener('change', function(event) {
        var file = event.target.files[0];
        if (file) {
            var reader = new FileReader();
            reader.onload = function(e) {
                var img = document.getElementById('image-preview');
                var crossIcon = document.getElementById('remove-image');
                img.src = e.target.result;
                img.style.display = 'block';
                crossIcon.style.display = 'block';
            }
            reader.readAsDataURL(file);
        }
    });

    document.getElementById('remove-image').addEventListener('click', function() {
        var img = document.getElementById('image-preview');
        var input = document.getElementById('image');
        img.style.display = 'none';
        this.style.display = 'none';
        input.value = ''; // Clear the file input
    });
</script>

</body>
</html>
