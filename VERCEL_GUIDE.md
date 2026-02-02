# How to Deploy to Vercel (Advanced)

Vercel is built for static sites. Trying to host a PHP/MySQL XAMPP app on it is tricky because **Vercel does not host databases**.

You can host the *code* on Vercel, but you must find a separate place to host the *database* (MySQL) and connect them.

## Step 1: Get a Remote MySQL Database
Since Vercel has no database, you need to sign up for a remote MySQL service.
User-friendly options with free tiers (availability varies):
1. **TiDB Cloud** (Recommended for MySQL compatibility)
2. **Aiven** (Free MySQL plans available)
3. **Clever Cloud**

**Once you sign up for one:**
1. Create a database.
2. Note down the **Host**, **Port**, **Username**, **Password**, and **Database Name**.
3. Import your `database.sql` into this remote database (using a tool like basic Workbench or their web UI).

## Step 2: Push Your Code to GitHub
1. Create a GitHub account.
2. Create a new Repository (e.g., `kismath-app`).
3. Upload your project files to this repository.

## Step 3: Connect to Vercel
1. Go to [Vercel.com](https://vercel.com) and Sign Up.
2. Click **Add New > Project**.
3. Select your GitHub repository (`kismath-app`).
4. **IMPORTANT**: Configure Environment Variables.
   In the "Environment Variables" section, add the details from Step 1:
   
   - `DB_HOST` : (e.g., `gateway01.region.tidbcloud.com`)
   - `DB_USER` : (e.g., `2Ha7s9...`)
   - `DB_PASS` : (e.g., `secret_password`)
   - `DB_NAME` : (e.g., `kismath_db`)
   - `DB_PORT` : (e.g., `4000` or `3306`)

5. Click **Deploy**.

## Why this is hard
*   **No File Uploads**: On Vercel, your `assets/uploads` folder will be read-only. You cannot upload new product images from the Admin panel unless you connect an external storage service (like AWS S3 or Cloudinary).
*   **Stateless**: PHP sessions might reset occasionally since Vercel is serverless.

## Recommendation
If the above sounds too complicated, stick to **InfinityFree** (from the previous guide). It works exactly like your XAMPP setup (Local Storage + Local Database).
