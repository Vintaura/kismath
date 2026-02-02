<?php
include 'includes/db_connect.php';

// 1. Create Banners Table
$sql_banners_table = "CREATE TABLE IF NOT EXISTS banners (
    id INT PRIMARY KEY AUTO_INCREMENT,
    image VARCHAR(255) NOT NULL,
    title VARCHAR(100),
    subtitle VARCHAR(200),
    link VARCHAR(255),
    active TINYINT DEFAULT 1
)";

if ($conn->query($sql_banners_table) === TRUE) {
    echo "Banners table created successfully.<br>";
} else {
    echo "Error creating banners table: " . $conn->error . "<br>";
}

// 2. Clear existing sample data to avoid duplicates (optional, based on logic)
$conn->query("TRUNCATE TABLE banners"); 
// Note: We won't truncate products to avoid deleting user data if they added any, 
// but for a clean 'add sample' script, we'll check existence or just insert.
// To be safe, let's just insert specific items.

// 3. Insert Sample Banners
// Using PLACEHOLD.CO with specific colors/text for visual distinction
$banners = [
    [
        'image' => 'https://placehold.co/1920x600/D32F2F/FFF?text=Authentic+Homemade+Pickles&font=playfair-display',
        'title' => 'Authentic Homemade Pickles',
        'subtitle' => 'Made with traditional recipes passed down through generations',
        'link' => 'shop.php?category=Pickles'
    ],
    [
        'image' => 'https://placehold.co/1920x600/FBC02D/3E2723?text=Pure+%26+Fresh+Spices&font=playfair-display',
        'title' => 'Premium Spice Powders',
        'subtitle' => 'Farm fresh spices ground to perfection',
        'link' => 'shop.php?category=Spice Powders'
    ],
    [
        'image' => 'https://placehold.co/1920x600/388E3C/FFF?text=Mega+Combo+Offers&font=playfair-display',
        'title' => 'Taste of Kerala Combo',
        'subtitle' => 'Get the best of everything in one pack',
        'link' => 'shop.php?category=Combos'
    ]
];

foreach ($banners as $b) {
    $img = $b['image'];
    $title = $b['title'];
    $sub = $b['subtitle'];
    $lnk = $b['link'];
    $sql = "INSERT INTO banners (image, title, subtitle, link) VALUES ('$img', '$title', '$sub', '$lnk')";
    $conn->query($sql);
}
echo "Sample banners added.<br>";

// 4. Insert Sample Products
// We need to get Category IDs first
$cats = [];
$res = $conn->query("SELECT id, name FROM categories");
while($row = $res->fetch_assoc()) {
    $cats[$row['name']] = $row['id'];
}

$sample_products = [
    // Pickles
    [
        'name' => 'Cut Mango Pickle',
        'cat' => 'Pickles',
        'price' => 120.00,
        'image' => 'https://placehold.co/600x600/D32F2F/FFF?text=Mango+Pickle',
        'desc' => 'Traditional Kerala style cut mango pickle made with gingelly oil.',
        'ing' => 'Raw Mango, Red Chili Powder, Turmeric, Gingelly Oil, Mustard Seeds, Salt',
        'weight' => '250g, 500g, 1kg'
    ],
    [
        'name' => 'Garlic Pickle',
        'cat' => 'Pickles',
        'price' => 140.00,
        'image' => 'https://placehold.co/600x600/8D6E63/FFF?text=Garlic+Pickle',
        'desc' => 'Spicy and tangy garlic pickle, perfect for rice and roti.',
        'ing' => 'Garlic, Vinegar, Red Chili, Spices, Oil',
        'weight' => '200g, 400g'
    ],
    [
        'name' => 'Vadu Mango (Tender Mango)',
        'cat' => 'Pickles',
        'price' => 180.00,
        'image' => 'https://placehold.co/600x600/388E3C/FFF?text=Vadu+Mango',
        'desc' => 'Whole tender mangoes soaked in brine and spices. A rare delicacy.',
        'ing' => 'Tender Mango, Salt, Chili, Mustard',
        'weight' => '300g, 500g'
    ],
    // Spices
    [
        'name' => 'Kashmiri Chili Powder',
        'cat' => 'Spice Powders',
        'price' => 90.00,
        'image' => 'https://placehold.co/600x600/B71C1C/FFF?text=Chili+Powder',
        'desc' => 'Vibrant red color with moderate heat. 100% stalkless.',
        'ing' => 'Dried Kashmiri Chilies',
        'weight' => '100g, 250g, 500g'
    ],
    [
        'name' => 'Wayanad Turmeric Powder',
        'cat' => 'Spice Powders',
        'price' => 80.00,
        'image' => 'https://placehold.co/600x600/FBC02D/000?text=Turmeric',
        'desc' => 'High curcumin content turmeric powder from Wayanad.',
        'ing' => 'Turmeric Root',
        'weight' => '100g, 250g'
    ],
    // Masalas
    [
        'name' => 'Kerala Chicken Masala',
        'cat' => 'Masalas',
        'price' => 65.00,
        'image' => 'https://placehold.co/600x600/795548/FFF?text=Chicken+Masala',
        'desc' => 'Authentic blend for perfect Kerala Chicken Curry.',
        'ing' => 'Coriander, Chili, Turmeric, Pepper, Fennel, Cardamom',
        'weight' => '100g, 200g'
    ],
    [
        'name' => 'Sambar Powder',
        'cat' => 'Masalas',
        'price' => 55.00,
        'image' => 'https://placehold.co/600x600/E65100/FFF?text=Sambar+Powder',
        'desc' => 'Aromatic blend for delicious hotel-style sambar.',
        'ing' => 'Coriander, Chana Dal, Fenugreek, Red Chili, Asafetida',
        'weight' => '100g, 200g'
    ],
    // Combos
    [
        'name' => 'Bachelor Survival Kit',
        'cat' => 'Combos',
        'price' => 350.00,
        'image' => 'https://placehold.co/600x600/455A64/FFF?text=Combo+Pack',
        'desc' => 'Includes: 200g Mango Pickle, 100g Chicken Masala, 100g Chili Powder.',
        'ing' => 'Various',
        'weight' => 'Standard Pack'
    ]
];

foreach ($sample_products as $p) {
    if (isset($cats[$p['cat']])) {
        $cat_id = $cats[$p['cat']];
        $name = $p['name'];
        $desc = $conn->real_escape_string($p['desc']);
        $ing = $conn->real_escape_string($p['ing']);
        $price = $p['price'];
        $img = $p['image']; // We are saving URL directly since we can't upload files easily via script. 
                            // Note: The system assumes 'assets/uploads/' prefix usuall, but we will hack it.
                            // We will handle the prefix logic in the display code or save it in a way that works.
                            // Current display logic: !empty($row['image']) ? 'assets/uploads/'.$row['image']
                            // We need to bypass this for external URLs. 
                            // *Modification needed in index.php/shop.php* to check if it starts with http.
        
        $w = $p['weight'];
        
        $sql = "INSERT INTO products (category_id, name, description, ingredients, price, weight_options, stock, image) 
                VALUES ('$cat_id', '$name', '$desc', '$ing', '$price', '$w', 100, '$img')";
        
        if ($conn->query($sql)) {
            echo "Added: $name<br>";
        } else {
            echo "Failed: $name - " . $conn->error . "<br>";
        }
    }
}

echo "<br><b>Sample data setup complete!</b> <a href='index.php'>Go to Home</a>";
?>
