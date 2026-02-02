# How to Host Your Website Online for Free (InfinityFree)

Since your project uses PHP and MySQL, **InfinityFree** is the best free hosting option. It works almost exactly like your local XAMPP server.

## Step 1: Prepare Your Files
1. Open your project folder: `c:\Users\VICTUS\Desktop\my pproject\xamp\htdocs\kismath`
2. Select **all files and folders** inside this directory (admin, assets, includes, index.php, etc.).
3. Right-click and choose **Send to > Compressed (zipped) folder**.
4. Name it `website.zip`.

## Step 2: Export Your Database
1. Go to **http://localhost/phpmyadmin** on your computer.
2. Click on your database `kismath_db`.
3. Click the **Export** tab at the top.
4. Click **Export** button to download the `.sql` file (e.g., `kismath_db.sql`).
   * *Note: You technically already have a `database.sql` file in your project, but exporting ensures you save any new products/orders you created.*

## Step 3: Create a Free Account
1. Go to [InfinityFree.com](https://www.infinityfree.com/).
2. Sign up for a free account.
3. Click **"Create Account"**.
4. Choose a **Subdomain** (e.g., `kismath-foods.infinityfreeapp.com`) and check availability.
5. Finish the setup.

## Step 4: Upload Your Website
1. In the InfinityFree dashboard, click **"File Manager"** (or "Online File Manager").
2. Open the **`htdocs`** folder.
3. Delete files named `index2.html` or `default.php` if they exist.
4. Click the **Upload** icon -> **Upload Zip**.
5. Select your `website.zip` file.
6. Once uploaded, right-click the zip and choose **Extract**.
7. Ensure all your files (`index.php`, `assets`, etc.) are directly inside `htdocs` (not inside a subfolder).

## Step 5: Setup the Database
1. Go back to the InfinityFree **Control Panel** (cPanel).
2. Click on **"MySQL Databases"**.
3. Create a new database name (e.g., `kismath`).
   * *Note detailed info will appear: Database Name, Username, Password, Hostname.*
4. Click on **"phpMyAdmin"** (usually a button next to the database you just created).
5. In phpMyAdmin, go to the **Import** tab.
6. Upload your `kismath_db.sql` (or the `database.sql` from your project).
7. Click **Go** to import.

## Step 6: Connect PHP to Online Database
1. Go back to the **File Manager**.
2. Open `includes/db_connect.php`.
3. Edit the file to match your **InfinityFree Database Details** (found in Step 5.3).

**Change this:**
```php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'kismath_db';
```

**To something like this (example):**
```php
$host = 'sql123.infinityfree.com'; // Found in Control Panel
$username = 'if0_3456789';         // Found in Control Panel
$password = 'YourPanelPassword';   // Found in Client Area
$database = 'if0_3456789_kismath'; // Found in Control Panel
```
4. **Save** the file.

## Step 7: Done!
Visit your website URL (e.g., `kismath-foods.infinityfreeapp.com`). It should be live!

---
**Tips:**
* If you see errors, check `includes/db_connect.php` credentials again.
* Free hosting is great for testing but might be slow.
